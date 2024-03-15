<?php

namespace Database\Factories;

use App\Cryptos\Encryptors\ResumeEncryptor;
use App\Models\Resume;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\en_US\Address;

/**
 * @extends Factory<Resume>
 */
class ResumeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return app(ResumeEncryptor::class)->encrypt([
            'user_id' => fn() => User::factory(),
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'title' => $this->faker->word(),
            'city' => $this->faker->city(),
            'state' => Address::state(),
            'country' => 'United States',
            'profile' => $this->faker->url(),
            'linked_in_profile' => $this->faker->url(),
            'github_profile' => $this->faker->url(),
            'phone' => $this->faker->phoneNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
