<!DOCTYPE html>
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
#why-choose {
    padding-bottom: 0px;
    background-color: #ffffff;
    padding: 13px 0px;
}

#why-choose .top {
    text-align: center;
    padding: 10px 72px;
    margin-bottom: 50px;
}

#why-choose .top h4 {
    font-size: 46px;
    font-weight: 900;
    color: #333;
}

#why-choose .top h4 span {
    color: #333;
    display: 700;
    padding: 10px 0px;
}

#why-choose .top p {
    font-size: 18px;
}

#why-choose .inr-contant {
    padding: 20px 16px;
    text-align: center;
    background: #fff;
    margin-bottom: 60px;
    background-color: #f0aa00;
    border-radius: 8px;
    transition: all.5s ease-in-out;
}

#why-choose .inr-contant:hover {
    transform: scale(1.05);

}

#why-choose .inr-contant .icon-box img {
    width: 52px;
}

#why-choose .inr-contant.red {
    background-color: #ff002a;
}

#why-choose .inr-contant.blue {
    background-color: #003d69;
}

#why-choose .inr-contant.sky {
    background-color: #3db2d5;
}

#why-choose .inr-contant.blak {
    background-color: #3ab64c;
}

#why-choose .inr-contant.sleti {
    background-color: #dd1146;
}

#why-choose .inr-contant.narangi {
    background-color: #56225e;
}

#why-choose .inr-contant.color {
    background-color: #f0aa00;
}

#why-choose .inr-contant.bengni {
    background-color: #cd2e80;
}

#why-choose .inr-contant.pink {
    background-color: #ff6d51;
}

#why-choose .inr-contant.orenge {
    background-color: #043947;
}

#why-choose .inr-contant.broun {
    background-color: #504e4e;
}

#why-choose .inr-contant.mehroon {
    background-color: #4b8e9f;
}

#why-choose .inr-contant.dark {
    background-color: #c86969;
}

#why-choose .inr-contant.dark-blue {
    background-color: #008cc9;
}

#why-choose .inr-contant.cloud {
    background-color: #2d5c5b;
}

#why-choose .inr-contant.myan {
    background-color: #463636;
}

#why-choose .inr-contant.siyan {
    background-color: #919191;
}

#why-choose .inr-contant.gray {
    background-color: #358f47;
}

#why-choose .inr-contant.light {
    background-color: #702a2a;
}

#why-choose .inr-contant.one {
    background-color: #a5a52a;
}

#why-choose .inr-contant.two {
    background-color: #444b91;
}

#why-choose .inr-contant.three {
    background-color: #b373ac;
}

#why-choose .inr-contant.four {
    background-color: #db4c9e;
}

#why-choose .inr-contant.five {
    background-color: #fb5050;
}

#why-choose .inr-contant.six {
    background-color: #499391;
}

#why-choose .inr-contant .icon-box {

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

#why-choose .inr-contant .hiro {
    font-size: 18px;
    font-weight: 500;
    margin-top: 25px;
    color: #fff;
    font-weight: bold;
    min-height: 40px;
}

