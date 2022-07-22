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
    public function WordreferenceSearchFromHome(Request $request)
    {
  
        $category = $request->input('category');
        $search = $request->input('search');
    
        return redirect(route('wordreference_search', ['category' => $category, 'search' => $search]));
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
        /*** Checking the table jisho_histories ***/
        
        //-- if $search already exits, the endpoint renders the column 'result' --
        $db_query_wordreference = WordreferenceHistory::where('search', $search)->first();

        // if(!empty($db_query_wordreference)){

        //     $resultInDB = "";

        //     return response()->json(json_decode($resultInDB, JSON_UNESCAPED_UNICODE));
        // }
        

        //-- if $search doesn't exit in db, the endpoint calls wordreference's api --

        $wordreferenceHistory = new WordreferenceHistory();
        $wordreferenceHistory->search = $search;
        
        date_default_timezone_set("Europe/Paris");
        $datenow = date("Y-m-d H:i:s");
        $wordreferenceHistory->created_at = $datenow;

        if($category == 'enfr'){
            
            $wordreferenceHistory->category = $category;
            $wordreferenceHistory->languageFrom = "english";
            $wordreferenceHistory->languageTo = "french";

        }

        else if($category == 'fren'){

            $wordreferenceHistory->category = $category;
            $wordreferenceHistory->languageFrom = "french";
            $wordreferenceHistory->languageTo = "english";
        }

        else{

            $wordreferenceHistory->category = $category;
            $wordreferenceHistory->languageFrom = "NaN";
            $wordreferenceHistory->languageTo = "NaN"; 
        }



        // $topSections = Wordreference::WordTopSections($category, $search);
        // $fromWords = Wordreference::FromWords($category, $search);
        // $toWords = Wordreference::toWords($category, $search);
        // $allTd = Wordreference::AllTd($category, $search);
        // $response = array("allTd" => $allTd);
        
        /******** Wordreference::GetJson *******/

        // stocker json dans variable $response içi
        $response = Wordreference::GetJson($category, $search);

        /************************************* */
        
        $datas = $response;

        if(empty($datas)){

            $noResult = array(
                'meta' => [
                    'status' => 404
                ], 
                'data' => [
                    'search' => $search,
                    'result' => 'no result'
                ]
            );
    
            $wordreferenceHistory->result = json_encode($noResult);
            $wordreferenceHistory->save();

            return response()->json($noResult);
            
        }

        $result = json_encode($response, JSON_UNESCAPED_UNICODE);
        $wordreferenceHistory->result = $result;
        $wordreferenceHistory->save();

        return response()->json(json_decode($result, JSON_UNESCAPED_UNICODE));

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
