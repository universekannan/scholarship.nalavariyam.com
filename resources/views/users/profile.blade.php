@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
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
                            @foreach ($profile as $key => $pro)
                                <form action="{{ url('/updateprofile') }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <input type="hidden" name="id" value="{{ $pro->id }}" />
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="full_name" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Full Name</label>
                                                <div class="col-sm-8">
                                                    <input required="requiered" type="text" class="form-control"
                                                        name="full_name" id="full_name" maxlength="50"
                                                        placeholder="Full Name" value="{{ $pro->full_name }}">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label for="phone" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Phone</label>
                                                <div class="col-sm-8">
                                                    <input required="requiered" type="text" class="form-control"
                                                        name="phone" id="phone"
                                                        placeholder="Mobile Number" value="{{ $pro->phone }}" maxlength="10">
                                                    <span id="dupmobile" style="color:red"></span>
                                                </div>
                                            </div>
                                        </div>

                                            @if(Auth::user()->tailoring_user == 1)
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="tailoring_ins_signature" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Signature</label>
                                                <div class="col-sm-8">
                                                    <input @if($pro->tailoring_ins_signature == "") required="requiered" @endif type="file" class="form-control"
                                                        name="tailoring_ins_signature" id="tailoring_ins_signature">
                                                </div>
                                             
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label for="tailoring_ins_agreement" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Agreement</label>
                                                <div class="col-sm-8">
                                                    <input @if($pro->tailoring_ins_agreement == "") required="requiered" @endif type="file" class="form-control"
                                                        name="tailoring_ins_agreement" id="tailoring_ins_agreement">
                                                   
                                                </div>
                                            </div>
                                        </div>
                                            @endif

                                        <div class="col-md-6">
                                            @if(Auth::user()->user_type_id == 1)
                                            <div class="form-group row">
                                                <label for="full_name" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>UPI</label>
                                                <div class="col-sm-8">
                                                    <input required="requiered" type="text" class="form-control"
                                                        name="upi" id="upi" maxlength="30"
                                                        placeholder="Enter UPI ID" value="{{ $pro->upi }}">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label for="phone" class="col-sm-4 col-form-label"><span
                                                        style="color:red"></span>Payment QR Code</label>
                                                <div class="col-sm-8">
                                                    <input @if($pro->payment_qr_oode == "") required="requiered" @endif type="file" class="form-control"
                                                        name="payment_qr_oode" id="payment_qr_oode">
                                                    <span id="dupmobile" style="color:red"></span>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 text-center">
                                <a href="" class="btn btn-info">Back</a>
                                <input id="save" class="btn btn-info" type="submit" name="submit"
                                    value="Submit" />
                            </div>
                        </div>
                        </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
