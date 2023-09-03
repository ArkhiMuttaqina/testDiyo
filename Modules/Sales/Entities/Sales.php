<?php

namespace Modules\Sales\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
