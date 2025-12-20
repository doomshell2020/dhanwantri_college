<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <?php
    // Program to display URL of current page. 
    //pr($_SERVER);
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $link = "https";
    else
        $link = "http";
    // Here append the common URL characters. 
    $link .= "://";
    // Append the host(domain name, ip) to the URL. 
    $link .= $_SERVER['HTTP_HOST'];
    $link .= $_SERVER['REQUEST_URI'];
    $met = $this->Comman->meta($link);
    $met2 = $this->Comman->meta("https://www.idsprime.com/");
    if ($met['title'] != "") { ?>
        <!-- Google Links -->
        <link rel="preconnect" href="https://www.google.com">
        <link rel="preconnect" href="https://www.googleapis.com">
        <link rel="preconnect" href="https://cse.google.com">
        <link rel="preconnect" href="https://stats.g.doubleclick.net">
        <link rel="preconnect" href="https://www.google.co.in">
        <link rel="preconnect" href="https://clients1.google.com">
        <link rel="preconnect" href="https://cse.google.com">
        <!-- Open Graph -->
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="<?php echo $met['title']; ?>" />
        <meta property="og:description" name="description" content="<?php echo $met['description']; ?>" />
        <meta property="og:url" content="<?php echo SITE_URL; ?>" />
        <meta property="og:site_name" content="idsPrime" />
        <meta property="og:updated_time" content="<?php echo date('Y-m-d H:i:s'); ?>" />
        <meta property="og:image" content="<?php echo SITE_URL; ?>images/idsprime-logo.webp" />
        <meta property="og:image:secure_url" content="<?php echo SITE_URL; ?>images/idsprime-logo.webp" />
        <meta property="og:image:width" content="712" />
        <meta property="og:image:height" content="364" />
        <meta property="og:image:alt" content="idsPrime-logo" />
        <meta property="og:image:type" content="images/webp" />
        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="<?php echo SITE_URL; ?>">
        <meta property="twitter:title" content="<?php echo $met['title']; ?>">
        <meta property="twitter:description" content="<?php echo $met['description']; ?>">
        <meta property="twitter:image" content="<?php echo SITE_URL; ?>images/idsprime-logo.webp">
        <!-- FB Admins -->
        <meta name="fb:admins" content="">
        <meta name="google-site-verification" content="" />
        <meta name="p:domain_verify" content="" />
        <meta name="yandex-verification" content="" />
        <title><?php echo $met['title']; ?></title>
        <meta name="keywords" content="<?php echo $met['keyword']; ?>" />
        <meta name="description" content="<?php echo $met['description']; ?>" />
    <?php } else { ?>
        <title><?php echo $met2['title']; ?></title>
        <meta name="keywords" content="<?php echo $met2['keyword']; ?>" />
        <meta name="description" content="<?php echo $met2['description']; ?>" />
    <?php } ?>
    <link rel="icon" type="image/ico" href="favicon.ico">
    <link href="http://www.idsprime.com" rel="canonical">
    <link href="<?php echo SITE_URL; ?>" rel="alternate" hreflang="en-US">
    <!----------------------------Google recaptcha--------------------->
    <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
    <!------------font------------------>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <!---------------owl carousel---------------------->
    <link href="<?php echo SITE_URL; ?>css/owl.carousel.min.css" rel="stylesheet" type="text/css">
    <!---------bootstrap-------------------->
    <link href="<?php echo SITE_URL; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"> -->

    <!------------wow-effect------------------>
    <link href="<?php echo SITE_URL; ?>css/animate.css" rel="stylesheet" type="text/css">
    <!------------font-awesome------------------>
    <!-- <link href="<?php //echo SITE_URL; 
                        ?>css/all.min.css" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link href="<?php echo SITE_URL; ?>css/scrolling-nav.css" rel="stylesheet">
    <!---------------genral---------------------->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="<?php echo SITE_URL; ?>css/style2.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SITE_URL; ?>css/responsive2.css" rel="stylesheet" type="text/css">
    <?= $this->element('scriptheader') ?>
</head>

