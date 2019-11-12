<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;



class TicketController extends Controller
{
    public function index($idevent){

        $tickets = DB::table('tickets')->where(['eid'=>$idevent])
        ->join('users','tickets.uid','=','users.id')
        ->get();

        $response["peserta"] = $tickets;
        return response()->json($response);
    }

    public function indexById($eid, $uid){

        $tickets = DB::table('tickets')->where([
            'eid'=>$eid,
            'uid'=>$uid
        ])->first();

        return response()->json($tickets);
    }

    public function scan($qrCode){

        $tickets = DB::table('tickets')->where(['qrCode'=>$qrCode])
                   ->update(['kehadiran' => true]);

        $response["peserta"] = $tickets;
        return response()->json($response);
    }

    public function create(request $request){
        $time = Carbon::now();
        $ticket = new Ticket;
        if(isset($request->eid) && isset($request->uid)){
            if(Ticket::where([
                            'uid'=>$request->uid,
                            'eid'=>$request->eid,
                        ])->exists()){
                            return "data ADA";
            }else{
                $ticket->eid = $request->eid;
                        $ticket->uid = $request->uid;
                        $qrString = $ticket->eid.$ticket->uid.$time;
                        $hashed = md5($qrString);
                        $ticket->qrCode = $hashed;
                        $ticket->save();
                            return $qrString."  sukses";
            }
                
        }else{
            return "gagal";
        }       
    }
}
