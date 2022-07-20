<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JishoHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class JishoHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jishoHistories = JishoHistory::all();

        // the following instruction convert $jishoHistory->result from string into json 
        foreach ($jishoHistories as $jishoHistory) {
            $jishoHistory->result = json_decode($jishoHistory->result, JSON_UNESCAPED_UNICODE);
          } 

        return response()->json([
            'jishoHistories' => $jishoHistories
        ]);

        // return response()->json(json_decode($result, JSON_UNESCAPED_UNICODE));

        
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
    public function show(JishoHistory $jishoHistory)
    {
        return response()->json($jishoHistory);
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

            /**
             * Get the value of post
             */ 
            public function getPost()
            {
                        return $this->post;
            }
}
