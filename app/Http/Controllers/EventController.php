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
    public function index(){
        //$date_string = "06 December 2019";
        $image_path = "http://192.168.43.248/event_rest/storage/app/public/upload/brosur/";
        $events  = DB::table('events')
                        ->latest()
                        ->get();
 
        foreach ($events as $key => $event) {
            $event->brosurEvent = $image_path.$event->brosurEvent;     
        }

        $response["events"] = $events;
        $response["success"] = 1;
        return response()->json($response);
    }
    
    public function index1($id, $userId){
        $image_path = "http://192.168.43.248/event_rest/storage/app/public/upload/brosur/";

        $event  = DB::table('events')->find($id);

        if($event->brosurEvent != null){
            $event->brosurEvent = $image_path.$event->brosurEvent;            
        }

        $jlh_peserta =  DB::table('tickets')->where(['eid'=>$id])
            ->count();
      
        if(Ticket::where([
                    'uidMengikuti'=> $userId,
                    'eid'=>$id,
                ])->exists()){
                    $success['jumlahPeserta'] = $jlh_peserta;
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

        return response()->json($success);
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

    public function eventByUidMengikuti($userId){

        $image_path = "http://192.168.43.248/event_rest/storage/app/public/upload/brosur/";

        $tickets = DB::table('tickets')->where(['uidMengikuti'=>$userId])
        ->join('events','tickets.eid','=','events.id')
        ->select('events.*')
        ->get();

        foreach ($tickets as $event) {
            if($event->brosurEvent != null){
                $event->brosurEvent = $image_path.$event->brosurEvent;            
            }   
        }

        $response["events"] = $tickets;
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



// public function index(){
//     //$date_string = "06 December 2019";
//     $image_path = "http://192.168.43.248/event_rest/storage/app/public/upload/brosur/";
//     $events  = DB::table('events')
//             // ->where(strtotime($events->tanggalEvent) < time() - (72*60*60))
//             ->latest()
//             ->get();
//     // if (strtotime($date_string) <= time()- (72*60*60)){
//     //     $response["success"] = "dah lewat";
//     // }else{
//     //     $response["success"] = "belum lewat";
//     // }
    
//     foreach ($events as $key => $event) {
//     //     if (strtotime($event->tanggalEvent) < time() - (72*60*60)){
//     //         unset ($events[$key]);
//     //         // dd(time().time() - (72*60*60));
//     //     }else{
//             $event->brosurEvent = $image_path.$event->brosurEvent;
//         // }       
//     }

//     $response["events"] = $events;
//     $response["success"] = 1;
//     return response()->json($response);
// }