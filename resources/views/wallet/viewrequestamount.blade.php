@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Wallet</h3>
                        </div>

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
                            <div class="table-responsive" style="overflow-x: auto; ">
                                 <table id="example2" class="table table-bordered table-striped">
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
									
									
									@if(Auth::user()->id == $payreq->from_id )
                                    <td>{{ $payreq->to_id }}</td>
								    @elseif(Auth::user()->id == $payreq->to_id)
                                    <td>{{ $payreq->from_id }}</td>

									@endif
									
									
                                    <td>{{ $payreq->amount }}</td>
                                    <td>{{ $payreq->req_time }}</td>
									@if(Auth::user()->id == $payreq->from_id || $payreq->status == "Approved" )
                                    <td>{{ $payreq->status }}</td>
                                     @elseif(Auth::user()->id == $payreq->from_id || $payreq->status == "Declined" )
                                    <td>{{ $payreq->status }}</td>
								    @elseif(Auth::user()->id == $payreq->to_id)
									
									<td><a class="btn btn-success btn-sm" href="#" onclick="show_reqamount('{{ $payreq->id }}','{{ $payreq->amount }}','{{ $payreq->from_id }}','{{ $payreq->req_image }}')">Approve</a></td>
                                   @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                            </div>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="requestamount">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Payment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('approvepayment') }}" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <input type="hidden" name="from_id" id="reqfromid">

                        <input type="hidden" name="req_id" id="reqid">                      
                        <center> <img src="" id="reqpaidimage" class="mb-3" style="opacity: .8; width:100%;"></center>
							<div class="form-group row">
                            <label for="amount" class="col-sm-4 col-form-label"><span
                                    style="color:red"></span>Amount <span id="reqamounthidden"></span></label>
                            <div class="col-sm-8">
                                <input type="text" name="amount" class="form-control number" placeholder="Enter Amount" required="required">
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                         <input id="declinebtn" type="button" value="Decline" class="btn btn-danger">
                        <input type="submit" class="btn btn-primary" value="Add Payment" name="addamount" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
    <script>

		function show_reqamount(id, amount, fromid, paidimage) {
            $("#reqid").val(id);
            $("#reqamounthidden").html(amount);
            $("#reqfromid").val(fromid);
            $("#reqpaidimage").attr("src", 'upload/paidimage/' + paidimage);
            $("#requestamount").modal("show");
             var decline = "{{ url('declinerequest_payment') }}";
             $('#declinebtn').click(function(e) {  
                var r = confirm("Are you sure to Decline?");
                if (r == true){
                    var url = decline + "/" + id;
                    window.location.href = url;
                }
            });
        }

        $(document).ready(function() {
            $("#wallet").addClass('menu-open');
        });
    </script>
@endpush
 