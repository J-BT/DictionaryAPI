<?php

use Weidner\Goutte\GoutteFacade;


class Wordreference
{
    // Mots et traductions regroupés par sections
    public static function GetAllSections($category, $search){
        $page = GoutteFacade::request('GET', "https://www.wordreference.com/$category/$search");
    
        
        $allSections = $page->filter('.WRD')->each(function ($section) {
            dump($section->text());
        });
    
        return response()->json($allSections);
    }
    // Mots recherchés
    public static function FromWords($category, $search){

        $page = GoutteFacade::request('GET', "https://www.wordreference.com/$category/$search");
        $FrWrd = array($page->filter('.FrWrd')->each(function ($node) {
            dump($node->text());
        }));
        return response()->json($FrWrd);
    }

    // Traductions
    public static function ToWords($category, $search){

        $page = GoutteFacade::request('GET', "https://www.wordreference.com/$category/$search");
        $ToWrd = array($page->filter('.ToWrd')->each(function ($node) {
            dump($node->text());
            // $node->text();
        }));
        return response()->json($ToWrd);
    }
        

}