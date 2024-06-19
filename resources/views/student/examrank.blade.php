@extends('student.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="content-header">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-center">Online Exam Rank</h3>
                    </div>
                    <div class="card-body">
                        
                        <table id="example13" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Prize Money</th>
                                    <th>Username</th>
                                    <th>Percentage</th>
                                    <th>Time Taken</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($top as $key => $e)
                               @if(Session::get('id')==$e->student_id)
                               <tr bgcolor="green">
                               @else
                               <tr> 
                               @endif 
                                <td>{{ ucwords($e->student_name) }}</td>
                                <td>{{ ucwords($e->prize_amount) }}</td>
                                <td>{{ $e->username }}</td>
                                <td>{{ round($e->corr/100,2)*100 }} %</td>
                                <td>{{ $e->mins_seconds }}</td>
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

