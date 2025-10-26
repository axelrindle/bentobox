<?php

namespace Database\Seeders;

use App\Models\Place;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Laravel\Prompts\confirm;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->withoutTwoFactor()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123',
        ]);

        Place::factory()
            ->hasWarehouses(2)
            ->create();
    }

    private function ask(string $class, array $parameters = []): void
    {
        $name = str($class)->afterLast('\\');

        if (app()->runningUnitTests() || confirm("Run {$name} ?", true)) {
            $this->call($class, parameters: $parameters);
        }
    }
}