#why-choose .inr-contant .seo {
    font-size: 15px;
    color: #fff;
    text-align: justify;
    min-height: 247px;
    text-align-last: center;
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

    <!-- <div id="why-slider">
        <div class="slider-img">
            <img src="<?php echo SITE_URL; ?>images/borivali-slider-one.jpg" alt="img"> 
    </div>
    </div>-->



    <section id="why-choose">
        <div class="container">
            <div class="top">
                <h4>Why Choose IDS Prime as your School management System?
                </h4>
                <p>The top reasons why IDS Prime is the preferred cloud-based school management system
                </p>
            </div>
            <div class="row">
                <div class=" col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant blak">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-1.png" alt="img">
                        </div>
                        <h5 class="hiro">Friendly to users</h5>
                        <p class="seo">A well-designed and intuitive GUI interface is available for bothweb and mobile
                            applications. Staff members and parents ho arecomputer novices can easily use it.
                            User-friendly features withself-explanatory options.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant red">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-2.png" alt="img">
                        </div>
                        <h5 class="hiro">It's easy to use</h5>
                        <p class="seo">No installation is required with IDS Prime School Management System. Interactive
                            web and mobile application that enhancesuser experience for each user. According to our
                            users, our ERPis more user-friendly than traditional systems based ERPs.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant blue">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-3.png" alt="img">
                        </div>
                        <h5 class="hiro ">Efficient & Productive</h5>
                        <p class="seo ">By saving their time from non-valued activities, IDS Prime School Management
                            System makes school staff and parents more productive and effective. By doing so, resources
                            are used to their full potential.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant sky ">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-4.png" alt="img">
                        </div>
                        <h5 class="hiro ">Priced affordably</h5>
                        <p class="seo ">The IDS Prime School Management System platform is designed to meet the needs of
                            academic institutions of all sizes. In accordance with institute requirements, we are
                            offering it at an affordable price. Payment is based on the amount of usage.Depending on
                            your needs, we have economical packages available.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 narangi">
                    <div class="inr-contant black-2 ">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-5.png" alt="img">
                        </div>
                        <h5 class="hiro ">Based on the web</h5>
                        <p class="seo ">The web browser can be used to access it. Utilizing web-based applications to
                            enhance productivity &amp; efficiency is one of the best ways to take advantage of todays
                            technology. This eliminates the need to build separate IT infrastructure by subscribing to
                            expensive system based ERPs.</p>
                    </div>
                </div>
                <div class=" col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant orenge">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-6.png" alt="img">
                        </div>
                        <h5 class="hiro ">Based on mobile devices</h5>
                        <p class="seo ">With competent mobile apps, you have all the information about your student /
                            school in your pocket - literally! It provides a better option than simply swiping on your
                            phone to access school anywhere, anytime.  A smart and compact way to access information,
                            with intelligent features for a smooth experience.</p>
                    </div>
                </div>
                <div class=" col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant bengni">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-7.png" alt="img">
                        </div>
                        <h5 class="hiro ">Cloud Based</h5>
                        <p class="seo ">With the use of cloud technology, IDS Prime School Management System is able to
                            store and access data and applications on the Internet rather than on your computers hard
                            drive. This allows staff members and parents to have access to student information. Whenever
                            and wherever you want, 24 hours a day.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant sleti">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-8.png" alt="img">
                        </div>
                        <h5 class="hiro ">Easily customizable</h5>
                        <p class="seo ">We can help you customize School Management System if the standard version does
                            not meet your needs. You can contact our experts for help with additional features. You can
                            always count on us.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant broun">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-9.png" alt="img">
                        </div>
                        <h5 class="hiro ">Access is secure</h5>
                        <p class="seo ">Students, parents, staff, and administrators can access the secure portal with
                            their unique ID and password. A user's access to systems is granted on a per-user basis, and
                            only those features that are permitted will be displayed.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant pink">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-10.png" alt="img">
                        </div>
                        <h5 class="hiro ">SSL Security</h5>
                        <p class="seo ">You can rest assured that your data is completely protected by SSL (Secure
                            Socket Layer) encryption at IDS Prime School Management System. You can rest assured that
                            all important information and data are well protected. You can rest assured that it will not
                            be stolen. We are truly concerned about you.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant mehroon">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-11.png" alt="img">
                        </div>
                        <h5 class="hiro ">Data Backup</h5>
                        <p class="seo ">Cloud technology is at the heart of IDS Prime School Management System. You dont
                            have to worry about a crash, a breakdown, or a theft if your hard drive or computer fails.
                            You always have access to your complete data in the cloud, and you
                            can log in from any computer.</p>
                    </div>
                </div>
                <div class=" col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant dark">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-12.png" alt="img">
                        </div>
                        <h5 class="hiro ">Data Privacy</h5>
                        <p class="seo ">The data of school staff, parents, and students at IDS Prime School Management
                            System is protected and is not shared. Staff, parents, and students cannot access one
                            anothers accounts without knowing their unique IDs and passwords. Privacy is fully
                            respected.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant light">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-13.png" alt="img">
                        </div>
                        <h5 class="hiro ">Management of multi-institutions.</h5>
                        <p class="seo ">You can use IDS Prime as a chairman/director if you manage a chain of schools.
                            Mobile app or computer access to all school and college information anywhere, anytime.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant gray">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-14.png" alt="img">
                        </div>
                        <h5 class="hiro ">Login for school staff</h5>
                        <p class="seo ">For school staff members, IDS Prime School Management ystem provides a variety
                            of login options based on their roles and responsibilities, e.g. administrator login,
                            teacher login, transport officer login, etc. Those features will only be displayed to a
                            staff member with permission to access them.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant siyan">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-15.png" alt="img">
                        </div>
                        <h5 class="hiro ">Parents Login</h5>
                        <p class="seo ">With IDS Prime dedicated parents login, parents will be able to stay involved in
                            their childs development and school activities. Parents can stay updated on attendance,
                            homework, results, etc. with a mobile app.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant myan">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-16.png" alt="img">
                        </div>
                        <h5 class="hiro ">Student Login</h5>
                        <p class="seo ">By using the IDS Prime web or mobile app, students can keep track of their
                            homework and class performance from anywhere. There is no longer a problem with students
                            missing school for any reason, but they cannot miss their classwork.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant cloud">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-17.png" alt="img">
                        </div>
                        <h5 class="hiro ">A great support system</h5>
                        <p class="seo ">Whether you have a question about a product or a customer servIce problem, the
                            IDS Prime service support team is there to assist you. Customer satisfaction is our number
                            one priority.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant dark-blue">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-18.png" alt="img">
                        </div>
                        <h5 class="hiro ">Pay Per Usage</h5>
                        <p class="seo ">Depending on the size and resources of the institute, IDS Prime offers flexible
                            pricing options based on usage. Our goal is to provide you with a cost-effective and
                            economical solution.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant one ">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-19.png" alt="img">
                        </div>
                        <h5 class="hiro ">Professional Developers</h5>
                        <p class="seo ">The developers at IDS Prime are experienced, innovative, and dynamic, and are
                            always eager to turn your needs into smart and effective solutions.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant two ">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-20.png" alt="img">
                        </div>
                        <h5 class="hiro ">Frequent New Feature</h5>
                        <p class="seo ">The journey we are on will never end. We regularly add new features and modules
                            to our web and mobile applications. Keeping our features up-to-date is our promise to you.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant three">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-21.png" alt="img">
                        </div>
                        <h5 class="hiro ">Graphical Analysis</h5>
                        <p class="seo ">A very attractive &amp; visual management program provides multiple graphical
                            analysis views, such as student exam performance, class ranking versus top students,
                            attendance view, etc.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant four">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-22.png" alt="img">
                        </div>
                        <h5 class="hiro ">Reports</h5>
                        <p class="seo ">There are various reports available with IDS Prime School Management System,
                            which can be generated on a single click to save time and effort. Reports include student
                            and staff details,various fee reports, library, attendance, and transportationreports, among
                            others.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant five">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-23.png" alt="img">
                        </div>
                        <h5 class="hiro ">Various Views</h5>
                        <p class="seo ">Data like exam results, attendance, etc, can be viewed in multiple views with
                            IDS Prime's single and multiple search options. Data can be viewed as a tabular or graphical
                            format according to the school's needs.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="inr-contant six ">
                        <div class="icon-box">
                            <img class="img-fluid" src="<?php echo SITE_URL; ?>images/many-24.png" alt="img">
                        </div>
                        <h5 class="hiro ">Quick and easy download.</h5>
                        <p class="seo ">It is very easy to download IDS Prime reports in pdt, excel or .csv formats by
                            simply clicking the button.</p>
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
                    <p>© <?php// $date = DATE('Y');
                           // echo $date;  ?> <a href="http://doomshell.com/">doomshell.com</a>.
                        | All Rights Reserved.</p>
                </div>
                <div class="col-md-2 col-xs-12">

                </div>
            </div>
        </div>
    </div> -->

    </div>







    <!------min.js----------------->
    <script src="<?php echo SITE_URL; ?>js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <!--------------owl carousel-------------------------->
    <script src="<?php echo SITE_URL; ?>js/owl.carousel.min.js" type="text/javascript"></script>
    <!--------------bootstyrap-js-------------------------->
    <script src="<?php echo SITE_URL; ?>js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" type="text/javascript"> -->
    </script>
    <script src="<?php echo SITE_URL; ?>js/wow.min.js"></script>
</body>

</html>