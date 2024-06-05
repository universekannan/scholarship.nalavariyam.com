<aside class="main-sidebar sidebar-dark-primary elevation-4">
   <a href="{{ route('dashboard') }}" class="brand-link">
   <img src="{{ asset('/AdminLTELogo.png') }}" class="brand-image img-circle elevation-3">
   <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
   </a>
   <div class="sidebar">
      <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">
            <li class="nav-item has-treeview {{ request()->segment(1) == 'Dashboard' ? 'menu-open' : '' }}">
               <a href="{{ route('dashboard') }}" class="nav-link">
                  <i class="nav-icon fas fa-home"></i>
                  <p>Dashboard</p>
               </a>
            </li>
            @if(Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2)
            <li class="nav-item has-treeview {{ request()->segment(1) == 'Student' || request()->is('Students') || request()->is('addstudent') || request()->is('studentapproval') ? 'menu-open' : '' }}">
               <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-graduation-cap"></i>
                  <p>
                     Manage Students
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li
                     class="nav-item has-treeview {{ request()->segment(1) == 'students' ? 'menu-open' : '' }}">
                     <a href="{{ url('students') }}"
                        class="nav-link {{ request()->segment(1) == 'students' ? 'active' : '' }}">
                        <i class="fa fa-user-circle"></i>
                        <p>Students</p>
                     </a>
                  </li>
                  <li
                     class="nav-item has-treeview {{ request()->segment(1) == 'ssummary' ? 'menu-open' : '' }}">
                     <a href="{{ url('ssummary') }}"
                        class="nav-link {{ request()->segment(1) == 'ssummary' ? 'active' : '' }}">
                        <i class="fa fa-user-circle"></i>
                        <p>District Summary</p>
                     </a>
                  </li>
                  <li
                     class="nav-item has-treeview {{ request()->segment(1) == 'usummary' ? 'menu-open' : '' }}">
                     <a href="{{ url('usummary') }}"
                        class="nav-link {{ request()->segment(1) == 'usummary' ? 'active' : '' }}">
                        <i class="fa fa-user-circle"></i>
                        <p>User Summary</p>
                     </a>
                  </li>
                  <li
                     class="nav-item has-treeview {{ request()->segment(1) == 'institutesummary' ? 'menu-open' : '' }}">
                     <a href="{{ url('institutesummary') }}"
                        class="nav-link {{ request()->segment(1) == 'institutesummary' ? 'active' : '' }}">
                        <i class="fa fa-user-circle"></i>
                        <p>Institute Summary</p>
                     </a>
                  </li>
                  <li
                     class="nav-item has-treeview {{ request()->segment(1) == 'addstudent' ? 'menu-open' : '' }}">
                     <a href="{{ url('addstudent') }}/"
                        class="nav-link {{ request()->segment(1) == 'addstudent' ? 'active' : '' }}">
                        <i class="fa fa-plus-square"></i>
                        <p>Add Student</p>
                     </a>
                  </li>
                  @if(Auth::user()->user_type_id == 1)
                  <li
                     class="nav-item has-treeview {{ request()->segment(1) == 'studentapproval' ? 'menu-open' : '' }}">
                     <a href="{{ url('studentapproval') }}/"
                        class="nav-link {{ request()->segment(1) == 'studentapproval' ? 'active' : '' }}">
                        <i class="fa fa-plus-square"></i>
                        <p>Student Approval</p>
                     </a>
                  </li>
                  @endif
               </ul>
            </li>
            @else
            <li class="nav-item has-treeview {{ request()->segment(1) == 'Student' || request()->is('Students') || request()->is('addstudent') || request()->is('digital') ? 'menu-open' : '' }}">
               <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-graduation-cap"></i>
                  <p>
                     Manage Students
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li
                     class="nav-item has-treeview {{ request()->segment(1) == 'students' ? 'menu-open' : '' }}">
                     <a href="{{ url('students') }}"
                        class="nav-link {{ request()->segment(1) == 'students' ? 'active' : '' }}">
                        <i class="fa fa-user-circle"></i>
                        <p>Students</p>
                     </a>
                  </li>
                  <li
                     class="nav-item has-treeview {{ request()->segment(1) == 'addstudent' ? 'menu-open' : '' }}">
                     <a href="{{ url('addinstitutestudent') }}/"
                        class="nav-link {{ request()->segment(1) == 'addinstitutestudent' ? 'active' : '' }}">
                        <i class="fa fa-plus-square"></i>
                        <p>Add Student</p>
                     </a>
                  </li>
               </ul>
            </li>
            @endif
            @if(Auth::user()->user_type_id == 1)
				
            <li class="nav-item has-treeview {{ request()->segment(1) == 'questions' ? 'menu-open' : '' }}">
               <a href="{{ route('questions') }}" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Questions</p>
               </a>
            </li>
            <li class="nav-item has-treeview {{ request()->segment(1) == 'summary' ? 'menu-open' : '' }}">
               <a href="{{ route('summary') }}" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Question Summary</p>
               </a>
            </li>
            <li class="nav-item has-treeview {{ request()->segment(1) == 'createexam' ? 'menu-open' : '' }}">
               <a href="{{ route('createexam') }}" class="nav-link">
                  <i class="nav-icon fas fa-graduation-cap"></i>
                  <p>Exam Schedule</p>
               </a>
            </li>
            <li class="nav-item has-treeview {{ request()->segment(1) == 'result' ? 'menu-open' : '' }}">
               <a href="{{ route('result') }}" class="nav-link">
                  <i class="nav-icon fas fa-graduation-cap"></i>
                  <p>Result</p>
               </a>
            </li>
            @endif
            <li class="nav-item has-treeview {{ request()->segment(1) == 'examcompleted' ? 'menu-open' : '' }}">
               <a href="{{ route('examcompleted') }}" class="nav-link">
                  <i class="nav-icon fas fa-graduation-cap"></i>
                  <p>Exam Completed</p>
               </a>
            </li>
            @if(Auth::user()->user_type_id == 1)
            <li class="nav-item">
               <a href="{{ route('category') }}" class="nav-link">
                  <i class="nav-icon fa fa-list-alt"></i>
                  <p>Category</p>
               </a>
            </li>
            <li class="nav-item">
               <a href="{{ route('attribute') }}" class="nav-link">
                  <i class="nav-icon fa fa-tag"></i>
                  <p>Attribute</p>
               </a>
            </li>
            <li class="nav-item">
               <a href="{{ route('catattribute') }}" class="nav-link">
                  <i class="nav-icon fa fa-link"></i>
                  <p>Link Attribute</p>
               </a>
            </li>
            <li class="nav-item has-treeview {{ request()->segment(1) == 'admins' ? 'menu-open' : '' }}">
               <a href="{{ route('admins') }}" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Admin Users</p>
               </a>
            </li>
            @endif
            @if(Auth::user()->create_institution == 1)
            <li class="nav-item has-treeview {{ request()->segment(1) == 'Institutes' ? 'menu-open' : '' }} fuck you {{  Auth::user()->create_institution  }}">
               <a href="{{ route('institutes') }}" class="nav-link">
                  <i class="nav-icon fas fa-university"></i>
                  <p>Institutes</p>
               </a>
            </li>
            @endif
            @if(Auth::user()->user_type_id == 1)
             <li class="nav-item has-treeview {{ request()->segment(1) == 'admission' || request()->segment(2) == 'edu_type' || request()->segment(2) == 'edustudents' || request()->segment(2) == 'colleges' || request()->is('addstudent') || request()->is('studentapproval') ? 'menu-open' : '' }}">
               <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-graduation-cap"></i>
                  <p>
                      Admission
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li
                     class="nav-item has-treeview {{ request()->segment(2) == 'edustudents' ? 'menu-open' : '' }}">
                     <a href="{{ url('admission/edustudents') }}"
                        class="nav-link {{ request()->segment(2) == 'edustudents' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Students</p>
                     </a>
                  </li>
                  <li class="nav-item has-treeview {{ request()->segment(2) == 'edu_type' ? 'menu-open' : '' }}">
                     <a href="{{ url('admission/edu_type') }}"
                        class="nav-link {{ request()->segment(2) == 'edu_type' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Education Types</p>
                     </a>
                  </li>
                  <li class="nav-item has-treeview {{ request()->segment(2) == 'colleges' ? 'menu-open' : '' }}">
                     <a href="{{ url('admission/colleges') }}"
                        class="nav-link {{ request()->segment(2) == 'colleges' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Colleges</p>
                     </a>
                  </li>

               </ul>
            </li>
			@elseif(Auth::user()->user_type_id == 2)
            <li class="nav-item has-treeview {{ request()->segment(2) == 'edustudents' ? 'menu-open' : '' }}">
               <a href="{{ url('admission/edustudents') }}" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>Admission</p>
               </a>
            </li>			
            @endif
			
            <li class="nav-item has-treeview {{ request()->segment(1) == 'tailoring' ? 'menu-open' : '' }}">
               <a href="{{ url('tailoring') }}/all" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>Tailoring</p>
               </a>
            </li>
            @if(Auth::user()->user_type_id == 1)
            <li class="nav-item has-treeview {{ request()->segment(1) == 'tailoringinstitute' ? 'menu-open' : '' }}">
               <a href="{{ url('tailoringinstitute') }}" class="nav-link">
                  <i class="nav-icon fas fa-university"></i>
                  <p>Tailoring Institute</p>
               </a>
            </li>
            @endif
            <li class="nav-item has-treeview {{ request()->segment(1) == 'Payment_history' ? 'menu-open' : '' }}">
               <a href="{{ route('payment_history') }}" class="nav-link">
                  <i class="nav-icon fas fa-history"></i>
                  <p>Payment History</p>
               </a>
            </li>
            <li class="nav-item">
               <a href="{{ url('backups') }}" class="nav-link {{ Request::is('backups') ? 'active' : '' }}">
                  <i class="nav-icon fa fa-download fa-lg"></i>
                  <p>Backup</p>
               </a>
            </li>
            <li class="nav-item has-treeview {{ request()->segment(1) == 'profiles' || request()->is('profile') || request()->is('changepassword') ? 'menu-open' : '' }}">
               <a href="" class="nav-link">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                     {{ Auth::user()->full_name }}
                     <i class="fas fa-angle-left right"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="{{ route('profile') }}"
                        class="nav-link {{ request()->is('profile') ? 'active' : '' }}">
                        <i class="fa fa-cogs"></i>
                        <p>Edit Profile</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('changepassword') }}"
                        class="nav-link {{ request()->is('changepassword') ? 'active' : '' }}">
                        <i class="fa fa-user-secret"></i>
                        <p>Change Password</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="#" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-ban"></i>
                        <p>Logout</p>
                     </a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                     </form>
                  </li>
               </ul>
            </li>
         </ul>
      </nav>
   </div>
</aside>