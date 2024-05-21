@extends('layouts.app')
@section('content')
<section class="content-header">
 <div class="container-fluid">
  <div class="row mb-2">
   <div class="col-sm-6">
    <h1>Tailoring</h1>
</div>
<div class="col-sm-6">
    @if( Request::path() == 'tailoring/pending' || Request::path() == 'tailoring/completed' || Request::path() == 'tailoring/resubmit')
    @else
    @if(Auth::user()->user_type_id != 1)
    <ol class="breadcrumb float-sm-right">
     <li class="breadcrumb-item"><button type="button" class="btn btn-block btn-primary btn-sm"
      data-toggle="modal" data-target="#tailoring"><i class="fa fa-plus"> Add </i></button>
  </li>
</ol>
@endif
@endif
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
   <div class="table-responsive" style="overflow-x: auto; ">
       <table id="example2" class="table table-bordered table-striped">
        <thead>
         <tr>
          <th> S No</th>
          <th> Name</th>
          <th> Course Name</th>
          <th> Status</th>
          @if(Auth::user()->user_type_id == 1)
          <th> User Id</th>
          @endif
          <th> Action </th>

      </tr>
  </thead>
  <tbody>
     @foreach($tailoring as $key => $tailoringlist)

     <tr>
      <td>{{ $key + 1 }}</td>
      <td>{{ $tailoringlist->name }}</td>
      <td>{{ $tailoringlist->course_name }}</td>
      <td>{{ $tailoringlist->status }}</td>
      @if(Auth::user()->user_type_id == 1)
      <td> {{ $tailoringlist->user_id }}</td>
      @endif
      <td>
          @php 
       $address1 = $tailoringlist->address;
       $address1 = str_replace(PHP_EOL, ' ',$address1);
       $address1 = str_replace("\r\n", ' ', $address1);
       $address1 = str_replace("\n", ' ', $address1);
       $NEWLINE_RE = '/(\r\n)|\r|\n/'; 
       $address1 = preg_replace($NEWLINE_RE,' ', $address1);
       @endphp

       <!--  <a onclick="return confirm('Do you want to perform delete operation?')" href="{{ url('/deletetailoring' , $tailoringlist->id) }}" class="btn btn-info"><i class="fa fa-trash"title="Delete"> Delete</i></a> -->
       @if($tailoringlist->payment_status == "New")
       @if(Auth::user()->id == 1  || Auth::user()->id == 42)

       @else
       <input onclick="pay_now()" type="button" value="Pay Now" class="btn btn-primary btn-sm">
       <input value="{{ $tailoringlist->id }}" type="hidden"  id="cusid" />
       @endif
       @elseif($tailoringlist->payment_status == "Pending")
       @if(Auth::user()->user_type_id == 1 || Auth::user()->id == 42)
     
       <a onclick="approve('{{ $tailoringlist->id }}','{{ $tailoringlist->name }}','{{ $tailoringlist->address_1 }}','{{ $tailoringlist->address_2 }}','{{ $tailoringlist->district }}','{{ $tailoringlist->taluk }}','{{ $tailoringlist->profile_image }}','{{ $address1 }}','{{ $tailoringlist->user_id }}','{{ $tailoringlist->payment_status }}','{{ $tailoringlist->significant }}','{{ $tailoringlist->father_or_hus_name }}','{{ $tailoringlist->institute }}','{{ $tailoringlist->institutename }}','{{ $tailoringlist->institutelocation }}','{{ $tailoringlist->course_name }}','{{ $tailoringlist->signature }}')" type="button" class="btn btn-info btn-sm">Approve</a>
       @else
       <input type="button" value="Waiting for Approval" class="btn btn-primary btn-sm">  
       @endif
       @elseif($tailoringlist->payment_status == "Rejected")
       @if(Auth::user()->id != 42)
       <a onclick="resubmit('{{ $tailoringlist->id }}','{{ $tailoringlist->name }}','{{ $tailoringlist->address_1 }}','{{ $tailoringlist->address_2 }}','{{ $tailoringlist->district }}','{{ $tailoringlist->taluk }}','{{ $tailoringlist->profile_image }}','{{ $tailoringlist->payment_status }}','{{ $tailoringlist->reason }}','{{ $tailoringlist->significant }}','{{ $tailoringlist->father_or_hus_name }}','{{ $tailoringlist->course_name }}')" type="button" class="btn btn-info btn-sm">Resubmit</a>
       @endif
       @elseif($tailoringlist->payment_status == "Completed")
       <input type="button" value="Approved" class="btn btn-success btn-sm">
       <a onclick="viewuser('{{ $tailoringlist->name }}','{{ $tailoringlist->address_1 }}','{{ $tailoringlist->address_2 }}','{{ $tailoringlist->district }}','{{ $tailoringlist->taluk }}','{{ $tailoringlist->profile_image }}','{{ $tailoringlist->significant }}','{{ $tailoringlist->father_or_hus_name }}','{{ $tailoringlist->course_name }}','{{ $address1 }}')" type="button" class="btn btn-info btn-sm">View</a>
       @endif

   </td>   
