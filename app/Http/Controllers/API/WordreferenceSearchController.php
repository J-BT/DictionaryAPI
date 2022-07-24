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
        $saveInDB = false;

        /*** Checking the table wordreference_histories ***/
        
        //-- if $search already exits, the endpoint renders the column 'result' --
        $db_query_wordreference = WordreferenceHistory::where('search', $search)->first();

        if(!empty($db_query_wordreference) 
            && $category == 'enfr'){

            $resultInDB = $db_query_wordreference->result;

            //------------------------------
            // +1 to the column search Count
            $searchCount = $db_query_wordreference->searchCount;
            $searchCount += 1;

            WordreferenceHistory::where('search', $search)
            ->update(['searchCount' => $searchCount]);

            //-----------------------------------------
            // set actual datetime to updated_at column
            date_default_timezone_set("Europe/Paris");
            $datenow = date("Y-m-d H:i:s");

            WordreferenceHistory::where('search', $search)
            ->update(['updated_at' => $datenow]);

            return response()->json(json_decode($resultInDB, JSON_UNESCAPED_UNICODE));
        }

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

            $response = Wordreference::GetJsonEngToFr($category, $search);

            if($response["data"] != 'wrong category'){
                $saveInDB = true;
            }
        }

        else if($category == 'fren'){

            $wordreferenceHistory->category = $category;
            $wordreferenceHistory->languageFrom = "french";
            $wordreferenceHistory->languageTo = "english";

            $response = Wordreference::GetJsonFrtoEng($category);
        }

        else{

            $wordreferenceHistory->category = $category;
            $wordreferenceHistory->languageFrom = "NaN";
            $wordreferenceHistory->languageTo = "NaN"; 

            $response = Wordreference::GetJsonNoCategory($category);
        }

        

        $result = json_encode($response, JSON_UNESCAPED_UNICODE);
        $wordreferenceHistory->result = $result;

        if($saveInDB){
            $wordreferenceHistory->save();
        }
        // return response()->json(json_decode($result, JSON_UNESCAPED_UNICODE));
        return response()->json(json_decode($result, JSON_UNESCAPED_UNICODE));

    }

}
