@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
		<section class="hero set-bg">
		</br>
		</br>
		</br>
		</br>
		</br>
		</br>
		</br>
		</br>

<div class="container"><center>
            @if($status == "Active")
			<h2>{{ $payment_message }}</h2></br>
		@else

                    <input onclick="pay_now()" type="button" value="Pay Now" class="btn btn-primary">
                    <input value="{{ $payment_amount }}" type="hidden" name="payment_amount" id="payment_amount" />
              
			

<h2>{{ $payment_message }}</h2>
            @endif
			</center>
</div>
</section>

<div class="modal fade" id="paynow_modal">
    <form action="{{ url('/centeruser_activate') }}" method="post">
      {{ csrf_field() }}
        <input value="{{ $payment_amount }}" type="hidden" name="payment_amount" id="payment_amount" />
        <input value="{{ $user_id }}" type="hidden" name="user_id" id="user_id" />

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pay Now</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><span style="color:red">*</span>Amount</label>
                        <div class="col-sm-8">
                            <input readonly name="pay_amount" id="pay_amount" required="required"  maxlength="50" class="form-control number" />
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input class="btn btn-primary" type="submit" value="Submit" />
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

    
        </div>
    </section>
@endsection

@push('page_scripts')
<script>
    function pay_now(){
        var payment_amount = parseFloat($("#payment_amount").val());
        $("#pay_amount").val(payment_amount);
        $("#paynow_modal").modal("show");
    }
</script>
@endpush
