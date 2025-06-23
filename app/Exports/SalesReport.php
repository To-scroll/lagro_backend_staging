<?php 
namespace App\Exports;
 
use App\Models\Orders;
use App\Models\OrderItems;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
class SalesReport implements FromView,ShouldAutoSize,WithEvents
{
    
    public function __construct($data) {
    $this->data = $data;
    }

    public function view(): View
    {
    
         return view('admin.sales-report.report',[
            'order_data'=>$this->data,
            ]);

        
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A14:H14'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                
            },
        ];
    }
}