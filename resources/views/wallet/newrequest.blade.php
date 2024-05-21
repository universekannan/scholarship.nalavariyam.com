@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Withdrawal Request</h1>
                </div>
                <div class="col-sm-6">
                    <ol class=" float-sm-right">

                        @if (Auth::user()->id == 1)
    
                        @else
                        @if(Auth::user()->upi == "" || Auth::user()->payment_qr_oode  == "") 
                        <a href="#" id="alertbtn"
                        class="btn btn-primary float-sm-right" ><i
                            class="fas fa-plus"> Withdrawal </i> </a>
                           
                          @elseif($status == 'Completed' || $status == "")
                          <a href="" data-toggle="modal" data-target="#Withdrawal "
                                class="btn btn-primary float-sm-right" title="Withdrawal Amound Request  "><i class="fas fa-plus"> Withdrawal </i> </a>
                         @else   
                         <a href="#" 
                         class="btn btn-primary float-sm-right" title="Withdrawal Amound Request  "><i
                             class="fas fa-plus"> Withdrawal Pending </i> </a>
                             @endif
                        @endif
                    </ol>
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
                                <th style="width:35%">Amount</th>
                                <th style="width:15%">Date</th>
                                <th style="width:20%">Status</th>
                                @if (Auth::user()->id == 1)
                                    <th style="width:20%">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($withdrawal as $key => $withd)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $withd->amount }}</td>
                                    <td>{{ $withd->req_time }}</td>
                                    <td>{{ $withd->status }} &nbsp;
                                        @if($withd->status == 'Completed')
                                        <a onclick="complete_withdraw('{{ $withd->pay_image }}')"
                                        href="#" class="btn btn-sm btn-primary"><i
                                            class="fa fa-eye"></i>View</a>
                                            @endif
                                        </td>
                                    @if (Auth::user()->id == 1)
                                        <td><a onclick="appove_withdrawal('{{ $withd->id }}','{{ $withd->user_id }}','{{ $withd->name }}','{{ $withd->amount }}','{{ $withd->upi }}','{{ $withd->payment_qr_oode }}')"
                                                href="#" class="btn btn-sm btn-primary"><i
                                                    class="fa fa-eye"></i>Approve</a></td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                </div>
            </div>
        </div>
        </div>
        <div class="modal fade" id="complete" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalScrollable">Withdrawal Completed</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group row">
                                <div class="col-sm-2"></div>
                                <P for="class_name" class="col-sm-10 col-form-label  text-success">Your Withdrawal is Successful.Please Check Your Account..</P>
                            </div>
                            <div class="col-md-12">
                               <center> <img style="width:200px;height:100%;;padding-bottom:10px;" src="" id="compqrcode" /></center>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>
    </div>
    </section>
    </div>
    <div class="modal fade" id="Withdrawal">
        <div class="modal-dialog">
            <form method="post" action="{{ url('saverequest') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Withdrawal Request </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="" class="col-sm-12 col-form-label"><span
                                    style="color:red"></span>Wallet</label>
                            <input value="{{ Auth::user()->wallet }}" type="text" class="form-control" name="wallet"
                                id="wallet" readonly>
                        </div>
                        @if (Auth::user()->wallet > 0)
                            <div class='form-group row'>
                                <label for='transfer_payment' class='col-sm-12 col-form-label'><span
                                        style='color:red'></span>Withdrawal Amount</label>
                                <input maxlength="7" required='requiered' type='text' class='form-control number'
                                    id="amount" name='amount' placeholder='Enter Amount'>
                            </div>
                            <div class='form-group row'>
                                <label for='balance' class='col-sm-12 col-form-label'><span
                                        style='color:red'></span>Balance</label>
                                <input readonly required='requiered' type='text' class='form-control' id="balance"
                                    name='balance'>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        @if (Auth::user()->wallet > 0)
                            <input value="Submit" id="submitbutton" type='submit' class='btn btn-primary' />
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="approve" tabindex="-1" aria-hidden="true">
        <form action="{{ url('/confirmwithdrawal') }}" method="post" enctype="multipart/form-data">
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
                                <input type="hidden" name="approve_id" id="apprid">
                                <input type="hidden" name="user_id" id="appruserid">
                                <div class="form-group row">
                                    <label for="class_name" class="col-sm-4 col-form-label">Name</label>
                                    <div class="col-sm-8">
                                        <input readonly class="form-control no-border" id="apprname" style="border: 0">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="class_name" class="col-sm-4 col-form-label">Amount</label>
                                    <div class="col-sm-8">
                                        <input readonly name="amount" class="form-control no-border" id="appramt" style="border: 0">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="class_name" class="col-sm-4 col-form-label">Upi</label>
                                    <div class="col-sm-8">
                                        <input readonly class="form-control no-border" id="apprupi" style="border: 0">
                                    </div>
                                </div>
                               <center> <img style="width:200px;height:100%;padding-bottom:10px;" src="" id="apprqrcode" /></center>
                                <div class="form-group row">
                                    <label for="pay_image" class="col-sm-4 col-form-label">Payment Proof</label>
                                    <div class="col-sm-8">
                                        <div class="custom-file">
                                            <input required='requiered' accept=" image/jpeg, image/png" type="file" class="custom-file-input" id="pay_image" name="pay_image">
                                            <label class="custom-file-label" for="exampleInputFile">Choose File</label>
                                        </div>
                                    </div>
                                </div>
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

$(document).ready(function () {
            $("#alertbtn").click(function () {
                alert("Please Update your Upi and Upi Qr code in profile...");
                window.location.href = "{{ route('profile') }}";
            });
        });
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

        function appove_withdrawal(id, user_id, name, amount, upi, qr_code) {
            $("#appruserid").val(user_id);
            $("#apprname").val(name);
            $("#appramt").val(amount);
            $("#apprupi").val(upi);
            $('#apprid').val(id);
            $("#apprqrcode").attr("src", "../uploads/qrcodeimg/" + qr_code);
            $("#approve").modal("show");
        }

        function complete_withdraw(pay_image) {
            $("#compqrcode").attr("src", "../uploads/paidimg/" + pay_image);
            $("#complete").modal("show");
        }
    </script>
@endpush
