<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JishoHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        $jishoHistory = new JishoHistory();
        $jishoHistory->search = $search;

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
    
            $jishoHistory->result = "no result";
            $jishoHistory->save();

            return response()->json([
                'meta' => [
                    'status' => 404
                ], 
                'data' => 
                [
                    [
                        'search' => $search,
                        'result' => 'no result'
                    ]
                ]
            ]);
            
        }

        $result = json_encode($datas, JSON_UNESCAPED_UNICODE);
        $jishoHistory->result = $result;
        $jishoHistory->save();

        return response()->json([
            'meta' => [
                'status' => 200
            ], 
            'data' => json_decode($result, JSON_UNESCAPED_UNICODE)
        ]);

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
