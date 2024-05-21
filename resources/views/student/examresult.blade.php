@extends('student.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="content-header">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-center">Online Exam Result</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">Total Questions</div>
                            <div class="col-md-6">100</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">Answered Questions</div>
                            <div class="col-md-6">{{ $answered }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">Correct Answers</div>
                            <div class="col-md-6">{{ $correct }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">Wrong Answers</div>
                            <div class="col-md-6">{{ $wrong }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

