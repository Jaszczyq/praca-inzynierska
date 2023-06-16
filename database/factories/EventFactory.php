<?php

namespace Database\Factories;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('+1 week', '+1 year');
        $time = Carbon::instance($date)->format('H:i');

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'place' => $this->faker->address,
            'date' => $date,
            'time' => $time,
            'image' => $this->faker->imageUrl(),
        ];
    }
}

