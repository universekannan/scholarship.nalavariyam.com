<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\WalletHelper;


class TailoringController extends Controller
{

      public function __construct()
 {

        $this->middleware( 'auth' );
    }

	public function tailoring($filter)
    {
    	$id = Auth::user()->id;
    	$sql = "SELECT * FROM tailoring";
    	if($filter == "pending"){
            if ( Auth::user()->id == 1 || Auth::user()->id == 42 ) {
                $sql = $sql ."  where payment_status = 'Pending' order by payment_status desc";
            }else{
                $sql = $sql ."  where payment_status = 'Pending' and user_id = $id order by id desc";
        	}
        }
        if($filter == "resubmit"){
            if ( Auth::user()->id == 1 || Auth::user()->id == 42 ) {
                $sql = $sql ."  where payment_status = 'Rejected' order by payment_status desc";
            }else{
                $sql = $sql ."  where payment_status = 'Rejected' and user_id = $id order by id desc";
        	}
        }
         if($filter == "completed"){
            if ( Auth::user()->id == 1 || Auth::user()->id == 42 ) {
                $sql = $sql ."  where payment_status = 'Completed' order by payment_status desc";
            }else{
                $sql = $sql ."  where payment_status = 'Completed' and user_id = $id order by id desc";
        	}
        }

         if($filter == "all"){
            if ( Auth::user()->id == 1 || Auth::user()->id == 42 ) {
                $sql = $sql ."   order by payment_status desc";
            }else{
                $sql = $sql ."  where  user_id = $id order by id desc";
        	}
        }

    	$tailoring = DB::select($sql);
		$tailoring = json_decode( json_encode( $tailoring ), true );
        $data = array();
        foreach ( $tailoring as $key => $ser ) {
            $userid = $ser[ 'user_id' ];

            $sql = "SELECT username,tailoring_user,tailoring_ins_name,tailoring_ins_location,tailoring_ins_signature FROM users where id='$userid'";
            $result = DB::select($sql);
            if(count($result) > 0){
                $tailoring[ $key ][ 'username' ] = $result[0]->username;
                $tailoring[ $key ][ 'institute' ] = $result[0]->tailoring_user;
                $tailoring[ $key ][ 'institutename' ] = $result[0]->tailoring_ins_name;
                $tailoring[ $key ][ 'institutelocation' ] = $result[0]->tailoring_ins_location;
                $tailoring[ $key ][ 'signature' ] = $result[0]->tailoring_ins_signature;
                 $tailoring[ $key ][ 'address' ] = "";
            }

        }
            $NALAVARIYAM_URL = env( 'NALAVARIYAM_URL', '' );
            $API_KEY = env( 'API_KEY', '' );
            $url = $NALAVARIYAM_URL .'/api/getaddress';
            $data=array();
            $data['key']=$API_KEY;
            $data['tailoring'] =  $tailoring;


            $ch = curl_init();
            $headers = array();
            $headers[] = "Content-Type: application/json";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $result = curl_exec($ch);
            $msg = "";
             if ( $result ) {
                $result = json_decode($result, TRUE);
                $tailoring = $result[ 'tailoring' ];
                 $msg = "success";
            }else {
                $msg = 'Error calling wallet';
            }
            curl_close($ch);

            $tailoring = json_decode( json_encode( $tailoring ) );

            //echo "<pre>";print_r($tailoring);echo"</pre>";die;

    	   return view('tailoring/index',compact('tailoring'));
    }

	public function addtailoring(Request $request)
	{
		DB::table('tailoring')->insert([
		'name' => $request->name,
        'course_name' => $request->course_name,
		'significant' => $request->significant,
		'father_or_hus_name' => $request->father_or_hus_name,
		'phone_number'=> $request->phone_number,
		'address_1' => $request->address_1,
		'address_2' => $request->address_2,
		'taluk' => $request->taluk,
		'district' => $request->district,
		'pin_code' => $request->pin_code,
		'aadhar_number' => $request->aadhar_number,
		'status'=>'Active',
		'payment_status'=>'New',
		'user_id'=>Auth::user()->id,
		]);
		  $insert_id = DB::getPdo()->lastInsertId();
        $profile_image = '';

        if ( $request->profile_image != null ) {
            $profile_image = $insert_id . '.' . $request->file( 'profile_image' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'tailoringprofile' . DIRECTORY_SEPARATOR);
            move_uploaded_file( $_FILES[ 'profile_image' ][ 'tmp_name' ], $filepath . $profile_image );
        }
        DB::table( 'tailoring' )->where( 'id', $insert_id )->update( [
            'profile_image' => $profile_image,
        ] );

		return redirect()->back()->with('Success','Add Successfully....!');
	}


