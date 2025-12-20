<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title">
      <i class="fa fa-file-pdf-o"></i> Transfer Certificate of <?php echo $student['fname'] . " " . $student['middlename'] . " " . $student['lname']; ?> (<? echo $student['enroll']; ?>)
   </h4>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
   $('.qualified').change(function() {
   	var urt = $(this).val();
   	// alert('gfgfg');
   
   	if (urt == 'Pass') {
   		$('.promotclass').show();
   		$("select#promoted_classid").prop('required', true);
   	} else {
   		//$("select#promoted_classid").prop('selectedIndex', 0);
   		$("select#promoted_classid").prop('required', false);
   		$('.promotclass').hide();
   	}
   	//var sgh=$("#qualified option:selected").text();qualified_hclass
   });
   
   
   $(function() {
   	$(".qualified").change(function() {
   
   		var urt = $(this).val();
   		if (urt == 'Yes') {
   			$('.promotclass').show();
   			$("select#promoted_classid").prop('required', true);
   		} else {
   			//$("select#promoted_classid").prop('selectedIndex', 0);
   			$("select#promoted_classid").prop('required', false);
   			$('.promotclass').hide();
   		}
   		// do your stuff
   	});
   });
</script>
<?php
   // student Attendence 
       $attendncterm1 = $this->Comman->findstuattendetails($student['s_id'],$student['class_id'],$student['section_id'],1);
       $attendncterm2 = $this->Comman->findstuattendetails($student['s_id'],$student['class_id'],$student['section_id'],2);
   	// pr($attendncterm1);die;
   
       $WorkingDays = $attendncterm1['total']+$attendncterm2['total'];
       $daysAttended = $attendncterm1['present']+$attendncterm2['present'];
   ?>
