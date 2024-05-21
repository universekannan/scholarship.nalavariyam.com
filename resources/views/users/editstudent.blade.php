@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Edit Student</h1>
         </div>
      </div>
   </div>
</section>
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-body">
                  <form onsubmit="return validate_all(event);" action="{{ url('/updatestudent') }}" method="post" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     <div class="row">
					    <div class="col-md-6">
                            <input type="hidden" name="student_id" value="{{ $edit->id }}">
                           <div class="form-group">
                              <label for="student_name">Student Name</label>
                              <input value="{{ $edit->student_name }}" required maxlength="30" type="text" class="form-control" name="student_name"
                                 id="student_name" placeholder="Enter Student Name">
                           </div>
                           <div class="form-group">
                              <label for="cell_number">Mobile Number</label>
                              <input value="{{ $edit->cell_number }}"required maxlength="15" type="text" class="form-control number"
                                 name="cell_number" id="cell_number" placeholder="Enter Mobile Number" maxlength="10">
                           </div>
                           <div class="form-group">
                              <label for="adhaar_number">Adhaar Number</label>
                              <input  value="{{ $edit->adhaar_number }}"required maxlength="15" type="text" class="form-control number"
                                 name="adhaar_number" id="adhaar_number" placeholder="Enter Adhaar Number" maxlength="15">
                           </div>
                           <div class="form-group">
                            <label for="father_name">Father Name</label>
                            <input value="{{ $edit->father_name }}" maxlength="15" type="text" class="form-control"
                               name="father_name" id="fathername" placeholder="Enter Father Name">
                         </div>
                           <div class="form-group">
                              <label>Gender</label>
                              <select required class="form-control select2" name="gender" id="gender"
                                 style="width: 100%;">
                                 <option value="">Select Gender</option>
                                 <option @if($edit->gender == "Male") selected @endif value="Male"> Male</option>
                                 <option @if($edit->gender == "Female") selected @endif value="Female">Female</option>
                              </select>
                           </div>
                           <div class="form-group">
                              <label for="db">Date of Birth</label>
                              <input  value="{{ $edit->db }}"required maxlength="15" type="date" class="form-control"
                                 name="db" id="db" placeholder="" maxlength="15">
                           </div>
                           <div class="form-group">
                              <label>Bank Name</label>
                              <select required class="form-control select2" name="bank_details" id="dist_id"
                                 style="width: 100%;">
                                 <option value="">Select Banking Details</Details></option>
                                 @foreach ($managebanking as $banking)
                                 <option @if($edit->bank_details ==  $banking->id) selected @endif  value="{{ $banking->id }}">{{ $banking->bank_name }}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="form-group">
                            <label for="micr_number"> Account Holder Name</label>
                            <input value="{{ $edit->account_holder_name}}" required maxlength="50" type="text" class="form-control" name="account_holder_name"
                               id="account_holder_name" placeholder="Enter Account Holder Name">
                         </div>
                           <div class="form-group">
                            <label for="branch_name">Branch Name</label>
                            <input value="{{ $edit->branch_name }}" required maxlength="50" type="text" class="form-control" name="branch_name"
                               id="branch_name" placeholder="Enter Branch Name">
                         </div>
                           <div class="form-group">
                              <label for="ac_number">Account Number</label>
                              <input value="{{ $edit->ac_number }}"required maxlength="30" type="text" class="form-control" name="ac_number"
                                 id="ac_number" placeholder="Enter Account Number">
                           </div>
                           <div class="form-group">
                              <label for="ifsc">IFSC Number</label>
                              <input value="{{ $edit->ifsc }}"required maxlength="30" type="text" class="form-control" name="ifsc_number"
                                 id="ifsc" placeholder="Enter IFSC Number">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>District Name</label>
                              <select required class="form-control select2" name="dist_id" id="dist_id"
                                 style="width: 100%;">
                                 <option value="">Select District Name</option>
                                 @foreach ($managedistrict as $district)
                                 <option @if($edit->dist_id ==  $district->id) selected @endif  value="{{ $district->id }}">{{ $district->district_name }}</option>
                                 @endforeach
                              </select>
                           </div>
                           
                           <div class="form-group">
                              <label>Academic Medium</label>
                              <select required class="form-control" name="medium_id" id="medium_id"
                                 style="width: 100%;">
                                 <option value="">Select Medium</option>
                                 @foreach ($managemedium as $medium)
                                 <option @if($edit->medium_id ==  $medium->id) selected @endif value="{{ $medium->id }}">{{ $medium->medium_name }}</option>
                                 @endforeach
                              </select>
                           </div>

                           <div id="variant">
                           
                            <label><input @if($edit->user_type_id==3) disabled @endif  id="category1" @if($edit->category=="School") checked @endif type="radio" name="category" class="radio"
                                    value="School"><span>School</span></label>
                                   
                            <label><input @if($edit->user_type_id==3) disabled @endif id="category2"  @if($edit->category=="College") checked @endif type="radio" name="category" class="radio"
                                    value="College"><span>College</span></label>
                                     
                          </div>
                          <input type="hidden" name="hiddencat" id="hiddencat" value="{{ $edit->category }}">
                         
                           <div class="form-group" id="ssection" >
                              <label>Section Name</label>
                              <select @if($edit->category == "School") required="required" @endif class="form-control" name="ssection" id="ssectionid"
                                 style="width: 100%;">
                                 <option value="">Select</option>
                                 @foreach ($ssection as $section)
                                 <option @if($edit->section_id ==  $section->id) selected @endif value="{{ $section->id }}">{{ $section->section_name }}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="form-group" id="csection">
                            <label>Section Name</label>
                            <select  @if($edit->category == "College") required="required" @endif class="form-control" name="csection" id="csectionid"
                               style="width: 100%;">
                               <option value="">Select</option>
                               @foreach ($csection as $section)
                               <option @if($edit->section_id ==  $section->id) selected @endif value="{{ $section->id }}">{{ $section->section_name }}</option>
                               @endforeach
                            </select>
                         </div>

                       

                            @if($institutestudent == 0 || Auth::user()->user_type_id == 1)
                           <div class="form-group">
                            <label for="school_name">School Name</label>
                            <textarea maxlength="100" rows="2" type="text" class="form-control" name="school_name"
                                id="school_name" placeholder="Enter School Name">{{ $edit->school_name }} </textarea>
                        </div>
                        <div class="form-group">
                            <label for="student_name">School or College ID Card</label>
                             <input  type="file" class="form-control" name="studentidcard" id="studentidcard" >
                        </div>
                        @if($edit->studentidcard != "")
                        <div class="form-group">
                            <img src="{{ URL::to('/') }}/upload/student/studentidcard/{{ $edit->studentidcard }}" class="img-responsive" width="100" height="100">
                       </div>
                       @endif
                           <div class="form-group">
                            <label>Ramji Union</label>
                            <select class="form-control" name="union" id="union"
                                style="width: 100%;">
                                <option value="">Select</option>
                                <option @if($edit->union_type == "Yes") selected @endif value="Yes">Yes</option>
                                <option @if($edit->union_type == "No") selected @endif value="No">No</option>
                            </select>
                        </div>

                        <div class="form-group" id="memberhide" style="display: none">
                            <label>Member Type</label>
                            <select class="form-control select2" name="membertype" id="membertype"
                                style="width: 100%;">
                                <option value="">Select</option>
                                <option @if($edit->membertype == "Special") selected @endif value="Special">Special Member</option>
                                <option @if($edit->membertype == "Member") selected @endif value="Member">Member</option>
                                <option @if($edit->membertype == "SpecialChild") selected @endif value="SpecialChild">Special Child</option>
                                <option @if($edit->membertype == "SingleParent") selected @endif value="SingleParent">Single Parent</option>
                            </select>
                        </div>
                        <input type="hidden" value="{{ $edit->membertype }}" id="memhidden" />

                        <div class="form-group" id="memberidhide" style="display: none">
                            <label for="student_name">Id Number</label>
                            <input value="{{ $edit->member_id_number }}" maxlength="30" type="text" class="form-control" name="id_number"
                                id="id_number" placeholder="Enter ID Number">
                        </div>

                        <div class="form-group" id="billoridcard" style="display: none">
                            <label for="student_name" id="labelbill">Bill/ID Card</label>
                             <input type="file" class="form-control" name="billorid" id="nalbillorid" >
                        </div>

                        <div class="form-group" id="billoridcardview" style="display: none">
                             <img src="{{ URL::to('/') }}/upload/student/billorid/{{ $edit->bill_or_id }}" class="img-responsive" width="100" height="100">
                        </div>

                        <div class="form-group" id="membernohide" style="display: none">
                            <label>Member Type</label>
                            <select class="form-control select2" name="membertype2" id="memberother"
                                style="width: 100%;">
                                <option value="">Select</option>
                                <option @if($edit->membertype == "Other") selected @endif value="Other">Other Union</option>
                                <option @if($edit->membertype == "Public") selected @endif value="Public">Public</option>
                            </select>
                        </div>

                        <div class="form-group" id="memberreghide" style="display: none">
                            <label for="student_name">Registration Number</label>
                            <input value="{{ $edit->registration_no }}" maxlength="30" type="text" class="form-control" name="reg_number"
                                id="regnumber" placeholder="Enter Registration Number">
                        </div>

                        <div class="form-group" id="memberaadhaarhide" style="display: none">
                            <label for="student_name">Aadhaar Number</label>
                            <input  value="{{ $edit->parent_aadhaar_no }}" maxlength="15" type="text" class="form-control number" name="parent_aadhaar"
                                id="aadhaarno" placeholder="Enter Aadhaar Number">
                        </div>
                        @endif
                        </div>
                     </div>
					 <div class="form-group row">
                            <div class="col-md-12 text-center">
                                <a href="" class="btn btn-info">Back</a>
                                <input id="save" class="btn btn-info" type="submit" name="submit"
                                    value="Submit" />
                            </div>
                        </div>
               </div>
            </div>
            </form>
         </div>
      </div>
   </div>
   </div>
   </div>
