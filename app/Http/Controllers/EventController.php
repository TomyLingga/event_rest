<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Http\Controllers\Controller;
use DB;

class EventController extends Controller
{
    public function index(){
        $event  = DB::table('events')->get();
           $response["events"] = $event;
           $response["success"] = 1;
           return response()->json($response);
    }
    
    public function index1($id){
        $event  = DB::table('events')->find($id);
        $response["event2"] = $event;
           $response["success"] = 1;
           return response()->json($response);
        }
        

            public function createEvent(request $request){
                
                $event = new Event;
                $event->namaEvent = $request->namaEvent;
                $event->tanggalEvent = $request->tanggalEvent;
                $event->jamEvent = $request->jamEvent;
                $event->jumlahPesertaEvent = $request->jumlahPesertaEvent;
                $event->lokasiEvent = $request->lokasiEvent;
                $event->brosurEvent = $request->brosurEvent;
                $event->deskripsiEvent = $request->deskripsiEvent;
                $event->qrEvent = $request->qrEvent;
                $event->save();

                return response()->json($event);
        
            }
        
            public function updateEvent(Request $request, $id){
               
            }  
            public function deleteEvent(){
                
            }

}