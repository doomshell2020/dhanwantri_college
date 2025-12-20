<?php if ($student['request_for_drop'] != 'Y' || $student['request_for_drop'] == '') { //pr($student);die;
   ?>
<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title">
      Request for Approvales Head Branch :<?php echo $student['fname'] . " " . $student['middlename'] . " " . $student['lname']; ?> (<?php echo $student['enroll']; ?>)
   </h4>
</div>
<?php echo $this->Form->create($student, array('class' => 'form-horizontal', 'action' => 'statusdroprequest')); ?>
<div class="modal-body" style="padding:10px 40px; ">
   <div class="row">
      <div class="col-sm-12">
         <div class="form-group">
            <label>Description</label>
            <?php
               echo $this->Form->input('description', array('class' => 'form-control', 'type' => 'textarea', 'label' => false, 'cols' => '85', 'rows' => '4', 'require'));
               ?>
         </div>
      </div>
   </div>
</div>
<div class="modal-footer">
   <button data-dismiss="modal" class="btn btn-default pull-left" type="button">Close</button>
   <?php
      echo $this->Form->submit(
      	'Submit',
      	array('class' => 'btn btn-info pull-right', 'style' => 'margin-right: 10px;')
      );
      
      ?>
</div>
<?php echo $this->Form->end(); ?>
<?php } else { ?>
<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title">
      Certificate Approvales <?php echo $student['fname'] . " " . $student['middlename'] . " " . $student['lname']; ?> (<?php echo $student['enroll']; ?>)
   </h4>
</div>
<?php echo $this->Form->create($student, array('class' => 'form-horizontal')); ?>
<div class="modal-body">
   <div class="row">
      <div class="col-sm-12">
         <div class="form-group">
            <div class="col-sm-12">
               <h1 style="text-align: center;">Your request is under process</h1>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal-footer">
   <button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
</div>
<?php } ?>