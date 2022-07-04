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

    // à utiliser pour que les fromWord & ToWords correspondent
    public static function AllTd($category, $search){
        $page = GoutteFacade::request('GET', "https://www.wordreference.com/$category/$search");
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

        return $AllTd;
    }

    // Créer Json à partir des 3 methodes ci-dessus
    public static function GetJson($category, $search){

        $topSections = Wordreference::WordTopSections($category, $search);
        $fromWords = Wordreference::FromWords($category, $search);
        $toWords = Wordreference::toWords($category, $search);

        $result = array_combine($fromWords, $toWords);

        return $result;
    }
        

}