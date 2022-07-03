<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WordreferenceHistory;
use App\Models\JishoHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Weidner\Goutte\GoutteFacade;

class WordreferenceSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WordreferenceHistory  $wordreferenceHistory
     * @return \Illuminate\Http\Response
     */
    public function show($category, $search)
    {
        $page = GoutteFacade::request('GET', "https://www.wordreference.com/$category/$search");

        // Miots et traductions regroupés par sections
        $mainTable = $page->filter('.WRD')->each(function ($node) {
            dump($node->text());
        });


        // // Mots recherchés
        // $FrWrd = $page->filter('.FrWrd')->each(function ($node) {
        //     dump($node->text());
        // });
        

        // // Traductions
        // $ToWrd = $page->filter('.ToWrd')->each(function ($node) {
        //     dump($node->text());
        // });


        // // // titres sections
        // $wrtopsection = $page->filter('.wrtopsection')->each(function ($node) {
        //     dump($node->text());
        // });



        return response()->json($mainTable);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WordreferenceHistory  $wordreferenceHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WordreferenceHistory $wordreferenceHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WordreferenceHistory  $wordreferenceHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(WordreferenceHistory $wordreferenceHistory)
    {
        //
    }
}
