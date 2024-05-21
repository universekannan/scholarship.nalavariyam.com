@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tailoring Institute</h1>
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
                                        <th> Institute Location</th>
                                        <th> Phone</th>
                                        <th> Status</th>
                                        <th> Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($manageinstitute as $key => $instituteslist)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>N{{ $instituteslist->id }}</td>
                                        <td>{{ $instituteslist->district_name }}</td>
                                        <td>{{ $instituteslist->tailoring_ins_name }}</td>
                                        <td>{{ $instituteslist->tailoring_ins_location }}</td>
                                        <td>{{ $instituteslist->phone }}</td>
                                        <td>{{ $instituteslist->status }}</td>
                                        <td> 
                                            <a onclick="userdatas('{{ $instituteslist->id }}','{{ $instituteslist->tailoring_ins_name }}','{{ $instituteslist->tailoring_ins_location }}','{{ $instituteslist->username }}','{{ $instituteslist->cpassword }}','{{ $instituteslist->phone }}','{{ $instituteslist->status }}')" type="button" class="btn btn-primary btn-sm">View</a>

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
                        id="insid"></span> </label>
                    </div>
                     <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Institute Name </label>
                    <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                        id="insname"></span> </label>
                    </div> 
                    <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Institute Location </label>
                    <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                        id="inslocation"></span> </label>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>UserName
                        </label>
                        <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                            id="insusername"></span> </label>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Password
                            </label>
                            <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                id="inspassword"></span></label>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Phone
                            </label>
                            <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                id="insphone"></span></label>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Status
                            </label>
                            <label for="" class="col-sm-8 col-form-label"><span style="color:red"
                                id="insstatus"></span> </label>
                        </div>

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
                            
                            function userdatas(id,insname,inslocation,username,cpassword,phone, status) {
                                $("#insid").text(id);
                                $("#insname").text(insname);
                                $("#inslocation").text(inslocation);
                                $("#insusername").text(username);
                                $("#inspassword").text(cpassword);
                                $("#insphone").text(phone);
                                $("#insstatus").text(status);
                                $("#userdata").modal("show");
                            }
                        </script>
                        @endpush
