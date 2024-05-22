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
                            <div class="col-md-6">{{ $total }}</div>
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
                        <hr>
                        @foreach ($wrong_answers as $k => $w)
                        <div class="row">
                            <div class="col-md-12">
                                <p>{{ $k + 1 }}. {{ $w->question }}</p>
                            </div>
                            <div class="col-md-12">
                                <p @if($w->correct_option=="option_a") class="text-success" @endif @if($w->answered_option=="option_a") class="text-danger" @endif >{{ $w->option_a }}</p>
                            </div>
                            <div class="col-md-12">
                                <p @if($w->correct_option=="option_b") class="text-success" @endif @if($w->answered_option=="option_b") class="text-danger" @endif >{{ $w->option_b }}</p>
                            </div>
                            <div class="col-md-12">
                                <p @if($w->correct_option=="option_c") class="text-success" @endif @if($w->answered_option=="option_c") class="text-danger" @endif >{{ $w->option_c }}</p>
                            </div>
                            <div class="col-md-12">
                                <p @if($w->correct_option=="option_d") class="text-success" @endif @if($w->answered_option=="option_d") class="text-danger" @endif >{{ $w->option_d }}</p>
                            </div>
                            <div class="col-md-12">
                                <hr/>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

