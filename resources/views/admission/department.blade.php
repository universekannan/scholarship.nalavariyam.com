@extends('layouts.app')
@section('content')
<style>
   input[type=checkbox] {
    transform: scale(1.5);
}
</style>
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Departments</h1>
         </div>
         <div class="col-sm-6">
            @if((Auth::user()->user_type_id == 1))
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#department"><i class="fa fa-plus"> Assign Department </i></button></li>
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
						        <th> Department</th>
						        <th> Status</th>
                         
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($department as $departmentlist)
                        <tr>
                           <td>{{ $departmentlist->id }}</td>
                           <td>{{ $departmentlist->department_name }}</td>
                           <td>{{ $departmentlist->status }}</td>
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
<div class="modal fade" id="department">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Assign Department</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>

            <div class="modal-body">
			 <form action="{{url('/assigndepartment')}}" method="post">
               {{ csrf_field() }}
              <input type="hidden" value="{{ $id }}" name="ins_id">          
				 <table id="example7" class="table table-bordered table-striped">
                     <thead>
                        <tr>
								<th> S No	</th>
						      <th> Department	</th>
								<th> Action	</th>
                         
                        </tr>
                     </thead>
                     <tbody>
					
                        @foreach($assigndepartment as $departmentlist)
                        <tr>
                           <td>{{ $departmentlist->id }}</td>
                           <td>{{ $departmentlist->department_name }}</td>
                           <td><input class="form-inline" style="font-size:15px;" type="checkbox" @if($departmentlist->id == $departmentlist->department_id) checked @endif value="{{ $departmentlist->id }}" name="dep[]"> </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>				
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