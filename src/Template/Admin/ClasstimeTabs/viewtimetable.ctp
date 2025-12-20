  <?php $role = $this->request->session()->read('Auth.User.role_id');  ?>
  <?php $username = $this->request->session()->read('Auth.User.email');  ?>

  <table class="table table-bordered table-striped whity_table">
    <thead>

      <p class="text-right btn-view-group">
        <a class="btn btn-primary" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/pdf_view/<?php echo $class; ?>/<?php echo $section; ?>" target="blank"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
      </p>

      <tr>
        <th class="text-center bg-teal color-palette">Period</th>
        <th class="text-center bg-teal color-palette">Monday</th>
        <th class="text-center bg-teal color-palette">Tuesday</th>
        <th class="text-center bg-teal color-palette">Wednesday</th>
        <th class="text-center bg-teal color-palette">Thursday</th>
        <th class="text-center bg-teal color-palette">Friday</th>
        <th class="text-center bg-teal color-palette">Saturday</th>
      </tr>
    </thead>
    <tbody>
      <?php if (isset($timetabledata) && !empty($timetabledata)) {
        foreach ($timetabledata as $work) {
          $getdata = '0';
          if ($work['is_break'] != 1) {   ?>
            <tr>
              <td class="text-center text-bold"><?php echo $work['name']; ?></td>
              <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><?php if (strpos($work['weekday'], "Monday") !== false) {
                                                                                              $getdata = $this->Comman->gettimetable($work['id'], "Monday", $classid);

                                                                                              $sub = explode(',', $getdata[0]['subject_id']);
                                                                                              $tea = explode(',', $getdata[0]['employee_id']);

                                                                                              $clsn = array();
                                                                                              foreach ($sub as $key => $value) {
                                                                                                foreach ($tea as $s => $val) {
                                                                                                  if ($key == $s) {
                                                                                                    $getteac = $this->Comman->findclassteachers($val);
                                                                                                    $subj = $this->Comman->findclassubject($value);
                                                                                                    if ($getteac['middlename'] != '') {
                                                                                                      $clsn[] = $subj['alias'] . "(" . $getteac['fname'] . ' ' . substr($getteac['middlename'], 0, 2) . ")<br>";
                                                                                                    } else {
                                                                                                      $clsn[] = $subj['alias'] . "(" . $getteac['fname'] . ' ' . substr($getteac['lname'], 0, 2) . ")<br>";
                                                                                                    }
                                                                                                  }
                                                                                                }
                                                                                              }
                                                                                            ?>

                  <span rel="tooltip" data-toggle="tooltip" title="<?php if (!empty($getdata)) {
                                                                                                echo $getdata[0]['Subjects']['name'] . '&nbsp;(' . $getdata[0]['Employees']['fname'] . '&nbsp;' . $getdata[0]['Employees']['middlename'] . '&nbsp;' . $getdata[0]['Employees']['lname'] . ')';
                                                                                              } else {
                                                                                                echo "Assign Lecture";
                                                                                              } ?>">

                    <?php if (!empty($getdata)) { ?><a class="globalModalss" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/edit/<?php echo $getdata[0]['id']; ?>" data-target="#globalModal" data-toggle="modal">

                        <?php
                                                                                                foreach ($clsn as $key => $value1) {
                                                                                                  echo  $value1;
                                                                                                }
                        ?>
                      </a>
                      <?php if ($work['name'] == '1st' && $username == $getdata[0]['Employees']['email']) { ?><a class="text-green" href="<?php echo SITE_URL; ?>admin/Studattends/attendence/<?php echo $class; ?>/<?php echo $section; ?>/<?php echo $acedimc; ?>/<?php echo date("Y-m-d", strtotime('monday this week')); ?>" title="Take Attendance" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-hand-o-up"></i></a><?php }
                                                                                                                                                                                                                                                                                                                                                                                                                                                        if ($role == ADMIN || $role == CENTER_COORDINATOR) {  ?><a class="text-red" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/delete/<?php echo $getdata[0]['id']; ?>/<?php echo $classid; ?>" data-toggle="tooltip" style="padding-left:5px;font-size:22px" data-confirm="Are you sure you want to delete this item?" data-method="post" title="Delete Lecture"><i class="fa fa-trash-o"></i></a><?php }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  if ($role == ADMIN || $role == CENTER_COORDINATOR) {  ?><a class="globalModals" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/add/<?php echo $work['id'] ?>/<?php echo $classid; ?>/Monday" data-target="#globalModal" data-toggle="modal">Assign</a> <?php }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?> </span> <?php  }  ?>
              </td>


              <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><?php if (strpos($work['weekday'], "Tuesday") !== false) {
                                                                                              $getdata = $this->Comman->gettimetable($work['id'], "Tuesday", $classid);

                                                                                              $sub = explode(',', $getdata[0]['subject_id']);
                                                                                              $tea = explode(',', $getdata[0]['employee_id']);
                                                                                              $clsn = array();
                                                                                              foreach ($sub as $key => $value) {
                                                                                                foreach ($tea as $s => $val) {
                                                                                                  if ($key == $s) {
                                                                                                    $getteac = $this->Comman->findclassteachers($val);
                                                                                                    $subj = $this->Comman->findclassubject($value);

                                                                                                    if ($getteac['middlename'] != '') {
                                                                                                      $clsn[] = $subj['alias'] . "(" . $getteac['fname'] . ' ' . substr($getteac['middlename'], 0, 2) . ")<br>";
                                                                                                    } else {
                                                                                                      $clsn[] = $subj['alias'] . "(" . $getteac['fname'] . ' ' . substr($getteac['lname'], 0, 2) . ")<br>";
                                                                                                    }
                                                                                                  }
                                                                                                }
                                                                                              }
                                                                                            ?>


                  <span rel="tooltip" data-toggle="tooltip" title="<?php if (!empty($getdata)) {
                                                                                                echo $getdata[0]['Subjects']['name'] . '&nbsp;(' . $getdata[0]['Employees']['fname'] . '&nbsp;' . $getdata[0]['Employees']['middlename'] . '&nbsp;' . $getdata[0]['Employees']['lname'] . ')';
                                                                                              } else {
                                                                                                echo "Assign Lecture";
                                                                                              } ?>">

                    <?php if (!empty($getdata)) { ?><a class="globalModalss" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/edit/<?php echo $getdata[0]['id']; ?>" data-target="#globalModal" data-toggle="modal">

                        <?php
                                                                                                foreach ($clsn as $key => $value1) {
                                                                                                  echo  $value1;
                                                                                                }
                        ?>
                      </a>

                      <?php if ($work['name'] == '1st' && $username == $getdata[0]['Employees']['email']) { ?><a class="text-green" href="<?php echo SITE_URL; ?>admin/Studattends/attendence/<?php echo $class; ?>/<?php echo $section; ?>/<?php echo $acedimc; ?>/<?php echo date("Y-m-d", strtotime('tuesday this week')); ?>" title="Take Attendance" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-hand-o-up"></i></a><?php }
                                                                                                                                                                                                                                                                                                                                                                                                                                                          if ($role == ADMIN || $role == CENTER_COORDINATOR) {  ?> <a class="text-red" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/delete/<?php echo $getdata[0]['id']; ?>/<?php echo $classid; ?>" data-toggle="tooltip" style="padding-left:5px;font-size:22px" data-confirm="Are you sure you want to delete this item?" data-method="post" title="Delete Lecture"><i class="fa fa-trash-o"></i></a><?php }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    if ($role == ADMIN || $role == CENTER_COORDINATOR) {  ?><a class="globalModals" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/add/<?php echo $work['id'] ?>/<?php echo $classid; ?>/Tuesday" data-target="#globalModal" data-toggle="modal">Assign</a> <?php }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              } ?> </span><?php } ?>
              </td>


              <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><?php if (strpos($work['weekday'], "Wednesday") !== false) {
                                                                                              $getdata = $this->Comman->gettimetable($work['id'], "Wednesday", $classid);

                                                                                              $sub = explode(',', $getdata[0]['subject_id']);
                                                                                              $tea = explode(',', $getdata[0]['employee_id']);


                                                                                              $clsn = array();
                                                                                              foreach ($sub as $key => $value) {
                                                                                                foreach ($tea as $s => $val) {
                                                                                                  if ($key == $s) {

                                                                                                    $getteac = $this->Comman->findclassteachers($val);
                                                                                                    $subj = $this->Comman->findclassubject($value);

                                                                                                    if ($getteac['middlename'] != '') {
                                                                                                      $clsn[] = $subj['alias'] . "(" . $getteac['fname'] . ' ' . substr($getteac['middlename'], 0, 2) . ")<br>";
                                                                                                    } else {
                                                                                                      $clsn[] = $subj['alias'] . "(" . $getteac['fname'] . ' ' . substr($getteac['lname'], 0, 2) . ")<br>";
                                                                                                    }
                                                                                                  }
                                                                                                }
                                                                                              }
                                                                                            ?>


                  <span rel="tooltip" data-toggle="tooltip" title="<?php if (!empty($getdata)) {
                                                                                                echo $getdata[0]['Subjects']['name'] . '&nbsp;(' . $getdata[0]['Employees']['fname'] . '&nbsp;' . $getdata[0]['Employees']['middlename'] . '&nbsp;' . $getdata[0]['Employees']['lname'] . ')';
                                                                                              } else {
                                                                                                echo "Assign Lecture";
                                                                                              } ?>">

                    <?php if (!empty($getdata)) { ?><a class="globalModalss" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/edit/<?php echo $getdata[0]['id']; ?>" data-target="#globalModal" data-toggle="modal">

                        <?php
                                                                                                foreach ($clsn as $key => $value1) {
                                                                                                  echo  $value1;
                                                                                                }
                        ?>
                      </a>

                      <?php if ($work['name'] == '1st' && $username == $getdata[0]['Employees']['email']) { ?><a class="text-green" href="<?php echo SITE_URL; ?>admin/Studattends/attendence/<?php echo $class; ?>/<?php echo $section; ?>/<?php echo $acedimc; ?>/<?php echo date("Y-m-d", strtotime('wednesday this week')); ?>" title="Take Attendance" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-hand-o-up"></i></a><?php }
                                                                                                                                                                                                                                                                                                                                                                                                                                                            if ($role == ADMIN || $role == CENTER_COORDINATOR) {  ?><a class="text-red" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/delete/<?php echo $getdata[0]['id']; ?>/<?php echo $classid; ?>" data-toggle="tooltip" style="padding-left:5px;font-size:22px" data-confirm="Are you sure you want to delete this item?" data-method="post" title="Delete Lecture"><i class="fa fa-trash-o"></i></a><?php }
} else {
if ($role == ADMIN || $role == CENTER_COORDINATOR) {  ?><a class="globalModals" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/add/<?php echo $work['id'] ?>/<?php echo $classid; ?>/Wednesday" data-target="#globalModal" data-toggle="modal">Assign</a><?php }
} ?></span> <?php } ?>
              </td>

              <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><?php if (strpos($work['weekday'], "Thursday") !== false) {
                                                                                              $getdata = $this->Comman->gettimetable($work['id'], "Thursday", $classid);

                                                                                              $sub = explode(',', $getdata[0]['subject_id']);
                                                                                              $tea = explode(',', $getdata[0]['employee_id']);


                                                                                              $clsn = array();
                                                                                              foreach ($sub as $key => $value) {
                                                                                                foreach ($tea as $s => $val) {
                                                                                                  if ($key == $s) {

                                                                                                    $getteac = $this->Comman->findclassteachers($val);
                                                                                                    $subj = $this->Comman->findclassubject($value);

                                                                                                    if ($getteac['middlename'] != '') {
                                                                                                      $clsn[] = $subj['alias'] . "(" . $getteac['fname'] . ' ' . substr($getteac['middlename'], 0, 2) . ")<br>";
                                                                                                    } else {
                                                                                                      $clsn[] = $subj['alias'] . "(" . $getteac['fname'] . ' ' . substr($getteac['lname'], 0, 2) . ")<br>";
                                                                                                    }
                                                                                                  }
                                                                                                }
                                                                                              }
                                                                                            ?>

                  <span rel="tooltip" data-toggle="tooltip" title="<?php if (!empty($getdata)) {
                                                                                                echo $getdata[0]['Subjects']['name'] . '&nbsp;(' . $getdata[0]['Employees']['fname'] . '&nbsp;' . $getdata[0]['Employees']['middlename'] . '&nbsp;' . $getdata[0]['Employees']['lname'] . ')';
                                                                                              } else {
                                                                                                echo "Assign Lecture";
                                                                                              } ?>">
                    <?php if (!empty($getdata)) { ?><a class="globalModalss" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/edit/<?php echo $getdata[0]['id']; ?>" data-target="#globalModal" data-toggle="modal">

                        <?php
                                                                                                foreach ($clsn as $key => $value1) {
                                                                                                  echo  $value1;
                                                                                                }
                        ?></a>

                      <?php if ($work['name'] == '1st' && $username == $getdata[0]['Employees']['email']) { ?><a class="text-green" href="<?php echo SITE_URL; ?>admin/Studattends/attendence/<?php echo $class; ?>/<?php echo $section; ?>/<?php echo $acedimc; ?>/<?php echo date("Y-m-d", strtotime('thursday this week')); ?>" title="Take Attendance" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-hand-o-up"></i></a><?php }
                                                                                                                                                                                                                                                                                                                                                                                                                                                          if ($role == ADMIN || $role == CENTER_COORDINATOR) {  ?> <a class="text-red" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/delete/<?php echo $getdata[0]['id']; ?>/<?php echo $classid; ?>" data-toggle="tooltip" style="padding-left:5px;font-size:22px" data-confirm="Are you sure you want to delete this item?" data-method="post" title="Delete Lecture"><i class="fa fa-trash-o"></i></a><?php }
} else {
if ($role == ADMIN || $role == CENTER_COORDINATOR) { ?><a class="globalModals" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/add/<?php echo $work['id']; ?>/<?php echo $classid; ?>/Thursday" data-target="#globalModal" data-toggle="modal">Assign</a><?php  }
} ?> </span><?php } ?>
              </td>

              <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"> <?php if (strpos($work['weekday'], "Friday") !== false) {
                                                                                              $getdata = $this->Comman->gettimetable($work['id'], "Friday", $classid);
                                                                                              $sub = explode(',', $getdata[0]['subject_id']);
                                                                                              $tea = explode(',', $getdata[0]['employee_id']);
                                                                                              $clsn = array();
                                                                                              foreach ($sub as $key => $value) {
                                                                                                foreach ($tea as $s => $val) {
                                                                                                  if ($key == $s) {

                                                                                                    $getteac = $this->Comman->findclassteachers($val);
                                                                                                    $subj = $this->Comman->findclassubject($value);

                                                                                                    if ($getteac['middlename'] != '') {
                                                                                                      $clsn[] = $subj['alias'] . "(" . $getteac['fname'] . ' ' . substr($getteac['middlename'], 0, 2) . ")<br>";
                                                                                                    } else {
                                                                                                      $clsn[] = $subj['alias'] . "(" . $getteac['fname'] . ' ' . substr($getteac['lname'], 0, 2) . ")<br>";
                                                                                                    }
                                                                                                  }
                                                                                                }
                                                                                              }
                                                                                            ?>

                  <span rel="tooltip" data-toggle="tooltip" title="<?php if (!empty($getdata)) {
                                                                                                echo $getdata[0]['Subjects']['name'] . '&nbsp;(' . $getdata[0]['Employees']['fname'] . '&nbsp;' . $getdata[0]['Employees']['middlename'] . '&nbsp;' . $getdata[0]['Employees']['lname'] . ')';
                                                                                              } else {
                                                                                                echo "Assign Lecture";
                                                                                              } ?>">

                    <?php if (!empty($getdata)) { ?><a class="globalModalss" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/edit/<?php echo $getdata[0]['id']; ?>" data-target="#globalModal" data-toggle="modal">

                        <?php
                                                                                                foreach ($clsn as $key => $value1) {
                                                                                                  echo  $value1;
                                                                                                }
                        ?></a>

                      <?php if ($work['name'] == '1st' && $username == $getdata[0]['Employees']['email']) { ?><a class="text-green" href="<?php echo SITE_URL; ?>admin/Studattends/attendence/<?php echo $class; ?>/<?php echo $section; ?>/<?php echo $acedimc; ?>/<?php echo date("Y-m-d", strtotime('friday this week')); ?>" title="Take Attendance" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-hand-o-up"></i></a><?php }
                                                                                                                                                                                                                                                                                                                                                                                                                                                        if ($role == ADMIN || $role == CENTER_COORDINATOR) {  ?> <a class="text-red" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/delete/<?php echo $getdata[0]['id']; ?>/<?php echo $classid; ?>" data-toggle="tooltip" style="padding-left:5px;font-size:22px" data-confirm="Are you sure you want to delete this item?" data-method="post" title="Delete Lecture"><i class="fa fa-trash-o"></i></a><?php }
} else {
if ($role == ADMIN || $role == CENTER_COORDINATOR) {  ?><a class="globalModals" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/add/<?php echo $work['id'] ?>/<?php echo $classid; ?>/Friday" data-target="#globalModal" data-toggle="modal">Assign</a><?php }
} ?> </span> <?php } ?>
              </td>

              <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"> <?php if (strpos($work['weekday'], "Saturday") !== false) {
                                                                                              $getdata = $this->Comman->gettimetable($work['id'], "Saturday", $classid);
                                                                                              $sub = explode(',', $getdata[0]['subject_id']);
                                                                                              $tea = explode(',', $getdata[0]['employee_id']);


                                                                                              $clsn = array();
                                                                                              foreach ($sub as $key => $value) {
                                                                                                foreach ($tea as $s => $val) {
                                                                                                  if ($key == $s) {

                                                                                                    $getteac = $this->Comman->findclassteachers($val);
                                                                                                    $subj = $this->Comman->findclassubject($value);

                                                                                                    if ($getteac['middlename'] != '') {
                                                                                                      $clsn[] = $subj['alias'] . "(" . $getteac['fname'] . ' ' . substr($getteac['middlename'], 0, 2) . ")<br>";
                                                                                                    } else {
                                                                                                      $clsn[] = $subj['alias'] . "(" . $getteac['fname'] . ' ' . substr($getteac['lname'], 0, 2) . ")<br>";
                                                                                                    }
                                                                                                  }
                                                                                                }
                                                                                              }
                                                                                            ?>

                  <span rel="tooltip" data-toggle="tooltip" title="<?php if (!empty($getdata)) {
                                                                                                echo $getdata[0]['Subjects']['name'] . '&nbsp;(' . $getdata[0]['Employees']['fname'] . '&nbsp;' . $getdata[0]['Employees']['middlename'] . '&nbsp;' . $getdata[0]['Employees']['lname'] . ')';
                                                                                              } else {
                                                                                                echo "Assign Lecture";
                                                                                              } ?>">

                    <?php if (!empty($getdata)) { ?><a class="globalModalss" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/edit/<?php echo $getdata[0]['id']; ?>" data-target="#globalModal" data-toggle="modal">

                        <?php
                        foreach ($clsn as $key => $value1) {
                         echo  $value1;
                          }
                        ?>
                      </a> </br>

                      <?php if ($work['name'] == '1st' && $username == $getdata[0]['Employees']['email']) { ?><a class="text-green" href="<?php echo SITE_URL; ?>admin/Studattends/attendence/<?php echo $class; ?>/<?php echo $section; ?>/<?php echo $acedimc; ?>/<?php echo date("Y-m-d", strtotime('saturday this week')); ?>" title="Take Attendance" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-hand-o-up"></i></a><?php }
if ($role == ADMIN || $role == CENTER_COORDINATOR) {   ?><a class="text-red" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/delete/<?php echo $getdata[0]['id']; ?>/<?php echo $classid; ?>" data-toggle="tooltip" style="padding-left:5px;font-size:22px" data-confirm="Are you sure you want to delete this item?" data-method="post" title="Delete Lecture"><i class="fa fa-trash-o"></i></a><?php }
} else {
if ($role == ADMIN || $role == CENTER_COORDINATOR) {  ?><a class="globalModals" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/add/<?php echo $work['id'] ?>/<?php echo $classid; ?>/Saturday" data-target="#globalModal" data-toggle="modal">Assign</a><?php }
} ?></span> <?php  } ?>
              </td>
            </tr><?php  }
                if ($work['is_break']) {
                  if ($work['time_from']) { ?><tr>
                <td class="text-center text-bold"><?php echo $work['name'] ?></td>
                <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;"> Break</span></td>
                <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;">Break</span></td>
                <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;">Break</span></td>
                <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;">Break</span></td>
                <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;">Break</span></td>
                <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;">Break</span></td>
              </tr>
      <?php }
                }
              }
            } ?>
    </tbody>
  </table>

  <script>
    $(".globalModals").click(function(event) {
      $('.modal-content').load($(this).attr("href")); //load content from href of link
    });
    $(".globalModalss").click(function(event) {
      $('.modal-content').load($(this).attr("href")); //load content from href of link
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