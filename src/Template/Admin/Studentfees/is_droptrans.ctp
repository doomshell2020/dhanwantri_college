<div class="modal-header" style="height: 65px; background:#2d95e3;">
  <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
  <h4 class="modal-title">Are You Sure ? Do You Want To Drop This Student from Transport. <b class="ert"> </b></h4>
</div>
<?php echo $this->Form->create($student_data, array('url' => array('controller' => 'studentfees', 'action' => 'is_droptrans'), 'class' => '', 'id' => 'sevice_form', 'enctype' => 'multipart/form-data', 'validate', 'autocomplete' => 'off')); ?>
<div class="modal-body transport">
  <div class="row">
    <!-- <div class="row"> -->
    <?php //$loc_selected = $student_data['location_id'];
    //$bus_selected = $student_data['bus_number'];
    ?>

    <div class="col-sm-6 align-self-center fields" style="margin-bottom: 15px;">
    <textarea name="reason" class="form-control rounded-0" id="exampleFormControlTextarea2" placeholder="Enter Reson Here" rows="3" style="width: 622px; height: 103px;"></textarea>
    </div>

    <div class="col-sm-12" id="enquiryexist" style="display:none" style="margin-bottom: 15px;"> </div>

    <div class="col-sm-12" style="margin-bottom: 15px;">
      <input type="hidden" name="academic_year" id="academic_year" value="<? echo $acedmicyear; ?>">
      <input type="hidden" name="student_id" id="student_id" value="<? echo $sid; ?>">
    </div>
  </div>
</div>
<br>
<!--./modal-body-->
<div class="modal-footer">

  <button data-dismiss="modal" class="btn btn-default pull-left fields" type="button" style="margin-left: 32px;">Close</button>
  <?php
  if (isset($student_data['id'])) {
    echo $this->Form->submit(
      'Update',
      array('class' => 'btn btn-default pull-right fields', 'style' => '', 'title' => 'Update', 'style' => 'margin-right:31px')
    );
  } else {
    echo $this->Form->submit(
      'Submit',
      array('class' => 'btn btn-default pull-right fields', 'style' => '', 'title' => 'Submit', 'style' => 'margin-right:31px')
    );
  }
  ?>

  <?php
  echo $this->Form->submit(
    'Restore',
    array('class' => 'btn btn-info pull-right restore', 'title' => 'Restore', 'style' => 'display:none;')
  );
  ?>
</div>
<!--./modal-footer-->
</form>


<script>
  $(document).ready(function() {
    
     
      // end 
  });
</script>