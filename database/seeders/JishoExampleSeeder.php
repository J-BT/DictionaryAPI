<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JishoExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("jisho_histories")->truncate(); 


        $searchResultsExample = array(
            'space' => '宇宙',
            'dream' => '夢',
            'travel' => '旅行',
            'run' => '走る',
            'video game' => 'ビデオゲーム'

        );

        foreach($searchResultsExample as $s => $r){

            $jisho_histories[] = [
                'category' => 'enjp',
                'languageFrom' => 'english',
                'languageTo' => 'japanese',
                'search' => $s,
                'result' => $r,
            ];
        }

        DB::table('jisho_histories')->insert($jisho_histories);
    }
}
