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
        Organizer::create([
            'name' => 'Organizerdemo3',
            'slug' => 'demo3',
            'email'=> 'demo3@hanoiskills.org',
            'password_hash' => Hash::make('123456')
        ]);
        // DB::table('organizers')->get();
    }
}
