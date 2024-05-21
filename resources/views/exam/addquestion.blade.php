@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="content-header">
      </div>
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Questions</h3>
          <button type="button" class="btn btn-sm btn-secondary float-right" data-toggle="modal" data-target="#addquestion"><i class="fa fa-plus"> </i> Add Question</button>
        </div>
        <div class="card-body">
          @if(session()->has('success'))
          <div class="alert alert-success alert-dismissable" style="margin: 15px;">
            <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong> {{ session('success') }} </strong>
          </div>
          @endif
          <div class="table-responsive">
            <table id="example2" class="table table-bordered">
              <thead>
                <tr> 
                  <th>Question</th>
                  <th>Option A</th>
                  <th>Option B</th>
                  <th>Option C</th>
                  <th>Option D</th>
                  <th>Correct Answer</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody> 
                @foreach($questions as $q)
                <tr> 
                  <td>{{ $q->question }}</td>
                  <td>{{ $q->option_a }}</td>
                  <td>{{ $q->option_b }}</td>
                  <td>{{ $q->option_c }}</td>
                  <td>{{ $q->option_d }}</td>
                  <td>{{ $answers[$q->correct_option] }}</td>
                  <td>
                    <a onclick="edit_question('{{ $q->id }}','{{ $q->exam_id }}','{{ $q->question }}','{{ $q->option_a }}','{{ $q->option_b }}','{{ $q->option_c }}','{{ $q->option_d }}','{{ $q->correct_option }}')" href="#" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i>Edit</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <div class="modal fade" id="editquestionmodal">
  <form action="{{url('/updatequestion')}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="qid" id="qid" >
    <input type="hidden" name="exam_id" id="exam_id" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Question</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Question</label>
            <div class="col-sm-8">
             <textarea required="required" id="question" name="question" maxlength="200" class="form-control" ></textarea>
           </div>
         </div>
         <div class="form-group row">
          <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Option A</label>
          <div class="col-sm-8">
           <input required="required" id="option_a" name="option_a" maxlength="50" class="form-control" />
         </div>
       </div>
       <div class="form-group row">
        <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Option B</label>
        <div class="col-sm-8">
         <input required="required" id="option_b" name="option_b" maxlength="50" class="form-control" />
       </div>
     </div>
     <div class="form-group row">
      <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Option C</label>
      <div class="col-sm-8">
       <input required="required" id="option_c" name="option_c" maxlength="50" class="form-control" />
     </div>
   </div>
   <div class="form-group row">
    <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Option D</label>
    <div class="col-sm-8">
     <input required="required" id="option_d" name="option_d" maxlength="50" class="form-control" />
   </div>
 </div>
 <div class="form-group row">
   <label for="correct_option" class="col-sm-4 col-form-label"><span style="color:red">*</span>Correct Answer</label>
   <div class="col-sm-8">
    <select required="required" id="correct_option" name="correct_option" class="form-control" id="correct_option">
      <option value="">Select</option>
      <option value="option_a">Option A</option>
      <option value="option_b">Option B</option>
      <option value="option_c">Option C</option>
      <option value="option_d">Option D</option>
    </select>
  </div>
</div>
<div class="modal-footer justify-content-between">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  <input class="btn btn-primary" type="submit" value="Submit" />
</div>
</div>
</div>
</form>
</div>
          </div>
          <div class="modal fade" id="addquestion">
            <form action="{{url('/savequestion')}}" method="post">
              {{ csrf_field() }}
              <input type="hidden" name="exam_id" value="{{ $exam_id }}">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Add Question</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Question</label>
                      <div class="col-sm-8">
                       <textarea required="required" name="question" maxlength="200" class="form-control" ></textarea>
                     </div>
                   </div>
                   <div class="form-group row">
                    <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Option A</label>
                    <div class="col-sm-8">
                     <input required="required" name="option_a" maxlength="50" class="form-control" />
                   </div>
                 </div>
                 <div class="form-group row">
                  <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Option B</label>
                  <div class="col-sm-8">
                   <input required="required" name="option_b" maxlength="50" class="form-control" />
                 </div>
               </div>
               <div class="form-group row">
                <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Option C</label>
                <div class="col-sm-8">
                 <input required="required" name="option_c" maxlength="50" class="form-control" />
               </div>
             </div>
             <div class="form-group row">
              <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Option D</label>
              <div class="col-sm-8">
               <input required="required" name="option_d" maxlength="50" class="form-control" />
             </div>
           </div>
           <div class="form-group row">
             <label for="correct_option" class="col-sm-4 col-form-label"><span style="color:red">*</span>Correct Answer</label>
             <div class="col-sm-8">
              <select required="required" name="correct_option" class="form-control" id="correct_option">
                <option value="">Select</option>
                <option value="option_a">Option A</option>
                <option value="option_b">Option B</option>
                <option value="option_c">Option C</option>
                <option value="option_d">Option D</option>
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input class="btn btn-primary" type="submit" value="Submit" />
          </div>
        </div>
      </div>
    </div>
  </div>
  
</div>
</div>

@endsection
@push('page_scripts')
<script>
  function edit_question(qid,exam_id,question,option_a,option_b,option_c,option_d,correct_option){
    $("#qid").val(qid);
    $("#exam_id").val(exam_id);
    $("#question").val(question);
    $("#option_a").val(option_a);
    $("#option_b").val(option_b);
    $("#option_c").val(option_c);
    $("#option_d").val(option_d);
    $("#correct_option").val(correct_option);
    $("#editquestionmodal").modal("show");
  }
</script>
@endpush