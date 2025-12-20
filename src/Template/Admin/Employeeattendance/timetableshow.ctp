<?php
//pr($absnt_report);die;
$absnt_perio = array();
$absent_per = array();
$absnt_perio = explode(',', $absnt_report['absent_periods']);
//pr($absnt_perio);
foreach ($absnt_perio as $valu) {
    $absent_per[] = ltrim($valu, "A");
}
//pr($absent_per);?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Staff Timetable Manager

    </h1>

  </section>

  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <?php $role = $this->request->session()->read('Auth.User.role_id');
$username = $this->request->session()->read('Auth.User.email');?>
          <!-- /.box-header -->
          <?php echo $this->Flash->render(); ?>
          <span class="text-muted" style="padding-left: 10px; font-size: 15px;">
            <?php if ($classsss) {?>
            <strong>Class Teacher :</strong> <?php echo $fname; ?> <?php echo $middlename; ?> <?php echo $lname; ?>
            <!-- | <strong>Section Name : </strong> <?php echo $sectionsss; ?> -->
            <!--  | <strong>Acedmicyear : </strong> <?php echo $acedimc; ?>  </span> -->

            <?php } else {?>
            <strong> Teacher :</strong> <?php echo $fname; ?> <?php echo $middlename; ?> <?php echo $lname; ?> </span>

          <?php }?>
        </div>
      </div>
    </div>



    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <i class="fa fa-search" aria-hidden="true"></i>
            <h3 class="box-title">TimeTable </h3>


          </div>
          <div class="row">
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-12">
              <!-- Horizontal Form -->
              <div class="box box-info">

                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                  <div class="box-body" id="resizable-tables">
                    <table class="table table-bordered table-striped">
                      <thead>

                        <!--      <p class="text-right btn-view-group">
  <a class="btn btn-primary" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/pdf_teacher" target="blank"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
  </p>
 -->


                        <tr>

                          <th class="text-center bg-teal color-palette">Class Timing</th>
                          <?php
$date = date('Y-m-d');

