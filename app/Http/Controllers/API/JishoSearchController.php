<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JishoHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class JishoSearchController extends Controller
{
    
    public function jishoSearchFromHome(Request $request)
    {
  
        $category = $request->input('category');
        $search = $request->input('search');
    

        return route("api/jisho/{$category}/{$search}");
        // return $search;
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

            $englishTranslation = array();
            $datas = $response->data;
            
            foreach($datas as $data){
                $nthSense = 1;
                $senses = $data->senses;
                $japaneseWord = $data->slug;
                foreach($senses as $sense){
                    $englishTranslations =  $sense->english_definitions;
                    $translationRow = 0;
                    foreach($englishTranslations as $translation){
                        $resume = "";
                        if($translationRow == 0){
                            $resume = "[Word=$japaneseWord Sense=$nthSense] :";
                        }
                        array_push($englishTranslation, "$resume $translation");
                        $translationRow++;
                    }
                    
                    $nthSense ++;
                }
            }
            $result = implode("," , $englishTranslation);
            
            
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

            $japaneseTranslation = array();
            $datas = $response->data;
        
            $nthTranslation = 1;
            foreach($datas as $data){
                // $result = $response->data[0]->senses[0]->english_definitions[0];
                $sense = $data->senses[0];
                $japaneseWord = $data->slug;
                $englishWord =  $sense->english_definitions[0];

                array_push($japaneseTranslation, "[Word=$englishWord Translation=$nthTranslation] : $japaneseWord");

                $nthTranslation++;
            }

            $result = implode("," , $japaneseTranslation);
            

            //ajout table jisho_histories categorie jpen
            $jishoHistory = new JishoHistory();

            $jishoHistory->category = $category;
            $jishoHistory->languageFrom = "english";
            $jishoHistory->languageTo = "japanese";
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