	public function tailoringpayment_update( Request $request ) {
		$service_charge = $request->payment_amount;
        $customerid = $request->customerid;
		$username = Auth::user()->username;
        $log_id = Auth::user()->id;
        $NALAVARIYAM_URL = env( 'NALAVARIYAM_URL', '' );
        $API_KEY = env( 'API_KEY', '' );
        $url = $NALAVARIYAM_URL .'/api/scholarship_tailoring_debit_wallet/'.$username.'/'.$service_charge.'/'.$API_KEY;
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
        if($msg != "success"){
        	return redirect( '/tailoring/all' )->with( 'error', $msg );
        } else {
            $amount=$service_charge;
            $to_id=1;
            $paydate = date('Y-m-d');
            $time = date("H:i:s");
            $ad_info = "Tailoring payment $username";
            $service_status = "Out Payment";
            $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$log_id','$log_id','$to_id','$amount','$ad_info', '$service_status','$time','$paydate','scholarship')";
            DB::insert(DB::raw($sql));
            $service_status = "In Payment";
            $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$log_id','$to_id','$log_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'scholarship')";
            DB::insert(DB::raw($sql));
            $date = date("Y-m-d");
	  		$sql = "update tailoring set payment_status = 'Pending',date = '$date' where id = $customerid";
	        DB::update( DB::raw( $sql ));
        return redirect( 'tailoring/pending' )->with('success','Payment Successful ..');

    	}
    }

    public function approve_certificate(Request $request)
	{
		$payment_status = $request->payment_status;
		$customerid = $request->customerid;
		if($payment_status == "Rejected"){
    		DB::table('tailoring')->where('id', $customerid)->update([
    			'payment_status' => $payment_status,
    			'reason' => $request->reason,
    		]);
		}
		if($payment_status == "Completed"){
            $admin_id = $request->userid;
            $amount = 50;
            $sql = "select username from users where id=$admin_id";
            $result = DB::select( $sql );
            $username = $result[ 0 ]->username;
          	$NALAVARIYAM_URL = env( 'NALAVARIYAM_URL', '' );
            $API_KEY = env( 'API_KEY', '' );
            $url = $NALAVARIYAM_URL .'/api/scholarship_tailoring_credit_wallet/'.$username.'/'.$amount.'/'.$API_KEY;
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
            if($msg != "success"){
        	   return redirect( '/tailoring/all' )->with( 'error', $msg );
            } else {
                $referral_username = $response["referral_username"];
                $sql = "select id from users where username='$referral_username'";
                $result = DB::select( $sql );
                $referral_id = $result[ 0 ]->id;
                $superadmin_id = 1;
                $paydate = date('Y-m-d');
                $time = date("H:i:s");
                $ad_info = "Tailoring Commission";
                $service_status = "Out Payment";
                $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,service_entity) values ('$superadmin_id','$superadmin_id','$referral_id','$amount','$ad_info', '$service_status','$time','$paydate','scholarship')";
                DB::insert(DB::raw($sql));
                $service_status = "IN Payment";
                $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,iscommission,service_entity) values ('$superadmin_id','$referral_id','$superadmin_id','$amount','$ad_info', '$service_status','$time','$paydate',1,'scholarship')";
                DB::insert(DB::raw($sql));
    	  		$sql = "update tailoring set payment_status = 'Completed' where id = $customerid";
    	        DB::update( DB::raw( $sql ));
            return redirect( 'tailoring/completed' )->with('success','Payment Successful ..');
    	   }
		}

		return redirect()->back()->with('Success','Update Successfully....!');

	}

	public function resubmit_certificate(Request $request)
	{
		DB::table('tailoring')->where('id', $request->customerid)->update([
		'name' => $request->name,
        'course_name' => $request->course_name,
		'significant' => $request->significant,
		'father_or_hus_name' => $request->father_or_hus_name,
		'address_1' => $request->address_1,
		'address_2' => $request->address_2,
		'taluk' => $request->taluk,
		'district' => $request->district,
		'payment_status'=>'Pending',
		]);

        if ( $request->profile_image != null ) {
            $profile_image = $request->customerid . '.' . $request->file( 'profile_image' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'tailoringprofile' . DIRECTORY_SEPARATOR);
            move_uploaded_file( $_FILES[ 'profile_image' ][ 'tmp_name' ], $filepath . $profile_image );
               DB::table( 'tailoring' )->where( 'id', $request->customerid )->update( [
            'profile_image' => $profile_image,
        ] );
        }


		return redirect()->back()->with('Success','Add Successfully....!');
	}

    public function tailoring_institute()
    {
     $manageinstitute  = DB::table( 'users' )->select( 'users.*', 'district.district_name')
        ->Join( 'district', 'district.id', '=', 'users.dist_id' )->where('tailoring_user',1)->orderBy( 'id', 'Asc' )->get();
     return view('tailoring/tailoringinstitute',compact('manageinstitute'));
    }

}
