<?php
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\JoinController::class, 'home'])->name('home');
Route::get('/home', [App\Http\Controllers\JoinController::class, 'home'])->name('home');
Route::get('/about_us', [App\Http\Controllers\JoinController::class, 'about_us'])->name('about_us');
Route::get('/institute', [App\Http\Controllers\JoinController::class, 'institute'])->name('institute');
Route::get('/schemes', [App\Http\Controllers\JoinController::class, 'schemes'])->name('schemes');
Route::get('/enquiry', [App\Http\Controllers\JoinController::class, 'enquiry'])->name('enquiry');
Route::get('/contact_us', [App\Http\Controllers\JoinController::class, 'contact_us'])->name('contact_us');
Route::get('/supcoordinators', [App\Http\Controllers\JoinController::class, 'supcoordinators'])->name('supcoordinators');
Route::get('/coordinators', [App\Http\Controllers\JoinController::class, 'coordinators'])->name('coordinators');

Route::get('/join/{id}', [App\Http\Controllers\Student\StudentLoginController::class, 'join'])->name('join');
Route::POST('/savejoin', [App\Http\Controllers\Student\StudentLoginController::class, 'savejoin'])->name('savejoin');

Auth::routes();

Route::get('/category', [App\Http\Controllers\CategoryController::class, 'manageCategory'])->name('category');
Route::get('/attribute', [App\Http\Controllers\CategoryController::class, 'attribute'])->name('attribute');
Route::get('/catattribute', [App\Http\Controllers\CategoryController::class, 'catattribute'])->name('catattribute');
ROUTE::post('/addattribute', [App\Http\Controllers\CategoryController::class, 'AddAttribute'])->name('addattribute');
ROUTE::post('/linkattribute', [App\Http\Controllers\CategoryController::class, 'linkattribute'])->name('linkattribute');
ROUTE::post('/getsubcategory', [App\Http\Controllers\CategoryController::class, 'getsubcategory'])->name('getsubcategory');
Route::Post('/getattributes', [App\Http\Controllers\CategoryController::class, 'getattributes'])->name('getattributes');
Route::get('/deleteattribute/{id}', [App\Http\Controllers\CategoryController::class, 'deleteattribute'])->name('deleteattribute');
Route::get('/deleteattributelink/{id}', [App\Http\Controllers\CategoryController::class, 'deleteattributelink'])->name('deleteattributelink');
ROUTE::post('/addcategory', [App\Http\Controllers\CategoryController::class, 'AddCategory'])->name('addcategory');
ROUTE::post('/addsubcategory', [App\Http\Controllers\CategoryController::class, 'AddSubCategory'])->name('addsubcategory');
ROUTE::post('/editcategory', [App\Http\Controllers\CategoryController::class, 'EditCategory'])->name('editcategory');
ROUTE::get('/subcategory/{id}', [App\Http\Controllers\CategoryController::class, 'manageSubcategory'])->name('subcategory');
ROUTE::post('/editsubcategory', [App\Http\Controllers\CategoryController::class, 'EditSubCategory'])->name('editsubcategory');
Route::get('/deletesubcategory/{id}', [App\Http\Controllers\CategoryController::class, 'DeleteSubcat'])->name('deletesubcategory');

Route::get('/payment_history', [App\Http\Controllers\PaymentController::class, 'payment_history'])->name('payment_history');



Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');

Route::get('/admins', [App\Http\Controllers\UsersController::class, 'admins'])->name('admins');
Route::POST('/adduser', [App\Http\Controllers\UsersController::class, 'adduser'])->name('adduser');
Route::POST('/edituser', [App\Http\Controllers\UsersController::class, 'edituser'])->name('edituser');
Route::POST('/activeadmin', [App\Http\Controllers\UsersController::class, 'activeadmin'])->name('activeadmin');
Route::get('/userstatusupdate/{id}', [App\Http\Controllers\UsersController::class, 'userstatusupdate'])->name('userstatusupdate');
Route::POST('/duplicate_username', [App\Http\Controllers\UsersController::class, 'duplicate_username'])->name('duplicate_username');

