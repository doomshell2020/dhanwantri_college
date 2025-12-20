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
<style>
#deta-squrity {
    padding-bottom: 0px;
    background-color: #ffffff;
    padding: 13px 0px;
}

#deta-squrity .top {
    text-align: center;
    padding: 10px 72px;
    margin-bottom: 50px;
}

#deta-squrity .top h4 {
    font-size: 46px;
    font-weight: 900;
    color: #333;
}

#deta-squrity .top h4 span {
    color: #333;
    display: 700;
    padding: 10px 0px;
}

#deta-squrity .top p {
    font-size: 14px;
}

#deta-squrity .inr-contant {
    padding: 20px 16px;
    text-align: center;
    background: #fff;
    margin-bottom: 60px;
    background-color: #f0aa00;
    border-radius: 8px;
    transition: all.5s ease-in-out;
}

#deta-squrity .inr-contant:hover {
    transform: scale(1.05);

}

#deta-squrity .inr-contant .icon-box img {
    width: 52px;
}

#deta-squrity .inr-contant.red {
    background-color: #ff002a;
}

#deta-squrity .inr-contant.blue {
    background-color: #003d69;
}

#deta-squrity .inr-contant.sky {
    background-color: #3db2d5;
}

#deta-squrity .inr-contant.blak {
    background-color: #3ab64c;
}

#deta-squrity .inr-contant.sleti {
    background-color: #dd1146;
}

#deta-squrity .inr-contant.narangi {
    background-color: #56225e;
}

#deta-squrity .inr-contant.color {
    background-color: #f0aa00;
}

#deta-squrity .inr-contant.bengni {
    background-color: #cd2e80;
}

#deta-squrity .inr-contant.pink {
    background-color: #ff6d51;
}

#deta-squrity .inr-contant.orenge {
    background-color: #043947;
}

#deta-squrity .inr-contant.broun {
    background-color: #504e4e;
}

#deta-squrity .inr-contant.mehroon {
    background-color: #4b8e9f;
}

#deta-squrity .inr-contant.dark {
    background-color: #c86969;
}

#deta-squrity .inr-contant.dark-blue {
    background-color: #008cc9;
}

#deta-squrity .inr-contant.cloud {
    background-color: #2d5c5b;
}

#deta-squrity .inr-contant.myan {
    background-color: #463636;
}

#deta-squrity .inr-contant.siyan {
    background-color: #919191;
}

#deta-squrity .inr-contant.gray {
    background-color: #358f47;
}

#deta-squrity .inr-contant.light {
    background-color: #702a2a;
}

#deta-squrity .inr-contant.one {
    background-color: #a5a52a;
}

#deta-squrity .inr-contant.two {
    background-color: #444b91;
}

#deta-squrity .inr-contant.three {
    background-color: #b373ac;
}

#deta-squrity .inr-contant.four {
    background-color: #db4c9e;
}

#deta-squrity .inr-contant.five {
    background-color: #fb5050;
}

#deta-squrity .inr-contant.six {
    background-color: #499391;
}

#deta-squrity .inr-contant .icon-box {

    padding: 10px;
    /* border: 1px solid black; */
    width: 100px;
    height: 100px;
    margin: auto;
    border-radius: 50px;
    margin-top: -63px;
    background-color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
}

#deta-squrity .inr-contant .hiro {
    font-size: 18px;
    font-weight: 500;
    margin-top: 25px;
    color: #fff;
    font-weight: bold;
    min-height: 40px;
}

#deta-squrity .inr-contant .seo {
    font-size: 15px;
    color: #fff;
    text-align: justify;
    min-height: 247px;
    text-align-last: center;
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
                    <h4>Data Security
                    </h4>
                    <h5 class="text-center">
                        We are committed to protecting our clients data.
                    </h5>
                    <p>
                        It is important that consumers protect their data, but don&#39;t worry. Your data is safe with
                        us.
                        Our company fully respects each institute s privacy and security in the www age; we
                        understand the importance of data security in today s world. With IDS Prime cloud, you are
                        protected with high-quality SSL. In an encrypted format, SSL stores and communicates
                        securities data. SSL protects the data of millions of people every day on the Internet,
                        especially during online transactions or when sending confidential information.
                    </p>

                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="inr-contant blak">
                            <div class="icon-box">
                                <img class="img-fluid" src="<?php echo SITE_URL; ?>images/data-1.png" alt="img">
                            </div>
                            <h5 class="hiro">Data Protection</h5>
                            <p class="seo">IDS Prime uses 256-bit AES encryption and SSL security for all data it
                                stores. New enhancements and updates will be added from time to time to
                                strengthen data security further. Our clients information is completely secure
                                and safe.</p>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="inr-contant sky ">
                            <div class="icon-box">
                                <img class="img-fluid" src="<?php echo SITE_URL; ?>images/data-2.png" alt="img">
                            </div>
                            <h5 class="hiro ">Secure Access</h5>
                            <p class="seo ">Each user type has a unique ID and password for accessing IDS Prime
                                instances. A director,
                                administrator, teacher, parent, or student can only access their own accounts.</p>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 narangi">
                        <div class="inr-contant black-2 ">
                            <div class="icon-box">
                                <img class="img-fluid" src="<?php echo SITE_URL; ?>images/data-3.png" alt="img">
                            </div>
                            <h5 class="hiro ">Data Recovery</h5>
                            <p class="seo ">IDS Prime cloud storage ensures clients&#39; data is always available with
                                multiple redundancies and
                                disaster recovery processes. To ensure efficient &amp; quick data recovery, our team
                                regularly backs up
                                data</p>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="inr-contant orenge">
                            <div class="icon-box">
                                <img class="img-fluid" src="<?php echo SITE_URL; ?>images/data-4.png" alt="img">
                            </div>
                            <h5 class="hiro ">Integrations</h5>
                            <p class="seo ">IDS Prime can integrate various third-party software and hardware solutions,
                                such as applications and
                                RFIDs. Every integration ensures data privacy and security with 3rd party vendors.</p>
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
<!-- 
        <div class="f_bar">
            <div class="container">
                <div class="row">
                    <div class="col-md-2 col-xs-12"></div>
                    <div class="col-md-8 col-xs-12">
                        <p>© <?php// $date =DATE('Y'); echo $date;  ?> <a href="http://doomshell.com/">doomshell.com</a>.
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