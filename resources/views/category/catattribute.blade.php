@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="content-header">
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Link Attributes</h3>
                </div>
                <div class="card-body">
                    @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissable" style="margin: 15px;">
                        <a href="#" style="color:white !important" class="close" data-dismiss="alert"
                            aria-label="close">&times;</a>
                        <strong> {{ session('success') }} </strong>
                    </div>
                    @endif
                    <form action="{{ url('/linkattribute') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="cat_id" class="col-sm-2 col-form-label"><span
                                    style="color:red">*</span>Category</label>
                            <div class="col-sm-10">
                                <select name="cat_id" id="cat_id" required="required" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($category as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sub_cat_id" class="col-sm-2 col-form-label"><span
                                    style="color:red">*</span>Sub Category</label>
                            <div class="col-sm-10">
                                <select name="sub_cat_id" id="sub_cat_id" required="required" class="form-control">
                                    <option value="">Select Sub Category</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="attr_id" class="col-sm-2 col-form-label"><span
                                    style="color:red">*</span>Attribute</label>
                            <div class="col-sm-10">
                                <select name="attr_id" id="attr_id" required="required" class="form-control">
                                    <option value="">Select Attribute</option>
                                    @foreach($attributes as $att)
                                        <option value="{{ $att->id }}">{{ $att->attr_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <input class="btn btn-primary" type="submit" value="Save" />
                            </div>
                        </div>
                    </form>   

                    <table id="example2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Attribute</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attrlink as $link)
                            <tr>
                                <td>{{ $link->cat }}</td>
                                <td>{{ $link->category_name }}</td>
                                <td>{{ $link->attr_name }}</td>
                                <td>{{ $link->attr_type }}</td>
                                <td><a onclick="return confirm('Do you want to Confirm delete operation?')"
                                    href="{{ url('/deleteattributelink', $link->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page_scripts')
<script>
    $('#cat_id').on('change',function(){
        var cat_id = this.value;
        $("#sub_cat_id").html('');
        $.ajax({
          url: "{{url('/getsubcategory')}}",
          type: "POST",
          data: {
            cat_id: cat_id,
            _token: '{{csrf_token()}}'
        },
        dataType: 'json',
            success: function (result) {
                $('#sub_cat_id').html('<option value="">Select Sub Category</option>');
                $.each(result, function (key, value) {
                  $("#sub_cat_id").append('<option value="' + value
                    .id + '">' + value.category_name + '</option>');
                });
            }   
        });
    });
</script>
@endpush