// parse about any English textual datetime description into a Unix timestamp
$ts = strtotime($date);
// find the year (ISO-8601 year number) and the current week
$year = date('o', $ts);
$week = date('W', $ts);
// print week for the current date
for ($i = 1; $i <= 7; $i++) {?>
                          <?php
$ts = strtotime($year . 'W' . $week . $i);
    $hol = date("l", $ts);
    if ($hol != 'Sunday') {?>

                          <th class="text-center bg-teal color-palette"> <?php $ts = strtotime($year . 'W' . $week . $i);

        print date("d-m-Y", $ts) . "<br>" . date("l", $ts);?></th>
                          <?php }}?>



                        </tr>
                      </thead>

                      <style type="text/css">
                      .unselectable1 {
                        background-color: #ddd;
                        cursor: not-allowed;
                      }

                      a.unselectable {
                        pointer-events: none;
                      }
                      </style>



                      <tbody>
                        <?php if ($classectionid) {if (isset($timetabledata) && !empty($timetabledata)) {
    $p = 0;
    $status = '';
    foreach ($timetabledata as $work) { //pr($work);

        $getdata = '0';if ($work['is_break'] != 1) {
            $timetab_per[$p] = $work['name'][0];
            $status = in_array($timetab_per[$p], $absent_per);
            //echo $status;
            //pr($timetab_per);
            ?>
                        <tr>
                          <?php

            $day = date("l");?>


                          <td class="text-center"><?php echo '<b>' . $work['name'] . ' </b>'; ?> </td>

                          <!--  ---------------Monday-------------------- -->

                          <td class="text-center <?php if ($day != 'Monday' || $status != 1) {?>unselectable1 <?php }?>"
                            style="word-break: keep-all;"><?php if (strpos($work['weekday'], "Monday") !== false) {

                $getdata = $this->Comman->gettimetableteacher($work['id'], "Monday", $classectionid);

                $a = array();
                foreach ($getdata as $key => $value2) {
                    $a[] = $value2['class_id'];

                }

                $clsssection = $this->Comman->find_alls($getdata[0]['class_id']);
                $class = $clsssection['class_id'];

                $section = $clsssection['section_id'];
                $classtitle = $clsssection['Classes']['title'];
                $sectiontitle = $clsssection['Sections']['title'];
                $cksub = $this->Comman->checksubstitute($work['id'], "Monday", $class, $emp1);
                //pr($cksub);
                $nid = $cksub[0]['new_empid'];
                $fsub = $this->Comman->findempname($nid);

                $emp = explode(',', $getdata[0]['employee_id']);
                $sub = explode(',', $getdata[0]['subject_id']);
                //pr($emp); pr($sub); pr($classectionid);
                $subjectname = "";
                foreach ($emp as $k => $value) {
                    foreach ($sub as $s => $val) {
                        $vbn = array();
                        if ($k == $s && $value == $classectionid) {

                            //pr($getteac);
                            $subj = $this->Comman->findclassubject($val);
                            $subjectname = $subj['alias'];

                        }
                    }
                }

                ?>

                            <span>



                              <?php if (!empty($getdata)) {if (empty($cksub)) {?><a
                                class="globalModalshh <?php if ($day != 'Monday' || $status != 1) {?>unselectable <?php }?>"
                                href="<?php echo SITE_URL; ?>admin/Employeeattendance/add/<?php echo $work['id'] ?>/<?php echo $class; ?>/Monday/<?php echo $emp1; ?>/<?php echo $section; ?>"
                                data-target="#globalModal" data-toggle="modal">

                                <?php $b = array_unique($a);

                    foreach ($b as $key => $va) {
                        $sdf = $this->Comman->findclasssectionid($va);

                        $sec = $sdf['section_id'];
                        $cls = $sdf['class_id'];
                        $cl1 = $this->Comman->findclass123($cls);
                        $sl2 = $this->Comman->findsection123($sec);

                        //pr($cl1['title']); pr($sl2['title']);
                        echo $subjectname;
                        $subjectname = "";

                        ?>

                              </a> </br><?php echo $cl1['title'] . '(' . $sl2['title'] . ')';} ?>

                              <?php } else {?>


                              <a class="globalModalshh"
                                href="<?php echo SITE_URL; ?>admin/Employeeattendance/edit/<?php echo $cksub[0]['id'] ?>/<?php echo $emp1; ?>"
                                data-target="#globalModal <?php if ($day != 'Monday' || $status != 1) {?>unselectable <?php }?>"
                                data-toggle="modal">

                                <?php $b = array_unique($a);

                    foreach ($b as $key => $va) {
                        $sdf = $this->Comman->findclasssectionid($va);

                        $sec = $sdf['section_id'];
                        $cls = $sdf['class_id'];
                        $cl1 = $this->Comman->findclass123($cls);
                        $sl2 = $this->Comman->findsection123($sec);

                        //pr($cl1['title']); pr($sl2['title']);
                        echo $subjectname;
                        $subjectname = "";?></a>

                              </br><?php echo $cl1['title'] . '(' . $sl2['title'] . ')';} ?>
                              <br>
                              <p style="color:green;">
                                <b><?php echo $fsub['fname'] . ' ' . $fsub['middlename'] . ' ' . $fsub['lname']; ?></b>
                              </p>

                              <?php }?>



                              <?php } else {echo "-";}?>
                            </span> <?php }?></td>


                          <!--  ---------------Tuesday-------------------- -->



                          <td
                            class="text-center <?php if ($day != 'Tuesday' || $status != 1) {?>unselectable1 <?php }?>"
                            style=" word-break: keep-all;"><?php if (strpos($work['weekday'], "Tuesday") !== false) {

                $getdata = $this->Comman->gettimetableteacher($work['id'], "Tuesday", $classectionid);

                $a = array();
                foreach ($getdata as $key => $value2) {
                    $a[] = $value2['class_id'];

                }

                $clsssection = $this->Comman->find_alls($getdata[0]['class_id']);
                $class = $clsssection['class_id'];

                $section = $clsssection['section_id'];
                $classtitle = $clsssection['Classes']['title'];
                $sectiontitle = $clsssection['Sections']['title'];
                $cksub = $this->Comman->checksubstitute($work['id'], "Tuesday", $class, $emp1);
                //pr($cksub);
                $nid = $cksub[0]['new_empid'];
                $fsub = $this->Comman->findempname($nid);

                $emp = explode(',', $getdata[0]['employee_id']);
                $sub = explode(',', $getdata[0]['subject_id']);
                //pr($emp); pr($sub); pr($classectionid);
                $subjectname = "";
                foreach ($emp as $k => $value) {
                    foreach ($sub as $s => $val) {
                        $vbn = array();
                        if ($k == $s && $value == $classectionid) {

                            //pr($getteac);
                            $subj = $this->Comman->findclassubject($val);
                            $subjectname = $subj['alias'];

                        }
                    }
                }

                ?>

                            <span>



                              <?php if (!empty($getdata)) {if (empty($cksub)) {?><a
                                class="globalModalshh <?php if ($day != 'Tuesday' || $status != 1) {?>unselectable <?php }?>"
                                href="<?php echo SITE_URL; ?>admin/Employeeattendance/add/<?php echo $work['id'] ?>/<?php echo $class; ?>/Tuesday/<?php echo $emp1; ?>/<?php echo $section; ?>"
                                data-target="#globalModal" data-toggle="modal">

                                <?php $b = array_unique($a);

                    foreach ($b as $key => $va) {
                        $sdf = $this->Comman->findclasssectionid($va);

                        $sec = $sdf['section_id'];
                        $cls = $sdf['class_id'];
                        $cl1 = $this->Comman->findclass123($cls);
                        $sl2 = $this->Comman->findsection123($sec);

                        //pr($cl1['title']); pr($sl2['title']);
                        echo $subjectname;
                        $subjectname = "";

                        ?>

                              </a> </br><?php echo $cl1['title'] . '(' . $sl2['title'] . ')';} ?>

                              <?php } else {?>


                              <a class="globalModalshh"
                                href="<?php echo SITE_URL; ?>admin/Employeeattendance/edit/<?php echo $cksub[0]['id'] ?>/<?php echo $emp1; ?>"
                                data-target="#globalModal <?php if ($day != 'Tuesday' || $status != 1) {?>unselectable <?php }?>"
                                data-toggle="modal">

                                <?php $b = array_unique($a);

                    foreach ($b as $key => $va) {
                        $sdf = $this->Comman->findclasssectionid($va);

                        $sec = $sdf['section_id'];
                        $cls = $sdf['class_id'];
                        $cl1 = $this->Comman->findclass123($cls);
                        $sl2 = $this->Comman->findsection123($sec);

                        //pr($cl1['title']); pr($sl2['title']);
                        echo $subjectname;
                        $subjectname = "";?></a>

                              </br><?php echo $cl1['title'] . '(' . $sl2['title'] . ')';} ?>
                              <br>
                              <p style="color:green;">
                                <b><?php echo $fsub['fname'] . ' ' . $fsub['middlename'] . ' ' . $fsub['lname']; ?></b>
                              </p>

                              <?php }?>



                              <?php } else {echo "-";}?>
                            </span> <?php }?></td>

                          <!--  ---------------Wednesday-------------------- -->

                          <td
                            class="text-center <?php if ($day != 'Wednesday' || $status != 1) {?>unselectable1 <?php }?>"
                            style=" word-break: keep-all;"><?php if (strpos($work['weekday'], "Wednesday") !== false) {
                $getdata = $this->Comman->gettimetableteacher($work['id'], "Wednesday", $classectionid);
                $a = array();
                foreach ($getdata as $key => $value2) {
                    $a[] = $value2['class_id'];

                }

                $clsssection = $this->Comman->find_alls($getdata[0]['class_id']);
                $class = $clsssection['class_id'];

                $section = $clsssection['section_id'];
                $classtitle = $clsssection['Classes']['title'];
                $sectiontitle = $clsssection['Sections']['title'];
                $cksub = $this->Comman->checksubstitute($work['id'], "Wednesday", $class, $emp1);
                //pr($cksub);
                $nid = $cksub[0]['new_empid'];
                $fsub = $this->Comman->findempname($nid);

                $emp = explode(',', $getdata[0]['employee_id']);
                $sub = explode(',', $getdata[0]['subject_id']);
                //pr($emp); pr($sub); pr($classectionid);
                $subjectname = "";
                foreach ($emp as $k => $value) {
                    foreach ($sub as $s => $val) {
                        $vbn = array();
                        if ($k == $s && $value == $classectionid) {

                            //pr($getteac);
                            $subj = $this->Comman->findclassubject($val);
                            $subjectname = $subj['alias'];

                        }
                    }
                }

                ?>

                            <span>



                              <?php if (!empty($getdata)) {if (empty($cksub)) {?><a
                                class="globalModalshh <?php if ($day != 'Wednesday' || $status != 1) {?>unselectable <?php }?>"
                                href="<?php echo SITE_URL; ?>admin/Employeeattendance/add/<?php echo $work['id'] ?>/<?php echo $class; ?>/Wednesday/<?php echo $emp1; ?>/<?php echo $section; ?>"
                                data-target="#globalModal" data-toggle="modal">

                                <?php $b = array_unique($a);

                    foreach ($b as $key => $va) {
                        $sdf = $this->Comman->findclasssectionid($va);

                        $sec = $sdf['section_id'];
                        $cls = $sdf['class_id'];
                        $cl1 = $this->Comman->findclass123($cls);
                        $sl2 = $this->Comman->findsection123($sec);

                        //pr($cl1['title']); pr($sl2['title']);
                        echo $subjectname;
                        $subjectname = "";

                        ?>

                              </a> </br><?php echo $cl1['title'] . '(' . $sl2['title'] . ')';} ?>

                              <?php } else {?>


                              <a class="globalModalshh"
                                href="<?php echo SITE_URL; ?>admin/Employeeattendance/edit/<?php echo $cksub[0]['id'] ?>/<?php echo $emp1; ?>"
                                data-target="#globalModal <?php if ($day != 'Wednesday' || $status != 1) {?>unselectable <?php }?>"
                                data-toggle="modal">

                                <?php $b = array_unique($a);

                    foreach ($b as $key => $va) {
                        $sdf = $this->Comman->findclasssectionid($va);

                        $sec = $sdf['section_id'];
                        $cls = $sdf['class_id'];
                        $cl1 = $this->Comman->findclass123($cls);
                        $sl2 = $this->Comman->findsection123($sec);

                        //pr($cl1['title']); pr($sl2['title']);
                        echo $subjectname;
                        $subjectname = "";?></a>

                              </br><?php echo $cl1['title'] . '(' . $sl2['title'] . ')';} ?>
                              <br>
                              <p style="color:green;">
                                <b><?php echo $fsub['fname'] . ' ' . $fsub['middlename'] . ' ' . $fsub['lname']; ?></b>
                              </p>

                              <?php }?>



                              <?php } else {echo "-";}?>
                            </span> <?php }?></td>


                          <!--  ---------------Thursday-------------------- -->

                          <td
                            class="text-center <?php if ($day != 'Thursday' || $status != 1) {?>unselectable1 <?php }?>"
                            style=" word-break: keep-all;"><?php if (strpos($work['weekday'], "Thursday") !== false) {

                $getdata = $this->Comman->gettimetableteacher($work['id'], "Thursday", $classectionid);
                //pr($getdata);
                $a = array();
                foreach ($getdata as $key => $value2) {
                    $a[] = $value2['class_id'];

                }

                $clsssection = $this->Comman->find_alls($getdata[0]['class_id']);
                $class = $clsssection['class_id'];

                $section = $clsssection['section_id'];
                $classtitle = $clsssection['Classes']['title'];
                $sectiontitle = $clsssection['Sections']['title'];
                $cksub = $this->Comman->checksubstitute($work['id'], "Thursday", $class, $emp1);
                //pr($cksub);
                $nid = $cksub[0]['new_empid'];
                $fsub = $this->Comman->findempname($nid);

                $emp = explode(',', $getdata[0]['employee_id']);
                $sub = explode(',', $getdata[0]['subject_id']);
                //pr($emp); pr($sub); pr($classectionid);
                $subjectname = "";
                foreach ($emp as $k => $value) {
                    foreach ($sub as $s => $val) {
                        $vbn = array();
                        if ($k == $s && $value == $classectionid) {

                            //pr($getteac);
                            $subj = $this->Comman->findclassubject($val);
                            $subjectname = $subj['alias'];

                        }
                    }
                }

                ?>

                            <span>



                              <?php if (!empty($getdata)) {if (empty($cksub)) {?><a
                                class="globalModalshh <?php if ($day != 'Thursday' || $status != 1) {?>unselectable <?php }?>"
                                href="<?php echo SITE_URL; ?>admin/Employeeattendance/add/<?php echo $work['id'] ?>/<?php echo $class; ?>/Thursday/<?php echo $emp1; ?>/<?php echo $section; ?>"
                                data-target="#globalModal" data-toggle="modal">

                                <?php $b = array_unique($a);

                    foreach ($b as $key => $va) {
                        $sdf = $this->Comman->findclasssectionid($va);

                        $sec = $sdf['section_id'];
                        $cls = $sdf['class_id'];
                        $cl1 = $this->Comman->findclass123($cls);
                        $sl2 = $this->Comman->findsection123($sec);

                        //pr($cl1['title']); pr($sl2['title']);
                        echo $subjectname;
                        $subjectname = "";

                        ?>

                              </a> </br><?php echo $cl1['title'] . '(' . $sl2['title'] . ')';} ?>

                              <?php } else {?>


                              <a class="globalModalshh"
                                href="<?php echo SITE_URL; ?>admin/Employeeattendance/edit/<?php echo $cksub[0]['id'] ?>/<?php echo $emp1; ?>"
                                data-target="#globalModal <?php if ($day != 'Thursday' || $status != 1) {?>unselectable <?php }?>"
                                data-toggle="modal">

                                <?php $b = array_unique($a);

                    foreach ($b as $key => $va) {
                        $sdf = $this->Comman->findclasssectionid($va);

                        $sec = $sdf['section_id'];
                        $cls = $sdf['class_id'];
                        $cl1 = $this->Comman->findclass123($cls);
                        $sl2 = $this->Comman->findsection123($sec);

                        //pr($cl1['title']); pr($sl2['title']);
                        echo $subjectname;
                        $subjectname = "";?></a>

                              </br><?php echo $cl1['title'] . '(' . $sl2['title'] . ')';} ?>
                              <br>
                              <p style="color:green;">
                                <b><?php echo $fsub['fname'] . ' ' . $fsub['middlename'] . ' ' . $fsub['lname']; ?></b>
                              </p>

                              <?php }?>



                              <?php } else {echo "-";}?>
                            </span> <?php }?></td>

                          <!--  ---------------Friday-------------------- -->

                          <td class="text-center <?php if ($day != 'Friday' || $status != 1) {?>unselectable1 <?php }?>"
                            style=" word-break: keep-all;"> <?php if (strpos($work['weekday'], "Friday") !== false) {

                $getdata = $this->Comman->gettimetableteacher($work['id'], "Friday", $classectionid);

                $a = array();
                foreach ($getdata as $key => $value2) {
                    $a[] = $value2['class_id'];

                }

                $clsssection = $this->Comman->find_alls($getdata[0]['class_id']);
                $class = $clsssection['class_id'];

                $section = $clsssection['section_id'];
                $classtitle = $clsssection['Classes']['title'];
                $sectiontitle = $clsssection['Sections']['title'];
                $cksub = $this->Comman->checksubstitute($work['id'], "Friday", $class, $emp1);
                //pr($cksub);
                $nid = $cksub[0]['new_empid'];
                $fsub = $this->Comman->findempname($nid);

                $emp = explode(',', $getdata[0]['employee_id']);
                $sub = explode(',', $getdata[0]['subject_id']);
                //pr($emp); pr($sub); pr($classectionid);
                $subjectname = "";
                foreach ($emp as $k => $value) {
                    foreach ($sub as $s => $val) {
                        $vbn = array();
                        if ($k == $s && $value == $classectionid) {

                            //pr($getteac);
                            $subj = $this->Comman->findclassubject($val);
                            $subjectname = $subj['alias'];

                        }
                    }
                }

                ?>

                            <span>



                              <?php if (!empty($getdata)) {if (empty($cksub)) {?><a
                                class="globalModalshh <?php if ($day != 'Friday' || $status != 1) {?>unselectable <?php }?>"
                                href="<?php echo SITE_URL; ?>admin/Employeeattendance/add/<?php echo $work['id'] ?>/<?php echo $class; ?>/Friday/<?php echo $emp1; ?>/<?php echo $section; ?>"
                                data-target="#globalModal" data-toggle="modal">

                                <?php $b = array_unique($a);

                    foreach ($b as $key => $va) {
                        $sdf = $this->Comman->findclasssectionid($va);

                        $sec = $sdf['section_id'];
                        $cls = $sdf['class_id'];
                        $cl1 = $this->Comman->findclass123($cls);
                        $sl2 = $this->Comman->findsection123($sec);

                        //pr($cl1['title']); pr($sl2['title']);
                        echo $subjectname;
                        $subjectname = "";

                        ?>

                              </a> </br><?php echo $cl1['title'] . '(' . $sl2['title'] . ')';} ?>

                              <?php } else {?>


                              <a class="globalModalshh"
                                href="<?php echo SITE_URL; ?>admin/Employeeattendance/edit/<?php echo $cksub[0]['id'] ?>/<?php echo $emp1; ?>"
                                data-target="#globalModal <?php if ($day != 'Friday' || $status != 1) {?>unselectable <?php }?>"
                                data-toggle="modal">

                                <?php $b = array_unique($a);

                    foreach ($b as $key => $va) {
                        $sdf = $this->Comman->findclasssectionid($va);

                        $sec = $sdf['section_id'];
                        $cls = $sdf['class_id'];
                        $cl1 = $this->Comman->findclass123($cls);
                        $sl2 = $this->Comman->findsection123($sec);

                        //pr($cl1['title']); pr($sl2['title']);
                        echo $subjectname;
                        $subjectname = "";?></a>

                              </br><?php echo $cl1['title'] . '(' . $sl2['title'] . ')';} ?>
                              <br>
                              <p style="color:green;">
                                <b><?php echo $fsub['fname'] . ' ' . $fsub['middlename'] . ' ' . $fsub['lname']; ?></b>
                              </p>

                              <?php }?>



                              <?php } else {echo "-";}?>
                            </span> <?php }?></td>


                          <!--  ---------------Saturday-------------------- -->


                          <td
                            class="text-center <?php if ($day != 'Saturday' || $status != 1) {?>unselectable1 <?php }?>"
                            style=" word-break: keep-all;"> <?php if (strpos($work['weekday'], "Saturday") !== false) {

                $getdata = $this->Comman->gettimetableteacher($work['id'], "Saturday", $classectionid);

                $a = array();
                foreach ($getdata as $key => $value2) {
                    $a[] = $value2['class_id'];

                }

                $clsssection = $this->Comman->find_alls($getdata[0]['class_id']);
                $class = $clsssection['class_id'];

                $section = $clsssection['section_id'];
                $classtitle = $clsssection['Classes']['title'];
                $sectiontitle = $clsssection['Sections']['title'];
                $cksub = $this->Comman->checksubstitute($work['id'], "Saturday", $class, $emp1);
                //pr($cksub);
                $nid = $cksub[0]['new_empid'];
                $fsub = $this->Comman->findempname($nid);

                $emp = explode(',', $getdata[0]['employee_id']);
                $sub = explode(',', $getdata[0]['subject_id']);
                //pr($emp); pr($sub); pr($classectionid);
                $subjectname = "";
                foreach ($emp as $k => $value) {
                    foreach ($sub as $s => $val) {
                        $vbn = array();
                        if ($k == $s && $value == $classectionid) {

                            //pr($getteac);
                            $subj = $this->Comman->findclassubject($val);
                            $subjectname = $subj['alias'];

                        }
                    }
                }

                ?>

                            <span>



                              <?php if (!empty($getdata)) {if (empty($cksub)) {?><a
                                class="globalModalshh <?php if ($day != 'Saturday' || $status != 1) {?>unselectable <?php }?>"
                                href="<?php echo SITE_URL; ?>admin/Employeeattendance/add/<?php echo $work['id'] ?>/<?php echo $class; ?>/Saturday/<?php echo $emp1; ?>/<?php echo $section; ?>"
                                data-target="#globalModal" data-toggle="modal">

                                <?php $b = array_unique($a);

                    foreach ($b as $key => $va) {
                        $sdf = $this->Comman->findclasssectionid($va);

                        $sec = $sdf['section_id'];
                        $cls = $sdf['class_id'];
                        $cl1 = $this->Comman->findclass123($cls);
                        $sl2 = $this->Comman->findsection123($sec);

                        //pr($cl1['title']); pr($sl2['title']);
                        echo $subjectname;
                        $subjectname = "";

                        ?>

                              </a> </br><?php echo $cl1['title'] . '(' . $sl2['title'] . ')';} ?>

                              <?php } else {?>


                              <a class="globalModalshh"
                                href="<?php echo SITE_URL; ?>admin/Employeeattendance/edit/<?php echo $cksub[0]['id'] ?>/<?php echo $emp1; ?>"
                                data-target="#globalModal <?php if ($day != 'Saturday' || $status != 1) {?>unselectable <?php }?>"
                                data-toggle="modal">

                                <?php $b = array_unique($a);

                    foreach ($b as $key => $va) {
                        $sdf = $this->Comman->findclasssectionid($va);

                        $sec = $sdf['section_id'];
                        $cls = $sdf['class_id'];
                        $cl1 = $this->Comman->findclass123($cls);
                        $sl2 = $this->Comman->findsection123($sec);

                        //pr($cl1['title']); pr($sl2['title']);
                        echo $subjectname;
                        $subjectname = "";?></a>

                              </br><?php echo $cl1['title'] . '(' . $sl2['title'] . ')';} ?>
                              <br>
                              <p style="color:green;">
                                <b><?php echo $fsub['fname'] . ' ' . $fsub['middlename'] . ' ' . $fsub['lname']; ?></b>
                              </p>

                              <?php }?>



                              <?php } else {echo "-";}?>
                            </span> <?php }?></td>
                        </tr>

                        <?}if ($work['is_break'] == 1) {if ($work['time_from']) {?>


                        <tr>
                          <td class="text-center"><?php echo '<b>' . $work['name'] . '</b>'; ?></td>

                          <td class="text-center" style=" word-break: keep-all;"><span title="Break"
                              data-toggle="tooltip" style="color:red;"> Break</span></td>
                          <td class="text-center" style=" word-break: keep-all;"><span title="Break"
                              data-toggle="tooltip" style="color:red;">Break</span></td>
                          <td class="text-center" style=" word-break: keep-all;"><span title="Break"
                              data-toggle="tooltip" style="color:red;">Break</span></td>
                          <td class="text-center" style=" word-break: keep-all;"><span title="Break"
                              data-toggle="tooltip" style="color:red;">Break</span></td>
                          <td class="text-center" style=" word-break: keep-all;"><span title="Break"
                              data-toggle="tooltip" style="color:red;">Break</span></td>
                          <td class="text-center" style=" word-break: keep-all;"><span title="Break"
                              data-toggle="tooltip" style="color:red;">Break</span></td>
                        </tr>



                        <?php }}
        $p++;
    }}?>

                        <?php } else {?>
                        <tr>
                          <td class="text-center text-bold" colspan="7">No Data Selected</td>
                        </tr><?php }?>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<script>
//prepare the dialog

//respond to click event on anything with 'overlay' class
$(".globalModalshh").click(function(event) {

  //alert();

  $('.modal-contents').load($(this).attr("href")); //load content from href of link

});





$(".globalModalss").click(function(event) {



  $('.modal-content').load($(this).attr("href")); //load content from href of link

});
</script>


<div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-contents" style="background-color: #fff;">
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
