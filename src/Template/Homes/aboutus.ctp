<!DOCTYPE HTML>
<html>

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



        <div class="p-slider">
            <div class="container">

                <div class="part">
                    <h3 class="channel">
                        About Us
                    </h3>

                    <p class="sectors">
                        We view protection of Your privacy as a very important principle. We understand clearly that You
                        and Your Personal Information is one of Our most important assets. We may share personal
                        information with our other corporate entities and affiliates.
                    </p>

                </div>
            </div>

        </div>



        <section id="about" class="one">
            <div class="container">
                <div class="row py-3 d-flex align-items-center">
                    <div class="col-md-6">
                        <div class="contants">
                            <h1>
                                iDS Prime - a Product by <span> Doomshell Software Pvt. Ltd.</span>
                            </h1>

                            <p>Doomshell Software Pvt. Ltd. is leading IT Solutions Company which form IT Services and
                                Solutions
                                as per your requirements. We are located where our clients need us, in addition to our
                                head
                                office in Jaipur. We have expertise in web designing, ERP solutions and mobile app
                                development
                                for educational institutes & industrial establishments. Doomshell Software your IT
                                Consultant,
                                provides a complete, innovative business/academic solutions in terms of the IT
                                proficiency that
                                your business/institute requires. We offer our expertise for your business/institute
                                unit. By
                                understanding your business model we develop a complete end to end solution - Matching
                                your IT
                                requirements with Physical lay out, IT infrastructure design, package of customized
                                softwares,
                                IT skill development of the employees or individuals whosoever required. We help you to
                                use the
                                Information Technology to innovate and invent value addition to your products and
                                services. We
                                rise with our clients.</p>

                        </div>

                    </div>
                    <div class="col-md-6 seven wow bounceInDown">
                        <div class="work">
                            <img src="<?php echo SITE_URL; ?>images/1727892.png " class="img-fluid" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="idsformmain">
            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
        </button> -->

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- <div class="modal-header">        
                    </div> -->
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
                                                    <input type="text" placeholder="Phone No."
                                                        class="form-control mb-3" />
                                                    <textarea class="form-control mb-3"
                                                        placeholder="Message"></textarea>
                                                    <button class="modalbtn">Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
                    </div>
                </div>
            </div>
        </div>

        <section id="about" class="one again">
            <div class="container">
                <div class="row py-3 g-0 d-flex align-items-center">

                    <div class="col-md-6  wow bounceInDown">
                        <div class="work">
                            <lottie-player src="https://assets7.lottiefiles.com/packages/lf20_JYe5t7/data2.json"
                                background="transparent" speed="1" style="width: 100%; height: auto;" loop autoplay>
                            </lottie-player>
                        </div>
                    </div>
                    <div class="col-md-6 six">
                        <div class="contants again">
                            <h1>
                                Role Of iDS Prime In<span>Educational Establishments</span>
                            </h1>


                            <p>The real change has been brought by the global business with the evolution and use of
                                computers.
                                The fastest of the changes that are occurring in the current era is the IT change. Being
                                an IT
                                literate is most important to handle these changes for both the business and individual
                                to keep
                                their position or touch new horizons. The market is producing better services and
                                current
                                products being modified with new features all thanks to IT evolution, which is
                                accelerating at a
                                faster rate then the new products being developed. The IT is playing a significant
                                developmental
                                role in all sectors of society- government, household, business, etc. When we talk about
                                the
                                business- each sector is now implementing the IT infrastructure and keeps a close look
                                at what
                                new technology is being provided by the IT market. IT is helping to reach the sections
                                of
                                society- students, employees, consumer etc.</p>
                            <p>“iDS Prime” comes as fresh gust of air, with a promise to usher in Smart Technology in
                                all
                                attributes of 21st education. It opens a wide vistas that will change education
                                management is
                                done in schools by bringing a futuristic SMART solution on to mobile touch screens and
                                computer
                                monitors. “iDS Prime” is a SMART communication tool, which brings on a common footing:
                                school,
                                parents and students.</p>

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
                        <p>© <?php $date = DATE('Y');
                                echo $date;  ?> <a href="http://doomshell.com/">Doomshell.com</a>.
                            | All Rights Reserved.</p>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <a href="#"><img src="<?php echo SITE_URL; ?>images/fb.jpg"></a>
                    </div>
                </div>
            </div>
        </div>-->

    </div>
    <!--page-wrapper-->
    <!------min.js----------------->
    <script src="<?php echo SITE_URL; ?>js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <!--------------bootstyrap-js-------------------------->
    <!-- <script src="<?php echo SITE_URL; ?>js/bootstrap.min.js" type="text/javascript"></script> -->
    <script src="https://www.idsprime.com/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</body>

</html>