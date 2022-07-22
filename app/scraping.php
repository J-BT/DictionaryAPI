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

        if(isset($_SESSION["AllTd"])){
            unset($_SESSION["AllTd"]);
        }
        
        else{
            $_SESSION["AllTd"] = array();
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

        $_SESSION["previousTrClass"] = "";

        $page->filter(
            'table.WRD tr:not(.ToEx)'
            )->each(function ($row) {

                $trClass = $row->extract(['class'])[0];
                    
                if($trClass == 'even' || $trClass == 'odd' ){
                    
                    if($_SESSION["previousTrClass"] != $trClass && !empty($_SESSION["previousTrClass"])){
                        array_push($_SESSION["AllTd"], "\n**New line**\n");
                    }

                    if($trClass == 'even'){
                        // array_push($_SESSION["AllTd"], "**even** {$row->text()}");
                        array_push($_SESSION["AllTd"], "**even**");
                        $row->filter('td')->each(function ($column) {
                            
                            $tdClass = $column->extract(['class'])[0];
                            array_push($_SESSION["AllTd"], "[class : {$tdClass}] {$column->text()}");    
                        });

                    }
    
                    if($trClass == 'odd'){
                        // array_push($_SESSION["AllTd"], "**odd** {$row->text()}");
                        array_push($_SESSION["AllTd"], "**even**");
                        $row->filter('td')->each(function ($column) {

                            $tdClass = $column->extract(['class'])[0];
                            array_push($_SESSION["AllTd"], "[class : {$tdClass}] {$column->text()}");    
                        });
                    }

                    $_SESSION["previousTrClass"] = $trClass;
                }

        });

        // $page->filter(
        //     'table.WRD:first-of-type tr.wrtopsection td,
        //     table.WRD:first-of-type tr.even td:not(.FrEx):not(.ToEx),
        //     table.WRD:first-of-type tr.odd td:not(.FrEx):not(.ToEx)'
        //     )->each(function ($node) {
           
        //     array_push($_SESSION["AllTd"], $node->text());
            
        // });

        return $_SESSION["AllTd"];
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