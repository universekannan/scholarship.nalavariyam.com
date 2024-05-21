@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Education Types</h1>
         </div>
         <div class="col-sm-6">
            @if((Auth::user()->user_type_id == 1))
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#edu_type"><i class="fa fa-plus"> Add </i></button></li>
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
                          <th> S No</th>
						        <th> Edu Type</th>
						        <th> Status</th>
                          <th> Action</th>
                         
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($edutype as $edutypelist)
                        <tr>
                           <td>{{ $edutypelist->id }}</td>
                           <td>{{ $edutypelist->edutype_name }}</td>
                           <td>{{ $edutypelist->status }}</td>
                           <td>
                      <a data-toggle="modal" data-target="#EditEdutype{{ $edutypelist->id }}" class="btn btn-info"><i class="fa fa-edit"title="Edit"> Edit </i></a>
					    <div class="modal fade" id="EditEdutype{{ $edutypelist->id }}">
							<div class="modal-dialog modal-md">
							  <div class="modal-content">
								 <div class="modal-header">
									<h4 class="modal-title">Edit Edu Type Details</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								 </div>
								 <form action="{{url('/updateedutype')}}" method="post">
									{{ csrf_field() }}
								<input type="hidden" value="{{ $edutypelist->id }}" name="id">
									<div class="modal-body">
											 <div class="form-group">
												<label for="edutype_name">Edutype Name</label>
												<input type="text" value="{{ $edutypelist->edutype_name }}" class="form-control"  name="edutype_name" id="edutype_name" placeholder="">
											 </div>
											  <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control select2" style="width: 100%;">
                                                <option @if($edutypelist->status == "Active") selected @endif value="Active">Active</option>
                                                <option @if($edutypelist->status == "Inactive") selected @endif value="Inactive">Inactive</option>
                                                </select>
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
							
										  
										  
										  
                     <a href="{{ url('/admission/courses',$edutypelist->id ) }}" class="btn btn-info"><i class="fa fa-eye"title="view"> View Department</i></a>
					  					  
                     <a onclick="return confirm('Do you want to perform delete operation?')" href="{{ url('/deleteedutype' , $edutypelist->id) }}" class="btn btn-info"><i class="fa fa-trash"title="Delete"> Delete</i></a>
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
<div class="modal fade" id="edu_type">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add Edu Type Details</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{url('/addedutype')}}" method="post">
            {{ csrf_field() }}
            <div class="modal-body">
                     <div class="form-group">
                        <label for="edutype_name">Edu Type Name</label>
                        <input type="text" class="form-control"  name="edutype_name" id="edutype_name" placeholder="Enter Edu Type Name">
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