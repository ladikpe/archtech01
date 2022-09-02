<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(AssignCompanySeeder::class);
//        $this->call(NotificationTypeSeeder::class);
        $this->call(RankAndCadreSeeder::class);
//        $this->call(PollSeeder::class);
    }
}
