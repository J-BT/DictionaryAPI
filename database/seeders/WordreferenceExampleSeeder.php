<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WordreferenceExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("wordreference_histories")->truncate(); 

        $wordreference_history = []; 

        $searchResultsExample = array(
            'espace' => 'space',
            'rêve' => 'dream',
            'voyager' => 'travel',
            'courir' => 'run',
            'jeu vidéo' => 'video game'

        );

        foreach($searchResultsExample as $s => $r){

            $wordreference_histories[] = [
                'category' => 'fren',
                'languageFrom' => 'french',
                'languageTo' => 'english',
                'search' => $s,
                'result' => $r,
            ];
        }

        DB::table('wordreference_histories')->insert($wordreference_histories);

    }
}
