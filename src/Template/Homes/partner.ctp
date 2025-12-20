<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $met['title']; ?></title>
    <meta name="keywords" content="<?php echo $met['keyword'];?>" />
    <meta name="description" content="<?php echo $met['description'];?>" />

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
.p-slider .part .channel {
    font-size: 60px text-align: center;
    font-weight: 600;
    margin: 0;
    margin-top: 20px;
    color: #0b237c;
}

.p-slider {
    background-color: #dbeff1;
    padding-bottom: 78px;
    padding-top: 40px;
}

.p-slider .part .offer {
    font-size: 31px margin: 13px 0;

}

.p-slider .part {
    padding: 40px 0px;
}

.p-slider .part .sectors {
    font-size: 15px text-align: justify;
    text-align-last: center;
}

.center .imgvactor {
    width: 616px;
    margin: auto;
    margin-top: -103px;
}

#partner {
    background-color: #fff;
    padding-top: 60px;
}

#partner h3 {
    /* text-align: left; */
    /* margin-bottom: 30px; */
    font-size: 56px;
    color: #414042;
    font-weight: 800;
    margin-top: 29px;
}


#partner .add {
    text-align: center;
    font-size: 48px;
    font-weight: 700;
}



#partner .contants .become {
    font-size: 19px;
    text-align: left;
    color: #006b91;
    color: #000;
    font-weight: 600;
}

#partner .contants {
    /* padding-top: 40px; */
    background-color: rgba(255, 222, 57, 1);
    padding: 72px;
    /* margin: 40px 0px; */
    margin-bottom: 40px;
}

#partner .contants ul li {
    list-style: none;
    margin-top: 20px;
    font-size: 16px color: #000;
    text-align: left;
    position: relative;
    padding-left: 24px;
}

#partner .contants ul {
    margin: 0px;
    padding: 0px;
}

#partner .contants ul li img {
    width: 18px;
    /* margin-right: 8px; */
    position: absolute;
    left: 0;
    top: 1px;
}

#partner .contants.deta p {
    margin-bottom: 10px;
    color: #000;
}

#partner .contants .pera .lastheading {
    font-size: 22px;
}

#partner .img-box {
    display: flex;
    align-items: center;
    justify-content: center;
}

#partner .contants.second {
    background-color: #fff;
}

/* #partner .contants ul li:last-child {
    font-size: 19px !important;
    font-weight: 600;
} */
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


        <div class="p-slider channels">
            <div class="container">

                <div class="part">
                    <h3 class="channel">
                        Channel Partner
                    </h3>
                    <h4 class="offer">We offer good reasons to be a

                        channel partner</h4>
                    <p class="sectors">
                        In terms of potential sectors, education and &#39;IDS Prime&#39; are consistently
                        growtion than today. The school, college, and institute industry is looking
                        into reliable, cost-effective, comprehensive, and value-added ERP
                        solutions to manage things more efficiently and connect key stakeholders.
                    </p>

                </div>
            </div>

        </div>

        <div class="center">
            <div class="imgvactor">
                <img src="<?php echo SITE_URL; ?>images/prt.png" class="img-fluid" alt="img">
            </div>
        </div>



        <section id="partner">
            <div class="container">


                <div class="row py-3 g-0 d-flex align-items-center">
                    <div class="col-md-6">
                        <div class="contants">

                            <p class="become">
                                Become a channel partner with us and discover
                                immense opportunities! Here are a few key benefits:
                            </p>
                            <ul>
                                <li>
                                    <img src="<?php echo SITE_URL; ?>images/chack.png" alt="img">Tremendous market size
                                </li>
                                <li>
                                    <img src="<?php echo SITE_URL; ?>images/chack.png" alt="img">Growth and future
                                    potential
                                </li>
                                <li>
                                    <img src="<?php echo SITE_URL; ?>images/chack.png" alt="img">Increasing trend
                                    towards technology adoption
                                </li>
                                <li>
                                    <img src="<?php echo SITE_URL; ?>images/chack.png" alt="img">Minimal investment
                                </li>
                                <li>
                                    <img src="<?php echo SITE_URL; ?>images/chack.png" alt="img">Assured revenue stream
                                </li>
                                <li>
                                    <img src="<?php echo SITE_URL; ?>images/chack.png" alt="img">Consistent source of
                                    recurring income
                                </li>

                            </ul>

                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="contants second">

                            <p class="become">
                                Stages and formalities
                            </p>
                            <ul>
                                <li>
                                    <img src="<?php echo SITE_URL; ?>images/chack.png" alt="img">Understand each other
                                </li>
                                <li>
                                    <img src="<?php echo SITE_URL; ?>images/chack.png" alt="img">Share your profile and
                                    aspirations
                                </li>
                                <li>
                                    <img src="<?php echo SITE_URL; ?>images/chack.png" alt="img">Decision phase
                                </li>
                                <li>
                                    <img src="<?php echo SITE_URL; ?>images/chack.png" alt="img">Completion of
                                    formalities
                                </li>
                                <li>
                                    <img src="<?php echo SITE_URL; ?>images/chack.png" alt="img">Training
                                </li>
                                <li>
                                    <img src="<?php echo SITE_URL; ?>images/chack.png" alt="img">Ready to go!
                                </li>

                            </ul>

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
                        <p>© <?php //$date =DATE('Y'); echo $date;  ?> <a href="http://doomshell.com/">doomshell.com</a>.
                            | All Rights Reserved.</p>
                    </div>
                    <div class="col-md-2 col-xs-12">

                    </div>
                </div>
            </div>
        </div> -->

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