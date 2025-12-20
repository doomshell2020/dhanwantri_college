<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IDsPrime ERP</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <?= $this->Html->css('admin/bootstrap.min.css') ?>
    <?= $this->Html->meta(
        'favicon.ico',
        'img/favicon.ico',
        ['type' => 'icon']
    ); ?>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- Theme style -->
    <?= $this->Html->css('admin/dataTables.bootstrap.css') ?>
    <?= $this->Html->css('admin/AdminLTE.min.css') ?>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <?= $this->Html->css('admin/skins/_all-skins.min.css') ?>
    <!-- iCheck -->
    <?= $this->Html->css('admin/blue.css') ?>
    <!-- Morris chart -->
    <?= $this->Html->css('admin/morris.css') ?>
    <!-- jvectormap -->
    <?= $this->Html->css('admin/jquery-jvectormap-1.2.2.css') ?>
    <!-- Date Picker -->
    <?= $this->Html->css('admin/datepicker3.css') ?>
    <!-- Daterange picker -->
    <?= $this->Html->css('admin/daterangepicker.css') ?>
    <!-- bootstrap wysihtml5 - text editor -->
    <?= $this->Html->css('admin/bootstrap3-wysihtml5.min.css') ?>
    <?= $this->Html->css('admin/responsive.css') ?>
    <?= $this->Html->css('admin/style.css') ?>
    <?= $this->Html->script('admin/jquery-2.2.3.min.js') ?>
    <?= $this->Html->script('admin/bootstrap.min.js') ?>
    <?= $this->Html->script('timepicker/bootstrap-timepicker.min.js') ?>
    <? //= $this->Html->script('admin/canvasjs.min.js') 
    ?>
    <? //= $this->Html->script('admin/canvasjs_graph.js') 
    ?>
    <?= $this->Html->css('timepicker/bootstrap-timepicker.min.css') ?>
    <?php $rolepresent = $this->request->session()->read('Auth.User.role_id');
    if ($rolepresent == '6') {  ?>
        <style type="text/css">
            .nav>li>a>img {
                width: 19px !important;
            }

            .nav>li>a {
                font-size: 13px !important;
                padding: 10px 10px !important
            }

            .skin-blue .main-header .logo {
                width: 213px;
            }

            .navbar-nav {
                margin-top: 16px !important;
                height: 58px;
            }
        </style>
    <?php } ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    <style>
        .skin-blue .main-header .navbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            background-color: #fff;
            box-shadow: 0px 0px 5px 0px #0002;
            height: 58px;
        }

        .skin-blue .main-header .navbar .navbar-custom-menu .nt_menu_align {
            display: flex;
            align-items: center;
        }

        .skin-blue .main-header .navbar .navbar-custom-menu .nt_menu_align li ul {
            margin-left: 0px;
        }

        header .navbar-nav li {
            padding: 0px 10px !important;
            text-align: center;
        }

        ul.nt_menu_align li a span {
            display: block;
            text-align: center;
            font-size: 12px;
            font-weight: 400;
        }

        header img {
            height: 26px;
            width: auto;
            /* -webkit-filter: invert(80%);
         filter: invert(80%); */
        }

        header {
            padding-top: 0;
        }

        header .navbar-nav li a {
            color: #333 !important;
            padding: 0px !important;
        }

        .main-header .navbar {
            min-height: auto !important;
            padding: 5px 0px;
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-collapse">
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <script>
                $(document).ready(function() {
                    jQuery.fn.justtext = function() {
                        return $(this).clone()
                            .children()
                            .remove()
                            .end()
                            .text();
                    };
                    var str = $('.content-header').find('h1').justtext();
                    document.title = str;
                });
            </script>
            <?php

            $role_id = $this->request->session()->read('Auth.User.role_id');
            $checked_by = $this->request->session()->read('checked_by');

            if ($role_id == '105' ||  $checked_by == '105') {
                $get_franchise = $this->Comman->getfranchise();
                //pr($get_franchise); die;
                $franchise_db = $get_franchise[0]['franchise_db'];

                $branch = explode(",", $franchise_db);
                //pr($branch); die;
            } ?>

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">

                <div class="d-flex justify-content-between">
                    <!-- Sidebar toggle button-->
                    <!--  <a href="#" class="sidebar-toggle" data-toggle="" role="button">
                     <span class="sr-only">Toggle navigation</span>
                     </a>-->
                    <?php
                    if ($rolepresent == 16) {
                        $payroll = $this->payroll();
                        // pr($payroll); die;
                    }
                    if ($rolepresent == 101) {   ?>
                        <a href="#" class="logo">
                            <!-- mini logo for sidebar mini 50x50 pixels -->
                            <!-- logo for regular state and mobile devices -->
                            <span class="logo-lg"> <img src="<?php echo SITE_URL; ?>images/idsprimeheaderlogo.png" style="width: 140px;" height="70px" class="user-image" alt="User Image"></span>
                        </a>
                    <?php   } else {
                    ?>
                        <?php /* <div class="head_adleft">
                                <a href="#" class="sidebar-toggle sidebar-toggle-2" data-toggle="offcanvass" role="button"></a>
                                <a href="#" class="logo">
                                    <!-- mini logo for sidebar mini 50x50 pixels -->
                                    <?php $findlogo= $this->Comman->findlogo();  ?>
                            <!-- <?php $rolepresent=$this->request->session()->read('Auth.User.role_id'); if($rolepresent!=6) { ?> -->
                            <span class="logo-mini">
                            <img src="<?php echo SITE_URL;?>images/<?php echo $findlogo['header_logo']; ?>" width="125px"
                                class="user-image" alt="User Image">
                            </span>
                            <!--   <?php } ?> -->
                            <!-- logo for regular state and mobile devices -->
                            <span class="logo-lg">
                            <img src="<?php echo SITE_URL;?>images/<?php echo $findlogo['header_logo']; ?>" height="70px"
                                style="width: 200px;" class="user-image" alt="User Image">
                            </span>
                            </a>
                            </div>
                        */ ?>
                    <?  } ?>
                    <div class="navbar-custom-menu">
                        <!-- <ul class="nav navbar-nav nt_menu_align" style="margin-left:230px;">-->
                        <ul class="nav navbar-nav nt_menu_align">
                            <li>
                                <ul style="display:flex;">
                                    <?php
                                    $tid = $this->request->session()->read('Auth.User.tech_id');
                                    $role_id = $this->request->session()->read('Auth.User.role_id');
                                    $classteacherss = $this->Comman->findcalssteach();
                                    if ($role_id == '101') { ?>
                                        <li>
                                            <a title="Help Manager" href="<?php echo SITE_URL; ?>admin/Help/index" data-toggle="tooltip">
                                                <img src="<?php echo SITE_URL; ?>images/Store Management-manager.png" style="width: 29px;height: 35px;" class="" alt="Help  Manager">
                                                <span>Help Manager</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="Enquiry Manager" href="<?php echo SITE_URL; ?>admin/enquiry/index" data-toggle="tooltip">
                                                <img src="<?php echo SITE_URL; ?>images/4.png" style="width: 29px;height: 35px;" class="" alt="Enquiry  Manager">
                                                <span>Enquiry Manager</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="School List Manager" href="<?php echo SITE_URL; ?>admin/users/add" data-toggle="tooltip">
                                                <img src="<?php echo SITE_URL; ?>images/4.png" style="width: 29px;height: 35px;" class="" alt="School List Manager">
                                                <span>School List</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="SEO" href="<?php echo SITE_URL; ?>admin/seo/index" data-toggle="tooltip">
                                                <img src="<?php echo SITE_URL; ?>/images/add-prospectus.png" style="width: 29px;height: 35px;" class="" alt="HomeWork">
                                                <span>SEO Manager</span>
                                            </a>
                                        </li>
                                    <?php }
                                    if (!empty($tid) && $role_id == '3') { ?>
                                        <li><a title="Timetable/Assignment" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/teachertimetable" data-toggle="tooltip">
                                                <img src="<?php echo SITE_URL; ?>/images/add-prospectus.png" style="width: 29px;height: 35px;" class="" alt="HomeWork">
                                                <span>Time Table</span>
                                            </a>
                                        </li>
                                        <li><a title="Timetable/Assignment" href="<?php echo SITE_URL; ?>admin/Video/view" data-toggle="tooltip">
                                                <img src="<?php echo SITE_URL; ?>/images/add-prospectus.png" style="width: 29px;height: 35px;" class="" alt="HomeWork">
                                                <span>Videos</span>
                                            </a>
                                        </li>
                                        <?php $csec = $this->Comman->findclasstime1221($tid);
                                        foreach ($csec as $key => $value) {
                                            $csection = $this->Comman->findclasssection1221($value['class_id']);
                                            $classs[] = $csection['class_id'];
                                        }
                                        $cls = array_unique($classs);
                                        $klp = array('18', '19', '1', '2', '3', '4', '6');
                                        $rt = array_intersect($cls, $klp);
                                    }
                                    if (!empty($rt)) { ?>
                                        <li style="padding:10px; text-align:center"><a title="Upload Higher Class Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/examcontrolviewsubject" data-toggle="tooltip">
                                                <?php if (file_exists('/var/www/html/templatelaboratory.com/webroot/images/headericons/studentexamresultexamcontrolviewsubject.png')) { ?>
                                                    <img src="<?php echo SITE_URL; ?>images/headericons/studentexamresultexamcontrolviewsubject.png" class="" alt="iamges">
                                                <?php } else { ?>
                                                    <img src="<?php echo SITE_URL; ?>images/1.png" class="" alt="">
                                                <?php } ?>
                                                <span>Upload Higher</span>
                                            </a>
                                        </li>
                                        <li style="padding:10px; text-align:center"><a title="Upload Term Result(Grade-III/IV/V)" href="<?php echo SITE_URL; ?>admin/studentexamresult/examcontrolterm" data-toggle="tooltip">
                                                <?php if (file_exists('/var/www/html/templatelaboratory.com/webroot/images/headericons/studentexamresultexamcontrolterm.png')) { ?>
                                                    <img src="<?php echo SITE_URL; ?>images/headericons/studentexamresultexamcontrolterm.png" class="" alt="iamges">
                                                <?php } else { ?>
                                                    <img src="<?php echo SITE_URL; ?>images/3.png" class="" alt="">
                                                <?php } ?>
                                                <span>Term (Grade-III/IV/V)</span>
                                            </a>
                                        </li>
                                        <li style="padding:10px; text-align:center"><a title="Upload PYP Result" href="<?php echo SITE_URL; ?>admin/Primarycentral/primaryexamcontrolview" data-toggle="tooltip">
                                                <?php if (file_exists('/var/www/html/templatelaboratory.com/webroot/images/headericons/Primarycentralprimaryexamcontrolview.png')) { ?>
                                                    <img src="<?php echo SITE_URL; ?>images/headericons/Primarycentralprimaryexamcontrolview.png" class="" alt="iamges">
                                                <?php } else { ?>
                                                    <img src="<?php echo SITE_URL; ?>images/depositbook.png" class="" alt="">
                                                <?php } ?>
                                                <span>Upload PYP</span>
                                            </a>
                                        </li>
                                    <?php }
                                    if ($rolepresent == '3' && $classteacherss['id'] != '') {
                                        $getterm = $this->Comman->findacedemicyears('1');  ?>
                                        <li>
                                            <a title="Co-Scholastic Upload Result" href="<?php echo SITE_URL; ?>admin/Coactivityresults/addcsv/<?php echo $classteacherss['class_id']; ?>/<?php echo $classteacherss['section_id']; ?>/<?php echo $findacedemicyears['academic_year']; ?>/<?php echo "Term" . $getterm['examterm']; ?>?query=1" data-toggle="tooltip">
                                                <img src="<?php echo SITE_URL; ?>/images/2.png" class="" alt="Upload Result">
                                                <span></span>
                                            </a>
                                        </li>
                                        <?php }
                                    if ($this->request->session()->read('Auth.User.role_id') != '101') {
                                        $headrmenu = $this->Comman->findheadermenu();
                                    }
                                    // pr($headrmenu);exit;
                                    foreach ($headrmenu as $key => $item) {
                                        if ($item['action'] == "prospectus_add") { ?>
                                            <li>

                                                <a id="update-data" href="<?php echo SITE_URL; ?>admin/<?php echo $item['controller']; ?>/<?php echo $item['action']; ?>" data-target="#globalModalkjs" data-toggle="modal" data-modal-size="modal-lg">
                                                    <?php if (file_exists('/var/www/html/idsprime/webroot/images/headericons/' . $item['controller'] . $item['action'] . '.png')) { ?>
                                                        <img src="<?php echo SITE_URL; ?>images/headericons/<?php echo $item['controller'] . $item['action']; ?>.png" class="" alt="iamges">
                                                    <?php } else { ?>
                                                        <img src="<?php echo SITE_URL; ?>images/add_inqury1.png" class="" alt="Default">
                                                    <?php } ?>
                                                    <span><?php echo $item['short_name']; ?></span>
                                                </a>
                                            </li>

                                        <?php } else {
                                            // pr($item);exit;
                                            //Only enabled deposite fee - Rupam 05/06/2023
                                            // if ($item['action'] == 'view') {
                                                // pr(SITE_URL . 'images/headericons/' . $item['controller'] . $item['action'] . '.png');
                                        ?>

                                            <li style="padding:10px; text-align:center">
                                                <a title="<?php echo $item['menu']; ?>" href="<?php echo SITE_URL; ?>admin/<?php echo $item['controller'];  ?>/<?php echo $item['action']; ?>" data-toggle="tooltip">
                                                    <?php
                                                    if (SITE_URL . 'images/headericons/' . $item['controller'] . $item['action'] . '.png') {
                                                    ?> 
                                                    <img src="<?php echo SITE_URL;  ?>images/headericons/<?php echo $item['controller'] . $item['action'];  ?>.png" height="30px" width="33px">

                                                    <?php  } else {  ?>

                                                        <img src="<?php echo SITE_URL; ?>images/add_inqury1.png" alt="Default">
                                                        
                                                    <?php  }
                                                    ?>
                                                    <span><?php echo $item['short_name']; ?></span>
                                                </a>
                                            </li>
                                    <?php //}
                                        }
                                    }  ?>
                                    <?php if ($role_id == '7') { ?>
                                        <li class="chk"><a title="Reports" href="#" data-toggle="tooltip">
                                                <img src="<?php echo SITE_URL; ?>/images/report_icon.png" class="" alt="Reports">
                                                <span>Reports</span>
                                            </a>
                                        </li>
                                        <ul class="checkme" style="width:190px;">
                                            <li>
                                                <a href="<?php echo ADMIN_URL; ?>ReportNew/booksreport" style="color:#337ab7 !important;">
                                                    <i class="fa fa-book"></i>
                                                    Books Report
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo ADMIN_URL; ?>report/issuedbooksreport" style="color:#337ab7 !important;">
                                                    <i class="fa fa-book"></i>
                                                    Issued Books Report
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo ADMIN_URL; ?>report/finereport" style="color:#337ab7 !important;"><i class="fa fa-book"></i>
                                                    Fine Report
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo ADMIN_URL; ?>report/overduewithoutfine" style="color:#337ab7 !important;">
                                                    <i class="fa fa-book"></i>
                                                    Overdue Return Without Fine
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo ADMIN_URL; ?>ReturnRenewBooks/studentreport" style="color:#337ab7 !important;">
                                                    <i class="fa fa-book"></i>
                                                    Student Report
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo ADMIN_URL; ?>ReturnRenewBooks/depositreport" style="color:#337ab7 !important;">
                                                    <i class="fa fa-book"></i>
                                                    Deposit Book Report
                                                </a>
                                            </li>
                                        </ul>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php
                            $db_data_name = $this->request->session()->read('Auth.User.db');

                            if ($db_data_name == "canvas") { ?>
                                <li> <a href="<?php echo SITE_URL; ?>admin/dashboards/applogindata">
                                        <img src="<?php echo SITE_URL; ?>/images/excel_icon.png" class="user-image"> <span>App</span> </a></li>
                            <?php } ?>
                            <li>
                                <?php if ($role_id == '105'  ||  $checked_by == '105') {
                                    $db_data_name = $this->request->session()->read('Auth.User.db');

                                ?>

                                    <select class="form-select form-control" aria-label="Default select example" style="width:200px; border:1px solid #999" onchange="changeGroupSchool(this.value);">
                                        <?php $branch_exps = explode("_", $branch[0]); ?>

                                        <option value="<?php echo $branch_exps[0]; ?>" <?php if ($db_data_name == $branch_exps[0]) {
                                                                                            echo "selected";
                                                                                        } else {
                                                                                            echo "";
                                                                                        } ?>>Central Head</option>

                                        <?php foreach ($branch as $key => $value) { //pr($value); die; 
                                        ?>
                                            <?php

                                            $branch_exp = explode("_", $value);
                                            // pr($branch_exp);
                                            ?>
                                            <option value="<?php echo $value; ?>" <?php if ($db_data_name == $value) {
                                                                                        echo "selected";
                                                                                    } else {
                                                                                        echo  "";
                                                                                    } ?> id="dbname"><?php echo ucfirst($branch_exp[1]); ?><?php //echo ucfirst($branch_city[0]['city']);  
                                                                                                                                            ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>

                            </li>

                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo SITE_URL; ?>/img/images.jpg" class="user-image">
                                    <span class="hidden-xs" style=" display: inline-block; ">
                                        <?php echo ucfirst($this->request->session()->read('Auth.User.user_name')); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <p>
                                            <?php
                                            echo ucfirst($this->request->session()->read('Auth.User.user_name')); ?>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">

                                        <?php
                                        $roles_master = $this->request->session()->read('Auth.User.role_id');
                                        if ($roles_master == '1') { ?>
                                            <div>
                                            <a href="<?php echo $this->Url->build('/admin/users/changepassword'); ?>" class="btn btn-default btn-flat bg-success">Change Password</a>
                                            </div>
                                            <?php

                                        } else {

                                            if ($db_data_name != "canvas") { ?>

                                                <a href="#" class="btn btn-default btn-flat bg-success">Change Password</a>
                                            <?php  } else { ?>
                                                <div>
                                                    <a href="<?php echo $this->Url->build('/admin/users/changepassword'); ?>" class="btn btn-default btn-flat bg-success">Change Password</a>

                                                    <!-- <a href="<?php //echo $this->Url->build('/admin/sitesettings/profile/1'); 
                                                                    ?>" class="btn btn-default btn-flat bg-success">Profile</a> -->

                                                </div>
                                        <?php }
                                        } ?>
                                        <?php if ($this->request->session()->read('Auth.User.role_id') == '16') { ?>
                                            <div style="margin-left:5px;">
                                                <a href="<?php echo $this->Url->build('/admin/payroll/payroll_setting'); ?>" class="btn btn-default btn-flat bg-info">Payroll Setting</a>
                                            </div>
                                        <?php } ?>
                                        <div style="margin-left:5px;">
                                            <a href="<?php echo $this->Url->build('/logins/logout'); ?>" class="btn btn-default btn-flat bg-danger">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

            </nav>
        </header>
        <div class="modal" id="globalModalkoi" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content personal">
                    <div class="modal-body">
                        <div class="loader">
                            <div class="es-spinner">
                                <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--<script>                   // on document ready
         var div = $('.tabs-menu');   // cache <div>
         $('.sidebar-toggle-2').click(function () { // on click on the `<a>`
         alert("hi");
         div.fadeToggle(1000);        // toggle div visibility over 1 second
         });
         </script>-->

        <!-- loder script link -->
        <script src="https://cdn.jsdelivr.net/gh/AmagiTech/JSLoader/amagiloader.js"></script>
        
        <script>
            $(document).ready(function() {
                //prepare the dialog
                //respond to click event on anything with 'overlay' class
                $(".globalModals").click(function(event) {
                    //alert($(this).attr("href"));
                    $('.personal').load($(this).attr("href")); //load content from href of link
                });
            });
        </script>
        <script>
            // $(document).ready(function() {
            //     $('[data-toggle=tooltip]').tooltip();
            //     $(".sidebar-toggle-2").click(function() {
            //         $(".tabs-menu").fadeToggle(1000);
            //     });
            // });

            //color picker with addon

            // $(document).mouseup(function(e) {
            //   var container = $(".tabs-menu");

            //   if (!container.is(e.target) // if the target of the click isn't the container...
            //     &&
            //     container.has(e.target).length === 0) // ... nor a descendant of the container
            //   {
            //     container.fadeOut(1000);
            //   }
            // });
        </script>
        <script>
            $(document).ready(function() {
                $(".chk").click(function() {
                    $(".checkme").slideToggle();
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $(".ad_hd_tmnu a").click(function() {
                    $(".ad_hd_mnu").slideToggle();
                });
            });
        </script>
        <div class="modal" id="globalModalkjs" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content personal">
                    <div class="modal-body">
                        <div class="loader">
                            <div class="es-spinner">
                                <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function changeGroupSchool(id) {
                // alert(id);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo SITE_URL; ?>/app/getbranchdetail',
                    data: {
                        'dbname': id
                    },
                    success: function(data) {
                        obj = JSON.parse(data);
                        var email = obj.email;
                        var password = obj.confirm_pass;
                        school_login(obj.email, obj.confirm_pass, id);
                    },

                });
            }

            function school_login(email, password, dbname) {
                var SITE_URL = '<?php echo SITE_URL; ?>';
                $.ajax({
                    type: 'POST',
                    url: '<?php echo SITE_URL; ?>/app/schoollogin',
                    data: {
                        'email': email,
                        'password': password,
                        'dbname': dbname,
                    },
                    success: function(data) {
                        obj = JSON.parse(data);
                        if (obj.role_id == '6') {
                            //alert('6')
                            window.location.replace(SITE_URL + "admin/dashboards/adminbranch")
                        } else {
                            //alert('105')
                            window.location.replace(SITE_URL + "admin/dashboards/headbranch")
                        }
                        //alert(obj.role_id);
                    },

                });

            }
        </script>