<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Hash;
use Auth;
use DateTime;
class StudentExamController extends Controller
{

    public function examcompleted()
    {
        $user_id=Auth::user()->id;
        $user_type_id=Auth::user()->user_type_id;
        $sql="select cell_number,a.student_name,a.username,a.cpassword,b.section_name,c.medium_name from students a,section b,medium c where a.section_id=b.id and a.medium_id=c.id ";
        if($user_type_id != 1){
            $sql .= " and a.user_id=$user_id";
        }
        $sql .=" and a.status='Active'";
        $sql .=" and a.id not in (select student_id from exam_session)";
        $notcompleted = DB::select($sql);
        $sql="select cell_number,a.student_name,a.username,a.cpassword,b.section_name,c.medium_name from students a,section b,medium c where a.section_id=b.id and a.medium_id=c.id ";
        if($user_type_id != 1){
            $sql .= " and a.user_id=$user_id";
        }
        $sql .=" and a.status='Active'";
        $sql .= " and a.id in (select student_id from exam_session)";
        $completed = DB::select($sql);
        return view( 'users/examcompleted',compact('notcompleted','completed'));
    }

    public function practice(){
        return view( 'student/practice');
    }

    public function saveservice(Request $request){
        $category_id = $request->category_id;
        $student_id = Session::get('id');
        $sql="select id from service where category_id=$category_id and student_id=$student_id";
        $result = DB::select(DB::raw($sql));
        $status = "Pending";
        $service_id = 0;
        if(count($result) > 0){
            $service_id = $result[0]->id;
        }else{
            $service_id = DB::table('service')->insertGetId([
                'student_id' => $student_id,
                'category_id' => $category_id,
                'status'    => 'Pending',
            ]);
        }
        foreach($request->all() as $key => $value){
            if(str_contains($key,'attr_')){ 
                $temp = explode("_",$key);
                $attr_id = $temp[1];
                $attr_type = $temp[2];
                if($attr_type == "text" || $attr_type == "dropdown"){
                    $sql = "delete from service_details where service_id=$service_id and attr_id=$attr_id";
                    DB::delete(DB::raw($sql));
                    $id = DB::table('service_details')->insertGetId([
                        'service_id' => $service_id,
                        'attr_id' => $attr_id,
                        'entry_value'    => $value,
                    ]);
                }
                if($attr_type == "file"){
                    if(trim($_FILES[$key]['name']) != ""){
                        $sql = "delete from service_details where service_id=$service_id and attr_id=$attr_id";
                        DB::delete(DB::raw($sql));
                        $id = DB::table('service_details')->insertGetId([
                            'service_id' => $service_id,
                            'attr_id' => $attr_id,
                        ]);
                        $doc_name = $id . '.' . $request->file($key)->extension();
                        $folder = public_path( 'upload' . DIRECTORY_SEPARATOR . 'student' . DIRECTORY_SEPARATOR . 'documents' . DIRECTORY_SEPARATOR );
                        move_uploaded_file($_FILES[$key]['tmp_name'],$folder.$doc_name);
                        $sql = "update service_details set entry_value='$doc_name' where id=$id";
                        DB::update($sql);
                    }
                }
            }
        }
        return redirect("service/$category_id")->With("success","Application submitted Succesfully");     
    }

    public function service($category_id){
        $status = "";
        $student_id = Session::get('id');
        $service_id = 0;
        $sql="select id from service where category_id=$category_id and student_id=$student_id";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $status = "Pending";
            $service_id = $result[0]->id;
        }
        $sql = "select category_name from category where id = $category_id";
        $result = DB::select(DB::raw($sql));
        $category_name = $result[0]->category_name;
        $sql = "select b.id,b.attr_name,b.attr_type,b.attr_value from category_attribute a,attribute b where a.attr_id = b.id and a.category_id = $category_id order by id";
        $attributes = DB::select(DB::raw($sql));
        //if($service_id != 0){
            $attributes = json_decode(json_encode($attributes),true);
            foreach($attributes as $key => $a){
                $attr_id = $a["id"];
                $attributes[$key]['entry_value'] = "";
                $sql="select entry_value from service_details where attr_id=$attr_id and service_id=$service_id";
                $result = DB::select(DB::raw($sql));
                if(count($result) > 0){
                   $attributes[$key]['entry_value'] = $result[0]->entry_value; 
                }
            }
            $attributes = json_decode(json_encode($attributes));
        //}
        return view( 'student/service',compact('attributes','category_name','category_id','status'));
    }

    public function practiceexam()
    {
        $medium_id = Session::get('medium_id');
        if(!is_null($medium_id)){
            $section_id = Session::get('section_id');
            $student_id = Session::get('id');
            $exam_id = 0;
            $time_remaining = 0;
            $total_minutes = 0;
            $total_seconds = 0;
            $sql = "select * from practice_exam_session where student_id=$student_id and status <> 'Completed'";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $exam_id = $result[0]->id;
                $start_time = date("Y-m-d H:i:s");
                $end_time = $result[0]->end_time;
                $start_datetime = new DateTime($start_time); 
                $diff = $start_datetime->diff(new DateTime($end_time)); 
                $time_remaining = ($diff->h)*60 + $diff->i; 
                $total_minutes = $time_remaining;
                $total_seconds = $diff->s;
                if(new DateTime() > new DateTime($end_time)){
                    $time_remaining = 0;    
                }
            }else{
                $sql9="select * from exam_question where section_id = $section_id and medium_of_study = $medium_id";
                $result9 = DB::select(DB::raw($sql9));
                if(count($result9) > 0){

                }else{
                    return redirect( '/practice' )->with( 'error', "Questions not entered" );   
                }
                $exam_date = date("Y-m-d");
                $start_time = date("Y-m-d H:i:s");
                $end_time = date("Y-m-d H:i:s", strtotime("+60 minutes"));
                $start_datetime = new DateTime($start_time); 
                $diff = $start_datetime->diff(new DateTime($end_time)); 
                $time_remaining = ($diff->h)*60 + $diff->i; 
                $total_minutes = $time_remaining;
                $total_seconds = $diff->s;
                if(new DateTime() > new DateTime($end_time)){
                    $time_remaining = 0;    
                }
                $sql = "insert into practice_exam_session (student_id,exam_date,start_time,end_time,status) values ('$student_id','$exam_date','$start_time','$end_time','Pending')";
                DB::insert($sql);
                $exam_id = DB::getPdo()->lastInsertId();
                Session::put( 'exam_id',$exam_id);
                $ques_count=0;
                $sql = "select * from exam_question where section_id = $section_id and medium_of_study = $medium_id and subject_id=1 order by rand() limit 20";
                $result = DB::select(DB::raw($sql));
                $ques_count = count($result);
                self::insert_question($result,$exam_id,$student_id,"practice_exam_answer");
                $sql = "select * from exam_question where section_id = $section_id and medium_of_study = $medium_id and subject_id=2 order by rand() limit 20";
                $result = DB::select(DB::raw($sql));
                $ques_count = $ques_count + count($result);
                self::insert_question($result,$exam_id,$student_id,"practice_exam_answer");
                $sql = "select distinct subject_id from exam_question where section_id = $section_id and medium_of_study = $medium_id and subject_id not in (1,2)";
                $result2 = DB::select(DB::raw($sql));
                foreach ($result2 as $key2 => $res2) {
                    $subject_id = $res2->subject_id;
                    $noofsubs = count($result2);
                    $limit = floor((100 - $ques_count)/$noofsubs);
                    if($key2 == (count($result2)-1)) $limit = 100 - $ques_count;
                    $sql = "select * from exam_question where section_id = $section_id and medium_of_study = $medium_id and subject_id=$subject_id order by rand() limit $limit";
                    $result = DB::select(DB::raw($sql));
                    $ques_count = $ques_count + count($result);
                    self::insert_question($result,$exam_id,$student_id,"practice_exam_answer");
                }
            }
            $answered = 0;
            $sql = "select * from practice_exam_answer where exam_session_id='$exam_id' and answered_option is not NULL order by id";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $answered = count($result);
            }
            $sql = "select * from practice_exam_answer where exam_session_id='$exam_id' and answered_option is NULL order by id limit 1";
            $question = DB::select(DB::raw($sql));
            $correct_ans = "";
            if($time_remaining > 0){
                return view( 'student/practiceexam',compact('question','time_remaining','answered','total_minutes','total_seconds','correct_ans'));
            }else{
                return redirect( '/practiceresult' );   
            }
        }else{
            return redirect( '/studentlogin' );
        }
    }

    public function practiceanswer($question_id,$answered_option,$student_id)
    {

        $exam_id = 0;
        $student_id = Session::get('id');
        $sql = "select * from practice_exam_session where student_id=$student_id and status <> 'Completed'";
            $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $exam_id = $result[0]->id;
        }
        $correct_option = "";
        $sql = "select correct_option from exam_question where id=$question_id";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $correct_option = $result[0]->correct_option;
        }
        $correct = 0;
        if($answered_option == $correct_option) $correct = 1;
        $answer_date =  date("Y-m-d");
        $answer_time =  date("H:i:s");

        $sql = "update practice_exam_answer set answered_option='$answered_option',correct=$correct,answer_date='$answer_date',answer_time='$answer_time' where exam_session_id=$exam_id and student_id=$student_id and question_id=$question_id";
        DB::update($sql);

        $student_id = Session::get('id');
        $time_remaining = 0;
        $total_minutes = 0;
        $total_seconds = 0;
        $sql = "select * from practice_exam_session where student_id=$student_id and status <> 'Completed'";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $start_time = date("Y-m-d H:i:s");
            $end_time = $result[0]->end_time;
            $start_datetime = new DateTime($start_time); 
            $diff = $start_datetime->diff(new DateTime($end_time)); 
            $time_remaining = ($diff->h)*60 + $diff->i; 
            $total_minutes = $time_remaining;
            $total_seconds = $diff->s;
            //$time_remaining = $total_minutes + $total_seconds/60;      
            if(new DateTime() > new DateTime($end_time)){
                $time_remaining = 0;    
            }
        }
        $answered = 0;
        $sql = "select * from practice_exam_answer where exam_session_id='$exam_id' and answered_option is not NULL order by id";
        $result = DB::select(DB::raw($sql));
        if(count($result)>0){
            $answered = count($result);
        }
        $question = "";
        $correct_ans = "";
        if($correct == 1){
            $sql = "select * from practice_exam_answer where exam_session_id='$exam_id' and answered_option is NULL order by id limit 1";
            $question = DB::select(DB::raw($sql));
        }else{
            $sql = "select * from practice_exam_answer where exam_session_id='$exam_id' and answered_option is NOT NULL order by id desc limit 1";
            $question = DB::select(DB::raw($sql));
            $correct_ans = $correct_option;
        }
        if($time_remaining > 0 and $answered < 100){
            return view( 'student/practiceexam',compact('question','time_remaining','answered','total_minutes','total_seconds','correct_ans'));
        }else{
            $answer_time =  date("Y-m-d H:i");
            $sql = "update practice_exam_session set end_time='$answer_time',status='Completed' where id=$exam_id";
            DB::update($sql);
            return redirect( '/practiceresult' );   
        }
    }

    public function showexam(){
        $examover=false;
        $student_id = Session::get('id');
        $section_id = Session::get('section_id');
        $sql = "select * from exam_session where student_id=$student_id and status='Completed' order by id desc";
        $completed = DB::select(DB::raw($sql));
        $completed = json_decode(json_encode($completed), true);
        foreach($completed as $key =>  $comp){
            $examover=true;
            $exam_id = $comp["id"];
            $exam_schedule_id = $comp["exam_schedule_id"];
            $answered = 0;
            $correct = 0;
            $wrong = 0;
            $title = "";
            $total=0;
            $sql = "select title from exam_schedule where id=$exam_schedule_id";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $title = $result[0]->title;
            }
            $sql = "select count(*) as total from exam_answer where exam_session_id='$exam_id'";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $total = $result[0]->total;
            }
            $sql = "select count(*) as answered from exam_answer where exam_session_id='$exam_id' and answered_option is NOT NULL";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $answered = $result[0]->answered;
            }
            $sql = "select count(*) as correct from exam_answer where exam_session_id='$exam_id' and correct=1 and answered_option is NOT NULL";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $correct = $result[0]->correct;
            }
            $sql = "select count(*) as wrong  from exam_answer where exam_session_id='$exam_id' and correct=0 and answered_option is NOT NULL";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $wrong = $result[0]->wrong;
            }
            $completed[$key]["answered"] = $answered;
            $completed[$key]["correct"] = $correct;
            $completed[$key]["wrong"] = $wrong;
            $completed[$key]["title"] = $title;
            $completed[$key]["total"] = $total;
        }
        $completed = json_decode(json_encode($completed));
        $today = date("Y-m-d");
        $sql="select * from exam_schedule where '$today' >= from_date and  '$today' <= to_date and section_id=$section_id and status is null";
        $exam = DB::select(DB::raw($sql));
        $sql="select * from exam_session where student_id=$student_id and status is null";
        $session = DB::select(DB::raw($sql));
        if(count($session)>0){
            return redirect( '/onlineexam' );   
        }else{
            return view( 'student/showexam',compact('completed','exam','examover'));
        }
    }

    public function onlineexam()
    {

        $medium_id = Session::get('medium_id');
        if(!is_null($medium_id)){
            $section_id = Session::get('section_id');
            $student_id = Session::get('id');
            $exam_id = 0;
            $time_remaining = 0;
            $total_minutes = 0;
            $total_seconds = 0;
            $sql = "select * from exam_session where student_id=$student_id and status is NULL";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $exam_id = $result[0]->id;
                Session::put('exam_id',$exam_id);
                $start_time = date("Y-m-d H:i:s");
                $end_time = $result[0]->end_time;
                $start_datetime = new DateTime($start_time); 
                $diff = $start_datetime->diff(new DateTime($end_time)); 
                $time_remaining = ($diff->h)*60 + $diff->i; 
                $total_minutes = $time_remaining;
                $total_seconds = $diff->s;
                if(new DateTime() > new DateTime($end_time)){
                    $time_remaining = 0;    
                }
            }else{
                $exam_date = date("Y-m-d");
                $start_time = date("Y-m-d H:i:s");
                $end_time = date("Y-m-d H:i:s", strtotime("+60 minutes"));
                $start_datetime = new DateTime($start_time); 
                $diff = $start_datetime->diff(new DateTime($end_time)); 
                $time_remaining = ($diff->h)*60 + $diff->i; 
                $total_minutes = $time_remaining;
                $total_seconds = $diff->s;
                if(new DateTime() > new DateTime($end_time)){
                    $time_remaining = 0;    
                }
                $exam_schedule_id = 0;
                $today = date("Y-m-d");
                $sql="select * from exam_schedule where from_date <= '$today' and to_date >= '$today' and section_id=$section_id and status is null";
                $result = DB::select(DB::raw($sql));
                if(count($result)>0){
                    $exam_schedule_id = $result[0]->id;
                }
                $sql = "insert into exam_session (student_id,exam_date,start_time,end_time,exam_schedule_id) values ('$student_id','$exam_date','$start_time','$end_time',$exam_schedule_id)";
                DB::insert($sql);
                $exam_id = DB::getPdo()->lastInsertId();
                Session::put( 'exam_id',$exam_id);
                
                self::select_questions($section_id,$medium_id,$exam_id,$student_id);   
                
            }
            $answered = 0;
            $sql = "select * from exam_answer where exam_session_id='$exam_id' and answered_option is not NULL order by id";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $answered = count($result);
            }
            $sql = "select * from exam_answer where exam_session_id='$exam_id' and answered_option is NULL order by id limit 1";
            $question = DB::select(DB::raw($sql));
            if($time_remaining > 0){
                return view( 'student/onlineexam',compact('question','time_remaining','answered','total_minutes','total_seconds'));
            }else{
                return redirect( '/examresult' );   
            }
        }else{
            return redirect( '/studentlogin' );
        }
    }

    public function select_questions($section_id,$medium_id,$exam_id,$student_id){
        $ques_count=0;
        $sql = "select * from exam_question where section_id = $section_id and medium_of_study = $medium_id order by rand() limit 100";
        $result = DB::select(DB::raw($sql));
        self::insert_question($result,$exam_id,$student_id,"exam_answer");
    }

    public function result(){
        $sql="select distinct a.*,b.section_name from exam_schedule a,section b where a.section_id=b.id and a.id in(select distinct exam_schedule_id from exam_session where status='Completed')";
        $exams = DB::select(DB::raw($sql));
        return view( 'exam/result',compact('exams'));
    }

    public function saveprizeamount(Request $request){
        if(Auth::user()->user_type_id == "1"){
            $sql="delete from prize_amount";
            DB::delete($sql);
            foreach($request->prize_amount as $key => $amount){
                $amount=trim($amount);
                $student_id = $request->student_id[$key];
                if($amount != ""){
                    $sql="insert into prize_amount (student_id,amount) values ($student_id,$amount)";
                    DB::insert($sql);
                }
            }
        }
        return redirect('/rank');
    }

    public function examrank(){
        $sql="select time_taken,count(correct) as corr,b.student_id from exam_session a,exam_answer b where a.id=b.exam_session_id and correct=1 group by b.student_id,time_taken having corr >= 95 order by count(correct) desc,time_taken asc";
        $top = DB::select(DB::raw($sql));
        $top = json_decode(json_encode($top),true);
        foreach ($top as $key => $t) {
            $student_id = $t["student_id"];
            $sql = "select * from exam_session where student_id = $student_id";
            $result = DB::select(DB::raw($sql));
            $exam_session_id=0;
            if(count($result) > 0){
                $exam_session_id = $result[0]->id;
                $top[$key]["student_id"] = $student_id;
                $top[$key]["exam_session_id"] = $exam_session_id;
                $top[$key]["start_time"] = $result[0]->start_time;
                $top[$key]["end_time"] = $result[0]->end_time;
                $start_time = $top[$key]["start_time"];
                $end_time = $top[$key]["end_time"];
                $start_datetime = new DateTime($start_time); 
                $diff = $start_datetime->diff(new DateTime($end_time)); 
                $total_seconds = ($diff->h)*60*60 + ($diff->i)*60 + $diff->s; 
                $top[$key]["total_seconds"] = $total_seconds;
                $mins_seconds = ($diff->h)*60*60 + ($diff->i)*60;
                if($mins_seconds >= 3600){
                    $mins_seconds = 60*60; 
                }else{
                    $mins_seconds = $mins_seconds + $diff->s; 
                }
                $top[$key]["mins_seconds"] = $mins_seconds;
            }
            $sql = "select student_name,username from students where id = $student_id";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $top[$key]["student_name"] = $result[0]->student_name;
                $top[$key]["username"] = $result[0]->username;
            }
            $top[$key]["prize_amount"]="";
            $sql = "select * from prize_amount where student_id = $student_id";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $top[$key]["prize_amount"] = $result[0]->amount;
            }
        }
        $top = json_decode(json_encode($top));
        return view( 'student/examrank',compact('top'));
    }

    public function examcert(){
        $sql="select time_taken,count(correct) as corr,b.student_id from exam_session a,exam_answer b where a.id=b.exam_session_id and correct=1 group by b.student_id,time_taken having corr >= 75 order by count(correct) desc,time_taken asc";
        $top = DB::select(DB::raw($sql));
        $top = json_decode(json_encode($top),true);
        foreach ($top as $key => $t) {
            $student_id = $t["student_id"];
            $sql = "select student_name,username from students where id = $student_id";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $top[$key]["student_name"] = $result[0]->student_name;
                $top[$key]["username"] = $result[0]->username;
            }
        }
        $top = json_decode(json_encode($top));
        return view( 'student/examcert',compact('top'));
    }

    public function certificate(){
        $sql="select time_taken,count(correct) as corr,b.student_id from exam_session a,exam_answer b where a.id=b.exam_session_id and correct=1 group by b.student_id,time_taken having corr >= 75 order by count(correct) desc,time_taken asc";
        $top = DB::select(DB::raw($sql));
        $top = json_decode(json_encode($top),true);
        foreach ($top as $key => $t) {
            $student_id = $t["student_id"];
            $sql = "select student_name,username from students where id = $student_id";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $top[$key]["student_name"] = $result[0]->student_name;
                $top[$key]["username"] = $result[0]->username;
            }
        }
        $top = json_decode(json_encode($top));
        return view( 'exam/certificate',compact('top'));
    }

    public function rank(){
        $sql="select time_taken,count(correct) as corr,b.student_id from exam_session a,exam_answer b where a.id=b.exam_session_id and correct=1 group by b.student_id,time_taken having corr >= 95 order by count(correct) desc,time_taken asc";
        $top = DB::select(DB::raw($sql));
        $top = json_decode(json_encode($top),true);
        foreach ($top as $key => $t) {
            $student_id = $t["student_id"];
            $sql = "select * from exam_session where student_id = $student_id";
            $result = DB::select(DB::raw($sql));
            $exam_session_id=0;
            if(count($result) > 0){
                $exam_session_id = $result[0]->id;
                $top[$key]["student_id"] = $student_id;
                $top[$key]["exam_session_id"] = $exam_session_id;
                $top[$key]["start_time"] = $result[0]->start_time;
                $top[$key]["end_time"] = $result[0]->end_time;
                $start_time = $top[$key]["start_time"];
                $end_time = $top[$key]["end_time"];
                $start_datetime = new DateTime($start_time); 
                $diff = $start_datetime->diff(new DateTime($end_time)); 
                $total_seconds = ($diff->h)*60*60 + ($diff->i)*60 + $diff->s; 
                $top[$key]["total_seconds"] = $total_seconds;
                $mins_seconds = ($diff->h)*60*60 + ($diff->i)*60;
                if($mins_seconds >= 3600){
                    $mins_seconds = 60*60; 
                }else{
                    $mins_seconds = $mins_seconds + $diff->s; 
                }
                $top[$key]["mins_seconds"] = $mins_seconds;
            }

            /*$total_ques=0;
            $answered_ques=0;
            $wrong_answer=0;
            $sql = "select count(*) as total_ques from exam_answer where student_id = $student_id";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $total_ques=$result[0]->total_ques;
            }
            $sql = "select count(*) as answered_ques from exam_answer where student_id = $student_id and answered_option is not null";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $answered_ques=$result[0]->answered_ques;
            }
            $sql = "select count(*) as wrong_answer from exam_answer where student_id = $student_id and answered_option is not null and correct=0";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $wrong_answer=$result[0]->wrong_answer;
            }
            $sql = "select * from exam_answer where student_id = $student_id and exam_session_id=$exam_session_id and answered_option is not null order by id desc limit 1";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $top[$key]["total_ques"] = $total_ques;
                $top[$key]["answered_ques"] = $answered_ques;
                $top[$key]["wrong_answer"] = $wrong_answer;
                //$top[$key]["end_time"] = $result[0]->answer_time;
                $start_time = $top[$key]["start_time"];
                $end_time = $top[$key]["end_time"];
                $start_datetime = new DateTime($start_time); 
                $diff = $start_datetime->diff(new DateTime($end_time)); 
                $total_seconds = ($diff->h)*60*60 + ($diff->i)*60 + $diff->s; 
                $top[$key]["total_seconds"] = $total_seconds;
                $mins_seconds = ($diff->h)*60*60 + ($diff->i)*60;
                if($mins_seconds >= 3600){
                    $mins_seconds = 60*60; 
                }else{
                    $mins_seconds = $mins_seconds + $diff->s; 
                }
                $top[$key]["mins_seconds"] = $mins_seconds;
            }*/

            $sql = "select student_name,username from students where id = $student_id";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $top[$key]["student_name"] = $result[0]->student_name;
                $top[$key]["username"] = $result[0]->username;
            }
            $top[$key]["prize_amount"]="";
            $sql = "select * from prize_amount where student_id = $student_id";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $top[$key]["prize_amount"] = $result[0]->amount;
            }
        }
        $top = json_decode(json_encode($top));
        return view( 'exam/rank',compact('top'));
    }

    public function topper($exam_id){
        $sql="select time_taken,count(correct) as corr,b.student_id from exam_session a,exam_answer b where a.id=b.exam_session_id  and a.exam_schedule_id=$exam_id and correct=1 group by b.student_id,time_taken order by count(correct) desc,time_taken";
        $top = DB::select(DB::raw($sql));
        $top = json_decode(json_encode($top),true);
        foreach ($top as $key => $t) {
            $student_id = $t["student_id"];
            $sql = "select * from exam_session where student_id = $student_id and exam_schedule_id=$exam_id";
            $result = DB::select(DB::raw($sql));
            $exam_session_id=0;
            if(count($result) > 0){
                $exam_session_id = $result[0]->id;
                $top[$key]["exam_session_id"] = $exam_session_id;
                $top[$key]["start_time"] = $result[0]->start_time;
                $top[$key]["end_time"] = $result[0]->start_time;
            }

            $total_ques=0;
            $answered_ques=0;
            $wrong_answer=0;
            $sql = "select count(*) as total_ques from exam_answer where student_id = $student_id";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $total_ques=$result[0]->total_ques;
            }
            $sql = "select count(*) as answered_ques from exam_answer where student_id = $student_id and answered_option is not null";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $answered_ques=$result[0]->answered_ques;
            }
            $sql = "select count(*) as wrong_answer from exam_answer where student_id = $student_id and answered_option is not null and correct=0";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $wrong_answer=$result[0]->wrong_answer;
            }
            $sql = "select * from exam_answer where student_id = $student_id and exam_session_id=$exam_session_id and answered_option is not null order by id desc limit 1";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $top[$key]["total_ques"] = $total_ques;
                $top[$key]["answered_ques"] = $answered_ques;
                $top[$key]["wrong_answer"] = $wrong_answer;
                $top[$key]["end_time"] = $result[0]->answer_time;
                $start_time = $top[$key]["start_time"];
                $end_time = $top[$key]["end_time"];
                $start_datetime = new DateTime($start_time); 
                $diff = $start_datetime->diff(new DateTime($end_time)); 
                $total_seconds = ($diff->h)*60*60 + ($diff->i)*60 + $diff->s; 
                $top[$key]["total_seconds"] = $total_seconds;
                $mins_seconds = ($diff->h)*60*60 + ($diff->i);
                if($mins_seconds >= 60){
                    $mins_seconds = "60 mins"; 
                }else{
                    $mins_seconds = $mins_seconds ." mins ". $diff->s. " secs"; 
                }
                $top[$key]["mins_seconds"] = $mins_seconds;
            }

            $sql = "select * from students where id = $student_id";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $top[$key]["student_name"] = $result[0]->student_name;
                $top[$key]["adhaar_number"] = $result[0]->adhaar_number;
            }
        }
        $top = json_decode(json_encode($top));
        return view( 'exam/topper',compact('top'));
    }

    public function distop($exam_id){
        $sql="select time_taken,count(correct) as corr,b.student_id,c.dist_id from exam_session a,exam_answer b,students c where a.id=b.exam_session_id and b.student_id=c.id and a.exam_schedule_id=$exam_id and correct=1 group by c.dist_id,b.student_id,time_taken order by count(correct) desc,time_taken";
        $top = DB::select(DB::raw($sql));
        $top = json_decode(json_encode($top),true);
        foreach ($top as $key => $t) {
            $student_id = $t["student_id"];

            $sql = "select * from exam_session where student_id = $student_id and exam_schedule_id=$exam_id";
            $result = DB::select(DB::raw($sql));
            $exam_session_id=0;
            if(count($result) > 0){
                $exam_session_id = $result[0]->id;
                $top[$key]["start_time"] = $result[0]->start_time;
                $top[$key]["end_time"] = $result[0]->start_time;
            }

            /*$sql = "select * from exam_answer where student_id = $student_id and exam_session_id=$exam_session_id and answered_option is not null order by id desc limit 1";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $top[$key]["end_time"] = $result[0]->answer_time;
                $start_time = $top[$key]["start_time"];
                $end_time = $top[$key]["end_time"];
                $start_datetime = new DateTime($start_time); 
                $diff = $start_datetime->diff(new DateTime($end_time)); 
                $total_seconds = ($diff->h)*60*60 + ($diff->i)*60 + $diff->s; 
                $top[$key]["total_seconds"] = $total_seconds;
                $mins_seconds = ($diff->h)*60*60 + ($diff->i) ." mins ". $diff->s. " secs"; 
                $top[$key]["mins_seconds"] = $mins_seconds;
            }*/

            $dist_id = $t["dist_id"];
            $sql = "select * from district where id = $dist_id";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $top[$key]["district_name"] = $result[0]->district_name;
            }
            $sql = "select * from students where id = $student_id";
            $result = DB::select(DB::raw($sql));
            if(count($result) > 0){
                $top[$key]["student_name"] = $result[0]->student_name;
                $top[$key]["adhaar_number"] = $result[0]->adhaar_number;
            }
        }
        $top = json_decode(json_encode($top));
        return view( 'exam/distop',compact('top'));
    }

    public function examresult(){
        $exam_id = Session::get('exam_id');
        $student_id = Session::get('id');
        $answered = 0;
        $correct = 0;
        $wrong = 0;
        $total=0;
        $sql = "select count(*) as total from exam_answer where student_id='$student_id'";
        $result = DB::select(DB::raw($sql));
        if(count($result)>0){
            $total = $result[0]->total;
        }
        $sql = "select count(*) as answered from exam_answer where student_id='$student_id' and answered_option is NOT NULL";
        $result = DB::select(DB::raw($sql));
        if(count($result)>0){
            $answered = $result[0]->answered;
        }
        $sql = "select count(*) as correct from exam_answer where student_id='$student_id' and correct=1 and answered_option is NOT NULL";
        $result = DB::select(DB::raw($sql));
        if(count($result)>0){
            $correct = $result[0]->correct;
        }
        $sql = "select count(*) as wrong  from exam_answer where student_id='$student_id' and correct=0 and answered_option is NOT NULL";
        $result = DB::select(DB::raw($sql));
        if(count($result)>0){
            $wrong = $result[0]->wrong;
        }

        $sql = "select * from exam_answer where student_id='$student_id' and correct=0 and answered_option is NOT NULL";
        $wrong_answers = DB::select(DB::raw($sql));
        return view( 'student/examresult',compact('total','answered','correct','wrong','wrong_answers'));
    }

    public function allpracticeresult(){
        $student_id = Session::get('id');
        $sql = "select * from practice_exam_session where student_id=$student_id and status='Completed' order by id desc";
        $exams = DB::select(DB::raw($sql));
        $exams = json_decode(json_encode($exams), true);
        foreach($exams as $key =>  $exam){
            $exam_id = $exam["id"];
            $answered = 0;
            $correct = 0;
            $wrong = 0;
            $sql = "select count(*) as answered from practice_exam_answer where exam_session_id='$exam_id' and answered_option is NOT NULL";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $answered = $result[0]->answered;
            }
            $sql = "select count(*) as correct from practice_exam_answer where exam_session_id='$exam_id' and correct=1 and answered_option is NOT NULL";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $correct = $result[0]->correct;
            }
            $sql = "select count(*) as wrong  from practice_exam_answer where exam_session_id='$exam_id' and correct=0 and answered_option is NOT NULL";
            $result = DB::select(DB::raw($sql));
            if(count($result)>0){
                $wrong = $result[0]->wrong;
            }
            $exams[$key]["answered"] = $answered;
            $exams[$key]["correct"] = $correct;
            $exams[$key]["wrong"] = $wrong;
        }
        $exams = json_decode(json_encode($exams));
        //dd($exams);
        return view( 'student/allpracticeresult',compact('exams'));
    }

    public function practiceresult(){
        $exam_id = Session::get('exam_id');
        $answered = 0;
        $correct = 0;
        $wrong = 0;
        $sql = "select count(*) as answered from practice_exam_answer where exam_session_id='$exam_id' and answered_option is NOT NULL";
        $result = DB::select(DB::raw($sql));
        if(count($result)>0){
            $answered = $result[0]->answered;
        }
        $sql = "select count(*) as correct from practice_exam_answer where exam_session_id='$exam_id' and correct=1 and answered_option is NOT NULL";
        $result = DB::select(DB::raw($sql));
        if(count($result)>0){
            $correct = $result[0]->correct;
        }
        $sql = "select count(*) as wrong  from practice_exam_answer where exam_session_id='$exam_id' and correct=0 and answered_option is NOT NULL";
        $result = DB::select(DB::raw($sql));
        if(count($result)>0){
            $wrong = $result[0]->wrong;
        }
        return view( 'student/practiceresult',compact('answered','correct','wrong'));
    }

    private function insert_question($result,$exam_id,$student_id,$table_name){
        foreach ($result as $res) {
            $question_id = $res->id;
            $question = $res->question;
            $option_a = $res->option_a;
            $option_b = $res->option_b;
            $option_c = $res->option_c;
            $option_d = $res->option_d;
            $correct_option = $res->correct_option;
            DB::table($table_name)->insert( [
                'exam_session_id' => $exam_id,
                'student_id' => $student_id,
                'question_id' => $question_id,
                'question' => $question,
                'option_a' => $option_a,
                'option_b' => $option_b,
                'option_c' => $option_c,
                'option_d' => $option_d,
                'correct_option' => $correct_option,
            ]);
        }
    }

    public function finishexam(){
        $exam_session_id = Session::get('exam_session_id');
        $start_time = date("Y-m-d H:i:s");
        $sql="select start_time from exam_session where id=$exam_session_id";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $start_time = $result[0]->start_time;
        }
        $answer_time =  date("Y-m-d H:i:s");
        $start_datetime = new DateTime($start_time); 
        $diff = $start_datetime->diff(new DateTime($answer_time)); 
        $time_taken = ($diff->h)*60*60 + ($diff->i)*60 + $diff->s; 
        $sql = "update exam_session set c='$answer_time',status='Completed',time_taken='$time_taken' where id=$exam_session_id";
        DB::update($sql);
        return redirect( '/viewresult' );
    }

    

    public function saveanswer($question_id,$answered_option,$student_id)
    {
        $sql="select * from exam_answer where student_id=$student_id";
        $result=DB::select($sql);
        if(count($result) == 0){
            return redirect( '/showexam' );
        }
        $exam_id = Session::get('exam_id');
        $correct_option = "";
        $sql = "select correct_option from exam_question where id=$question_id";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $correct_option = $result[0]->correct_option;
        }
        $correct = 0;
        if($answered_option == $correct_option) $correct = 1;
        $answer_date =  date("Y-m-d");
        $answer_time =  date("Y-m-d H:i:s");

        $sql = "update exam_answer set answered_option='$answered_option',correct=$correct,answer_date='$answer_date',answer_time='$answer_time' where exam_session_id=$exam_id and student_id=$student_id and question_id=$question_id";
        DB::update($sql);

        $student_id = Session::get('id');
        $time_remaining = 0;
        $sql = "select * from exam_session where student_id=$student_id and status is NULL";
        $result = DB::select(DB::raw($sql));
        if(count($result) > 0){
            $exam_id = Session::get('exam_id');
            $start_time = date("Y-m-d H:i:s");
            $end_time = $result[0]->end_time;
            $start_datetime = new DateTime($start_time); 
            $diff = $start_datetime->diff(new DateTime($end_time)); 
            $time_remaining = ($diff->h)*60 + $diff->i; 
            if(new DateTime() > new DateTime($end_time)){
                $time_remaining = 0;    
            }
        } 
        $answered = 0;
        $sql = "select * from exam_answer where exam_session_id='$exam_id' and answered_option is not NULL order by id";
        $result = DB::select(DB::raw($sql));
        if(count($result)>0){
            $answered = count($result);
        }
        $sql = "select * from exam_answer where exam_session_id='$exam_id' and answered_option is NULL order by id limit 1";
        $question = DB::select(DB::raw($sql));
        if($time_remaining > 0 and $answered < 100){
            return redirect( '/onlineexam' );   
        }else{
            $sql = "update exam_session set end_time='$answer_time',status='Completed' where id=$exam_id";
            DB::update($sql);
            return redirect( '/examresult' );   
        }
    }

    public function viewresult(){
        $exam_session_id = Session::get('exam_session_id');
        $total_questions = 0;
        $answered_questions = 0;
        $correct_answer = 0;
        $wrong_answer = 0;
        $sql = "select count(*) as total_questions from exam_answer where exam_session_id=$exam_session_id";
        $result = DB::select(DB::raw($sql));
        $total_questions = $result[0]->total_questions;
        $sql = "select count(*) as answered_questions from exam_answer where exam_session_id=$exam_session_id and answered_option is not null";
        $result = DB::select(DB::raw($sql));
        $answered_questions = $result[0]->answered_questions;
        $sql = "select count(*) as correct_answer from exam_answer where exam_session_id=$exam_session_id and answered_option is not null and correct=1";
        $result = DB::select(DB::raw($sql));
        $correct_answer = $result[0]->correct_answer;
        $sql = "select count(*) as wrong_answer from exam_answer where exam_session_id=$exam_session_id and answered_option is not null and correct=0";
        $result = DB::select(DB::raw($sql));
        $wrong_answer = $result[0]->wrong_answer;
        return view( 'student/viewresult',compact('total_questions','answered_questions','correct_answer','wrong_answer'));
    }

    public function studentchangepassword()
    {
        $id = Session::get("student_id");

        return view( 'student/profile/studentchangepassword' );
    }

    public function studentupdatepassword( Request $request ) {
        $id = Session::get("student_id");
        $old_password = trim( $request->get( 'oldpassword' ) );
        $currentPassword = Session::get('password');
        if ( Hash::check( $old_password, $currentPassword ) ) {
            $new_password = trim( $request->get( 'new_password' ) );
            $confirm_password = trim( $request->get( 'confirm_password' ) );
            if ( $new_password != $confirm_password ) {
                return redirect( 'studentchangepassword' )->with( 'error', 'Passwords does not match' );
            } else {
                $updatepass = DB::table( 'students' )->where( 'id', '=', $id )->update( [
                    'password' => Hash::make( $new_password ),
                    'cpassword'      => $request->new_password,
                ] );
                return redirect( 'studentchangepassword' )->with( 'success', 'Passwords Change Succesfully' );
            }
        } else {
            return redirect( 'studentchangepassword' )->with( 'error', 'Sorry, your current password was not recognised' );
        }
    }

}
