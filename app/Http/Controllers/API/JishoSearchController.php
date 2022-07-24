<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JishoHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Route;


class JishoSearchController extends Controller
{
    
    public function jishoSearchFromHome(Request $request)
    {
  
        $category = $request->input('category');
        $search = $request->input('search');
    
        return redirect(route('jisho_search', ['category' => $category, 'search' => $search]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JishoHistory  $jishoHistory
     * @return \Illuminate\Http\Response
     */
    public function show($category, $search)
    {
        /*** Checking the table jisho_histories ***/
        
        //-- if $search already exits, the endpoint renders the column 'result' --
        $db_query_jisho = JishoHistory::where('search', $search)->first();

        if(!empty($db_query_jisho)){

            $resultInDB = $db_query_jisho->result;

            //------------------------------
            // +1 to the column search Count
            $searchCount = $db_query_jisho->searchCount;
            $searchCount += 1;

            JishoHistory::where('search', $search)
            ->update(['searchCount' => $searchCount]);

            //-----------------------------------------
            // set actual datetime to updated_at column
            date_default_timezone_set("Europe/Paris");
            $datenow = date("Y-m-d H:i:s");

            JishoHistory::where('search', $search)
            ->update(['updated_at' => $datenow]);

            return response()->json(json_decode($resultInDB, JSON_UNESCAPED_UNICODE));
        }
        

        //-- if $search doesn't exit in db, the endpoint calls jisho's api --

        $jishoHistory = new JishoHistory();
        $jishoHistory->search = $search;
        
        date_default_timezone_set("Europe/Paris");
        $datenow = date("Y-m-d H:i:s");
        $jishoHistory->created_at = $datenow;

        if($category == 'jpen'){
            
            $jishoHistory->category = $category;
            $jishoHistory->languageFrom = "japanese";
            $jishoHistory->languageTo = "english";

        }

        else if($category == 'enjp'){

            $jishoHistory->category = $category;
            $jishoHistory->languageFrom = "english";
            $jishoHistory->languageTo = "japanese";
        }

        else{

            $jishoHistory->category = $category;
            $jishoHistory->languageFrom = "NaN";
            $jishoHistory->languageTo = "NaN"; 
        }

        //Call for jisho.org's api
        $apiResponse = Http::get("http://beta.jisho.org/api/v1/search/words?keyword=$search");
        $response = json_decode($apiResponse->body());
        $datas = $response->data;



        if(empty($datas)){

            $noResult = array(
                'meta' => [
                    'status' => 200
                ], 
                'data' => [
                    'search' => $search,
                    'result' => 'no result'
                ]
            );
    
            $jishoHistory->result = json_encode($noResult);
            $jishoHistory->save();

            return response()->json($noResult);
            
        }

        $result = json_encode($response, JSON_UNESCAPED_UNICODE);
        $jishoHistory->result = $result;
        $jishoHistory->save();

        return response()->json(json_decode($result, JSON_UNESCAPED_UNICODE));

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
