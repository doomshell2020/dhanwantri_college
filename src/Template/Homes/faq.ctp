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

    <link href="<?php echo SITE_URL; ?>css/style2.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SITE_URL; ?>css/responsive2.css" rel="stylesheet" type="text/css">
    <?= $this->element('scriptheader') ?>
</head>



<style>
    #faq {
        background: #fff;
        padding: 50px 0px;
    }

    #faq .faq_contant {
        text-align: left;
        padding: 20px 15px;
        margin-bottom: 5px;
    }

    #faq .faq_contant ul li {
        list-style: none;
    }

    #faq .faq_contant .heading_s {
        margin-bottom: 10px;
        color: #000;
        text-align: center;
        font-weight: 800;
        margin-bottom: 12px;
    }

    #faq .faq_contant h6 {
        font-size: 20px;
        margin-bottom: 30px;
    }

    #faq .faq_contant ul i {
        color: #d33ea8;
        margin-right: 10px;
        font-size: 15px;
    }

    #faq_sidebar .Feedback_bg .form-control {
        border: none;
        border-radius: 0rem;
        padding: 5px 10px;
        background-color: #f9fbfc;
        height: auto;
        font-size: 13px;
    }

    #faq_sidebar .Feedback_bg .form-control:hover {
        background-color: #ffffff;
    }

    #faq_sidebar .Feedback_bg .form-control:focus {
        box-shadow: none;
    }

    #faq_sidebar .Feedback_bg .btn-primary {
        background-color: #e35302;
        border: none;
        padding: 6px 25px;
        display: block;
        outline: none;
        width: 100%;
        transition: .5s;
        -moz-transition: .5s;
        -o-transition: .5s;
        -webkit-transition: .5s;
    }

    #faq_sidebar .Feedback_bg .btn-primary:focus {
        outline: none;
        box-shadow: none;
    }

    #faq_sidebar .Feedback_bg .btn-primary:hover {
        background-color: #c94800;
    }

    #faq .faq_contant .accordion-button:focus {
        outline: none;
        box-shadow: none
    }

    #faq .faq_contant .accordion-body {
        padding: 1rem 1.25rem;
        background: #f8fbff;
        font-size: 15px;
        color: #777777;
    }

    #faq_sidebar .Feedback_bg p {
        font-size: 15px;
        margin-top: 16px;
    }

    #faq_sidebar .Feedback_bg h5 {
        font-size: 15px;
        font-weight: 400;
        margin-top: 25px;
    }

    #faq_sidebar .Feedback_bg a {
        font-size: 15px;
        color: #c94800;
    }

    #faq .faq_contant ul li i {
        list-style: none;
        color: #e35302;
        font-weight: 900;
        font-size: 8px;
        margin-bottom: 4px;
        margin-right: 5px;
        margin-top: 7px;
    }

    #faq .faq_contant ul li i {
        color: #d33ea8;
        margin-right: 10px;
        font-size: 15px;
    }

    #faq .faq_contant ul {
        padding-left: 0px;
    }

    .accordion.accordion-flush {
        padding: 30px 0px;
    }

    #faq .accordion-button:not(.collapsed) {
        color: #fff;
        background-color: #673de6;
        font-weight: 500;
    }

    #faq .helite_pb {
        font-weight: 600;
        color: #5d5d5d;
    }
