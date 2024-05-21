<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class PaymentController extends Controller {


    public function payment_history () {
        $id = Auth::user()->id;
        $viewhistory = DB::table( 'payments' )->orderby( 'id', 'Asc' )->get();
        return view( 'payment/payment_history', compact( 'viewhistory' ) );
    }

     public function paymentrequest()
 {
        $login = Auth::user()->id;
        $sql = "select * from request_payment where from_id=$login or to_id = $login order by `status` desc";
        $paymentrequest =  DB::select( DB::raw( $sql ));
       

        return view( 'wallet.viewrequestamount', compact( 'paymentrequest') );
    }

    public function create_paymentrequest(Request $request){
        $from_id = Auth::user()->id;
        $confirm = DB::table('request_payment')->insert([
          'from_id' => $from_id,
          'to_id' => 1,
          'amount' => $request->amount,
          'status' => 'Pending',
          'req_date' => date("Y-m-d"),
          'req_time' => date("Y-m-d H:i:s"),
        ]);
        $insertid = DB::getPdo()->lastInsertId();

        $paid_image = "";
        if ($request->paid_image != null) {
          $paid_image = $insertid.'.'.$request->file('paid_image')->extension();
          $filepath = public_path('upload' . DIRECTORY_SEPARATOR . 'paidimage' . DIRECTORY_SEPARATOR);
          move_uploaded_file($_FILES['paid_image']['tmp_name'], $filepath . $paid_image);
      }
      $image = DB::table('request_payment')->where('id', $insertid)->update([
          'req_image' => $paid_image,
        ]);
  
          return redirect( "/paymentrequest" );
      }
      
      public function approvepayment(Request $request){
        $amount = $request->amount;
        $from_id = $request->from_id;
        $request_id = $request->req_id;
        $status = 'Approved';
        $login_id = 1;
        $date = date( 'Y-m-d' );
        $time = date( 'H:i:s' );
        $sql="select username from users where id=$from_id";
        $result=DB::select($sql);
        $username=$result[0]->username;
        $context = "scholarship";
        $NALAVARIYAM_URL = env( 'NALAVARIYAM_URL', '' );
        $API_KEY = env( 'API_KEY', '' );
        $url = $NALAVARIYAM_URL ."/api/approve_amount/$username/$amount/$context/".$API_KEY;
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
            $msg = 'Error updating wallet';
        }
        curl_close( $crl );
        if ( $msg == 'success' ) {
            $sql = "update request_payment set status = '$status' where id = $request_id";
            DB::update( DB::raw( $sql ) );
            $service_status = 'Out Payment';
        $ad_info = 'Fund Transfer Scholarship';
        $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,pay_id,service_entity) values ('$login_id','$login_id','$from_id','$amount','$ad_info', '$service_status','$time','$date','$request_id','scholarship')";
        DB::insert( DB::raw( $sql ) );
        
        $service_status = 'IN Payment';
        $ad_info = 'Fund Transfer';
        $sql = "insert into payment (log_id,from_id,to_id,amount,ad_info,service_status,time,paydate,pay_id,service_entity) values ('$login_id','$from_id','$login_id','$amount','$ad_info', '$service_status','$time','$date','$request_id','scholarship')";
        DB::insert( DB::raw( $sql ) );
         
            return redirect("/paymentrequest")->with( 'success', 'Amount approved successfully');
        }else{
            return redirect("/paymentrequest")->with( 'error', $msg);
        }
    }

     public function declinerequest_payment($toid) {

        $sql = "update request_payment set status = 'Declined' where id = $toid";
        DB::update( DB::raw( $sql ) );

        return redirect( "paymentrequest" )->with('success', 'Request Amount Declined  Successfully');
     }
    
}
