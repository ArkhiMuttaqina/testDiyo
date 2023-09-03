<?php

namespace Modules\Sales\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesCart extends Model
{
    use HasFactory;

    protected $table = 'sales_cart';
    protected $primaryKey = 'id';

    protected $fillable = [
        'sales_id',
        'item_id',
        'price',
        'qty',
    ];


    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id');
    }


}
