<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
class Invoice extends Model
{
	use SoftDeletes;
    use HasFactory;
	protected $table='invoice';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	public static function boot()
	{
		parent::boot();
		self::creating(function ($model) {
			$model->invoice_no = IdGenerator::generate(['table' => 'invoice','field'=>'invoice_no', 'length' =>10, 'prefix' =>'INV'.date('ym')]);
		});
	}
	public function invoiceItems()
	{
		 return $this->hasMany(InvoiceItems::class,'invoice_id','id');
	}
	public function customers()
    {
        return $this->belongsTo(Customer::class,'customer_id','user_id');
    }
    public function customerAddress()
    {
        return $this->belongsTo(Address::class,'customer_id','customer_id');
    }
}


