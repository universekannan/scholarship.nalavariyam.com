@extends('student.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="content-header">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-center">Certificate</h3>
                    </div>
                    <div class="card-body">
                        
                        <table id="example13" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Student Name</th>
                                    <th>Username</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                 @foreach($top as $key => $e)
                    <tr> 
                    <td>{{ $key+1 }}</td>
                    <td>{{ ucwords($e->student_name) }}</td>
                    <td>{{ ucwords($e->username) }}</td>
                    <td>{{ round($e->corr/100,2)*100 }} %</td>
                    </tr>
                 @endforeach
                            </tbody>
                            </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

