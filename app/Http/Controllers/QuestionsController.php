<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;
use App\Models\User;

class QuestionsController extends Controller
 {

    public function __construct()
    {
        $this->middleware( 'auth' );
    }
	
	
    public function section()
    {
        $section = DB::table( 'section' )->orderBy( 'id', 'Asc' )->get();
		
  return view( 'questions/section', compact( 'section' ) );
    }

    public function questionscound($id) 
   {
	   
	   
        $sql = "select count(*) as Tamil from exam_question where subject_id='1' and section_id	 = $id";
            $result = DB::select( DB::raw( $sql ) );
            if ( count( $result ) > 0 ) {
                $Tamil = $result[ 0 ]->Tamil;
            }
			
        $sql = "select count(*) as English from exam_question where subject_id='2' and section_id	 = $id";
            $result = DB::select( DB::raw( $sql ) );
            if ( count( $result ) > 0 ) {
                $English = $result[ 0 ]->English;
            }
     return view( 'questions/questionscound', compact('Tamil','English' ) );
    }

}