</section>
@endsection
@push('page_scripts')
    <script>

        $(document).ready(function() {
            $('input[type=radio][name=category]').change(function() {
                if (this.value == 'School') {
                    $("#ssectionid").val("");
                    $("#ssection").show();
                    $("#csection").hide();
                    $("#csectionid").prop("required",false);
                    $("#ssectionid").prop("required",true);
                } else {
                    $("#csectionid").val("");
                    $("#ssection").hide();
                    $("#csection").show();
                    $("#ssectionid").prop("required",false);
                    $("#csectionid").prop("required",true);
                }
            });

            var category = $("#hiddencat").val();
            if(category == "School"){
                $("#ssection").show();
                $("#csection").hide();
                $("#csectionid").prop("required",false);
                $("#ssectionid").prop("required",true);
            }else{
                $("#ssection").hide();
                $("#csection").show();
                $("#ssectionid").prop("required",false);
                $("#csectionid").prop("required",true);
            }
            
        });

        var union_type = $("#union").val();
        var memtype2 = $("#memberother").val();
        var specialtype = $("#membertype").val();
        if(union_type == "Yes"){
            $('#memberhide').css('display','block');
           
            if(specialtype == "Special"){
                $('#billoridcard').css('display','block');
                $('#billoridcardview').css('display','block');
                $('#labelbill').text('Bill/ID Card');
                $('#memberidhide').css('display','block');
            }else if(specialtype == "Member"){
                $('#billoridcard').css('display','block');
                $('#billoridcardview').css('display','block');
                $('#labelbill').text('Bill');
                $('#memberidhide').css('display','block');
            }else if(specialtype == "SpecialChild"){
                $('#billoridcard').css('display','block');
                $('#billoridcardview').css('display','block');
                $('#labelbill').text('Government Disability ID Card');
                $('#memberidhide').css('display','block');
            }else if(specialtype == "SingleParent"){
                $('#billoridcard').css('display','block');
                $('#billoridcardview').css('display','block');
                $('#memberidhide').css('display','none');
                $('#labelbill').text('Widower / Divorce Certificate');
            }
        }else{
            $('#membernohide').css('display','block');
            if(memtype2 == "Other"){
                $('#memberreghide').css('display','block');
            }else{
                $('#memberaadhaarhide').css('display','block');
            }
        }

        var mediumid = $('#medium_id').val();
        var sectionid = $('#section_id').val();
        if(mediumid == 1){
            if(sectionid == 6 || sectionid == 7){
                $('#studentsyllabus').css('display','block');
            }
            }else{
            $('#studentsyllabus').css('display','block');
        }

       
        var hiddenmedium = $('#hiddenmediumstudy').val();
        $('#studentquestionpattern').css('display','block');
        if(mediumid == 1){
            $("#medium_of_study").append("<option value='TamilState'>Tamil(State Board)</option><option value='EnglishState'>English(State Board)</option><option value='Matriculation'>Matriculation</option>");
            $("#medium_of_study").val(hiddenmedium).change();

         }else{
            $("#medium_of_study").append("<option value='Tamil'>Tamil</option><option value='English'>English</option>");
            $("#medium_of_study").val(hiddenmedium);
         } 
     $(function() {
          
    $('#union').change(function(){
        if($(this).val() == "Yes"){
            $('#memberhide').css('display','block');
            $('#memberidhide').css('display','block');
            $('#membernohide').css('display','none');
            $('#memberreghide').css('display','none');
            $('#memberaadhaarhide').css('display','none');

          

        }else if($(this).val() == "No"){
        
            $('#memberhide').css('display','none');
            $('#memberidhide').css('display','none');
            $('#membernohide').css('display','block');
            $('#memberaadhaarhide').css('display','none');

            $('#billoridcardview').css('display','none');
            $('#billoridcard').css('display','none');
        

        }else{
            $('#membernohide').css('display','none');
            $('#memberreghide').css('display','none');
            $('#memberaadhaarhide').css('display','none');
            $('#memberhide').css('display','none');
            $('#memberidhide').css('display','none');

           
        }
    });

    $('#memberother').change(function(){
        if($(this).val() == "Other"){
            $('#memberreghide').css('display','block');
            $('#memberaadhaarhide').css('display','none');
        }else if($(this).val() == "Public") {
            $('#memberaadhaarhide').css('display','block');
            $('#memberreghide').css('display','none');
        }else{
            $('#memberaadhaarhide').css('display','none');
            $('#memberreghide').css('display','none');
        }
    });
    $('#membertype').change(function(){
        if($(this).val() == specialtype && specialtype == "Special"){
            $('#billoridcard').css('display','block');
            $('#billoridcardview').css('display','block');
        }else if($(this).val() == specialtype && specialtype == "Member") {
            $('#billoridcard').css('display','block');
            $('#billoridcardview').css('display','block');
        }else if($(this).val() == specialtype && specialtype == "SpecialChild") {
            $('#billoridcard').css('display','block');
            $('#billoridcardview').css('display','block');
        }else if($(this).val() == specialtype && specialtype == "SingleParent") {
            $('#billoridcard').css('display','block');
            $('#billoridcardview').css('display','block');
            $('#memberidhide').css('display','none');
        }
       else if($(this).val() == "Special"){
            $('#billoridcard').css('display','block');
            $('#memberidhide').css('display','block');
            $('#billoridcardview').css('display','none');
            $('#labelbill').text('Bill/ID Card');
         
        }else if($(this).val() == "Member") {
            $('#billoridcard').css('display','block');
            $('#memberidhide').css('display','block');
            $('#billoridcardview').css('display','none'); 
            $('#labelbill').text('Bill');

        }else if($(this).val() == "SpecialChild") {
            $('#billoridcard').css('display','block');
            $('#billoridcardview').css('display','none');
            $('#memberidhide').css('display','block');
            $('#labelbill').text('Government Disability ID Card');

        }else if($(this).val() == "SingleParent") {
            $('#labelbill').text('Widower / Divorce Certificate');
            $('#billoridcard').css('display','block');
            $('#billoridcardview').css('display','none');
            $('#memberidhide').css('display','none');
        }else{
            $('#bill').css('display','none');
            $('#billoridcard').css('display','none');
            $('#billoridcardview').css('display','none');
        }
    });

});

