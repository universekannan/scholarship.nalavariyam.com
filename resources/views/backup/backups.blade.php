@extends('layouts.app')
@section('content')

    <div class="content-wrapper">
        <section class="content">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <div class="col-sm-5">
                            <center>
                                <div class="nav-link">Database Create</div>
                            </center>
                        </div>
                        <div class="col-sm-3"></div>
                        <!--<div class="col-sm-4" style="padding-top: calc(.5rem + 0px);">
                      <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Customer Full Name">
                   </div>-->
                        <div class="col-sm-3 " style="padding-top: calc(.5rem + 0px);">
                            <td>
                                <form action="{{ url('backup/create') }}" method="GET" enctype="multipart/form-data"
                                    id="CreateBackupForm">
                                    {{ csrf_field() }}
                                    <input type="submit" name="submit" class="btn btn-primary btn-sm"
                                        style="margin-bottom:2em;" value="Create Database Backup">
                                </form>
                            </td>

                        </div>

                    </ul>
                </div>
                <div class="card-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissable">
                            <a href="#" style="color:white !important" class="close" data-dismiss="alert"
                                aria-label="close">&times;</a>
                            <strong> {{ session('success') }} </strong>
                        </div>
                    @endif
                    @if (Session::has('update'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ Session::get('update') }}
                        </div>
                    @endif

                    @if (Session::has('delete'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ Session::get('delete') }}
                        </div>
                    @endif
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                            aria-labelledby="custom-tabs-four-home-tab">

                            @if (count($backups))
                            <table id="example2" class="table table-bordered table-striped">
                              <thead>
                                 <tr>
                                    <th>File Name</th>
                                    <th>File Size</th>
                                    <th>Created Date</th>
                                    <th>Created Age</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach($backups as $backup)
                                 <tr>
                                    <td>{{ $backup['file_name'] }}</td>
                                    <td>{{ \App\Http\Controllers\BackupController::humanFilesize($backup['file_size']) }}</td>
                                    <td>
                                       {{ date('F jS, Y, g:ia (T)',$backup['last_modified']) }}
                                    </td>
                                    <td>
                                       {{ \Carbon\Carbon::parse($backup['last_modified'])->diffForHumans() }}
                                    </td>
                                    <td>
                                       <a class="btn btn-success"
                                          href="{{ url('backup/download/'.substr($backup['file_name'],5)) }}"><i
                                          class="fa fa-cloud-download"></i> Download</a>
                                       <a class="btn btn-danger" onclick="return confirm('Do you really want to delete this file')" data-button-type="delete"
                                          href="{{ url('/backup/delete/'. substr($backup['file_name'],5)) }}"><i class="fa fa-trash-o"></i>
                                       Delete</a>
                                    </td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                            @else
                                <div class="well">
                                    <h4 class="text-center">No Backups</h4>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    <!-- /.content -->
    </div>
@endsection
