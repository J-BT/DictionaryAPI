<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\WordreferenceHistory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class WordreferenceHistoryController extends Controller
{
    public function WordreferenceFromHome(Request $request)
    {
  
        $category = $request->input('category');
        $search = $request->input('search');
    
        return redirect(route('wordreference_search', ['category' => $category, 'search' => $search]));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wordreferenceHistories = WordreferenceHistory::orderBy('id', 'DESC')->get();

        if($wordreferenceHistories->count() > 0){

            // the following instruction convert $jishoHistory->result from string into json 
            foreach ($wordreferenceHistories as $wordreferenceHistory) {
                $wordreferenceHistory->result = json_decode($wordreferenceHistory->result, JSON_UNESCAPED_UNICODE);
            } 

            $result = array(
                'meta' => [
                    'status' => 200
                ], 
                'data' => [
                    'wordreferenceHistories' => $wordreferenceHistories
                ]
            );
        }

        else{
            $result = array(
                'meta' => [
                    'status' => 404
                ], 
                'data' => [
                    'wordreferenceHistories' => 'empty table'
                ]
            );
        }

        return response()->json($result);
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
    public function show(WordreferenceHistory $wordreferenceHistory)
    {
        //
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
