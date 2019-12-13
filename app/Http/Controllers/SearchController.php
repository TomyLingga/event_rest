<?php

namespace App\Http\Controllers;
use App\Event;
use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{
    public function search(request $string){
        
        $image_path = "http://192.168.43.248/event_rest/storage/app/public/upload/brosur/";
        $cari = $string->cari;
        // image view bisa di full screen
        // perbaiki tambah event bug
        // password lebih secure
        $events = DB::table('events')
            ->where('namaEvent','like',"%".$cari."%")
            ->orWhere('lokasiEvent','like',"%".$cari."%")
            ->orWhere('tanggalEvent','like',"%".$cari."%")
            ->get();
        
            foreach ($events as $event) {
                $event->brosurEvent = $image_path.$event->brosurEvent;    
            }
        
        $response["events"] = $events;
        $response["success"] = 1;
    
        return response()->json($response);
    }
}
