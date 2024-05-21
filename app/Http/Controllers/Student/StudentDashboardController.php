<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentDashboardController extends Controller
 {

    public function studentdashboard()
 {
           $login_id = Session::get( 'id' );
           if(is_null($login_id)){
               return redirect("/studentlogin");
           }else{
               $students = DB::table( 'students' )->select( 'students.*', 'district.district_name', 'medium.medium_name', 'section.section_name' )
               ->Join( 'district', 'district.id', '=', 'students.dist_id' )
               ->Join( 'medium', 'medium.id', '=', 'students.medium_id' )
               ->Join( 'section', 'section.id', '=', 'students.section_id' )
               ->where( 'students.id', '=', $login_id )
               ->orderBy( 'students.id', 'Asc' )->get();
               

               $ownactivation = DB::table( 'payments' )->select('status')->where('from_id',$login_id)->first();
                $paidstatus = 0;
               //dd($ownactivation);
               if ($ownactivation == "") { 
                return view( 'student/studentdashboard', compact( "students","paidstatus") );
            }else {
                if($ownactivation->status == "Pending"){
                    $paidstatus = 1;
                }
            }
           }

           return view( 'student/studentdashboard', compact( "students","paidstatus") );
       }

       public function studentrequest( Request $request )
 {
         DB::table( 'payments' )->insert( [
            'from_id' => $request->student_id,
            'to_id' => 1,
            'amount' => 150,
            'ad_info' => "Student Own Registration",
            'pay_date' => date("Y-m-d"),
            'pay_time' => date("h:i:s"),
            'status' => "Pending",
        ] );

         $insert_id = DB::getPdo()->lastInsertId();
        $paid_img = '';

        if ( $request->paid_img != null ) {
            $paid_img = $insert_id . '.' . $request->file( 'paid_img' )->extension();
            $filepath = public_path( 'upload' . DIRECTORY_SEPARATOR . 'student' . DIRECTORY_SEPARATOR . 'paid_img' .DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'paid_img' ][ 'tmp_name' ], $filepath . $paid_img );
        }
        DB::table( 'payments' )->where( 'id', $insert_id )->update( [
            'paid_img' => $paid_img,
        ] );
        

        return redirect( '/studentdashboard' );
    }
       
    public function bgdark( $customer_id ) {
        $id = Session::get( 'customer_id' );
        $sql = "update customers set colour=$customer_id where id = $id";
        DB::update( DB::raw( $sql ) );
        $response[ 'status' ] = 'success';
        return response()->json( $response );
    }

    public function removefavorites( $customer_id ) {
        $sql = "delete from favorites where customer_id=$customer_id";
        $result = DB::delete( DB::raw( $sql ) );
        $response[ 'status' ] = 'success';
        return response()->json( $response );
    }

}