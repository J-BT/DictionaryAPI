<?php

use Weidner\Goutte\GoutteFacade;
session_start(); // car les variables locales ne fonctionnent pas dans les each()

class Wordreference
{
    

    // Provides english->french translations scraping on wordreference.com
    public static function EngToFr($category, $search){
        $page = GoutteFacade::request('GET', "https://www.wordreference.com/$category/$search");

        $_SESSION["jsonEnFrResults"] = array();
        $_SESSION["nthRowOfWord"] = 0;

        /************************/
        /********* Model *********/
        /************************/

        // $json_enfr = array(
        //     'slug' => '**identifiant**',
        //     'type' => '**noun/verb/...**',
        //     'english' =>'**$search**',
        //     'details' => '**ex: figurative (person: slow), slang, literal (settle with a fistfight), ...**',
        //     'senses' => [
        //         'french' => '**traduction**',
        //         'type' => '**nom/verbe/...**'
        //     ]
        // );
        $_SESSION["json_enfr"] = array(
            'slug' => '',
            'type' => '',
            'english' =>'',
            'details' => '',
            'senses' => [

            ]
        );

        $_SESSION["previousTrClass"] = "";
        $_SESSION["trClass"] = "";


        // /*******Test******* */

        $page->filter(
            'div#articleWRD table.WRD '  // select 1st table : table.WRD:nth-of-type(1) tr
            )->each(function ($table){
                
                array_push($_SESSION["jsonEnFrResults"], "======== new table ========");
                
                $table->filter('tr:not(.wrtopsection):not(.langHeader)')->each(function ($row) {
                    
                    $rowClass = $row->extract(['class'])[0];
                    array_push($_SESSION["jsonEnFrResults"], $rowClass);
                });

            });

        // /****************** */

        // $page->filter(
        //     'table.WRD tr:not(.wrtopsection):not(.langHeader)'  // select 1st table : table.WRD:nth-of-type(1) tr
        //     )->each(function ($row) {

        //         $_SESSION["trClass"] = $row->extract(['class'])[0];
                    
        //         if($_SESSION["trClass"] == 'even' || $_SESSION["trClass"] == 'odd' ){
                    
        //             // ------ If the word changes -------------------------------------------------------------
        //             if($_SESSION["previousTrClass"] != $_SESSION["trClass"]){

        //                 //new row in json everytime the class changes(even / odd) except for the first iteration
        //                 if($_SESSION["previousTrClass"] != ""){  
        //                     array_push($_SESSION["jsonEnFrResults"], $_SESSION["json_enfr"]); 

        //                     $_SESSION["json_enfr"] = array(
        //                         'slug' => '',
        //                         'type' => '',
        //                         'english' =>'',
        //                         'details' => '',
        //                         'senses' => [

        //                         ]
        //                     );

        //                     $_SESSION["nthRowOfWord"] = 0;
        //                 }

        //                 $row->filter('td:not(.FrEx):not(.ToEx)')->each(function ($column) {
                            
        //                     $tdClass = $column->extract(['class'])[0];
        //                     // array_push($_SESSION["jsonEnFrResults"], "[class : {$tdClass}] {$column->text()}");

        //                     if($tdClass == 'FrWrd'){
        //                         $_SESSION["json_enfr"]['slug'] = $column->filter('strong')->text();
        //                         $_SESSION["json_enfr"]['english'] = $column->filter('strong')->text();
        //                         $_SESSION["json_enfr"]['type'] = $column->filter('em')->text();
                                
        //                     }

        //                     else if($tdClass == 'ToWrd'){


        //                         $_SESSION["json_enfr"]['senses'][$_SESSION["nthRowOfWord"]]['french'] =  $column->text();
        //                         $_SESSION["json_enfr"]['senses'][$_SESSION["nthRowOfWord"]]['type'] =  $column->filter('em')->text();
        //                     }

        //                     else if($tdClass != 'FrWrd' && $tdClass != 'ToWrd'){
        //                         //details english
        //                         $details = $column->text();
        //                         $details = substr($details, 0, strpos($details, ')')); //removing the right part after the space
        //                         $details = $details . ')';
        //                         $_SESSION["json_enfr"]['details'] = $details;

        //                     }

        //                 });

        //             }

        //             // ------ If the word i the same (different row but same class (even/ odd)) -------------------------------------------
        //             if($_SESSION["previousTrClass"] == $_SESSION["trClass"]){

        //                 $row->filter('td:not(.FrEx):not(.ToEx)')->each(function ($column) {
        //                     $tdClass = $column->extract(['class'])[0];
                                
        //                     if($tdClass == 'ToWrd'){


        //                         $_SESSION["json_enfr"]['senses'][$_SESSION["nthRowOfWord"]]['french'] =  $column->text();
        //                         $_SESSION["json_enfr"]['senses'][$_SESSION["nthRowOfWord"]]['type'] =  $column->filter('em')->text();
        //                     }  
                            
        //                 });
        //             }

        //             $_SESSION["nthRowOfWord"] ++;
        //             $_SESSION["previousTrClass"] = $_SESSION["trClass"];
        //         }

        // });

        return $_SESSION["jsonEnFrResults"];
    }


    public static function GetJson($category, $search){


        $engToFr = Wordreference::EngToFr($category, $search);

        $result = array(
            'meta' => [
                'status' => 200
            ], 
            'data' => $engToFr
            
        );

        return $result;
    }

}