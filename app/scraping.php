<?php

use Weidner\Goutte\GoutteFacade;


class Wordreference
{
    public static function GetAllSections($category, $search){
        $page = GoutteFacade::request('GET', "https://www.wordreference.com/$category/$search");
    
        // Mots et traductions regroupés par sections
        $allSections = $page->filter('.WRD')->each(function ($section) {
            dump($section->text());
        });
    
        return response()->json($allSections);
    }
}