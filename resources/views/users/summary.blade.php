@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>District Summary</h1>
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
                            <div class="table-responsive" style="overflow-x: auto; ">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>District</th>
                                            <th>Active</th>
                                            <th>Inactive</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students2 as $s)
                                            <tr>
                                                <td>{{ $s["district_name"] }}</td>
                                                <td>{{ $s["active"] }}</td>
                                                <td>{{ $s["inactive"] }}</td>
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
