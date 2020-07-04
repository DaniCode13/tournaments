<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypePollsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!App\Models\TypePoll::find(1)){
            DB::table('type_polls')->insert([
                'id' => '1',
                'type' => 'IP'
            ]);
            DB::table('type_polls')->insert([
                'id' => '2',
                'type' => 'Cookie'
            ]);
            DB::table('type_polls')->insert([
                'id' => '3',
                'type' => 'Nothing'
            ]);
        }


    }
}
