@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Colleges List</h1>
         </div>
         <div class="col-sm-6">
            @if((Auth::user()->user_type_id == 1))
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#colleges"><i class="fa fa-plus"> Add </i></button></li>
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
						  <th> Colleges Name</th>
						  <th> Edu Type Name</th>
                          <th> Action</th>
                         
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($colleges as $institutionlist)
                        <tr>
                           <td>{{ $institutionlist->id }}</td>
                           <td>{{ $institutionlist->college_name }}</td>
                           <td>{{ $institutionlist->edutype_name }} </td> 
                           
                              <td style="white-space: nowrap">
                                 <a onclick="edit_colleges('{{ $institutionlist->id }}','{{ $institutionlist->district_id }}','{{ $institutionlist->edutype_id }}','{{ $institutionlist->college_name }}')"
                                     href="#" class="btn btn-info"><i
                                         class="fa fa-edit"></i>Edit</a>



                              <a href="{{ url('/admission/department',$institutionlist->id ) }}" class="btn btn-info"><i class="fa fa-eye"title="view"> View Department</i></a>
					  					  
                              <a onclick="return confirm('Do you want to perform delete operation?')" href="{{ url('/deletecolleges' , $institutionlist->id) }}" class="btn btn-info"><i class="fa fa-trash"title="Delete"> Delete</i></a>

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



                      
					    <div class="modal fade" id="editcolleges">
							<div class="modal-dialog modal-md">
							  <div class="modal-content">
								 <div class="modal-header">
									<h4 class="modal-title">Edit College Details</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								 </div>
								 <form action="{{url('/updatecolleges')}}" method="post">
									{{ csrf_field() }}
                           <input type="hidden" name="row_id" id="row_id">
								
									<div class="modal-body">
                              <div class="form-group">
                                 <label>District Name</label>
                                 <select required class="form-control select2" name="district_id" id="editdistrictid"
                                    style="width: 100%;">
                                    <option value="">Select District Name</option>
                                    @foreach ($districts as $district)
                                       <option value="{{ $district->id }}">{{ $district->district_name }}
                                       </option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="form-group">
                                 <label>Edu Type Name</label>
                                 <select required class="form-control select2" name="edutype_id" id="editedutypeid"
                                    style="width: 100%;">
                                    <option  value="">Select Edu Type Name</option>
                                    @foreach ($edutype as $district)
                                       <option value="{{ $district->id }}">{{ $district->edutype_name }}
                                       </option>
                                    @endforeach
                                 </select>
                              </div>
											 <div class="form-group">
												<label for="college_name">College Name</label>
												<input type="text"  value="{{ $institutionlist->college_name }}" class="form-control"  name="college_name" id="editcollege_name" placeholder="">

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
							
										
<div class="modal fade" id="colleges">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add College Details</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{url('/addcolleges')}}" method="post">
            {{ csrf_field() }}
            <div class="modal-body">
                     
					 <div class="form-group">
						<label>District Name</label>
						<select required class="form-control select2" name="district_id" id="district_id"
							style="width: 100%;">
							<option value="">Select District Name</option>
							@foreach ($districts as $district)
								<option value="{{ $district->id }}">{{ $district->district_name }}
								</option>
							@endforeach
						</select>
					</div>
					 <div class="form-group">
						<label>Edu Type Name</label>
						<select required class="form-control select2" name="edutype_id" id="edutype_id"
							style="width: 100%;">
							<option value="">Select Edu Type Name</option>
							@foreach ($edutype as $district)
								<option value="{{ $district->id }}">{{ $district->edutype_name }}
								</option>
							@endforeach
						</select>
					</div>
				<div class="form-group">
                        <label for="college_name">College Name</label>
                        <input type="text" class="form-control"  name="college_name" id="college_name" placeholder="Enter College Name">
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
@push('page_scripts')
    <script>

        function edit_colleges(id, distid, edutypeid, college_name) {
            $("#row_id").val(id);
            $("#editdistrictid").select2().select2('val',distid);
		      $("#editedutypeid").select2().select2('val', edutypeid);
		      $("#editcollege_name").val(college_name);
            $("#editcolleges").modal("show");
        } 
      
    </script>
@endpush
