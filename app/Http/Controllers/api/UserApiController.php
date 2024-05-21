<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;

class UserApiController extends Controller
{
    public function createuser(Request $request){
        $API_KEY = env('API_KEY','');
        $key = $request->key;
        $response = array();
        $message = "";
		$username = trim($request->username);
		$sql = "select * from users where username = '$username'";
		$result = DB::select($sql);
		if(count($result) > 0){
			
		}else{
        if($key == $API_KEY){
            DB::table('users')->insert( [
                'full_name' => $request->full_name,
                'username' => trim($username),
                'password' => Hash::make($request->password),
                'cpassword' => $request->password,
                'dist_id' => $request->dist_id,
                'taluk_id' => $request->taluk_id,
                'referral_id' => 1,
                'phone' => $request->phone,
                'user_type_id' => 2,
                'status' => 'Active',
                'user_photo' => 'user.jpg',
                'log_id' => 1
            ]);
            $message = "success";
        }else{
            $message = "Access Denied";
        }
		}
        $response["message"] = $message;
        return response()->json($response);
    }

    public function importusers(){
        $sql = "select id,username,full_name,dist_id,taluk_id,phone from scholarship_nalavariyam.users where scholarship_nalavariyam.user_type_id = 2 and scholarship_nalavariyam.referral_id = 1 and scholarship_nalavariyam.username not in (select username from laravel_nalavariyam.users) order by id;";
        $result = DB::select($sql);
        foreach ($result as $res) {
            echo $res->id." ".$res->username." ".$res->full_name."<br>";
            /*DB::table('users')->insert( [
                'full_name' => $res->full_name,
                'username' => $res->username,
                'password' => Hash::make($res->pas),
                'cpassword' => $res->pas,
                'dist_id' => $res->dist_id,
                'taluk_id' => $res->taluk_id,
                'referral_id' => 1,
                'phone' => $res->phone,
                'user_type_id' => 2,
                'status' => 'Active',
                'user_photo' => 'user.jpg',
                'log_id' => 1
            ]);*/
        }
        
    }


   
}
