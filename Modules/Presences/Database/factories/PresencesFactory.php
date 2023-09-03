<?php
namespace Modules\Presences\Database\factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PresencesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Presences\Entities\Presences::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['in', 'out']),
            'datetime' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }
}

