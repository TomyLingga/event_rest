<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use DB;
use QrCode;


class TicketController extends Controller
{
    public function index($idevent){

        $tickets = Event::findOrFail($idevent)->tickets;

        foreach ($tickets as $ticket) {
            $ticket['user'] = $ticket->user;
        }

        return response()->json($tickets);
        
    }

    public function create(request $request){

        $generateQr = QrCode::size(500)
                    ->format('png')
                    ->generate('Welcome to kerneldev.com!', public_path('../storage/app/qr/qrcode2.png'));
         
        $qr = $generateQr->storeAs('../storage/app/qr', $generateQr->getCLientOriginalName());
        //$qr = Storage::get('qr/qrcode2.png');  

        $ticket = new Ticket;
        $ticket->eid = $request->eid;
        $ticket->uid = $request->uid;
        $ticket->qrCode = $qr;
        $ticket->save();

        $response["qr"] = $qr;
           $response["success"] = 1;
           return response()->json($response);



        //    if($request->gambar->storeAs('kue', $input['gambar']->getClientOriginalName(), 'upload')){
        //     $data = new Cake;
        //     $data -> nama = $input['nama'];
        //     $data -> deskripsi = $input['deskripsi'];
        //     $data -> harga = $input['harga'];
        //     $data -> stok = $input['stok'];
        //     $data -> kategori = $input['kategori'];
        //     $data -> gambar = $input['gambar']->getClientOriginalName();
        //     $data -> save();
        //     }
    }
}


