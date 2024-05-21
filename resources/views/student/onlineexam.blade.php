@extends('student.layouts.app')
@section('content')
<div class="container-fluid">
    <form action="" method="post">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
                <div class="content-header">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title text-center">Online Exam <span id="timer"></span></h3>
                        </div>
                        <div class="card-body" id="question_div" style="display:none">
                            @if(count($question)>0)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="question">
                                            <p>{{ $answered + 1 }}. {{ $question[0]->question }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="option_a" class="control-label">
                                                <input disabled name="answer" onclick="saveanswer({{ $question[0]->question_id }},'option_a')" type="radio" id="option_a">
                                                {{ $question[0]->option_a }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="option_b" class="control-label">
                                                <input disabled name="answer" onclick="saveanswer({{ $question[0]->question_id }},'option_b')" type="radio" id="option_b">
                                                {{ $question[0]->option_b }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="option_c" class="control-label">
                                                <input disabled name="answer" onclick="saveanswer({{ $question[0]->question_id }},'option_c')" type="radio" id="option_c">
                                                {{ $question[0]->option_c }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="option_d" class="control-label">
                                                <input disabled name="answer" onclick="saveanswer({{ $question[0]->question_id }},'option_d')" type="radio" id="option_d">
                                                {{ $question[0]->option_d }}
                                            </label>
                                        </div>
                                    </div>
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
                window.location.href = "{{ url('/examresult') }}"; 
            } else {
                currentTime--;
            }
        }

        startTimer();

        function saveanswer(ques,ans){
            $("#question_div").html("");
            $("#option_a").prop("disabled",true);
            $("#option_b").prop("disabled",true);
            $("#option_c").prop("disabled",true);
            $("#option_d").prop("disabled",true);
            var saveanswer = "{{ url('/saveanswer') }}";
            saveanswer = saveanswer + "/" + ques + "/" +ans + "/" + sid;
            window.location.href = saveanswer;
        }

        $(document).ready(function(){
            $("#option_a").prop("disabled",false);
            $("#option_b").prop("disabled",false);
            $("#option_c").prop("disabled",false);
            $("#option_d").prop("disabled",false);
            $("#question_div").css("display", "block"); 
        });

    </script>
    @endpush
