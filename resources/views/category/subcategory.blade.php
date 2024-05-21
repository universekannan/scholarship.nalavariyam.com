@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="content-header">
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Sub Category</h3>
                </div>
                <div class="card-body">
                    @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissable" style="margin: 15px;">
                        <a href="#" style="color:white !important" class="close" data-dismiss="alert"
                            aria-label="close">&times;</a>
                        <strong> {{ session('success') }} </strong>
                    </div>
                    @endif
                    <form action="{{ url('/addsubcategory') }}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="class_name" class="col-sm-4 col-form-label"><span
                                            style="color:red">*</span>Category Name</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" class="form-control" name="category_id"
                                            value="{{ $cat_id }}">
                                        <input type="text" class="form-control" value="{{ $cat_name }}" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-sm-4 col-form-label"><span
                                            style="color:red">*</span>Sub Category Name</label>
                                    <div class="col-sm-8">
                                        <input required="required" type="text" class="form-control"
                                            name="subcategory_name" maxlength="50" placeholder="Sub Category Name">
                                    </div>
                                </div>
                                <div class="form-group row text-center">
                                    <div class="col-md-12 ">
                                        <input id="save" required="required" class="btn btn-info" type="submit"
                                            name="submit" value="Save" />
                                        <a href="{{ url('admin/category') }}" class="btn btn-info">Back</a>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
                <table id="example2" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>SubCategory Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subcat as $cat)
                        <tr>
                            <td>{{ $cat->id }}</td>
                            <td>{{ $cat->category_name }}</td>
                            @if ($cat->status == 1)
                            <td>Active</td>
                            @else
                            <td>Inactive</td>
                            @endif
                            </td>
                            <td>
                                <a onclick="edit_subcategory('{{ $cat->id }}','{{ $cat->category_name }}','{{ $cat->status }}')"
                                    href="#" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i>Edit</a>

                                <a onclick="return confirm('Do you want to Confirm delete operation?')"
                                    href="{{ url('/deletesubcategory', $cat->id) }}" class="btn btn-danger btn-sm"><i
                                        class="fa fa-trash"></i> Delete</a>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="modal fade" id="editsubcategory" tabindex="-1" aria-hidden="true">
                    <form action="{{ url('/editsubcategory') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalScrollable">Edit SubCategory</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="Hidden" name="parent_id" value="{{ $cat_id }}">
                                            <input type="Hidden" name="category_id" id="category_id">
                                            <div class="form-group row">
                                                <label for="subcategory_name" class="col-sm-4 col-form-label"><span
                                                        style="color:red">*</span>SubCategory Name</label>
                                                <div class="col-sm-8">
                                                    <input required="required" type="text" class="form-control"
                                                        name="subcategory_name" id="editsubcategoryname" maxlength="50"
                                                        placeholder="Category Name">
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
@endsection
@push('page_scripts')
<script>
function edit_subcategory(id, subcategory_name, status, ) {
    $("#editsubcategoryname").val(subcategory_name);
    $("#editstatus").val(status);
    $("#category_id").val(id);
    $("#editsubcategory").modal("show");
}
</script>
@endpush