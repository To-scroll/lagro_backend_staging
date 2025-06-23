<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    use HasFactory;
	protected $table='invoice_items';
	public $timestamps = false;

	public function productItems()
	{
		 return $this->belongsTo(Product::class,'product_id','id');
	}

}
