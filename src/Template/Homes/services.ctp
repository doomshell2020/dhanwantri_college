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
<!-- <style>
#partner {
    padding: 0px 0px;
    padding: 60px 0px;
    background-color: #f2f1f1;
}

#partner h1 {
    font-size: 58px;
    margin-bottom: 6px;
}


#partner h3 {
    font-size: 28px;
    text-align: center;
    color: #000;
    margin-bottom: 15px;
}

#partner .top-heading {
    color: #000;
    font-size: 15px;
}


#partner .contants p {
    font-size: 21px;
    text-align: left;
    color: #006b91;
    color: #fff;
}

#partner .contants {
    padding: 33px 38px;

    background: linear-gradient(to right, #098dbf 0%, #035e78 100%);
    min-height: 349px;
}

#partner .contants ul li {
    list-style: none;
    margin-top: 12px;
    display: flex;
    align-items: center;
    color: #fff
}

#partner .contants.deta {
    background: linear-gradient(to right, #789d2f, #809b00);
}

#partner .contants ul {
    margin: 0px;
    padding: 0px;
}

#partner .contants ul li img {
    width: 18px;
    margin-right: 8px;
}

#partner .contants.deta p {
    margin-bottom: 10px;
}

div#wpcs_tab_35465 {
    border: 1px solid #ffffff;
    border-bottom: none;
    cursor: pointer;
    width: 170px;
    height: 34px;
    overflow: hidden;
    background: #ee5d21;
    color: #ffffff;
    padding: 2px 0px 2px 0px;
    position: fixed;
    top: 200px;
    right: -68px;
    text-align: center;
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    -ms-transform: rotate(-90deg);
    -o-transform: rotate(-90deg);
    transform: rotate(-90deg);
    z-index: 9999999;
    font-size: 18px;
}

div#wpcs_tab_35465 {
    background-image: url(https://www.skolaro.com/wp-content/uploads/2022/05/ezgif-3-501ec35579.gif) !important;
}
</style> -->

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


        <!-- <footer id="footer">
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
        </footer>

        <div class="f_bar">
            <div class="container">
                <div class="row">
                    <div class="col-md-2 col-xs-12"></div>
                    <div class="col-md-8 col-xs-12">
                        <p>© <?php //$date = DATE('Y');
                               // echo $date;  ?> <a href="http://doomshell.com/">doomshell.com</a>.
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