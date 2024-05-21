@extends('student.layouts.app')
@section('content')

    <div class="row">
        <div class="page-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h2>Student Profile</h2>
                        </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    @foreach ($students as $studentslist)
                    <input type="hidden" id="statuscheck" value="{{ $studentslist->status }}">
                    <input type="hidden" id="paidstatus" value="{{ $paidstatus }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ URL::to('/') }}/upload/student/photo/{{ $studentslist->photo }}"
                                                alt="{{ $studentslist->student_name }}">
                                        </div>
                                        <h3 class="profile-username text-center">{{ $studentslist->student_name }}</h3>
                                        <p class="text-muted text-center">Software Engineer</p>
                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Followers</b> <a class="float-right">1,322</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Following</b> <a class="float-right">543</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Friends</b> <a class="float-right">13,287</a>
                                            </li>
                                        </ul>
                                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                                    </div>
                                </div>
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">About Me</h3>
                                    </div>
                                    <div class="card-body">
                                        <strong><i class="fas fa-book mr-1"></i> Education</strong>
                                        <p class="text-muted">
                                            {{ $studentslist->medium_name }},{{ $studentslist->section_name }},
                                        </p>
                                        <hr>
                                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                                        <p class="text-muted">Malibu, California</p>
                                        <hr>
                                        <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                                        <p class="text-muted">
                                            <!-- <span class="tag tag-danger">UI Design</span>
                            <span class="tag tag-success">Coding</span>
                            <span class="tag tag-info">Javascript</span>
                            <span class="tag tag-warning">PHP</span>
                            <span class="tag tag-primary">Node.js</span>-->
                                        </p>
                                        <hr>
                                        <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam
                                            fermentum enim neque.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#activity"
                                                    data-toggle="tab">Activity</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#timeline"
                                                    data-toggle="tab">Timeline</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#Bank_details"
                                                    data-toggle="tab">Settings</a></li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="activity">
                                                <div class="post">
                                                    <div class="user-block">
                                                        <img class="img-circle img-bordered-sm"
                                                            src="../../dist/img/user1-128x128.jpg" alt="user image">
                                                        <span class="username">
                                                            <a href="#">Jonathan Burke Jr.</a>
                                                            <a href="#" class="float-right btn-tool"><i
                                                                    class="fas fa-times"></i></a>
                                                        </span>
                                                        <span class="description">Shared publicly - 7:30 PM today</span>
                                                    </div>
                                                    <p>
                                                        Lorem ipsum represents a long-held tradition for designers,
                                                        typographers and the like. Some people hate it and argue for
                                                        its demise, but others ignore the hate as they create awesome
                                                        tools to help create filler text for everyone from bacon lovers
                                                        to Charlie Sheen fans.
                                                    </p>
                                                    <p>
                                                        <a href="#" class="link-black text-sm mr-2"><i
                                                                class="fas fa-share mr-1"></i> Share</a>
                                                        <a href="#" class="link-black text-sm"><i
                                                                class="far fa-thumbs-up mr-1"></i> Like</a>
                                                        <span class="float-right">
                                                            <a href="#" class="link-black text-sm">
                                                                <i class="far fa-comments mr-1"></i> Comments (5)
                                                            </a>
                                                        </span>
                                                    </p>
                                                    <input class="form-control form-control-sm" type="text"
                                                        placeholder="Type a comment">
                                                </div>
                                                <div class="post clearfix">
                                                    <div class="user-block">
                                                        <img class="img-circle img-bordered-sm"
                                                            src="../../dist/img/user7-128x128.jpg" alt="User Image">
                                                        <span class="username">
                                                            <a href="#">Sarah Ross</a>
                                                            <a href="#" class="float-right btn-tool"><i
                                                                    class="fas fa-times"></i></a>
                                                        </span>
                                                        <span class="description">Sent you a message - 3 days ago</span>
                                                    </div>
                                                    <p>
                                                        Lorem ipsum represents a long-held tradition for designers,
                                                        typographers and the like. Some people hate it and argue for
                                                        its demise, but others ignore the hate as they create awesome
                                                        tools to help create filler text for everyone from bacon lovers
                                                        to Charlie Sheen fans.
                                                    </p>
                                                    <form class="form-horizontal">
                                                        <div class="input-group input-group-sm mb-0">
                                                            <input class="form-control form-control-sm"
                                                                placeholder="Response">
                                                            <div class="input-group-append">
                                                                <button type="submit"
                                                                    class="btn btn-danger">Send</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="post">
                                                    <div class="user-block">
                                                        <img class="img-circle img-bordered-sm"
                                                            src="../../dist/img/user6-128x128.jpg" alt="User Image">
                                                        <span class="username">
                                                            <a href="#">Adam Jones</a>
                                                            <a href="#" class="float-right btn-tool"><i
                                                                    class="fas fa-times"></i></a>
                                                        </span>
                                                        <span class="description">Posted 5 photos - 5 days ago</span>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-6">
                                                            <img class="img-fluid" src="../../dist/img/photo1.png"
                                                                alt="Photo">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <img class="img-fluid mb-3"
                                                                        src="../../dist/img/photo2.png" alt="Photo">
                                                                    <img class="img-fluid" src="../../dist/img/photo3.jpg"
                                                                        alt="Photo">
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <img class="img-fluid mb-3"
                                                                        src="../../dist/img/photo4.jpg" alt="Photo">
                                                                    <img class="img-fluid" src="../../dist/img/photo1.png"
                                                                        alt="Photo">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="timeline">
                                                <div class="timeline timeline-inverse">
                                                    <div class="time-label">
                                                        <span class="bg-danger">
                                                            10 Feb. 2014
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <i class="fas fa-envelope bg-primary"></i>
                                                        <div class="timeline-item">
                                                            <span class="time"><i class="far fa-clock"></i> 12:05</span>
                                                            <h3 class="timeline-header"><a href="#">Support Team</a>
                                                                sent you an email</h3>
                                                            <div class="timeline-body">
                                                                Etsy doostang zoodles disqus groupon greplin oooj voxy
                                                                zoodles,
                                                                weebly ning heekya handango imeem plugg dopplr jibjab,
                                                                movity
                                                                jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo
                                                                kaboodle
                                                                quora plaxo ideeli hulu weebly balihoo...
                                                            </div>
                                                            <div class="timeline-footer">
                                                                <a href="#" class="btn btn-primary btn-sm">Read
                                                                    more</a>
                                                                <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <i class="fas fa-user bg-info"></i>
                                                        <div class="timeline-item">
                                                            <span class="time"><i class="far fa-clock"></i> 5 mins
                                                                ago</span>
                                                            <h3 class="timeline-header border-0"><a href="#">Sarah
                                                                    Young</a> accepted your friend request</h3>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <i class="fas fa-comments bg-warning"></i>
                                                        <div class="timeline-item">
                                                            <span class="time"><i class="far fa-clock"></i> 27 mins
                                                                ago</span>
                                                            <h3 class="timeline-header"><a href="#">Jay White</a>
                                                                commented on your post</h3>
                                                            <div class="timeline-body">
                                                                Take me to your leader!
                                                                Switzerland is small and neutral!
                                                                We are more like Germany, ambitious and misunderstood!
                                                            </div>
                                                            <div class="timeline-footer">
                                                                <a href="#"
                                                                    class="btn btn-warning btn-flat btn-sm">View
                                                                    comment</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="time-label">
                                                        <span class="bg-success">
                                                            3 Jan. 2014
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <i class="fas fa-camera bg-purple"></i>
                                                        <div class="timeline-item">
                                                            <span class="time"><i class="far fa-clock"></i> 2 days
                                                                ago</span>
                                                            <h3 class="timeline-header"><a href="#">Mina Lee</a>
                                                                uploaded new photos</h3>
                                                            <div class="timeline-body">
                                                                <img src="https://placehold.it/150x100" alt="...">
                                                                <img src="https://placehold.it/150x100" alt="...">
                                                                <img src="https://placehold.it/150x100" alt="...">
                                                                <img src="https://placehold.it/150x100" alt="...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <i class="far fa-clock bg-gray"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="Bank_details">
                                                <form class="form-horizontal">
                                                     <div class="form-group row">
                                                        <label for="inputEmail" class="col-sm-2 col-form-label">User
                                                            Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" readonly
                                                                value="{{ $studentslist->username }}"
                                                                class="form-control"
                                                                placeholder="Bank Name">
                                                        </div>
                                                    </div>
                                                     <div class="form-group row">
                                                        <label for="inputEmail" class="col-sm-2 col-form-label">
                                                            Password</label>
                                                        <div class="col-sm-10">
                                                            <input type="text"
                                                                value="{{ $studentslist->cpassword }}"
                                                                class="form-control" name=" "
                                                                placeholder="Bank Name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail" class="col-sm-2 col-form-label">Bank
                                                            Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text"
                                                                value="{{ $studentslist->bank_details }}"
                                                                class="form-control" name="bank_details	"
                                                                placeholder="Bank Name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail" class="col-sm-2 col-form-label">Full
                                                            Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text"
                                                                value="{{ $studentslist->account_holder_name }}"
                                                                class="form-control" name="account_holder_name"
                                                                placeholder="Full Name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName" class="col-sm-2 col-form-label">Ac
                                                            number</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" value="{{ $studentslist->ac_number }}"
                                                                class="form-control" name="ac_number"
                                                                placeholder="Ac number">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName" class="col-sm-2 col-form-label">Branch
                                                            Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" value="{{ $studentslist->branch_name }}"
                                                                class="form-control" name="branch_name"
                                                                placeholder="Branch Name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail"
                                                            class="col-sm-2 col-form-label">IFSC</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" value="{{ $studentslist->ifsc }}"
                                                                class="form-control" name="ifsc" placeholder="ifsc">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName2"
                                                            class="col-sm-2 col-form-label">MICR</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" value="{{ $studentslist->micr }}"
                                                                class="form-control" name="micr" placeholder="micr">
                                                        </div>
                                                     </div>
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox"> I agree to the <a
                                                                        href="#">terms and conditions</a>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button type="submit" class="btn btn-danger">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="modal fade" id="statususercheck" tabindex="-1" aria-hidden="true">
                     <form action="{{ url('/studentrequest') }}" method="post" enctype="multipart/form-data">        
                        {{ csrf_field() }}                            
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Student Payment</h6>
                </div>
                <div class="modal-body">
                    @php
                     $payment = DB::table( 'users' )->select('upi','payment_qr_oode')->where('id',1)->first();
                      @endphp
                         <center>
                           <p class="text-center">UPI ID : <b>{{ $payment->upi }}</b></p></br>
                            <img style="width:200px"
                                src="{{ URL::to('/') }}/upload/qrcode/{{ $payment->payment_qr_oode }}" />
                                <input type="hidden" name="student_id" value="{{ $studentslist->id }}">
                    </center>
                         <div class="form-group row mt-2">
                            <label for="phone" class="col-sm-4 col-form-label"><span style="color:red"></span>Amount</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="amount" placeholder='Enter Request Amount' value="150" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                         <label for="phone" class="col-sm-4 col-form-label"><span style="color:red"></span>Paid Image(Screenshot)</label>
                         <div class="col-sm-8">
                        <input required="requiered"  type="file" class="form-control"
                            name="paid_img" id="paid_img">
                                                </div>
                                            </div>
                     <div class="form-group row">
                         <label for="phone" class="col-form-label">Please Note Your <span style="color: red;"> Username : {{ $studentslist->username }} </span> and <span style="color: red;"> Password : {{ $studentslist->cpassword }} </span>.Please Pay for your account activation...</label>
                          <label for="phone" class="col-form-label">You can login using this <a href="{{ url('/studentlogin') }}">Link</a></label>
                     </div>
                    <div class="modal-footer justify-content-between">
                        <a></a>
                        <button type="submit" id="submitpayment" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>

    <div class="modal fade" id="paidstatuscheck" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Student Payment</h6>
                </div>
                <div class="modal-body">
                         <center>
                           <p><b> Please Wait For The admin's approval... </b></p>
                            <div class="form-group row">
                         <label for="phone" class="col-form-label">Please Note Your <span style="color: red;"> Username : {{ $studentslist->username }} </span> and <span style="color: red;"> Password : {{ $studentslist->cpassword }} </span>.Please Pay for your account activation...You can login using this <a href="{{ url('/studentlogin') }}">Link</a></label>
                     </div>
                    </center>
                    <div class="modal-footer justify-content-between">
                        <a></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
                    @endforeach
                </div>
        </div>

        </section>

    </div>
    </div>






    </div>
    </div>
@endsection
@push('page_scripts')
    <script>
        function pay_now() {
            var wallet_amount = parseFloat($("#wallet_amount").val());
            var payment_amount = parseFloat($("#payment_amount").val());
            $("#pay_amount").val(payment_amount);
            if (payment_amount > wallet_amount) {
                $("#referral_modal").modal("show");
            } else {
                $("#paynow_modal").modal("show");
            }
        }
        $( document ).ready(function() {
         var status = $("#statuscheck").val();
        var paidstatus = $("#paidstatus").val();
        if (status == "Inactive" && paidstatus == 0) {
            $('#statususercheck').modal({
                backdrop: 'static',
                keyboard: false
            });
        }else if(status == "Inactive" && paidstatus == 1){
            $('#paidstatuscheck').modal({
                backdrop: 'static',
                keyboard: false
            });
        }
});
      
    </script>
@endpush