<?php

namespace Modules\Products\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductGroup extends Model
{
    use HasFactory;

    protected $table = 'product_group';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'sku_group',
        'description',
        'price'
    ];

    // Tentukan hubungan dengan model 'Product'
    public function products()
    {
        return $this->hasMany(Product::class, 'product_group_id');
    }



}
