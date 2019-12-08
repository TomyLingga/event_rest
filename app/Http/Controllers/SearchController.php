<?php

namespace App\Http\Controllers;
use App\Event;
use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{
    public function search(request $string){
        //$cari = Event::search($string)->get();

        $cari = $string->cari;
        
        if($cari==null){
            $events = "hahahahha";
        
        }else{
    		// mengambil data dari table pegawai sesuai pencarian data
		$events = DB::table('events')
		->where('namaEvent','like',"%".$cari."%")->get();
    }
        return response()->json($events);
    }
}
