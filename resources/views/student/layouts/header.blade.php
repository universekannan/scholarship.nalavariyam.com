<!-- Main Header -->
<nav
    class="main-header navbar navbar-expand
@if (Session::get('colour') == 1) navbar-light navbar-white 
@elseif(Session::get('colour') == 2)
navbar-dark navbar-black @endif
">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        {{-- @foreach ($referencedata as $key => $referencedatas)
        <li class="nav-item d-none d-sm-inline-block">
            <a href="tel:{{ $referencedatas->phone }}" class="nav-link">+91 {{ $referencedatas->phone }} { 24/7 }</a>
        </li>
		 @endforeach --}}

    </ul>

    <ul class="navbar-nav ml-auto">
        @if (Session::get('user_type') == 18 ||
                Session::get('user_type') == 19 ||
                Session::get('user_type') == 20 ||
                Session::get('user_type') == 21)
            @php
                $dist_id = '';
                if (Session::get('user_type') == 18 || Session::get('user_type') == 19) {
                    $dist_id = '18';
                } elseif (Session::get('user_type') == 20 || Session::get('user_type') == 21) {
                    $dist_id = '19';
                }
                $dist_id = Session::get('dist_id');
                if (Session::get('user_type') == 18 || Session::get('user_type') == 20) {
                    $sql = "SELECT * FROM payments WHERE service_status = 'Pending' and customer_user_type_id= '$dist_id'";
                } elseif (Session::get('user_type') == 19 || Session::get('user_type') == 21) {
                    $sql = "SELECT * FROM payments WHERE service_status = 'Pending' and dist_id='$dist_id' and customer_user_type_id= '$dist_id'";
                }
                $pending = DB::select(DB::raw($sql));
                $wordcount = count($pending);
            @endphp
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="" href="{{ route('memberpending') }}">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">{{ $wordcount }}</span>
                </a>
            </li>
        @endif

        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                <i class="fas fa-user"></i>
                <span class="d-none d-md-inline"> {{ Session::get('name') }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="{{ URL::to('/') }}/upload/student/photo/{{ Session::get('photo') }}"
                        class="img-circle elevation-2" alt="{{ Session::get('student_name') }}">
                    <br>
                    <h5 class="d-none d-md-inline"> {{ Session::get('student_name') }}
                    </h5>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">

                    <a href="{{ route('studentprofile') }}"
                        class="btn btn-default">Profile</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @if (Session::get('colour') == 1)
                        <a onclick="bgfavorites(this,2)" class="btn btn-danger"><i class="fa fa-moon"></i></a>
                    @else
                        <a onclick="bgfavorites(this,1)" class="btn btn-success"><i class="fas fa-moon"></i></a>
                    @endif

                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="btn btn-default float-right text-muted text-sm">Log out</a>
                    <form id="logout-form" action="{{ route('studentlogout') }}" method="get" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<style>
    marquee {
        font-size: 30px;
        font-weight: 800;
        color: #8ebf42;
        font-family: sans-serif;
    }
</style>
@php
    $user_type = '';
    if (Session::get('user_type') == 18 || Session::get('user_type') == 19) {
        $user_type = 'B';
    } elseif (Session::get('user_type') == 20 || Session::get('user_type') == 21) {
        $user_type = 'C';
    }

    // $today = date('Y-m-d');
    // if (Session::get('user_type') == 18 || Session::get('user_type') == 19 || Session::get('user_type') == 20 || Session::get('user_type') == 21) {
    //     $sql = "Select * from notification where from_date>='$today' and to_date<='$today'  order by id";
    // } else {
    //     $sql = "Select * from notification where user_type = '$user_type'  and from_date <='$today' and to_date >='$today' order by id";
    // }

    // $test = DB::select(DB::raw($sql));

@endphp
