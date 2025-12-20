<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Timetables Manager
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header" style="display:flex; justify-content: space-between; align-items: center;">
                        <div style="flex:1">
                            <?php $role = $this->request->session()->read('Auth.User.role_id');
                            $username = $this->request->session()->read('Auth.User.email');?>
                            <!-- /.box-header -->
                            <?php echo $this->Flash->render(); ?>
                            <span class="text-muted" style="font-size: 15px;">
                            <?php if ($classsss) {?>
                            <strong>Class Teacher :</strong> <?php echo $fname; ?> <?php echo $middlename; ?> <?php echo $lname; ?> | <strong>Class Name </strong> <?php echo $classsss; ?> | <strong>Section Name : </strong> <?php echo $sectionsss; ?>	 | <strong>Acedmicyear : </strong> <?php echo $acedimc; ?> 	</span>
                            <?php } else {?>
                            <strong> Teacher :</strong> <?php echo $fname; ?> <?php echo $middlename; ?> <?php echo $lname; ?> | <strong>Acedmicyear : </strong> <?php echo $acedimc; ?></span>
                            <?php }?>
                        </div>

                        <p class="text-right btn-view-group" style="margin-bottom:0px;">
                            <a class="btn btn-primary" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/pdf_teacher/<?php echo $classectionid; ?>" target="blank">
                                <i class="fa fa-file-pdf-o"></i> Export PDF
                            </a>
                        </p>
                    </div>

                    <div class="box-body" id="resizable-tables">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <?php $role = $this->request->session()->read("Auth.User.role_id"); ?>
                                <tr>
                                    <th>Period</th>
                                    <th>Monday</th>
                                    <th>Tuesday</th>
                                    <th>Wednesday</th>
                                    <th>Thursday</th>
                                    <th>Friday</th>
                                    <th>Saturday</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($classectionid) {if (isset($timetabledata) && !empty($timetabledata)) {
                                foreach ($timetabledata as $work) {
                                    $getdata = '0';if ($work['is_break'] != 1) {?>
                                <tr class="hjk">
                                <!--  ---------------Monday-------------------- -->
                                <td class="text-center text-bold"><?php echo $work['name'] ?></td>
                                <td class="text-center" style=" word-break: keep-all;"><?php if (strpos($work['weekday'], "Monday") !== false) {
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
                                    $emp = explode(',', $getdata[0]['employee_id']);
                                    $sub = explode(',', $getdata[0]['subject_id']);
                                 
                                    $subjectname = array();
                                    foreach ($emp as $k => $value) {
                                        foreach ($sub as $s => $val) {
                                         
                                            $vbn = array();
                                            if ($k == $s && $value == $classectionid) {
                                               
                                                $subj = $this->Comman->findclassubject($val);
                                              
                                                $subjectname[$val] = $subj['alias'];
                                            }
                                        }
                                    }
                                    ?>
                                    <span ><?php if (!empty($getdata)) { ?>
                                    <?php $b = array_unique($a);
                                        foreach ($subjectname as $ko => $bhu) {
                                            echo '<span style="color:green;">' . $bhu . '</span>';
                                            $data = 0;
                                            $data = base64_encode($work['id'] . '/Monday/' . $classectionid . '/' . $ko);
                                            if ($role != ADMIN && $role != CENTER_COORDINATOR) {?> <a class="text-green" href="<?php echo SITE_URL; ?>admin/assignments/add/<?php echo $data; ?>" title="Add Assignment" data-toggle="tooltip" style="padding-left:5px;font-size:16px"><i class="fa fa-thumb-tack"></i></a><a class="text-red" href="<?php echo SITE_URL; ?>admin/video/uploadVideo/<?php echo $data; ?>" title="Add Video" data-toggle="tooltip" style="padding-left:5px;font-size:16px"><i class="fa fa-thumb-tack"></i></a><br>
                                    <?php }}?>
                                    <?php
                                        foreach ($b as $key => $va) {
                                                            $sdf = $this->Comman->findclasssectionid($va);
                                                            $sec = $sdf['section_id'];
                                                            $cls = $sdf['class_id'];
                                                            $cl1 = $this->Comman->findclass123($cls);
                                                            $sl2 = $this->Comman->findsection123($sec);
                                                            echo $cl1['title'] . '(' . $sl2['title'] . ')<br>';
                                                        }
                                                        ?>
                                    <?php } else {echo "-";}}?> </span>
                                </td>
                                <!--  ---------------Tuesday-------------------- -->
                                <td class="text-center" style=" word-break: keep-all;"><?php if (strpos($work['weekday'], "Tuesday") !== false) {
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
                                    $emp = explode(',', $getdata[0]['employee_id']);
                                    $sub = explode(',', $getdata[0]['subject_id']);
                                    $subjectname = array();
                                    foreach ($emp as $k => $value) {
                                        foreach ($sub as $s => $val) {
                                            $vbn = array();
                                            if ($k == $s && $value == $classectionid) {
                                                $subj = $this->Comman->findclassubject($val);
                                                $subjectname[$val] = $subj['alias'];
                                            }
                                        }
                                    }
                                    ?>
                                    <span ><?php if (!empty($getdata)) { ?>
                                    <?php $b = array_unique($a);
                                        foreach ($subjectname as $ko => $bhu) {
                                            echo '<span style="color:green;">' . $bhu . '</span>';
                                            $data = 0;
                                            $data = base64_encode($work['id'] . '/Tuesday/' . $classectionid . '/' . $ko);
                                            if ($role != ADMIN && $role != CENTER_COORDINATOR) {?> <a class="text-green" href="<?php echo SITE_URL; ?>admin/assignments/add/<?php echo $data; ?>" title="Add Assignment" data-toggle="tooltip" style="padding-left:5px;font-size:16px"><i class="fa fa-thumb-tack"></i></a><br>
                                    <?php }}?>
                                    <?php
                                        foreach ($b as $key => $va) {
                                                            $sdf = $this->Comman->findclasssectionid($va);
                                                            $sec = $sdf['section_id'];
                                                            $cls = $sdf['class_id'];
                                                            $cl1 = $this->Comman->findclass123($cls);
                                                            $sl2 = $this->Comman->findsection123($sec);
                                                            echo $cl1['title'] . '(' . $sl2['title'] . ')<br>';
                                                        }
                                                        ?>
                                    <?php } else {echo "-";}}?> </span>
                                </td>
                                <!--  ---------------Wednesday-------------------- -->
                                <td class="text-center" style=" word-break: keep-all;"><?php if (strpos($work['weekday'], "Wednesday") !== false) {
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
                                    $emp = explode(',', $getdata[0]['employee_id']);
                                    $sub = explode(',', $getdata[0]['subject_id']);
                                    $subjectname = array();
                                    foreach ($emp as $k => $value) {
                                        foreach ($sub as $s => $val) {
                                            $vbn = array();
                                            if ($k == $s && $value == $classectionid) {
                                                $subj = $this->Comman->findclassubject($val);
                                                $subjectname[$val] = $subj['alias'];
                                            }
                                        }
                                    }
                                    ?>
                                    <span ><?php if (!empty($getdata)) {?>
                                    <?php $b = array_unique($a);
                                        foreach ($subjectname as $ko => $bhu) {
                                            echo '<span style="color:green;">' . $bhu . '</span>';
                                            $data = 0;
                                            $data = base64_encode($work['id'] . '/Wednesday/' . $classectionid . '/' . $ko);
                                            if ($role != ADMIN && $role != CENTER_COORDINATOR) {?> <a class="text-green" href="<?php echo SITE_URL; ?>admin/assignments/add/<?php echo $data; ?>" title="Add Assignment" data-toggle="tooltip" style="padding-left:5px;font-size:16px"><i class="fa fa-thumb-tack"></i></a><br>
                                    <?php }}?>
                                    <?php
                                        foreach ($b as $key => $va) {
                                                            $sdf = $this->Comman->findclasssectionid($va);
                                                            $sec = $sdf['section_id'];
                                                            $cls = $sdf['class_id'];
                                                            $cl1 = $this->Comman->findclass123($cls);
                                                            $sl2 = $this->Comman->findsection123($sec);
                                                            echo $cl1['title'] . '(' . $sl2['title'] . ')<br>';
                                                        }
                                                        ?>
                                    <?php } else {echo "-";}}?> </span>
                                </td>
                                <!--  ---------------Thursday-------------------- -->
                                <td class="text-center" style=" word-break: keep-all;"><?php if (strpos($work['weekday'], "Thursday") !== false) {
                                    $getdata = $this->Comman->gettimetableteacher($work['id'], "Thursday", $classectionid);
                                    $a = array();
                                    foreach ($getdata as $key => $value2) {
                                        $a[] = $value2['class_id'];
                                    }
                                    $clsssection = $this->Comman->find_alls($getdata[0]['class_id']);
                                    $class = $clsssection['class_id'];
                                    $section = $clsssection['section_id'];
                                    $classtitle = $clsssection['Classes']['title'];
                                    $sectiontitle = $clsssection['Sections']['title'];
                                    $emp = explode(',', $getdata[0]['employee_id']);
                                    $sub = explode(',', $getdata[0]['subject_id']);
                                    $subjectname = array();
                                    foreach ($emp as $k => $value) {
                                        foreach ($sub as $s => $val) {
                                            $vbn = array();
                                            if ($k == $s && $value == $classectionid) {
                                                $subj = $this->Comman->findclassubject($val);
                                                $subjectname[$val] = $subj['alias'];
                                            }
                                        }
                                    }
                                    ?>
                                    <span ><?php if (!empty($getdata)) { ?>
                                    <?php $b = array_unique($a);
                                        foreach ($subjectname as $ko => $bhu) {
                                            echo '<span style="color:green;">' . $bhu . '</span>';
                                            $data = 0;
                                            $data = base64_encode($work['id'] . '/Thursday/' . $classectionid . '/' . $ko);
                                            if ($role != ADMIN && $role != CENTER_COORDINATOR) {?> <a class="text-green" href="<?php echo SITE_URL; ?>admin/assignments/add/<?php echo $data; ?>" title="Add Assignment" data-toggle="tooltip" style="padding-left:5px;font-size:16px"><i class="fa fa-thumb-tack"></i></a><br>
                                    <?php }}?>
                                    <?php
                                        foreach ($b as $key => $va) {
                                                            $sdf = $this->Comman->findclasssectionid($va);
                                                            $sec = $sdf['section_id'];
                                                            $cls = $sdf['class_id'];
                                                            $cl1 = $this->Comman->findclass123($cls);
                                                            $sl2 = $this->Comman->findsection123($sec);
                                                            echo $cl1['title'] . '(' . $sl2['title'] . ')<br>';
                                                        }
                                                        ?>
                                    <?php } else {echo "-";}}?> </span>
                                </td>
                                <!--  ---------------Friday-------------------- -->
                                <td class="text-center" style=" word-break: keep-all;">  <?php if (strpos($work['weekday'], "Friday") !== false) {
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
                                    $emp = explode(',', $getdata[0]['employee_id']);
                                    $sub = explode(',', $getdata[0]['subject_id']);
                                    $subjectname = array();
                                    foreach ($emp as $k => $value) {
                                        foreach ($sub as $s => $val) {
                                            $vbn = array();
                                            if ($k == $s && $value == $classectionid) {
                                                $subj = $this->Comman->findclassubject($val);
                                              
                                                $subjectname[$val] = $subj['alias'];
                                            }
                                        }
                                    }
                                    ?>
                                    <span ><?php if (!empty($getdata)) { ?>
                                    <?php $b = array_unique($a);
                                        foreach ($subjectname as $ko => $bhu) {
                                            echo '<span style="color:green;">' . $bhu . '</span>';
                                            $data = 0;
                                            $data = base64_encode($work['id'] . '/Friday/' . $classectionid . '/' . $ko);
                                            if ($role != ADMIN && $role != CENTER_COORDINATOR) {?> <a class="text-green" href="<?php echo SITE_URL; ?>admin/assignments/add/<?php echo $data; ?>" title="Add Assignment" data-toggle="tooltip" style="padding-left:5px;font-size:16px"><i class="fa fa-thumb-tack"></i></a><br>
                                    <?php }}?>
                                    <?php
                                        foreach ($b as $key => $va) {
                                                            $sdf = $this->Comman->findclasssectionid($va);
                                                            $sec = $sdf['section_id'];
                                                            $cls = $sdf['class_id'];
                                                            $cl1 = $this->Comman->findclass123($cls);
                                                            $sl2 = $this->Comman->findsection123($sec);
                                                            echo $cl1['title'] . '(' . $sl2['title'] . ')<br>';
                                                        }
                                                        ?>
                                    <?php } else {echo "-";}}?> </span>
                                </td>
                                <!--  ---------------Saturday-------------------- -->
                                <td class="text-center" style=" word-break: keep-all;"> <?php if (strpos($work['weekday'], "Saturday") !== false) {
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
                                    $emp = explode(',', $getdata[0]['employee_id']);
                                    $sub = explode(',', $getdata[0]['subject_id']); 
                                    $subjectname = array();
                                    foreach ($emp as $k => $value) {
                                        foreach ($sub as $s => $val) {
                                         
                                            $vbn = array();
                                            if ($k == $s && $value == $classectionid) {
                                            
                                                $subj = $this->Comman->findclassubject($val);
                                              
                                                $subjectname[$val] = $subj['alias'];
                                            }
                                        }
                                    }
                                    ?>
                                    <span ><?php if (!empty($getdata)) { ?>
                                    <?php $b = array_unique($a);
                                        foreach ($subjectname as $ko => $bhu) {
                                            echo '<span style="color:green;">' . $bhu . '</span>';
                                            $data = 0;
                                            $data = base64_encode($work['id'] . '/Saturday/' . $classectionid . '/' . $ko);
                                            if ($role != ADMIN && $role != CENTER_COORDINATOR) {?> <a class="text-green" href="<?php echo SITE_URL; ?>admin/assignments/add/<?php echo $data; ?>" title="Add Assignment" data-toggle="tooltip" style="padding-left:5px;font-size:16px"><i class="fa fa-thumb-tack"></i></a><br>
                                    <?php }}?>
                                    <?php
                                        foreach ($b as $key => $va) {
                                                            $sdf = $this->Comman->findclasssectionid($va);
                                                            $sec = $sdf['section_id'];
                                                            $cls = $sdf['class_id'];
                                                            $cl1 = $this->Comman->findclass123($cls);
                                                            $sl2 = $this->Comman->findsection123($sec);
                                                            echo $cl1['title'] . '(' . $sl2['title'] . ')<br>';
                                                        }
                                                        ?>
                                    <?php } else {echo "-";}}?> </span>
                                </td>
                                </tr>
                                <?php }if ($work['is_break']) {if ($work['time_from']) {?>
                                <tr class="hjk">
                                <td class="text-center text-bold"><?php echo $work['name'] ?></td>
                                <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;"  > Break</span></td>
                                <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;" >Break</span></td>
                                <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;" >Break</span></td>
                                <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;" >Break</span></td>
                                <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;" >Break</span></td>
                                <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;" >Break</span></td>
                                </tr>
                                <?php }}}}?>
                                <?php } else {?>
                                <tr>
                                <td class="text-center text-bold" colspan="7">No Data Selected</td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                        <script>
                            //prepare the dialog
                            //respond to click event on anything with 'overlay' class
                            $(".globalModals").click(function(event){
                                $('.modal-content').load($(this).attr("href"));  //load content from href of link
                                });
                            $(".globalModalss").click(function(event){
                                $('.modal-content').load($(this).attr("href"));  //load content from href of link
                                });
                        </script>
                        <div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
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
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>