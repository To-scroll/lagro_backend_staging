<?php 
namespace App\Exports;
 
use App\Models\Orders;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
 use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class salesReport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */ 
    // public function headings():array{
    //     return[
    //         'Id',
    //         'Name',
    //         'Email',
    //         'City',
    //         'Created_at',
    //         'Updated_at' 
    //     ];
    // } 
    // public function collection()
    // {
    //     return Orders::all();
    // }
    public function __construct($data) {
    $this->data = $data;
    }

    public function view(): View
    {
        
         return view('admin.sales-report.report',[
            'stk'=>$this->data ]);

        
    }
}