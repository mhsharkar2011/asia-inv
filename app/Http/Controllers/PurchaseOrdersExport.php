<?php

namespace App\Exports;

use App\Models\PurchaseOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PurchaseOrdersExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = PurchaseOrder::with(['supplier', 'warehouse', 'company']);

        // Apply filters
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['search'])) {
            $query->where('po_number', 'like', '%' . $this->filters['search'] . '%')
                  ->orWhereHas('supplier', function($q) use ($filters) {
                      $q->where('name', 'like', '%' . $filters['search'] . '%');
                  });
        }

        if (!empty($this->filters['start_date'])) {
            $query->where('order_date', '>=', $this->filters['start_date']);
        }

        if (!empty($this->filters['end_date'])) {
            $query->where('order_date', '<=', $this->filters['end_date']);
        }

        return $query->orderBy('order_date', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'PO Number',
            'Supplier',
            'Warehouse',
            'Company',
            'Order Date',
            'Delivery Date',
            'Status',
            'Amount',
            'Tax Amount',
            'Discount',
            'Final Amount',
            'Created At',
        ];
    }

    public function map($po): array
    {
        return [
            $po->po_number,
            $po->supplier->name ?? 'N/A',
            $po->warehouse->name ?? 'N/A',
            $po->company->name ?? 'N/A',
            $po->order_date->format('Y-m-d'),
            $po->expected_delivery_date ? $po->expected_delivery_date->format('Y-m-d') : 'N/A',
            ucfirst($po->status),
            $po->amount,
            $po->tax_amount,
            $po->discount,
            $po->final_amount,
            $po->created_at->format('Y-m-d H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
        ];
    }
}
