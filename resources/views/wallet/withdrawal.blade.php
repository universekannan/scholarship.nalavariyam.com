@include('layouts.header')
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    <!-- Navbar -->
  @include('layouts.menu')
  <!-- Main Sidebar Container -->
  @include('layouts.sidebar')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Withdraw Amount</h1>

                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- SELECT2 EXAMPLE -->
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Withdraw Amount Details</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
							
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
							
                        </div>
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

                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" class="submit-form" action="{{ route('withdraw') }}">
                                @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="cbalance">Total Balance*</label>
                                            <input type="text" class="form-control" name="totalBalance" placeholder="My Balance" value="{{ Auth::user()->wallet }}" id="balance" readonly>
                                        </div> 

                                        <div class="form-group">
                                            <label for="waiting_for_approval">Waiting For Approval*</label>
                                            <input type="text" class="form-control" name="waitingForApproval" placeholder="My Balance" value="{{ $autopoolamount }}" id="waiting_for_approval" readonly>
                                        </div> 

                                        <div class="form-group">
                                            <label for="avilable_balance">Available Active Balance*</label>
                                            <input type="text" class="form-control" name="balance" placeholder="My Balance" value="{{ Auth::user()->wallet - $autopoolamount }}" id="avilable_balance" readonly>
                                        </div> 

                                        <input type="hidden" name="cbalance" value="{{ Auth::user()->wallet - $autopoolamount }}">      
                                        <div class="form-group">
                                            <label for="amount">Withdrawal Amount *</label>
                                            <input type="number" class="form-control"  required="required" name="tamount" placeholder="Withdrawal Amount" id="tamount"><br>
                                            <span class="alert alert-danger" id="error" style="display: none;">Insufficient balance</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="tds">TDS Amount *</label>
                                            <input type="number" class="form-control"  required="required" name="tds" placeholder="TDS Amount" id="tds" readonly><br>
                                        </div>
										
										  <div class="form-group">
                                            <label for="rebirth">Rebirth *</label>
                                            <input type="number" class="form-control"  required="required" name="rebirth" placeholder="Rebirth Amount" id="rebirth" readonly><br>
                                        </div>

                                        <div class="form-group">
                                            <label for="myamount">You will get *</label>
                                            <input type="number" class="form-control"  required="required" name="youWillGet" placeholder="My Amount" id="myamount" readonly><br>
                                        </div>

                                         <div class="form-group">
                                            <label for="nbalance1">New Balance*</label>
                                            <input type="text" class="form-control"  required="required" name="nbalance1" id="nbalance" placeholder="New Balanse" readonly>
                                        </div> 
                                        <input type="hidden" name="nbalance" id="nbalance1" value="0">      
                                         <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name="description" rows="3" placeholder="Enter ..."></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="tpassword"> Transfer Password *</label>
                                            <input type="text" class="form-control"  required="required" name="tpassword" placeholder="Transfer Password">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" name="submit" class="btn btn-primary submit-button">Submit</button>
                                    </div>
                                </form>
                                <!-- /.col (right) -->
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <!-- /.control-sidebar -->
    @include('layouts.footers')

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ URL::asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ URL::asset('dist/js/adminlte.js') }}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{ URL::asset('dist/js/demo.js') }}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ URL::asset('plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ URL::asset('plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ URL::asset('plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ URL::asset('plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ URL::asset('plugins/chart.js/Chart.min.js') }}"></script>

<!-- PAGE SCRIPTS -->
<script src="{{ URL::asset('dist/js/pages/dashboard2.js') }}"></script>
<!-- Select2 -->
<script src="{{ URL::asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript">
    $("#tamount").keyup(function(){
        var getval = parseInt(this.value);
        var bal = parseInt($('#avilable_balance').val());
        var bal2 = parseInt($('#balance').val());
        if(getval) {
            if(bal < getval) {
                $("#error").css("display", "block");
                $('#nbalance').val(0); 
            } else {
                var tds = (getval/100) * 15;
                $('#tds').val(tds);
				var rebirth = (getval/100) * 10;
                $('#rebirth').val(rebirth);
                var myamount = getval - tds - rebirth;
                $('#myamount').val(myamount);


               var res = bal2 - getval;
                $('#nbalance').val(res); 
                $('#nbalance1').val(res); 
                $("#error").css("display", "none");
            }
        } else {
            $("#error").css("display", "none");
            $('#nbalance').val(0); 
        }
    });

    $('.submit-form').on('submit', function(){
        $('.submit-button').attr('disabled', 'true');
    })
</script>
</body>
</html>
