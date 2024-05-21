<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;
use Session;

class StudentLoginController extends Controller
{


    public function join($referral_id) {


        $managedistrict  = DB::table( 'district' )->orderBy( 'id', 'Asc' )->get();
        $managebanking  = DB::table( 'bank_details' )->orderBy( 'id', 'Asc' )->get();
        $managemedium  = DB::table( 'medium' )->orderBy( 'id', 'Asc' )->get();
        $ssection  = DB::table( 'section' )->where('id','<',100)->orderBy( 'id', 'Asc' )->get();
        $csection  = DB::table( 'section' )->where('id','>',100)->orderBy( 'id', 'Asc' )->get();
        $group  = DB::table( 'syllabus' )->orderBy( 'id', 'Asc' )->get();

        return view( 'users/join', compact( 'managedistrict', 'managebanking', 'managemedium','ssection','csection','group','referral_id') );

    }

    public function checkaadhar( Request $request )
 {
        $aadhar = trim( $request->aadhar );
        $id = trim( $request->id );
        if ( $id == 0 ) {
            $sql = "SELECT * FROM students where adhaar_number='$aadhar'";
        } else {
            $sql = "SELECT * FROM students where adhaar_number='$aadhar' and id <> $id";
        }
        $users = DB::select( DB::raw( $sql ) );
        if ( count( $users ) > 0 ) {
            return response()->json( array( 'exists' => true ) );
        } else {
            return response()->json( array( 'exists' => false ) );
        }
    }

    public function savejoin( Request $request )
    {
        $message = '';
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
            'union_type' => "No",
            'membertype' => "Self",
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


        $sql = "select * from students where username='$username' and status='Inactive'";
        $result = DB::select( DB::raw( $sql ) );
        Session::put( 'id', $result[ 0 ]->id );
        Session::put( 'medium_id', $result[ 0 ]->medium_id );
        Session::put( 'section_id', $result[ 0 ]->section_id );
        Session::put( 'student_name', $result[ 0 ]->student_name );
        Session::put( 'father_name', $result[ 0 ]->father_name );
        Session::put( 'photo', $result[ 0 ]->photo );
        Session::put( 'status', $result[ 0 ]->status );
        Session::put( 'password', $result[ 0 ]->password );
        return redirect( '/studentdashboard' )->with( 'message', $message );
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




    public function studentlogin()
    {
        return view( 'student/studentlogin' );
    }


    public function checklogin( Request $request )
    {

        $message = '';
        $username = trim( $request->username );
        $password = trim( $request->password );

        $sql = "select * from students where username='$username'";
        $result = DB::select( DB::raw( $sql ) );
        $hash = '';
        if ( count( $result ) > 0 ) {
            $hash = $result[ 0 ]->password;
        }
        if ( Hash::check( $password, $hash ) ) {
            if ( count( $result ) > 0 ) {
                Session::put( 'id', $result[ 0 ]->id );
                Session::put( 'medium_id', $result[ 0 ]->medium_id );
                Session::put( 'section_id', $result[ 0 ]->section_id );
                Session::put( 'student_name', $result[ 0 ]->student_name );
                Session::put( 'father_name', $result[ 0 ]->father_name );
                Session::put( 'photo', $result[ 0 ]->photo );
                Session::put( 'status', $result[ 0 ]->status );
                Session::put( 'password', $result[ 0 ]->password );
                return redirect( '/studentdashboard' )->with( 'message', $message );
            } else {
                $message = 'Login Failed';
                return redirect( '/studentlogin' )->with( 'message', $message );
            }
        } else {
            $message = 'Incorrect Password';
            return redirect( '/studentlogin' )->with( 'message', $message );
        }
    }

    public function studentlogout()
    {
        Session::flush();
        return redirect( '/studentlogin' );
    }
}