</style>

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
        <section id="faq">
            <div class="container ">
                <div class="faq_contant ">
                    <div class="nav-item" style="display: flex; justify-content: flex-end;">
                        <form action="<?php echo SITE_URL; ?>homes/faq" method="get">
                            <select class="form-select" name="id" onchange="this.form.submit()">
                                <option selected disabled>Select Category</option>
                                <?php foreach ($result as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </form>
                    </div>
                    <h1 class="heading_s ">FAQs</h1>
                    <div class="accordion" id="accordionExample">
                        <?php /*
                        foreach ($faq_data as $val) {  ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <?php echo $val['faq_question']; ?>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p><?php echo $val['faq_answer']; ?></p>

                                    </div>
                                </div>
                            </div>
                        <?php   } */?>

                       <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Does your company provide training?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Yes, we do. The initial setup of all new customers includes training. You can
                                        complete this on campus or remotely. Moreover, custom training can be provided
                                        as needed. We also provide periodic online training sessions at no additional
                                        charge to our customers.</p>

                                </div>
                            </div>
                        </div> 


                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Does it support a large number of students?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>
                                        Currently, we cannot estimate, but based on our experience, it supports 5000
                                        student records since IDS Prime works well with one of our clients after 5000
                                        records. As it is SQL Server 2008, the database won't crash technically.</p>



                                </div>
                            </div>
                        </div>


                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    How long does the student information last?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>You can access it easily, yes. A student's history can be viewed from the moment
                                        they join to the moment they leave.</p>

                                </div>
                            </div>
                        </div>


                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    What is the number of computers that support IDS Prime school management software?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>IDS Prime is a Client-Server Application where schools can have one Server and
                                        several Clients where they can access the server.</p>

                                </div>
                            </div>
                        </div>



                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Is the school management software equipped with a data backup facility?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>There is also a data backup facility for IDS Prime school management software.
                                        There is no difficulty in retrieving the customer's data.</p>

                                </div>
                            </div>
                        </div>


                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingsix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesix" aria-expanded="false" aria-controls="collapsesix">

                                    Does this software provide accounting functionality?
                                </button>
                            </h2>
                            <div id="collapsesix" class="accordion-collapse collapse" aria-labelledby="headingsix" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>
                                        Yes, of course. Accounting is a very strong part of our software since schools
                                        can manage their routines and export the data directly to Tally for further
                                        processing.</p>

                                </div>
                            </div>
                        </div>


                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingseven">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">
                                    Do you have a particular school or company logo displayed in this software?
                                </button>
                            </h2>
                            <div id="collapseseven" class="accordion-collapse collapse" aria-labelledby="headingseven" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>The school management software allows schools to upload their logos and names.
                                        With the Home screen of the IDS Prime software, they can even upload their
                                        school picture. We prefer to replace our Brand Logo and Name with the name that
                                        Distributors require after deciding the terms and conditions.</p>

                                </div>
                            </div>
                        </div>


                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingeight">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseeight" aria-expanded="false" aria-controls="collapseeight">
                                    What kind of support services do you provide?
                                </button>
                            </h2>
                            <div id="collapseeight" class="accordion-collapse collapse" aria-labelledby="headingeight" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>

                                        You can contact us at any time if you need support. We are also available to
                                        answer any questions you may have and assist with implementation. Our clients
                                        can reach us by email, chat, phone, personal visit, or Skype.</p>

                                </div>
                            </div>
                        </div>






                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingten">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseten" aria-expanded="false" aria-controls="collapseten">
                                    How Does Parent Portal Benefit Students and Schools?
                                </button>
                            </h2>
                            <div id="collapseten" class="accordion-collapse collapse" aria-labelledby="headingten" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>

                                        The Parent Portal allows parents and guardians to check student information,
                                        results, attendance, upcoming
                                        events, and extracurricular accounts from home, office, or any location. A
                                        real-time link in today's 24/7
                                        world enhances the school's standing with parents.</p>

                                </div>
                            </div>
                        </div>


                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingeleven">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseeleven" aria-expanded="false" aria-controls="collapseeleven">
                                    Is it possible to create the school's website with IDS Prime?
                                </button>
                            </h2>
                            <div id="collapseeleven" class="accordion-collapse collapse" aria-labelledby="headingeleven" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>

                                        The school's website can be designed and hosted by IDS Prime with a responsive
                                        design and a parent portal
                                        that parents can easily access.</p>

                                </div>
                            </div>
                        </div>



                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingtharteen">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetharteen" aria-expanded="false" aria-controls="collapsetharteen">
                                    What should we do now that we have many unanswered questions?
                                </button>
                            </h2>
                            <div id="collapsetharteen" class="accordion-collapse collapse" aria-labelledby="headingtharteen" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>


                                        We can answer your questions via email at seo@doomshell.com or by phone (
                                        8764122221) or visit your school
                                        to clarify everything for you.</p>

                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </section>
        <!-- 
        <footer id="footer">
            <div class="container">
                <div class="tg-sectiontitle text-center">
                    <h2> Demo Application Link</h2>

                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4 wow fadeInLeft">
                        <div class="footBx">
                            <h4>ADMIN</h4>
                            <ul>
                                <li>Username: admin@idsprime.com</li>
                                <li>Password: 12345</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 wow bounceInDown">
                        <div class="footBx">
                            <h4>EMPLOYEE</h4>
                            <ul>
                                <li>Username: teacher@idsprime.com</li>
                                <li>Password: 12345</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 wow fadeInRight">
                        <div class="footBx">
                            <h4>PARENT APP</h4>
                            <ul>
                                <li>Username: S12002</li>
                                <li>Password: 12345</li>
                            </ul>
                        </div>
                    </div>
                </div>
          
                <div class="text-center demoAppLinkDv">
                    <a href="http://demo.idsprime.com/" class="siteBtn" target="_blank">Demo Application Link</a>
                </div>
          
            </div>
        </footer> -->

        <!-- <div class="f_bar">
            <div class="container">
                <div class="row">
                    <div class="col-md-2 col-xs-12"></div>
                    <div class="col-md-8 col-xs-12">
                        <p>© <?php $date = DATE('Y');
                                echo $date;  ?> <a href="http://doomshell.com/">doomshell.com</a>.
                            | All Rights Reserved.</p>
                    </div>
                    <div class="col-md-2 col-xs-12">

                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <!--page-wrapper-->
    <!------min.js----------------->
    <script src="<?php echo SITE_URL; ?>js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <!--------------owl carousel-------------------------->
    <script src="<?php echo SITE_URL; ?>js/owl.carousel.min.js" type="text/javascript"></script>
    <!--------------bootstyrap-js-------------------------->
    <script src="<?php echo SITE_URL; ?>js/bootstrap.bundle.min.js" type="text/javascript"></script>
    </script>
    <script src="<?php echo SITE_URL; ?>js/wow.min.js"></script>

</body>

</html>