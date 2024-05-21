@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Wallet</h3>
                            <div class="row float-right ">
                                <div class="row">
                                    <ol class=" float-sm-right">
                                        @if(Auth::user()->id != 1)
                                    @if($status == 'Pending')
                                        <a href="{{ route('paymentrequest') }}"  class="btn btn-primary float-sm-right" title="Request Amount "><i class="fas fa-plus"> Request Amount</i> </a>
                                        @else
                                       
                                        <a href="" data-toggle="modal" data-target="#Request"
                                        class="btn btn-primary float-sm-right" title="Request Amount "><i
                                            class="fas fa-plus"> Request Amount</i> </a>
                                        @endif
                                        @endif
                                    </ol>
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="from" id="from"
                                            value="{{ $from }}">
                                    </div>
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="to" id="to"
                                            value="{{ $to }}">
                                    </div>
                                </div>
                                <div>
                                    <input id="btntop" type="button" onclick="load_report()" value="Show"
                                        class="col-sm-12 btn btn-success">
                                </div>
                            </div>
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
                                            <th>S No</th>
                                            <th>DateTime</th>
                                            <th>UserId</th>
                                            <th>Title</th>
                                            <th>Details</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                           <!--  @if (Auth::user()->user_type_id == 1)
                                                <th>Delete</th>
                                            @endif -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wallet as $key => $walletlist)
                                            <tr>
                                                <td>{{ $walletlist->id }}</td>
                                                <td>{{ $walletlist->paydate }} , {{ $walletlist->time }}</td>

                                                <td>U{{ $walletlist->to_id }}</td>
                                                <td>{{ $walletlist->service_status }} , {{ $walletlist->ad_info }}  </td>
                                               
												 <td>C {{ $walletlist->customer_id }} , S {{ $walletlist->service_id }}</td>

                                                @if ($walletlist->service_status == 'Out Payment')
                                                    <td>{{ $walletlist->amount }}</td>
                                                    <td></td>
                                                @else
                                                    <td></td>
                                                    <td>{{ $walletlist->amount }}</td>
                                                @endif
                                                {{--
                                                @if (Auth::user()->user_type_id == 1)
                                                    <td>
                                                        @if (Auth::user()->user_type_id == 1 && $walletlist->ad_info2 == 'ServicePayment')
                                                            <a onclick="return confirm('Do you want to Confirm delete operation?')"
                                                                href="{{ url('/servicepaymentdelete', $walletlist->pay_id) }}"
                                                                class="btn btn-info btn-sm"><i class="fa fa-undo"></i>
                                                                Refund S</a>
                                                        @elseif (Auth::user()->user_type_id == 1 && $walletlist->ad_info2 == 'FundTransfer')
                                                            <a onclick="return confirm('Do you want to Confirm delete operation?')"
                                                                href="{{ url('/transferpaymentdelete', $walletlist->pay_id) }}"
                                                                class="btn btn-info btn-sm"><i class="fa fa-undo"></i>
                                                                Refund T</a>
                                                        @else($walletlist->service_status == 'RequestAmount' )
                                                        @endif
                                                    </td>
                                                @endif
                                                --}}
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total</td>
                                        <td>{{ $balance }}</td>
                                        @if (Auth::user()->user_type_id == 1)
                                            <td></td>
                                        @endif
                                    </tr>
                                </table>
                            </div>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="modal fade" id="Request">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Request Amount</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                   <form action="{{ url('create_paymentrequest') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                <div class="modal-body">
                    <center>

                            {{ $referencedata->full_name }}</br>
                            {{ $referencedata->phone }}</br>
                            {{ $referencedata->upi }}</br>
                            <img style="width:200px"
                                src="{{ URL::to('/') }}/upload/qrcode/{{ $referencedata->payment_qr_oode }}" />
                    </center>
                     
                    <div class="form-group row">
                        <label for="" class="col-sm-12 col-form-label"><span
                                style="color:red"></span>Request Amount</label>
                        <input  type="text" class="form-control" name="amount" placeholder='Enter Request Amount' required="required">
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-12 col-form-label"><span
                                style="color:red"></span>Paid Image(ScreenShot)</label>
                    <div class="custom-file">
                    <input accept="image/png,image/jpeg,image/jpg" type="file" class="custom-file-input" name="paid_image" required="required">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
              
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type='submit' id='plansubmit' class='btn btn-primary'>Request Now</button>
                 </form>
                </div>
            </div>
        </div>
    </div>
    </section>
   

   
@endsection
@push('page_scripts')
    <script>
        var payments = "{{ url('payments') }}";

        function load_report() {
            var from = $("#from").val();
            var to = $("#to").val();
            if (from == "") {
                alert("Please select from Date");
            } else if (to == "") {
                alert("Please select To Date");
            } else {
                var url = payments + "/" + from + "/" + to;
                window.location.href = url;
            }
        }
        

        $(document).ready(function() {
            $("#wallet").addClass('menu-open');
        });
    </script>
@endpush
