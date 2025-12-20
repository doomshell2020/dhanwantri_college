<?php $array = array();
foreach ($employee as $key => $value) {
    $array[$key] = str_replace(";", " ", $value);
} ?>
<?php $array1 = array();
foreach ($newemployees as $key => $value) {
    $array1[$key] = str_replace(";", " ", $value);
} ?>
<div class="box-header" style="margin-top:15px;margin-bottom:15px">
    <div class="row">
        <?php echo $this->Form->create('', ['url' => ['controller' => 'ClasstimeTabs', 'action' => 'aggsn_other']]); ?>
        <div class="col-sm-3">
            <?php echo $this->Form->input('old_id', ['type' => 'select', 'class' => 'form-control', 'empty' => 'Select Teacher', 'options' => $array, 'value' => $classectionid, 'label' => false, 'readonly']); ?>
        </div>
        <div class="col-sm-3">
            <p class="btn-success" style="text-align:center; width:10%;margin:auto"><i class="fa fa-chevron-right" aria-hidden="true"></i> <i class="fa fa-chevron-right" aria-hidden="true"></i></p>
        </div>
        <div class="col-sm-3">
            <?php echo $this->Form->input('new_id', ['type' => 'select', 'class' => 'form-control', 'empty' => 'Select Teacher', 'options' => $array1, 'label' => false, 'required']); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $this->Form->input('Submit', ['type' => 'submit', 'value' => 'submit', 'class' => 'btn btn-success', 'label' => false]); ?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<div class="box-body">
    <table class="table table-bordered table-striped">
        <thead>

            <p class="text-right btn-view-group">
                <a class="btn btn-primary" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/pdf_teacher/<?php echo $classectionid; ?>" target="blank"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
            </p>

            <?php $role = $this->request->session()->read("Auth.User.role_id");
            ?>

            <tr>
                <th class="text-center bg-teal color-palette">Class Timing</th>
                <th class="text-center bg-teal color-palette">Monday</th>
                <th class="text-center bg-teal color-palette">Tuesday</th>
                <th class="text-center bg-teal color-palette">Wednesday</th>
                <th class="text-center bg-teal color-palette">Thursday</th>
                <th class="text-center bg-teal color-palette">Friday</th>
                <th class="text-center bg-teal color-palette">Saturday</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($classectionid) {
                if (isset($timetabledata) && !empty($timetabledata)) {
                    foreach ($timetabledata as $work) {

                        $getdata = '0';
                        if ($work['is_break'] != 1) { ?>
                            <tr>

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
                                                                                            $subjectname = "";
                                                                                            foreach ($emp as $k => $value) {
                                                                                                foreach ($sub as $s => $val) {
                                                                                                    $vbn = array();
                                                                                                    if ($k == $s && $value == $classectionid) {
                                                                                                        $subj = $this->Comman->findclassubject($val);
                                                                                                        $subjectname = $subj['alias'];
                                                                                                    }
                                                                                                }
                                                                                            }

                                                                                        ?>


                                        <span><?php if (!empty($getdata)) {
                                                ?>
                                                <?php $b = array_unique($a);

                                                                                                foreach ($b as $key => $va) {
                                                                                                    $sdf = $this->Comman->findclasssectionid($va);
                                                                                                    $sec = $sdf['section_id'];
                                                                                                    $cls = $sdf['class_id'];
                                                                                                    $cl1 = $this->Comman->findclass123($cls);
                                                                                                    $sl2 = $this->Comman->findsection123($sec);
                                                                                                    echo $subjectname . '<br>' . $cl1['title'] . '(' . $sl2['title'] . ')';
                                                                                                    $subjectname = "";
                                                                                                } ?>
                                                <?php if ($role != ADMIN && $role != CENTER_COORDINATOR) { ?> <a class="text-green" href="<?php echo SITE_URL; ?>admin/assignments/add/<?php echo $data; ?>" title="Add Assignment" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-thumb-tack"></i></a>
                                        <?php }
                                                                                            } else {
                                                                                                echo "-";
                                                                                            }
                                                                                        } ?> </span>
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
                                                                                            $subjectname = "";
                                                                                            foreach ($emp as $k => $value) {
                                                                                                foreach ($sub as $s => $val) {
                                                                                                    $vbn = array();
                                                                                                    if ($k == $s && $value == $classectionid) {

                                                                                                        $subj = $this->Comman->findclassubject($val);
                                                                                                        $subjectname = $subj['alias'];
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                        ?>


                                        <span><?php if (!empty($getdata)) {
                                                ?>

                                                <?php $b = array_unique($a);

                                                                                                foreach ($b as $key => $va) {
                                                                                                    $sdf = $this->Comman->findclasssectionid($va);

                                                                                                    $sec = $sdf['section_id'];
                                                                                                    $cls = $sdf['class_id'];
                                                                                                    $cl1 = $this->Comman->findclass123($cls);
                                                                                                    $sl2 = $this->Comman->findsection123($sec);

                                                                                                    echo $subjectname . '<br>' . $cl1['title'] . '(' . $sl2['title'] . ')';
                                                                                                    $subjectname = "";
                                                                                                } ?>



                                                <?php if ($role != ADMIN && $role != CENTER_COORDINATOR) { ?> <a class="text-green" href="<?php echo SITE_URL; ?>admin/assignments/add/<?php echo $data; ?>" title="Add Assignment" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-thumb-tack"></i></a>

                                        <?php }
                                                                                            } else {
                                                                                                echo "-";
                                                                                            }
                                                                                        } ?> </span>
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
                                                                                            $subjectname = "";
                                                                                            foreach ($emp as $k => $value) {
                                                                                                foreach ($sub as $s => $val) {
                                                                                                    $vbn = array();
                                                                                                    if ($k == $s && $value == $classectionid) {
                                                                                                        $subj = $this->Comman->findclassubject($val);
                                                                                                        $subjectname = $subj['alias'];
                                                                                                    }
                                                                                                }
                                                                                            }

                                                                                        ?>


                                        <span><?php if (!empty($getdata)) {
                                                ?>

                                                <?php $b = array_unique($a);

                                                                                                foreach ($b as $key => $va) {
                                                                                                    $sdf = $this->Comman->findclasssectionid($va);

                                                                                                    $sec = $sdf['section_id'];
                                                                                                    $cls = $sdf['class_id'];
                                                                                                    $cl1 = $this->Comman->findclass123($cls);
                                                                                                    $sl2 = $this->Comman->findsection123($sec);

                                                                                                    echo $subjectname . '<br>' . $cl1['title'] . '(' . $sl2['title'] . ')';
                                                                                                    $subjectname = "";
                                                                                                } ?>



                                                <?php if ($role != ADMIN && $role != CENTER_COORDINATOR) { ?> <a class="text-green" href="<?php echo SITE_URL; ?>admin/assignments/add/<?php echo $data; ?>" title="Add Assignment" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-thumb-tack"></i></a>

                                        <?php }
                                                                                            } else {
                                                                                                echo "-";
                                                                                            }
                                                                                        } ?> </span>
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
                                                                                            $subjectname = "";
                                                                                            foreach ($emp as $k => $value) {
                                                                                                foreach ($sub as $s => $val) {
                                                                                                    $vbn = array();
                                                                                                    if ($k == $s && $value == $classectionid) {


                                                                                                        $subj = $this->Comman->findclassubject($val);
                                                                                                        $subjectname = $subj['alias'];
                                                                                                    }
                                                                                                }
                                                                                            }

                                                                                        ?>


                                        <span><?php if (!empty($getdata)) {
                                                ?>

                                                <?php $b = array_unique($a);

                                                                                                foreach ($b as $key => $va) {
                                                                                                    $sdf = $this->Comman->findclasssectionid($va);

                                                                                                    $sec = $sdf['section_id'];
                                                                                                    $cls = $sdf['class_id'];
                                                                                                    $cl1 = $this->Comman->findclass123($cls);
                                                                                                    $sl2 = $this->Comman->findsection123($sec);

                                                                                                    echo $subjectname . '<br>' . $cl1['title'] . '(' . $sl2['title'] . ')';
                                                                                                    $subjectname = "";
                                                                                                } ?>



                                                <?php if ($role != ADMIN && $role != CENTER_COORDINATOR) { ?> <a class="text-green" href="<?php echo SITE_URL; ?>admin/assignments/add/<?php echo $data; ?>" title="Add Assignment" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-thumb-tack"></i></a>

                                        <?php }
                                                                                            } else {
                                                                                                echo "-";
                                                                                            }
                                                                                        } ?> </span>
                                </td>

                                <!--  ---------------Friday-------------------- -->

                                <td class="text-center" style=" word-break: keep-all;"> <?php if (strpos($work['weekday'], "Friday") !== false) {
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
                                                                                            $subjectname = "";
                                                                                            foreach ($emp as $k => $value) {
                                                                                                foreach ($sub as $s => $val) {
                                                                                                    $vbn = array();
                                                                                                    if ($k == $s && $value == $classectionid) {

                                                                                                        $subj = $this->Comman->findclassubject($val);
                                                                                                        $subjectname = $subj['alias'];
                                                                                                    }
                                                                                                }
                                                                                            }

                                                                                        ?>


                                        <span><?php if (!empty($getdata)) {
                                                ?>

                                                <?php $b = array_unique($a);

                                                                                                foreach ($b as $key => $va) {
                                                                                                    $sdf = $this->Comman->findclasssectionid($va);

                                                                                                    $sec = $sdf['section_id'];
                                                                                                    $cls = $sdf['class_id'];
                                                                                                    $cl1 = $this->Comman->findclass123($cls);
                                                                                                    $sl2 = $this->Comman->findsection123($sec);


                                                                                                    echo $subjectname . '<br>' . $cl1['title'] . '(' . $sl2['title'] . ')';
                                                                                                    $subjectname = "";
                                                                                                } ?>



                                                <?php if ($role != ADMIN && $role != CENTER_COORDINATOR) { ?> <a class="text-green" href="<?php echo SITE_URL; ?>admin/assignments/add/<?php echo $data; ?>" title="Add Assignment" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-thumb-tack"></i></a>

                                        <?php }
                                                                                            } else {
                                                                                                echo "-";
                                                                                            }
                                                                                        } ?> </span>
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
                                                                                            $subjectname = "";
                                                                                            foreach ($emp as $k => $value) {
                                                                                                foreach ($sub as $s => $val) {
                                                                                                    $vbn = array();
                                                                                                    if ($k == $s && $value == $classectionid) {

                                                                                                        $subj = $this->Comman->findclassubject($val);
                                                                                                        $subjectname = $subj['alias'];
                                                                                                    }
                                                                                                }
                                                                                            }

                                                                                        ?>


                                        <span><?php if (!empty($getdata)) {
                                                ?>

                                                <?php $b = array_unique($a);

                                                                                                foreach ($b as $key => $va) {
                                                                                                    $sdf = $this->Comman->findclasssectionid($va);

                                                                                                    $sec = $sdf['section_id'];
                                                                                                    $cls = $sdf['class_id'];
                                                                                                    $cl1 = $this->Comman->findclass123($cls);
                                                                                                    $sl2 = $this->Comman->findsection123($sec);

                                                                                                    echo $subjectname . '<br>' . $cl1['title'] . '(' . $sl2['title'] . ')';
                                                                                                    $subjectname = "";
                                                                                                } ?>



                                                <?php if ($role != ADMIN && $role != CENTER_COORDINATOR) { ?> <a class="text-green" href="<?php echo SITE_URL; ?>admin/assignments/add/<?php echo $data; ?>" title="Add Assignment" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-thumb-tack"></i></a>

                                        <?php }
                                                                                            } else {
                                                                                                echo "-";
                                                                                            }
                                                                                        } ?> </span>
                                </td>
                            </tr>


                            <?php }
                        if ($work['is_break']) {
                            if ($work['time_from']) { ?><tr>
                                    <td class="text-center text-bold"><?php echo $work['name'] ?></td>
                                    <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;"> Break</span></td>
                                    <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;">Break</span></td>
                                    <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;">Break</span></td>
                                    <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;">Break</span></td>
                                    <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;">Break</span></td>
                                    <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;">Break</span></td>
                                </tr>
                <?php }
                        }
                    }
                } ?>

            <?php } else { ?>
                <tr>
                    <td class="text-center text-bold" colspan="7">No Data Selected</td>
                </tr><?php } ?>
        </tbody>
    </table>
</div>