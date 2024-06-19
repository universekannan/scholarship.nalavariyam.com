<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('studentdashboard') }}" class="brand-link">
        <img src="{{ asset('/upload/logo.png') }}" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item has-treeview {{ request()->segment(1) == 'studentdashboard' ? 'menu-open' : '' }}">
                    <a href="{{ route('studentdashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @if(Session::get('status') == "Active")
                @foreach($category as $cat)
                <li
                    class="nav-item has-treeview {{ request()->segment(1) == 'profile' || request()->is('changepassword') ? 'menu-open' : '' }}">
                    <a class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            {{ $cat->category_name }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    @foreach($cat->subcat as $sub)
                    <ul class="nav nav-treeview">
                        <li
                            class="nav-item has-treeview {{ request()->segment(1) == 'studentprofile' ? 'menu-open' : '' }}">
                            <a href="{{ url('/service') }}/{{ $sub->id }}" class="nav-link">
                                <i class="nav-icon fa fa-cog"></i>
                                <p>{{ $sub->category_name }}</p>
                            </a>
                        </li>
                    </ul>
                    @endforeach
                </li>
                @endforeach
                <!-- <li class="nav-item has-treeview {{ request()->segment(1) == 'practice' ? 'menu-open' : '' }}">
                    <a href="{{ route('practice') }}" class="nav-link">
                        <i class=""></i>
                        <i class="nav-icon fas fa-book-reader"></i>
                        <p>Practice Exam</p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ request()->segment(1) == 'allpracticeresult' ? 'menu-open' : '' }}">
                    <a href="{{ route('allpracticeresult') }}" class="nav-link">
                        <i class=""></i>
                        <i class="nav-icon fa fa-award"></i>
                        <p>Practice Result</p>
                    </a>
                </li> -->
                <li class="nav-item has-treeview {{ request()->segment(1) == 'showexam' ? 'menu-open' : '' }}">
                    <a href="{{ route('showexam') }}" class="nav-link">
                        <i class=""></i>
                        <i class="nav-icon fas fa-book-reader"></i>
                        <p>Online Exam</p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ request()->segment(1) == 'examresult' ? 'menu-open' : '' }}">
                    <a href="{{ route('examresult') }}" class="nav-link">
                        <i class=""></i>
                        <i class="nav-icon fa fa-award"></i>
                        <p>Exam Result</p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ request()->segment(1) == 'examrank' ? 'menu-open' : '' }}">
                    <a href="{{ route('examrank') }}" class="nav-link">
                        <i class=""></i>
                        <i class="nav-icon fa fa-award"></i>
                        <p>Exam Rank</p>
                    </a>
                </li>
                @endif
                <li
                    class="nav-item has-treeview {{ request()->segment(1) == 'profile' || request()->is('changepassword') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            {{ Session::get('student_name') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li
                            class="nav-item has-treeview {{ request()->segment(1) == 'studentprofile' ? 'menu-open' : '' }}">
                            <a href="{{ route('studentprofile') }}" class="nav-link">
                                <i class="nav-icon fa fa-user"></i>
                                <p>My Profile</p>
                            </a>
                        </li>
                        <li
                            class="nav-item has-treeview {{ request()->segment(1) == 'studentchangepassword' ? 'menu-open' : '' }}">
                            <a href="{{ route('studentchangepassword') }}" class="nav-link">
                                <i class="nav-icon fa fa-key"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                        <li
                            class="nav-item has-treeview {{ request()->segment(1) == 'studentlogout' ? 'menu-open' : '' }}">
                            <a href="{{ route('studentlogout') }}" class="nav-link">
                                <i class="nav-icon fas fa-ban"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
