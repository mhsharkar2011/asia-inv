<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Admin\Organization;
use App\Models\Sales\Invoice;
use App\Models\Sales\Customer;
use App\Models\Sales\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Invoice::with('customer')->latest();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $invoices = $query->paginate(20);

        return view('sales.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $customers = Organization::where('type', 'customer')->orderBy('name')->get();
        $invoice_number = Invoice::generateInvoiceNumber();

        // Pre-select customer if coming from customer page
        $selected_customer_id = $request->customer_id;

        return view('sales.invoices.create', compact('customers', 'invoice_number', 'selected_customer_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate basic invoice data
            $validated = $request->validate([
                'customer_id' => 'required|exists:organizations,id',
                'invoice_date' => 'required|date',
                'due_date' => 'required|date|after_or_equal:invoice_date',
                'notes' => 'nullable|string',
                'terms' => 'nullable|string',
                'subtotal' => 'required|numeric|min:0',
                'tax_amount' => 'required|numeric|min:0',
                'total_amount' => 'required|numeric|min:0',
                'items' => 'required|array|min:1',
                'items.*.description' => 'required|string',
                'items.*.quantity' => 'required|numeric|min:0.01',
                'items.*.unit_price' => 'required|numeric|min:0',
            ]);

            Log::info('Validated data:', $validated);

            DB::beginTransaction();

            // Get the invoice number from the form
            $invoiceNumber = $request->input('invoice_number', Invoice::generateInvoiceNumber());

            // Create invoice
            $invoice = Invoice::create([
                'company_id' => Auth::user()->company_id ?? 1, // Adjust based on your auth system
                'customer_id' => $validated['customer_id'],
                'invoice_number' => $invoiceNumber,
                'invoice_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'],
                'subtotal' => $validated['subtotal'],
                'tax_amount' => $validated['tax_amount'],
                'total_amount' => $validated['total_amount'],
                'amount_paid' => 0,
                'balance_due' => $validated['total_amount'],
                'notes' => $validated['notes'] ?? null,
                'terms' => $validated['terms'] ?? null,
                'status' => $request->input('action') === 'save_send' ? 'sent' : 'draft',
            ]);

            Log::info('Invoice created:', $invoice->toArray());

            // Create invoice items
            foreach ($validated['items'] as $index => $itemData) {
                $item = new InvoiceItem([
                    'invoice_id' => $invoice->id,
                    'description' => $itemData['description'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total' => $itemData['quantity'] * $itemData['unit_price'],
                    'tax_rate' => 18, // Default 18% GST
                    'tax_amount' => ($itemData['quantity'] * $itemData['unit_price']) * 0.18,
                ]);

                $item->save();
                Log::info("Item {$index} created:", $item->toArray());
            }

            DB::commit();

            // Check action type for redirect
            if ($request->input('action') === 'save_print') {
                return redirect()->route('sales.invoices.print', $invoice->id)
                    ->with('success', 'Invoice created successfully. Ready to print.');
            }

            return redirect()->route('sales.invoices.show', $invoice->id)
                ->with('success', 'Invoice created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating invoice: ' . $e->getMessage());
            Log::error('Exception trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Error creating invoice: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'items']);
        return view('sales.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        if ($invoice->status !== 'draft') {
            return redirect()->route('sales.invoices.show', $invoice->id)
                ->with('error', 'Only draft invoices can be edited.');
        }

        $invoice->load('items');
        $customers = Organization::where('type', 'customer')->orderBy('name')->get();

        return view('sales.invoices.edit', compact('invoice', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        if ($invoice->status !== 'draft') {
            return redirect()->route('sales.invoices.show', $invoice->id)
                ->with('error', 'Only draft invoices can be edited.');
        }

        try {
            $validated = $request->validate([
                'customer_id' => 'required|exists:organizations,id',
                'invoice_date' => 'required|date',
                'due_date' => 'required|date|after_or_equal:invoice_date',
                'notes' => 'nullable|string',
                'terms' => 'nullable|string',
                'subtotal' => 'required|numeric|min:0',
                'tax_amount' => 'required|numeric|min:0',
                'total_amount' => 'required|numeric|min:0',
                'items' => 'required|array|min:1',
                'items.*.id' => 'nullable|exists:invoice_items,id',
                'items.*.description' => 'required|string',
                'items.*.quantity' => 'required|numeric|min:0.01',
                'items.*.unit_price' => 'required|numeric|min:0',
            ]);

            DB::beginTransaction();

            // Update invoice details
            $invoice->update([
                'customer_id' => $validated['customer_id'],
                'invoice_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'],
                'subtotal' => $validated['subtotal'],
                'tax_amount' => $validated['tax_amount'],
                'total_amount' => $validated['total_amount'],
                'balance_due' => $validated['total_amount'] - $invoice->amount_paid,
                'notes' => $validated['notes'] ?? null,
                'terms' => $validated['terms'] ?? null,
                'status' => $request->input('action') === 'save_send' ? 'sent' : 'draft',
            ]);

            // Update or create items
            $existingItemIds = $invoice->items->pluck('id')->toArray();
            $updatedItemIds = [];

            foreach ($validated['items'] as $itemData) {
                if (isset($itemData['id']) && in_array($itemData['id'], $existingItemIds)) {
                    // Update existing item
                    $item = InvoiceItem::find($itemData['id']);
                    $item->update([
                        'description' => $itemData['description'],
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'total' => $itemData['quantity'] * $itemData['unit_price'],
                        'tax_amount' => ($itemData['quantity'] * $itemData['unit_price']) * 0.18,
                    ]);
                    $updatedItemIds[] = $itemData['id'];
                } else {
                    // Create new item
                    $item = new InvoiceItem([
                        'invoice_id' => $invoice->id,
                        'description' => $itemData['description'],
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'total' => $itemData['quantity'] * $itemData['unit_price'],
                        'tax_rate' => 18,
                        'tax_amount' => ($itemData['quantity'] * $itemData['unit_price']) * 0.18,
                    ]);
                    $item->save();
                }
            }

            // Delete removed items
            $itemsToDelete = array_diff($existingItemIds, $updatedItemIds);
            if (!empty($itemsToDelete)) {
                InvoiceItem::whereIn('id', $itemsToDelete)->delete();
            }

            DB::commit();

            // Check action type for redirect
            if ($request->input('action') === 'save_print') {
                return redirect()->route('sales.invoices.print', $invoice->id)
                    ->with('success', 'Invoice updated successfully. Ready to print.');
            }

            return redirect()->route('sales.invoices.show', $invoice->id)
                ->with('success', 'Invoice updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating invoice: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error updating invoice: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        if ($invoice->status !== 'draft') {
            return redirect()->route('sales.invoices.show', $invoice->id)
                ->with('error', 'Only draft invoices can be deleted.');
        }

        $invoice->delete();

        return redirect()->route('sales.invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    /**
     * Download invoice as PDF.
     */
    public function download(Invoice $invoice)
    {
        // This would generate a PDF
        // For now, redirect to print view
        return redirect()->route('sales.invoices.print', $invoice);
    }

    /**
     * Send invoice via email.
     */
    public function send(Invoice $invoice)
    {
        $invoice->update(['status' => 'sent']);

        return redirect()->back()
            ->with('success', 'Invoice sent successfully.');
    }

    /**
     * Record payment for invoice.
     */
    public function recordPayment(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $invoice->balance_due,
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'reference' => 'nullable|string',
        ]);

        $invoice->increment('amount_paid', $validated['amount']);
        $invoice->decrement('balance_due', $validated['amount']);

        if ($invoice->balance_due <= 0) {
            $invoice->update(['status' => 'paid']);
        }

        // Create payment record if you have a payments table
        // Payment::create([...]);

        return redirect()->back()
            ->with('success', 'Payment recorded successfully.');
    }

    /**
     * Print invoice view.
     */
    public function print($id)
    {
        try {
            $invoice = Invoice::with(['customer', 'items'])->findOrFail($id);

            // Get company information
            $company = Organization::where('type', 'company')->first();

            if (!$company) {
                // Create a default company object
                $company = (object)[
                    'name' => config('app.name', 'Your Company'),
                    'logo' => null,
                    'address_line1' => '123 Business Street',
                    'address_line2' => '',
                    'city' => 'City',
                    'state' => 'State',
                    'pincode' => '12345',
                    'phone' => '(123) 456-7890',
                    'email' => 'billing@company.com',
                    'gstin' => '22AAAAA0000A1Z5',
                ];
            }

            return view('sales.invoices.print', compact('invoice', 'company'));
        } catch (\Exception $e) {
            Log::error('Error loading invoice for print: ' . $e->getMessage());
            return redirect()->route('sales.invoices.index')
                ->with('error', 'Invoice not found or error loading for print');
        }
    }
}
