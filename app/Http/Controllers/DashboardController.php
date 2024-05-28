<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\User;

class DashboardController extends Controller
 {
    public function __construct()
    {
        $this->middleware( 'auth' );
    }

    public function dashboard() {
        $user_id = Auth::user()->id;
        $referral_id = Auth::user()->referral_id;
        $studentscount = 0;
        $admincount = 0;
        $Centercount = 0;
        if ( Auth::user()->user_type_id	 == 1 ) {
            $sql = 'select count(*) as studentscount from students';
        } else {
            $sql = "select count(*) as studentscount from students where user_id = $user_id";
        }
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $studentscount = $result[ 0 ]->studentscount;
        }

        if ( Auth::user()->user_type_id	 == 1 ) {
            $sql = 'select count(*) as admincount from users where user_type_id = 2';
        } elseif ( Auth::user()->user_type_id == 2 ) {
            $sql = "select count(*) as admincount from users where user_type_id = 2 and referral_id = $referral_id";
        }
        $result = DB::select( DB::raw( $sql ) );

        if(Auth::user()->user_type_id  != 3){
        if ( count( $result ) > 0 ) {
            $admincount = $result[ 0 ]->admincount;
        }
    }

        $questions = array();
        $sql="select * from section order by id";
        $result = DB::select($sql);
        $i=0;
        foreach($result as $res){
            $section_id = $res->id;
            $section_name = $res->section_name;
            $questions[$i]["section_id"] = $section_id;
            $questions[$i]["section_name"] = $section_name;
            $questions[$i]["qcount"]  = 0;
            if($i%2 == 0)
                $questions[$i]["color"]  = "bg-olive";
            else
                $questions[$i]["color"]  = "bg-indigo";
            $sql2 = "select count(*) as qcount from exam_question where section_id=$section_id";
            $result2 = DB::select($sql2);
            $questions[$i]["qcount"] = $result2[0]->qcount;
            $i++;
        }

          $tailoringpending = 0;
        if(Auth::user()->id == 1 || Auth::user()->id == 42){
        $sql = "select count(*) as tailoringpending from tailoring where payment_status='Pending'";
        }else{
        $sql = "select count(*) as tailoringpending from tailoring where payment_status='Pending' and user_id = $user_id";
        }
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $tailoringpending = $result[ 0 ]->tailoringpending;
        }

         $tailoringresubmit = 0;
        if(Auth::user()->id == 1 || Auth::user()->id == 42){
        $sql = "select count(*) as tailoringresubmit from tailoring where payment_status='Rejected'";
        }else{
        $sql = "select count(*) as tailoringresubmit from tailoring where payment_status='Rejected' and user_id = $user_id";
        }
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $tailoringresubmit = $result[ 0 ]->tailoringresubmit;
        }


       $tailoringcompleted = 0;
        if(Auth::user()->id == 1 || Auth::user()->id == 42){
        $sql = "select count(*) as tailoringcompleted from tailoring where payment_status='Completed'";
        }else{
        $sql = "select count(*) as tailoringcompleted from tailoring where payment_status='Completed' and user_id = $user_id";

        }
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $tailoringcompleted = $result[ 0 ]->tailoringcompleted;
        }

        $tailoringnew = 0;
        if(Auth::user()->id == 1){
        $sql = "select count(*) as tailoringnew from tailoring where payment_status='New'";
        }else{
        $sql = "select count(*) as tailoringnew from tailoring where payment_status='New' and user_id = $user_id";

        }
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $tailoringnew = $result[ 0 ]->tailoringnew;
        }

         $login = Auth::user()->id;
        $sql = "select count(id) as RequestAmount from request_payment where status='Pending' and (from_id=$login or to_id = $login )";
        $result = DB::select( DB::raw( $sql ) );
        if ( count( $result ) > 0 ) {
            $RequestAmount = $result[ 0 ]->RequestAmount;
        }
        $EduStudents = '0';
		
		if(Auth::user()->id ==1){
    	$EduStudents = DB::table('students')->whereIn('section_id', array(12, 13, 14, 15, 16, 18))->orderBy('id', 'Asc')->count();
		} else {
        $EduStudents = DB::table('students')->whereIn('section_id', array(12, 13, 14, 15, 16, 18))->where('user_id','$login')->orderBy('id', 'Asc')->count();
        }
      

        return view( 'dashboard', compact( 'studentscount', 'admincount','questions','tailoringpending','tailoringcompleted','tailoringresubmit','tailoringnew','RequestAmount','EduStudents' ) );
        }

        public function payments($from,$to) {
            $login = Auth::user()->id;
            $sql="select * from payment where from_id=$login and paydate >= '$from' and paydate <= '$to' order by id desc";
            $wallet = DB::select($sql);
            $balance = $this->wallet();

             $sql = "select status from request_payment where from_id=$login and status='Pending'";
            $paymentrequest =  DB::select( DB::raw( $sql ));
            $status ="";
            if(count($paymentrequest) > 0){
                 $status = $paymentrequest[0]->status;
            }

             $referencedata = DB::table( 'users' )->where('id',1)->first();
            return view( 'wallet/index', compact( 'wallet', 'from', 'to','balance','status','referencedata') );
        }

        public function wallet() {
            $username = Auth::user()->username;
            $NALAVARIYAM_URL = env( 'NALAVARIYAM_URL', '' );
            $API_KEY = env( 'API_KEY', '' );
            $url = $NALAVARIYAM_URL .'/api/wallet_balance/'.$username.'/'.$API_KEY;
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
            return $response["balance"];
        }

        public function bgdark( $user_id ) {
            $id = Auth::user()->id;
            $bg = DB::table( 'users' )->where( 'id', $id )->update( [
                'colour' => $user_id,
            ] );
            $response[ 'status' ] = 'success';
            return response()->json( $response );
        }

    }
