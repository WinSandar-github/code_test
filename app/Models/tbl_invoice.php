<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_invoice extends Model
{
    use HasFactory;
    protected $fillable=['table_no','receipt_no','sub_total','tax','total'];

    public function item()
  {
      return $this->hasMany(tbl_item::class,'invoice_id');
  }
}
