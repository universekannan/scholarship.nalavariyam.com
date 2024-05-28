@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Exam Completed</h1>
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
                        @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissable" style="margin: 15px;">
                            <a href="#" style="color:white !important" class="close" data-dismiss="alert"
                            aria-label="close">&times;</a>
                            <strong> {{ session('success') }} </strong>
                        </div>
                        @endif
                        @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
                            <a href="#" style="color:white !important" class="close" data-dismiss="alert"
                            aria-label="close">&times;</a>
                            <strong> {{ session('error') }} </strong>
                        </div>
                        @endif
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#notcompleted"
                                data-toggle="tab">Exam Not Completed</a></li>
                                <li class="nav-item"><a class="nav-link" href="#completed"
                                    data-toggle="tab">Exam Completed</a></li>
                                    
                                </ul>
                                <div class="tab-content">
                                    <div class="active tab-pane" id="notcompleted">    
                                        <div class="table-responsive" style="overflow-x: auto; ">
                                            <table id="example2" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Phone</th>
                                                        <th>Username</th>
                                                        <th>Section</th>
                                                        <th>Medium</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($notcompleted as $key => $s)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $s->student_name }}</td>
                                                        <td>{{ $s->cell_number }}</td>
                                                        <td>{{ $s->username }}</td>
                                                        <td>{{ $s->section_name }}</td>
                                                        <td>{{ $s->medium_name }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="completed">
                                        <div class="table-responsive" style="overflow-x: auto; ">
                                            <table id="example2" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Phone</th>
                                                        <th>Username</th>
                                                        <th>Section</th>
                                                        <th>Medium</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($completed as $key => $s)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $s->student_name }}</td>
                                                        <td>{{ $s->cell_number }}</td>
                                                        <td>{{ $s->username }}</td>
                                                        <td>{{ $s->section_name }}</td>
                                                        <td>{{ $s->medium_name }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="modal fade" id="userdata">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="studentnames"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>ID </label>
                                <label for="" class="col-sm-8 col-form-label"><span style="color:red" id="id"></span>
                                </label>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>UserName
                                </label>
                                <label for="" class="col-sm-8 col-form-label"><span style="color:red" id="usernames"></span>
                                </label>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>District
                                </label>
                                <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                    id="district_name"></span> </label>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Password
                                    </label>
                                    <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                        id="pas"></span></label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Phone
                                        </label>
                                        <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                            id="cell_numbers"></span></label>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Status
                                            </label>
                                            <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                                id="statuses"></span> </label>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Medium Name
                                                </label>
                                                <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                                    id="mediumname"></span> </label>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Section Name
                                                    </label>
                                                    <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                                        id="sectionname"></span> </lzzzzabel>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Bill Or Id
                                                        </label>
                                                        <a id="viewimg" target="_blank" class="col-sm-8 col-form-label"><span
                                                            style="color:red"></span>Bill Or Id</a>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Student Id
                                                            </label>
                                                            <a id="viewid" target="_blank" class="col-sm-8 col-form-label"><span
                                                                style="color:red"></span>Student Id</a>
                                                            </div>
                                                            <center>
                                                                <a class="btn btn-info" href="" id="msgbtn" data-action="share/whatsapp/share"
                                                                target="_blank">Send Whatsapp</a>
                                                            </center>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <a type="" class=""></a>
                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="statusupdate">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="studname"></h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ url('/updatestatus') }}" method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="hidden" name="studentid" id="studid">
                                                                <input type="hidden" name="membertype" id="memtype">
                                                                <div class="form-group" id="">
                                                                    <label for="student_name">Amount Payable</label>
                                                                    <input readonly type="text" class="form-control" name="amount" id="payamount">
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @endsection
                                            @push('page_scripts')
                                            <script>
                                                function statusupdate(id, student_name, status, membertype) {
                                                    $("#studid").val(id);
                                                    $("#studname").text(student_name);
                                                    var amount = "";
                                                    if (membertype == "Special" || membertype == "SpecialChild") {
                                                        amount = 0;
                                                    } else if (membertype == "Member") {
                                                        amount = 75;
                                                    } else if (membertype == "SingleParent") {
                                                        amount = 50;
                                                    } else {
                                                        amount = 120;
                                                    }
                                                    $("#payamount").val(amount);
                                                    $("#memtype").val(membertype);
                                                    $("#statusupdate").modal("show");
                                                }


                                                function edituser(id, dist_id, student_name, cell_number, username, password, status) {
                                                    $("#editid").val(id);
                                                    $("#editdist_id").val(dist_id);
                                                    $.ajax({
                                                        url: "{{ url('/gettaluk') }}",
                                                        type: "POST",
                                                        data: {
                                                            taluk_id: dist_id,
                                                            _token: '{{ csrf_token() }}'
                                                        },
                                                        dataType: 'json',
                                                        success: function(result) {
                                                            $('#edittaluk').html('<option value="">-- Select Taluk Name --</option>');
                                                            $.each(result, function(key, value) {
                                                                $("#edittaluk").append('<option value="' + value
                                                                    .id + '">' + value.taluk_name + '</option>');
                                                            });
                                                            $("#edittaluk").val(taluk_id);
                                                        }
                                                    });
                                                    $("#editstudent_name").val(student_name);
                                                    $("#editcell_number").val(cell_number);
                                                    $("#editusername").val(username);
                                                    $("#editpassword").val(password);
                                                    $("#status").val(status);
                                                    $("#editcenteruser").modal("show");
                                                }


                                                function userdatas(id, student_name, username, district_name, cpassword, cell_number, status, medium_name,
                                                    section_name, bill_or_id, studentidcard) {
                                                    $("#id").text(id);
                                                    $("#studentnames").text(student_name);
                                                    $("#usernames").text(username);
                                                    $("#district_name").text(district_name);
                                                    $("#pas").text(cpassword);
                                                    $("#cell_numbers").text(cell_number);
                                                    $("#statuses").text(status);
                                                    $("#mediumname").text(medium_name);
                                                    $("#sectionname").text(section_name);
                                                    if(bill_or_id != ""){
                                                        $("#viewimg").attr("href", "{{ URL::to('/') }}/upload/student/billorid/" + bill_or_id);
                                                    }
                                                    if(viewid != ""){
                                                        $("#viewid").attr("href", "{{ URL::to('/') }}/upload/student/billorid/" + studentidcard);
                                                    }
                                                    $('#msgbtn').attr('href', 'https://api.whatsapp.com/send?cell_number=91' + cell_number +
                                                        '&text=Sir, We are from NalaVariyam , Your Login UserName : ' + username + ', Password : ' + pas +
                                                        ', Contact Us : Mobile 7598984380 Email : ramjitrust039@gmail.com, Websit : www.nalavariyam.com. I have attached your Login website  link below https://nalavariyam.com/apps/'
                                                        )
                                                    $("#userdata").modal("show");
                                                }
                                                $('#dist_id').on('change', function() {
                                                    var idTaluk = this.value;
                                                    $("#taluk").html('');
                                                    $.ajax({
                                                        url: "{{ url('/gettaluk') }}",
                                                        type: "POST",
                                                        data: {
                                                            taluk_id: idTaluk,
                                                            _token: '{{ csrf_token() }}'
                                                        },
                                                        dataType: 'json',
                                                        success: function(result) {
                                                            $('#taluk').html('<option value="">-- Select Taluk Name --</option>');
                                                            $.each(result, function(key, value) {
                                                                $("#taluk").append('<option value="' + value
                                                                    .id + '">' + value.taluk_name + '</option>');
                                                            });
                                                        }
                                                    });
                                                });

                                                $('#editdist_id').on('change', function() {
                                                    var idTaluk = this.value;
                                                    $("#edittaluk").html('');
                                                    $.ajax({
                                                        url: "{{ url('/gettaluk') }}",
                                                        type: "POST",
                                                        data: {
                                                            taluk_id: idTaluk,
                                                            _token: '{{ csrf_token() }}'
                                                        },
                                                        dataType: 'json',
                                                        success: function(result) {
                                                            $('#edittaluk').html('<option value="">-- Select Taluk Name --</option>');
                                                            $.each(result, function(key, value) {
                                                                $("#edittaluk").append('<option value="' + value
                                                                    .id + '">' + value.taluk_name + '</option>');
                                                            });
                                                        }
                                                    });
                                                });


                                                function duplicate_username(id) {
                                                    var username = $("#username").val().trim();
                                                    var _token = $('input[name="_token"]').val();
                                                    $.ajax({
                                                        type: "post",
                                                        url: '{{ url('duplicate_username') }}',
                                                        data: {
                                                            id: id,
                                                            username: username,
                                                            _token: _token
                                                        },

                                                        success: function(res) {
                                                            if (res.exists) {
                                                                $("#save").prop('disabled', true);
                                                                $("#dupusername").html("Duplicate Username");
                                                            } else {
                                                                $("#save").prop('disabled', false);
                                                                $("#dupusername").html("");
                                                            }
                                                        },

                                                        error: function(jqXHR, exception) {
                                                            console.log(exception);
                                                        }
                                                    });
                                                }

                                                function duplicate_username_edit() {
                                                    var username = $("#editusername").val().trim();
                                                    var editid = $("#editid").val().trim();
                                                    var _token = $('input[name="_token"]').val();
                                                    $.ajax({
                                                        type: "post",
                                                        url: '{{ url('duplicate_username') }}',
                                                        data: {
                                                            id: editid,
                                                            username: username,
                                                            _token: _token
                                                        },

                                                        success: function(res) {
                                                            if (res.exists) {
                                                                $("#editsave").prop('disabled', true);
                                                                $("#dupusernameedit").html("Duplicate Username");
                                                            } else {
                                                                $("#editsave").prop('disabled', false);
                                                                $("#dupusernameedit").html("");
                                                            }
                                                        },

                                                        error: function(jqXHR, exception) {
                                                            console.log(exception);
                                                        }
                                                    });
                                                }
                                            </script>
                                            @endpush
