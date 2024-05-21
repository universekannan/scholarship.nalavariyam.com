@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="content-header">
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Attribute</h3>
                    <button type="button" class="btn btn-sm btn-secondary float-right" data-toggle="modal"
                        data-target="#addcategory"><i class="fa fa-plus"> </i> Add Attribute</button>
                </div>
                <div class="card-body">
                    @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissable" style="margin: 15px;">
                        <a href="#" style="color:white !important" class="close" data-dismiss="alert"
                            aria-label="close">&times;</a>
                        <strong> {{ session('success') }} </strong>
                    </div>
                    @endif
                    <table id="example2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attributes as $attr)
                            <tr>
                                <td>{{ $attr->id }}</td>
                                <td>{{ $attr->attr_name }}</td>
                                <td>{{ ucwords($attr->attr_type) }}</td>
                                @if($attr->can_delete)
                                <td><a onclick="return confirm('Do you want to Confirm delete operation?')"
                                    href="{{ url('/deleteattribute', $attr->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
                                @else
                                <td><a class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i></a></td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="modal fade" id="addcategory">
                        <form action="{{ url('/addattribute') }}" method="post">
                            {{ csrf_field() }}
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add Attribute</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label for="attr_name" class="col-sm-4 col-form-label"><span
                                                            style="color:red">*</span>Attribute Name</label>
                                                    <div class="col-sm-8">
                                                        <input required="required" type="text" class="form-control"
                                                            name="attr_name" id="attr_name" maxlength="50"
                                                            placeholder="Attribute Name">
                                                    </div>
                                                </div>
                                           
                                                <div class="form-group row">
                                                    <label for="attr_type" class="col-sm-4 col-form-label"><span
                                                            style="color:red">*</span>Attribute Type</label>
                                                    <div class="col-sm-8">
                                                        <select name="attr_type" id="attr_type" required="required" class="form-control">
                                                            <option value="file">File</option>
                                                            <option value="text">Text</option>
                                                             <option value="dropdown">Dropdown</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            
                                                <div class="form-group row" id="hidden_div" style="display: none">
                                                    <label for="attr_value" class="col-sm-4 col-form-label"><span
                                                            style="color:red">*</span>Attribute Value</label>
                                                    <div class="col-sm-8">
                                                    <input type="text" name="attr_value" id="attr_value" data-role="tagsinput"/>
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

<script type="text/javascript">
$("#attr_type").change(function(evt){
    var attrtype = $("#attr_type").val();
    if(attrtype=="dropdown"){
        $("#hidden_div").slideDown("slow");
    }else{
        $("#hidden_div").slideUp("slow");
        $("#attr_value").val("");
    }
}); 
</script>
@endpush