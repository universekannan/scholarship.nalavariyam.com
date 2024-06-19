@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="content-header">
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Certificate</h3>
                    </div>
                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissable" style="margin: 15px;">
                                <a href="#" style="color:white !important" class="close" data-dismiss="alert"
                                    aria-label="close">&times;</a>
                                <strong> {{ session('success') }} </strong>
                            </div>
                        @endif
                        <form action="{{ url('/saveprizeamount') }}" method="post">
                        {{ csrf_field() }}
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
                            <div class="row">
                            <div class="col-md-12 text-center">
                                <input type="submit" value="Save Prize Amount" class="btn btn-success text-center" >
                            </div>
                            </div>
                        </form>

                        <div class="modal fade" id="addcategory">
                            <form action="{{ url('/addcategory') }}" method="post">
                                {{ csrf_field() }}
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Category</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label for="category_name" class="col-sm-4 col-form-label"><span
                                                                style="color:red">*</span>Category Name</label>
                                                        <div class="col-sm-8">
                                                            <input required="required" type="text" class="form-control"
                                                                name="category_name" id="category_name" maxlength="50"
                                                                placeholder="Category Name">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <input class="btn btn-primary" type="submit" value="Submit" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal fade" id="editcategory" tabindex="-1" aria-hidden="true">
                            <form action="{{ url('/editcategory') }}" method="post">
                                {{ csrf_field() }}
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalScrollable">Edit Category</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="Hidden" name="category_id" id="category_id">
                                                    <div class="form-group row">
                                                        <label for="category_name" class="col-sm-4 col-form-label"><span
                                                                style="color:red">*</span>Category Name</label>
                                                        <div class="col-sm-8">
                                                            <input required="required" type="text"
                                                                class="form-control" name="category_name" id="editcategoryname"
                                                                maxlength="50" placeholder="Category Name">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="name" class="col-sm-4 col-form-label"><span
                                                                style="color:red">*</span>Status</label>
                                                        <div class="col-sm-8">
                                                            <select name="status" class="form-control" id="editstatus">
                                                                <option value="1">Active</option>
                                                                <option value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <input class="btn btn-primary" type="submit" value="Submit" />
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
<script>
    function edit_category(id, category_name, status,) {
        $("#editcategoryname").val(category_name);
        $("#editstatus").val(status);
        $("#category_id").val(id);
        $("#editcategory").modal("show");
    }
</script>
@endpush
