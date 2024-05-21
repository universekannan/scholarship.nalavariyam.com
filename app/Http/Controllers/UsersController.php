<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;
use App\Models\User;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware( 'auth' );
    }

    public function students()
    {
        $user_id = Auth::user()->id;
        if ( Auth::user()->user_type_id == 1 ) {
            $students = DB::table( 'students' )->select( 'students.*', 'district.district_name', 'medium.medium_name', 'section.section_name' )
            ->Join( 'district', 'district.id', '=', 'students.dist_id' )
            ->Join( 'medium', 'medium.id', '=', 'students.medium_id' )
            ->Join( 'section', 'section.id', '=', 'students.section_id' )
            ->orderBy( 'students.id', 'Asc' )->get();
        } else {
            $students = DB::table( 'students' )->select( 'students.*', 'district.district_name',  'medium.medium_name', 'section.section_name' )
            ->Join( 'district', 'district.id', '=', 'students.dist_id' )
            ->Join( 'medium', 'medium.id', '=', 'students.medium_id' )
            ->Join( 'section', 'section.id', '=', 'students.section_id' )
            ->where( 'user_id', '=', $user_id )
            ->orderBy( 'students.id', 'Asc' )->get();

        }
        $managedistrict  = DB::table( 'district' )->orderBy( 'id', 'Asc' )->get();

        return view( 'users/students', compact( 'students', 'managedistrict' ) );
    }

    public function usummary()
    {
        $user_id = Auth::user()->id;
        $sql="";
        if ( Auth::user()->user_type_id == 1 ) {
            $sql="select count(*) as usrcnt,a.user_id,a.status from students a,users b where a.user_id = b.id and b.user_type_id = 2 group by a.user_id,a.status order by a.user_id,a.status";
        } else {
            $sql="select count(*) as usrcnt,a.user_id,a.status from students a,users b where a.user_id = b.id and b.user_type_id = 2 and a.user_id = $user_id group by a.user_id,a.status order by a.user_id,a.status";
        }
        //echo $sql;die;
        $students = DB::select($sql);
        $students = json_decode(json_encode($students),true);
        foreach($students as $key => $s){
            $user_id = $s["user_id"];
            $students[$key]['full_name']="";
            $students[$key]['username']="";
            $sql2 = "select full_name,username from users where id=$user_id";
            $result2 = DB::select(DB::raw($sql2));
            foreach($result2 as $res){
                $students[$key]['full_name']=$res->full_name;
                $students[$key]['username']=$res->username;
            }
        }
        $students = json_decode(json_encode($students));
       
        $user_id=0;
        $students2 = array();
        $i=-1;
        foreach($students as $s){
            if($user_id != $s->user_id){
                $i++;
                $students2[$i]["user_id"] = "";
                $students2[$i]["full_name"] = "";
                $students2[$i]["username"] = "";
                $students2[$i]["active"] = 0;
                $students2[$i]["inactive"] = 0;
            }
            $students2[$i]["user_id"] = $s->user_id;
            $students2[$i]["full_name"] = $s->full_name;
            $students2[$i]["username"] = $s->username;
            if($s->status == "Active"){
                $students2[$i]["active"] = $s->usrcnt;
            }
            if($s->status == "Inactive"){
                $students2[$i]["inactive"] = $s->usrcnt;
            }
            $user_id = $s->user_id; 
        }
        return view( 'users/usersummary', compact( 'students2'));
    }

     public function institutesummary()
    {
        $user_id = Auth::user()->id;
        $sql="";
        if ( Auth::user()->user_type_id == 1 ) {
            $sql="select count(*) as usrcnt,a.user_id,a.status from students a,users b where a.user_id = b.id and b.user_type_id = 3 group by a.user_id,a.status order by a.user_id,a.status";
        } else {
            $sql="select count(*) as usrcnt,a.user_id,a.status from students a,users b where a.user_id = b.id and b.user_type_id = 3 and a.user_id = $user_id group by a.user_id,a.status order by a.user_id,a.status";
        }
        //echo $sql;die;
        $students = DB::select($sql);
        $students = json_decode(json_encode($students),true);
        foreach($students as $key => $s){
            $user_id = $s["user_id"];
            $students[$key]['full_name']="";
            $students[$key]['username']="";
            $sql2 = "select full_name,username,referral_id from users where id=$user_id";
            $result2 = DB::select(DB::raw($sql2));
            foreach($result2 as $res){
                $students[$key]['full_name']=$res->full_name;
                $students[$key]['username']=$res->username;
                $students[$key]['referral_id']=$res->referral_id;
            }
        }
        $students = json_decode(json_encode($students));
       
        $user_id=0;
        $students2 = array();
        $i=-1;
        foreach($students as $s){
            if($user_id != $s->user_id){
                $i++;
                $students2[$i]["user_id"] = "";
                $students2[$i]["full_name"] = "";
                $students2[$i]["username"] = "";
                $students2[$i]["referral_id"] = "";
                $students2[$i]["active"] = 0;
                $students2[$i]["inactive"] = 0;
            }
            $students2[$i]["user_id"] = $s->user_id;
            $students2[$i]["full_name"] = $s->full_name;
            $students2[$i]["username"] = $s->username;
            $students2[$i]["referral_id"] = $s->referral_id;
            if($s->status == "Active"){
                $students2[$i]["active"] = $s->usrcnt;
            }
            if($s->status == "Inactive"){
                $students2[$i]["inactive"] = $s->usrcnt;
            }
            $user_id = $s->user_id; 
        }
        return view( 'institutes/institutesummary', compact( 'students2'));
    }

    public function ssummary()
    {
        $user_id = Auth::user()->id;
        $sql="";
        if ( Auth::user()->user_type_id == 1 ) {
            $sql="select count(*) as discnt,dist_id,status from students group by dist_id,status order by dist_id,status";
        } else {
            $sql="select count(*) as discnt,dist_id,status from students group by dist_id,status where user_id=$user_id order by dist_id,status";
        }
        $students = DB::select($sql);
        $students = json_decode(json_encode($students),true);
        foreach($students as $key => $s){
            $dist_id = $s["dist_id"];
            $sql2 = "select district_name from district where id=$dist_id";
            $result2 = DB::select(DB::raw($sql2));
            foreach($result2 as $res){
                $students[$key]['district_name']=$res->district_name;
            }
        }
        $students = json_decode(json_encode($students));
        $dist_id=0;
        $students2 = array();
        $i=-1;
        foreach($students as $s){
            if($dist_id != $s->dist_id){
                $i++;
                $students2[$i]["dist_id"] = "";
                $students2[$i]["district_name"] = "";
                $students2[$i]["active"] = 0;
                $students2[$i]["inactive"] = 0;
            }
            $students2[$i]["dist_id"] = $s->dist_id;
            $students2[$i]["district_name"] = $s->district_name;
            if($s->status == "Active"){
                $students2[$i]["active"] = $s->discnt;
            }
            if($s->status == "Inactive"){
                $students2[$i]["inactive"] = $s->discnt;
            }
            $dist_id = $s->dist_id; 
        }
        return view( 'users/summary', compact( 'students2'));
    }

    public function addstudent() {

        $managedistrict  = DB::table( 'district' )->orderBy( 'id', 'Asc' )->get();

        $managebanking  = DB::table( 'bank_details' )->orderBy( 'id', 'Asc' )->get();
        $managemedium  = DB::table( 'medium' )->orderBy( 'id', 'Asc' )->get();
        $ssection  = DB::table( 'section' )->where('id','<',100)->orderBy( 'id', 'Asc' )->get();
        $csection  = DB::table( 'section' )->where('id','>',100)->orderBy( 'id', 'Asc' )->get();
        $group  = DB::table( 'syllabus' )->orderBy( 'id', 'Asc' )->get();

        return view( 'users/addstudent', compact( 'managedistrict', 'managebanking', 'managemedium','ssection','csection','group' ) );

    }

    public function savestudent( Request $request )
    {
        $cpassword = rand( 10001, 99999 );
        $password = Hash::make( $cpassword );
        $user_id = Auth::user()->id;
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
            'user_id' => $user_id,
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

    public function editstudent( $id ) {
        $user_id = Auth::user()->id;
        $check = DB::table( 'students' )->select( 'user_id' )->where( 'id', '=', $id )->first();
        if ( Auth::user()->user_type_id != 1 ) {
            if ( empty( $check ) ) {
                return redirect( '/students' )->with( 'error', 'You Dont Have Permission To Access ... !' );
            }
            if ( $user_id != $check->user_id ) {
                return redirect( '/students' )->with( 'error', 'You Dont Have Permission To Access ... !' );

            }
        }
        $checkusers = DB::table( 'users' )->select( 'user_type_id' )->where( 'id', '=', $check->user_id )->first();
        $institutestudent = 0;
        if($checkusers->user_type_id == 3){
            $institutestudent = 1;
        }

        if ( Auth::user()->user_type_id == 1 ) {
            $edit  = DB::table( 'students' )->select( 'students.*', 'users.user_type_id')
            ->Join( 'users', 'users.id', '=', 'students.user_id' )->where( 'students.id', '=', $id )->first();
        } else {
            $edit  = DB::table( 'students' )->select( 'students.*', 'users.user_type_id')
            ->Join( 'users', 'users.id', '=', 'students.user_id' )->where( 'students.id', '=', $id )->where( 'students.user_id', '=', $user_id )->first();
        }
        $medium_id = $edit->medium_id;
        $section_id = $edit->section_id;
        $ssection  = DB::table( 'section' )->where('id','<',100)->orderBy( 'id', 'Asc' )->get();
        $csection  = DB::table( 'section' )->where('id','>',100)->orderBy( 'id', 'Asc' )->get();
        $managedistrict  = DB::table( 'district' )->orderBy( 'id', 'Asc' )->get();
        $managemedium  = DB::table( 'medium' )->orderBy( 'id', 'Asc' )->get();
        $managebanking  = DB::table( 'bank_details' )->orderBy( 'id', 'Asc' )->get();
        $managesyllabus = array();
        if ( $medium_id == 1 ) {
            if ( $section_id == 6 || $section_id == 7 ) {
                $managesyllabus = DB::table( 'syllabus' )->where( 'section_id', 1 )->orderBy( 'id', 'Asc' )->get();
            }
        } else {
            $managesyllabus = DB::table( 'syllabus' )->where( 'section_id', 2 )->orderBy( 'id', 'Asc' )->get();
        }
        //print_r( $editstudent );
        // die;
        return view( 'users/editstudent', compact( 'edit', 'managedistrict', 'managemedium', 'managebanking', 'ssection', 'csection','managesyllabus','institutestudent' ) );
    }


    public function join($referral_id) {

        $managedistrict  = DB::table( 'district' )->orderBy( 'id', 'Asc' )->get();
        $managebanking  = DB::table( 'bank_details' )->orderBy( 'id', 'Asc' )->get();
        $managemedium  = DB::table( 'medium' )->orderBy( 'id', 'Asc' )->get();
        $ssection  = DB::table( 'section' )->where('id','<',100)->orderBy( 'id', 'Asc' )->get();
        $csection  = DB::table( 'section' )->where('id','>',100)->orderBy( 'id', 'Asc' )->get();
        $group  = DB::table( 'syllabus' )->orderBy( 'id', 'Asc' )->get();

        return view( 'users/join', compact( 'managedistrict', 'managebanking', 'managemedium','ssection','csection','group','$referral_id' ) );

    }

    public function savejoin( Request $request )
    {
        $cpassword = rand( 10001, 99999 );
        $password = Hash::make( $cpassword );
        $user_id = Auth::user()->id;
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
            'referral_id' => $request->referral_id,
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
            'user_id' => $user_id,
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

    public function updatestudent( Request $request )
    {

        $user_id = Auth::user()->id;
        $genders = $request->gender;
        if ( $genders == 'Male' ) {
            $photo = 'mail.jpg';
        } else {
            $photo = 'female.jpg';
        }
        $registration_no = '';
        $parent_aadhaar_no = '';
        $member_id_number = '';
        $union = $request->union;
        if ( $union == 'Yes' ) {
            $membertype = $request->membertype;
            $member_id_number = $request->id_number;
        } else {
            $membertype = $request->membertype2;
            if ( $membertype == 'Other' ) {
                $registration_no = $request->reg_number;
            } else {
                $parent_aadhaar_no = $request->parent_aadhaar;
            }
        }
        if(Auth::user()->user_type_id == 3){
            $category = $request->hiddencat;
        }else{
            $category = $request->category;
        }
        $section_id = 0;
        if($category == "School"){
            $section_id = $request->ssection;
        }else{
            $section_id = $request->csection;
        }
        DB::table( 'students' )->where( 'id', $request->student_id )->update( [
            'student_name' => $request->student_name,
            'father_name' => $request->father_name,
            'cell_number' => $request->cell_number,
            'adhaar_number' => $request->adhaar_number,
            'gender' => $genders,
            'db' => $request->db,
            'medium_id' => $request->medium_id,
            'category' => $category,
            'section_id' => $section_id,
            'school_name' => $request->school_name,
            'union_type' => $union,
            'membertype' => $membertype,
            'member_id_number' => $member_id_number,
            'registration_no' => $registration_no,
            'parent_aadhaar_no' => $parent_aadhaar_no,
            'dist_id' => $request->dist_id,
            'bank_details' => $request->bank_details,
            'ac_number' => $request->ac_number,
            'branch_name' => $request->branch_name,
            'ifsc' => $request->ifsc_number,
            'account_holder_name' => $request->account_holder_name,
            'photo' => $photo,
        ] );

        if ( $request->studentidcard != null ) {
            $studentidcard = $request->student_id . '.' . $request->file( 'studentidcard' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'student' . DIRECTORY_SEPARATOR . 'studentidcard' .DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'studentidcard' ][ 'tmp_name' ], $filepath . $studentidcard );

            DB::table( 'students' )->where( 'id', $request->student_id )->update( [
                'studentidcard' => $studentidcard,
            ] );
        }

        if ( $union == 'Yes' ) {
            if ( $request->billorid != null ) {
                $billorid = $request->student_id . '.' . $request->file( 'billorid' )->extension();
                $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'student' . DIRECTORY_SEPARATOR . 'billorid' .DIRECTORY_SEPARATOR );
                move_uploaded_file( $_FILES[ 'billorid' ][ 'tmp_name' ], $filepath . $billorid );

                DB::table( 'students' )->where( 'id', $request->student_id )->update( [
                    'bill_or_id' => $billorid,

                ] );
            }
        }

        return redirect( '/students' )->with( 'success', 'Student Updated Successfully ... !' );
    }


    public function institutestudentsactivate( Request $request ) {
        $studentid = $request->studentid;
        $payamount = $request->payamount;
        $ins_id = $request->ins_id;
        $studentid = explode(",",$studentid);
        $admin_id = Auth::user()->id;
        $sql = "select username from users where id=$admin_id";
        $result = DB::select( $sql );
        $username = $result[ 0 ]->username;
        $NALAVARIYAM_URL = env( 'NALAVARIYAM_URL', '' );
        $API_KEY = env( 'API_KEY', '' );
        $url = $NALAVARIYAM_URL .'/api/scholarship_activate_student/'.$username.'/'.$payamount.'/'.$API_KEY;
        $crl = curl_init();
        curl_setopt( $crl, CURLOPT_URL, $url );
        curl_setopt( $crl, CURLOPT_FRESH_CONNECT, true );
        curl_setopt( $crl, CURLOPT_RETURNTRANSFER, true );
        $response = curl_exec( $crl );
        $msg = '';
        if ( $response ) {
            $response = json_decode( $response, true );
            $msg = $response[ 'message' ];
        } else {
            $msg = 'Error calling wallet';
        }
        curl_close( $crl );
        if ( $msg != 'success' ) {
            return redirect( '/institutes' )->with( 'error', $msg );
        } else {
            //sukumar
            $to_id=1;
            $log_id=$admin_id;
            $amount=$payamount;
            $paydate = date('Y-m-d');
            $time = date("H:i:s");
            $ad_info = "ScholarShip activate student $username";
            $service_status = "Out Payment";
            $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','scholarship')";
            DB::insert(DB::raw($sql));
            $service_status = "In Payment";
            $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$to_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'scholarship')";
            DB::insert(DB::raw($sql));
            foreach($studentid as $id){
                $sql = "update students set status='Active' where id=$id";
                DB::update( $sql );
            }
            return redirect( '/institutes' )->with( 'success', 'Students activated successfully' );
        }
    }

    public function studentstatusupdate( Request $request ) {
        $student_id = $request->studentid;
        $membertype = $request->membertype;
        $amount = $request->amount;
        if ( $amount == 0 ) {
            DB::table( 'students' )->where( 'id', $student_id )->update( [
                'status' => 'Active',
            ] );
            return redirect( '/students' )->with( 'success', 'Student Status Updated Successfully' );

        } else {
            $admin_id = Auth::user()->id;
            $sql = "select username from users where id=$admin_id";
            $result = DB::select( $sql );
            $username = $result[ 0 ]->username;
            $NALAVARIYAM_URL = env( 'NALAVARIYAM_URL', '' );
            $API_KEY = env( 'API_KEY', '' );
            $url = $NALAVARIYAM_URL .'/api/scholarship_activate_student/'.$username.'/'.$amount.'/'.$API_KEY;
            $crl = curl_init();
            curl_setopt( $crl, CURLOPT_URL, $url );
            curl_setopt( $crl, CURLOPT_FRESH_CONNECT, true );
            curl_setopt( $crl, CURLOPT_RETURNTRANSFER, true );
            $response = curl_exec( $crl );
            $msg = '';
            if ( $response ) {
                $response = json_decode( $response, true );
                $msg = $response[ 'message' ];
            } else {
                $msg = 'Error calling wallet';
            }
            curl_close( $crl );
            if ( $msg != 'success' ) {
                return redirect( '/students' )->with( 'error', $msg );
            } else {
                //sukumar
                $to_id=1;
                $log_id=$admin_id;
                $paydate = date('Y-m-d');
                $time = date("H:i:s");
                $ad_info = "ScholarShip activate student $username";
                $service_status = "Out Payment";
                $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','scholarship')";
                DB::insert(DB::raw($sql));
                $service_status = "In Payment";
                $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$to_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'scholarship')";
                DB::insert(DB::raw($sql));
                $sql = "update students set status='Active' where id=$student_id";
                DB::update( $sql );
                return redirect( '/students' )->with( 'success', 'Student activated successfully' );
            }

        }

    }

    public function admins()
    {
        if ( Auth::user()->user_type_id == 1 ) {
            $admin = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name' )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->where( 'users.user_type_id', 2 )->orderBy( 'users.id', 'Asc' )->get();
        } else {
            return redirect( '/dashboard' )->with( 'error', 'You Dont have the permission to access ... !' );
        }

        $manageusertype = DB::table( 'user_type' )->where( 'id', '=', '2' )->orderBy( 'id', 'Asc' )->get();
        $managedistrict = DB::table( 'district' )->orderBy( 'id', 'Asc' )->get();

        $sql = 'select id,district_name from district where id not in (select distinct dist_id from users  where user_type_id = 2)';
        $getdistrictlimit = DB::select( DB::raw( $sql ) );
        return view( 'users/admin', compact( 'admin', 'managedistrict', 'getdistrictlimit', 'manageusertype' ) );

    }

    public function centers()
    {

        $user_id = Auth::user()->id;
        if ( Auth::user()->user_type_id == 1 ) {
            $centerusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name' )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->where( 'users.user_type_id', 3 )->orderBy( 'users.id', 'Asc' )->get();

            $managedistrict = DB::table( 'district' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();
            $manageusertype = DB::table( 'user_type' )->where( 'id', '=', '3' )->orderBy( 'id', 'Asc' )->get();

        } elseif ( Auth::user()->user_type_id == 2 ) {
            $centerusers = DB::table( 'users' )->select( 'users.*', 'district.district_name', 'taluk.taluk_name' )
            ->Join( 'district', 'district.id', '=', 'users.dist_id' )
            ->Join( 'taluk', 'taluk.id', '=', 'users.taluk_id' )
            ->where( 'users.user_type_id', 3 )
            ->Where( 'referral_id', $user_id )
            ->orderBy( 'users.id', 'Asc' )->get();

            $managedistrict = DB::table( 'district' )->where( 'status', '=', 'Active' )->orderBy( 'id', 'Asc' )->get();
            $manageusertype = DB::table( 'user_type' )->where( 'id', '=', '3' )->orderBy( 'id', 'Asc' )->get();
        }
        $sql = 'select id,district_name from district where id not in (select distinct dist_id from users  where user_type_id = 2)';
        $getdistrictlimit = DB::select( DB::raw( $sql ) );
        return view( 'users/centers', compact( 'centerusers', 'managedistrict', 'getdistrictlimit', 'manageusertype' ) );

    }

    public function edituser( Request $request )
    {
        $id = $request->id;
        $dist_id = $request->dist_id;
        $referral_id = Auth::user()->id;
        $full_name = $request->full_name;
        $phone = $request->phone;
        $username = trim( $request->username );
        $cpassword = $request->password;
        $status = $request->status;
        $user_type_id = $request->user_type_id;
        $createinstitution = ($request->get("create_institution") != null) ? 1 : 0;
        $tailoringuser = ($request->get("tailoring_user") != null) ? 1 : 0;
        $password = Hash::make( $request->password );
        $log_id = $request->user_id;
        $tailoring_ins_name = $request->tailoring_ins_name;
        $tailoring_ins_location = $request->tailoring_ins_location;
        $sql = "update users set dist_id=$dist_id,full_name='$full_name',phone='$phone',username='$username',password='$password',cpassword='$cpassword',status='$status',create_institution='$createinstitution',tailoring_user='$tailoringuser',tailoring_ins_name='$tailoring_ins_name',tailoring_ins_location='$tailoring_ins_location' where id=$id";
        DB::update( $sql );

        if ( $request->cordinator_image != null ) {
            $cordinator_image = $id. '.' . $request->file( 'cordinator_image' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'cordinator' .DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'cordinator_image' ][ 'tmp_name' ], $filepath . $cordinator_image );


            DB::table( 'users' )->where( 'id', $id )->update( [
                'cordinator_image' => $cordinator_image,
            ] );
        }
        
        return redirect()->back()->with( 'success', 'User updated Successfully' );
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

    public function adduser( Request $request )
    {
        $user_id = Auth::user()->id;

        $adduser = DB::table( 'users' )->insert( [
            'full_name' => $request->full_name,
            'username' => trim( $request->username ),
            'password' => Hash::make( $request->password ),
            'cpassword' => $request->password,
            'dist_id' => $request->dist_id,
            'taluk_id' => $request->taluk_id,
            'referral_id' => $user_id,
            'phone' => $request->phone,
            'user_type_id' => $request->user_type_id,
            'create_institution' => ($request->get("create_institution") != null) ? 1 : 0,
            'status' => 'Inactive',
            'user_photo' => 'user.jpg',
            'log_id' => $user_id
        ] );
        $insert_id = DB::getPdo()->lastInsertId();


        if ( $request->scholarship_image != null ) {
            $scholarship_image = $insert_id. '.' . $request->file( 'scholarship_image' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'cordinator' .DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'scholarship_image' ][ 'tmp_name' ], $filepath . $scholarship_image );


            DB::table( 'users' )->where( 'id', $insert_id )->update( [
                'scholarship_image' => $scholarship_image,
            ] );
        }
        return redirect()->back()->with( 'success', 'User added Successfully' );
    }

    public function gettaluk( Request $request )
    {

        $gettaluk = DB::table( 'taluk' )->where( 'parent', $request->taluk_id )->orderBy( 'id', 'Asc' )->get();
        return response()->json( $gettaluk );
    }

    public function changepassword()
    {
        $userid = Auth::user()->id;

        return view( 'users/changepassword' );
    }

    public function updatepassword( Request $request ) {
        $userid = Auth::user()->id;
        $old_password = trim( $request->get( 'oldpassword' ) );
        $currentPassword = auth()->user()->password;
        if ( Hash::check( $old_password, $currentPassword ) ) {
            $new_password = trim( $request->get( 'new_password' ) );
            $confirm_password = trim( $request->get( 'confirm_password' ) );
            if ( $new_password != $confirm_password ) {
                return redirect( 'changepassword' )->with( 'error', 'Passwords does not match' );
            } elseif ( $new_password == '12345678' ) {
                return redirect( 'changepassword' )->with( 'error', 'You cannot use the passord 12345678' );
            } else {
                $updatepass = DB::table( 'users' )->where( 'id', '=', $userid )->update( [
                    'password' => Hash::make( $new_password ),
                    'pas'      => $request->new_password,
                ] );
                return redirect( 'dashboard' )->with( 'success', 'Passwords Change Succesfully' );
            }
        } else {
            return redirect( 'changepassword' )->with( 'error', 'Sorry, your current password was not recognised' );
        }
    }

    public function userstatusupdate( $user_id )
    {
        $status = '';
        $sql = "select status from users where id = $user_id";
        $result = DB::select( DB::raw( $sql ) );
        $status = $result[ 0 ]->status;
        if ( $status == 'Active' ) {
            $payment_message = 'This Account Is Active';
            $payment_amount = '0';
        } else {

            $payment_message = 'Activate this center account';
            $payment_amount = 100;
        }

        return view( 'users/user_status_update', compact( 'payment_amount', 'payment_message', 'status', 'user_id' ) );

    }

    public function centeruser_activate( Request $request ) {
        $payment_amount = $request->payment_amount;
        $user_id = $request->user_id;
        $admin_id = Auth::user()->id;
        $sql = "select username from users where id=$admin_id";
        $result = DB::select( $sql );
        $username = $result[ 0 ]->username;
        $NALAVARIYAM_URL = env( 'NALAVARIYAM_URL', '' );
        $API_KEY = env( 'API_KEY', '' );
        $url = $NALAVARIYAM_URL .'/api/voterid_activate_center/'.$username.'/'.$payment_amount.'/'.$API_KEY;
        $crl = curl_init();
        curl_setopt( $crl, CURLOPT_URL, $url );
        curl_setopt( $crl, CURLOPT_FRESH_CONNECT, true );
        curl_setopt( $crl, CURLOPT_RETURNTRANSFER, true );
        $response = curl_exec( $crl );
        $msg = '';
        if ( $response ) {
            $response = json_decode( $response, true );
            $msg = $response[ 'message' ];
        } else {
            $msg = 'Error calling wallet';
        }
        curl_close( $crl );
        if ( $msg != 'success' ) {
            return redirect( '/dashboard' )->with( 'error', $msg );
        } else {
            $sql = "update users set status='Active' where id=$user_id";
            DB::update( $sql );
            return redirect( 'dashboard' )->with( 'success', 'Center activated successfully' );
        }
    }

    public function addinstitutestudent() {

        $managedistrict  = DB::table( 'district' )->orderBy( 'id', 'Asc' )->get();

        $managebanking  = DB::table( 'bank_details' )->orderBy( 'id', 'Asc' )->get();
        $managemedium  = DB::table( 'medium' )->orderBy( 'id', 'Asc' )->get();
        $ssection  = DB::table( 'section' )->where('id','<',100)->orderBy( 'id', 'Asc' )->get();
        $csection  = DB::table( 'section' )->where('id','>',100)->orderBy( 'id', 'Asc' )->get();
        $group  = DB::table( 'syllabus' )->orderBy( 'id', 'Asc' )->get();

        return view( 'institutes/addstudent', compact( 'managedistrict', 'managebanking', 'managemedium','ssection','csection','group' ) );

    }

    public function saveinstitutestudent( Request $request )
    {
        $cpassword = rand( 10001, 99999 );
        $password = Hash::make( $cpassword );
        $user_id = Auth::user()->id;
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
            'dist_id' => $dist_id,
            'bank_details' => $request->bank_details,
            'branch_name' => $request->branch_name,
            'ac_number' => $request->ac_number,
            'ifsc' => $request->ifsc_number,
            'account_holder_name' => $request->account_holder_name,
            'user_id' => $user_id,
            'username' => $username,
            'cpassword' => $cpassword,
            'password' => $password,
            'status' => 'Inactive',
            'photo' => $photo,
        ] );
        

        return redirect( '/students' )->with( 'success', 'Add Members Successfully ... !' );
    }

    public function studentapproval() {

        $approvestudent  = DB::table( 'payments' )->select( 'payments.*', 'students.student_name')
        ->Join( 'students', 'students.id', '=', 'payments.from_id' )->where('payments.status','Pending')->orderBy( 'payments.id', 'Desc' )->get();

        return view( 'users/approvestudent', compact('approvestudent') );

    }

    public function rejectstudent($studentid) {

       DB::table( 'payments' )->where('from_id',$studentid)->delete();
       
       return redirect( '/studentapproval')->with( 'success', 'Student Rejected Successfully ... !' );

   }

   public function acceptstudent($studentid) {

    DB::table( 'payments' )->where( 'from_id', $studentid )->update( [
        'status' => "Completed",
    ]);
    DB::table( 'students' )->where( 'id', $studentid )->update( [
        'status' => "Active",
    ]);

    $sql = "select a.username,a.id from users a,students b where a.id=b.user_id and b.id=$studentid";
    $result = DB::select($sql);
    $username = $result[0]->username;
    $ref_id = $result[0]->id;
    $sup_amount = 75; 
    $ref_amount = 75; 
    $NALAVARIYAM_URL = env( 'NALAVARIYAM_URL', '' );
    $API_KEY = env( 'API_KEY', '' );
    $url = $NALAVARIYAM_URL .'/api/scholarship_accept_student/'.$username.'/'.$studentid.'/'.$sup_amount.'/'.$ref_amount.'/'.$API_KEY;
    $crl = curl_init();
    curl_setopt( $crl, CURLOPT_URL, $url );
    curl_setopt( $crl, CURLOPT_FRESH_CONNECT, true );
    curl_setopt( $crl, CURLOPT_RETURNTRANSFER, true );
    $response = curl_exec( $crl );
    $msg = '';
    if ( $response ) {
        $response = json_decode( $response, true );
        $msg = $response[ 'message' ];
    } else {
        $msg = 'Error calling wallet';
    }
    curl_close( $crl );
    $to_id=1;
    $paydate = date('Y-m-d');
    $time = date("H:i:s");
    $ad_info = "ScholarShip accept student N".$studentid;
    $service_status = "In Payment";
    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$to_id','$ref_id','$to_id','$ref_amount','$ad_info', '$service_status','$time','$paydate',1,'scholarship')";
    DB::insert(DB::raw($sql));
    $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$to_id','$to_id','$to_id','$sup_amount','$ad_info', '$service_status','$time','$paydate',1,'scholarship')";
    DB::insert(DB::raw($sql));
    return redirect( '/studentapproval')->with( 'success', 'Student Approved Successfully ... !' );

}

 public function districts()
    {
    	$districts = DB::table('district')->orderBy('id', 'Asc')->get();
		
    	return view('/admission/districts', compact('districts'));
    }
    public function adddistrict(Request $request)
    {
        DB::table('district')->insert(['district_name' => $request->district_name,
    		'status' => 'Active'
    	]);
    	return redirect()->back()->with('success', 'Add District Successfully ... !');
    } 
    public function updatedistrict(Request $request)
    {
		DB::table('district')->where('id',$request->district_id)->update([
    		'district_name' => $request->district_name,
    		'status' => $request->status,
    	]);
    	return redirect()->back()->with('success', 'update districts  Successfully ... !');
    } 
    
	 public function deletedistrict($id)
     {
         DB::table('district')->where('id', $id)->delete();
         return redirect()->back()->with('success', 'Add District Successfully ... !');
     }
    public function edu_type($id)
    {
        $edutype = DB::table('edutype')->orderBy('id', 'Asc')->get();
        
    	return view('/admission/edu_type', compact('edutype'));
    }
    public function addedutype(Request $request)
    {
        DB::table('edutype')->insert([
            'edutype_name' => $request->edutype_name,
    		'status' => 'Active'
    	]);
    	return redirect()->back()->with('success', 'Add Edutype Successfully ... !');
    } 
    public function updateedutype(Request $request)
    {
		DB::table('edutype')->where('id',$request->id)->update([
    		'edutype_name' => $request->edutype_name,
    		'status' => $request->status,
    	]);
    	return redirect()->back()->with('success', 'update Edutype  Successfully ... !');
    } 

	 public function deleteedutype($id)
    {
        DB::table('edutype')->where('id', $id)->delete();
    	return redirect()->back()->with('success', 'Add Edutype Successfully ... !');
    }

    public function institution($id)
    {
        $institution = DB::table('institution')->orderBy('id', 'Asc')->get();
        
    	return view('/admission/institution', compact('institution'));
    }
    public function addinstitution(Request $request)
    {
        DB::table('institution')->insert([
            'institution_name' => $request->institution_name,
    		'status' => 'Active'
    	]);
    	return redirect()->back()->with('success', 'Add institution Successfully ... !');
    } 
    public function updateinstitution(Request $request)
    {
		DB::table('institution')->where('id',$request->id)->update([
    		'institution_name' => $request->institution_name,
    		'status' => $request->status,
    	]);
    	return redirect()->back()->with('success', 'update Institution  Successfully ... !');
    } 

	 public function deleteinstitution($id)
    {
        DB::table('institution')->where('id', $id)->delete();
    	return redirect()->back()->with('success', 'Add Institution Successfully ... !');
    }
    public function department()
    {
        $department = DB::table('department')->orderBy('id', 'Asc')->get();
        
    	return view('/admission/department', compact('department'));
    }
    public function adddepartment(Request $request)
    {
        DB::table('department')->insert([
            'department_name' => $request->department_name,
    		'status' => 'Active'
    	]);
    	return redirect()->back()->with('success', 'Add Department Successfully ... !');
    } 
    public function updatedepartment(Request $request)
    {
		DB::table('department')->where('id',$request->id)->update([
    		'department_name' => $request->department_name,
    		'status' => $request->status,
    	]);
    	return redirect()->back()->with('success', 'update Department  Successfully ... !');
    } 

	 public function deletedepartment($id)
    {
        DB::table('department')->where('id', $id)->delete();
    	return redirect()->back()->with('success', 'Add Department Successfully ... !');
    }
    
}
