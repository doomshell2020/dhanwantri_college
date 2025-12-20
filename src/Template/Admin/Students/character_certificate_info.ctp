<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title">
      <i class="fa fa-file-pdf-o"></i> Character Certificate
   </h4>
</div>
<?php echo $this->Form->create($student, array('class'=>'form-horizontal')); ?>
<div class="modal-body">
   <div class="row">
      <div class="col-sm-12">
         <div class="form-group">
            <div class="col-sm-12">
               <label>Character as Recorded by School Discipline Committee <span><font color="red"> *</font></span></label>
               <input type="hidden" name="s_id" value="<? echo $student['s_id']; ?>">
               <?php echo $this->Form->input('charctercertificate', array('class'=>'qualified form-control','type'=>'select', 'empty'=>'Select Choice','options'=>['good moral character'=>'good moral character','good'=>'good', 'satisfactory'=>'satisfactory', 'unsatisfactory'=>'unsatisfactory'], 'label' =>false,'id'=>'qualified', 'required'));
                  ?>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal-footer">
   <?php
      echo $this->Form->submit(
      	'Generate CC', 
      	array('class' => 'btn btn-info pull-left','style'=>'margin-right: 10px;')
      );
      ?>
   <button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
</div>
<?php echo $this->Form->end(); ?>