</td>   
</tr>
@endforeach

</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</section>

<div class="modal fade" id="tailoring">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Tailoring User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/addtailoring') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="full_name">Name</label>
                                <input maxlength="50" required type="text" class="form-control" name="name" id="full_name"
                                placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                               <label for="address_1">Address 1</label>
                               <input maxlength="80" required type="text" class="form-control" name="address_1" id="address_1"
                               placeholder="Enter Address 1">
                           </div>
                           <div class="form-group">
                               <label>District</label>
                               <input maxlength="50" required type="text" class="form-control" name="district" id="district"
                               placeholder="Enter District">
                           </div>


                           <div class="form-group">
                               <label for="pin_code">Pin Code</label>
                               <input maxlength="6" required type="text" class="form-control number" name="pin_code" id="pin_code"
                               placeholder="Enter Pin Code">
                           </div>
                           <div class="form-group">
                               <label for="aadhar_number">Aadhar Number</label>
                               <input maxlength="12" required type="text" class="form-control number" name="aadhar_number" id="aadhar_number"
                               placeholder="Enter aadhar Number">
                           </div>
                       </div>
                       <div class="col-md-6">
                         <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label for="password">Significant</label>
                                  <select required="required" class="form-control" name="significant" id="significant" style="width:100%;">
                                     <option value="">
                                        Select 
                                    </option>
                                    <option value="S/O">S/O</option>
                                    <option value="D/O">D/O</option>
                                    <option value="W/O">W/O</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="father_or_hus_name">Father or Husband Name</label>
                                <input required maxlength="50" type="text" class="form-control"
                                name="father_or_hus_name" id="father_or_hus_name" placeholder="Enter Father Or Husband Name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                       <label for="address_2">Address 2</label>
                       <input maxlength="80" required type="text" class="form-control" name="address_2" id="address_2"
                       placeholder="Enter Address 2">
                   </div>
                   <div class="form-group">
                       <label>Taluk</label>
                       <input maxlength="50" required type="text" class="form-control" name="taluk" id="taluk"
                       placeholder="Enter Taluk">                                   
                   </div>
                   <div class="form-group">
                                  <label for="password">Course Name</label>
                                  <select required="required" class="form-control" name="course_name" id="course_name" style="width:100%;">
                                     <option value="">
                                        Select 
                                    </option>
                                    <option value="Tailoring Course">Tailoring Course</option>
                                    <option value="Tailoring and Embroidering Course">Tailoring and Embroidering Course</option>
                                    <option value="Aari work and Designing Course">Aari work and Designing Course</option>
                                    <option value="Tally">Tally</option>
                                    <option value="C++">C++</option>
                                    <option value="Java">Java</option>
                                    <option value="PHP">PHP</option>
                                    <option value="Java Script">Java Script</option>
                                    <option value="Tally ERP 9">Tally ERP 9</option>
                                    <option value="Desktop Publishing(DTP)">Desktop Publishing(DTP)</option>
                                </select>
                            </div>
                   <div class="form-group">
                    <label>Photo</label>

                    <input required type="file" class="form-control" name="profile_image" >
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="editsave" type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
</div>
</div>
</div>


