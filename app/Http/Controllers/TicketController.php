<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use PDF;

class TicketController extends Controller
 {

    //fungsi untuk mengambil list2 user yang join suatu event dengan parameter idevent

    public function index( $idevent ) {

        $tickets = DB::table( 'tickets' )->where( ['eid'=>$idevent] )
        ->join( 'users', 'tickets.uidMengikuti', '=', 'users.id' )       //ambil data semua user yang sudah join event yang idnya = parameter
        ->get();

        $response['peserta'] = $tickets;
        return response()->json( $response );
    }

    public function cetak_pdf( $idevent ) {

        $tickets = DB::table( 'tickets' )->where( ['eid'=>$idevent] )
        ->join( 'users', 'tickets.uidMengikuti', '=', 'users.id' )       //ambil data semua user yang sudah join event yang idnya = parameter
        ->get();

        $pdf = PDF::loadview('peserta_pdf',['tickets'=>$tickets]);
        
    	return $pdf->download('list-peserta'.date('Y-m-d_H-i-s').'.pdf');
        // $response['peserta'] = $tickets;
        // return response()->json( $response );
    }

    //fungsi untuk mengambil tiket seorang user dari suatu event dengan parameter id event dan id user yang mengikuti

    public function indexById( $eid, $uidMengikuti ) {

        $tickets = DB::table( 'tickets' )->where( [
            'eid'=>$eid,
            'uidMengikuti'=>$uidMengikuti
        ] )->first();

        return response()->json( $tickets );
    }

    //fungsi untuk scan

    public function scan( $qrCode ) {

        $tickets = DB::table( 'tickets' )->where( ['qrCode'=>$qrCode] )
        ->update( ['kehadiran' => true] );
        //jika data qrCode pada tabel tickets = parameter, set kehadiran jadi true

        $response['peserta'] = $tickets;
        return response()->json( $response );
    }

    //fungsi untuk buat tiket ( ketika user nge join suatu event )

    public function create( request $request ) {
        $time = Carbon::now();
        // ambil waktu sekarang tampung ke time
        $ticket = new Ticket;
        if ( isset( $request->eid ) && isset( $request->uidMengikuti ) ) {
            if ( Ticket::where( [
                'uidMengikuti'=>$request->uidMengikuti,
                'eid'=>$request->eid,
            ] )->exists() ) {
                // kalau user sudah pernah join event ini sebelumnya, maka cuma return data yang sudah ada saja
                return 'data ADA';
                // dan tidak ditambah data baru ke database
            } else {
                $ticket->eid = $request->eid;
                $ticket->uidMengikuti = $request->uidMengikuti;
                $qrString = $ticket->eid.$ticket->uidMengikuti.$time;
                // data qr berupa eventid ditambah user id yang mengikuti event tsb ditambah waktu sekarang
                $hashed = md5( $qrString );
                // kemudian di hash
                $ticket->qrCode = $hashed;
                $ticket->save();
                return $qrString.'  sukses';
            }

        } else {
            return 'gagal';
        }

    }
}
