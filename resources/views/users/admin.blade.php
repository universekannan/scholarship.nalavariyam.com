@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Admin Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm"
                        data-toggle="modal" data-target="#Centerusers"><i class="fa fa-plus"> Add </i></button>
                    </li>
                </ol>
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
                        <div class="table-responsive" style="overflow-x: auto; ">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>District</th>
                                        <th>Full Name</th>
                                        <th>Role</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admin as $key => $centeruserslist)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $centeruserslist->id }}</td>
                                        <td>{{ $centeruserslist->district_name }}</td>
                                        <td>{{ $centeruserslist->full_name }}</td>
                                        @if($centeruserslist->create_institution == 0)
                                        <td>Admin</td>
                                        @else
                                        <td>Coordinator</td>
                                        @endif
                                        <td>{{ $centeruserslist->phone }}</td>
                                        <td>{{ $centeruserslist->status }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default">Action</button>
                                                <button type="button"
                                                class="btn btn-default dropdown-toggle dropdown-icon"
                                                data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a onclick="edituser('{{ $centeruserslist->id }}','{{ $centeruserslist->dist_id }}','{{ $centeruserslist->district_name }}','{{ $centeruserslist->full_name }}','{{ $centeruserslist->phone }}','{{ $centeruserslist->username }}','{{ $centeruserslist->cpassword }}','{{ $centeruserslist->status }}','{{ $centeruserslist->create_institution }}','{{ $centeruserslist->tailoring_user }}','{{ $centeruserslist->tailoring_ins_name }}','{{ $centeruserslist->tailoring_ins_location }}')"
                                                    type="button" class="dropdown-item">Edit User</a>

                                                    <a onclick="userdatas('{{ $centeruserslist->id }}','{{ $centeruserslist->full_name }}','{{ $centeruserslist->username }}','{{ $centeruserslist->district_name }}','{{ $centeruserslist->cpassword }}','{{ $centeruserslist->phone }}','{{ $centeruserslist->status }}')"
                                                        type="button" class="dropdown-item">View User</a>

                                                    </div>
                                                </div>
                                            </td>
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
    </section>
    <div class="modal fade" id="Centerusers">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Admin User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/adduser') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>District Name</label>
                                    <select required class="form-control select2" name="dist_id" id="dist_id"
                                    style="width: 100%;">
                                    <option value="">Select District Name</option>
                                    @foreach ($managedistrict as $district)
                                    <option value="{{ $district->id }}">{{ $district->district_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>User Type</label>
                                <select class="form-control" name="user_type_id" id="usertype_id" style="width: 100%;">
                                    @foreach ($manageusertype as $usertype)
                                    <option value="{{ $usertype->id }}">{{ $usertype->group_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                              <div class="custom-control custom-checkbox">
                               <input class="custom-control-input" name="create_institution" type="checkbox" id="customCheckbox1" value="0">
                               <label for="customCheckbox1" class="custom-control-label">Allow Add Institution</label>
                           </div>
                       </div>
                       <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input required maxlength="30" type="text" class="form-control" name="full_name"
                        id="full_name" placeholder="Enter Full Name">
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input required maxlength="15" type="text" class="form-control number"
                        name="phone" id="phone" placeholder="Enter Phone" maxlength="10">
                        <span id="dupmobile" style="color:red"></span>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Username</label>
                                <input onkeyup="duplicate_username(0)" required maxlength="30" type="text"
                                class="form-control" name="username" id="username"
                                placeholder="Enter Username">
                                <span id="dupusername" style="color:red"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input required maxlength="20" type="text" class="form-control"
                                name="password" id="password" placeholder="Enter Password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone">Photo</label>
                        <input required maxlength="15" type="file" class="form-control number"
                        name="scholarship_image" id="scholarship_image" placeholder="Enter Phone" maxlength="10">
                        <span id="scholarship_image" style="color:red"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button id="save" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
</div>
</div>


<div class="modal fade" id="editcenteruser">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Admin User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/edituser') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="id" id="editid">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>District Name</label>
                                <select required class="form-control" name="dist_id" id="editdist_id"
                                style="width: 100%;">
                                <option value="">Select District Name</option>
                                @foreach ($managedistrict as $district)
                                <option value="{{ $district->id }}">{{ $district->district_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" id="status" style="width: 100%;">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="custom-control custom-checkbox">
                           <input class="custom-control-input" name="create_institution" type="checkbox" id="create_institution" value="0">
                           <label for="create_institution" class="custom-control-label">Allow Add Institution</label>
                       </div>


                       <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input required maxlength="30" type="text" class="form-control" name="full_name"
                        id="editfull_name" placeholder="Enter Full Name">
                    </div>
                    <div class="form-group" style="display:none;" id="tailoringinstitutenamehide">
                        <label for="full_name">Tailoring Institute Name</label>
                        <input maxlength="50" type="text" class="form-control" name="tailoring_ins_name"
                        id="tailoring_ins_name" placeholder="Enter Institution Name">
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input required maxlength="30" type="text" class="form-control number"
                        name="phone" id="editphone" placeholder="Enter Phone" maxlength="10">
                        <span id="dupmobile" style="color:red"></span>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Username</label>
                                <input onkeyup="duplicate_username_edit()" required maxlength="30"
                                type="text" class="form-control" name="username" id="editusername"
                                placeholder="Enter Username">
                                <span id="dupusernameedit" style="color:red"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input required maxlength="20" type="text" class="form-control"
                                name="password" id="editpassword" placeholder="Enter Password">
                            </div>
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox">
                       <input class="custom-control-input" name="tailoring_user" type="checkbox" id="tailoring_user" value="0">
                       <label for="tailoring_user" class="custom-control-label">Tailoring Institution</label>
                   </div>
                   <div class="form-group">
                    <label for="phone">Photo</label>
                    <input type="file" class="form-control"
                    name="cordinator_image" id="cordinator_image">

                </div>
                <div class="form-group" style="display:none;" id="tailoringlocationhide">
                    <label for="full_name">Tailoring Institute Location</label>
                    <input maxlength="50" type="text" class="form-control" name="tailoring_ins_location"
                    id="tailoring_ins_location" placeholder="Enter Institution Location">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="editsave" type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
</div>
</div>
</div>

<div class="modal fade" id="userdata">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="full_name"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>ID </label>
                    <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                        id="id"></span> </label>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>UserName
                        </label>
                        <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                            id="usernames"></span> </label>
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
                                        id="phones"></span></label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Status
                                        </label>
                                        <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                            id="statuses"></span> </label>
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
                        @endsection
                        @push('page_scripts')
                        <script>
                            $('#tailoring_user').click(function() {
                                if( $(this).is(':checked')) {
                                    $("#tailoringinstitutenamehide").show();
                                    $("#tailoringlocationhide").show();
                                     $('#tailoring_ins_name').attr("required", true);
                                  $('#tailoring_ins_location').attr("required", true);
                                } else {
                                    $("#tailoringinstitutenamehide").hide();
                                    $("#tailoringlocationhide").hide();
                                     $('#tailoring_ins_name').attr("required", false);
                                  $('#tailoring_ins_location').attr("required", false);
                                }
                            }); 
                            function edituser(id, dist_id, taluk_id, full_name, phone, username, cpassword, status,create_institution,tailoring_user,ins_name,ins_location) {
                              $("#create_institution").prop( "checked", false );
                              $("#tailoring_user").prop( "checked", false );
                               $("#tailoring_ins_name").val("");
                                $("#tailoring_ins_location").val("");
                              $("#tailoringinstitutenamehide").hide();
                              $("#tailoringlocationhide").hide();
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
                              $("#editfull_name").val(full_name);
                              $("#editphone").val(phone);
                              $("#editusername").val(username);
                              $("#editpassword").val(cpassword);
                              $("#status").val(status);
                              if(create_institution == 1){
                                $("#create_institution").prop( "checked", true );
                            }
                            if(tailoring_user == 1){
                                $("#tailoring_user").prop( "checked", true );
                                $("#tailoringinstitutenamehide").show();
                                $("#tailoringlocationhide").show();
                                $("#tailoring_ins_name").val(ins_name);
                                $("#tailoring_ins_location").val(ins_location);
                                  $('#tailoring_ins_name').attr("required", true);
                                  $('#tailoring_ins_location').attr("required", true);
                            }

                            $("#editcenteruser").modal("show");
                        }


                        function userdatas(id, full_name, username, district_name, cpassword, phone, status) {
                            $("#id").text(id);
                            $("#full_names").text(full_name);
                            $("#usernames").text(username);
                            $("#district_name").text(district_name);
                            $("#pas").text(cpassword);
                            $("#phones").text(phone);
                            $("#statuses").text(status);
                            $('#msgbtn').attr('href', 'https://api.whatsapp.com/send?phone=91' + phone +
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