function validate_all(e){
    var union = $("#union").val().trim();
    if(union == ""){
        alert('Please Select Union');
        return false;
    }
    if(union == "Yes"){
        var memtype = $("#membertype").val().trim();
        var memid = $("#id_number").val().trim();
        var memhidden = $("#memhidden").val().trim();
        if(memtype == ""){
            alert('Please Select Member Type');
            return false;
        }
        if(memtype != "SingleParent" && memid == ""){
            alert('Please Enter Member ID');
            return false;
        }

        if(memtype == "Special" && $('#nalbillorid').get(0).files.length === 0 && memhidden != memtype){
            alert('Please Upload Bill or Id');
            return false;
        }
        if(memtype == "Member" && $('#nalbillorid').get(0).files.length === 0 && memhidden != memtype){
            alert('Please Upload Bill');
            return false;
        }
        if(memtype == "SpecialChild" && $('#nalbillorid').get(0).files.length === 0 && memhidden != memtype){
            alert('Please Upload Government Disability ID');
            return false;
        }
        if(memtype == "SingleParent" && $('#nalbillorid').get(0).files.length === 0 && memhidden != memtype){
            alert('Please Upload Widower or Divorced Certificate');
            return false;
        }
       
        $('#save').prop('disabled', true) .val("Please Wait...");
    }

    if(union == "No"){
        var memother = $("#memberother").val().trim();
        if(memother == ""){
            alert('Please Select Member Type');
            return false;
        }
        if(memother == "Other"){
            var regnum = $("#regnumber").val().trim();
            if(regnum == ""){
                alert('Please Enter Registration Number');
                return false;
            }
        $('#save').prop('disabled', true) .val("Please Wait...");
        }else {
            var aadhaarno = $("#aadhaarno").val().trim();
            if(aadhaarno == ""){
                alert('Please Enter Parent Aadhaar Number');
                return false;
            }
        $('#save').prop('disabled', true) .val("Please Wait...");

        }
    }

}
    </script>
@endpush
