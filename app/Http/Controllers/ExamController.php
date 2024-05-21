<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;
use App\Models\User;

class ExamController extends Controller
{

 public function __construct()
 {
  $this->middleware( 'auth' );
}

public function exam()
{

  return view( 'exam/index' );
}

public function createexam() {
  $sql = "select a.*,b.section_name from exam_schedule a,section b where a.section_id=b.id order by id desc";
  $schedule = DB::select($sql);
  $section  = DB::table( 'section' )->orderBy( 'id', 'Asc' )->get();
  return view('exam/createexam',compact('schedule','section'));
}

public function updateexamschedule(Request $request){
  DB::table( 'exam_schedule' )->where( 'id', $request->id )->update( [
   'title' => $request->title,
   'from_date' => $request->from_date,
   'to_date'   => $request->to_date,
   'section_id' => $request->section_id,
  ]);
  return redirect( 'createexam' );
}

public function saveexamschedule( Request $request )
{
  DB::table( 'exam_schedule' )->insert( [
   'title' => $request->title,
   'from_date' => $request->from_date,
   'to_date' => $request->to_date,
   'section_id' => $request->section_id
] );
  return redirect( 'createexam' );
}

public function summary() {
  $sql = "select section_id,medium_of_study,subject_id,count(*) as ques from exam_question group by section_id,medium_of_study,subject_id order by section_id,medium_of_study,subject_id";
  $questions = DB::select($sql);
  $sub  = DB::table( 'subject' )->orderBy( 'id', 'Asc' )->get();
  $sec  = DB::table( 'section' )->orderBy( 'id', 'Asc' )->get();
  $med  = DB::table( 'medium' )->orderBy( 'id', 'Asc' )->get();
  $section = array();
  foreach($sec as $s){
    $section[$s->id] = $s->section_name;
  }
  $medium = array();
  foreach($med as $s){
    $medium[$s->id] = $s->medium_name;
  }
  $subject = array();
  foreach($sub as $s){
    $subject[$s->id] = $s->subject_name;
  }
  return view( 'exam/summary', compact( 'questions', 'section', 'subject','medium') );
}

public function questions() {
  $sql = "select a.*,b.section_name,c.medium_name,d.subject_name from exam_question a,section b,medium c,subject d where a.section_id=b.id and a.medium_of_study=c.id and a.subject_id=d.id order by id desc";
  $questions = DB::select($sql);
  $subject  = DB::table( 'subject' )->orderBy( 'id', 'Asc' )->get();
  $from_subject  = DB::table( 'subject' )->orderBy( 'id', 'Asc' )->get();
  $section  = DB::table( 'section' )->orderBy( 'id', 'Asc' )->get();
  $from_section  = DB::table( 'section' )->orderBy( 'id', 'Asc' )->get();
  $medium  = DB::table( 'medium' )->orderBy( 'id', 'Asc' )->get();
  $option = array("option_a" => "Option A","option_b" => "Option B","option_c" => "Option C","option_d" => "Option D");
  return view( 'exam/questions', compact( 'questions', 'section', 'subject','medium','option','from_subject','from_section' ) );
}

public function question($id) {
  $sql = "select a.*,b.section_name,c.medium_name,d.subject_name from exam_question a,section b,medium c,subject d where a.section_id=b.id and a.medium_of_study=c.id and a.subject_id=d.id order by id desc";
  $questions = DB::select($sql);
  $subject  = DB::table( 'subject' )->orderBy( 'id', 'Asc' )->get();
  $from_subject  = DB::table( 'subject' )->orderBy( 'id', 'Asc' )->get();
  $section  = DB::table( 'section' )->orderBy( 'id', 'Asc' )->get();
  $from_section  = DB::table( 'section' )->orderBy( 'id', 'Asc' )->get();
  $medium  = DB::table( 'medium' )->orderBy( 'id', 'Asc' )->get();
  $option = array("option_a" => "Option A","option_b" => "Option B","option_c" => "Option C","option_d" => "Option D");
  return view( 'exam/questions', compact( 'questions', 'section', 'subject','medium','option','from_subject','from_section' ) );
}

public function copyquestion( Request $request ){
    $from_section = $request->from_section;
    $to_section = $request->to_section;
    $from_medium = $request->from_medium;
    $to_medium = $request->to_medium;
    $from_subject = $request->from_subject;
    //$sql="delete from exam_question where section_id=$to_section and medium_of_study=$to_medium and subject_id=$from_subject";
    //DB::delete($sql);
    $sql = "select * from exam_question where section_id=$from_section and medium_of_study=$from_medium and subject_id=$from_subject";
    $questions = DB::select($sql);
    foreach($questions as $q){
        DB::table( 'exam_question' )->insert( [
           'section_id' => $to_section,
           'medium_of_study' => $to_medium,
           'question' => $q->question,
           'subject_id' => $from_subject,
           'option_a' => $q->option_a,
           'option_b' => $q->option_b,
           'option_c' => $q->option_c,
           'option_d' => $q->option_d,
           'correct_option' => $q->correct_option,
        ]);
    }
    return redirect('questions')->with( 'success', 'Copied Successfully' );;
}

public function savequestion( Request $request )
{
  $addcustomer = DB::table( 'exam_question' )->insert( [
   'section_id' => $request->section_id,
   'medium_of_study' => $request->medium_of_study,
   'question' => $request->question,
   'subject_id' => $request->subject_id,
   'option_a' => $request->option_a,
   'option_b' => $request->option_b,
   'option_c' => $request->option_c,
   'option_d' => $request->option_d,
   'correct_option' => $request->correct_option,
] );
  return redirect( 'questions' );
}



public function updatequestion( Request $request )
{
  DB::table( 'exam_question' )->where( 'id', $request->id )->update( [
   'section_id' => $request->section_id,
   'medium_of_study' => $request->medium_of_study,
   'question'   => $request->question,
   'subject_id' => $request->subject_id,
   'option_a'   => $request->option_a,
   'option_b'   => $request->option_b,
   'option_c'   => $request->option_c,
   'option_d'   => $request->option_d,
   'correct_option' => $request->correct_option,
] );
  return redirect( 'questions' );
}

}
