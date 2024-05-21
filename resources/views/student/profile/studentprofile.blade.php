@extends('student.layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Student Profile</h1>
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
                            @foreach ($profile as $pro)
                                <form action="{{ url('/updatestudentprofile') }}" method="post"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <input type="hidden" name="id" value="{{ $pro->id }}" />
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="student_name" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Student Name</label>
                                                <div class="col-sm-8">
                                                    <input required="requiered" type="text" class="form-control"
                                                        name="student_name" id="student_name" maxlength="30"
                                                        placeholder="Full Name" value="{{ $pro->student_name }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="cell_number" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Mobile Number</label>
                                                <div class="col-sm-8">
                                                    <input required="requiered" type="text" class="form-control number"
                                                        name="cell_number" id="phone" placeholder="Mobile Number"
                                                        value="{{ $pro->cell_number }}" onkeyup="duplicatephone(0)"
                                                        maxlength="10">
                                                    <span id="dupmobile" style="color:red"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="photo" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Student Photo</label>
                                                <div class="col-sm-7">
                                                    <input type="file" name="photo" value="Upload Image">
                                                </div>
                                                <div class="col-sm-1">
                                                    <button type="button" class="btn btn-default" data-toggle="modal"
                                                        data-target="#viewprofile{{ $pro->id }}"><i
                                                            class="fa fa-eye"></i> </button>
                                                </div>
                                                <div class="modal fade" id="viewprofile{{ $pro->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Student Profile</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <center><img style="width:200px"
                                                                        src="{{ URL::to('/') }}/upload/student/photo/{{ $pro->photo }}" />
                                                                </center>
                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
