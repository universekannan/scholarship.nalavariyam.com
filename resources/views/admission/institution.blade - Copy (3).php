@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Institution List</h1>
         </div>
         <div class="col-sm-6">
            @if((Auth::user()->user_type_id == 1))
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#institution"><i class="fa fa-plus"> Add </i></button></li>
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
						        <th> Institution Name</th>
						        <th> Status</th>
                          <th> Action</th>
                         
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($institution as $institutionlist)
                        <tr>
                           <td>{{ $institutionlist->id }}</td>
                           <td>{{ $institutionlist->institution_name }}</td>
                           <td>{{ $institutionlist->status }}</td>
                           <td>
                      <a data-toggle="modal" data-target="#EditInstitution{{ $institutionlist->id }}" class="btn btn-info"><i class="fa fa-edit"title="Edit"> Edit </i></a>
					    <div class="modal fade" id="EditInstitution{{ $institutionlist->id }}">
							<div class="modal-dialog modal-md">
							  <div class="modal-content">
								 <div class="modal-header">
									<h4 class="modal-title">Edit Edu Type Details</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								 </div>
								 <form action="{{url('/updateinstitution')}}" method="post">
									{{ csrf_field() }}
								<input type="hidden" value="{{ $institutionlist->id }}" name="edutypeinstitution_id">
									<div class="modal-body">
											 <div class="form-group">
												<label for="institution_name">Institution Name</label>
												<input type="text" value="{{ $institutionlist->institution_name }}" class="form-control"  name="institution_name" id="institution_name" placeholder="">
											 </div>
											  <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control select2" style="width: 100%;">
                                                <option @if($institutionlist->status == "Active") selected @endif value="Active">Active</option>
                                                <option @if($institutionlist->status == "Inactive") selected @endif value="Inactive">Inactive</option>
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
							
										  
										  
										  
                      <a href="{{ url('/admission/department',$institutionlist->id ) }}" class="btn btn-info"><i class="fa fa-eye"title="view"> View Department</i></a>
					  					  
                     <a onclick="return confirm('Do you want to perform delete operation?')" href="{{ url('/deleteinstitution' , $institutionlist->id) }}" class="btn btn-info"><i class="fa fa-trash"title="Delete"> Delete</i></a>
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
<div class="modal fade" id="institution">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add Edu Type Details</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{url('/addinstitution')}}" method="post">
            {{ csrf_field() }}
            <div class="modal-body">
                     <div class="form-group">
                        <label for="institution_name">Edu instucen Name</label>
                        <input type="text" class="form-control"  name="institution_name" id="institution_name" placeholder="Enter Edu instucen Name">
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