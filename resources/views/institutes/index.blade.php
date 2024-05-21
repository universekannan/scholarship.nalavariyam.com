        @extends('layouts.app')
        @section('content')
        <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Institute</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm"
                data-toggle="modal" data-target="#Institutes"><i class="fa fa-plus"> Add </i></button>
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
                                <th> #</th>
                                <th> ID</th>
                                <th> District</th>
                                <th> Institute Name</th>
                                <th> Phone</th>
                                <th> Status</th>
                                <th> Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($institutes as $key => $instituteslist)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>N{{ $instituteslist->id }}</td>
                                <td>{{ $instituteslist->district_name }}</td>
                                <td>{{ $instituteslist->full_name }}</td>
                                <td>{{ $instituteslist->phone }}</td>
                                <td>{{ $instituteslist->status }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default">Action</button>
                                        <button type="button"
                                        class="btn btn-default dropdown-toggle dropdown-icon"
                                        data-toggle="dropdown">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
										@php 
										$address = $instituteslist->address;
										$address = str_replace(PHP_EOL,' ',$address);
										@endphp
										<div class="dropdown-menu" role="menu">
                                        <a href="{{ url('/instudents') }}/{{ $instituteslist->id }}" class="dropdown-item">View  Students</a>    
										<a onclick="edituser('{{ $instituteslist->id }}','{{ $instituteslist->dist_id }}','{{ $instituteslist->full_name }}','{{ $instituteslist->phone }}','{{ $instituteslist->email }}','{{ $instituteslist->username }}','{{ $instituteslist->cpassword }}','{{ $instituteslist->status }}','{{ $address }}','{{ $instituteslist->institution_type }}','{{ $instituteslist->institution_photo }}')" type="button" class="dropdown-item">Edit User</a>

										<a onclick="userdatas('{{ $instituteslist->id }}','{{ $instituteslist->full_name }}','{{ $instituteslist->username }}','{{ $instituteslist->district_name }}','{{ $instituteslist->email }}','{{ $instituteslist->cpassword }}','{{ $instituteslist->phone }}','{{ $instituteslist->status }}','{{ $instituteslist->user_photo }}')" type="button" class="dropdown-item">View User</a>

                                        </div>
                                    </td>
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
        </div>
        </section>
        <div class="modal fade" id="editinstitute">
        <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Edit Institute</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form action="{{ url('/editinstitute') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id" id="editid">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>District Name</label>
                        <select required class="form-control select2" name="dist_id" id="editdist_id"
                        style="width: 100%;">
                        <option value="">Select District Name</option>
                        @foreach ($managedistrict as $district)
                        <option value="{{ $district->id }}">{{ $district->district_name }}</option>
                        @endforeach
                    </select>
                </div>

   
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status" id="editstatus" style="width: 100%;">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control" name="address" rows="3" id="editaddress" placeholder="Enter Address ...."></textarea>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" maxlength="30" class="form-control" name="email" rows="3" id="editemail" />
                </div>
             
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input required maxlength="30" type="text" class="form-control" name="full_name"
                    id="editfull_name" placeholder="Enter Full Name">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input required maxlength="30" type="text" class="form-control number"
                    name="phone" id="editphone" placeholder="Enter Phone" maxlength="10">
                    <span id="dupmobile" style="color:red"></span>
                </div>
                <div class="form-group">
                                            <label>Institution Type</label>
                                            <select required class="form-control" name="institution_type" id="editinstitution_type"
                                                style="width: 100%;">
                                                <option value="School">School</option>
                                                <option value="College">College</option>
                                            </select>
                                        </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Username</label>
                            <input readonly  maxlength="30"
                            type="text" class="form-control" name="username" id="name"
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

            </div>
              <div class="col-md-12">
                    <div class="form-group">
                        <label>Institute Photo</label>
                        <input class="form-control" name="institute_photo" type="file" accept="image/*">
                    </div>
                      <img src="" id="editinstitutephoto" class="mb-3" width="100" height="100">
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

        <div class="modal fade" id="Institutes">
        <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Add Institute</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form action="{{ url('/addinstitute') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>District</label>
                        <select class="form-control select2" name="dist_id" id="dist_id" style="width: 100%;">
                            <option value="">Select District</option>
                            @foreach ($managedistrict as $district)
                            <option value="{{ $district->id }}">{{ $district->district_name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="full_name">Institute Name</label>
                        <input type="text" class="form-control" name="full_name" id="full_name"
                        placeholder="Enter Institute Name">
                    </div>


                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input onkeyup="duplicateemail(0)" type="email" class="form-control"
                        name="email" id="email" placeholder="Enter email">
                        <span id="dupemail" style="color:red"></span>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone"
                        placeholder="Enter Phone" onkeyup="duplicatephone(0)" maxlength="10">
                        <span id="dupmobile" style="color:red"></span>
                    </div>

                             <div class="form-group">
                                            <label>Institution Type</label>
                                            <select required class="form-control select2" name="institution_type" id="institution_type"
                                                style="width: 100%;">
                                                <option value="">Select</option>
                                                <option value="School">School</option>
                                                <option value="College">College</option>
                                            </select>
                                        </div>

                </div>
                 <div class="col-md-12">
                    <div class="form-group">
                        <label>Institute Photo</label>
                        <input class="form-control" name="institute_photo" type="file" accept="image/*">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Address</label>
                        <textarea class="form-control" name="address" rows="3" placeholder="Enter Address ...."></textarea>
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
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Email
                        </label>
                        <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                            id="emails"></span></label>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Password
                            </label>
                            <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                id="password"></span></label>
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
                                        id="viewstatus"></span> </label>
                                    </div>
                                    <center>
                                        <a class="btn btn-info" id="msgbtn" href="" data-action="share/whatsapp/share"
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
                                            <button id="save" type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endsection
                    @push('page_scripts')
                    <script>
                        function edituser(id, dist_id,full_name, phone,email, username, cpassword, status,address,institutetype,institutephoto) {
                            $("#editid").val(id);
                            $("#editdist_id").select2().select2('val',dist_id);
                            $("#editinstitution_type").val(institutetype);
                            $("#editfull_name").val(full_name);
                            $("#editphone").val(phone);
                            $("#editemail").val(email);
                            $("#editusername").val(username);
                            $("#editpassword").val(cpassword);
                            $("#editstatus").val(status);
                            $("#editinstitution_type").val(institutetype);
                             if(institutephoto != ""){
                                 $("#editinstitutephoto").attr("src", '../upload/institutephoto/' + institutephoto);
                              }
                            $("#editinstitute").modal("show");
                        }

                        function userdatas(id, full_name, username, district_name,email, cpassword, phone, status) {
                            $("#id").text(id);
                            $("#full_names").text(full_name);
                            $("#username").text(username);
                            $("#district_name").text(district_name);
                            $("#emails").text(email);
                            $("#password").text(cpassword);
                            $("#phones").text(phone);
                            $("#viewstatus").text(status);
                            $('#msgbtn').attr('href', 'https://api.whatsapp.com/send?phone=91' + phone +
                                '&text=Sir, We are from NalaVariyam , Your Login UserName : ' + username + ', Password : ' + cpassword +
                                ', Contact Us : Mobile 7598984380 Email : ramjitrust039@gmail.com, Website : www.nalavariyam.com. I have attached your Login website  link below https://nalavariyam.com/apps/'
                                )
                            $("#userdata").modal("show");
                        }

        

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

                        function pay_now(userid) {
                            $("#renewaluserid").val(userid);
                            var wallet_amount = parseFloat($("#wallet_amount").val());
                            var payment_amount = parseFloat($("#payment_amount").val());
                            $("#pay_amount").val(payment_amount);
                            if (payment_amount > wallet_amount) {
                                $("#referral_modal").modal("show");
                            } else {
                                $("#paynow_modal").modal("show");
                            }
                        }
                    </script>
                    @endpush
