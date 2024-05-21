<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;
use App\Models\User;

class InstitutesController extends Controller
 {

    public function __construct()
    {
        $this->middleware( 'auth' );
    }

    public function instudents($ins_id){
        $students = DB::table( 'students' )->select( 'students.*', 'district.district_name', 'medium.medium_name', 'section.section_name' )
        ->Join( 'district', 'district.id', '=', 'students.dist_id' )
        ->Join( 'medium', 'medium.id', '=', 'students.medium_id' )
        ->Join( 'section', 'section.id', '=', 'students.section_id' )
        ->where( 'user_id', '=', $ins_id )
        ->where( 'students.status', '=', 'Inactive' )
        ->orderBy( 'students.id', 'Asc' )->get(); 
        $managedistrict  = DB::table( 'district' )->orderBy( 'id', 'Asc' )->get();
        return view( 'institutes/instudents', compact( 'students', 'managedistrict','ins_id' ) );
    }

    public function institutes() {
        if ( Auth::user()->user_type_id == 1 ) {
            $institutes = DB::table( 'users' )->select( 'users.*', 'district.district_name')
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->where( 'users.user_type_id', 3 )->orderBy( 'users.id', 'Asc' )->get(); 
            } else {
            $user_id = Auth::user()->id;
            $institutes = DB::table( 'users' )->select( 'users.*', 'district.district_name')
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->where( 'users.user_type_id', 3 )->where( 'users.log_id',$user_id )->orderBy( 'users.id', 'Asc' )->get();
			}
				  
            $managedistrict  = DB::table( 'district' )->orderBy( 'id', 'Asc' )->get();

        return view( 'institutes/index', compact( 'institutes', 'managedistrict') );

    }
	
    public function addinstitute( Request $request )
    {
		$dist_id = $request->dist_id;
        $sql = "Select * from district where id = $dist_id order by id";
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $districtid = $result[ 0 ]->districtid;
            $short_name = $result[ 0 ]->short_name;
        }
		$uniqueId = rand( 111111111, 999999999 );
        $username = 'RJ' . $districtid . $short_name . $uniqueId;
        $cpassword = rand( 10001, 99999 );
        $password = Hash::make( $cpassword );
		
        $user_id = Auth::user()->id;
        $adduser = DB::table( 'users' )->insert( [
            'full_name' => $request->full_name,
            'email' => $request->email,
            'dist_id' => $dist_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'institution_type' => $request->institution_type,
            'username' => $username,
            'password' => $password,
            'cpassword' => $cpassword,
            'referral_id' => $user_id,
            'user_type_id' => 3,
            'status' => 'Active',
            'log_id' => $user_id
        ] );
         $insert_id = DB::getPdo()->lastInsertId();
        $institute_photo = "";

        if ( $request->institute_photo != null ) {
            $institute_photo = $insert_id . '.' . $request->file( 'institute_photo' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'institutephoto' . DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'institute_photo' ][ 'tmp_name' ], $filepath . $institute_photo );
        }
        DB::table( 'users' )->where( 'id', $insert_id )->update( [
            'institution_photo' => $institute_photo,
        ] );
        return redirect()->back()->with( 'success', 'Institute added Successfully' );
    }

    public function editinstitute( Request $request )
    {
        $id = $request->id;
        $dist_id = $request->dist_id;
        $full_name = $request->full_name;
        $phone = $request->phone;
        $email = $request->email;
        $cpassword = $request->password;
        $status = $request->status;
        $address = $request->address;
        $institutiontype = $request->institution_type;
        $password = Hash::make( $request->password );
        $sql = "update users set dist_id=$dist_id,full_name='$full_name',phone='$phone',email='$email',password='$password',cpassword='$cpassword',address='$address',status='$status',institution_type='$institutiontype' where id=$id";
        DB::update( $sql );


        if ( $request->institute_photo != null ) {
            $institute_photo = $id . '.' . $request->file( 'institute_photo' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'institutephoto' . DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'institute_photo' ][ 'tmp_name' ], $filepath . $institute_photo );

             DB::table( 'users' )->where( 'id', $id )->update( [
            'institution_photo' => $institute_photo,
        ] );
        }
       
        
        return redirect()->back()->with( 'success', 'Institute updated Successfully' );
    }
}