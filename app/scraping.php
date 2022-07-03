<?php

use Weidner\Goutte\GoutteFacade;
session_start();

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
    
        return response()->json($wrtopsection);
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

        return response()->json($FrWrd);
    }

    // Traductions
    public static function ToWords($category, $search){
        $page = GoutteFacade::request('GET', "https://www.wordreference.com/$category/$search");
        $_SESSION["ToWrd"] = array();
        $page->filter('.ToWrd')->each(function ($node) {
            // dump($node->text());
            array_push($_SESSION["ToWrd"], $node->text());
        });
        $ToWrd = $_SESSION["ToWrd"];
        unset($_SESSION["ToWrd"]);

        return response()->json($ToWrd);
    }
        

}