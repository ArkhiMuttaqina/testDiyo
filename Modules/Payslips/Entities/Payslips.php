<?php

namespace Modules\Payslips\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payslips extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'month',
        'basic_salary',
        'performance_allowance',
        'late_penalty',
        'take_home_pay',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function newFactory()
    {
        return \Modules\Payslips\Database\factories\PayslipsFactory::new();
    }
}
