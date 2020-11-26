<?php

namespace Database\Factories;

use App\Models\User;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Set user as UserType::Commom or UserType::ShopKeeper
        $userType = null;

        return [
            'name' => $this->faker->name,
            'user_type' => ($userType ?: $userType = rand(UserType::Commom, UserType::ShopKeeper)) ?: $userType,
            'document' => ($userType == UserType::Commom) ? $this->faker->unique()->cpf : $this->faker->unique()->cnpj,
            'email' => $this->faker->unique()->safeEmail,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ];
    }
}
