<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Query\Builder;
use DB;

class EventController extends Controller
{

    
    
     public function index(){
        $image_path = "http://192.168.43.248/event_rest/storage/app/public/upload/brosur/";
        $events  = DB::table('events')->get();

        foreach ($events as $event) {
            $event->brosurEvent = $image_path.$event->brosurEvent;    
        }

        $response["events"] = $events;
        $response["success"] = 1;
        return response()->json($response);
     }
    
    public function index1($id){
        $image_path = "http://192.168.43.248/event_rest/storage/app/public/upload/brosur/";

        $event  = DB::table('events')->find($id);

        if($event->brosurEvent != null){
            $event->brosurEvent = $image_path.$event->brosurEvent;            
        }
        
        //$response["event"] = ;
           //$response["success"] = 1;
           return response()->json($event);
    }

    public function index2($uid){
        $image_path = "http://192.168.43.248/event_rest/storage/app/public/upload/brosur/";

        $events = DB::table('events')->where('uid', $uid)->get();
        foreach ($events as $event) {
            if($event->brosurEvent != null){
                $event->brosurEvent = $image_path.$event->brosurEvent;            
            }   
        }

        $response["events"] = $events;
        $response["success"] = 1;
        return response()->json($response);
    }
        

    public function createEvent(request $request){


        $input = $request->all();
                
        if($request->brosurEvent->storeAs('brosur', $input['brosurEvent']->getClientOriginalName(), 'upload')){
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
                
        return response()->json($event);
    }
        
    public function updateEvent(Request $request, $id){
               
    }  
    public function deleteEvent(){
                
    }

}