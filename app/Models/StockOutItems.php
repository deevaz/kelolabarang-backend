<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOutItems extends Model
{
    use HasFactory;

    protected $table = 'stock_out_items';

    protected $fillable = [
        'stock_out_id',
        'item_id',
        'quantity',
        'created_at',
        'updated_at',
    ];

    public function stockOut()
    {
        return $this->belongsTo(StockOut::class, 'stock_out_id');
    }

}
