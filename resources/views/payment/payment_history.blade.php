@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payment History </h1>
                </div>
                <div class="col-sm-6">
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
                            <div class="table-responsive">
                                <table id="example2" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th> S No </th>
									<th> Payment Id </th>
									<th> Amount </th>
									<th> From Id </th>
                                    <th> To Id </th>
									<th>Pay Date</th>
                                    <th>Pay Time</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($viewhistory as $key => $historylist)
									<tr>
										<td>{{ $key + 1 }}</td>
										<td>{{ $historylist->id }}</td>
										<td>{{ $historylist->amount }}</td>
										<td>{{ $historylist->from_id}}</td>
										<td>{{ $historylist->to_id}}</td>
										<td>{{ $historylist->pay_date }}</td> 
                                        <td>{{ $historylist->pay_time }}</td>
										<td>{{ $historylist->status }}</td>
										<td>
									</td>
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
    </section>
    
@endsection





