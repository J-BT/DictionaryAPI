<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WordreferenceHistory;
use App\Models\JishoHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Weidner\Goutte\GoutteFacade;
use Wordreference;

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
        $topSections = Wordreference::WordTopSections($category, $search);
        $fromWords = Wordreference::FromWords($category, $search);
        $toWords = Wordreference::toWords($category, $search);
        $allTd = Wordreference::AllTd($category, $search);

        $tempResults = array("topSections" => $topSections , "fromWords" => $fromWords, "toWords" => $toWords, "allTd" => $allTd);

        // $results = Wordreference::GetJson($category, $search);


        return response()->json($tempResults);
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
