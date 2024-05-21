@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Amount Request</h1>
                </div>
                <div class="col-sm-6">
                    
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Request</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width:15%">S No</th>
                                <th style="width:15%">To</th>
                                <th style="width:35%">Amount</th>
                                <th style="width:15%">Date</th>
                                <th style="width:20%">Status</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paymentrequest as $key => $payreq)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $payreq->to_id }} , {{ $payreq->full_name }}</td>
                                    <td>{{ $payreq->amount }}</td>
                                    <td>{{ $payreq->req_time }}</td>
									@if(Auth::user()->id == $payreq->from_id || $payreq->status == "Approved" )
                                    <td>{{ $payreq->status }}</td>
								    @elseif(Auth::user()->id == $payreq->to_id)
                                    @if (Auth::user()->wallet < $payreq->amount)
                                    <td><a class="btn btn-info" href="#" onclick="reqamount('{{ $payreq->id }}','{{ $payreq->amount }}','{{ $payreq->from_id }}','{{ $payreq->req_image }}')">Request</a></td>
                                    @else
									<td><a class="btn btn-success" onclick="appove_requestamount('{{ $payreq->id }}','{{ $payreq->from_id }}','{{ $payreq->amount }}','{{ $payreq->req_image }}')" href="#">Activate</a></td>
                                    @endif

									@endif
									       
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="modal fade" id="Request">
            <form onsubmit="return validateamount()" action="{{ url('paymentrequest') }}" method="post" enctype="multipart/form-data">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Request Amount</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <center>
                                @foreach ($referencedata as $key => $referencedatas)
                                    {{ $referencedatas->name }}</br>
                                    {{ $referencedatas->phone }}</br>
                                    {{ $referencedatas->upi }}</br>
                                    <img style="width:200px"
                                        src="{{ URL::to('/') }}/upload/qrcodeimg/{{ $referencedatas->payment_qr_oode }}" />
                                        <input type="hidden" name="to_id" value="{{ $referencedatas->id }}">
                                @endforeach
                            </center>
                            
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <label for="" class="col-sm-12 col-form-label"><span style="color:red"></span>Request
                                        Amount</label>
                                    <input type="text" class="form-control" name="amount" placeholder='Enter Request Amount'
                                        required="required">
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-12 col-form-label"><span style="color:red"></span>Paid
                                        Image(ScreenShot)</label>
                                    <div class="custom-file">
                                        <input accept="image/png,image/jpeg,image/jpg" type="file" class="custom-file-input"
                                            name="req_image" required="required">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
        
                        </div>
        
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type='submit' id='plansubmit' class='btn btn-primary'>Request Now</button>
                        </div>
                    </div>
                </div>
              </form>
            </div>
            
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <div class="modal fade" id="approve" tabindex="-1" aria-hidden="true">
        <form action="{{ url('/approverequest_payment') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalScrollable">Confirm Withdrawal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="from_id" id="reqfromid">
                                <input type="hidden" name="row_id" id="reqid">  

                                <div class="form-group row">
                                    <label for="class_name" class="col-sm-4 col-form-label">Amount</label>
                                    <div class="col-sm-8">
                                        <input readonly class="form-control no-border" name="amount" id="appramt" style="border: 0">
                                    </div>
                                </div>

                                
                               <center> <img style="width:200px;height:100%;padding-bottom:10px;" src="" id="apprreq_image" /></center>

                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input class="btn btn-primary" type="submit" value="Submit" />
                        </div>
                    </div>
                </div>
        </form>
    </div>

    
@endsection
@push('page_scripts')
    <script>
        $('#amount').on('input', function() {
            var wallet = parseInt($('#wallet').val());
            var amt = parseInt($('#amount').val());
            var balance = wallet - amt;
            $('#balance').val(balance);
            if (balance >= 0) {
                $('#submitbutton').prop('disabled', false);
            } else {
                $('#submitbutton').prop('disabled', true);
            }
        });

        function appove_requestamount(id, from_id, amount, req_image) {
            $("#reqfromid").val(from_id);
            $("#appramt").val(amount);
            $('#reqid').val(id);
            $("#apprreq_image").attr("src", "../upload/requestimg/" + req_image);
            $("#approve").modal("show");
        }

        function reqamount(id, amount, fromid) {
            $("#requestid").val(id);
            $("#reqamounthidden").html(amount);
            $("#reqfromid").val(fromid);
            $("#Request").modal("show");
        }
		

        function complete_withdraw(pay_image) {
            $("#compqrcode").attr("src", "../uploads/paidimg/" + pay_image);
            $("#complete").modal("show");
        }
    </script>
@endpush