<div class="modal fade" id="paynow_modal">
 <form action="{{ url('/tailoringpayment_update') }}" method="post">
   {{ csrf_field() }}
   @if(Auth::user()->tailoring_user == 1)
   <input value="200" type="hidden" name="payment_amount" id="payment_amount" />
   @else
   <input value="300" type="hidden" name="payment_amount" id="payment_amount" />
   @endif
   <input  type="hidden" name="customerid" id="customer_id" />

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
        <input readonly name="pay_amount" id="pay_amount" required="required" maxlength="50"
        class="form-control number" />
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


<div class="modal fade" id="viewmodal">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title">View</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
       </button>
   </div>
   <div class="modal-body">

    <div class="form-group row">
       <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Name </label>
       <label for="" class="col-sm-8 col-form-label"><span style="color:red"
          id="viewname"></span> </label>
      </div>
       <div class="form-group row">
       <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Course Name</label>
       <label for="" class="col-sm-8 col-form-label"><span style="color:red"
          id="viewcoursename"></span> </label>
      </div>
      <div class="form-group row">
       <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Husband or Father Name </label>
       <label for="" class="col-sm-8 col-form-label"><span style="color:red"
          id="viewfatherorhusname"></span> </label>
      </div>
      <div class="form-group row">
       <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Address 1
       </label>
       <label for="" class="col-sm-8 col-form-label"><span style="color:red"
          id="viewaddress1"></span> </label>
      </div>
      <div class="form-group row">
       <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Address 2
       </label>
       <label for="" class="col-sm-8 col-form-label"><span style="color:red"
          id="viewaddress2"></span> </label>
      </div>
      <div class="form-group row">
       <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>District
       </label>
       <label for="" class="col-sm-8 col-form-label"><span style="color:red"
          id="viewdist"></span> </label>
      </div>

      <div class="form-group row">
       <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Taluk
       </label>
       <label for="" class="col-sm-8 col-form-label"><span style="color:red"
          id="viewtaluk"></span> </label>
      </div>
      @if(Auth::user()->id == 1)
       <div class="form-group row">
       <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Center Address
       </label>
       <label for="" class="col-sm-8 col-form-label"><span style="color:red"
          id="viewcenteraddress"></span> </label>
      </div>
      @endif

      <div class="modal-body text-center">
        <span>Photo</span>
        <center>
            <img style="width:200px;height:100%;padding-bottom:10px;" src="" id="viewphoto" />
        </center>
        <a id="viewphotodownload" href="" type="button" class="btn btn-primary btn-sm"
        download>Download</a>
    </div>

</div>

