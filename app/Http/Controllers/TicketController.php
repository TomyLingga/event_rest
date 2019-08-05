<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Http\Controllers\Controller;
use DB;



class TicketController extends Controller
{
    public function index($eid){

        $ticket  = DB::table('tickets')->select('uid')->where('eid', '=',$eid)->get();
        
        foreach ($ticket as $p) {
            
            $id = preg_replace("/[^0-9]/", '', $ticket);   //untuk ambil hanya id karna diatas ambilnya "uid : id user"
            $tickets = \App\Helpers\AppHelper::uidToName($id); // panggil funct helper dengan parameter id
            }


        $response["ticket"] = $ticket;
        // $response["id"] = $id;
        $response["tickets"] = $tickets;
        //$response["p"] = $p;
           //$response["success"] = 1;
           return response()->json($response);
    }

    public function create(request $request){

        $ticket = new Ticket;
        $ticket->eid = $request->eid;
        $ticket->uid = $request->uid;
        $ticket->qrCode = $request->qrCode;
        $ticket->save();

        return "sukses";
    }
}


