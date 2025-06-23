<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Cms extends Model
{
	use SoftDeletes;
    protected $table='cms';
    public $timestamps=true;
    protected $dates=['deleted_at'];
}
