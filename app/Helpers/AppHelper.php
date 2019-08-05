<?php
namespace App\Helpers;
use DB;

class AppHelper
{

     public static function uidToName($id)
     {
        //  $id = preg_replace("/[^0-9]/", '', $ticket);
        $haha = DB::table('users')->select('name')
        ->where('id', '=',$id)->get();
        return $haha;
     }

     public static function generateQR(){
        QrCode::generate('Make me into a QrCode!');

     }

     public function showQueries()
     {
          dd(\DB::getQueryLog());
     }

     public static function instance()
     {
         return new AppHelper();
     }
}