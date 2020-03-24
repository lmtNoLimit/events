<?php

use Illuminate\Database\Seeder;
use App\Organizer;

class OrganizersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Organizer::where('slug', 'demo1')->update([
            'password_hash' => Hash::make('demopass1')
        ]);
        Organizer::where('slug', 'demo2')->update([
            'password_hash' => Hash::make('demopass2')
        ]);
    }
}
