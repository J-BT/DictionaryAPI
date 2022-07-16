<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $cities = array();
        $cities["osaka"] =  "大阪最高や！";
        $cities["kyoto"] = "淀川の隣に居ていた時に最高だったなぁ...";


        date_default_timezone_set("Europe/Paris");
        $datenow = date("h:i:sa");

        return view('home.index', ['cities' => $cities, 'datenow' => $datenow]);
    }
}
