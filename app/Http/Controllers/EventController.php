<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Ticket;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Query\Builder;
use DB;

class EventController extends Controller
 {
    public $successStatus = 200;

    // fungsi untuk List Event

    public function index() {
        $image_path = 'http://192.168.43.248/event_rest/storage/app/public/upload/brosur/';
        //url poster yang disimpan di server
        $events  = DB::table( 'events' )
        ->whereDate( 'tanggalEvent', '>=', date( 'Y-m-d' ) )                    //ambil event2 yang masih tersedia saja
        ->latest()                                                          //tampil kan dari yang paling baru
        ->get();

        foreach ( $events as $key => $event ) {
            $event->brosurEvent = $image_path.$event->brosurEvent;
            // untuk setiap data event yang didapat, tambah kan url gambar sebelum poster
        }

        $response['events'] = $events;
        $response['success'] = 1;
        return response()->json( $response );
    }

    //fungsi untuk Detail Event

    public function index1( $id, $userId ) {
        $image_path = 'http://192.168.43.248/event_rest/storage/app/public/upload/brosur/';

        $event  = DB::table( 'events' )->find( $id );

        if ( $event->brosurEvent != null ) {
            $event->brosurEvent = $image_path.$event->brosurEvent;

        }
        // menghitung sudah berapa users yang join event yang idnya = parameter
        $jlh_peserta =  DB::table( 'tickets' )->where( ['eid'=>$id] )
        ->count();

        if ( Ticket::where( [
            'uidMengikuti'=> $userId,
            'eid'=>$id,
        ] )->exists() ) {
            $success['jumlahPeserta'] = $jlh_peserta;
            // kalau user sudah pernah join sebelumnya maka nilai statusAda di set jadi true
            $success['statusAda'] = true;
            $success['id'] = $event->id;
            $success['uid'] = $event->uid;
            $success['namaEvent'] = $event->namaEvent;
            $success['tanggalEvent'] = $event->tanggalEvent;
            $success['jamEvent'] = $event->jamEvent;
            $success['jumlahPesertaEvent'] = $event->jumlahPesertaEvent;
            $success['lokasiEvent'] = $event->lokasiEvent;
            $success['brosurEvent'] = $event->brosurEvent;
            $success['deskripsiEvent'] = $event->deskripsiEvent;
            $success['qrEvent'] = $event->qrEvent;
            $success['created_at'] = $event->created_at;
            $success['updated_at'] = $event->updated_at;
        } else {
            $success['jumlahPeserta'] = $jlh_peserta;
            // kalau belum pernah join, maka nilai statusAda nya false
            $success['statusAda'] = false;
            $success['id'] = $event->id;
            $success['uid'] = $event->uid;
            $success['namaEvent'] = $event->namaEvent;
            $success['tanggalEvent'] = $event->tanggalEvent;
            $success['jamEvent'] = $event->jamEvent;
            $success['jumlahPesertaEvent'] = $event->jumlahPesertaEvent;
            $success['lokasiEvent'] = $event->lokasiEvent;
            $success['brosurEvent'] = $event->brosurEvent;
            $success['deskripsiEvent'] = $event->deskripsiEvent;
            $success['qrEvent'] = $event->qrEvent;
            $success['created_at'] = $event->created_at;
            $success['updated_at'] = $event->updated_at;
        }

        return response()->json( $success );
    }

    //fungsi untuk List My Event ( Event2 yang dibuat user dengan id = parameter )

    public function index2( $uid ) {
        $image_path = 'http://192.168.43.248/event_rest/storage/app/public/upload/brosur/';

        $events = DB::table( 'events' )->where( 'uid', $uid )->get();
        foreach ( $events as $event ) {
            if ( $event->brosurEvent != null ) {
                $event->brosurEvent = $image_path.$event->brosurEvent;

            }

        }

        $response['events'] = $events;
        $response['success'] = 1;
        return response()->json( $response );
    }

    //fungsi untuk List Mengikuti ( Event2 yang pernah diikuti ( dijoin ) oleh user dengan id = parameter )

    public function eventByUidMengikuti( $userId ) {

        $image_path = 'http://192.168.43.248/event_rest/storage/app/public/upload/brosur/';

        $tickets = DB::table( 'tickets' )->where( ['uidMengikuti'=>$userId] )
        ->join( 'events', 'tickets.eid', '=', 'events.id' )
        ->select( 'events.*' )
        ->get();

        foreach ( $tickets as $event ) {
            if ( $event->brosurEvent != null ) {
                $event->brosurEvent = $image_path.$event->brosurEvent;

            }

        }

        $response['events'] = $tickets;
        return response()->json( $response );
    }

    //fungsi Tambah Event

    public function createEvent( request $request ) {

        $input = $request->all();

        //simpan file image brosur ke ...\storage\app\public\upload\brosur\
        if ( $request->brosurEvent->storeAs( 'brosur', $input['brosurEvent']->getClientOriginalName(), 'upload' ) ) {

            $event = new Event;
            $event -> uid = $input['uid'];
            $event -> namaEvent = $input['namaEvent'];
            $event -> tanggalEvent = $input['tanggalEvent'];
            $event -> jamEvent = $input['jamEvent'];
            $event -> jumlahPesertaEvent = $input['jumlahPesertaEvent'];
            $event -> lokasiEvent = $input['lokasiEvent'];
            $event -> brosurEvent = $input['brosurEvent']->getClientOriginalName();
            $event -> deskripsiEvent = $input['deskripsiEvent'];
            $event -> save();
        }

        return response()->json( $event );
    }

}