@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Center Users</h1>
                </div>

                <div class="col-sm-6">
                    @if (Auth::user()->user_type_id == 1)
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm"
                                    data-toggle="modal" data-target="#Centerusers"><i class="fa fa-plus"> Add </i></button>
                            </li>
                        </ol>
                    @else
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">View Center Users Details</h3>
                        </div>
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
                                            <th>Districts</th>
                                            <th>Taluks</th>
                                            <th>FULL NAME</th>
                                            <th>PHONE</th>
                                            <th>STATUS</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($centerusers as $key => $centeruserslist)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $centeruserslist->id }}</td>
                                                <td>{{ $centeruserslist->district_name }}</td>
                                                <td>{{ $centeruserslist->taluk_name }}</td>
                                                {{-- <td>{{ $centeruserslist->panchayath_name }}</td> --}}
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
                                                            <a class="dropdown-item"
                                                                href="{{ url('/edituser', $centeruserslist->id) }}">Edit
                                                                User</a>
                                                            <a onclick="userdatas('{{ $centeruserslist->id }}','{{ $centeruserslist->full_name }}','{{ $centeruserslist->username }}','{{ $centeruserslist->district_name }}','{{ $centeruserslist->taluk_name }}','{{ $centeruserslist->email }}','{{ $centeruserslist->pas }}','{{ $centeruserslist->phone }}','{{ $centeruserslist->status }}','{{ $centeruserslist->profile_photo }}',)"
                                                                type="button" class="dropdown-item">View User</a>
                                                            @if (Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2 || Auth::user()->user_type_id == 3)
                                                                <a onclick="userstatus('{{ $centeruserslist->id }}','{{ $centeruserslist->full_name }}','{{ $centeruserslist->from_to_date }}','{{ $centeruserslist->status }}')"
                                                                    type="button" class="dropdown-item">Status</a>
                                                            @else
                                                                <a class="dropdown-item"
                                                                    href="{{ url('/userstatusupdate') }}/{{ $centeruserslist->id }}/{{ $centeruserslist->user_type_id }}">Status
                                                                    Update</a>
                                                            @endif
                                                            <a onclick="userwallet('{{ $centeruserslist->id }}','{{ $centeruserslist->full_name }}','{{ $centeruserslist->wallet }}')"
                                                                type="button" class="dropdown-item">View Wallet</a>
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
                    <h4 class="modal-title">Add Center Users Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/adduser') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_type_id" value="2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>District Name</label>
                                    <select class="form-control select2" name="dist_id" id="dist_id" style="width: 100%;">
                                        <option value="">Select District Name</option>
                                        @foreach ($managedistrict as $district)
                                            <option value="{{ $district->id }}">{{ $district->district_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" class="form-control" name="full_name" id="full_name"
                                        placeholder="Enter Full Name">
                                </div>
                                <div class="form-group">
                                    <label for="full_name">Gender</label>
                                    <div class="radio">
                                        <label>
                                            Select
                                            <l /abel>
                                                <label>
                                                    <input type="radio" name="gender" id="male" value="1">
                                                    Male
                                                </label>
                                                <label>
                                                    <input type="radio" name="gender" id="female" value="2">
                                                    Female
                                                </label>

                                                <label for="phone">Phone</label>
                                                <input type="text" class="form-control-4" name="phone"
                                                    id="phone" placeholder="Enter Phone">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Taluk Name</label>
                                    <select class="form-control select2" name="taluk_id" id="taluk"
                                        style="width: 100%;">
                                        <option value="">Select Taluk Name</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="username">User Name</label>
                                    <input type="text" class="form-control" name="username" id="username"
                                        placeholder="User Name">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Enter Password">
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
                                id="username"></span> </label>
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
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Panchayath
                        </label>
                        <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                id="panchayathname"></span> </label>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Email
                        </label>
                        <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                id="emails"></span></label>
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
                                id="status"></span> </label>
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
    <div class="modal fade" id="wallets">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="name"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <h1 id="userwallet"></h1>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a type="" class=""></a>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="userstatusmodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="statusname"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/userstatus') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="userid" id="statusid">
                        <div class="form-group">
                            <label>District Name</label>
                            <select class="form-control" name="status" id="userstatus" style="width: 100%;">
                                <option value="">Select District Name</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="full_name">From Date</label>
                            <input type="date" class="form-control" name="from_to_date" id="fromdate">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
    <script>
        function userdatas(id, full_name, username, district_name, taluk_name, panchayath_name, email, pas, phone, status) {
            $("#id").text(id);
            $("#full_names").text(full_name);
            $("#username").text(username);
            $("#district_name").text(district_name);
            $("#talukname").text(taluk_name);
            $("#panchayathname").text(panchayath_name);
            $("#emails").text(email);
            $("#pas").text(pas);
            $("#phones").text(phone);
            $("#status").text(status);
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
                    $('#panchayath').html('<option value="">-- Select Panchayath --</option>');
                }
            });
        });


        $('#taluk').on('change', function() {
            var taluk_id = this.value;
            $("#panchayath").html('');
            var url = "{{ url('/getpanchayathlimit') }}/" + taluk_id;
            $.ajax({
                url: url,
                type: "GET",
                success: function(result) {
                    $('#panchayath').html('<option value="">-- Select Panchayath Name --</option>');
                    $.each(result, function(key, value) {
                        $("#panchayath").append('<option value="' + value
                            .id + '">' + value.panchayath_name + '</option>');
                    });
                }
            });
        });
    </script>
    <script>
        function userwallet(id, full_name, wallet) {
            $("#id").text(id);
            $("#name").text(full_name);
            $("#userwallet").text(wallet);
            $("#wallets").modal("show");
        }

        function userstatus(id, full_name, fromto_date, status) {
            $("#statusid").val(id);
            $("#statusname").text(full_name);
            $("#fromdate").val(fromto_date);
            $("#userstatus").val(status);
            $("#userstatusmodal").modal("show");

        }
    </script>
@endpush
