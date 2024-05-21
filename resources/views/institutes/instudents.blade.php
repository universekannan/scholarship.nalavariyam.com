@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Activate Students</h1>
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
                        <div class="col-sm-12">
                            
                            <div class="table-responsive" style="overflow-x: auto; ">
                                <table id="example22" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkall" /></th>
                                            <th>#</th>
                                            <th>Id</th>
                                            <th>District</th>
                                            <th>Full Name</th>
                                            <th>Mobile Number</th>
                                            <th>Medium</th>
                                            <th>Section</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $key => $studentslist)
                                        <tr>
                                            <td><input type="checkbox" class="actchk" value="{{ $studentslist->id }}" /></td>
                                            <td>{{ $key + 1 }}</td>
                                            <td>N{{ $studentslist->id }}</td>
                                            <td>{{ $studentslist->district_name }}</td>
                                            <td>{{ $studentslist->student_name }}</td>
                                            <td>{{ $studentslist->cell_number }}</td>
                                            <td>{{ $studentslist->medium_name }}</td>
                                            <td>{{ $studentslist->section_name }}</td>

                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="8" align="center">
                                                <a type="button" onclick="pay_now()" class="btn btn-primary btn-sm">Pay Now</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <div class="modal fade" id="statusupdate">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="studname"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/institutestudentsactivate') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="studentid" id="studentid">
                        <input type="hidden" name="ins_id" id="ins_id" value="{{ $ins_id }}">
                        <div class="form-group" >
                            <label for="student_name">No of Students</label>
                            <input readonly type="text" class="form-control" name="noofstudent" id="noofstudent">
                        </div>
                        <div class="form-group" >
                            <label for="student_name">Amount Payable</label>
                            <input readonly type="text" class="form-control" name="payamount" id="payamount">
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
    @push('page_scripts')
    <script>
        
        $(document).ready(function(){
            $("#checkall").change(function() {
                var check = false;
                if($(this).prop('checked')) {
                    var check = true;
                }
                $('input:checkbox.actchk').each(function () {
                    this.checked = check;
                });
            });
        });

        function pay_now(){
            var amount = 0;
            var noofstudent = 0;
            $("#studentid").val("");
            $('input:checkbox.actchk').each(function () {
                if(this.checked){
                    if(amount == 0)
                        $("#studentid").val($(this).val());
                    else
                        $("#studentid").val($("#studentid").val()+","+$(this).val());
                    amount = amount + 50;
                    noofstudent = noofstudent + 1;
                }
            });
            $("#payamount").val(amount);
            if(amount == 0){
                alert("Please select a student");
            }else{
                $("#noofstudent").val(noofstudent);
                $("#statusupdate").modal("show");
            }
        }
    </script>
    @endpush
