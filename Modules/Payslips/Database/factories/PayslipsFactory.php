<?php
namespace Modules\Payslips\Database\factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayslipsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Payslips\Entities\Payslips::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'month' => $this->faker->date('Y-m', 'now'),
            'basic_salary' => 2000000,
            'performance_allowance' => $this->faker->numberBetween(0, 500000),
            'late_penalty' => $this->faker->numberBetween(0, 500000),
            'take_home_pay' => $this->faker->numberBetween(1500000, 2500000),
        ];
    }
}

