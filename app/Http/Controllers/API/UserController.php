<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
class UserController extends Controller 
{
public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 

    //function login 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){  //cek email dan password yang sama
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; //set $success['token'] dengan token user yang didapat
            $success['name'] =  $user->name;                                //set $success['name'] dengan nama user yang didapat
            $success['email'] =  $user->email;                              //set $success['email'] dengan email user yang didapat
            $success['id'] =  $user->id;                                    //set $success['id'] dengan id user yang didapat
            return response()->json($success);                              //return data user
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401);        //kalau tidak ada email dan password yang cocok return 401 Unauthorized error
        } 
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [                         //ambil nama, email, dan password yang diinput
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required|min:8', 
            'cpassword' => 'required|same:password',                            //password dan cpassword(confirm password) harus sama
        ]);
if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);      // jika gagal return $validator error 401      
        }
        $input = $request->all();                                               // jika berhasil input ke database
        $input['password'] = bcrypt($input['password']);            
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
        $success['id'] = $user->id;
        
        return response()->json(['success'=>$success], $this-> successStatus); 
    }
/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 
}