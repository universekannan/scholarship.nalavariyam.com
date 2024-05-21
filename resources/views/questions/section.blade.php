@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>section</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            @if(Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2)
                            <a type="button" href="{{ url('addstudent') }}" class="btn btn-block btn-primary btn-sm"><i
                                    class="fa fa-plus"> Add </i></a>
                            @else
                             <a type="button" href="{{ url('addinstitutestudent') }}" class="btn btn-block btn-primary btn-sm"><i
                                    class="fa fa-plus"> Add </i></a>
                             @endif
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
                                            <th>User Id</th>
                                          
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($section as $key => $sectionlist)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $sectionlist->section_name }}</td>
                                                <td>
												 <a href="{{ url('questionscound') }}/{{ $sectionlist->id }}" type="button" class="dropdown-item">View Questions Cound</a>

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
	
@endsection
