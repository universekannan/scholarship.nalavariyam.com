@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Assigned College List</h1>
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
                            <th> District</th>
                            <th> Edu Type</th>
                            <th> Department</th>
                            <th> View College</th>
                         </tr>
                      </thead>
                      <tbody>
                        @foreach($edustudents as $key => $edustudentslist)
                        <tr>
                           <td>{{ $key + 1 }}</td>
                           <td>{{ $edustudentslist->student_name }}</td>
                           <td>{{ $edustudentslist->district_name }}</td>
                           <td>{{ $edustudentslist->edutype_name }}</td>
                           <td>{{ $edustudentslist->department_name }}</td>
                           <td>
                            @php $college = json_encode($edustudentslist->colleges)  @endphp
                           <a onclick = "viewcollege('{{ $college }}','{{ $key }}')" class="btn btn-info btn-sm"> View College</a>
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
            <h4 class="modal-title">College</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
            <div class="modal-body">
                 <table id="example2" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                            <th> S NO</th>
                            <th> College Name</th>
                         </tr>
                      </thead>
                      <tbody id="tabbody">
                       
                  </tbody>
               </table>        
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
      </div>
   </div>
</div>
@endsection
@push('page_scripts')
<script>
       function viewcollege(college,key){
        $("#tabbody").html('');
        var obj = JSON.parse(college);
        $("#edustudents").modal("show");
         $.each(obj, function(key, value) {
            var key = key + 1;
            $("#tabbody").append('<tr><td> '+ key +'</td><td> '+ value.college_name +'</td></tr>');
         });  
       }

</script>
@endpush