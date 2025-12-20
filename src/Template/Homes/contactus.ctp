<!DOCTYPE html>
<html lang="en">
<style>
.wrap-contact100 .logo {
    display: block;
    text-align: center;
}

.wrap-contact100 .logo img {
    width: 180px;
}

.wrap-contact100 li {
    padding: 10px 0px;
}

.wrap-contact100 li img {
    width: 18px;
    display: inline-block;
    vertical-align: top;
}
</style>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <?php 
        // Program to display URL of current page. 
        //pr($_SERVER);
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
            $link = "https"; 
        else
            $link = "http"; 
        // Here append the common URL characters. 
        $link .= "://"; 
        // Append the host(domain name, ip) to the URL. 
        $link .= $_SERVER['HTTP_HOST'];
        $link .= $_SERVER['REQUEST_URI'];
        $met=$this->Comman->meta($link);
        $met2=$this->Comman->meta("https://www.idsprime.com/");
        if($met['title']!="")
    { ?>
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
    <meta property="og:description" name="description" content="<?php echo $met['description'];?>" />
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
    <meta property="twitter:description" content="<?php echo $met['description'];?>">
    <meta property="twitter:image" content="<?php echo SITE_URL; ?>images/idsprime-logo.webp">
    <!-- FB Admins -->
    <meta name="fb:admins" content="">
    <meta name="google-site-verification" content="" />
    <meta name="p:domain_verify" content="" />
    <meta name="yandex-verification" content="" />
    <title><?php echo $met['title']; ?></title>
    <meta name="keywords" content="<?php echo $met['keyword'];?>" />
    <meta name="description" content="<?php echo $met['description'];?>" />
    <?php }else{ ?>
    <title><?php echo $met2['title']; ?></title>
    <meta name="keywords" content="<?php echo $met2['keyword'];?>" />
    <meta name="description" content="<?php echo $met2['description'];?>" />
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
    <!-- <link href="<?php //echo SITE_URL; ?>css/all.min.css" rel="stylesheet" type="text/css"> -->
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
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
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


    <div id="contactus">
        <div class="container">
            <h1>
                Contact Us
            </h1>
            <div class="row">
                <div class="col-md-6 ">
                    <div class="formdeta">
                        <div class="inner">
                            <ul>
                                <li>
                                    <img src="<?php echo SITE_URL; ?>images/con-mail.png"
                                        alt="idsPrime-logo">contact@doomshell.com
                                </li>
                                <li>
                                    <img src="<?php echo SITE_URL; ?>images/con-call.png" alt="idsPrime-logo">9829732221
                                </li>
                                <li>
                                    <img src="<?php echo SITE_URL; ?>images/con-sky.png" alt="idsPrime-logo">doomshell
                                </li>
                            </ul>
                            <!-- <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3557.398893087682!2d75.73368295074125!3d26.92256598304059!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396db35d15187661%3A0x62b29d09fa72ed4!2sSanskar+School!5e0!3m2!1sen!2sin!4v1566546151890!5m2!1sen!2sin"
                                width="100%" height="300px" frameborder="0" style="border:0" allowfullscreen></iframe> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="formcontant">
                        <form>
                            <input type="text" placeholder="Name" class="form-control " />
                            <input type="email" placeholder="Email" class="form-control " />
                            <input type="text" placeholder="Phone No." class="form-control" />
                            <textarea class="form-control " placeholder="Message"></textarea>


                            <button>Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <form method="post" action="process.php"> -->












    <!-- <div class="container-contact100">
        <div class="row no-gutters w-100 vh-100">
            <div class="col-5">

                <div class="wrap-contact100">
                    <a href="#" class="logo">
                        <img src="images/logo.png" alt="logo">
                    </a>
                    <hr>

                    <br>
                    <form class="contact100-form validate-form">
                        <span class="contact100-form-title" style="font-size:22px">
                            Please feel free to contact us if any assistance is needed in the future.

                        </span>
                    </form>

                    <ul>
                        <li>
                            <img src="images/ic_email.svg"> <span>contact@doomshell.com</span>
                        </li>

                        <li>
                            <img src="images/ic_phone.svg"> <span>(+91) 9829732221</span>
                        </li>

                        <li>
                            <img src="images/skype-logo.svg"> <span>doomshell</span>
                        </li>
                    </ul>

                </div>


            </div>





            <div class="col-7">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3557.398893087682!2d75.73368295074125!3d26.92256598304059!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396db35d15187661%3A0x62b29d09fa72ed4!2sSanskar+School!5e0!3m2!1sen!2sin!4v1566546151890!5m2!1sen!2sin"
                    width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>



        <div id="dropDownSelect1"></div> -->

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
            <-- row 
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
                    <p>© <?php // $date =DATE('Y'); echo $date;  ?> <a href="http://doomshell.com/">doomshell.com</a>.
                        | All Rights Reserved.</p>
                </div>
                <div class="col-md-2 col-xs-12">

                </div>
            </div>
        </div>
    </div> -->
    </div>

    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://www.idsprime.com/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <!-- integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"> -->
    </script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBb3j8Aiv60CadZ_wJS_5wg2KBO6081a_k"></script>

    <!-- <script src="vendor/js/map-custom.js"></script> -->
    <!--===============================================================================================-->
    <script src="vendor/js/main.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
    </script>

</body>

</html>