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
        //Call for jisho.org here !!!
        $apiResponse = Http::get("http://beta.jisho.org/api/v1/search/words?keyword=$search");
        $response = json_decode($apiResponse->body());

        if(empty($response->data)){
            $jishoHistory = new JishoHistory();

            $jishoHistory->category = $category;
            $jishoHistory->languageFrom = "japanese";
            $jishoHistory->languageTo = "english";
            $jishoHistory->search = $search;
            $jishoHistory->result = "no result";

            $jishoHistory->save();

            return response()->json("Aucun resultat pour $search");
        }

        if($category == 'jpen'){
            // $result = $response->data[0]->senses[0]->english_definitions[0];

            $datas = $response->data;
            $result = json_encode($datas, JSON_UNESCAPED_UNICODE);
            
            
            //****Mettre conditions içi pour obtenir tous les resultats *****

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

            $datas = $response->data;
            $result = json_encode($datas, JSON_UNESCAPED_UNICODE);
            

            //ajout table jisho_histories categorie jpen
            $jishoHistory = new JishoHistory();

            $jishoHistory->category = $category;
            $jishoHistory->languageFrom = "english";
            $jishoHistory->languageTo = "japanese";
            $jishoHistory->search = $search;
            $jishoHistory->result = $result;

            $jishoHistory->save();

        }

        else{
           
            $datas = $response->data;
            $result = json_encode($datas, JSON_UNESCAPED_UNICODE);
            
            
            //****Mettre conditions içi pour obtenir tous les resultats *****

            //ajout table jisho_histories categorie jpen
            $jishoHistory = new JishoHistory();

            $jishoHistory->category = $category;
            $jishoHistory->languageFrom = "NaN";
            $jishoHistory->languageTo = "NaN";
            $jishoHistory->search = $search;
            $jishoHistory->result = $result;

            $jishoHistory->save(); 
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
