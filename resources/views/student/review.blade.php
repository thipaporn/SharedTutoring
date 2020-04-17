<!DOCTYPE html>
<html lang="en">
<head>
<!--

Template 2082 Pure Mix

http://www.tooplate.com/view/2082-pure-mix

-->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="">
	<meta name="description" content="">

	<!-- Site title
   ================================================== -->
	<title>Review tutor</title>

	<!-- Bootstrap CSS
   ================================================== -->
	<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">

	<!-- Animate CSS
   ================================================== -->
	<link rel="stylesheet" href="{{ URL::asset('css/animate.min.css') }}">

	<!-- Font Icons CSS
   ================================================== -->
	<link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/ionicons.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">

	<!-- Main CSS
   ================================================== -->
	<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">

	<!-- Google web font
   ================================================== -->
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,300' rel='stylesheet' type='text/css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <style>
        textarea{
            margin:  20px;
            font-size: 20px;
            font-family: 'Sarabun', sans-serif;
            margin-left: -20px;
        }

        @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);

        fieldset, label { margin: 0; padding: 0; }

        /****** Style Star Rating Widget *****/

        .rating {
            border: none;
            float: left;
        }

        .rating > input { display: none; }
        .rating > label:before {
            margin: 5px;
            font-size: 2em;
            font-family: FontAwesome;
            display: inline-block;
            content: "\f005";
        }

        .rating > .half:before {
        content: "\f089";
        position: absolute;
        }

        .rating > label {
            color: #ddd;
            float: right;
        }

        /***** CSS Magic to Highlight Stars on Hover *****/

        .rating > input:checked ~ label, /* show gold star when clicked */
        .rating:not(:checked) > label:hover, /* hover current star */
        .rating:not(:checked) > label:hover ~ label { color: Orange;  } /* hover previous stars in list */

        .rating > input:checked + label:hover, /* hover current star when changing rating */
        .rating > input:checked ~ label:hover,
        .rating > label:hover ~ input:checked ~ label, /* lighten current selection */
        .rating > input:checked ~ label:hover ~ label { color: Orange;  }

        /*  option style    */
        select#soflow, select#soflow-color {
            -webkit-appearance: button;
            -webkit-border-radius: 2px;
            -webkit-box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
            -webkit-padding-end: 20px;
            -webkit-padding-start: 2px;
            -webkit-user-select: none;
            text-align-last: center;
            border: 1px solid #AAA;
            color: #555;
            font-size: inherit;
            overflow: hidden;
            padding: 5px 10px;
            text-overflow: ellipsis;
            white-space: nowrap;
            width: 350px;
        }

        select#soflow-color {
            color: #131313;
            background-color: #ffffff;
            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            border-radius: 20px;
            padding-left: 15px;
        }
    </style>
</head>
<body>


<!-- Preloader section
================================================== -->
<div class="preloader">

	<div class="sk-spinner sk-spinner-pulse"></div>

</div>

<!-- Alart section
================================================== -->
@if (Session('pass'))
    <script type="text/javascript">
        Swal.fire({
            icon: 'success',
            title: 'Completed',
            text: "you've just reviewed the tutor"
        })
    </script>
@endif
@if (Session('null'))
    <script type="text/javascript">
        Swal.fire({
            icon: 'error',
            title: 'Wrong!!',
            text: "Try to review the tutor again"
        })
    </script>
@endif

<!-- Navigation section
================================================== -->
<div class="nav-container" style="background-color:#F4F6F7;">
    <nav class="nav-inner transparent">

    <div class="navbar">
        <div class="container">
            <div class="row">

            <div class="brand">
                <a href="{{url('/')}}">Shared Tutoring</a>
            </div>

            <div class="navicon">
                @if (Auth:: check())
                    <h3 style="text-align:right;">{{ Auth::user()->name }}</h3>
                @endif
                <div class="menu-container">
                    <div class="circle dark inline">
                        <i class="icon ion-navicon"></i>
                    </div>

                    <div class="list-menu">
                        <i class="icon ion-close-round close-iframe"></i>
                        <div class="intro-inner">
                            <ul id="nav-menu">

                            <!-- ================= แสดงเมื่อมีการ login แล้ว ================= -->
                            @if (Auth::check())
                                <li><a href="{{url('/')}}">Home</a></li>

                                <!-- check status -->
                                <!-- student -->
                                @if ( Auth:: user()->status == 'student')
                                    <li><a href="{{url('/enroll')}}">enrollment</a></li>
                                    <li><a href="{{url('/review')}}">review</a></li>
                                    <li><a href="{{url('/studentEdit')}}">edit profile</a></li>
                                <!-- tutor -->
                                @elseif ( Auth:: user()->status == 'tutor')
                                    <li><a href="{{url('/Profile')}}">Tutor Profile</a></li>
                                    <li><a href="{{url('/course')}}">Tutor course</a></li>
                                <!-- admin -->
                                @else
                                    <!-- <li><a href="#">admin area</a></li> -->
                                @endif
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                            Logout</a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                            </form>
                                </li>
                            <!-- ================= แสดงเมื่อยังไม่ได้ login ================= -->
                            @else
                                <li><a href="{{url('/')}}">Home</a></li>
                                <li><a href="{{url('/login')}}">Log-in</a></li>
                                @if (Route::has('register'))
                                <li><a href="{{url('/register')}}">Register</a></li>
                                @endif
                                <li><a href="{{url('/contact')}}">Contact</a></li>
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>

    </nav>
 </div>

