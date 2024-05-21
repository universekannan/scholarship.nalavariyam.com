<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;
use App\Models\User;

class JoinController extends Controller
 {


    public function home() {

        $cordinator  = DB::table( 'users' )->where('create_institution','=',1)->where('id','!=', 1)->orderBy( 'id', 'Asc' )->get();
        $instutites  = DB::table( 'users' )->where('user_type_id','=',3)->orderBy( 'id', 'Asc' )->get();
//print_r{$instutites};die;
        return view( 'welcome', compact( 'cordinator','instutites') );
     } 

	public function join($referral_id) {

        $managedistrict  = DB::table( 'district' )->orderBy( 'id', 'Asc' )->get();
        $managebanking  = DB::table( 'bank_details' )->orderBy( 'id', 'Asc' )->get();
        $managemedium  = DB::table( 'medium' )->orderBy( 'id', 'Asc' )->get();
        $ssection  = DB::table( 'section' )->where('id','<',100)->orderBy( 'id', 'Asc' )->get();
        $csection  = DB::table( 'section' )->where('id','>',100)->orderBy( 'id', 'Asc' )->get();
        $group  = DB::table( 'syllabus' )->orderBy( 'id', 'Asc' )->get();

        return view( 'users/join', compact( 'managedistrict', 'managebanking', 'managemedium','ssection','csection','group','referral_id' ) );

    }
	
    public function savejoin( Request $request )
 {
        $cpassword = rand( 10001, 99999 );
        $password = Hash::make( $cpassword );
        $dist_id = $request->dist_id;
        $sql = "Select * from district where id = $dist_id order by id";
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $districtid = $result[ 0 ]->districtid;
            $short_name = $result[ 0 ]->short_name;
        }

        $uniqueId = rand( 111111111, 999999999 );
        $username = 'RJ' . $districtid . $short_name . $uniqueId;
        $genders = $request->gender;
        if ( $genders == 'Male' ) {
            $photo = 'male.png';
        } else {
            $photo = 'female.png';
        }
        $union = $request->union;
        if ( $union == 'Yes' ) {
            $membertype = $request->membertype;
        } else {
            $membertype = $request->membertype2;
        }
        $category = $request->category;
        $section_id = 0;
        if($category == "School"){
            $section_id = $request->ssection;
        }else{
            $section_id = $request->csection;
        }
        $addcustomer = DB::table( 'students' )->insert( [
            'student_name' => $request->student_name,
            'father_name' => $request->father_name,
            'cell_number' => $request->cell_number,
            'adhaar_number' => $request->adhaar_number,
            'gender' => $genders,
            'db' => $request->db,
            'medium_id' => $request->medium_id,
            'section_id' => $section_id,
            'category' => $category,
            'school_name' => $request->school_name,
            'union_type' => $union,
            'membertype' => $membertype,
            'member_id_number' => $request->id_number,
            'registration_no' => $request->reg_number,
            'parent_aadhaar_no' => $request->parent_aadhaar,
            'dist_id' => $dist_id,
            'bank_details' => $request->bank_details,
            'branch_name' => $request->branch_name,
            'ac_number' => $request->ac_number,
            'ifsc' => $request->ifsc_number,
            'account_holder_name' => $request->account_holder_name,
            'user_id' => $request->referral_id,
            'username' => $username,
            'cpassword' => $cpassword,
            'password' => $password,
            'status' => 'Inactive',
            'photo' => $photo,
        ] );
        $insert_id = DB::getPdo()->lastInsertId();
        $billorid = '';
        $studentidcard = '';

        if ( $request->studentidcard != null ) {
            $studentidcard = $insert_id . '.' . $request->file( 'studentidcard' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'student' . DIRECTORY_SEPARATOR . 'studentidcard' .DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'studentidcard' ][ 'tmp_name' ], $filepath . $studentidcard );
        }
        DB::table( 'students' )->where( 'id', $insert_id )->update( [
            'studentidcard' => $studentidcard,
        ] );

        if ( $union == 'Yes' ) {
            if ( $request->billorid != null ) {
                $billorid = $insert_id . '.' . $request->file( 'billorid' )->extension();
                $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'student' . DIRECTORY_SEPARATOR . 'billorid' .DIRECTORY_SEPARATOR );
                move_uploaded_file( $_FILES[ 'billorid' ][ 'tmp_name' ], $filepath . $billorid );
            }
            DB::table( 'students' )->where( 'id', $insert_id )->update( [
                'bill_or_id' => $billorid,
            ] );

        }

        return redirect( '/students' )->with( 'success', 'Add Members Successfully ... !' );
    }



    public function getsection( Request $request )
 {
        $getsection = DB::table( 'section' )->where( 'medium_id', $request->medium_id )->orderBy( 'id', 'Asc' )->get();
        return response()->json( $getsection );
    }

    public function getsyllabus( Request $request )
 {
        $sectionid = $request->section_id;
        $mediumid = $request->medium_id;
        if ( $mediumid == 1 ) {
            if ( $sectionid == 6 || $sectionid == 7 ) {
                $getsyllabus = DB::table( 'syllabus' )->where( 'section_id', 1 )->orderBy( 'id', 'Asc' )->get();
            }
        } else {
            $getsyllabus = DB::table( 'syllabus' )->where( 'section_id', 2 )->orderBy( 'id', 'Asc' )->get();
        }

        return response()->json( $getsyllabus );
    }



    public function duplicate_username( Request $request )
 {
        $username = trim( $request->username );
        $id = trim( $request->id );
        if ( $id == 0 ) {
            $sql = "SELECT * FROM users where username='$username'";
        } else {
            $sql = "SELECT * FROM users where username='$username' and id <> $id";
        }
        $users = DB::select( DB::raw( $sql ) );
        if ( count( $users ) > 0 ) {
            return response()->json( array( 'exists' => true ) );
        } else {
            return response()->json( array( 'exists' => false ) );
        }
    }


    public function gettaluk( Request $request )
 {

        $gettaluk = DB::table( 'taluk' )->where( 'parent', $request->taluk_id )->orderBy( 'id', 'Asc' )->get();
        return response()->json( $gettaluk );
    }


}
