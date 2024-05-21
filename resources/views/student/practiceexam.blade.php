@extends('student.layouts.app')
@section('content')
<div class="container-fluid">
    <form action="" method="post">
        {{ csrf_field() }}
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
                            <h3 class="card-title text-center">Practice Exam <span id="timer"></span></h3>
                            
                        </div>
                        <div class="card-body" id="question_div" style="display:none">
                            @if(count($question)>0)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="question">
                                            @if($correct_ans == "")
                                            <p>{{ $answered + 1 }}. {{ $question[0]->question }}</p>
                                            @else
                                            <p>{{ $answered }}. {{ $question[0]->question }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 @if($correct_ans=='option_a') bg-success @endif">
                                        <div class="form-group">
                                            <label for="option_a" class="control-label">
                                                <input disabled name="answer" onclick="saveanswer({{ $question[0]->question_id }},'option_a')" type="radio" id="option_a">
                                                {{ $question[0]->option_a }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 @if($correct_ans=='option_b') bg-success @endif">
                                        <div class="form-group">
                                            <label for="option_b" class="control-label">
                                                <input disabled name="answer" onclick="saveanswer({{ $question[0]->question_id }},'option_b')" type="radio" id="option_b">
                                                {{ $question[0]->option_b }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 @if($correct_ans=='option_c') bg-success @endif">
                                        <div class="form-group">
                                            <label for="option_c" class="control-label">
                                                <input disabled name="answer" onclick="saveanswer({{ $question[0]->question_id }},'option_c')" type="radio" id="option_c">
                                                {{ $question[0]->option_c }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 @if($correct_ans=='option_d') bg-success @endif">
                                        <div class="form-group">
                                            <label for="option_d" class="control-label">
                                                <input disabled name="answer" onclick="saveanswer({{ $question[0]->question_id }},'option_d')" type="radio" id="option_d">
                                                {{ $question[0]->option_d }}
                                            </label>
                                        </div>
                                    </div>
                                    @if($correct_ans != "")
                                    <div class="col-md-12 mt-1">
                                        <div class="form-group">
                                            <a class="btn btn-info" href="#" onclick="nextanswer()">Next</a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @endsection
    @push('page_scripts')
    <script>
        let totalMinutes = {{ $total_minutes }};
        let totalSeconds = {{ $total_seconds }};
        let answered = {{ $answered }};
        let totalTime = totalMinutes * 60 + totalSeconds;
        let currentTime = totalTime;
        var currentQuestion = 1;
        var sid = "{{ Session::get('id') }}";

        function startTimer() {
            setInterval(updateTimer, 1000);
        }

        function updateTimer() {
            const minutes = Math.floor(currentTime / 60);
            const seconds = currentTime % 60;
            document.getElementById('timer').innerText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            if (currentTime === 0) {
                window.location.href = "{{ url('/allpracticeresult') }}"; 
            } else {
                currentTime--;
            }
        }

        startTimer();

        function nextanswer(){
            var practiceexam = "{{ url('/practiceexam') }}";
            window.location.href = practiceexam;
        }

        function saveanswer(ques,ans){
            $("#question_div").html("");
            $("#option_a").prop("disabled",true);
            $("#option_b").prop("disabled",true);
            $("#option_c").prop("disabled",true);
            $("#option_d").prop("disabled",true);
            var saveanswer = "{{ url('/practiceanswer') }}";
            saveanswer = saveanswer + "/" + ques + "/" +ans + "/" + sid;
            window.location.href = saveanswer;
        }

        $(document).ready(function(){
            @if($correct_ans == "")
                $("#option_a").prop("disabled",false);
                $("#option_b").prop("disabled",false);
                $("#option_c").prop("disabled",false);
                $("#option_d").prop("disabled",false);
            @endif
            $("#question_div").css("display", "block"); 
        });

    </script>
    @endpush