Route::get('/instudents/{id}', [App\Http\Controllers\InstitutesController::class, 'instudents'])->name('instudents');
Route::get('/students', [App\Http\Controllers\UsersController::class, 'students'])->name('students');
Route::get('/ssummary', [App\Http\Controllers\UsersController::class, 'ssummary'])->name('ssummary');
Route::get('/usummary', [App\Http\Controllers\UsersController::class, 'usummary'])->name('usummary');
Route::get('/institutesummary', [App\Http\Controllers\UsersController::class, 'institutesummary'])->name('institutesummary');
Route::get('/addstudent', [App\Http\Controllers\UsersController::class, 'addstudent'])->name('addstudent');
Route::post('/savestudent', [App\Http\Controllers\UsersController::class, 'savestudent'])->name('savestudent');
Route::get('/editstudent/{id}', [App\Http\Controllers\UsersController::class, 'editstudent'])->name('editstudent');
Route::post('/updatestudent', [App\Http\Controllers\UsersController::class, 'updatestudent'])->name('updatestudent');
Route::post('/updatestatus', [App\Http\Controllers\UsersController::class, 'studentstatusupdate'])->name('updatestatus');
Route::post('/institutestudentsactivate', [App\Http\Controllers\UsersController::class, 'institutestudentsactivate'])->name('institutestudentsactivate');

Route::get('/admission/districts', [App\Http\Controllers\AdmissionController::class, 'districts'])->name('districts');
Route::post('/adddistrict', [App\Http\Controllers\AdmissionController::class, 'adddistrict'])->name('adddistrict');
Route::post('/updatedistrict', [App\Http\Controllers\AdmissionController::class, 'updatedistrict'])->name('updatedistrict');
Route::get('/deletedistrict/{id}', [App\Http\Controllers\AdmissionController::class, 'deletedistrict'])->name('deletedistrict');

Route::get('/admission/edu_type', [App\Http\Controllers\AdmissionController::class, 'edu_type'])->name('edu_type');
Route::post('/addedutype', [App\Http\Controllers\AdmissionController::class, 'addedutype'])->name('addedutype');
Route::post('/updateedutype', [App\Http\Controllers\AdmissionController::class, 'updateedutype'])->name('updateedutype');
Route::get('/deleteedutype/{id}', [App\Http\Controllers\AdmissionController::class, 'deleteedutype'])->name('deleteedutype');
Route::get('/admission/edustudents', [App\Http\Controllers\AdmissionController::class, 'edustudents'])->name('edustudents');
Route::get('/admission/assigncollege/{studentid}', [App\Http\Controllers\AdmissionController::class, 'assigncollege'])->name('assigncollege');

Route::get('/getcolleges/{distid}/{edutypeid}/{deptid}', [App\Http\Controllers\AdmissionController::class, 'getcollege'])->name('getcollege');
Route::get('/getdepartment/{edutypeid}', [App\Http\Controllers\AdmissionController::class, 'getdepartment'])->name('getdepartment');

Route::post('/admission/saveassigncollege', [App\Http\Controllers\AdmissionController::class, 'saveassigncollege'])->name('saveassigncollege');
Route::get('/admission/viewassigncollege/{studentid}', [App\Http\Controllers\AdmissionController::class, 'viewassigncollege'])->name('viewassigncollege');

Route::get('/admission/institution/{id}', [App\Http\Controllers\AdmissionController::class, 'institution'])->name('institution');
Route::post('/addinstitution', [App\Http\Controllers\AdmissionController::class, 'addinstitution'])->name('addinstitution');
Route::post('/updateinstitution', [App\Http\Controllers\AdmissionController::class, 'updateinstitution'])->name('updateinstitution');
Route::get('/deleteinstitution/{id}', [App\Http\Controllers\AdmissionController::class, 'deleteinstitution'])->name('deleteinstitution');

Route::get('/admission/department/{id}', [App\Http\Controllers\AdmissionController::class, 'department'])->name('department');
Route::post('/adddepartment', [App\Http\Controllers\AdmissionController::class, 'adddepartment'])->name('adddepartment');
Route::post('/updatedepartment', [App\Http\Controllers\AdmissionController::class, 'updatedepartment'])->name('updatedepartment');
Route::get('/deletedepartment/{id}', [App\Http\Controllers\AdmissionController::class, 'deletedepartment'])->name('deletedepartment');

Route::get('/admission/courses/{id}', [App\Http\Controllers\AdmissionController::class, 'courses'])->name('courses');
Route::post('/addcourses', [App\Http\Controllers\AdmissionController::class, 'addcourses'])->name('addcourses');
Route::post('/updatecourses', [App\Http\Controllers\AdmissionController::class, 'updatecourses'])->name('updatecourses');
Route::get('/deletecourses/{id}', [App\Http\Controllers\AdmissionController::class, 'deletecourses'])->name('deletecourses');



Route::get('/admission/colleges', [App\Http\Controllers\AdmissionController::class, 'colleges'])->name('colleges');
Route::post('/addcolleges', [App\Http\Controllers\AdmissionController::class, 'addcolleges'])->name('addcolleges');
Route::post('/updatecolleges', [App\Http\Controllers\AdmissionController::class, 'updatecolleges'])->name('updatecolleges');
Route::get('/deletecolleges/{id}', [App\Http\Controllers\AdmissionController::class, 'deletecolleges'])->name('deletecolleges');

Route::post('/assigndepartment', [App\Http\Controllers\AdmissionController::class, 'assigndepartment'])->name('assigndepartment');

Route::get('/createexam', [App\Http\Controllers\ExamController::class, 'createexam'])->name('createexam');
Route::get('/questions', [App\Http\Controllers\ExamController::class, 'questions'])->name('questions');
Route::get('/summary', [App\Http\Controllers\ExamController::class, 'summary'])->name('summary');
Route::get('/question/{id}', [App\Http\Controllers\ExamController::class, 'question'])->name('question');
Route::post('/savequestion', [App\Http\Controllers\ExamController::class, 'savequestion'])->name('savequestion');
Route::post('/copyquestion', [App\Http\Controllers\ExamController::class, 'copyquestion'])->name('copyquestion');
Route::post('/updatequestion', [App\Http\Controllers\ExamController::class, 'updatequestion'])->name('updatequestion');
Route::post('/saveexamschedule', [App\Http\Controllers\ExamController::class, 'saveexamschedule'])->name('saveexamschedule');
Route::post('/updateexamschedule', [App\Http\Controllers\ExamController::class, 'updateexamschedule'])->name('updateexamschedule');


Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'profile'])->name('profile');
Route::post('/updateprofile', [App\Http\Controllers\ProfileController::class, 'updateprofile'])->name('updateprofile');
Route::get('/changepassword', [App\Http\Controllers\UsersController::class, 'changepassword'])->name('changepassword');
Route::get('/bgdark/{user_id}', [App\Http\Controllers\DashboardController::class, 'bgdark'])->name('bgdark');

Route::get('/wallet', [App\Http\Controllers\DashboardController::class, 'wallet'])->name('wallet');
Route::get('/payments/{from}/{to}', [App\Http\Controllers\DashboardController::class, 'payments'])->name('payments');
Route::get('/paymentrequest', [App\Http\Controllers\PaymentController::class, 'paymentrequest'])->name('paymentrequest');
Route::post('/create_paymentrequest', [App\Http\Controllers\PaymentController::class, 'create_paymentrequest'])->name('create_paymentrequest');
Route::post('/approvepayment', [App\Http\Controllers\PaymentController::class, 'approvepayment'])->name('approvepayment');
Route::get('/declinerequest_payment/{id}', [App\Http\Controllers\PaymentController::class, 'declinerequest_payment'])->name('declinerequest_payment');


ROUTE::get('institutes', [App\Http\Controllers\InstitutesController::class, 'institutes'])->name('institutes');
ROUTE::post('addinstitute', [App\Http\Controllers\InstitutesController::class, 'addinstitute'])->name('addinstitute');
ROUTE::post('editinstitute', [App\Http\Controllers\InstitutesController::class, 'editinstitute'])->name('editinstitute');

ROUTE::get('addinstitutestudent', [App\Http\Controllers\UsersController::class, 'addinstitutestudent'])->name('addinstitutestudent');
ROUTE::post('saveinstitutestudent', [App\Http\Controllers\UsersController::class, 'saveinstitutestudent'])->name('saveinstitutestudent');
ROUTE::get('studentapproval', [App\Http\Controllers\UsersController::class, 'studentapproval'])->name('studentapproval');
ROUTE::get('rejectstudent/{id}', [App\Http\Controllers\UsersController::class, 'rejectstudent'])->name('rejectstudent');
ROUTE::get('acceptstudent/{id}', [App\Http\Controllers\UsersController::class, 'acceptstudent'])->name('acceptstudent');

Route::post('/gettaluk', [App\Http\Controllers\UsersController::class, 'gettaluk'])->name('gettaluk');
Route::POST('/getsection', [App\Http\Controllers\UsersController::class, 'getsection'])->name('getsection');
Route::POST('/getsyllabus', [App\Http\Controllers\UsersController::class, 'getsyllabus'])->name('getsyllabus');
Route::get("/getpanchayathlimit/{taluk_id}", [App\Http\Controllers\UsersController::class, 'getpanchayathlimit'])->name('getpanchayathlimit');

ROUTE::get('backups', [App\Http\Controllers\BackupController::class, 'backups'])->name('backups');
ROUTE::get('/backup/create', [App\Http\Controllers\BackupController::class, 'create'])->name('create');
ROUTE::get('/backup/download/{file_name}', [App\Http\Controllers\BackupController::class, 'download'])->name('download');
ROUTE::get('/backup/delete/{file_name}', [App\Http\Controllers\BackupController::class, 'delete'])->name('delete');

Route::get('/logout', [App\Http\Controllers\JoinController::class, 'logout'])->name('logout');

//Tailoring


Route::get('/tailoring/{filter}', [App\Http\Controllers\TailoringController::class, 'tailoring'])->name('tailoring');
Route::post('/addtailoring', [App\Http\Controllers\TailoringController::class, 'addtailoring'])->name('addtailoring');
Route::post('/updatetailoring', [App\Http\Controllers\TailoringController::class, 'updatetailoring'])->name('updatetailoring');
Route::get('/deletetailoring/{id}', [App\Http\Controllers\TailoringController::class, 'deletetailoring'])->name('deletetailoring');
Route::get('/paytailoring/{id}', [App\Http\Controllers\TailoringController::class, 'paytailoring'])->name('paytailoring');
Route::post('/tailoringpayment_update', [App\Http\Controllers\TailoringController::class, 'tailoringpayment_update'])->name('tailoringpayment_update');
Route::post('/approve_certificate', [App\Http\Controllers\TailoringController::class, 'approve_certificate'])->name('approve_certificate');
Route::post('/resubmit_certificate', [App\Http\Controllers\TailoringController::class, 'resubmit_certificate'])->name('resubmit_certificate');

Route::get('/tailoringinstitute', [App\Http\Controllers\TailoringController::class, 'tailoring_institute'])->name('tailoringinstitute');

//Students Login

Route::get('/studentdashboard', [App\Http\Controllers\Student\StudentDashboardController::class, 'studentdashboard'])->name('studentdashboard');
ROUTE::post('studentrequest', [App\Http\Controllers\Student\StudentDashboardController::class, 'studentrequest'])->name('studentrequest');

