@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Center Users</h1>
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
                                            <th>Full Name</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($centerusers as $key => $centeruserslist)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $centeruserslist->id }}</td>
                                                <td>{{ $centeruserslist->full_name }}</td>
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
                                                            <a onclick="edituser('{{ $centeruserslist->id }}','{{ $centeruserslist->full_name }}','{{ $centeruserslist->phone }}','{{ $centeruserslist->username }}','{{ $centeruserslist->cpassword }}','{{ $centeruserslist->status }}','{{ $centeruserslist->user_type_id }}')"
                                                                type="button" class="dropdown-item">Edit User</a>
                                                            <a onclick="userdatas('{{ $centeruserslist->id }}','{{ $centeruserslist->full_name }}','{{ $centeruserslist->username }}','{{ $centeruserslist->cpassword }}','{{ $centeruserslist->phone }}','{{ $centeruserslist->status }}')"
                                                                type="button" class="dropdown-item">View User</a>
                                                            @if (Auth::user()->user_type_id == 2)
                                                                <a class="dropdown-item"
                                                                    href="{{ url('/userstatusupdate') }}/{{ $centeruserslist->id }}">Status
                                                                    Update</a>
                                                            @endif
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
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Taluk
                        </label>
                        <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                id="talukname"></span> </label>
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
    </div>
    </div>
    </div>
@endsection
@push('page_scripts')
    <script>
        function edituser(id, full_name, phone, username, password, status, user_type_id) {
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
            $("#editpassword").val(password);
            $("#editusertypeid").val(user_type_id);
            $("#status").val(status);
            $("#editcenteruser").modal("show");
        }

        function userdatas(id, full_name, username,pas, phone, status) {
            $("#id").text(id);
            $("#full_names").text(full_name);
            $("#usernames").text(username);
            $("#pas").text(pas);
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
