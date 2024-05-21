@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="content-header">
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Question Summary</h3>
                        
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
                                        <th>S.No</th>
                                        <th>Section</th>
                                        <th>Medium</th>
                                        <th>Subject</th>
                                        <th>Questions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questions as $key => $q)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $section[$q->section_id] }}</td>
                                            <td>{{ $medium[$q->medium_of_study] }}</td>
                                            <td>{{ $subject[$q->subject_id] }}</td>
                                            <td>{{ $q->ques }}</td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                        



                    </div>
                </div>

                
            @endsection
           