@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Student</h1>
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
                            <form onsubmit="return validate_all(event);" action="{{ url('/savestudent') }}" method="post"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="student_name">Student Name</label>
                                            <input required maxlength="30" type="text" class="form-control"
                                                name="student_name" id="student_name" placeholder="Enter Student Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="cell_number">Mobile Number</label>
                                            <input required maxlength="15" type="text" class="form-control number"
                                                name="cell_number" id="cell_number" placeholder="Enter Mobile Number"
                                                maxlength="10">
                                        </div>
                                        <div class="form-group">
                                            <label for="adhaar_number">Aadhaar Number</label>
                                            <input required maxlength="15" type="text" class="form-control number"
                                                name="adhaar_number" id="adhaar_number" placeholder="Enter Adhaar Number">
                                        </div>
                                        <div class="form-group">
                                            <label for="father_name">Father Name</label>
                                            <input required maxlength="40" type="text" class="form-control"
                                                name="father_name" id="adhaar_number" placeholder="Enter Father Name">
                                        </div>

                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select required class="form-control select2" name="gender" id="gender"
                                                style="width: 100%;">
                                                <option value="">Select Gender</option>
                                                <option value="Male"> Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Transgender">Transgender</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="db">Date of Birth</label>
                                            <input required maxlength="15" type="date" class="form-control"
                                                name="db" id="db" placeholder="" maxlength="15">
                                        </div>
                                        <div class="form-group">
                                            <label>Bank Name</label>
                                            <select required class="form-control select2" name="bank_details" id="dist_id"
                                                style="width: 100%;">
                                                <option value="">Select Bank Name</option>
                                                @foreach ($managebanking as $banking)
                                                    <option value="{{ $banking->id }}">{{ $banking->bank_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="micr_number"> Account Holder Name</label>
                                            <input required maxlength="50" type="text" class="form-control"
                                                name="account_holder_name" id="account_holder_name"
                                                placeholder="Enter Account Holder Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="branch_name">Branch Name</label>
                                            <input required maxlength="50" type="text" class="form-control"
                                                name="branch_name" id="branch_name" placeholder="Enter Branch Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="ac_number">Account Number</label>
                                            <input required maxlength="30" type="text" class="form-control"
                                                name="ac_number" id="acc_number" placeholder="Enter Account Number">
                                        </div>

                                        <div class="form-group">
                                            <label for="ac_number">Confirm Account Number</label>
                                            <input required maxlength="30" type="text" class="form-control"
                                                name="ac_number" id="confirmacc_number"
                                                placeholder="Enter Account Number">
                                            <span id="divCheckMatch"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="ifsc_number">IFSC Number</label>
                                            <input required maxlength="30" type="text" class="form-control"
                                                name="ifsc_number" id="ifsc_number" placeholder="Enter IFSC Number">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>District Name</label>
                                            <select required class="form-control select2" name="dist_id" id="dist_id"
                                                style="width: 100%;">
                                                <option value="">Select District Name</option>
                                                @foreach ($managedistrict as $district)
                                                    <option value="{{ $district->id }}">{{ $district->district_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Academic Medium</label>
                                            <select required class="form-control" name="medium_id" id="medium_id"
                                                style="width: 100%;">
                                                <option value="">Select Medium</option>
                                                @foreach ($managemedium as $medium)
                                                    <option value="{{ $medium->id }}">{{ $medium->medium_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label><input id="category1" checked type="radio" name="category" class="radio"
                                                    value="School"><span>School</span></label>
                                            <label><input id="category2" type="radio" name="category" class="radio"
                                                    value="College"><span>College</span></label>
                                        </div>

                                        <div class="form-group" id="ssection">
                                            <label>Section Name</label>
                                            <select required class="form-control" name="ssection" id="ssectionid"
                                                style="width: 100%;">
                                                <option value="">Select</option>
                                                @foreach ($ssection as $section)
                                                    <option value="{{ $section->id }}">{{ $section->section_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="csection" style="display: none">
                                            <label>Section Name</label>
                                            <select class="form-control" name="csection" id="csectionid"
                                                style="width: 100%;">
                                                <option value="">Select</option>
                                                @foreach ($csection as $section)
                                                    <option value="{{ $section->id }}">{{ $section->section_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="school_name">School Name</label>
                                            <textarea maxlength="100" rows="2" type="text" class="form-control" name="school_name" id="school_name"
                                                placeholder="Enter School Name"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="student_name">School or College ID Card</label>
                                            <input required="requiered" type="file" class="form-control"
                                                name="studentidcard" id="studentidcard">
                                        </div>
                                        <div class="form-group">
                                            <label>Ramji Union</label>
                                            <select class="form-control select2" name="union" id="union"
                                                style="width: 100%;">
                                                <option value="">Select</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>

                                        <div class="form-group" id="memberhide" style="display: none">
                                            <label>Member Type</label>
                                            <select class="form-control select2" name="membertype" id="membertype"
                                                style="width: 100%;">
                                                <option value="">Select</option>
                                                <option value="Special">Special Member</option>
                                                <option value="Member">Member</option>
                                                <option value="SpecialChild">Special Child</option>
                                                <option value="SingleParent">Single Parent</option>
                                            </select>
                                        </div>

                                        <div class="form-group" id="memberidhide" style="display: none">
                                            <label for="student_name">Id Number</label>
                                            <input maxlength="30" type="text" class="form-control" name="id_number"
                                                id="id_number" placeholder="Enter ID Number">
                                        </div>

                                        <div class="form-group" id="billoridcard" style="display: none">
                                            <label for="student_name" id="labelbill">Bill/ID Card</label>
                                            <input type="file" class="form-control" name="billorid" id="nalbillorid">
                                        </div>


                                        <div class="form-group" id="membernohide" style="display: none">
                                            <label>Member Type</label>
                                            <select class="form-control select2" name="membertype2" id="memberother"
                                                style="width: 100%;">
                                                <option value="">Select</option>
                                                <option value="Other">Other Union</option>
                                                <option value="Public">Public</option>
                                            </select>
                                        </div>

                                        <div class="form-group" id="memberreghide" style="display: none">
                                            <label for="student_name">Registration Number</label>
                                            <input maxlength="30" type="text" class="form-control" name="reg_number"
                                                id="regnumber" placeholder="Enter Registration Number">
                                        </div>

                                        <div class="form-group" id="memberaadhaarhide" style="display: none">
                                            <label for="student_name">Parent Aadhaar Number</label>
                                            <input maxlength="15" type="text" class="form-control number"
                                                name="parent_aadhaar" id="aadhaarno" placeholder="Enter Aadhaar Number">
                                        </div>
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
            
            $("#acc_number, #confirmacc_number").keyup(checkAccountNumberMatch);
        });

        function checkAccountNumberMatch() {
            var accountno = $("#acc_number").val();
            var confirmaccountno = $("#confirmacc_number").val();

            if (accountno != confirmaccountno) {
                $("#divCheckMatch").html("Account Number do not match!").css({
                    'color': 'red',
                    'font-size': '80%',
                    'font-weight': 'bold'
                });
                $("#save").attr("disabled", true);
            } else {
                $("#divCheckMatch").html("Account Number match.").css({
                    'color': 'green',
                    'font-size': '80%',
                    'font-weight': 'bold'
                });
                $("#save").removeAttr("disabled");
            }
        }

        $(function() {

            $('#union').change(function() {
                if ($(this).val() == "Yes") {
                    $("#memberother").val('').trigger('change');
                    $('#regnumber').val("");
                    $('#aadhaarno').val("");
                    $('#memberhide').css('display', 'block');
                    $('#memberidhide').css('display', 'block');
                    $('#membernohide').css('display', 'none');
                    $('#memberreghide').css('display', 'none');
                    $('#memberaadhaarhide').css('display', 'none');



                } else if ($(this).val() == "No") {
                    $('#id_number').val("");
                    $("#membertype").val('').trigger('change');

                    $('#memberhide').css('display', 'none');
                    $('#memberidhide').css('display', 'none');
                    $('#membernohide').css('display', 'block');
                    $('#memberaadhaarhide').css('display', 'none');

                } else {
                    $('#regnumber').val("");
                    $('#aadhaarno').val("");
                    $("#memberother").val('').trigger('change');
                    $('#id_number').val("");
                    $("#membertype").val('').trigger('change');

                    $('#membernohide').css('display', 'none');
                    $('#memberreghide').css('display', 'none');
                    $('#memberaadhaarhide').css('display', 'none');
                    $('#memberhide').css('display', 'none');
                    $('#memberidhide').css('display', 'none');


                }
            });

            $('#memberother').change(function() {
                if ($(this).val() == "Other") {
                    $('#aadhaarno').val("");
                    $('#memberreghide').css('display', 'block');
                    $('#memberaadhaarhide').css('display', 'none');
                } else if ($(this).val() == "Public") {
                    $('#regnumber').val("");
                    $('#memberaadhaarhide').css('display', 'block');
                    $('#memberreghide').css('display', 'none');
                } else {
                    $('#memberaadhaarhide').css('display', 'none');
                    $('#memberreghide').css('display', 'none');
                }
            });

            $('#membertype').change(function() {
                if ($(this).val() == "Special") {
                    $('#nalbillorid').val("");
                    $('#id_number').val("");
                    $('#naldisability_id').val("");
                    $('#billoridcard').css('display', 'block');
                    $('#memberidhide').css('display', 'block');
                    $('#labelbill').text('Bill/ID Card');

                } else if ($(this).val() == "Member") {
                    $('#id_number').val("");
                    $('#nalbillorid').val("");
                    $('#billoridcard').css('display', 'block');
                    $('#memberidhide').css('display', 'block');
                    $('#labelbill').text('Bill');

                } else if ($(this).val() == "SpecialChild") {
                    $('#id_number').val("");
                    $('#nalbillorid').val("");
                    $('#billoridcard').css('display', 'block');
                    $('#memberidhide').css('display', 'block');
                    $('#labelbill').text('Government Disability ID Card');

                } else if ($(this).val() == "SingleParent") {
                    $('#id_number').val("");
                    $('#nalbillorid').val("");
                    $('#memberidhide').css('display', 'none');
                    $('#billoridcard').css('display', 'block');
                    $('#labelbill').text('Widower / Divorce Certificate');
                } else {
                    $('#id_number').val("");
                    $('#nalbillorid').val("");
                    $('#billoridcard').css('display', 'none');
                }
            });

        });

        function validate_all(e) {

            var union = $("#union").val().trim();
            if (union == "") {
                alert('Please Select Union');
                return false;
            }
            if (union == "Yes") {
                var memtype = $("#membertype").val().trim();
                var memid = $("#id_number").val().trim();
                if (memtype == "") {
                    alert('Please Select Member Type');
                    return false;
                }
                if (memtype != "SingleParent" && memid == "") {
                    alert('Please Enter Member ID');
                    return false;
                }
                if (memtype == "Special" && $('#nalbillorid').get(0).files.length === 0) {
                    alert('Please Upload Bill or Id');
                    return false;
                }
                if (memtype == "Member" && $('#nalbillorid').get(0).files.length === 0) {
                    alert('Please Upload Bill');
                    return false;
                }
                if (memtype == "SpecialChild" && $('#nalbillorid').get(0).files.length === 0) {
                    alert('Please Upload Government Disability ID');
                    return false;
                }
                if (memtype == "SingleParent" && $('#nalbillorid').get(0).files.length === 0) {
                    alert('Please Upload Widower / Divorce Certificate');
                    return false;
                }

                $('#save').prop('disabled', true).val("Please Wait...");
            }

            if (union == "No") {
                var memother = $("#memberother").val().trim();
                if (memother == "") {
                    alert('Please Select Member Type');
                    return false;
                }
                if (memother == "Other") {
                    var regnum = $("#regnumber").val().trim();
                    if (regnum == "") {
                        alert('Please Enter Registration Number');
                        return false;
                    }
                    $('#save').prop('disabled', true).val("Please Wait...");
                } else {
                    var aadhaarno = $("#aadhaarno").val().trim();
                    if (aadhaarno == "") {
                        alert('Please Enter Aadhaar Number');
                        return false;
                    }
                    $('#save').prop('disabled', true).val("Please Wait...");

                }
            }

            /*  var mediumid = $('#medium_id').val().trim();
             var sectionid = $('#section_id').val().trim();
             var syllabus = $("#syllabus").val().trim();
             if(mediumid == 1){
                 if(sectionid == 6 || sectionid == 7){
                 if(syllabus == ""){
                     alert('Please Select Syllabus');
                     return false;
                 }
                 }
             }else{
                 if(syllabus == ""){
                     alert('Please Select Syllabus');
                     return false;
                 }
             }
             $('#save').prop('disabled', true).val("Please Wait..."); */


        }
    </script>
@endpush
