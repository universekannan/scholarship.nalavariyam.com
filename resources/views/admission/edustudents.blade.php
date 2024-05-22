@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Edu Students List</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#edustudents"><i class="fa fa-plus"> Add </i></button></li>
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
                  @if(session()->has('error'))
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
                            <th> S No</th>
                            <th> Students Name</th>
                            <th> Status</th>
                            <th> Action</th>

                         </tr>
                      </thead>
                      <tbody>
                        @foreach($edustudents as $edustudentslist)
                        <tr>
                           <td>{{ $edustudentslist->id }}</td>
                           <td>{{ $edustudentslist->student_name }}</td>
                           <td>{{ $edustudentslist->status }}</td>
                           <td>
                           <a href="{{ url('/admission/assigncollege',$edustudentslist->id ) }}" class="btn btn-info"><i class="fa fa-eye"title="view"></i> Admission</a>
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
<div class="modal fade" id="edustudents">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add Edu Type Details</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{url('/addedustudents')}}" method="post">
            {{ csrf_field() }}
            <div class="modal-body">
               <div class="form-group">
                  <label for="edustudents_name">Edu instucen Name</label>
                  <input type="text" class="form-control"  name="edustudents_name" id="edustudents_name" placeholder="Enter Edu instucen Name">
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
@endsection