<style>
    .demoside,
    .demosideShadow {
        width: max-content;
        height: auto;
        font-size: 16px;
        text-align: center;
        line-height: initial;
        color: rgba(255, 255, 255, 0.9);
        border-radius: 5px;
        background: linear-gradient(-45deg, #ffa63d, #ff3d77, #338aff, #3cf0c5);
        background-size: 600%;
        -webkit-animation: anime 8s linear infinite;
        animation: anime 8s linear infinite;
        padding: 8px 15px;
        color: #fff !important;
        position: relative;
        /* margin-left: 30px; */
        display: block !important;
        position: fixed;
        top: 350px;
        right: -53px;
        text-align: center;
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
        z-index: 9999999;
        font-size: 18px;
    }
</style>

<body>
    <div id="page-wrapper">
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-body">
                        <div class="idsform">
                            <div class="row g-0">
                                <div class="col-lg-6 col-md-12">
                                    <div class="idsformimg">
                                        <div class="idsoverlay">
                                            <h6 class="idsformhed"> School Management Software (ERP)</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="idspopup">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <h5 class="modal-title" id="exampleModalLabel">Book A Demo</h5>
                                        <div class="formContainer">

                                            <form>
                                                <input type="text" placeholder="Name" class="form-control mb-3" />
                                                <input type="email" placeholder="Email" class="form-control mb-3" />
                                                <input type="text" placeholder="Phone No." class="form-control mb-3" />
                                                <textarea class="form-control mb-3" placeholder="Message"></textarea>
                                                <button class="modalbtn">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
        <a href="#" class="demoside" data-bs-toggle="modal" data-bs-target="#exampleModal">Book a Demo
            <div class="demosideShadow"></div>
        </a>
        <header id="header">
            <nav class="navbar navbar-expand-lg bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="https://www.idsprime.com">
                        <img src="<?php echo SITE_URL; ?>images/idsprime-logo.webp" alt="idsPrime-logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a href="<? echo SITE_URL; ?>homes/aboutus" class="nav-link">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="<? echo SITE_URL; ?>homes/whychoose" class="nav-link">Why Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="<? echo SITE_URL; ?>homes/services" class="nav-link">Services</a>
                            </li>
                            <li class="nav-item">
                                <a href="<? echo SITE_URL; ?>homes/benefits" class="nav-link">Benefits</a>
                            </li>
                            <li class="nav-item">
                                <a href="<? echo SITE_URL; ?>homes/datasecurity" class="nav-link">Data Security</a>
                            </li>
                            <li class="nav-item">
                                <a href="<? echo SITE_URL; ?>homes/partner" class="nav-link">Partner</a>
                            </li>
                            <li class="nav-item">
                                <a href="<? echo SITE_URL; ?>homes/howitwork" class="nav-link">How It Works</a>
                            </li>
                            <li class="nav-item">
                                <a href="<? echo SITE_URL; ?>homes/faq" class="nav-link">FAQ</a>
                            </li>
                            <li class="nav-item">
                                <a href="<? echo SITE_URL; ?>homes/contactus" class="nav-link">Contact</a>
                            </li>
                        </ul>

                        <a href="#" class="demoButton" data-bs-toggle="modal" data-bs-target="#exampleModal">Book a Demo
                            <div class="demoButtonShadow"></div>
                        </a>
                    </div>
                </div>
            </nav>
        </header>

        <div id="slider-3">
            <div class="over">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="left">
                                <h1>
                                    Welcome To <span>iDS Prime</span>
                                </h1>
                                <p>
                                    Best School Management Software (ERP)
                                </p>

                                <a href="#" class="demoButton" data-bs-toggle="modal" data-bs-target="#exampleModal">Book a
                                    Demo
                                    <div class="demoButtonShadow"></div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <div class="right">
                                <div class="desktop">
                                    <img src="<?php echo SITE_URL; ?>images/1727892.png" alt="sliderImage" class="img-fluid">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!--  -->
        <!-- Button trigger modal -->






        <section id="whatSMS">
            <div class="container">

                <div class="row align-items-center shadow">
                    <div class="col-md-5">
                        <lottie-player class="lottiimg" src="https://assets7.lottiefiles.com/packages/lf20_JYe5t7/data2.json" background="transparent" speed="1" style="width: 100%; height: auto" loop autoplay>
                        </lottie-player>
                    </div>
                    <div class="col-md-7 shadow-2 pe-5">
                        <div class="tg-sectionhead">
                            <div class="tg-sectiontitle">
                                <h1>What is School Management Software?</h1>
                            </div>

                            <p>In today's time, every school worldwide needs one or even another sort associated
                                with
                                School
                                Management System which is also known as School Management Software. The majority of
                                the
                                colleges
                                have experienced many other types of systems. On the other hand, due to restrictions
                                on
                                features,
                                product experience, or customer care problems, they look for better options.</p>
                            <p>IDS Prime School Management Software offers the best of technology to help provide
                                fish
                                hunters with
                                a 360-degree experience at schools that not only boosts the efficiency of
                                administrative
                                personnel
                                but also improves the experiences and productivity of all stakeholders: principals,
                                Management,
                                educators, administrative staff, college students, and parents.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <div class="call">
            <div class="container">
                <div class="actionmain">
                    <h3 class="actionheading hed">We Will Contact You, At a Time Which Suits You Best</h3>
                    <a href="https://www.idsprime.com/homes/contactus" class="demoside "> Request a Call Back
                        <div class="demosideShadow"></div>
                    </a>
                    <!-- <a class="action" href="https://www.idsprime.com/homes/contactus">
                <i class="bi bi-telephone"></i>  Request a Call Back
                </a> -->
                </div>
            </div>
        </div>


        <section id="login">
            <div class="container">
                <div class="tab">
                    <button class="tablinks active" style="" onclick="openCity(event, 'admin')" id="defaultOpen">
                        <img src="<?php echo SITE_URL; ?>images/adminTab.png" alt="admin_login">
                        <!-- <i class="fa-solid fa-user-tie"></i> -->
                        <p>Admin Login</p>
                    </button>
                    <button class="tablinks" style="" onclick="openCity(event, 'teacher')">
                        <!-- <img src="<?php //echo SITE_URL; 
                                        ?>images/teacher_login.png" alt="admin_login" class="i_show">
                        <img src="<?php //echo SITE_URL; 
                                    ?>images/teacher_login_2.webp" alt="admin_login"
                            class="i_hide"> -->
                        <img src="<?php echo SITE_URL; ?>images/teacherTab.png" alt="admin_login">
                        <p>Teachers Login</p>
                    </button>
                    <button class="tablinks" style="" onclick="openCity(event, 'parent')">
                        <!-- <img src="<?php //echo SITE_URL; 
                                        ?>images/parents_login.png" alt="admin_login"
                            class="i_show">
                            <img src="<?php //echo SITE_URL; 
                                        ?>images/parents_login_2.webp"
                            alt="admin_login" class="i_hide"> -->
                        <img src="<?php echo SITE_URL; ?>images/parentsTab.png" alt="admin_login">
                        <p>Parents Login</p>
                    </button>
                    <!-- <button class="tablinks" onclick="openCity(event, 'student')"><img
                        src="<?php echo SITE_URL; ?>images/student_login.png" alt="admin_login" class="i_show"><img
                        src="<?php echo SITE_URL; ?>images/student_login_2.webp" alt="admin_login"
                        class="i_hide">Student Login</button> -->
                </div>
                <div>
                    <div id="admin" class="tabcontent">
                        <p>Developing a dynamic system with a bird view involving information and records will give
                            the
                            following power levels together with quick decision-making for the principal or perhaps
                            management person. IDS Prime offers more ordinary Management Dash and data revealing
                            functions
                            and has a dynamic access privileges mechanism that gets to be a blessing to get
                            management
                            personnel.</p>
                        <ul>
                            <li>Class Management</li>
                            <li>Subject Management</li>
                            <li>Timetable Management</li>
                            <li>Exam Category</li>
                            <li>Student Exam Category Result</li>
                            <li>Exam Result</li>
                            <li>Event Management</li>
                            <li>Post Homework</li>
                            <li>Store Management</li>
                            <li>Payroll Management</li>
                            <li>SMS Management</li>
                            <li>Report Center Management</li>
                            <li>Public Relation Management</li>
                        </ul>
                    </div>

                    <div id="teacher" class="tabcontent">
                        <p>Having excellent access to Institution Management System dash and Mobile Software
                            multiplies the
                            output of educational in addition to the non-academic staff. Getting power to record
                            essential
                            activities in the system reduces the problem and boosts the particular velocity of
                            connection.
                            Keeping data and access regarding data when necessary make their lifestyle super easy
                        </p>

                        <ul>
                            <li>Manage Timetable</li>
                            <li>Import Exam Result</li>
                            <li>Import Co-School Activity Result</li>
                            <li>Student Attendance</li>
                            <li>Post Homework</li>
                            <li>Students View</li>
                        </ul>
                    </div>

                    <div id="parent" class="tabcontent">
                        <p>The mobile iPhone app and web admittance of school technique make life involving
                            students,
                            mothers, and fathers simple. Accessing all of the info in an iPhone app dash increases
                            overall
                            the web connectivity with the school. That brings better mastering outcomes for pupils.
                            Having
                            learning methods access on typically the software and process gives freedom to the
                            student to
                            find out anytime, anywhere together with their rate.</p>
                        <ul>
                            <li>Fee Management</li>
                            <li>Child's Activities Update</li>
                            <li>Daily Attendance Alerts</li>
                            <li>Subject Wise Homework Alerts</li>
                            <li>Class Tests & Exam Results Updates</li>
                            <li>School Events Updates</li>
                            <li>SMART E-Diary</li>
                            <li>Homework Alerts</li>
                            <li>School Activities Updates</li>
                            <li>Access School Photo Gallery</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- <section id="login_for_phone" class="visible-xs">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                aria-expanded="true" aria-controls="collapseOne">
                                <img src="<?php echo SITE_URL; ?>images/idsLoginIco1.webp" alt="admin_login">Admin Login
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                        aria-labelledby="headingOne">
                        <div class="panel-body">
                            <ul>
                                <li>Access to complete School/College management web control panel with all keyfeatures.
                                </li>
                                <li>Manage your group of institutes using smart phone touch screen from any location.
                                </li>
                                <li>Smart management of Students, Staff and Parents details with user friendly mode.
                                </li>
                                <li>Smart management of Students, Staff and Parents details with user friendly mode.
                                </li>
                                <li>Cloud based solution to manage your institute anytime from anywhere.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <img src="<?php echo SITE_URL; ?>images/idsLoginIco2.png" alt="admin_login"
                                    class="i_hide">Teachers Login
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <ul>
                                <li>Time to say bye-bye to paper registers...SMART roll call on mobile touch screen.
                                </li>
                                <li>Post/Assign homework to whole class on a single click in text or voice format.</li>
                                <li>Two way Smart Messaging with other staff members and parents...unlimited message
                                    size.</li>
                                <li>Efficient way to manage exam and exam results in Marks or Grade format.</li>
                                <li>Attendance, Result and Other reports at a single click...download or share via
                                    email..</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <img src="<?php echo SITE_URL; ?>images/idsLoginIco3.png" alt="admin_login"
                                    class="i_hide">Parents Login
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                        aria-labelledby="headingThree">
                        <div class="panel-body">
                            <ul>
                                <li>Real time update of child's activities within class & school campus on parents SMART
                                    Phone.</li>
                                <li>Daily attendance and subject wise homework alerts on mobile touch screen...Live.
                                </li>
                                <li>Follow the progress of your child by keeping track of class tests & exam results on
                                    a single click.</li>
                                <li>Stay tuned to important school events by using school calendar and photo gallery.
                                </li>
                                <li>Discuss with teachers using 2-way smart messaging, online fee payment & many more
                                    options.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFour">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                                <img src="<?php echo SITE_URL; ?>images/idsLoginIco4.png" alt="admin_login"
                                    class="i_hide">Student Login
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel"
                        aria-labelledby="headingFour">
                        <div class="panel-body">
                            <ul>
                                <li>Real time update of child's activities within class & school campus on parents SMART
                                    Phone.</li>
                                <li>Daily attendance and subject wise homework alerts on mobile touch screen...Live.
                                </li>
                                <li>Follow the progress of your child by keeping track of class tests & exam results on
                                    a single click.</li>
                                <li>Stay tuned to important school events by using school calendar and photo gallery.
                                </li>
                                <li>Discuss with teachers using 2-way smart messaging, online fee payment & many more
                                    options.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->


        <div class="what one ">
            <div class="container">
                <h1>What is School Management Software?</h1>
                <div class="row align-items-center">
                    <div class="col-md-7 boxfirst">
                        <div class="whats">
                            <p>
                                A school management software is a collection associated with computer instructions,
                                mainly designed to handle the day-to-day management tasks of colleges. School
                                management
                                software programs allow schools to monitor particular everyday activities digitally
                                and
                                manage all of the sources and information on one platform. In modern, nearly all the
                                colleges are utilizing school administration software to improve effectiveness and
                                productivity, so conserving a lot regarding the time involved to carry out different
                                administrative operations. These kinds of software also aid in reducing the pressure
                                of
                                handling massive data by schools.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="whats-2">
                            <img src="<?php echo SITE_URL; ?>images/chacck.png" class="img-fluid  " alt="admin_login">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="what">
            <div class="container">

                <div class="row align-items-center">
                    <div class="col-md-5 ">
                        <div class="whats-2">
                            <img src="<?php echo SITE_URL; ?>images/asd.png" class="img-fluid " alt="admin_login">
                        </div>
                    </div>

                    <div class="col-md-7 ">
                        <div class="whats">
                            <p>
                                From monitoring a student's attendance to creating aesthetic report credit cards
                                with a
                                solitary click, the school software, lets schools carry out many associated tasks
                                with
                                the special power software. Parents may easily manage their ward's functionality and
                                follow their academic requirements. The school management system has rightly
                                substituted
                                the traditional method regarding data management using pen and enrolls, thus
                                reducing
                                the likelihood of procedure mistakes. Furthermore, a great deal of expenditure plus
                                time
                                is stored, letting the college staff perform even more operate a reduced amount of
                                moment and so using higher accuracy.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="what last">
            <div class="container">

                <div class="row align-items-center">
                    <div class="col-md-7  ">
                        <div class="whats">
                            <p>
                                Although the whole administration technique runs efficiently, schools can offer
                                students
                                an even more effective and positive academic experience than ever before, providing
                                every scholar with an educative experience that is more tailored. IDS Prime's school
                                managing system is one such software that has been specially designed and produced
                                to
                                conform to every one of the requirements regarding different schools. That helps you
                                save time and funds and can help increase the productivity and productivity of your
                                respective workforce. High acceleration, security, and convenience of use are a
                                couple
                                of the features that will align with IDS Prime's school management software program.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-5 ">
                        <div class="whats-2">
                            <img src="<?php echo SITE_URL; ?>images/manyhands-2.png" class="img-fluid " alt="admin_login">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="call">
            <div class="container">
                <div class="actionmain">
                    <h3 class="actionheading hed">We Will Contact You, At a Time Which Suits You Best</h3>
                    <a href="https://www.idsprime.com/homes/contactus" class="demoside "> Request a Call Back
                        <div class="demosideShadow"></div>
                    </a>
                    <!-- <a class="action" href="https://www.idsprime.com/homes/contactus">
                <i class="bi bi-telephone"></i>  Request a Call Back
                </a> -->
                </div>
            </div>
        </div>

        <section id="faq">
            <div class="container ">
                <div class="faq_contant ">
                    <h1 class="heading_s ">Benefits Of iDS Prime's <span> School Management Software</span></h1>

                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    School Data Management
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p> This consists of files Management of all pupils teacher and oldsters, as
                                        this
                                        program ideal
                                        for fog up based system together with so there can be no restriction
                                        involving
                                        the
                                        particular device, spot or time. An individual can access that from
                                        anywhere,
                                        whenever, with
                                        any product. A few of them are- THE FRONT OFFICE-This includes all of the
                                        data
                                        accessibility
                                        related to the front office like grievance, calling, inquiry, and targeted
                                        visitor book.</p>


                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Homework plan management
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p> University ERP helps create swiftly multiple timetables together with
                                        homework
                                        which
                                        preserve a sufficient volume of administrative moment and effort. By School
                                        Administration
                                        Program, it is an uncomplicated task to take care of the Proxy period
                                        involving
                                        teachers,
                                        which preserves the time together with the measures of management staff.
                                        Creating a plan,
                                        assigning a proxy period, and managing teachers' timetable is incredibly
                                        easy
                                        with the
                                        Institute Management.</p>


                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Employee Management
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>This includes employee details and offers a new feature to generate a
                                        separate
                                        account for
                                        every single of those.</p>

                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Salary Management
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>This module manages just about all the wage-connected work for employees.
                                        Their
                                        deduction,
                                        benefit, and leave may be calculated with this automated system.</p>

                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    FEES Management
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>This manages most of the cost-relevant features like cost payment, Management
                                        regarding cost
                                        payment specifics, and provides payment tips to parents.</p>

                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingsix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesix" aria-expanded="false" aria-controls="collapsesix">
                                    Attendance Management
                                </button>
                            </h2>
                            <div id="collapsesix" class="accordion-collapse collapse" aria-labelledby="headingsix" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>This component manages all the particular students and educators' attendance
                                        and
                                        provides
                                        notice to</p>

                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingeight">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#eight" aria-expanded="false" aria-controls="eight">
                                    Report Management
                                </button>
                            </h2>
                            <div id="eight" class="accordion-collapse collapse" aria-labelledby="headingseven" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p> Parents about their kid occurrence and lack. It will always be an easy
                                        activity
                                        to keep
                                        review collection on this computer software.</p>

                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingnine">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nine" aria-expanded="false" aria-controls="nine">
                                    Library Management
                                </button>
                            </h2>
                            <div id="nine" class="accordion-collapse collapse" aria-labelledby="headingseven" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p> School Management software aims to give customers a new platform to further
                                        improve their
                                        student's literary expertise by designing a School Library Management
                                        instrument. The
                                        library enhances the communautaire creative imagination of learners,
                                        highlighting the
                                        library's perspective to generate the impression of changing instances that
                                        can
                                        be managed
                                        in an improved way utilizing the latest technology. School Library
                                        Management
                                        Program is a
                                        part of the Institute Management Program, which focuses on specific issues
                                        confronted by
                                        libraries plus its operating professionals/librarians.</p>

                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingten">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ten" aria-expanded="false" aria-controls="ten">
                                    Test Data Record
                                </button>
                            </h2>
                            <div id="ten" class="accordion-collapse collapse" aria-labelledby="headingseven" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Examination instances are the most popular for every school. School exam
                                        management software
                                        eases the process of examination operations in schools. Typically the
                                        examination management
                                        manages crucial businesses, just as defining class-wise assessment schemes,
                                        grading/passing
                                        standards, paper evaluation, and even final report card generation, and
                                        therefore forth and
                                        quickly simplifies the exam-related jobs of college. School management
                                        software
                                        is a robust,
                                        nicely comprehensive answer to automate, improve, and manage the particular
                                        exam-related
                                        activities of any school. Designed within the latest framework, the specific
                                        college
                                        examination method can be successfully performed in-house as correctly as
                                        online
                                        examinations in the institution.</p>

                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingeleven">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#eleven" aria-expanded="false" aria-controls="eleven">
                                    Public Relation Management
                                </button>
                            </h2>
                            <div id="eleven" class="accordion-collapse collapse" aria-labelledby="headingseven" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>PRM (Personal Relation Management) module provides access to complete.</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>





        <section id="whyIds">
            <div class="container">
                <h3>Why choose IDS Prime For Your <span>School Management Software</span> </h3>
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-6 mb-4">
                        <div class="whybox">
                            <img src="<?php echo SITE_URL; ?>images/w1.png" alt="icon">
                            <h4>Guaranteed Functioning</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-6 mb-4">
                        <div class="whybox">
                            <img src="<?php echo SITE_URL; ?>images/w2.png" alt="icon">
                            <h4>Certain Regular</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-6 mb-4">
                        <div class="whybox">
                            <img src="<?php echo SITE_URL; ?>images/w3.png" alt="icon">
                            <h4>Connection</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-6 mb-4">
                        <div class="whybox white">
                            <img src="<?php echo SITE_URL; ?>images/w4.png" alt="icon">
                            <h4>Completely Confidentiality Certain</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-6 mb-4 ">
                        <div class="whybox white">
                            <img src="<?php echo SITE_URL; ?>images/w5.png" alt="icon">
                            <h4>Most Economical, Remarkably</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-6 mb-4 ">
                        <div class="whybox">
                            <img src="<?php echo SITE_URL; ?>images/w6.png" alt="icon">
                            <h4>Progressive</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-6 mb-4">
                        <div class="whybox">
                            <img src="<?php echo SITE_URL; ?>images/w7.png" alt="icon">
                            <h4>Most Affordable Alternative</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-6 mb-4">
                        <div class="whybox">
                            <img src="<?php echo SITE_URL; ?>images/w8.png" alt="icon">
                            <h4>Maintenance</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <div class="call">
            <div class="container">
                <div class="actionmain">
                    <h3 class="actionheading hed">We Will Contact You, At a Time Which Suits You Best</h3>
                    <a href="https://www.idsprime.com/homes/contactus" class="demoside "> Request a Call Back
                        <div class="demosideShadow"></div>
                    </a>
                    <!-- <a class="action" href="https://www.idsprime.com/homes/contactus">
                <i class="bi bi-telephone"></i>  Request a Call Back
                </a> -->
                </div>
            </div>
        </div>



        <section id="deta-squrity">
            <div class="container">
                <div class="top">
                    <h4>Our Services
                    </h4>
                    <h5>
                        What We Offer
                    </h5>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-6 col-12 left wow fadeInLeft">
                        <div class="inr-contant gra-1">
                            <div class="icon-box">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <h5 class="hiro">SCHOOL MANAGEMENT SOFTWARE / SCHOOL ERP</h5>
                            <p class="seo">Comprehensive school managment software including 20+ modules, available
                                on
                                SaaS and
                                hosted on Google App Engine integrated with email & mobile SMS.</p>
                        </div>
                    </div>



                    <div class="col-md-4 col-sm-6 col-6 col-12">
                        <div class="inr-contant gra-2">
                            <div class="icon-box">
                                <i class="bi bi-phone"></i>

                            </div>
                            <h5 class="hiro">MOBILE APP FOR SCHOOL</h5>
                            <p class="seo">Personalised School Mobile App with login for Student, Parent, Teacher &
                                Management
                                giving realtime information and alerts for latest happening at the school.</p>
                        </div>
                    </div>


                    <div class="col-md-4 col-sm-6 col-6 col-12 right  wow fadeInRight">
                        <div class="inr-contant gra-3">
                            <div class="icon-box">

                                <i class="bi bi-gear"></i>
                            </div>
                            <h5 class="hiro ">SECURITY</h5>
                            <p class="seo ">iDS Prime is secured with database encryption and security tools which
                                means
                                your
                                school data is in secure hands.</p>
                        </div>
                    </div>





                    <div class="col-md-4 col-sm-6 col-6 col-12 left wow fadeInLeft">
                        <div class="inr-contant gra-4">
                            <div class="icon-box">
                                <i class="bi bi-pc-display-horizontal"></i>
                            </div>
                            <h5 class="hiro ">WEBSITE DESIGNING & PROMOTION</h5>
                            <p class="seo ">Dynamic School Website powered with properitory CMS for easy updation
                                including
                                pages, circulars, notices, image gallery, downloads, etc. with SEO and SMM services.
                            </p>
                        </div>
                    </div>


                    <div class="col-md-4 col-sm-6 col-6 col-12 ">
                        <div class="inr-contant gra-5">
                            <div class="icon-box">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <h5 class="hiro ">SCHOOL BRANDING</h5>
                            <p class="seo ">Enhanced Branding with designing and printing services including
                                prospectus,
                                flyers,
                                billboards, office stationary & promotional materials.</p>
                        </div>
                    </div>


                    <div class="col-md-4 col-sm-6 col-6 col-12">
                        <div class="inr-contant gra-6 right  wow fadeInRight">
                            <div class="icon-box">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <h5 class="hiro ">EASILY CUSTOMIZABLE</h5>
                            <p class="seo ">iDS Prime UI helps you easily customize the look and feel of the
                                application
                                with the
                                presentation of information to different user groups.</p>
                        </div>
                    </div>




                </div>
            </div>
        </section>

        <section id="client">
            <div class="container">

                <div class="row">
                    <div class="col-lg-offset-2 col-lg-8 col-md-offset-1 col-md-10 col-sm-offset-0 col-sm-12 col-xs-12 m-auto">
                        <div class="tg-sectionhead">
                            <div class="tg-sectiontitle">
                                <h3>Our Clients</h3>

                            </div>
                        </div>
                    </div>
                </div>


                <div id="clients_logos" class="owl-carousel owl-theme owl-loaded">
                    <div class="owl-item">
                        <a target="_blank" href="https://kidsclubschool.org/">
                            <img src="<?php echo SITE_URL; ?>images/client-iDS-Prime-1.jpg" alt="logo_client" class="img-responsive">
                        </a>
                    </div>
                    <div class="owl-item">
                        <a target="_blank" href="https://www.sanskarjaipur.com/">
                            <img src="<?php echo SITE_URL; ?>images/client-iDS-Prime-2.png" alt="logo_client" class="img-responsive">
                        </a>
                    </div>
                    <div class="owl-item">
                        <a target="_blank" href="https://www.thepalaceschool.com/">
                            <img src="<?php echo SITE_URL; ?>images/client-iDS-Prime-3.jpg" alt="logo_client" class="img-responsive">
                        </a>
                    </div>
                    <div class="owl-item">
                        <a target="_blank" href="https://gdmcmt.org/">
                            <img src="<?php echo SITE_URL; ?>images/client-iDS-Prime-4.jpg" alt="logo_client" class="img-responsive">
                        </a>
                    </div>
                    <div class="owl-item">
                        <a target="_blank" href="https://gdmcmt.org/">
                            <img src="<?php echo SITE_URL; ?>images/client-iDS-Prime-5.png" alt="logo_client" class="img-responsive">
                        </a>
                    </div>
                    <div class="owl-item">
                        <a target="_blank" href="http://www.gdwttc.org/">
                            <img src="<?php echo SITE_URL; ?>images/client-iDS-Prime-6.png" alt="logo_client" class="img-responsive">
                        </a>
                    </div>
                    <div class="owl-item">
                        <a target="_blank" href="https://luckyinstitute.org/">
                            <img src="<?php echo SITE_URL; ?>images/client-iDS-Prime-7.png" alt="logo_client" class="img-responsive">
                        </a>
                    </div>
                    <div class="owl-item">
                        <a target="_blank" href="https://www.sanskarjaipur.com/">
                            <img src="<?php echo SITE_URL; ?>images/client-iDS-Prime-8.png" alt="logo_client" class="img-responsive">
                        </a>
                    </div>
                </div>
            </div>
        </section>



        <!-- <div class="call">
            <a class="action" href="#">
                Call To Action
            </a>
        </div> -->


        <section id="why">
            <div class="container">
                <h1> Our Features </h1>

                <div class="row">
                    <div class="col-lg-3 col-md-4  ">
                        <div class="why-deta  blue">
                            <i class="bi bi-card-list"></i>
                            <h5>Admission Management</h5>
                        </div>


                    </div>

                    <div class="col-lg-3 col-md-4 ">
                        <div class="why-deta black ">
                            <img src="<?php echo SITE_URL; ?>images/new-1.png" alt="logo_client">
                            <h5>Student Management</h5>
                        </div>


                    </div>

                    <div class="col-lg-3 col-md-4 ">
                        <div class="why-deta yellow">
                            <img src="<?php echo SITE_URL; ?>images/new-2.png" alt="logo_client">
                            <h5>Homework / Timetable Entry</h5>
                        </div>


                    </div>

                    <div class="col-lg-3 col-md-4 ">
                        <div class="why-deta green">
                            <i class="bi bi-truck"></i>
                            <h5>Transport Detail Entry </h5>
                        </div>


                    </div>

                    <div class="col-lg-3 col-md-4 ">
                        <div class="why-deta red">
                            <i class="bi bi-cash"></i>
                            <h5>Fee Management </h5>
                        </div>


                    </div>

                    <div class="col-lg-3 col-md-4 ">
                        <div class="why-deta broun">
                            <i class="bi bi-newspaper"></i>
                            <h5>
                                Report Management
                            </h5>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-4 ">
                        <div class="why-deta blue">

                            <i class="bi bi-envelope"></i>
                            <h5>SMS Management</h5>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-4 ">
                        <div class="why-deta black">
                            <i class="bi bi-book"></i>
                            <h5>Library Management</h5>
                        </div>
                    </div>



                    <div class="col-lg-3 col-md-4 ">
                        <div class="why-deta yellow">
                            <i class="bi bi-cart4"></i>
                            <h5>
                                Store Management
                            </h5>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 ">
                        <div class="why-deta green">
                            <i class="bi bi-people-fill"></i>
                            <h5>
                                Manage Staff
                            </h5>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 ">
                        <div class="why-deta red">
                            <i class="bi bi-journal-richtext"></i>
                            <h5>
                                Exam Data Record
                            </h5>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 ">
                        <div class="why-deta broun">
                            <img src="<?php echo SITE_URL; ?>images/new-3.png" alt="logo_client">
                            <h5>
                                Attendance Management
                            </h5>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 ">
                        <div class="why-deta yellow">
                            <img src="<?php echo SITE_URL; ?>images/new-4.png" alt="logo_client">
                            <h5>
                                Public Relation Managment
                            </h5>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 ">
                        <div class="why-deta broun">
                            <i class="bi bi-wallet"></i>

                            <h5>
                                PayRoll Management
                            </h5>
                        </div>
                    </div>


                </div>
            </div>
        </section>

        <div class="play_store_link">
            <a target="_blank" href="https://play.google.com/store/apps/details?id=com.doomshell.idsprimelatest">
                <img src="<?php echo SITE_URL; ?>images/iDS-Prime-app-url.webp" alt="logo">
            </a>
        </div>


        <section id="contact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-offset-2 col-lg-8 col-md-offset-1 col-md-10 col-sm-offset-0 col-sm-12 col-xs-12 m-auto">
                        <div class="tg-sectionhead">
                            <div class="tg-sectiontitle">
                                <h3>Inquiry</h3>

                            </div>
                        </div>
                    </div>
                </div>

                <? echo $this->Form->create('Contact', array('url' => array('controller' => 'homes', 'action' => 'contact'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'form1', 'autocomplete' => 'off', 'required', 'validate')); ?>

                <div class="row contacts mb-3 ">
                    <div class="col-sm-4">
                        <input type="text" required="required" class="form-control" placeholder="Name" name="name" maxlength="60">
                    </div>
                    <div class="col-sm-4">
                        <input type="email" required="required" class="form-control" placeholder="Email id" name="email">
                    </div>
                    <div class="col-sm-4">
                        <input type="text" required="required" class="form-control telnumber" placeholder="Phone no." name="phone" maxlength="15">
                    </div>
                </div>

                <div class="row mb-3 contacts">
                    <div class="col-sm-4">
                        <input type="text" required="required" class="form-control" placeholder="School / Organization" maxlength="60" name="school">
                    </div>

                    <div class="col-sm-8">
                        <input type="text" required="required" class="form-control" placeholder="Address" maxlength="100" name="address">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-12">
                        <textarea class="form-control" required="required" maxlength="255" name="message" placeholder="Message"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <button type="submit" id="submitBtn" class="btn-default">Submit</button>
                    </div>
                    <div class="col-sm-4"></div>
                </div>
                </form>
                <script>
                    function myFunction() {
                        // Get the value of the input field with id="numb"
                        let x = document.getElementById("numb").value;
                        // If x is Not a Number or less than one or greater than 10
                        let text;
                        if (isNaN(x) || x < 1 || x > 10) {
                            text = "Input not valid";
                        } else {
                            text = "Input OK";
                        }
                        document.getElementById("demo").innerHTML = text;
                    }
                </script>

                <script>
                    function recaptchaCallback() {
                        $('#submitBtn').removeAttr('disabled');
                    }
                </script>
            </div>
        </section>

   
  
    <!--page-wrapper-->
    <!------min.js----------------->
    <script src="<?php echo SITE_URL; ?>js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <!--------------owl carousel-------------------------->
    <script src="<?php echo SITE_URL; ?>js/owl.carousel.min.js" type="text/javascript"></script>
    <!--------------bootstyrap-js-------------------------->
    <script src="<?php echo SITE_URL; ?>js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" type="text/javascript"> -->
    </script>
    <script src="<?php echo SITE_URL; ?>js/wow.min.js"></script>
    <script>
        $(function() {
            $('.telnumber').keyup(function() {
                if (/\D/g.test(this.value)) {
                    // Filter non-digits from input value.
                    this.value = this.value.replace(/\D/g, '');
                }
                var foo = $(this).val().split().join(""); // remove hyphens
                foo = foo.match(new RegExp('.{11}$|.{11}', 'g')).join();
                $(this).val(foo);
            });
        });
    </script>
    <script>
        wow = new WOW({
            animateClass: 'animated',
            offset: 100,
            mobile: false, // trigger animations on mobile devices (true is default)
            callback: function(box) {
                console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
            }
        });
        wow.init();
        document.getElementById('moar').onclick = function() {
            var section = document.createElement('section');
            section.className = 'section--purple wow fadeInDown';
            this.parentNode.insertBefore(section, this);
        };
    </script>

    <script>
        $('#clients_logos').owlCarousel({
            loop: true,
            autoplay: true,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 3,
                    nav: false
                },
                600: {
                    items: 4,
                    nav: false
                },
                1000: {
                    items: 5,
                    nav: false,
                    loop: false
                }
            }
        })
    </script>
    <!-------scripts_tab-------------------->
    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js">
    </script>

    <? if ($idspimrr) { ?>
        <script>
            $(function() {
                BootstrapDialog.alert({
                    size: BootstrapDialog.SIZE_SMALL,
                    title: "<img title='iDSPRIME' src='<?php echo SITE_URL; ?>img/favicon.ico' alt='Image' class='img-circle' height='26' width='26'> - Notification",
                    message: '<h5>We have successfully received your inquiry and will respond to you shortly! Thank you!</h5>'
                });
            });
        </script>
    <? } ?>
    <script>
        function recaptchaCallback() {
            $('#submitBtn').removeAttr('disabled');
        };
    </script>

    <!-- School -->
    <script type="text/javascript">
        function isCspecial(e) {
            var e = e || window.event;
            var k = e.which || e.keyCode;
            var s = String.fromCharCode(k);
            if (/^[\\\"\'\;\:\>\<\[\]\-\.\,\/\?\=\+\_\|~`!@#\$%^&*\(\)0-9]$/i.test(s)) {
                alert("Special characters not acceptable");
                return false;
            }
        }
    </script>
    <script>
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            dots: false,
            nav: true,
            smartSpeed: 2000,
            autoplayTimeout: 7000,
            mouseDrag: true,
            autoplay: true,
            animateOut: 'slideOutUp',
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    </script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

</body>

</html>