<div id="wrapper" class="container">
	<section class="navbar main-menu">
	  <div class="navbar-inner main-menu">
		<nav id="menu" class="pull-left">
			<ul class="nav navbar-nav">
                <li class="active dropdown"><a href="{{ route('home') }}">Home</a></li> 
				<li class="dropdown"><a href="{{ route('about_us') }}">About Us</a></li>          
			   <li  class="dropdown"><a href="javascript:void(0)">Co-ordinators<i class="fa fa-angle-down"></i></a>
    		    <ul class="dropdown-menu">
				   <li><a href="{{ route('coordinators') }}" class="high">Co-ordinators</a></li>
				   <li><a href="{{ route('supcoordinators') }}">Sup Co-ordinators</a></li>
                </ul>
    		   </li>
			   <li class=""><a href="{{ route('institute') }}">Institute</a></li>
			   <li class=""><a href="{{ route('schemes') }}">Schemes</a></li>            
			   <li class=""><a href="{{ route('enquiry') }}">Enquiry</a></li>            
               <li><a href="{{ route('contact_us') }}">Contact Us</a></li>   
               <li><a href="{{ route('login') }}">Admin Login</a></li>   
               <li><a href="{{ route('studentlogin') }}">Student Login</a></li>   
               <li><a href="{{ route('login') }}">Institut Login</a></li>   
                </ul>
    	   </nav>
	  </div>
</section>