<!-- Review section
================================================== -->
<section id="contact">
	<div class="container">
		<div class="row">
		    <div class="wow fadeInUp"data-wow-delay="1.6s">
                <div class="col-md-6 col-sm-4" >
                    <section id="header" class="header-five">
                            <div class="row">
                                <div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
                                    <div class="header-thumb">
                                        <h1 class="wow fadeIn" data-wow-delay="0.6s">review</h1>
                                        <h3 class="wow fadeInUp" data-wow-delay="0.9s">Let's review your tutor</h3>
                                    </div>
                                </div>
                            </div>
                    </section>
                </div>
                <div class="col-md-6 col-sm-4" style="top:-40px;">
                    <div class="contact-form" >
                        @if ( $list != [])
                            <form id="contact-form" method="get" action="{{ URL::to('/review/add') }} ">
                                <div class="tutorName"></div>
                                    <h3>Course</h3>
                                    <select name="course" id="soflow-color" onchange="addReview()" >

                                            <option value="">เลือกคอร์ส</option>

                                        @foreach ($list as $l)
                                            <option value="{{$l->idcourse}}">{{$l->idcourse}} - {{$l->Ncourse}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @foreach ($list as $l)
                                    <input type="hidden" id="1-{{$l->idcourse}}" name="idTutor" value="{{$l->idTutor}}" disabled>
                                    <input type="hidden" id="2-{{$l->idcourse}}" name="idCourse" value="{{$l->idcourse}}" disabled>
                                @endforeach
                                <br>
                                <div class="rate">
                                    <h3>Rate</h3>
                                    <fieldset class="rating">
                                        <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="สอนดีมาก ไม่เรียนไม่ได้แล้ว"></label>
                                        <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="ภูมิใจนำเสนอ"></label>
                                        <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="ก็โอเคอยู่นะ"></label>
                                        <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="เฉยๆ"></label>
                                        <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="สอนเป็นปะเนี่ย"></label>
                                    </fieldset>
                                </div>
                                <br><br><br>
                                <h3>Comment</h3>
                                <div class="comment" align="center">
                                    <textarea name="review-comment" id="" cols="54" rows="2"></textarea>
                                </div>
                                <input type="submit" class="btn" style="width:95%" name="view" value="Send">
                                <br><br>
                            </form>
                        @else
                            <h1>ไม่มีคอร์สที่สามารถรีวิวได้</h1>
                            <input type="submit" class="btn" style="width:95%" name="view" value="Home">

                        @endif

                    </div>
                </div>
		  </div>
		</div>
	 </div>
</section>

<!-- Footer section
================================================== -->
<footer>
	<div class="container">
		<div class="row">

			<div class="col-md-12 col-sm-12">
				<p class="wow fadeInUp"  data-wow-delay="0.3s">Shared Tutoring by Teletubbies - Software Engineering 2020</p>
				<ul class="social-icon wow fadeInUp"  data-wow-delay="0.6s">
					<li><a href="#" class="fa fa-facebook"></a></li>
					<li><a href="#" class="fa fa-twitter"></a></li>
					<li><a href="#" class="fa fa-dribbble"></a></li>
					<li><a href="#" class="fa fa-behance"></a></li>
					<li><a href="#" class="fa fa-google-plus"></a></li>
				</ul>
			</div>

		</div>
	</div>
</footer>

<!-- Javascript
================================================== -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/custom.js"></script>

<script>
    function addReview() {
        var x = document.getElementById("soflow-color").value;

        if(x != ""){

            $('#1-'+x).attr('disabled', false);
            $('#2-'+x).attr('disabled', false);

        }else{
            document.getElementById("showName").innerHTML = "";
        }
    }
</script>
@include('sweet::alert')
</body>
</html>
