<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Event;
use App\Http\Controllers\Controller;
use DB;



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

        $ticket = new Ticket;
        $ticket->eid = $request->eid;
        $ticket->uid = $request->uid;
        $ticket->qrCode = $request->qrCode;
        $ticket->save();

        return "sukses";
    }
}
