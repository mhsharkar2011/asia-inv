<?php

namespace App\Http\Controllers;

use App\Models\Inventory\Company;
use App\Models\Sales\Invoice;
use App\Models\Sales\Customer;
use App\Models\sales\InvoiceItem;
use Illuminate\Http\Request;
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
        $customers = Customer::where('is_active', '1')->orderBy('customer_name')->get();
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
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Create invoice
            $invoice = Invoice::create([
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'customer_id' => $validated['customer_id'],
                'invoice_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'],
                'notes' => $validated['notes'] ?? null,
                'terms' => $validated['terms'] ?? null,
                'status' => 'draft',
            ]);

            // Create invoice items
            $subtotal = 0;
            foreach ($validated['items'] as $itemData) {
                $item = new InvoiceItem([
                    'description' => $itemData['description'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total' => $itemData['quantity'] * $itemData['unit_price'],
                ]);

                $invoice->items()->save($item);
                $subtotal += $item->total;
            }

            // Calculate totals
            $invoice->calculateTotals();

            DB::commit();

            return redirect()->route('sales.invoices.show', $invoice->id)
                ->with('success', 'Invoice created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
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
        $customers = Customer::where('status', 'active')->orderBy('name')->get();

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

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|exists:invoice_items,id',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Update invoice details
            $invoice->update([
                'customer_id' => $validated['customer_id'],
                'invoice_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'],
                'notes' => $validated['notes'] ?? null,
                'terms' => $validated['terms'] ?? null,
            ]);

            // Update or create items
            $existingItemIds = $invoice->items->pluck('id')->toArray();
            $updatedItemIds = [];

            foreach ($validated['items'] as $itemData) {
                if (isset($itemData['id'])) {
                    // Update existing item
                    $item = InvoiceItem::find($itemData['id']);
                    $item->update([
                        'description' => $itemData['description'],
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'total' => $itemData['quantity'] * $itemData['unit_price'],
                    ]);
                    $updatedItemIds[] = $itemData['id'];
                } else {
                    // Create new item
                    $item = new InvoiceItem([
                        'description' => $itemData['description'],
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'total' => $itemData['quantity'] * $itemData['unit_price'],
                    ]);
                    $invoice->items()->save($item);
                }
            }

            // Delete removed items
            $itemsToDelete = array_diff($existingItemIds, $updatedItemIds);
            if (!empty($itemsToDelete)) {
                InvoiceItem::whereIn('id', $itemsToDelete)->delete();
            }

            // Recalculate totals
            $invoice->calculateTotals();

            DB::commit();

            return redirect()->route('sales.invoices.show', $invoice->id)
                ->with('success', 'Invoice updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
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
        // Logic to send invoice via email
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

        return redirect()->back()
            ->with('success', 'Payment recorded successfully.');
    }

    /**
     * Print invoice view.
     */
    // public function print(Invoice $invoice)
    // {
    //     $invoice->load(['customer', 'items']);
    //     return view('sales.invoices.print', compact('invoice'));
    // }
    public function print($id)
    {
        try {
            $invoice = Invoice::with([
                'customer',
                'items.product',
                'createdBy'
            ])->findOrFail($id);

            // Get company information - make sure it's a single object
            $company = Company::first(); // Or however you get company info

            if (!$company) {
                // Create a default company object
                $company = (object)[
                    'name' => config('app.name', 'Your Company'),
                    'logo' => null,
                    'address' => '',
                    'phone' => '',
                    'email' => '',
                    'website' => '',
                    'tax_id' => '',
                    'registration_no' => '',
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
