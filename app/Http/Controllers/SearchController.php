<?php

namespace App\Http\Controllers;
use App\Event;
use Illuminate\Http\Request;
use DB;

class SearchController extends Controller {

    //fungsi search

    public function search( request $string ) {

        $image_path = 'http://192.168.43.248/event_rest/storage/app/public/upload/brosur/';
        $cari = $string->cari;

        $events = DB::table( 'events' )
        ->where( 'namaEvent', 'like', '%'.$cari.'%' )           // ambil event yang namanya mirip dengan parameter
        ->orWhere( 'lokasiEvent', 'like', '%'.$cari.'%' )       // atau event yang lokasinya mirip dengan parameter
        ->orWhere( 'tanggalEvent', 'like', '%'.$cari.'%' )      // atau event yang tanggal mirip dengan parameter
        ->get();

        foreach ( $events as $event ) {
            $event->brosurEvent = $image_path.$event->brosurEvent;
            //untuk setiap data event yang didapat, tambah kan url gambar sebelum poster
        }

        $response['events'] = $events;
        $response['success'] = 1;

        return response()->json( $response );
    }
}
