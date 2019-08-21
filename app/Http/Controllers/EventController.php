<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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

                $input = $request->all();
                
                if($request->brosurEvent->storeAs('brosur', $input['brosurEvent']->getClientOriginalName(), 'upload')){
                    $event = new Event;
                    $event -> namaEvent = $input['namaEvent'];
                    $event -> tanggalEvent = $input['tanggalEvent'];
                    $event -> jamEvent = $input['jamEvent'];
                    $event -> jumlahPesertaEvent = $input['jumlahPesertaEvent'];
                    $event -> lokasiEvent = $input['lokasiEvent'];
                    $event -> brosurEvent = $input['brosurEvent']->getClientOriginalName();
                    $event -> deskripsiEvent = $input['deskripsiEvent'];
                    //$event -> qrEvent = NULL;
                    $event -> save();
                }
                
                return response()->json($event);

            
        
            }
        
            public function updateEvent(Request $request, $id){
               
            }  
            public function deleteEvent(){
                
            }

}