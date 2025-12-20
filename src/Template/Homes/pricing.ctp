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
    <meta property="og:url" content="<?php echo SITE_URL; ?>homes/pricing" />
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
    <meta property="twitter:url" content="<?php echo SITE_URL; ?>homes/pricing">
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
    <link href="<?php echo SITE_URL; ?>homes/pricing" rel="canonical">
    <link href="<?php echo SITE_URL; ?>homes/pricing" rel="alternate" hreflang="en-US">

    <?php }else{ ?>
    <title><?php echo $met2['title']; ?></title>
    <meta name="keywords" content="<?php echo $met2['keyword'];?>" />
    <meta name="description" content="<?php echo $met2['description'];?>" />
    <?php } ?>
    <!--  -->
    <!---------bootstrap-------------------->
    <link href="<?php echo SITE_URL; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!------------font-awesome------------------>
    <link href="<?php echo SITE_URL; ?>css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!---------------genral---------------------->
    <link href="<?php echo SITE_URL; ?>css/style2.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SITE_URL; ?>css/responsive2.css" rel="stylesheet" type="text/css">
    <?= $this->element('scriptheader') ?>
</head>

<body>

    <div id="page-wrapper">

        <div class="brochure_download">
            <a href="<?php echo SITE_URL; ?>images/Myschoolapp_Brochure.pdf">Download Brochure</a>
        </div>

        <style>
        #header .nav li a:last-child {
            padding: 10px 0px 9px 26px;
        }
        </style>
        <header id="header">
            <nav id="mainNav" class="navbar navbar-inverse navbar-expand-lg navbar-dark bg-dark fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand js-scroll-trigger" href="<? echo SITE_URL; ?>homes/index#header"><img
                                src="<?php echo SITE_URL; ?>images/logo.png" alt="logo"></a>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-link js-scroll-trigger"><a
                                    href="<? echo SITE_URL; ?>homes/index#services">Our Services</a></li>
                            <li class="nav-link js-scroll-trigger"><a href="<? echo SITE_URL; ?>homes/index#client">Our
                                    Clients</a></li>
                            <li class="nav-link js-scroll-trigger"><a
                                    href="<? echo SITE_URL; ?>homes/index#features">Features</a></li>
                            <li class="nav-link js-scroll-trigger"><a href="<? echo SITE_URL; ?>homes/aboutus">About
                                    us</a></li>
                            <li class="nav-link js-scroll-trigger"><a href="<? echo SITE_URL; ?>homes/pricing">Pricing
                                    Policy</a></li>
                            <li class="nav-link js-scroll-trigger"><a href="<? echo SITE_URL; ?>homes/privacy">Privacy
                                    Policy</a></li>
                            <li class="nav-link js-scroll-trigger"><a
                                    href="<? echo SITE_URL; ?>homes/index#contact">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <section id="features" class="priv_page">
            <div class="container">
                <div>
                    <h4 class="headingp">Pricing Policy</h4>



                    <h6>Price Range</h6>
                    <p>At iDS Prime we have customised pricing according to the services rendered by us. The details are
                        provided to you beforehand according to the effort, efficiency and the output of the service.
                    </p>

                    <h6>Schedule of payment</h6>
                    <p>Some of our services can be utilised for fixed durations. In such cases, it is clearly mentioned
                        within the description of these services. The period of usage in these cases vary from 1 month
                        to 1 year.</p>


                    <h6>Price Matching</h6>
                    <p>At iDS Prime we are committed to offering you the best possible prices. We will be glad to meet
                        our competitor's pricing if you ever find an item that we offer.</p>

                    <h6>Pricing Errors</h6>
                    <p>We work hard to ensure the accuracy of pricing. Despite our efforts, pricing errors may still
                        occur. If an item/service price is higher than the price displayed, we will cancel your order of
                        that item and notify you of the cancellation.</p>

                    <p>Our merchandise/service is offered for sale by iDS Prime for your personal use and not for
                        resale. Therefore, we reserve the right to refuse to sell to any person whom we believe may be
                        purchasing for resale.

                        Our Customer Service Specialists are ready to assist you - simply email at <a
                            href="mailto:contact@doomshell.com">contact@doomshell.com</a>
                    </p>
                </div>
            </div>
        </section>

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
                <!-- row -->
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
                        <p>© <?php $date =DATE('Y'); echo $date;  ?> <a href="http://doomshell.com/">Doomshell.com</a>. | All Rights Reserved.</p>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <a href="#"><img src="<?php echo SITE_URL; ?>images/fb.jpg"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--page-wrapper-->
    <!------min.js----------------->
    <script src="<?php echo SITE_URL; ?>js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <!--------------bootstyrap-js-------------------------->
    <script src="<?php echo SITE_URL; ?>js/bootstrap.min.js" type="text/javascript"></script>

</body>

</html>