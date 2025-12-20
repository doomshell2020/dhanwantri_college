<section class="tabs-menu leftMenu">
    <div class="drawerLogo">
        <a href="<?php echo SITE_URL; ?>admin/dashboards/adminbranch/">
            <!-- <img src="images/" class="fullLogo" alt="logo"> -->
            <img src="<?php echo SITE_URL; ?>images/a1cb71f0df8027b787cef089ce9925d8.jpeg" class="fullLogo" alt="logo">

            <img src="<?php echo SITE_URL; ?>images/a1cb71f0df8027b787cef089ce9925d8.jpeg" class="smallLogo" alt="logo">
        </a>
    </div>
    <!-- <div class="container-fluid">
      <div class="row">
          <div class="col-sm-3"> -->


    <?php $rolepresent = $this->request->session()->read('Auth.User.role_id');
    //  pr($rolepresent);die;
   
   // pr( $role_permissions);die;
    $role_permissions = $this->Permission->permissioncheck(); ?>

    <!------------------------------------- Admission --------------------------------------->


    <!-- <?php $role_permiss = $this->Permission->permissioncount('Admission');
    if (!empty($role_permiss)) {

     
    
        ?> <?php } ?> -->

    <ul class="nav nav-tabs sideMenu">
        <li class="mainMenu0">
            <a data-toggle="tab" href="#menu110">
                <!-- <i class="fa fa-user" aria-hidden="true"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/Admission-manager.png">
                     <span>Admission</span> 
                    <i class="fa fa-chevron-right pull-right" aria-hidden="true"></i>
                </a>

                <script>
                    $(document).ready(function () {
                        $(".mainMenu0 a").click(function () {
                            $(".mainMenu0").addClass("step2");
                        });
                    });
                </script>

                <script>
                    $(document).ready(function () {
                        $(".tabHeading").click(function () {
                            $(".mainMenu0").removeClass("step2");
                        });
                    });
                </script>
                <!-- <div id="menu110" class="tab-pane fade  in active "> -->
                <ul>
                    <!-- <li>
                        <a href="#">
                            <i class="fa fa-users"></i>
                            <span>Admission</span>
                        </a>
                    </li> -->
                    <p class="menuBack">
                        <a href="#" class="tabHeading">
                            <!-- <i class="fa fa-users"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/Admission-manager.png" alt="Registration Manager">
                            <span>Admission</span>
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        </a>
                    </p>

                    <?php
                    $fileurl = "admin/students/add";
                    if (in_array($fileurl, $role_permissions)) {
                        ?>

                        <li style="display: flex; align-items: center;">
                            <a href="<?php echo SITE_URL; ?>admin/students/add">
                                <!-- <i class="fa fa-reorder"></i> -->
                                <img src="<?php echo SITE_URL; ?>images/subMenu/Add Admission-sub.png" alt="submenu"
                                    class="submenuIcon">
                                <span>Add Admission</span>
                            </a>
                        </li>

                    <?php } ?>

                    <?php
                    $fileurl = "admin/students/index";
                    if (in_array($fileurl, $role_permissions)) {
                        ?>
                        <li style="display: flex; align-items: center;">
                            <a href="<?php echo SITE_URL; ?>admin/students/index">
                                <!-- <i class="fa fa-reorder"></i> -->
                                <img src="<?php echo SITE_URL; ?>images/subMenu/Manage Admission-sub.png" alt="submenu"
                                    class="submenuIcon">
                                <span>Manage Admission</span>
                            </a>
                        </li>

                    <?php } ?>
                    <?php

                    $fileurl = "admin/students/drop";
                    if (in_array($fileurl, $role_permissions)) {
                        ?>

                        <li style="display: flex; align-items: center;">
                            <a href="<?php echo SITE_URL; ?>admin/students/drop">
                                <!-- <i class="fa fa-reorder"></i> -->
                                <img src="<?php echo SITE_URL; ?>images/subMenu/Drop Out Students-sub.png" alt="submenu"
                                    class="submenuIcon">
                                <span>Drop Out Students</span>
                            </a>
                        </li>
                    <?php } ?>

                    <li class="returnBack">
                        <a href="#" class="tabHeading"><i class="fas fa-undo"></i> <span>Back To Menu</span></a>
                    </li>
                </ul>
            </li>
        

        <!------------------------------------- Fee Master --------------------------------------->


        <li class="mainMenu1">
            <a data-toggle="tab" href="#menu111">
                <!-- <i class="fa fa-user" aria-hidden="true"></i> -->
                <img src="<?php echo SITE_URL; ?>images/Fee Master-manager.png">
                <span>Fee Master</span>
                <i class="fa fa-chevron-right pull-right" aria-hidden="true"></i>

            </a>


            <script>
                $(document).ready(function () {
                    $(".mainMenu1 a").click(function () {
                        $(".mainMenu1").addClass("step2");
                    });
                });
            </script>
            <script>
                $(document).ready(function () {
                    $(".tabHeading").click(function () {
                        $(".mainMenu1").removeClass("step2");
                    });
                });
            </script>
            <!-- <div id="menu111" class="tab-pane fade "> -->
            <ul>
                <!-- <li>
               <a href="#">
                   <i class="fa fa-users"></i>
                   <span>Fee Master</span>
               </a>
               </li> -->
                <p class="menuBack">
                    <a href="#" class="tabHeading">
                        <!-- <i class="fa fa-users"></i> -->
                        <img src="<?php echo SITE_URL; ?>images/Fee Master-manager.png" alt="Registration Manager">
                        <span>Fee Master</span>
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    </a>
                </p>

                <?php
                $fileurl = "admin/classfee/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>

                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/classfee/index">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Course Fee Structures-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Course Fee Structures</span>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $fileurl = "admin/feesheads/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/feesheads/index">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Fee Heads-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Fee Heads</span>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $fileurl = "admin/studentfees/view";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/studentfees/view">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Deposit Fee-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Deposit Fee</span>
                        </a>
                    </li>
                <?php } ?>

                <li class="returnBack">
                    <a href="#" class="tabHeading"><i class="fas fa-undo"></i> <span>Back To Menu</span></a>
                </li>
            </ul>
        </li>


        <!------------------------------------- Reports --------------------------------------->

        <li class="mainMenu2 active">
            <a data-toggle="tab" href="#menu112" aria-expanded="true">
                <!-- <i class="fa fa-user" aria-hidden="true"></i> -->
                <img src="<?php echo SITE_URL; ?>images/Reports-manager.png">
                <span>Reports</span>
                <i class="fa fa-chevron-right pull-right" aria-hidden="true"></i>
            </a>
            <script>
                $(document).ready(function () {
                    $(".mainMenu2 a").click(function () {
                        $(".mainMenu2").addClass("step2");
                    });
                });
            </script>
            <script>
                $(document).ready(function () {
                    $(".tabHeading").click(function () {
                        $(".mainMenu2").removeClass("step2");
                    });
                });
            </script>
            <!-- <div id="menu112" class="tab-pane fade "> -->
            <ul>


                <li>
                    <!-- <a href="#">
                   <i class="fa fa-users"></i>
                   <span>Reports</span>
               </a>
               </li> -->
                    <p class="menuBack">
                        <a href="#" class="tabHeading">
                            <!-- <i class="fa fa-users"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/Reports-manager.png" alt="Registration Manager">
                            <span>Reports</span>
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        </a>
                    </p>

                    <?php
                    $fileurl = "admin/report/student";
                    if (in_array($fileurl, $role_permissions)) {
                        ?>

                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/report/student">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Student Information-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Student Information</span>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $fileurl = "admin/report/document";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/report/document">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Student Document Report-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Student Document Report</span>
                        </a>
                    </li>

                <?php } ?>

                <?php
                $fileurl = "admin/report/studentgender";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/report/studentgender">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Gender Report-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Gender Report</span>
                        </a>
                    </li>
                <?php } ?>


                <?php
                $fileurl = "admin/report/collectionrecipiet";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/report/collectionrecipiet">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Fee Collections-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Fee Collections</span>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $fileurl = "admin/report/dailyreport";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/report/dailyreport">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Daily Summary-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Daily Summary</span>
                        </a>
                    </li>

                <?php } ?>


                <?php
                $fileurl = "admin/report/monthlysummary";
                if (in_array($fileurl, $role_permissions)) {
                    ?>

                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/report/monthlysummary">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Monthly Summary-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Monthly Summary</span>
                        </a>
                    </li>

                <?php } ?>

                <?php
                $fileurl = "admin/report/cancelledrecipiet";
                if (in_array($fileurl, $role_permissions)) {
                    ?>

                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/report/cancelledrecipiet">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Search Fee-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Search Fee</span>
                        </a>
                    </li>
                <?php } ?>


                <?php
                $fileurl = "admin/report/studentpendingfeedetails";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/students/studentpendingfeedetails">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Students Pending Fee-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Students Pending Fee</span>
                        </a>
                    </li>

                <?php } ?>

                <?php
                $fileurl = "admin/report/hostelcollection";
                if (in_array($fileurl, $role_permissions)) {
                    ?>

                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/report/hostelcollection">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Hostel Fee Collection-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Hostel Fee Collection</span>
                        </a>
                    </li>

                <?php } ?>

                <li class="returnBack">
                    <a href="#" class="tabHeading"><i class="fas fa-undo"></i> <span>Back To Menu</span></a>
                </li>
            </ul>
        </li>



        <!------------------------------------- permission --------------------------------------->

        <li class="mainMenu3">
            <a data-toggle="tab" href="#menu113">
                <!-- <i class="fa fa-user" aria-hidden="true"></i> -->
                <img src="<?php echo SITE_URL; ?>images/Permission-manager.png">
                <span>Permission</span>
                <i class="fa fa-chevron-right pull-right" aria-hidden="true"></i>

            </a>


            <script>
                $(document).ready(function () {
                    $(".mainMenu3 a").click(function () {
                        $(".mainMenu3").addClass("step2");
                    });
                });
            </script>
            <script>
                $(document).ready(function () {
                    $(".tabHeading").click(function () {
                        $(".mainMenu3").removeClass("step2");
                    });
                });
            </script>
            <!-- <div id="menu113" class="tab-pane fade "> -->
            <ul>
                <!-- <li>
               <a href="#">
                   <i class="fa fa-users"></i>
                   <span>Permission</span>
               </a>
               </li> -->
                <p class="menuBack">
                    <a href="#" class="tabHeading">
                        <!-- <i class="fa fa-users"></i> -->
                        <img src="<?php echo SITE_URL; ?>images/Permission-manager.png" alt="Registration Manager">
                        <span>Permission</span>
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    </a>
                </p>

                <?php
                $fileurl = "admin/Permission/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>

                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/Permission/index">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Permission-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Permission</span>
                        </a>
                    </li>
                <?php } ?>
                <li class="returnBack">
                    <a href="#" class="tabHeading"><i class="fas fa-undo"></i> <span>Back To Menu</span></a>
                </li>
            </ul>
        </li>

        <!------------------------------------- Exam --------------------------------------->

        <li class="mainMenu4">
            <a data-toggle="tab" href="#menu114">
                <!-- <i class="fa fa-user" aria-hidden="true"></i> -->
                <img src="<?php echo SITE_URL; ?>images/Exam-manager.png">
                <span>Exam</span>
                <i class="fa fa-chevron-right pull-right" aria-hidden="true"></i>

            </a>


            <script>
                $(document).ready(function () {
                    $(".mainMenu4 a").click(function () {
                        $(".mainMenu4").addClass("step2");
                    });
                });
            </script>
            <script>
                $(document).ready(function () {
                    $(".tabHeading").click(function () {
                        $(".mainMenu4").removeClass("step2");
                    });
                });
            </script>
            <!-- <div id="menu114" class="tab-pane fade "> -->
            <ul>
                <!-- <li>
               <a href="#">
                   <i class="fa fa-users"></i>
                   <span>Exam</span>
               </a>
               </li> -->
                <p class="menuBack">
                    <a href="#" class="tabHeading">
                        <!-- <i class="fa fa-users"></i> -->
                        <img src="<?php echo SITE_URL; ?>images/Exam-manager.png" alt="Registration Manager">
                        <span>Exam</span>
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    </a>
                </p>

                <?php
                $fileurl = "admin/subject/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>

                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/subject/index">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Subjects-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Subjects</span>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $fileurl = "admin/exam/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>


                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/exam/index">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Add &amp; Update Exam-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Add &amp; Update Exam</span>
                        </a>
                    </li>
                <?php } ?>


                <?php
                $fileurl = "admin/exam/addbacklogstudent";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/exam/addbacklogstudent">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Add Backlog-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Add Backlog</span>
                        </a>
                    </li>
                <?php } ?>

                <li class="returnBack">
                    <a href="#" class="tabHeading"><i class="fas fa-undo"></i> <span>Back To Menu</span></a>
                </li>
            </ul>
        </li>

        <!------------------------------------- School Staff --------------------------------------->

        <li class="mainMenu6">
            <a data-toggle="tab" href="#menu116">
                <!-- <i class="fa fa-user" aria-hidden="true"></i> -->
                <img src="<?php echo SITE_URL; ?>images/School Staff-manager.png">
                <span>School Staff</span>
                <i class="fa fa-chevron-right pull-right" aria-hidden="true"></i>

            </a>


            <script>
                $(document).ready(function () {
                    $(".mainMenu6 a").click(function () {
                        $(".mainMenu6").addClass("step2");
                    });
                });
            </script>
            <script>
                $(document).ready(function () {
                    $(".tabHeading").click(function () {
                        $(".mainMenu6").removeClass("step2");
                    });
                });
            </script>
            <!-- <div id="menu116" class="tab-pane fade "> -->
            <ul>
                <!-- <li>
               <a href="#">
                   <i class="fa fa-users"></i>
                   <span>School Staff</span>
               </a>
               </li> -->
                <p class="menuBack">
                    <a href="#" class="tabHeading">
                        <!-- <i class="fa fa-users"></i> -->
                        <img src="<?php echo SITE_URL; ?>images/School Staff-manager.png" alt="Registration Manager">
                        <span>School Staff</span>
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    </a>
                </p>

                <?php
                $fileurl = "admin/payroll/add";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/payroll/add">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Add Employee-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Add Employee</span>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $fileurl = "admin/employees/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>

                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/employees/index">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Manage Employee-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Manage Employee</span>
                        </a>
                    </li>
                <?php } ?>

                <li class="returnBack">
                    <a href="#" class="tabHeading"><i class="fas fa-undo"></i> <span>Back To Menu</span></a>
                </li>
            </ul>
        </li>

        <!------------------------------------- >Library Management --------------------------------------->

        <li class="mainMenu7 active">
            <a data-toggle="tab" href="#menu117" aria-expanded="true">
                <!-- <i class="fa fa-user" aria-hidden="true"></i> -->
                <img src="<?php echo SITE_URL; ?>images/Library Management-manager.png">
                <span>Library Management</span>
                <i class="fa fa-chevron-right pull-right" aria-hidden="true"></i>

            </a>


            <script>
                $(document).ready(function () {
                    $(".mainMenu7 a").click(function () {
                        $(".mainMenu7").addClass("step2");
                    });
                });
            </script>
            <script>
                $(document).ready(function () {
                    $(".tabHeading").click(function () {
                        $(".mainMenu7").removeClass("step2");
                    });
                });
            </script>
            <!-- <div id="menu117" class="tab-pane fade "> -->
            <ul>
                <!-- <li>
               <a href="#">
                   <i class="fa fa-users"></i>
                   <span>Library Management</span>
               </a>
               </li> -->
                <p class="menuBack">
                    <a href="#" class="tabHeading">
                        <!-- <i class="fa fa-users"></i> -->
                        <img src="<?php echo SITE_URL; ?>images/Library Management-manager.png"
                            alt="Registration Manager">
                        <span>Library Management</span>
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    </a>
                </p>

                <?php
                $fileurl = "admin/issuebooks/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/issuebooks/index">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Issue Book Manager-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Issue Book Manager</span>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $fileurl = "admin/Books/periodicView";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/Books/periodicView">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Periodical Manager-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Periodical Manager</span>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $fileurl = "admin/ReturnRenewBooks/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/ReturnRenewBooks/index">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Deposit Book Manager-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Deposit Book Manager</span>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $fileurl = "admin/Books/create";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/Books/create">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Add Book Manager-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Add Book Manager</span>
                        </a>
                    </li>
                <?php } ?>


                <?php
                $fileurl = "admin/Language/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/Language/index">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Book Language-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Book Language</span>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $fileurl = "admin/BookCategories/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/BookCategories/index">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Book Category-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Book Category</span>
                        </a>
                    </li>
                <?php } ?>


                <?php
                $fileurl = "admin/BookVendors/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/BookVendors/index">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Vendor Manager-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Vendor Manager</span>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $fileurl = "admin/CupBoards/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/CupBoards/index">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Cup Board Manager-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Cup Board Manager</span>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $fileurl = "admin/CupBoardShelves/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/CupBoardShelves/index">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Shelf Manager-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Shelf Manager</span>
                        </a>
                    </li>
                <?php } ?>


                <?php
                $fileurl = "admin/Books/request";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
                    <li style="display: flex; align-items: center;">
                        <a href="<?php echo SITE_URL; ?>admin/Books/request">
                            <!-- <i class="fa fa-reorder"></i> -->
                            <img src="<?php echo SITE_URL; ?>images/subMenu/Book Request-sub.png" alt="submenu"
                                class="submenuIcon">
                            <span>Book Request</span>
                        </a>
                    </li>
                <?php } ?>

                <li class="returnBack">
                    <a href="#" class="tabHeading"><i class="fas fa-undo"></i> <span>Back To Menu</span></a>
                </li>


            </ul>


        </li>


        <!------------------------------------- Store Management --------------------------------------->


        <li class="mainMenu5">
        <a data-toggle="tab" href="#menu115">
            <!-- <i class="fa fa-user" aria-hidden="true"></i> -->
            <img src="<?php echo SITE_URL; ?>images/Store Management-manager.png">
            <span>Store Management</span>
            <i class="fa fa-chevron-right pull-right" aria-hidden="true"></i>

        </a>


        <script>
            $(document).ready(function () {
                $(".mainMenu5 a").click(function () {
                    $(".mainMenu5").addClass("step2");
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $(".tabHeading").click(function () {
                    $(".mainMenu5").removeClass("step2");
                });
            });
        </script>
        <!-- <div id="menu115" class="tab-pane fade "> -->
        <ul>
            <!-- <li>
               <a href="#">
                   <i class="fa fa-users"></i>
                   <span>Store Management</span>
               </a>
               </li> -->
            <p class="menuBack">
                <a href="#" class="tabHeading">
                    <!-- <i class="fa fa-users"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/Store Management-manager.png" alt="Registration Manager">
                    <span>Store Management</span>
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </a>
            </p>



            
            <?php
                $fileurl = "admin/vendors/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/vendors/index">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Vendor Manager-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Vendor Manager</span>
                </a>
            </li>

            <?php } ?>


<?php
                $fileurl = "admin/taxmaster/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/taxmaster/index">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Tax Manager-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Tax Manager</span>
                </a>
            </li>
<?php } ?>


