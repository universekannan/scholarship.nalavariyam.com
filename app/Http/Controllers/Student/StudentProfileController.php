<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;
use Session;
use App\Models\User;

class StudentProfileController extends Controller
{

    public function studentprofile()
    {
        $id = Session::get( 'student_id' );
        $profile = DB::table( 'students' )->where( 'id', '=', $id )->get();
        return view( 'student/profile/studentprofile', compact( 'profile' ) );

    }

    public function updatestudentprofile( Request $request ) {

        $id = Session::get('student_id');

        $updatestudentprofile = DB::table( 'students' )->where( 'id', $id )->update( [
            'student_name'  => $request->student_name,
            'cell_number'   => $request->cell_number,
        ] );

        $stuimg = '';
        if ( $request->photo != null ) {
            $stuimg = $id.'.'.$request->file( 'photo' )->extension();

            $filepath = public_path( 'upload/student'.DIRECTORY_SEPARATOR.'photo'.DIRECTORY_SEPARATOR );
            move_uploaded_file( $_FILES[ 'photo' ][ 'tmp_name' ], $filepath.$stuimg );
            $sql = "update students set photo='$stuimg' where id = $id";
            DB::update( DB::raw( $sql ) );
        }

        return redirect( 'studentprofile' )->with( 'success', 'StudentProfile updated successfully' );
    }
}
