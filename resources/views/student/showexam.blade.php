@extends('student.layouts.app')
@section('content')
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="content-header">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title text-center">Online Exam</h3>
                        </div>
                        <div class="card-body text-center">
                            @unless($examover)
                            <a href="{{ url('/onlineexam') }}" class="btn btn-success">Start Exam</a>
                            @endunless
                        </div> 
                        @if(count($completed)>0)
                        <h3 class="card-title">Exam Result</h3>
                        @foreach($completed as $comp)
                        <div class="row">
                            <div class="col-md-12">{{ $comp->title }}</div> 
                        </div>             
                        <div class="row">
                            <div class="col-md-6">Total Questions</div>
                            <div class="col-md-6">{{ $comp->total }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">Answered</div>
                            <div class="col-md-6">{{ $comp->answered }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">Correct</div>
                            <div class="col-md-6">{{ $comp->correct }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">Wrong</div>
                            <div class="col-md-6">{{ $comp->wrong }}</div>
                        </div>
                        @endforeach
                        @endif
                        <div class="row">
                            <div class="col-md-12">&nbsp;</div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection

