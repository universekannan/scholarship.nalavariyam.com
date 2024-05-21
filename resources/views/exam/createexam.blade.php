@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="content-header">
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Exam Schedule</h3>
                        <button type="button" class="btn btn-sm btn-success float-right" data-toggle="modal"
                            data-target="#addexamschedule"><i class="fa fa-plus"> </i> Add Exam Schedule</button>
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
                                        <th>Exam Name</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Section</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($schedule as $key => $s)
                                        <tr>
                                            <td>{{ $s->title }}</td>
                                            <td>{{ date("d/m/Y",strtotime($s->from_date)) }}</td>
                                            <td>{{ date("d/m/Y",strtotime($s->to_date)) }}</td>
                                            <td>{{ $s->section_name }}</td>
                                            <td><a onclick="edit_schedule('{{ $s->id }}','{{ $s->title }}','{{ $s->from_date }}','{{ $s->to_date }}','{{ $s->section_id }}')"
                                                    href="#" class="btn btn-sm btn-primary"><i
                                                        class="fa fa-edit"></i>Edit</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <div class="modal fade" id="editexamschedule">
                                <form action="{{ url('/updateexamschedule') }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" id="id">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Exam Schedule</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Exam Name</label>
                                                    <div class="col-sm-8">
                                                        <input required="required" id="edittitle" name="title"
                                                        maxlength="50" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label"><span style="color:red">*</span>From Date</label>
                                                    <div class="col-sm-8">
                                                        <input min="{{ date('Y-m-d') }}" type="date" required="required" id="editfrom_date" name="from_date"
                                                        class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label"><span style="color:red">*</span>To Date</label>
                                                    <div class="col-sm-8">
                                                        <input min="{{ date('Y-m-d') }}" type="date" required="required" id="editto_date" name="to_date"
                                                        class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="section_id" class="col-sm-4 col-form-label"><span
                                                            style="color:red">*</span>Section Name</label>
                                                    <div class="col-sm-8">
                                                        <select required="required" name="section_id" id="editsection_id" class="form-control">
                                                            <option value="">Select</option>
                                                            @foreach ($section as $sec)
                                                                <option value="{{ $sec->id }}">
                                                                    {{ $sec->section_name }}</option>
                                                            @endforeach
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

                        <div class="modal fade" id="addexamschedule">
                            <form action="{{ url('/saveexamschedule') }}" method="post">
                                {{ csrf_field() }}
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Exam Schedule</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Exam Name</label>
                                                    <div class="col-sm-8">
                                                        <input required="required" id="title" name="title"
                                                        maxlength="50" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label"><span style="color:red">*</span>From Date</label>
                                                    <div class="col-sm-8">
                                                        <input min="{{ date('Y-m-d') }}" type="date" required="required" id="from_date" name="from_date"
                                                        class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label"><span style="color:red">*</span>To Date</label>
                                                    <div class="col-sm-8">
                                                        <input min="{{ date('Y-m-d') }}" type="date" required="required" id="to_date" name="to_date"
                                                        class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="section_id" class="col-sm-4 col-form-label"><span
                                                            style="color:red">*</span>Section Name</label>
                                                    <div class="col-sm-8">
                                                        <select required="required" name="section_id" id="section_id" class="form-control">
                                                            <option value="">Select</option>
                                                            @foreach ($section as $sec)
                                                                <option value="{{ $sec->id }}">
                                                                    {{ $sec->section_name }}</option>
                                                            @endforeach
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
            @endsection
            @push('page_scripts')
                <script>
                    function edit_schedule(id,title,from_date,to_date,section_id) {
                        $("#id").val(id);
                        $("#edittitle").val(title);
                        $("#editfrom_date").val(from_date);
                        $("#editto_date").val(to_date);
                        $("#editsection_id").val(section_id);
                        $("#editexamschedule").modal("show");
                    }
                </script>
            @endpush
