<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<title>Ramji Trust</title>
        <meta name="description" content="Ramji Trust" />
		<meta name="Keywords" content="Ramji Trust" />
        <link rel="canonical" href="" />
        <meta property="og:title" content="Ramji Trust" />
        <meta property="og:type" content="blog" />
	    <meta property="og:type" content="article" />
	    <meta property="og:description" content="Ramji Trust" />
        <meta property="og:url" content="" />
        <meta property="og:site_name" content="Ramji Trust" />
        <meta name="twitter:description" content="Ramji Trust" />
	    <meta name="twitter:card" content="summary" />
	    <meta name="copyright" content="Galaxy Technology Park Pvt Ltd" />
	    <meta name="author" content="Galaxy Kannan" />
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta content='IE=8' http-equiv='X-UA-Compatible'/>
		<link rel="shortcut icon" href="./assets/images/pr-info-expert-logo.png" />
		<link rel="icon" href="./assets/images/pr-info-expert-logo.png" />

		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="assets/css/bootstrappage.css" rel="stylesheet"/>

		<link href="assets/css/flexslider.css" rel="stylesheet"/>
		<link href="assets/css/main.css" rel="stylesheet"/>

		<script src="assets/js/jquery-1.7.2.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/superfish.js"></script>
		<script src="assets/js/jquery.scrolltotop.js"></script>

	</head>
    <body>
    @include('layouts.header')
    @include('layouts.menu')

	<section class="header_text">
			<h1><b>Welcome to Ramji Trust</b></h1>
			</section>
			<section class="main-content">
				 <div class="row">
         <div class="span12">
            <h4 class="title">
            <div id="myCarousel" class="myCarousel carousel slide">
               <div class="carousel-inner">
                  <div class="active item">
                     <ul class="thumbnails">
                        <li class="span4">
                           <div class="example-box">
                               @foreach ($cordinator as $cordinatorlist)
                        <div class="w3-content w3-section">
                            <a href="{{ url(1) }}">
                                <img width="1125" height="190" align="center" class="mySlides1"
                                    src="{{ URL::to('/') }}/upload/cordinator/{{ $cordinatorlist->cordinator_image }}"></a>
                        </div>
						  @endforeach
                              <p class="title">Co-ordinator</p>
                              <p class="price"><img src="assets/images/star-rating.png"/></p>
                           </div>
                        </li>
                       <li class="span4">
                           <div class="example-box">

                        <div class="w3-content w3-section">
                            <a href="{{ url(1) }}">
                                <img width="1125" height="190" align="center" class="mySlides2"
                                    src="{{ URL::to('/') }}/upload/scheme/1.jpeg"></a>
                        </div>
                             
                        <div class="w3-content w3-section">
                            <a href="{{ url(1) }}">
                                <img width="1125" height="190" align="center" class="mySlides2"
                                    src="{{ URL::to('/') }}/upload/scheme/2.jpeg"></a>
                        </div>

                        <div class="w3-content w3-section">
                            <a href="{{ url(1) }}">
                                <img width="1125" height="190" align="center" class="mySlides2"
                                    src="{{ URL::to('/') }}/upload/scheme/3.jpeg"></a>
                        </div>
                        <div class="w3-content w3-section">
                            <a href="{{ url(1) }}">
                                <img width="1125" height="190" align="center" class="mySlides2"
                                    src="{{ URL::to('/') }}/upload/scheme/4.jpeg"></a>
                        </div>
                        <div class="w3-content w3-section">
                            <a href="{{ url(1) }}">
                                <img width="1125" height="190" align="center" class="mySlides2"
                                    src="{{ URL::to('/') }}/upload/scheme/5.jpeg"></a>
                        </div>
                        <div class="w3-content w3-section">
                            <a href="{{ url(1) }}">
                                <img width="1125" height="190" align="center" class="mySlides2"
                                    src="{{ URL::to('/') }}/upload/scheme/6.jpeg"></a>
                        </div>
                        <div class="w3-content w3-section">
                            <a href="{{ url(1) }}">
                                <img width="1125" height="190" align="center" class="mySlides2"
                                    src="{{ URL::to('/') }}/upload/scheme/7.jpeg"></a>
                        </div>

                        <div class="w3-content w3-section">
                            <a href="{{ url(1) }}">
                                <img width="1125" height="190" align="center" class="mySlides2"
                                    src="{{ URL::to('/') }}/upload/scheme/8.jpeg"></a>
                        </div>
                              <p class="title">Scheme</p>
                              <p class="price"><img src="assets/images/star-rating.png"/></p>
                       
                           </div>
                        </li>
						<li class="span4">
                           <div class="example-box">
                               @foreach ($instutites as $instutiteslist)
                        <div class="w3-content w3-section">
                            <a href="{{ url(1) }}">
                                <img width="1125" height="190" align="center" class="mySlides3" src="{{ URL::to('/') }}/upload/institutephoto/{{ $instutiteslist->institution_photo }}"></a>
                        </div>
						  @endforeach
                              <p class="title">Instutites</p>
                              <p class="price"><img src="assets/images/star-rating.png"/></p>
							 
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>		

		<script src="assets/js/common.js"></script>
		<script src="assets/js/jquery.flexslider-min.js"></script>
		<script type="text/javascript">
			$(function() {
				$(document).ready(function() {
					$('.flexslider').flexslider({
						animation: "fade",
						slideshowSpeed: 4000,
						animationSpeed: 600,
						controlNav: false,
						directionNav: true,
						controlsContainer: ".flex-container" // the container that holds the flexslider
					});
				});
			});
		</script>
		 <script>
        var myIndex = 0;
        carousel();

        function carousel() {
            var i;
            var x = document.getElementsByClassName("mySlides1");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            myIndex++;
            if (myIndex > x.length) {
                myIndex = 1
            }
            x[myIndex - 1].style.display = "block";
            setTimeout(carousel, 5000);
        }

        var myIndexleft = 0;
        carouselleft();

        function carouselleft() {
            var i;
            var x = document.getElementsByClassName("mySlides2");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            myIndexleft++;
            if (myIndexleft > x.length) {
                myIndexleft = 1
            }
            x[myIndexleft - 1].style.display = "block";
            setTimeout(carouselleft, 5000);
        }

        var myIndexfooter = 0;
        carouselfooter();

        function carouselfooter() {
            var i;
            var x = document.getElementsByClassName("mySlides3");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            myIndexfooter++;
            if (myIndexfooter > x.length) {
                myIndexfooter = 1
            }
            x[myIndexfooter - 1].style.display = "block";
            setTimeout(carouselfooter, 5000);
        }
    </script>
    </body>
</html>