<?php
                $fileurl = "admin/itemcategory/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/itemcategory/index">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Item Category Manager-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Item Category Manager</span>
                </a>
            </li>
            <?php } ?>


            <?php
                $fileurl = "admin/sizemanager/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/sizemanager/index">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Size Manager-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Size Manager</span>
                </a>
            </li>
            <?php } ?>


   <?php
                $fileurl = "admin/paymentmanager/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/paymentmanager/index">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Payment Terms Manager-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Payment Terms Manager</span>
                </a>
            </li>
            <?php } ?>


            <?php
                $fileurl = "admin/additem/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/additem/index">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Add Item Manager-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Add Item Manager</span>
                </a>
            </li>
            <?php } ?>



 <?php
                $fileurl = "admin/indent/add";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/indent/add">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Add Indent-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Add Indent</span>
                </a>
            </li>
            <?php } ?>



 <?php
                $fileurl = "admin/indent/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/indent/index">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Goods Issue-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Goods Issue</span>
                </a>
            </li>

            <?php } ?>

            <?php
                $fileurl = "admin/purchaseorder/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/purchaseorder/index">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/PO-sub.png" alt="submenu" class="submenuIcon">
                    <span>PO</span>
                </a>
            </li>
            <?php } ?>



 <?php
                $fileurl = "admin/goodsreceived/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/goodsreceived/index">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Goods Material Received-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Goods Material Received</span>
                </a>
            </li>
            <?php } ?>


 <?php
                $fileurl = "admin/stockregister/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/stockregister/index">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Stock Register-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Stock Register</span>
                </a>
            </li>
            <?php } ?>



