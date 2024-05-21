@extends('student.layouts.app')
@section('content')
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
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
                <div class="content-header">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title text-center">Practice Exam</h3>

                        </div>
                        <div class="card-body text-center">
                            <a href="{{ url('/practiceexam') }}" class="btn btn-success">Start Exam</a>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection

