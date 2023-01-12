<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

/**
 * Класс-сидер для быстрого заполнения БД данными-заглушками
 *
 * Class PostSeeder
 *
 * @package Database\Seeders
 */
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory()
            ->count(50)
            ->create();
    }
}
