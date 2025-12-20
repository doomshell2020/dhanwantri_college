<?= $this->Html->script('admin/jquery-2.2.3.min.js') ?>
<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title">
      <i class="fa fa-plus-square"></i> <?php if (!empty($Transport['is_transport'])) {
         echo 'View Transport';
         } else {
         echo 'Add Transport';
         } ?>
   </h4>
</div>
<?php echo $this->Form->create($Transport, array(
   'class' => '',
   'id' => 'sevice_form',
   'enctype' => 'multipart/form-data',
   'validate',
   
   )); ?>
<div class="modal-body">
<div class="row">
   <div class="col-sm-12">
      <?php  //pr($res);
         foreach ($transport as $key => $value) {
         
         	$res = $this->Comman->findlocationss($value);
         	$loct[$value] = $res[$value];

         }
         
         $discounttransport = $this->Comman->findpaidtransportamount($ids, $acedemic);
         ?>
      <div class="form-group">
         <div class="col-sm-6">
            <label for="inputEmail3" class="control-label">Location Name<span style="color:red;">*</span></label>
            <input type="hidden" id="" name="user_id" value="<?php echo $ids; ?>">
            <?php if (!empty($Transport['is_transport'])) {
               echo $this->Form->input('transportloc_id', array('class' => 'form-control', 'required', 'empty' => 'Select Location', 'disabled', 'id' => 'l_name' . $Transport['id'], 'options' => $loct, 'label' => false));
               } else {
               
               echo $this->Form->input('transportloc_id', array('class' => 'form-control', 'required', 'empty' => 'Select Location', 'id' => 'l_name' . $Transport['id'], 'options' => $loct, 'label' => false));
               } ?>
         </div>
         <div class="form-group">
            <div class="col-sm-6">
               <label for="inputEmail3" class="control-label">Select Vechical</label>
               <?php if (empty($Transport['is_transport'])) {  ?>
               <select class="form-control " name="v_num" id="v_number<?php echo $Transport['id']; ?>" style="width: 100%;">
                  <option value="">Select Vechical</option>
               </select>
               <?php } else {
                  echo $this->Form->input('v_num', array('class' => 'form-control', 'required', 'placeholder' => 'Vechical No', 'readonly', 'id' => 'v_number' . $Transport['id'], 'label' => false));
                  } ?>
            </div>
         </div>
      </div>
   </div>
</div>
<!--./modal-body-->
<div class="modal-footer">
   <button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
   <?php
      if (!empty($Transport['is_transport'])) {
      } else {
      	echo $this->Form->submit(
      		'Add',
      		array('class' => 'btn btn-info pull-left', 'style' => '', 'title' => 'Add')
      	);
      }
      ?>
</div>
<!--./modal-footer-->
</form>
<script>
   $('#l_name<?php echo $Transport['id']; ?>').on('change', function() {
   	var id = $('#l_name<?php echo $Transport['id']; ?>').val();
   
   	$.ajax({
   		type: 'POST',
   		url: '<?php echo ADMIN_URL; ?>students/find_vechical',
   		data: {
   			'id': id
   		},
   		success: function(data) {
   			//alert(data);
   			$('#v_number<?php echo $Transport['id']; ?>').html(data);
   		},
   
   	});
   });
</script>