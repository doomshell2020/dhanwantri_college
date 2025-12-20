<!-- Content Wrapper. Contains page content -->
<style>
   .checkbox input[type="checkbox"] {
   opacity: 1;
   }
   #sel_date {
   z-index: 99999,
   opacity:1,
   }
   #load2 {
   width: 100%;
   height: 100%;
   position: fixed;
   z-index: 9999;
   background-color: white !important;
   background: url("<? use function PHPSTORM_META\type;
      echo SITE_URL; ?>images/Preloader_2.gif") no-repeat center center rgba(0, 0, 0, 0.75)
   }
   .content {
   min-height: 0px !important;
   }
</style>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      <i class="fa fa-money"></i> Take Class Attendence 
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>students/classattendance"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>students/classattendance">Take Class Attendence </a></li>
   </ol>
   <div id="load2" style="display:none;"></div>
</section>
<div class="box-header">
   <script>
      $(document).ready(function() {
      	$("#selectdate").bind("submit", function(event) {
      		$('.lds-facebook').show();
      		$.ajax({
      			async: true,
      			data: $("#selectdate").serialize(),
      			dataType: "html",
      			type: "POST",
      			url: "<?php echo ADMIN_URL; ?>students/searchattendence",
      			success: function(data) {
      				$('.lds-facebook').hide();
      				$("#updt").html(data);
      			},
      		});
      		return false;
      	});
      
      	15
      
      	$(function() {
      		$("#datepicker").datepicker({
      			changeYear: true,
      			dateFormat: 'dd-mm-yy',
      			maxDate: new Date(),
      		});
      	});
      
      });
   </script>
   <?php echo $this->Form->create('selectdate', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'selectdate', 'class' => '')); ?>
   <div class="form-group pull-left" style="display:flex; align-items:flex-end; margin-bottom:0px;">
      <div style="margin-right:10px;">
         <label for="inputEmail3" class="control-label">Select Date</label>
         <input type="text" class="form-control datepicker" id='datepicker' autocomplete="off" name="date" placeholder="DD-MM-YYYY" readonly required >
      </div>
      <input type="submit" style="background-color:#00c0ef; color:#fff" id="selectdate" class="btn btn4 btn_pdf myscl-btn date" value="Search">
   </div>
   <div style="clear-both"></div>
</div>
<section class="content" id="updt">
<span class="description">
<?
   if (isset($classess) && !empty($classess)) {
   	$findstudentrfidclassss = 0;
   	$findstudentwithrfidclassss = 0;
   	$findstudentamountcnt = 0;
   	$c1 = 0;
   	$errt = array();
   	$errst = array();
   	foreach ($classess as $element) {
   		$s_id = $element['class_id'];
   		$c_id = $element['section_id'];
   	}
   }   ?>
<strong>Total Students </strong> : <?php echo $studentcnt; ?> </span>
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-header">
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
   <!-- /.box-header -->
   <?php echo $this->Flash->render(); ?>
</div>
<div id="updt">
<div class="table-responsive">
<table id="" class="table table-bordered table-striped">
   <tbody>
      <tr>
         <th>S.No</th>
         <th>Class</th>
         <th>Section</th>
         <th>Class Teacher</th>
         <th>Mobile No.</th>
         <th>Strength</th>
         <th> Absent Today </th>
         <th> Take Attendance </th>
      </tr>
      <?php
         $page = $this->request->params['paging']['Services']['page'];
         $limit = $this->request->params['pagc_c_iding']['Services']['perPage'];
         $counter = 1;
         $total = 0;
         $totalfee = 0;
         $out = 0;
         $total_discount = 0;
         $total_absent = 0;
         
         $session = $this->request->session();
         $session->delete($classess);
         $session->write('classess', $classess);
         if (isset($classess) && !empty($classess)) {
         	$findstudentamount = 0;
         	$findstudentrfidclass = 0;
         	// pr($classess);die;
         	foreach ($classess as $element) {
         
         		if ($element['class_id']) {
         			$findstudenttotlaclassdds = $this->Comman->classtotalstudent($element['class_id'], $element['section_id']);
         			// pr($findstudenttotlaclassdds);die;
         			if ($findstudenttotlaclassdds == 0) {
         				continue;
         			}
         
         			$s_id = $element['class_id'];
         			$c_id = $element['section_id'];
         ?>
      <tr>
         <td><?php echo $counter;  ?></td>
         <td><?php $class = $this->Comman->findclasses($s_id);
            echo $class[0]['title'];
            ?> </td>
         <td><?php
            echo $element['Sections']['title'];
            ?> </td>
         <td><?php
            $ss = $this->Comman->findclassteachersorginal($element['class_id'], $element['section_id']);
            $studentname = ucwords(strtolower($ss['employee']['fname'] . " " . $ss['employee']['middlename'] . " " . $ss['employee']['lname']));
            echo $studentname;
            ?> 
         </td>
         <td><?php echo $ss['employee']['mobile']; ?> </td>
         <?php $findstudentamount = $this->Comman->findstudentcountclass($element['class_id'], $element['section_id']);  ?>
         <td> <?php	echo $findstudenttotlaclassdds; ?></td>
         <td> <?php
            $findstudenttotlacslasssabsent = $this->Comman->absentclasstodayreportss23($element['class_id'], $element['section_id']);
            
            $classstodayreportss23 = $this->Comman->classtodayreportss23($element['class_id'], $element['section_id']);
            
            $classstotalstudent = $findstudenttotlaclassdds;
            
            
            if ($classstodayreportss23) {
            
            	if ($findstudenttotlacslasssabsent != '0') { ?> 
            <a target="_blank" href="<?php echo SITE_URL; ?>admin/students/searchabsent/<?php echo $element['class_id']; ?>/<?php echo $element['section_id']; ?>"> <? $total_absent += $findstudenttotlacslasssabsent;	echo $findstudenttotlacslasssabsent; ?></a> <?php } else {	echo $findstudenttotlacslasssabsent;	}	} else {
               ?> <strong title="Absent Student" style="color:red;"><? echo $findstudenttotlaclassdds; ?></strong> </a> <?php }   ?></a>
         </td>
         <td><?php if ($output['canTakeAttendance'] == 1) {
            $mid = base64_encode(base64_encode($element['class_id'] . '/' . $element['section_id'] . '/' . $acedmic)) ?>
            <a href="<?php echo ADMIN_URL; ?>studattends/attendence/<?php echo $mid; ?>"><i class="fas fa-street-view"></i></a>
            <?php } else { ?> <i class="fas fa-ban"></i><?php } ?>
         </td>
      </tr>
      <?php $counter++;
         }
         }
         } else { ?>
      <td colspan="8" style="text-align:center;">No Student Data Available</td>
      <?	} ?>
</table>
<span id="tabsent" style="display:none;"><? echo $total_absent; ?></span>
<script>
   $(document).ready(function() {
   	var tabse = $("#tabsent").text();
   	$("#tabsent2").html(tabse);
   
   });
</script>
<div>
</div>
<script>
   $(document).ready(function() {
   	$("#attn_date").bind("submit", function(event) {
   		$.ajax({
   			async: true,
   			data: $("#attn_date").serialize(),
   			dataType: "html",
   			type: "POST",
   			beforeSend: function() {
   				// setting a timeout
   				$('#load2').css("display", "block");
   			},
   
   			url: "<?php echo ADMIN_URL; ?>students/classidcard_search",
   			success: function(data) {
   				//  alert(data);
   				$('#load2').css("display", "none");
   				$("#updt").html(data);
   			},
   
   		});
   		return false;
   
   	});
   });
</script>