<div class="modal-footer justify-content-between">
   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<div class="modal fade" id="approvemodal">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title">Approve</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
       </button>
   </div>
   <form action="{{ url('approve_certificate') }}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="modal-body">

        <div class="form-group row">
           <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Customer Name </label>
           <label for="" class="col-sm-8 col-form-label"><span style="color:red"
              id="apprname"></span> </label>
          </div>
           <div class="form-group row">
           <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Course Name </label>
           <label for="" class="col-sm-8 col-form-label"><span style="color:red"
              id="apprcoursename"></span> </label>
          </div>
          <div class="form-group row">
           <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Father OR Husband Name</label>
           <label for="" class="col-sm-8 col-form-label"><span style="color:red"
              id="fatherorhusname"></span> </label>
          </div>
          <div class="form-group row">
           <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Address 
           </label>
           <label for="" class="col-sm-8 col-form-label"><span style="color:red"
              id="appraddress1"></span> </label>
          </div>
    
          <div class="form-group row">
           <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>District
           </label>
           <label for="" class="col-sm-8 col-form-label"><span style="color:red"
              id="apprdist"></span> </label>
          </div>

          <div class="form-group row">
           <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Taluk
           </label>
           <label for="" class="col-sm-8 col-form-label"><span style="color:red"
              id="apprtaluk"></span> </label>
          </div>
          <div class="form-group row">
           <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Center Address
           </label>
           <label for="" class="col-sm-8 col-form-label"><span style="color:red"
              id="address"></span> </label>
          </div>

           <div class="form-group row" style="display:none;" id="insnamehide">
           <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Institute Name
           </label>
           <label for="" class="col-sm-8 col-form-label"><span style="color:red"
              id="insname"></span> </label>
          </div>

           <div class="form-group row" style="display:none;" id="inslochide">
           <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Institute Location
           </label>
           <label for="" class="col-sm-8 col-form-label"><span style="color:red"
              id="inslocation"></span> </label>
          </div>

          <div class="modal-body text-center">
            <span>Photo</span>
            <center>
                <img style="width:200px;height:100%;padding-bottom:10px;" src="" id="profilephoto" />
            </center>
            <a id="profilephotodownload" href="" type="button" class="btn btn-primary btn-sm"
            download>Download</a>
        </div>

          <div class="modal-body text-center" id="signaturehide">
            <span>Signature</span>
            <center>
                <img style="width:200px;height:100%;padding-bottom:10px;" src="" id="inssignature" />
            </center>
            <a id="inssignaturedownload" href="" type="button" class="btn btn-primary btn-sm"
            download>Download</a>
        </div>

        <div class="form-group row">
           <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Status
           </label>
           <select required class="form-control col-sm-8" id="apprstatus" name="payment_status"  style="width: 50%;">
             <option value="">Select</option>
             <option value="Completed">Completed</option>
             <option value="Rejected">Resubmit</option>
         </select>
     </div>

     <div class="form-group row" style="display: none;" id="aprreasonhide">
         <label for="customer_name" class="col-sm-4 col-form-label"><span
            style="color:red"></span>Reason</label>
            <div class="col-sm-8">
               <textarea rows="3" type="text" class="form-control"
               name="reason" id="aprreason" maxlength="100"></textarea>
           </div>
       </div>

       <input type="hidden" id="tailoringcustomerid" class="form-control" name="customerid">
       <input type="hidden" id="tailoringuserid" class="form-control" name="userid">


   </div>

   <div class="modal-footer justify-content-between">
       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       <button type='submit'class='btn btn-primary'>Submit</button>
   </form>
</div>
</div>
</div>
</div>

