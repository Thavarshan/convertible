<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Conversion;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Conversion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => Str::ucfirst($this->faker->word()),
            'job_id' => null,
            'audio_file_name' => $this->faker->word(),
            'status' => 'pending',
            'audio_file_path' => '',
            'download_path' => '',
            'user_id' => create(User::class)->id,
        ];
    }
}
