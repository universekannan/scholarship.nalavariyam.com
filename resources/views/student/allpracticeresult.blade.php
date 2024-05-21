@extends('student.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="content-header">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-center">Practice Exam Result</h3>
                    </div>
                    <div class="card-body">
                        @foreach($exams as $exam)
                        <div class="row">
                            <div class="col-md-4 bg-success">Exam Time</div>
                            <div class="col-md-8 bg-success">{{ date("d-m-Y h:i:s A",strtotime($exam->start_time)) }} - {{ date("d-m-Y h:i:s A",strtotime($exam->end_time)) }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Total Questions</div>
                            <div class="col-md-8">100</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Answered Questions</div>
                            <div class="col-md-8">{{ $exam->answered }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Correct Answers</div>
                            <div class="col-md-8">{{ $exam->correct }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Wrong Answers</div>
                            <div class="col-md-8">{{ $exam->wrong }}</div>
                        </div>
                        <div class="row"><div class="col-md-12">&nbsp;</div></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

