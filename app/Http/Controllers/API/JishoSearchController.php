<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JishoHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JishoSearchController extends Controller
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
     * @param  \App\Models\JishoHistory  $jishoHistory
     * @return \Illuminate\Http\Response
     */
    public function show($category, $search)
    {
        //Call for jisho.org here !!!
        $apiResponse = Http::get("http://beta.jisho.org/api/v1/search/words?keyword=$search");

        $response = json_decode($apiResponse->body());

        if(empty($response->data)){
            return response()->json("Aucun resultat pour $search");
        }

        if($category == 'jpen'){
            $result = $response->data[0]->senses[0]->english_definitions[0];
            
            //****Mettre conditions içi pour obtenir tous les resultats *****

            // - faire foreach sur data[]
            // - faire foreach sur senses[]
            // - Si english_definitions[] contient plus d'un element convertir ses elements en chaîne de caractères

            //ajout table jisho_histories categorie jpen
            $jishoHistory = new JishoHistory();

            $jishoHistory->category = $category;
            $jishoHistory->languageFrom = "japanese";
            $jishoHistory->languageTo = "english";
            $jishoHistory->search = $search;
            $jishoHistory->result = $result;

            $jishoHistory->save();
        }

        else if($category == 'enjp'){
           //ajout table jisho_histories categorie enjp
        }

        return response()->json($response);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JishoHistory  $jishoHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JishoHistory $jishoHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JishoHistory  $jishoHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(JishoHistory $jishoHistory)
    {
        //
    }
}
