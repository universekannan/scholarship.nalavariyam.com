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

                                <h3 class="card-title text-center">Practice Exam</h3>
                            </div>
                            <div class="card-body" id="contetnt_div">
                                @if (isset($questions))
                                    @foreach ($questions as $i => $row)
                                        <div class="row qpad" id="question-{{ $i }}"
                                            @if ($i != 0) style="display:none" @endif>
                                            <div class="col-md-12">
                                                <div class="question">
                                                    <p>{{ $i + 1 }}. {{ $row->question }}</p>
                                                </div>
                                            </div>

                                            <div class="col-md-12 @if ($row->correct_option == 'option_a') correctanswer @endif ">
                                                <div class="form-group">
                                                    <label for="{{ $i }}-option_a-{{ $row->id }}"
                                                        class="control-label required">
                                                        <input type="radio"
                                                            id="{{ $i }}-option_a-{{ $row->id }}"
                                                            data-correct="{{ $row->correct_option }}"
                                                            name="myanswer{{ $i }}" value="option_a">
                                                        {{ $row->option_a }}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-12 @if ($row->correct_option == 'option_b') correctanswer @endif ">
                                                <div class="form-group">
                                                    <label for="{{ $i }}-option_b-{{ $row->id }}"
                                                        class="control-label required">
                                                        <input type="radio"
                                                            id="{{ $i }}-option_b-{{ $row->id }}"
                                                            data-correct="{{ $row->correct_option }}"
                                                            name="myanswer{{ $i }}" value="option_b">
                                                        {{ $row->option_b }}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-12 @if ($row->correct_option == 'option_c') correctanswer @endif ">
                                                <div class="form-group">
                                                    <label for="{{ $i }}-option_c-{{ $row->id }}"
                                                        class="control-label required">
                                                        <input type="radio"
                                                            id="{{ $i }}-option_c-{{ $row->id }}"
                                                            data-correct="{{ $row->correct_option }}"
                                                            name="myanswer{{ $i }}" value="option_c">
                                                        {{ $row->option_c }}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-12 @if ($row->correct_option == 'option_d') correctanswer @endif ">
                                                <div class="form-group">
                                                    <label for="{{ $i }}-option_d-{{ $row->id }}"
                                                        class="control-label required">
                                                        <input type="radio"
                                                            id="{{ $i }}-option_d-{{ $row->id }}"
                                                            data-correct="{{ $row->correct_option }}"
                                                            name="myanswer{{ $i }}" value="option_d">
                                                        {{ $row->option_d }}
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                    <div class="clearfix"></div>
                                    <div style="padding: 10px 20px;" class="row">
                                        <div class="col-md-6">
                                            <a class="btn btn-info gotoprev" href="#">Previous</a>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <a class="btn btn-info gotonext pull-right" href="#">Next</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
        </form>
    </div>
@endsection
@push('page_scripts')
    <script>
        $(document).ready(function() {
            let score = 0;
            let correct = 0;
            let incorrect = 0;

            $('.qpad').each(function(index) {
                if (index != 0) {
                    $(this).hide();
                }
            });
        });

        $('.gotoprev').on('click', function() {
            let pageid = $('.qpad:visible').attr('id');
            let arr = pageid.split('-');
            if (typeof $('#question-' + arr[1]).prev().attr('id') == 'undefined') {} else {
                $('#question-' + arr[1]).hide();
                $('#question-' + arr[1]).prev().show();
            }
            $(".correctanswer").css('background-color', 'white');
        });

        function go_next() {
            let pageid = $('.qpad:visible').attr('id');
            let arr = pageid.split('-');
            if (typeof $('#question-' + arr[1]).next().attr('id') == 'undefined') {} else {
                $('#question-' + arr[1]).hide();
                $('#question-' + arr[1]).next().show();
            }
            $(".correctanswer").css('background-color', 'white');
        }

        $('.gotonext').on('click', function() {
            go_next();
        });

        $("#exam_idtop").on('change', function() {
            $("#contetnt_div").html("");
        });

        function show_questions() {
            var url = "{{ url('showquestions') }}";
            exam_id = $("#exam_idtop").val();
            if (exam_id == "") {
                alert("Select Exam");
                $("#exam_idtop").focus();
            } else {
                url = url + "/" + exam_id;
                window.location.href = url;
            }
        }

        $("input").on("click", function() {
            let isCorrect = false;
            if ($(this).prop('checked', true)) {
                let myanswer = $(this).val();
                let actanswer = $(this).attr('data-correct');
                let page = $(this).attr('id');
                let pageid = page.split('-');
                let qid = pageid[2];
                if (myanswer == actanswer) {
                    isCorrect = true;
                }
            }
            if (isCorrect) {
                $(".correctanswer").css('background-color', 'green');
                go_next();
            } else {
                $(".correctanswer").css('background-color', 'green');
            }
        });

        function checkAnswer() {
            choiceClicked = true;
            $("#choiceSubmit").removeAttr("disabled");
            $("#test label").css("background-color", "transparent");
            if ($("#test input:checked").val() == questions[pos][4]) {
                // correct question clicked
                $("#test input:checked+label").css("background-color", "green");
                correct++;
            } else {
                // wrong question clicked
                $("#test input:checked+label").css("background-color", "red");
            }
        }
    </script>
@endpush
