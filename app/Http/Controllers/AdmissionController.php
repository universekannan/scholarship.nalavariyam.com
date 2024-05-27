<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;
use App\Models\User;

class AdmissionController extends Controller
{

    public function __construct()
    {
        $this->middleware( 'auth' );
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
	 
    public function edu_type()
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
	
    public function department($id)
    {
        $department = DB::table('department')->select('department.*')->Join( 'assigned_department', 'assigned_department.department_id', '=', 'department.id' )->where('assigned_department.institute_id',$id)->orderBy('id', 'Asc')->get();

        $assigndepartment = DB::table('department')->orderBy('id', 'Asc')->get();
        $assigndepartment = json_decode( json_encode( $assigndepartment ), true );
            foreach ( $assigndepartment as $key => $s ) {
              $dept_id = $s[ 'id' ];
              $sql2 = "select department_id from assigned_department where department_id=$dept_id and institute_id = $id";
              $result = DB::select( DB::raw( $sql2 ) );
              $department_id = 0;
              if ( count( $result ) > 0 ) {
                $department_id = $result[ 0 ]->department_id;
              }
              $assigndepartment[ $key ][ 'department_id' ] = $department_id;
            }
            $assigndepartment = json_decode( json_encode( $assigndepartment ) );
            //echo "<pre>";print_r($assigndepartment);echo "</pre>";die;
    	return view('/admission/department', compact('department','id','assigndepartment'));
    }
	
	public function assigndepartment(Request $request)
    {
        $department = $request->input('dep');
        $institute_id = $request->ins_id;
        DB::table('assigned_department')->where('institute_id', $institute_id)->delete();
        if($department == ""){
            DB::table('assigned_department')->where('institute_id', $institute_id)->delete();
        }else{
            foreach($department as $dep){
                DB::table('assigned_department')->insert([
                    'department_id' => $dep,
                    'institute_id' => $institute_id
                ]);
            }
        }
        
    	return redirect()->back()->with('success', 'Add Department Successfully ... !');
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
    	return redirect()->back()->with('success', 'Delete Department Successfully ... !');
    }
    
    public function colleges()
    {
        $colleges = DB::table('colleges')->select('colleges.*','edutype.edutype_name')
		->Join( 'edutype', 'edutype.id', '=', 'colleges.edutype_id' )
		->orderBy('colleges.id', 'Asc')->get();
        //dd($colleges);

        $districts = DB::table('district')->orderBy('id', 'Asc')->get();
        $edutype = DB::table('edutype')->orderBy('id', 'Asc')->get();
        
    	return view('/admission/colleges', compact('colleges','districts','edutype'));
    }
	
    public function addcolleges(Request $request)
    {
        DB::table('colleges')->insert([
            'district_id' => $request->district_id,
            'edutype_id' => $request->edutype_id,
            'college_name' => $request->college_name,
    	]);
    	return redirect()->back()->with('success', 'Add colleges Successfully ... !');
    } 
    public function updatecolleges(Request $request)
    {
        DB::table('colleges')->where('id',$request->row_id)->update([
            'district_id' => $request->district_id,
            'edutype_id' => $request->edutype_id,
            'college_name' => $request->college_name,
        ]);
        
    	return redirect()->back()->with('success', 'Update colleges Successfully ... !');
    } 
    public function deletecolleges($id)
    {
        DB::table('colleges')->where('id', $id)->delete();
    	return redirect()->back()->with('success', 'Delete Department Successfully ... !');
    }
    
    public function courses($id)
    {
        $courses = DB::table('department')->where('edutype_id', $id)->orderBy('id', 'Asc')->get();
        return view('admission/courses', compact('courses','id'));
    }
	
    public function addcourses(Request $request)
    {
        DB::table('department')->insert([
            'edutype_id' => $request->edutype_id,
            'department_name' => $request->department_name,
            'status' => 'Active'
        ]);
        return redirect()->back()->with('success', 'Add Department Successfully ...!');
    }
	
    public function updatecourses(Request $request)
    {
        DB::table('department')->where('id',$request->id)->update([
            'department_name' => $request->department_name,
            'status' => $request->status,
        ]);
        return redirect()->back()->with('success', 'Update Department Successfully ...!');
    }
	
    public function deletecourses($id)
    {
        DB::table('department')->where('id', $id)->delete();
    	return redirect()->back()->with('success', 'Delete Department Successfully ... !');
    }
	   
	public function edustudents()
    {
    	$edustudents = DB::table('students')->whereIn('section_id', array(12, 13, 14, 15, 16, 18))->orderBy('id', 'Asc')->get();
        $edustudents = json_decode( json_encode( $edustudents ), true );
        foreach ($edustudents as $key => $s) {
             $studentid = $s[ 'id' ];
              $sql2 = "select id from assigned_college where student_id = $studentid";
              $result = DB::select( DB::raw( $sql2 ));
              $checkflg = 0;
              if(count($result) > 0){
                $checkflg = 1;
              }
              $edustudents[ $key ][ 'checkflg' ] = $checkflg;
        }
        $edustudents = json_decode( json_encode( $edustudents ));
		//dd($edustudents);
    	return view('/admission/edustudents', compact('edustudents'));
    }

        public function assigncollege($studentid)
    {
        $department = DB::table('department')->orderBy('id', 'Asc')->get();
         $managedistrict  = DB::table( 'district' )->orderBy( 'id', 'Asc' )->get();
         $edutype  = DB::table( 'edutype' )->orderBy( 'id', 'Asc' )->get();
        return view('/admission/assignstudent',compact('department','managedistrict','edutype','studentid'));
    }

    public function saveassigncollege(Request $request)
    {
        $colleges = $request->input('college_id');
        $student_id = $request->studentid;
        $dist_id = $request->dist_id;
        $edutype_id = $request->edutype_id;
        $department_id = $request->department_id;
        
            foreach($colleges as $college){
                
                DB::table('assigned_college')->insert([
                    'student_id' => $student_id,
                    'dist_id'    => $dist_id,
                    'edutype_id' => $edutype_id,
                    'department_id' => $department_id,
                    'college_id' => $college
                ]);
            }
        
        return redirect()->back()->with('success', 'Success');
    }

    public function getcollege($distid,$edutypeid,$departmentid)
    {
        $department = DB::table('department')->where('id',$departmentid)->get();
        $department = json_decode( json_encode( $department ), true );
            foreach ( $department as $key => $s ) {
            $department[ $key ][ 'colleges' ] = array();
              $departmentid = $s[ 'id' ];
              $sql2 = "select a.* from colleges a,assigned_department b where a.id = b.institute_id and b.department_id = $departmentid and a.district_id = $distid and a.edutype_id = $edutypeid";
              $result = DB::select( DB::raw( $sql2 ) );
              $department[ $key ][ 'colleges' ] = $result;
            }
            $department = json_decode( json_encode( $department ) );
            //echo "<pre>";print_r($department);echo "</pre>";die;

        return response()->json( $department );
    }

    public function viewassigncollege($studentid)
    {
        $edustudents = DB::table('students')->select('students.id','students.student_name','edutype.edutype_name','district.district_name','department.department_name','department.id as deptid')
            ->Join( 'assigned_college', 'assigned_college.student_id', '=', 'students.id' ) ->Join( 'edutype', 'edutype.id', '=', 'assigned_college.edutype_id' )
            ->Join( 'department', 'department.id', '=', 'assigned_college.department_id' )
            ->Join( 'district', 'district.id', '=', 'assigned_college.dist_id' )->where('students.id',$studentid)
            ->orderBy('assigned_college.id', 'Asc')->groupby('students.id')->groupby('students.student_name')->groupby('edutype.edutype_name')->groupby('district.district_name')->groupby('department.department_name')->groupby('department.id')->get();

        $edustudents = json_decode( json_encode( $edustudents ), true );
        foreach ($edustudents as $key => $s) {
             $studentid = $s[ 'id' ];
             $deptid = $s[ 'deptid' ];
              $colleges = DB::table('colleges')->select('colleges.college_name')
            ->Join( 'assigned_college', 'assigned_college.college_id', '=', 'colleges.id' )->where('assigned_college.department_id',$deptid)
            ->orderBy('colleges.id', 'Asc')->groupby('colleges.college_name')->get();
              $edustudents[ $key ][ 'colleges' ] = $colleges;
        }
        $edustudents = json_decode( json_encode( $edustudents ));
        //echo "<pre>";print_r($edustudents);echo "</pre>";die;
        
        return view('/admission/viewassignstudent',compact('edustudents'));
    }

	
}
