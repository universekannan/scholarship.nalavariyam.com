@extends('student.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="content-header">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title text-center">{{ $category_name }}</h3>
                    </div>
                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissable" style="margin: 15px;">
                                <a href="#" style="color:white !important" class="close" data-dismiss="alert"
                                    aria-label="close">&times;</a>
                                <strong> {{ session('success') }} </strong>
                            </div>
                        @endif
                        <form action="{{ url('/saveservice') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="category_id" value="{{ $category_id }}">
                            @foreach($attributes as $attr)
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">{{ $attr->attr_name }}</label>
                                <div class="col-sm-4">
                                    @if($attr->attr_type == "file")
                                    <input accept="image/jpeg, image/png"  type="file" class="form-control"
                                    name="attr_{{ $attr->id }}_{{ $attr->attr_type }}" />
                                    @elseif($attr->attr_type == "text")
                                    <input value="{{ $attr->entry_value }}" type="text" maxlength="50" class="form-control"
                                    name="attr_{{ $attr->id }}_{{ $attr->attr_type }}" />
                                    @elseif($attr->attr_type == "dropdown")
                                    <select class="form-control" name="attr_{{ $attr->id }}_{{ $attr->attr_type }}">
                                        @php
                                            $avalues = $attr->attr_value;
                                            $avalues = explode(",",$avalues);
                                            foreach($avalues as $v){
                                                echo "<option ";
                                                if($v == $attr->entry_value) echo " selected ";
                                                echo " value='$v'>$v</option>";
                                            }
                                        @endphp
                                    </select>
                                    @endif
                                </div>
                                <div class="col-sm-4">
                                    @if($attr->attr_type == "file")
                                        @if($attr->entry_value != "")
                                          <a target="_blank" href="{{ URL::to('/') }}/upload/student/documents/{{ $attr->entry_value }}" ><i class="fa fa-eye"></i></a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    @if($status == "Pending")
                                    <input class="btn btn-primary" type="submit" value="Resubmit" />
                                    @else
                                    <input class="btn btn-primary" type="submit" value="Submit" />
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

