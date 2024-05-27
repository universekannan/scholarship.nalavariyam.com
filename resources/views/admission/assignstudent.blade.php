@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Assign Student</h1>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form onsubmit="return validate_all(event);" action="{{ url('admission/saveassigncollege') }}" method="post"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $studentid }}" name="studentid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="student_name">District Name</label>
                                     <select required class="form-control select2" name="dist_id" id="dist_id"
                                                style="width: 100%;">
                                                <option value="">Select District Name</option>
                                                @foreach ($managedistrict as $district)
                                                    <option value="{{ $district->id }}">{{ $district->district_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                </div>
                                <div class="form-group">
                                    <label for="student_name">Education Type</label>
                                     <select required class="form-control select2" name="edutype_id" id="edutype_id"
                                                style="width: 100%;">
                                    <option value="">Select District Name</option>
                                    @foreach ($edutype as $edu)
                                        <option value="{{ $edu->id }}">{{ $edu->edutype_name }}
                                        </option>
                                    @endforeach
                                 </select>
                                </div>

                             <div class="form-group">
                                <label>Department Name</label>
                                <select required class="form-control select2" name="department_id" id="department_id"
                                    style="width: 100%;">
                                    <option value="">Select Department Name</option>
                                     @foreach ($department as $dep)
                                        <option value="{{ $dep->id }}">{{ $dep->department_name }}
                                        </option>
                                    @endforeach
                                   
                                </select>
                                    </div>

                                     <div class="form-group">
                                <label>College Name</label>
                                <select required class="form-control select2" multiple="multiple"
                           data-placeholder="Select a College"  name="college_id[]" id="college_id"
                                    style="width: 100%;">
                                    <option value="">Select Department</option>
                                   
                                </select>
                                    </div>
                        

                    </div>
</div>
<div class="form-group row">
    <div class="col-md-12 text-center">
        <a href="" class="btn btn-info">Back</a>
        <input id="save" class="btn btn-info" type="submit" name="submit"
        value="Submit" />
    </div>
</div>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</section>
@endsection
@push('page_scripts')
<script>

    $('#edutype_id').on('change', function() {
            var edutype_id = this.value;
            $("#department_id").html('');
            var url = "{{ url('/getdepartment') }}/" + edutype_id;
            $.ajax({
                url: url,
                type: "GET",
                success: function(result) {
                    $.each(result, function(key, value) {
                        $("#department_id").append('<option value="' + value.id + '">' + value.department_name + '</option>');
                    });
                }
            });
        });

       
        $('#department_id').on('change', function() {
            var department_id = this.value;
            var district_id = $('#dist_id').val();
            var edutype_id = $('#edutype_id').val();
            $("#college_id").html('');
            var url = "{{ url('/getcolleges') }}/" + district_id +"/" + edutype_id +"/" + department_id;
            $.ajax({
                url: url,
                type: "GET",
                success: function(result) {
                    $.each(result, function(key, value) {
                          $.each(value.colleges, function(key, value) {
                        $("#college_id").append('<option value="' + value.id + '">' + value.college_name + '</option>');
                    });
                    });
                }
            });
        });

</script>
@endpush
