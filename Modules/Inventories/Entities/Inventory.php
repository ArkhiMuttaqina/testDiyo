<?php

namespace Modules\Inventories\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'amount',
        'unit',
    ];

    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