<?php echo $this->Form->create($student, array('class' => 'form-horizontal', 'target' => '_blank')); ?>
<div class="modal-body">
   <div class="row">
      <div class="col-sm-12">
         <div class="form-group">
            <div class="col-sm-6">
               <label>Application Date<span>
               <font color="red"> *</font>
               </span></label>
               <?php
                  echo $this->Form->input(
                  	'date_application',
                  	array('class' => 'form-control', 'type' => 'date', 'label' => false, 'id' => 'qualified', 'required')
                  );
                  ?>
            </div>
            <div class="col-sm-6">
               <label>Issue Date<span>
               <font color="red"> *</font>
               </span></label>
               <?php
                  echo $this->Form->input(
                  	'date_issue',
                  	array('class' => 'form-control', 'type' => 'date', 'label' => false, 'id' => 'qualified', 'required')
                  );
                  ?>
            </div>
            <div class="col-sm-12"><label>&nbsp;</label></div>
            <div class="col-sm-3">
               <label>S.No.<span>
               <font color="red"> *</font>
               </span></label>
               <?php $lstbook = $this->Comman->gethistoryyeard();
                  if ($student['bookno']) {
                  	$bbokno = $student['bookno'];
                  } else {
                  	$bbokno = $lstbook['bookno'] + 1;
                  }
                  echo $this->Form->input('bookno', array('class' => 'form-control', 'value' => $bbokno, 'type' => 'text', 'required', 'label' => false));
                  ?>
               <?php
                  echo $this->Form->input('sino', array('class' => 'form-control', 'type' => 'hidden', 'value' => '0', 'label' => false));
                  ?>
            </div>
            <div class="col-sm-3" style="color:red;">
               <label>Academic Year*</label>
               <?php
                  echo $this->Form->input(
                  	'updateacedemic',
                  	array('class' => 'accademic form-control', 'type' => 'select', 'empty' => 'Select Year', 'options' => $acd, 'value' => $student['updateacedemic'], 'label' => false, 'id' => 'accademic', 'required')
                  );
                  ?>
            </div>
            <div class="col-sm-3">
               <label>If Guardian Name</label>
               <?php
                  echo $this->Form->input('guardian', array('class' => 'form-control', 'type' => 'text', 'label' => false));
                  ?>
            </div>
            <div class="col-sm-3">
               <label>Nationality</label>
               <?php
                  echo $this->Form->input('nationality', array('class' => 'form-control', 'type' => 'text', 'label' => false));
                  ?>
            </div>
            <div class="col-sm-6">
               <label>School/Board Annual Examination last taken result<span style="color:red;">*</span></label>
               <?php
                  echo $this->Form->input(
                  	'school_lastresult',
                  	array('class' => 'quaglified form-control', 'type' => 'select', 'empty' => 'Select', 'options' => ['Pass' => 'Pass', 'Detain' => 'Detain', 'Compartment' => 'Compartment', 'Not Taken' => 'Not Taken'], 'label' => false, 'id' => 'quaglified', 'required')
                  );
                  ?>
            </div>
            <div class="col-sm-6">
               <label>If failed,whether once/twice in the same class</label>
               <?php
                  echo $this->Form->input('againclass', array('class' => 'form-control', 'type' => 'text', 'label' => false));
                  ?>
            </div>
            <div class="col-sm-6">
               <label>Total no of working days</label>
               <?php
                  if($WorkingDays!=0){
                  	echo $this->Form->input('workingdays', array('class' => 'form-control', 'type' => 'text', 'label' => false, 'value' => $WorkingDays));
                  }else{
                  
                  	echo $this->Form->input('workingdays', array('class' => 'form-control', 'type' => 'text', 'label' => false, 'default' => '180'));
                  }
                  ?>
            </div>
            <div class="col-sm-6">
               <label>Total no of working days present </label>
               <?php
                  if($daysAttended!=0){
                  	echo $this->Form->input('presentdays', array('class' => 'form-control', 'type' => 'text', 'label' => false, 'value' => $daysAttended));
                  }else{
                  
                  	echo $this->Form->input('presentdays', array('class' => 'form-control', 'type' => 'text', 'label' => false, 'default' => '180'));
                  }
                  ?>
            </div>
            <div class="col-sm-6">
               <label>Qualified for promotion to Higher Class</label>
               <?php
                  echo $this->Form->input(
                  	'qualified_to_promote',
                  	array('class' => 'qualified form-control', 'type' => 'select', 'empty' => 'Select Choice', 'options' => ['Yes' => 'Yes', 'No' => 'No'], 'label' => false, 'id' => 'qualified_hclass')
                  );
                  ?>
            </div>
            <script src="http://code.jquery.com/jquery-1.12.3.min.js"></script>
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
            <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>
            <script inline="1">
               $(".stu_class").change(function(){
               var urt = $(this).val();
               if(urt==17 || urt==20 || urt==22 ){
               $(".dis_class").prop('disabled', true);
               $(".dis_class").val("");
               $('.dis_class').attr('required', false);
               }else{
               $(".dis_class").prop('disabled', false);
               $('.dis_class').attr('required', true);
               }
               });
            </script>
            <div class="col-sm-6">
               <label>Class in which pupil last studied </label>
               <select name="laststudclass" id="lststudclass " class="form-control stu_class">
                  <option value="0">Select Class</option>
                  <? if ($student['laststudclass']) { ?>
                  <?php foreach ($classes2 as $jk => $rt) { ?>
                  <option value="<? echo $jk; ?>" <? if ($student['laststudclass'] == $jk) { ?> selected <? } ?>><? echo $rt; ?></option>
                  <? } ?>
                  <? } else { ?>
                  <?php foreach ($classes2 as $jk => $rt) { ?>
                  <option value="<? echo $jk; ?>" <? if ($student['class_id'] == $jk) { ?> selected <? } ?>><? echo $rt; ?></option>
                  <? } ?>
                  <? } ?>
               </select>
            </div>
         </div>
         <div class="form-group">
            <div class="col-sm-6">
               <label>Month upto which the school fee is paid</label>
               <?php
                  $ec = $this->Comman->findfeesmonth34($student['s_id']);
                  $quuar = unserialize($ec['quarter']);
                  $qra = array();
                  foreach ($quuar as $h => $rt) {
                  	$qra[] = $h;
                  }
                  $monthupto = date('M Y', strtotime($ec['paydate']));
                  if (in_array('Quater4', $qra) && in_array('Quater3', $qra) && in_array('Quater2', $qra) && in_array('Quater1', $qra)) {
                  	$monthuptosa = 'Mar';
                  } else {
                  	if (in_array('Quater1', $qra)) {
                  		$monthuptoss = "Jun";
                  	} elseif (in_array('Quater2', $qra)) {
                  		$monthuptoss = "Sep";
                  	} elseif (in_array('Quater3', $qra)) {
                  		$monthuptoss = "Dec";
                  	} elseif (in_array('Quater4', $qra)) {
                  		$monthuptoss = "Mar";
                  	}
                  	$monthuptos = date('M', strtotime($ec['paydate']));
                  	$monthuptosyy = date('Y', strtotime($ec['paydate']));
                  }
                  $e1 = array('Mar', 'Apr', 'May', 'Jun');
                  $e2 = array('Jul', 'Aug', 'Sep');
                  $e3 = array('Oct', 'Nov', 'Dec');
                  $e4 = array('Jan', 'Feb', 'Mar');
                  
                  if (in_array('Quater4', $qra)) {
                  
                  	$monthupto = 'Mar ' . date('Y');
                  } elseif ($monthuptoss) {
                  	$monthupto = $monthuptoss . " " . date('Y', strtotime($ec['paydate']));
                  } elseif (in_array($monthuptos, $e1)) {
                  	$monthupto = 'Jun ' . date('Y', strtotime($ec['paydate']));
                  } elseif (in_array($monthuptos, $e2)) {
                  	$monthupto = 'Sep ' . date('Y', strtotime($ec['paydate']));
                  } elseif (in_array($monthuptos, $e3)) {
                  	$monthupto = 'Dec ' . date('Y', strtotime($ec['paydate']));
                  } elseif (in_array($monthuptos, $e4)) {
                  	$monthupto = 'Mar ' . date('Y', strtotime($ec['paydate']));
                  } elseif ($monthuptosa) {
                  	$monthupto = 'Mar ' . date('Y');
                  	// $monthupto = 'N/A';
                  }
                  
                  if ($student['month']) {
                  	echo $this->Form->input('month', array('class' => 'form-control', 'value' => $student['month'], 'label' => false, 'type' => 'text'));
                  } else {
                  	// echo $this->Form->input('month', array('class' => 'form-control', 'value' => $monthupto, 'label' => false, 'type' => 'text'));
                  	echo $this->Form->input('month', array('class' => 'form-control', 'default' => 'N/A', 'label' => false, 'type' => 'text'));
                  }
                  
                  ?>
            </div>
            <div <? if ($student['qualified_to_promote'] == "No") { ?> style="display:none;" <? } ?> class="col-sm-6 promotclass ">
               <label>Promoted to class <span style="color:red;"> *</span></label>
               <select name="promoted_to_class_id" id="promoted_classid" class="form-control dis_class" required>
                  <?php if ($student['laststudclass']) {
                     if ($student['laststudclass'] == '18') {
                     	$c = '19';
                     } elseif ($student['laststudclass'] == '19') {
                     	$c = '1';
                     } elseif ($student['laststudclass'] == '1') {
                     	$c = '2';
                     } elseif ($student['laststudclass'] == '2') {
                     	$c = '3';
                     } elseif ($student['laststudclass'] == '3') {
                     	$c = '4';
                     } elseif ($student['laststudclass'] == '4') {
                     	$c = '6';
                     } elseif ($student['laststudclass'] == '6') {
                     	$c = '7';
                     } elseif ($student['laststudclass'] == '7') {
                     	$c = '8';
                     } elseif ($student['laststudclass'] == '8') {
                     	$c = '9';
                     } elseif ($student['laststudclass'] == '9') {
                     	$c = '10';
                     } elseif ($student['laststudclass'] == '10') {
                     	$c = '11';
                     } elseif ($student['laststudclass'] == '11') {
                     	$c = '12';
                     } elseif ($student['laststudclass'] == '12') {
                     	$c = '17';
                     } elseif ($student['laststudclass'] == '13') {
                     	$c = '20';
                     } elseif ($student['laststudclass'] == '15') {
                     	$c = '22';
                     } elseif ($student['laststudclass'] == '23') {
                     	$c = '24';
                     } elseif ($student['laststudclass'] == '24') {
                     	$c = '28';
                     } elseif ($student['laststudclass'] == '28') {
                     	$c = '25';
                     } elseif ($student['laststudclass'] == '25') {
                     	$c = '29';
                     } elseif ($student['laststudclass'] == '26') {
                     	$c = '27';
                     } elseif ($student['laststudclass'] == '30') {
                     	$c = '31';
                     } elseif ($student['laststudclass'] == '31') {
                     	$c = '1';
                     }
                     } elseif ($student['class_id']) {
                     
                     if ($student['class_id'] == '18') {
                     	$c = '19';
                     } elseif ($student['class_id'] == '19') {
                     	$c = '1';
                     } elseif ($student['class_id'] == '1') {
                     	$c = '2';
                     } elseif ($student['class_id'] == '2') {
                     	$c = '3';
                     } elseif ($student['class_id'] == '3') {
                     	$c = '4';
                     } elseif ($student['class_id'] == '4') {
                     	$c = '6';
                     } elseif ($student['class_id'] == '6') {
                     	$c = '7';
                     } elseif ($student['class_id'] == '7') {
                     	$c = '8';
                     } elseif ($student['class_id'] == '8') {
                     	$c = '9';
                     } elseif ($student['class_id'] == '9') {
                     	$c = '10';
                     } elseif ($student['class_id'] == '10') {
                     	$c = '11';
                     } elseif ($student['class_id'] == '11') {
                     	$c = '12';
                     } elseif ($student['class_id'] == '12') {
                     	$c = '17';
                     } elseif ($student['class_id'] == '13') {
                     	$c = '20';
                     } elseif ($student['class_id'] == '15') {
                     	$c = '22';
                     } elseif ($student['class_id'] == '23') {
                     	$c = '24';
                     } elseif ($student['class_id'] == '24') {
                     	$c = '28';
                     } elseif ($student['class_id'] == '28') {
                     	$c = '25';
                     } elseif ($student['class_id'] == '25') {
                     	$c = '29';
                     } elseif ($student['class_id'] == '26') {
                     	$c = '27';
                     } elseif ($student['laststudclass'] == '30') {
                     	$c = '31';
                     } elseif ($student['laststudclass'] == '31') {
                     	$c = '1';
                     }
                     } ?>
                  <? if ($student['promoted_to_class_id']) { ?>
                  <option value="0">Select Class</option>
                  <?php foreach ($classes2 as $jk => $rt) { ?>
                  <option value="<? echo $jk; ?>" <? if ($student['promoted_to_class_id'] == $jk) { ?> selected <? } ?>><? echo $rt; ?></option>
                  <? }
                     } else { ?>
                  <option value="">Select Class</option>
                  <?php foreach ($classes2 as $jk => $rt) { ?>
                  <option value="<? echo $jk; ?>" <? if ($c == $jk) { ?> selected <? } ?>><? echo $rt; ?></option>
                  <? }
                     } ?>
               </select>
            </div>
         </div>
         <div class="form-group">
            <div class="col-sm-6">
               <label>Whether NCC Cadet/Boy Scout/Girl Guide</label>
               <?php echo $this->Form->input('NCC_cadet', array('class' => 'form-control', 'label' => false, 'type' => 'text', 'default' => 'N/A')); ?>
            </div>
            <div class="col-sm-6">
               <label>Games/Extra curricular activities took part</label>
               <?php echo $this->Form->input('extra_curricular_activities', array('class' => 'form-control', 'label' => false, 'type' => 'text', 'default' => 'N/A')); ?>
            </div>
         </div>
         <div class="form-group">
            <div class="col-sm-6">
               <label>Whether School is under Govt./Minority/Independent Category</label>
               <?php echo $this->Form->input('govt_category', array('class' => 'form-control', 'label' => false, 'type' => 'text', 'default' => 'N/A')); ?>
            </div>
            <div class="col-sm-6">
               <label>Date on which pupils name was struck off the rolls of the school</label>
               <?php echo $this->Form->input('struck_off_date', array('class' => 'form-control', 'label' => false, 'type' => 'date')); ?>
            </div>
         </div>
         <div class="form-group">
            <? if ($student['laststudclass']) {
               $studenta['class_id'] = $student['laststudclass'];
               } elseif ($student['class_id']) {
               
               if ($student['class_id'] == '18') {
               	$studenta['class_id'] = '18';
               } elseif ($student['class_id'] == '19') {
               	$studenta['class_id'] = '18';
               } elseif ($student['class_id'] == '1') {
               	$studenta['class_id'] = '19';
               } elseif ($student['class_id'] == '2') {
               	$studenta['class_id'] = '1';
               } elseif ($student['class_id'] == '3') {
               	$studenta['class_id'] = '2';
               } elseif ($student['class_id'] == '4') {
               	$studenta['class_id'] = '3';
               } elseif ($student['class_id'] == '6') {
               	$studenta['class_id'] = '4';
               } elseif ($student['class_id'] == '7') {
               	$studenta['class_id'] = '6';
               } elseif ($student['class_id'] == '8') {
               	$studenta['class_id'] = '7';
               } elseif ($student['class_id'] == '9') {
               	$studenta['class_id'] = '8';
               } elseif ($student['class_id'] == '10') {
               	$studenta['class_id'] = '9';
               } elseif ($student['class_id'] == '11') {
               	$studenta['class_id'] = '10';
               } elseif ($student['class_id'] == '12') {
               	$studenta['class_id'] = '11';
               } elseif ($student['class_id'] == '13') {
               	$studenta['class_id'] = '11';
               } elseif ($student['class_id'] == '15') {
               	$studenta['class_id'] = '11';
               } elseif ($student['class_id'] == '17') {
               	$studenta['class_id'] = '12';
               } elseif ($student['class_id'] == '20') {
               	$studenta['class_id'] = '13';
               } elseif ($student['class_id'] == '22') {
               	$studenta['class_id'] = '15';
               } elseif ($student['class_id'] == '23') {
               	$studenta['class_id'] = '23';
               } elseif ($student['class_id'] == '24') {
               	$studenta['class_id'] = '23';
               } elseif ($student['class_id'] == '25') {
               	$studenta['class_id'] = '24';
               } elseif ($student['class_id'] == '28') {
               	$studenta['class_id'] = '25';
               } elseif ($student['class_id'] == '27') {
               	$studenta['class_id'] = '27';
               } elseif ($student['class_id'] == '30') {
               	$studenta['class_id'] = '19';
               } elseif ($student['class_id'] == '32') {
               	$studenta['class_id'] = '30';
               }
               }
               
               if ($db == "sanskar") {
               if ($studenta['class_id'] == '18' || $studenta['class_id'] == '19' || $studenta['class_id'] == '1' || $studenta['class_id'] == '2' || $studenta['class_id'] == '3' || $studenta['class_id'] == '4' || $studenta['class_id'] == '5' || $studenta['class_id'] == '6') {
               $opts = array();
               $subjectsclass = $this->Comman->find_subjectsprinttc($studenta['class_id']);
               if ($student['tcsubject']) {
               $opts = explode(",", $student['tcsubject']);
               }
               ?>
            <div class="col-sm-6">
               <label>Any Fee Concession</label>
               <?php echo $this->Form->input('anyfeeconcession', array('class' => 'form-control', 'label' => false, 'type' => 'text')); ?>
            </div>
            <div class="col-sm-6">
               <label>Subject Studied</label>
               <select name="tcsubject[]" class="form-control" multiple="multiple" required>
                  <option value="0">Select Subject</option>
                  <?php foreach ($subjectsclass as $jk => $rt) {
                     ?>
                  <option value="<? echo $rt['id']; ?>" <? if (in_array($rt['id'], $opts)) { ?>selected <? } elseif (empty($opts)) { ?>selected <? } ?>><? echo $rt['name']; ?></option>
                  <? } ?>
               </select>
            </div>
            <? } elseif ($studenta['class_id'] == '7' || $studenta['class_id'] == '8' || $studenta['class_id'] == '9' || $studenta['class_id'] == '10' || $studenta['class_id'] == '11' || $studenta['class_id'] == '23' || $studenta['class_id'] == '24' || $studenta['class_id'] == '25' || $studenta['class_id'] == '28' || $studenta['class_id'] == '29' ) {
               $opts = array();
               
               $subjectsclass = $this->Comman->find_subjectsexprinter($studenta['class_id']);
               if ($student['tcsubject']) {
               	$opts = explode(",", $student['tcsubject']);
               }
               ?>
            <div class="col-sm-6">
               <label>Any Fee Concession</label>
               <?php echo $this->Form->input('anyfeeconcession', array('class' => 'form-control', 'label' => false, 'type' => 'text')); ?>
            </div>
            <div class="col-sm-6">
               <label>Subject Studied</label>
               <select name="tcsubject[]" required="required" class="form-control" multiple="multiple">
                  <option value="0">Select Subject</option>
                  <?php foreach ($subjectsclass as $jk => $rt) {
                     ?>
                  <option value="<? echo $rt['id']; ?>" <? if (in_array($rt['id'], $opts)) { ?>selected <? } elseif (empty($opts)) { ?>selected <? } ?>><? echo strtoupper($rt['exprint']); ?></option>
                  <? } ?>
               </select>
            </div>
            <? } elseif ($studenta['class_id'] == '26' || $studenta['class_id'] == '27') {
               $opts = array();
               
               $subjectsclass = $this->Comman->findibdpsubject();
               
               if ($student['tcsubject']) {
               	$opts = explode(",", $student['tcsubject']);
               }
               ?>
            <div class="col-sm-6">
               <label>Any Fee Concession</label>
               <?php echo $this->Form->input('anyfeeconcession', array('class' => 'form-control', 'label' => false, 'type' => 'text')); ?>
            </div>
            <div class="col-sm-6">
               <label>Subject StudiedR</label>
               <select name="tcsubject[]" required="required" class="form-control" multiple="multiple">
                  <option value="0">Select Subject</option>
                  <?php foreach ($subjectsclass as $jk => $rt) { ?>
                  <option value="<? echo $rt['id']; ?>" <? if (in_array($rt['id'], $opts)) { ?>selected <? } ?>><? echo strtoupper($rt['name']); ?></option>
                  <? } ?>
               </select>
            </div>
            <?php } else { ?>
            <div class="col-sm-12">
               <label>Any Fee Concession</label>
               <?php echo $this->Form->input('anyfeeconcession', array('class' => 'form-control', 'label' => false, 'type' => 'text')); ?>
            </div>
            <?php }
               } else {
               
               	// pr($student);die;
               
               	if ($db != 'kidsclub' || $db != 'palaceschool' || $db != 'demoschool' || $db != 'sanskar' || $db != 'rajshree') {
               		
               		if ($studenta['class_id'] == 18) {
               			$class_id = 19;
               		} else {
               			$class_id = $studenta['class_id'];
               		}
               		
               		$subjectsclass = $this->Comman->find_subjectsexprinter($class_id);
               		if ($student['tcsubject']) {
               			$opts = explode(",", $student['tcsubject']);
               		}
               
               	} else {
               		$subjectsclass = $this->Comman->find_subjectsexprinter($class_id);
               		if ($student['tcsubject']) {
               			$opts = explode(",", $student['tcsubject']);
               		}
               	}
               
               	// pr($subjectsclass);exit;
               
               	?>
            <div class="col-sm-6">
               <label>Any Fee Concession</label>
               <?php echo $this->Form->input('anyfeeconcession', array('class' => 'form-control', 'label' => false, 'type' => 'text', 'default' => 'N/A')); ?>
            </div>
            <div class="col-sm-6">
               <label>Subject Studied </label>
               <select name="tcsubject[]" required class="form-control" multiple="multiple">
                  <option value="0">Select Subject</option>
                  <?php 
                     foreach ($subjectsclass as $jk => $rt) {?>
                  <option value="<?php echo $rt['id']; ?>" <?php if (in_array($rt['id'], $opts)) { ?>selected <?php } elseif (empty($opts)) { ?>selected <?php } ?>><? echo strtoupper($rt['exprint']); ?></option>
                  <?php } ?>
               </select>
            </div>
            <?php	} ?>
         </div>
         <div class="form-group">
            <div class="col-sm-6">
               <label>First Admission Date<span>
               <font color="red"> *</font>
               </span></label>
               <?php
                  echo $this->Form->input(
                  	'admissiondate',
                  	array('class' => 'form-control', 'type' => 'date', 'label' => false, 'id' => 'qualified', 'required', 'minYear' => date('Y') - 20, 'maxYear' => date('Y'))
                  );
                  ?>
            </div>
            <div class="col-sm-6">
               <label>First Admission Class<span>
               <font color="red"> *</font>
               </span></label>
               <select name="admissionclass" class="form-control" required="required">
                  <option value="-">Select Admission Class</option>
                  <?php foreach ($admissionclass as $jhj => $rdt) { ?>
                  <option value="<? echo $jhj; ?>" <? if ($student['admissionclass'] == $jhj) { ?> selected <? } ?>><? echo $rdt; ?></option>
                  <? } ?>
               </select>
            </div>
         </div>
         <div class="form-group">
            <div class="col-sm-6">
               <label>Mention achievement level</label>
               <?php echo $this->Form->input('achievement_level', array('class' => 'form-control', 'label' => false, 'type' => 'text')); ?>
            </div>
            <div class="col-sm-6">
               <label>General Conduct<span>
               <font color="red"> *</font>
               </span></label>
               <?php echo $this->Form->input('general_conduct', array('class' => 'form-control', 'label' => false, 'required', 'type' => 'text')); ?>
            </div>
         </div>
         <div class="form-group">
            <div class="col-sm-6">
               <label>Reason for Leaving<span>
               <font color="red"> *</font>
               </span></label>
               <?php echo $this->Form->input('leaving_reason', array('autocomplete' => 'on', 'type' => 'text', 'class' => 'form-control', 'label' => false, 'required')); ?>
            </div>
            <div class="col-sm-6">
               <label>Any Other Remarks</label>
               <?php echo $this->Form->textarea('remarks', array('rows' => '1', 'class' => 'form-control', 'label' => false, 'type' => 'text')); ?>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal-footer">
   <?php
      if ($db != 'sanskar') {
      	echo $this->Form->submit(
      		'Generate TC',
      		array('class' => 'btn btn-info pull-left', 'style' => 'margin-right: 10px;')
      	);
      }
      ?>
   <button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
</div>
<?php echo $this->Form->end(); ?>