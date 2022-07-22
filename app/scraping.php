<?php

use Weidner\Goutte\GoutteFacade;
session_start(); // car les variables locales ne fonctionnent pas dans les each()

class Wordreference
{
    // Mots et traductions regroupés par sections
    public static function WordTopSections($category, $search){
        $page = GoutteFacade::request('GET', "https://www.wordreference.com/$category/$search");
        $_SESSION["wrtopsection"] = array();
        $page->filter('.wrtopsection')->each(function ($section) {
            // dump($section->text());
            array_push($_SESSION["wrtopsection"], $section->text());
        });

        $wrtopsection = $_SESSION["wrtopsection"];
        unset($_SESSION["wrtopsection"]);
    
        return $wrtopsection;
    }
    // Mots recherchés
    public static function FromWords($category, $search){
        $page = GoutteFacade::request('GET', "https://www.wordreference.com/$category/$search");
        $_SESSION["FrWrd"] = array();
        $page->filter('.FrWrd')->each(function ($node) {
            // dump($node->text());
            array_push($_SESSION["FrWrd"], $node->text());
        });
        $FrWrd = $_SESSION["FrWrd"];
        unset($_SESSION["FrWrd"]);

        return $FrWrd;
    }

    // Traductions
    public static function ToWords($category, $search){
        $page = GoutteFacade::request('GET', "https://www.wordreference.com/$category/$search");
        $_SESSION["ToWrd"] = array();
        $row = "even";
        $page->filter('.ToWrd')->each(function ($node) {
            // dump($node->text());
            array_push($_SESSION["ToWrd"], $node->text());
            
        });
        $ToWrd = $_SESSION["ToWrd"];
        unset($_SESSION["ToWrd"]);

        return $ToWrd;
    }

    // Pour test---------------------------------------------------------------------------------
    public static function AllTd($category, $search){
        $page = GoutteFacade::request('GET', "https://www.wordreference.com/$category/$search");

        $_SESSION["jsonEnFrResults"] = array();

        /**************************/
        /********* Modèle *********/
        /**************************/

        // $json_enfr = array(
        //     'slug' => '**identifiant**',
        //     'type' => '**noun/verb/...**',
        //     'english' =>'**$search**',
        //     'details' => '**ex: figurative (person: slow), slang, literal (settle with a fistfight), ...**',
        //     'senses' => [
        //         'french' => '**traduction**',
        //         'type' => '**nom/verbe/...**',
        //         'details' => '**ex: (figuré, péjoratif)	**'
        //     ]
        // );

        $_SESSION["previousTrClass"] = "";

        $page->filter(
            'table.WRD tr:not(.ToEx)'
            )->each(function ($row) {

                $_SESSION["json_enfr"] = array(
                    'slug' => '**identifiant**',
                    'type' => '**noun/verb/...**',
                    'english' =>'**$search**',
                    'details' => '**ex: figurative (person: slow), slang, literal (settle with a fistfight), ...**',
                    'senses' => [
                        'french' => '**traduction**',
                        'type' => '**nom/verbe/...**',
                        'details' => '**ex: (figuré, péjoratif)	**'
                    ]
                );

                $trClass = $row->extract(['class'])[0];
                    
                if($trClass == 'even' || $trClass == 'odd' ){
                    
                    // ------ If the word changes -------------------------------------------------------------
                    if($_SESSION["previousTrClass"] != $trClass){
                        
                        $row->filter('td')->each(function ($column) {
                            
                            $tdClass = $column->extract(['class'])[0];
                            // array_push($_SESSION["jsonEnFrResults"], "[class : {$tdClass}] {$column->text()}");

                            if($tdClass == 'FrWrd'){
                                $_SESSION["json_enfr"]['slug'] = $column->filter('strong')->text();
                                $_SESSION["json_enfr"]['english'] = $column->filter('strong')->text();
                                $_SESSION["json_enfr"]['type'] = $column->filter('em')->text();
                            }

                            else if($tdClass != 'FrWrd' && $tdClass != 'ToWrd'){
                                
                                $details = $column->text();
                                $details = substr($details, 0, strpos($details, ')')); //removing the right part after the space
                                $details = $details . ')';
                                $_SESSION["json_enfr"]['details'] = $details;
                            }

                        });

                        array_push($_SESSION["jsonEnFrResults"], $_SESSION["json_enfr"]);

                    }

                    // ------ If the word i the same -------------------------------------------------------------
                    else{
                         

                    if($trClass == 'even'){
                        array_push($_SESSION["jsonEnFrResults"], "**even**");
                    }
    
                    else if($trClass == 'odd'){
                        array_push($_SESSION["jsonEnFrResults"], "**odd**");
                    }

                    $row->filter('td')->each(function ($column) {
                            
                        $tdClass = $column->extract(['class'])[0];
                        // array_push($_SESSION["jsonEnFrResults"], "[class : {$tdClass}] {$column->text()}");
       
                            
                    });
                    }

                    $_SESSION["previousTrClass"] = $trClass;
                }

        });

        return $_SESSION["jsonEnFrResults"];
    }

    public static function FrToEn($search){

        $page = GoutteFacade::request('GET', "https://www.wordreference.com/enfr/$search");

        $_SESSION["AllTd"] = array();

        $page->filter(
            'table.WRD:first-of-type tr.wrtopsection td,
            table.WRD:first-of-type tr.even td:not(.FrEx):not(.ToEx),
            table.WRD:first-of-type tr.odd td:not(.FrEx):not(.ToEx)'
            )->each(function ($node) {
            // dump($node->text());
            array_push($_SESSION["AllTd"], $node->text());
            
        });
        $AllTd = $_SESSION["AllTd"];
        unset($_SESSION["AllTd"]);

        $newArray = array();
        $counSpace = 0;

        foreach($AllTd as $td){
            array_push($newArray, $td);
            if($td == "\\u21d2"){
                array_push($newArray, "----------------");
            }
        }

        $json_enfr = array(
            'slug' => '**identifiant**',
            'type' => '**noun/verb/...**',
            'english' =>'**$search**',
            'details' => '**ex: figurative (person: slow), slang, literal (settle with a fistfight), ...**',
            'senses' => [
                'french' => '**traduction**',
                'type' => '**nom/verbe/...**',
                'details' => '**ex: (figuré, péjoratif)	**'
            ]
        );

        // $test = $page;

        return $newArray;
        // return $test;
    }

    // Créer Json à partir des 3 methodes ci-dessus
    public static function GetJson($category, $search){

        $topSections = Wordreference::WordTopSections($category, $search);
        $fromWords = Wordreference::FromWords($category, $search);
        $toWords = Wordreference::toWords($category, $search);
        $allTd = Wordreference::AllTd($category, $search);

        $json_enfr = Wordreference::FrToEn($search);

        // $result = $fromWords;
        // // $result = array("allTd" => $allTd);
        // // $result = array_combine($fromWords, $toWords);

        // if(empty($allTd)){
        //     $noNesult = array(
        //         'meta' => [
        //             'status' => 404
        //         ], 
        //         'data' => "no result"
                
        //     );
        //     return $noNesult;
        // }

        $result = array(
            'meta' => [
                'status' => 200
            ], 
            'data' => $allTd
            
        );

        // $test = $json_enfr;

        // return $test;
        return $result;
    }

}