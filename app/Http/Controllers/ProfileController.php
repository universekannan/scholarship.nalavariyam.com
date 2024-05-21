<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;
use App\Models\User;

class ProfileController extends Controller
{

  public function __construct()
  {
   $this->middleware( 'auth' );
 }
 
 public function profile()
 {
  $userid = Auth::user()->id; 
  $profile = DB::table('users')->where('id','=', $userid)->get();
  return view('users/profile', compact('profile'));

}
public function updateprofile(Request $request){
  $userid = Auth::user()->id; 
  $updateprofile = DB::table( 'users' )->where('id',$userid)->update([
    'full_name'  => $request->full_name,
    'phone'      => $request->phone,
  ]);

   if ( $request->tailoring_ins_signature != null ) {
            $signature = $userid . '.' . $request->file( 'tailoring_ins_signature' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'tailoring' . DIRECTORY_SEPARATOR . 'signature' . DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'tailoring_ins_signature' ][ 'tmp_name' ], $filepath . $signature );

            DB::table( 'users' )->where( 'id', $userid )->update( [
                'tailoring_ins_signature' => $signature,
            ] );
        }

         if ( $request->tailoring_ins_agreement != null ) {
            $agreement = $userid . '.' . $request->file( 'tailoring_ins_agreement' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'tailoring' . DIRECTORY_SEPARATOR . 'agreement' . DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'tailoring_ins_agreement' ][ 'tmp_name' ], $filepath . $agreement );

            DB::table( 'users' )->where( 'id', $userid )->update( [
                'tailoring_ins_agreement' => $agreement,
            ] );
        }
  return redirect('dashboard')->with('success', 'Profile updated successfully');
}
}
