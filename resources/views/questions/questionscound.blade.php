 @extends('layouts.app')
 @section('content')
 <section class="content">
   <div class="container-fluid">
       <div class="row mb-2">
       </div>
       <div class="row">
	   
                   @if (Auth::user()->user_type_id == 1)
					   
                   <div class="col-lg-3 col-6">
                      <div class="small-box bg-orange">
                           <div class=" small-box-footer">
                               <h3>{{$Tamil}}</h3>
                               <p>Tamil</p>
                           </div>
                         </div>
                   </div>
					   
                   <div class="col-lg-3 col-6">
                      <div class="small-box bg-orange">
                           <div class="small-box-footer">
                               <h3>{{$English}}</h3>
                               <p>English</p>
                           </div>
                         </div>
                   </div>

                       @endif
                                           </div>
                                       </div>
                                   </section>
                                   @endsection
                                   @push('page_scripts')
                                   <script>
                                    /*$(document).ready(function() {
                                           $("#userwallet").html(0);
                                           var wallet = "{{ url('/wallet') }}";
                                           $.ajax({
                                               url: wallet,
                                               type: "GET",
                                               success: function(response) {
                                                   response = JSON.parse(response);
                                                   if (response.message == "success") {
                                                       $("#userwallet").html(response.balance);
                                                   } else {
                                                       alert(response.message);
                                                   }
                                               }
                                           });
                                       })*/
                                   </script>
                                   @endpush
