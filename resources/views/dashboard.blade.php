 @extends('layouts.app')
 @section('content')
 <section class="content">
   <div class="container-fluid">
       <div class="row mb-2">
       </div>
       <div class="row">
           <div class="col-lg-3 col-6">

               <div class="small-box bg-info">
                   <div class="inner">
                       <h3 id="userwallet"></h3>
                       <p>Wallet</p>
                   </div>
                   <div class="icon">
                       <i class="ion ion-bag"></i>
                   </div>
                   <a href="{{ url('payments') }}/{{ date('Y-m-d') }}/{{ date('Y-m-d') }}" class="small-box-footer">More info <i
                       class="fas fa-arrow-circle-right"></i></a>
                   </div>
               </div>

                 <div class="col-lg-3 col-6">

               <div class="small-box bg-info">
                   <div class="inner">
                       <h3>{{ $RequestAmount }}</h3>
                       <p>Request Amount</p>
                   </div>
                   <div class="icon">
                       <i class="ion ion-bag"></i>
                   </div>
                   <a href="{{ url('paymentrequest') }}" class="small-box-footer">More info <i
                       class="fas fa-arrow-circle-right"></i></a>
                   </div>
               </div>

                @if (Auth::user()->user_type_id == 1)
               <div class="col-lg-3 col-6">
                   <div class="small-box bg-orange">
                       <div class="inner">
                           <h3>{{ $admincount }}</h3>
                           <p>Admin</p>
                       </div>
                       <div class="icon">
                           <i class="ion ion-stats-bars"></i>
                       </div>
                       <a href="{{ url('admins') }}" class="small-box-footer">More info <i
                           class="fas fa-arrow-circle-right"></i></a>
                       </div>
                   </div>
                @endif
                   

               <div class="col-lg-3 col-6">

               <div class="small-box bg-info">
                   <div class="inner">
                       <h3>{{ $studentscount }}</h3>
                       <p>Students</p>
                   </div>
                   <div class="icon">
                       <i class="ion ion-bag"></i>
                   </div>
                   <a href="{{ url('students') }}" class="small-box-footer">More info <i
                       class="fas fa-arrow-circle-right"></i></a>
                   </div>
               </div>
                @if (Auth::user()->user_type_id == 1)
               <div class="col-lg-3 col-6">

               <div class="small-box bg-success">
                   <div class="inner">
                       <h3>&nbsp;</h3>
                       <p>District Summary</p>
                   </div>
                   <div class="icon">
                       <i class="ion ion-bag"></i>
                   </div>
                   <a href="{{ url('ssummary') }}" class="small-box-footer">More info <i
                       class="fas fa-arrow-circle-right"></i></a>
                   </div>
               </div>

               <div class="col-lg-3 col-6">

               <div class="small-box bg-info">
                   <div class="inner">
                       <h3>&nbsp;</h3>
                       <p>User Summary</p>
                   </div>
                   <div class="icon">
                       <i class="ion ion-bag"></i>
                   </div>
                   <a href="{{ url('usummary') }}" class="small-box-footer">More info <i
                       class="fas fa-arrow-circle-right"></i></a>
                   </div>
               </div>

                <div class="col-lg-3 col-6">

               <div class="small-box bg-info">
                   <div class="inner">
                       <h3>&nbsp;</h3>
                       <p>Institute Summary</p>
                   </div>
                   <div class="icon">
                       <i class="ion ion-bag"></i>
                   </div>
                   <a href="{{ url('institutesummary') }}" class="small-box-footer">More info <i
                       class="fas fa-arrow-circle-right"></i></a>
                   </div>
               </div>

              
                   @endif
                    @if (Auth::user()->user_type_id != 1)
                   <div class="col-lg-3 col-6">
                   <div class="small-box bg-orange">
                       <div class="inner">
                           <h3>{{ $tailoringnew }}</h3>
                           <p>New Tailoring</p>
                       </div>
                       <div class="icon">
                           <i class="ion ion-stats-bars"></i>
                       </div>
                       <a href="{{ url('tailoring') }}/all" class="small-box-footer">More info <i
                           class="fas fa-arrow-circle-right"></i></a>
                       </div>
                   </div>
                   @endif

              


                <div class="col-lg-3 col-6">
                   <div class="small-box bg-orange">
                       <div class="inner">
                           <h3>{{ $tailoringresubmit }}</h3>
                           <p>Tailoring Resubmit</p>
                       </div>
                       <div class="icon">
                           <i class="ion ion-stats-bars"></i>
                       </div>
                       <a href="{{ url('tailoring') }}/resubmit" class="small-box-footer">More info <i
                           class="fas fa-arrow-circle-right"></i></a>
                       </div>
                   </div>

                    <div class="col-lg-3 col-6">
                   <div class="small-box bg-orange">
                       <div class="inner">
                           <h3>{{ $tailoringpending }}</h3>
                           <p>Tailoring Pending</p>
                       </div>
                       <div class="icon">
                           <i class="ion ion-stats-bars"></i>
                       </div>
                       <a href="{{ url('tailoring') }}/pending" class="small-box-footer">More info <i
                           class="fas fa-arrow-circle-right"></i></a>
                       </div>
                   </div>

                    <div class="col-lg-3 col-6">
                   <div class="small-box bg-orange">
                       <div class="inner">
                           <h3>{{ $tailoringcompleted }}</h3>
                           <p>Tailoring Completed</p>
                       </div>
                       <div class="icon">
                           <i class="ion ion-stats-bars"></i>
                       </div>
                       <a href="{{ url('tailoring') }}/completed" class="small-box-footer">More info <i
                           class="fas fa-arrow-circle-right"></i></a>
                       </div>
                   </div>



                   @if (Auth::user()->user_type_id == 1)
					   
                   @foreach ($questions as $key => $question)
                   <div class="col-lg-3 col-6">
                       <div class="small-box {{$question["color"]}}">
                           <div class="inner">
                               <h3>{{$question["qcount"]}}</h3>
                               <p>{{$question["section_name"]}}</p>
                           </div>
                           <div class="icon">
                               <i class="ion ion-stats-bars"></i>
                           </div>
                           <a href="{{ url('question') }}/{{$question['section_id']}}" class="small-box-footer">More info <i
                               class="fas fa-arrow-circle-right"></i></a>
                           </div>
                       </div>
                       @endforeach
                       @endif

                       </div>
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
@push('page_scripts')
 <script>
     $( document ).ready(function() {
        $("#userwallet").html(0);
         var wallet = "{{ url('/wallet') }}";
         $.ajax({
             url: wallet,
             type: "GET",
             success: function(response) {
                 $("#userwallet").html(response);
             }
         });
     })

 </script>

 @endpush