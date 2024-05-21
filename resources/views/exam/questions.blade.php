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
                        <button type="button" class="btn btn-sm btn-success float-right" data-toggle="modal"
                            data-target="#addquestion"><i class="fa fa-plus"> </i> Add Question</button>
                        <button type="button" class="btn btn-sm btn-success float-right" data-toggle="modal"
                            data-target="#copyquestion"><i class="fa fa-copy"> </i> Copy Questions</button>    
                    </div>
                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissable" style="margin: 15px;">
                                <a href="#" style="color:white !important" class="close" data-dismiss="alert"
                                    aria-label="close">&times;</a>
                                <strong> {{ session('success') }} </strong>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Question</th>
                                        <th>Correct</th>
                                        <th>Subject</th>
                                        <th>Section</th>
                                        <th>Medium</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questions as $q)
                                        <tr>
                                            <td>{{ $q->id }}</td>
                                            <td>{{ $q->question }}</td>
                                            <td>{{ $option[$q->correct_option] }}</td>
                                            <td>{{ $q->subject_name }}</td>
                                            <td>{{ $q->section_name }}</td>
                                            <td>{{ $q->medium_name }}</td>
                                            <td>
                <a onclick="edit_question('{{ $q->id }}','{{ $q->section_id }}','{{ $q->medium_of_study }}','{{ $q->subject_id }}','{{ $q->question }}','{{ $q->option_a }}','{{ $q->option_b }}','{{ $q->option_c }}','{{ $q->option_d }}','{{ $q->correct_option }}')"
                                                    href="#" class="btn btn-sm btn-primary"><i
                                                        class="fa fa-edit"></i>Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="modal fade" id="editquestionmodal">
                                <form action="{{ url('/updatequestion') }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" id="qid">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Question</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label for="section_id" class="col-sm-4 col-form-label"><span
                                                            style="color:red">*</span>Section Name</label>
                                                    <div class="col-sm-8">
                                                        <select required="required" id="editsection" name="section_id"
                                                            class="form-control">
                                                            <option value="">Select</option>
                                                            @foreach ($section as $sectionlist)
                                                                <option value="{{ $sectionlist->id }}">
                                                                    {{ $sectionlist->section_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="medium_of_study" class="col-sm-4 col-form-label"><span
                                                            style="color:red">*</span>Medium</label>
                                                    <div class="col-sm-8">
                                                        <select required="required" id="editmedium" name="medium_of_study"
                                                            class="form-control">
                                                            <option value="">Select</option>
                                                            @foreach ($medium as $med)
                                                            <option value="{{ $med->id }}">
                                                                {{ $med->medium_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="subject_id" class="col-sm-4 col-form-label"><span
                                                            style="color:red">*</span>Subject</label>
                                                    <div class="col-sm-8">
                                                        <select required="required" name="subject_id" id="editsubject" class="form-control">
                                                            <option value="">Select</option>
                                                            @foreach ($subject as $sub)
                                                                <option value="{{ $sub->id }}">
                                                                    {{ $sub->subject_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label"><span
                                                            style="color:red">*</span>Question</label>
                                                    <div class="col-sm-8">
                                                        <textarea required="required" id="question" name="question" maxlength="3000" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label"><span
                                                            style="color:red">*</span>Option A</label>
                                                    <div class="col-sm-8">
                                                        <input required="required" id="option_a" name="option_a"
                                                        maxlength="3000" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label"><span
                                                            style="color:red">*</span>Option B</label>
                                                    <div class="col-sm-8">
                                                        <input required="required" id="option_b" name="option_b"
                                                        maxlength="3000" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label"><span
                                                            style="color:red">*</span>Option C</label>
                                                    <div class="col-sm-8">
                                                        <input required="required" id="option_c" name="option_c"
                                                        maxlength="3000" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label"><span
                                                            style="color:red">*</span>Option D</label>
                                                    <div class="col-sm-8">
                                                        <input required="required" id="option_d" name="option_d"
                                                        maxlength="3000" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="correct_option" class="col-sm-4 col-form-label"><span
                                                            style="color:red">*</span>Correct Answer</label>
                                                    <div class="col-sm-8">
                                                        <select required="required" id="correct_option"
                                                            name="correct_option" class="form-control"
                                                            id="correct_option">
                                                            <option value="">Select</option>
                                                            <option value="option_a">Option A</option>
                                                            <option value="option_b">Option B</option>
                                                            <option value="option_c">Option C</option>
                                                            <option value="option_d">Option D</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                    <input class="btn btn-primary" type="submit" value="Submit" />
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal fade" id="addquestion">
                            <form action="{{ url('/savequestion') }}" method="post">
                                {{ csrf_field() }}
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Question</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="section_id" class="col-sm-4 col-form-label"><span
                                                        style="color:red">*</span>Section Name</label>
                                                <div class="col-sm-8">
                                                    <select required="required" name="section_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach ($section as $sectionlist)
                                                            <option value="{{ $sectionlist->id }}">
                                                                {{ $sectionlist->section_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="medium_of_study" class="col-sm-4 col-form-label"><span
                                                        style="color:red">*</span>Medium</label>
                                                <div class="col-sm-8">
                                                    <select required="required" name="medium_of_study"
                                                        class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach ($medium as $med)
                                                            <option value="{{ $med->id }}">
                                                                {{ $med->medium_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="subject_id" class="col-sm-4 col-form-label"><span
                                                        style="color:red">*</span>Subject</label>
                                                <div class="col-sm-8">
                                                    <select required="required" name="subject_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach ($subject as $sub)
                                                            <option value="{{ $sub->id }}">
                                                                {{ $sub->subject_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label"><span
                                                        style="color:red">*</span>Question</label>
                                                <div class="col-sm-8">
                                                    <textarea required="required" name="question" maxlength="3000" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label"><span
                                                        style="color:red">*</span>Option A</label>
                                                <div class="col-sm-8">
                                                    <input required="required" name="option_a" maxlength="3000"
                                                        class="form-control" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label"><span
                                                        style="color:red">*</span>Option B</label>
                                                <div class="col-sm-8">
                                                    <input required="required" name="option_b" maxlength="3000"
                                                        class="form-control" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label"><span
                                                        style="color:red">*</span>Option C</label>
                                                <div class="col-sm-8">
                                                    <input required="required" name="option_c" maxlength="3000"
                                                        class="form-control" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label"><span
                                                        style="color:red">*</span>Option D</label>
                                                <div class="col-sm-8">
                                                    <input required="required" name="option_d" maxlength="3000"
                                                        class="form-control" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="correct_option" class="col-sm-4 col-form-label"><span
                                                        style="color:red">*</span>Correct Answer</label>
                                                <div class="col-sm-8">
                                                    <select required="required" name="correct_option"
                                                        class="form-control" id="correct_option">
                                                        <option value="">Select</option>
                                                        <option value="option_a">Option A</option>
                                                        <option value="option_b">Option B</option>
                                                        <option value="option_c">Option C</option>
                                                        <option value="option_d">Option D</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <input class="btn btn-primary" type="submit" value="Submit" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>



                    </div>
                </div>

                <div class="modal fade" id="copyquestion">
    <form onsubmit="return validatecopy(event)" action="{{ url('/copyquestion') }}" method="post">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Copy Question</h4>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>From Section</label>
                                <select required="required" id="from_section" name="from_section" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($from_section as $sectionlist)
                                        <option value="{{ $sectionlist->id }}">
                                            {{ $sectionlist->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>From Medium</label>
                                <select required="required" id="from_medium" name="from_medium"
                                        class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($medium as $med)
                                        <option value="{{ $med->id }}">
                                            {{ $med->medium_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Subject</label>
                                <select required="required" name="from_subject" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($from_subject as $sub)
                                        <option value="{{ $sub->id }}">
                                            {{ $sub->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>To Section</label>
                            <select required="required" id="to_section" name="to_section" class="form-control">
                              <option value="">Select</option>
                                @foreach ($from_section as $sectionlist)
                                    <option value="{{ $sectionlist->id }}">
                                        {{ $sectionlist->section_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>To Medium</label>
                            <select required="required" id="to_medium" name="to_medium"
                                    class="form-control">
                                <option value="">Select</option>    
                                @foreach ($medium as $med)
                                    <option value="{{ $med->id }}">
                                        {{ $med->medium_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default"
                        data-dismiss="modal">Close</button>
                    <input class="btn btn-primary" type="submit" value="Copy" />
                </div>
                </div>
            </div>
        </div>
    </form>
</div>
            @endsection
            @push('page_scripts')
                <script>
                    function edit_question(qid, section_id, medium_of_study, subject_id, question, option_a, option_b, option_c, option_d,
                        correct_option) {
                        $("#qid").val(qid);
                        $("#editsection").val(section_id);
                        $("#editmedium").val(medium_of_study);
                        $("#editsubject").val(subject_id);
                        $("#question").val(question);
                        $("#option_a").val(option_a);
                        $("#option_b").val(option_b);
                        $("#option_c").val(option_c);
                        $("#option_d").val(option_d);
                        $("#correct_option").val(correct_option);
                        $("#editquestionmodal").modal("show");
                    }


                    function validatecopy(e){
                        var from_section = $("#from_section").val();
                        var to_section = $("#to_section").val();
                        var from_medium = $("#from_medium").val();
                        var to_medium = $("#to_medium").val();
                        if(from_section == to_section && from_medium == to_medium){
                            alert("Please Change To Section or To Medium");
                            return false;
                        }
                        if(!confirm("Are you sure")){
                            return false;
                        }
                    } 

                    $("#to_section > option").each(function(){
                       if(this.value != ""){
                        $("#to_section option[value=" + this.value + "]").hide();
                       }
                    }); 

                    $('#from_section').on('change',function(){
                       var from_section = this.value;
                       $("#to_section").val("");
                       $("#to_section > option").each(function(){
                          if(this.value != ""){
                           $("#to_section option[value=" + this.value + "]").hide();
                          }
                       }); 
                       if(from_section != ""){
                          if(from_section >=1 && from_section <=5){
                            $("#to_section option[value=" + from_section + "]").show();
                            $("#to_section option[value=" + "101" + "]").show();
                            $("#to_section option[value=" + "102" + "]").show();
                          }
                          if((from_section >=6 && from_section <=11) || from_section == 18) {
                            $("#to_section option[value=" + from_section + "]").show();
                            $("#to_section option[value=" + "6" + "]").show();
                            $("#to_section option[value=" + "7" + "]").show();
                            $("#to_section option[value=" + "8" + "]").show();
                            $("#to_section option[value=" + "9" + "]").show();
                            $("#to_section option[value=" + "10" + "]").show();
                            $("#to_section option[value=" + "11" + "]").show();
                            $("#to_section option[value=" + "18" + "]").show();
                            $("#to_section option[value=" + "102" + "]").show();
                          }
                          if((from_section >=12 && from_section <=17) || from_section ==19){
                            $("#to_section option[value=" + from_section + "]").show();
                            $("#to_section option[value=" + "12" + "]").show();
                            $("#to_section option[value=" + "13" + "]").show();
                            $("#to_section option[value=" + "14" + "]").show();
                            $("#to_section option[value=" + "15" + "]").show();
                            $("#to_section option[value=" + "16" + "]").show();
                            $("#to_section option[value=" + "17" + "]").show();
                            $("#to_section option[value=" + "19" + "]").show();
                            $("#to_section option[value=" + "102" + "]").show();
                          }
                          if(from_section >=101 && from_section <=102){
                            $("#to_section option[value=" + "101" + "]").show();
                            $("#to_section option[value=" + "102" + "]").show();
                          }
                          $("#to_section option[value=" + "103" + "]").show(); 
                       }
                      
                    });

                    /*$('#from_medium').on('change',function(){
                       var from_medium = this.value;
                       $("#to_medium > option").each(function(){
                           $("#to_medium option[value=" + this.value + "]").show();
                       });            
                       $("#to_medium option[value=" + from_medium + "]").hide();
                    });*/
                </script>
            @endpush
