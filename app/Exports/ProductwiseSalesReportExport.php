<?php 
namespace App\Exports;
 
use App\Models\Orders;
use App\Models\OrderItems;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
class ProductwiseSalesReportExport implements FromView,ShouldAutoSize,WithHeadings
{
     
    public function __construct($data) {
    $this->data = $data;
    }
      public function headings():array{
        return[
            'order no',
            'Name',
            'Email',
            'phone',
            'address',
            'date',
            'amount',
            'reference',
            'status',
            'delivery status',
            'payment method'
             
        ];
    }

    public function view(): View
    {
    
         return view('admin.sales-report.productwise-salesreport',[
            'order_data'=>$this->data,
            ]);

        
    }
   


  
}