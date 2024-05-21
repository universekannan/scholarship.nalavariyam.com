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
                        <h1>Amount Transfer</h1>

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
                        <h3 class="card-title">Amount Transfer Details</h3>

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
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" action="{{ route('fundtranser') }}">
                                @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Select User ID *</label>
                                            <select class="form-control select2bs4" name="userid"
                                                    style="width: 100%;" required="required">
                                                    @foreach ($users as $user)
                                                    <option value="{{ $user->id }}-{{ $user->uniqueId }}-{{ $user->wallet }}">{{ $user->uniqueId }} - {{ $user->name }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="balance">Current Balance </label>
                                            <input type="text" class="form-control" name="balance" disabled="disabled" id="balance" value="{{ Auth::user()->wallet - $autopoolamount }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Transfer Amount *</label>
                                            <input type="text" class="form-control"  required="required" name="tamount" placeholder="Transfer Amount" id="tamount"><br>
                                            <span class="alert alert-danger" id="error" style="display: none;">Insufficient balance</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">New Balance *</label>
                                            <input type="text" class="form-control"  disabled="disabled" name="namount" placeholder="New Balance" id="nbalance">
                                        </div>
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
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })


        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function (event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        });

        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

    })
    /*$('select').on('change', function() {
      var getval = this.value;
      var arr = getval.split("-");
      $('#curbalance, #balance').val(arr[2]);
    });*/

    $("#tamount").keyup(function(){
        var getval = this.value;
        var bal = $('#balance').val();
        if(bal < getval) {
            $("#error").css("display", "block");
            $('#nbalance').val(0); 
        } else {
           var res = bal - getval;
            $('#nbalance').val(res); 
            $("#error").css("display", "none");
        }
    });
</script>
</body>
</html>