<?php
                $fileurl = "admin/companymaster/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/companymaster/index">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Company Master-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Company Master</span>
                </a>
            </li>
            <?php } ?>

            <?php
                $fileurl = "admin/branchitemrequest/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/branchitemrequest/index">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Branch Store items Request-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Branch Store items Request</span>
                </a>
            </li>
            <?php } ?>

            <?php
                $fileurl = "admin/Itemlocation/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/Itemlocation/index">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Itemlocation Manager-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Itemlocation Manager</span>
                </a>
            </li>
            <?php } ?>

            <?php
                $fileurl = "admin/Solditems/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/Solditems/index">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Solditems-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Solditems</span>
                </a>
            </li>
            <?php } ?>

            <?php
                $fileurl = "admin/stockregister/stockmatching";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/stockregister/stockmatching">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Stock Matching-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Stock Matching</span>
                </a>
            </li>
            <?php } ?>

  <?php
                $fileurl = "admin/salereturn/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/salereturn/index">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Sales Return-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Sales Return</span>
                </a>
            </li>
            <?php } ?>

            <?php
                $fileurl = "admin/Purchasereturn/index";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/Purchasereturn/index">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>images/subMenu/Purchase Return-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Purchase Return</span>
                </a>
            </li>
            <?php } ?>


            <?php
                $fileurl = "admin/stockregister/daily_stockreport";
                if (in_array($fileurl, $role_permissions)) {
                    ?>
            <li style="display: flex; align-items: center;">
                <a href="<?php echo SITE_URL; ?>admin/stockregister/daily_stockreport">
                    <!-- <i class="fa fa-reorder"></i> -->
                    <img src="<?php echo SITE_URL; ?>mages/subMenu/Stock Matertial Report-sub.png" alt="submenu"
                        class="submenuIcon">
                    <span>Stock Matertial Report</span>
                </a>
            </li>
            <?php } ?>

            <li class="returnBack">
                <a href="#" class="tabHeading"><i class="fas fa-undo"></i> <span>Back To Menu</span></a>
            </li>
        </ul>

    </li>




    </ul>
    </li>



    

    






    </ul>
    <!-- </div> -->
    <!--col-sm-3-->
    <!-- </div> -->
    <!--row-->
</section>