<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Timetables Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>ClasstimeTabs/index"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>ClasstimeTabs/index">Manage Timetables</a></li>
      <li class="active">Search Time Table </li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <?php $role = $this->request->session()->read('Auth.User.role_id');
          $username = $this->request->session()->read('Auth.User.email');
          if ($role == ADMIN || $role ==CENTER_COORDINATOR  || $role == TEACHER) { ?>
            <div class="box-header">
              <i class="fa fa-search" aria-hidden="true"></i>
              <h3 class="box-title">Search Time Table </h3>
              <?php if ($role ==CENTER_COORDINATOR) { ?>
                <a href="<?php echo SITE_URL; ?>admin/Timetables/index">
                  <button class="btn btn-success pull-right m-top10">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Class Timing </button>
                </a>
              <?php } ?>
            </div>
          <?php } ?>
          <!-- /.box-header -->
          <?php echo $this->Flash->render(); ?>
          <?php if ($role == ADMIN || $role ==CENTER_COORDINATOR || $role == TEACHER) {  ?>
            <div class="box-body">
              <div class="manag-stu">
                <script inline="1">
                  //<![CDATA[
                  $(document).ready(function() {
                    $("#TaskAdminCustomerForm").bind("submit", function(event) {
                      $.ajax({
                        async: true,
                        data: $("#TaskAdminCustomerForm").serialize(),
                        dataType: "html",
                        success: function(data, textStatus) {
                          $("#resizable-tables").html(data);
                        },
                        type: "POST",
                        url: "<?php echo SITE_URL; ?>admin/ClasstimeTabs/viewtimetable"
                      });
                      return false;
                    });
                  });
                  //]]>
                </script>
                <?php echo $this->Form->create('Task', array('url' => array('controller' => 'ClasstimeTabs'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'TaskAdminCustomerForm', 'class' => 'form-horizontal')); ?>
                <div class="form-group">
                  <div class="col-sm-4">
                    <label>Select Class</label>
                    <?php if ($seletedclassid) {
                      echo $this->Form->input('class_id', array('class' => 'form-control', 'type' => 'select', 'empty' => 'Select Class', 'options' => $classes, 'value' => $seletedclassid, 'label' => false, 'required'));
                    } else {
                      echo $this->Form->input('class_id', array('class' => 'form-control', 'type' => 'select', 'empty' => 'Select Class', 'options' => $classes, 'label' => false, 'required'));
                    } ?>
                  </div>
                  <div class="col-sm-4">
                    <label>Select Section</label>
                    <?php
                    if ($seletedsectionid) {
                      echo $this->Form->input('section_id', array('class' => 'form-control', 'type' => 'select', 'empty' => '--Select Section--', 'options' => $sectionselectlist, 'value' => $seletedsectionid, 'label' => false, 'required'));
                    } else {
                      echo $this->Form->input('section_id', array('class' => 'form-control', 'type' => 'select', 'empty' => '--Select Section--', 'options' => $sectionslist, 'label' => false, 'required'));
                    } ?>
                  </div>
                  <script>
                    $(document).ready(function() {
                      $('#class-id').on('change', function() {
                        var id = $('#class-id').val();
                        $.ajax({
                          type: 'POST',
                          url: '<?php echo ADMIN_URL; ?>ClasstimeTabs/find_section',
                          data: {
                            'id': id
                          },
                          success: function(data) {
                            $('#section-id').empty();
                            $('#section-id').html(data);
                          },
                        });
                      });
                    });
                  </script>
                  <div class="col-sm-4" style="top: 22px;">
                    <button type="submit" class="btn btn-success">Search</button>
                    <button type="reset" class="btn btn-primary">Reset</button>
                  </div>
                </div>
                <?php echo $this->Form->end(); ?>
              </div>
            </div>
          <?php } ?>

          <div class="box-body" id="resizable-tables">
            <table class="table table-bordered table-striped whity_table">
              <thead>
                <?php if ($classectionid) { ?>
                  <p class="text-right btn-view-group">
                    <a class="btn btn-primary" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/pdf_view/<?php echo $class; ?>/<?php echo $section; ?>" target="blank"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
                  </p>
                <?php } ?>
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
                <?php if ($classectionid) {

                  if (isset($timetabledata) && !empty($timetabledata)) {
                    foreach ($timetabledata as $work) { 
                      $getdata = '0';
                      if ($work['is_break'] != 1) {
                       ?>
                        <tr>
                          <td class="text-center text-bold"><?php echo $work['name']; ?></td>
                          <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;">
                            <?php if (strpos($work['weekday'], "Monday") !== false) {
                              $getdata = $this->Comman->gettimetable($work['id'], "Monday", $classectionid); 
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
                                <?php if (!empty($getdata)) { ?>
                                  <a class="globalModalss" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/edit/<?php echo $getdata[0]['id']; ?>" data-target="#globalModal" data-toggle="modal">
                                    <?php
                                    foreach ($clsn as $key => $value1) {
                                      echo  $value1;
                                    }
                                    ?>
                                  </a>
                                  <?php if ($work['name'] == '1st' && $username == $getdata[0]['Employees']['email']) { ?>
                                    <a class="text-green" href="<?php echo SITE_URL; ?>admin/Studattends/attendence/<?php echo $class; ?>/<?php echo $section; ?>/<?php echo $acedimc; ?>/<?php echo date("Y-m-d", strtotime('monday this week')); ?>" title="Take Attendance" data-toggle="tooltip" style="padding-left:5px;font-size:22px">
                                      <i class="fa fa-hand-o-up"></i>
                                    </a>
                                  <?php }
                                  if ($role == ADMIN || $role ==CENTER_COORDINATOR) {  ?>
                                    <a class="text-red" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/delete/<?php echo $getdata[0]['id']; ?>/<?php echo $classectionid; ?>" data-toggle="tooltip" style="padding-left:5px;font-size:22px" data-confirm="Are you sure you want to delete this item?" data-method="post" title="Delete Lecture">
                                      <i class="fa fa-trash-o"></i>
                                    </a>
                                  <?php }
                                } else {
                                  if ($role == ADMIN || $role ==CENTER_COORDINATOR) {  ?>
                                    <a class="globalModals" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/add/<?php echo $work['id'] ?>/<?php echo $classectionid; ?>/Monday" data-target="#globalModal" data-toggle="modal">
                                      Assign
                                    </a>
                                <?php }
                                } ?>
                              </span>
                            <?php  }  ?>
                          </td>
                          <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><?php if (strpos($work['weekday'], "Tuesday") !== false) {
                          $getdata = $this->Comman->gettimetable($work['id'], "Tuesday", $classectionid);
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
                          }}}}?>
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
                                  </br>
                                  <?php if ($work['name'] == '1st' && $username == $getdata[0]['Employees']['email']) { ?><a class="text-green" href="<?php echo SITE_URL; ?>admin/Studattends/attendence/<?php echo $class; ?>/<?php echo $section; ?>/<?php echo $acedimc; ?>/<?php echo date("Y-m-d", strtotime('tuesday this week')); ?>" title="Take Attendance" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-hand-o-up"></i></a><?php }
                                  if ($role == ADMIN || $role ==CENTER_COORDINATOR) {  ?><a class="text-red" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/delete/<?php echo $getdata[0]['id']; ?>/<?php echo $classectionid; ?>" data-toggle="tooltip" style="padding-left:5px;font-size:22px" data-confirm="Are you sure you want to delete this item?" data-method="post" title="Delete Lecture"><i class="fa fa-trash-o"></i></a><?php }
                                  } else {
                                 if ($role == ADMIN || $role == CENTER_COORDINATOR) {  ?><a class="globalModals" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/add/<?php echo $work['id'] ?>/<?php echo $classectionid; ?>/Tuesday" data-target="#globalModal" data-toggle="modal">Assign</a> <?php }
                                 } ?> </span><?php } ?>
                              </td>

                          <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><?php if (strpos($work['weekday'], "Wednesday") !== false) {
                          $getdata = $this->Comman->gettimetable($work['id'], "Wednesday", $classectionid);
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
                          }}}}?>


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
                                    ?></a></br>
                                  <?php if ($work['name'] == '1st' && $username == $getdata[0]['Employees']['email']) { ?><a class="text-green" href="<?php echo SITE_URL; ?>admin/Studattends/attendence/<?php echo $class; ?>/<?php echo $section; ?>/<?php echo $acedimc; ?>/<?php echo date("Y-m-d", strtotime('wednesday this week')); ?>" title="Take Attendance" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-hand-o-up"></i></a><?php }
                                if ($role == ADMIN || $role ==CENTER_COORDINATOR) { ?> <a class="text-red" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/delete/<?php echo $getdata[0]['id']; ?>/<?php echo $classectionid; ?>" data-toggle="tooltip" style="padding-left:5px;font-size:22px" data-confirm="Are you sure you want to delete this item?" data-method="post" title="Delete Lecture"><i class="fa fa-trash-o"></i></a><?php }
                                   } else {
                               if ($role == ADMIN || $role ==CENTER_COORDINATOR) {  ?><a class="globalModals" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/add/<?php echo $work['id'] ?>/<?php echo $classectionid; ?>/Wednesday" data-target="#globalModal" data-toggle="modal">Assign</a><?php }
                                 } ?></span> <?php } ?>
                             </td>

                          <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><?php if (strpos($work['weekday'], "Thursday") !== false) {
                          $getdata = $this->Comman->gettimetable($work['id'], "Thursday", $classectionid);
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
                        }}}}?>

                        
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
                                    </a></br>
                                <?php if ($work['name'] == '1st' && $username == $getdata[0]['Employees']['email']) { ?><a class="text-green" href="<?php echo SITE_URL; ?>admin/Studattends/attendence/<?php echo $class; ?>/<?php echo $section; ?>/<?php echo $acedimc; ?>/<?php echo date("Y-m-d", strtotime('thursday this week')); ?>" title="Take Attendance" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-hand-o-up"></i></a><?php }
                              if ($role == ADMIN || $role ==CENTER_COORDINATOR) {   ?> <a class="text-red" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/delete/<?php echo $getdata[0]['id']; ?>/<?php echo $classectionid; ?>" data-toggle="tooltip" style="padding-left:5px;font-size:22px" data-confirm="Are you sure you want to delete this item?" data-method="post" title="Delete Lecture"><i class="fa fa-trash-o"></i></a><?php }
                              } else {
                               if ($role == ADMIN || $role ==CENTER_COORDINATOR) {  ?><a class="globalModals" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/add/<?php echo $work['id']; ?>/<?php echo $classectionid; ?>/Thursday" data-target="#globalModal" data-toggle="modal">Assign</a><?php }
                               } ?> </span><?php } ?>
                          </td>
                          <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"> <?php if (strpos($work['weekday'], "Friday") !== false) {
                            $getdata = $this->Comman->gettimetable($work['id'], "Friday", $classectionid);
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
                           }}}}
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
                                    ?></a> </br>
                                    <?php if ($work['name'] == '1st' && $username == $getdata[0]['Employees']['email']) { ?><a class="text-green" href="<?php echo SITE_URL; ?>admin/Studattends/attendence/<?php echo $class; ?>/<?php echo $section; ?>/<?php echo $acedimc; ?>/<?php echo date("Y-m-d", strtotime('friday this week')); ?>" title="Take Attendance" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-hand-o-up"></i></a><?php }
                                    if ($role ==ADMIN || $role ==CENTER_COORDINATOR) {  ?> <a class="text-red" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/delete/<?php echo $getdata[0]['id']; ?>/<?php echo $classectionid; ?>" data-toggle="tooltip" style="padding-left:5px;font-size:22px" data-confirm="Are you sure you want to delete this item?" data-method="post" title="Delete Lecture"><i class="fa fa-trash-o"></i></a><?php }
                                     } else {
                                     if ($role == ADMIN || $role ==CENTER_COORDINATOR) {  ?><a class="globalModals" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/add/<?php echo $work['id'] ?>/<?php echo $classectionid; ?>/Friday" data-target="#globalModal" data-toggle="modal">Assign</a><?php }
                                     } ?> </span> <?php } ?>
                          </td>
                          <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"> <?php if (strpos($work['weekday'], "Saturday") !== false) {
                          $getdata = $this->Comman->gettimetable($work['id'], "Saturday", $classectionid);
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
                          }}}}?>


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
                                  </a></br>
                                  <?php if ($work['name'] == '1st' && $username == $getdata[0]['Employees']['email']) { ?><a class="text-green" href="<?php echo SITE_URL; ?>admin/Studattends/attendence/<?php echo $class; ?>/<?php echo $section; ?>/<?php echo $acedimc; ?>/<?php echo date("Y-m-d", strtotime('saturday this week')); ?>" title="Take Attendance" data-toggle="tooltip" style="padding-left:5px;font-size:22px"><i class="fa fa-hand-o-up"></i></a>
                                  <?php }
                               if ($role == ADMIN || $role ==CENTER_COORDINATOR) {  ?> <a class="text-red" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/delete/<?php echo $getdata[0]['id']; ?>/<?php echo $classectionid; ?>" data-toggle="tooltip" style="padding-left:5px;font-size:22px" data-confirm="Are you sure you want to delete this item?" data-method="post" title="Delete Lecture"><i class="fa fa-trash-o"></i></a><?php }
                             } else {
                             if ($role == ADMIN|| $role ==CENTER_COORDINATOR) {  ?><a class="globalModals" href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/add/<?php echo $work['id'] ?>/<?php echo $classectionid; ?>/Saturday" data-target="#globalModal" data-toggle="modal">Assign</a><?php }
                          } ?></span> <?php  } ?>
                          </td>
                        </tr>
                        <?php }
                      if ($work['is_break']) {
                        if ($work['name'] == 'Break') { ?>
                          <tr>
                            <td class="text-center text-bold"><?php echo $work['name']; ?></td>
                            <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;"> Break</span></td>
                            <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;">Break</span></td>
                            <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;">Break</span></td>
                            <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;">Break</span></td>
                            <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;">Break</span></td>
                            <td class="text-center" style="white-space: pre-wrap; word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;">Break</span></td>
                          </tr>
                  <?php  }
                      }
                    }
                  }   ?>
                <?php  } else {  ?>
                  <tr>
                    <td class="text-center text-bold" colspan="7">No Data Selected</td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>

            <script>
              //prepare the dialog
              //respond to click event on anything with 'overlay' class
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
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>