<div class="modal fade" id="resubmitmodal">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title">Resubmit</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
       </button>
   </div>
   <form action="{{ url('resubmit_certificate') }}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="modal-body">



        <div class="form-group row">
          <label for="customer_name" class="col-sm-4 col-form-label"><span
             style="color:red"></span>Name</label>
             <div class="col-sm-8">
                <input required="required" type="text" class="form-control"
                name="name" id="resname" maxlength="50"
                placeholder="Name">
            </div>
        </div>

        <div class="form-group row">
          <label for="course_name" class="col-sm-4 col-form-label"><span
             style="color:red"></span>Course Name</label>
             <div class="col-sm-8">
              <select required="required" class="form-control" name="course_name" id="rescourse_name" style="width:100%;">
               <option value="Tailoring Course">Tailoring Course</option>
                                    <option value="Tailoring and Embroidering Course">Tailoring and Embroidering Course</option>
                                    <option value="Aari work and Designing Course">Aari work and Designing Course</option>
                                    <option value="Tally">Tally</option>
                                    <option value="C++">C++</option>
                                    <option value="Java">Java</option>
                                    <option value="PHP">PHP</option>
                                    <option value="Java Script">Java Script</option>
                                    <option value="Tally ERP 9">Tally ERP 9</option>
                                    <option value="Desktop Publishing(DTP)">Desktop Publishing(DTP)</option>
            </select>
        </div>
    </div>

        <div class="form-group row">
          <label for="customer_name" class="col-sm-4 col-form-label"><span
             style="color:red"></span>Significant</label>
             <div class="col-sm-8">
              <select required="required" class="form-control" name="significant" id="ressignificant" style="width:100%;">
                <option value="S/O">S/O</option>
                <option value="D/O">D/O</option>
                <option value="W/O">W/O</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
      <label for="customer_name" class="col-sm-4 col-form-label"><span
         style="color:red"></span>Father or Husband Name</label>
         <div class="col-sm-8">
            <input required="required" type="text" class="form-control"
            name="father_or_hus_name" id="reshusbandorfather" maxlength="50"
            placeholder="Name">
        </div>
    </div>

    <div class="form-group row">
     <label for="customer_name" class="col-sm-4 col-form-label"><span
        style="color:red"></span>Address 1</label>
        <div class="col-sm-8">
           <input required="required" type="text" class="form-control"
           name="address_1" id="resaddress1" maxlength="100"
           placeholder="Name">
       </div>
   </div>

   <div class="form-group row">
    <label for="customer_name" class="col-sm-4 col-form-label"><span
       style="color:red"></span>Address 2</label>
       <div class="col-sm-8">
          <input required="required" type="text" class="form-control"
          name="address_2" id="resaddress2" maxlength="100"
          placeholder="Name">
      </div>
  </div>

  <div class="form-group row">
   <label for="customer_name"  class="col-sm-4 col-form-label"><span
      style="color:red"></span>District</label>
      <div class="col-sm-8">
         <input required="required" type="text" class="form-control"
         name="district" id="resdist" maxlength="50"
         placeholder="Name">
     </div>
 </div>

 <div class="form-group row">
   <label for="customer_name" class="col-sm-4 col-form-label"><span
      style="color:red"></span>Taluk</label>
      <div class="col-sm-8">
         <input required="required" type="text" class="form-control"
         name="taluk" id="restaluk" maxlength="50"
         placeholder="Name">
     </div>
 </div>

 <div class="form-group row">
   <label for="customer_name" class="col-sm-4 col-form-label"><span
      style="color:red"></span>Photo</label>
      <div class="col-sm-8">
         <input accept="image/*" type="file" class="form-control"
         name="profile_image" id="resphoto">
     </div>
 </div>

 <div class="form-group row">
   <label for="relation_ship" class="col-sm-4 col-form-label"><span
      style="color:red"></span>Status</label>
      <div class="col-sm-8">
         <select required="required" class="form-control"
         id="resstatus" name="card_type">
         <option value="Rejected">Resubmit</option>
     </select>
 </div>
</div>

<div class="form-group row">
   <label for="customer_name" class="col-sm-4 col-form-label"><span
      style="color:red"></span>Reason</label>
      <div class="col-sm-8">
         <textarea rows="3" type="text" class="form-control"
         name="reason" id="resreason" maxlength="100"></textarea>
     </div>
 </div>

 <input type="hidden" id="resubmitcustomerid" class="form-control" name="customerid">


</div>
<div class="modal-footer justify-content-between">
   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   <button id="resubmitbtn" type='submit'class='btn btn-primary'>Submit</button>
</form>
</div>
</div>
</div>

@endsection
@push('page_scripts')

<script>
 var iduser = "{{ Auth::user()->id }}";
 if(iduser != 42){
     function pay_now() {
        var payment_amount = parseFloat($("#payment_amount").val());
        var customerid = $("#cusid").val();
        $("#pay_amount").val(payment_amount);
        $("#customer_id").val(customerid);
        $("#paynow_modal").modal("show");
    }
}