Route::get('/studentlogin', [App\Http\Controllers\Student\StudentLoginController::class, 'studentlogin'])->name('studentlogin');
Route::post('/checklogin', [App\Http\Controllers\Student\StudentLoginController::class, 'checklogin'])->name('checklogin');
ROUTE::get('/studentlogout', [App\Http\Controllers\Student\StudentLoginController::class, 'studentlogout'])->name('studentlogout');
Route::POST('/checkaadhar', [App\Http\Controllers\Student\StudentLoginController::class, 'checkaadhar'])->name('checkaadhar');
ROUTE::get('/exam', [App\Http\Controllers\Student\StudentExamController::class, 'exam'])->name('exam');
Route::get('examcompleted',[App\Http\Controllers\Student\StudentExamController::class, 'examcompleted'])->name('examcompleted');

Route::get('/service/{id}', [App\Http\Controllers\Student\StudentExamController::class, 'service'])->name('service');
Route::POST('/saveservice', [App\Http\Controllers\Student\StudentExamController::class, 'saveservice'])->name('saveservice');

ROUTE::get('/practice', [App\Http\Controllers\Student\StudentExamController::class, 'practice'])->name('practice');
ROUTE::get('/showexam', [App\Http\Controllers\Student\StudentExamController::class, 'showexam'])->name('showexam');
ROUTE::get('/viewresult', [App\Http\Controllers\Student\StudentExamController::class, 'viewresult'])->name('viewresult');
Route::get('/onlineexam', [App\Http\Controllers\Student\StudentExamController::class, 'onlineexam'])->name('onlineexam');
Route::get('/practiceexam', [App\Http\Controllers\Student\StudentExamController::class, 'practiceexam'])->name('practiceexam');
Route::get('/distop/{id}', [App\Http\Controllers\Student\StudentExamController::class, 'distop'])->name('distop');
Route::get('/topper/{id}', [App\Http\Controllers\Student\StudentExamController::class, 'topper'])->name('topper');
Route::get('/rank', [App\Http\Controllers\Student\StudentExamController::class, 'rank'])->name('rank');
Route::post('/saveprizeamount', [App\Http\Controllers\Student\StudentExamController::class, 'saveprizeamount'])->name('saveprizeamount');
Route::get('/result', [App\Http\Controllers\Student\StudentExamController::class, 'result'])->name('result');
Route::get('/examresult', [App\Http\Controllers\Student\StudentExamController::class, 'examresult'])->name('examresult');
Route::get('/practiceresult', [App\Http\Controllers\Student\StudentExamController::class, 'practiceresult'])->name('practiceresult');
Route::get('/allpracticeresult', [App\Http\Controllers\Student\StudentExamController::class, 'allpracticeresult'])->name('allpracticeresult');
ROUTE::get('/saveanswer/{ques}/{ans}/{sid}', [App\Http\Controllers\Student\StudentExamController::class, 'saveanswer'])->name('saveanswer');
ROUTE::get('/practiceanswer/{ques}/{ans}/{sid}', [App\Http\Controllers\Student\StudentExamController::class, 'practiceanswer'])->name('practiceanswer');
ROUTE::get('/finishexam', [App\Http\Controllers\Student\StudentExamController::class, 'finishexam'])->name('finishexam');
Route::get('/studentchangepassword', [App\Http\Controllers\Student\StudentExamController::class, 'studentchangepassword'])->name('studentchangepassword');
Route::post('/studentupdatepassword', [App\Http\Controllers\Student\StudentExamController::class, 'studentupdatepassword'])->name('studentupdatepassword');

Route::get('/studentprofile', [App\Http\Controllers\Student\StudentProfileController::class, 'studentprofile'])->name('studentprofile');
Route::post('/updatestudentprofile', [App\Http\Controllers\Student\StudentProfileController::class, 'updatestudentprofile'])->name('updatestudentprofile');



ROUTE::get('section', [App\Http\Controllers\QuestionsController::class, 'section'])->name('section');

ROUTE::get('/questionscound/{section}', [App\Http\Controllers\QuestionsController::class, 'questionscound'])->name('questionscound');
