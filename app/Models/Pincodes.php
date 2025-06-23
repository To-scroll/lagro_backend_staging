<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pincodes extends Model
{
    protected $guarded = [];
    use HasFactory;
    protected $table="pincodes";
    public $timestamps=false;
}
