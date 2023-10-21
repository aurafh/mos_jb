<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'purchase_id',
        'inventory_id',
        'qty',
        'price'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchases::class, 'purchase_id');
    }
    
    public function inventory()
    {
        return $this->belongsTo(Inventories::class, 'inventory_id');
    }
}
