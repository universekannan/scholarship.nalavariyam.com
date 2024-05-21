@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Students Approval</h1>
                </div>
                <div class="col-sm-6">
                   
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
                                            <th>Student Id</th>
                                            <th>Student Name</th>
                                            <th>Info</th>
                                            <th>Pay Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                    <tbody>
                        @foreach ($approvestudent as $key => $approve)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>N{{ $approve->from_id }}</td>
                                <td>{{ $approve->student_name }}</td>
                                <td>{{ $approve->ad_info }}</td>
                                <td>{{ $approve->pay_date }}</td>
                                <td>{{ $approve->status }}</td>
                              
                                <td>
                                 <a onclick="viewdata('{{ $approve->id }}','{{ $approve->from_id }}','{{ $approve->student_name }}','{{ $approve->paid_img }}')"
                                                type="button" class="btn btn-primary btn-sm">View </a>
     <a href="{{ url('rejectstudent') }}/{{ $approve->from_id }}" type="button" class="btn btn-danger btn-sm">Reject</a>

 <a href="{{ url('acceptstudent') }}/{{ $approve->from_id }}" type="button" class="btn btn-success btn-sm">Accept</a>


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
                    <h4 class="modal-title" id="studentnames"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Student ID </label>
                        <label for="" class="col-sm-8 col-form-label"><span style="color:red" id="id"></span>
                        </label>
                    </div>
                    <center>
                      <img src="" id="reqpaidimage" class="mb-3" style="opacity: .8; width:100%;height:350px">
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
       
        function viewdata(id,student_id, student_name, paid_img) {
            $("#id").text(student_id);
            $("#studentnames").text(student_name);
            if(paid_img != ""){
                $("#reqpaidimage").attr("src", '../upload/student/paid_img/' + paid_img);
            }
     
            $("#userdata").modal("show");
        }
        
    </script>
@endpush