function approve(id,name,address1,address2,district,taluk,profileimage,address,userid,status,significant,husorfathername,institute,institutename,institutelocation,coursename,signature) {
    $('#insnamehide').hide();
    $('#inslochide').hide();
    $('#signaturehide').hide();

   $("#tailoringcustomerid").val(id);
   $("#tailoringuserid").val(userid);
   $("#apprname").text(name);
   $("#apprcoursename").text(coursename);
   $("#appraddress1").text(address1 + " " + address2);
   $("#apprdist").text(district);
   $("#apprtaluk").text(taluk);
   $("#address").text(address);
   $("#fatherorhusname").text(significant + " " +husorfathername);
    if(institute == 1){
        $('#insnamehide').show();
        $('#inslochide').show();
        $('#signaturehide').show();
        $("#insname").text(institutename);
        $("#inslocation").text(institutelocation);
        if(signature != ""){
            $("#inssignature").attr("src", "../upload/tailoring/signature/" + signature);
            $('a#inssignaturedownload').attr({
             href: '../upload/tailoring/signature/' + profileimage
            });
        }
    }
    if(status == "Pending"){
        $('#aprreason').attr("required", false);
    }
    $('#apprstatus').change(function() {
        if ($(this).val() == "Rejected") {
            $('#aprreasonhide').show();
            $('#aprreason').attr("required", true);
        }else{
            $('#aprreasonhide').hide();
            $('#aprreason').attr("required", false);
        }
    });
    $("#profilephoto").attr("src", "../upload/tailoringprofile/" + profileimage);
    $('a#profilephotodownload').attr({
    href: '../upload/tailoringprofile/' + profileimage
    });
   $("#approvemodal").modal("show");

}


function viewuser(name,address1,address2,district,taluk,profileimage,significant,husorfathername,coursename,address) {
   $("#viewname").text(name);
   $("#viewcoursename").text(coursename);
   $("#viewaddress1").text(address1);
   $("#viewaddress2").text(address2);
   $("#viewdist").text(district);
   $("#viewtaluk").text(taluk);
   if(iduser == 1){
        $("#viewcenteraddress").text(address);
    }
   $("#viewfatherorhusname").text(significant + " " +husorfathername);
   $("#viewmodal").modal("show");

   $("#viewphoto").attr("src", "../upload/tailoringprofile/" + profileimage);
   $('a#viewphotodownload').attr({
    href: '../upload/tailoringprofile/' + profileimage
});
}

var user_type_id = "{{ Auth::user()->id }}";
function resubmit(id,name,address1,address2,district,taluk,profileimage,status,reason,significant,husorfathername,coursename) {
   $("#resubmitcustomerid").val(id);
   $("#resname").val(name);
   $("#rescourse_name").val(coursename);
   $("#resaddress1").val(address1);
   $("#resaddress2").val(address2);
   $("#resdist").val(district);
   $("#restaluk").val(taluk);
   $("#resstatus").val(status);
   $("#resreason").val(reason);
   $("#ressignificant").val(significant);
   $("#reshusbandorfather").val(husorfathername);
   $("#resubmitmodal").modal("show");

   if (user_type_id == "1" && status == "Rejected" ){
      $("#resubmitbtn").attr("disabled", true);
      $("#resname").attr("readonly", true);
      $('#resaddress1').attr("readonly", true);
      $('#resaddress2').attr("readonly", true);
      $("#resdist").attr("readonly", true);
      $("#restaluk").attr("readonly", true);
      $("#resstatus").attr("readonly", true);
      $("#resreason").attr("readonly", true);
      $("#resphoto").attr("readonly", true);
      $("#ressignificant").attr("readonly", true);
      $("#reshusbandorfather").attr("readonly", true);
  } else {

      $("#resstatus").attr("readonly", true);
      $("#resreason").attr("readonly", true);
  } 

}

$(function() {


});

</script>

@endpush
