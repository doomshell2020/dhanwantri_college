<?= $this->Html->script('admin/jquery-2.2.3.min.js') ?>
<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title">
      <i class="fa fa-plus-square"></i> <?php if(!empty($students['is_hostel'])){ echo 'View Hostel'; }else{ echo 'Add Hostel';} ?>
   </h4>
</div>
<?php //pr($students) ?>
<?php echo $this->Form->create($students, array(
   'class'=>'',
   'id' => 'sevice_form',
   'enctype' => 'multipart/form-data',
   'validate',
   
   )); ?>
<div class="modal-body">
<div class="row">
   <div class="col-sm-12">
      <div class="form-group">
         <div class="col-sm-6">
            <label for="inputEmail3" class="control-label">Hostel Name<span style="color:red;">*</span></label>
            <input type="hidden" id="" name="user_id" value="<?php echo $ids; ?>">
            <?php if(!empty($students['is_hostel'])){ echo $this->Form->input('h_id',array('class'=>'form-control h-id','required','empty'=>'Select Hostel','id'=>'f_room'.$ids,'options'=>$hostel,'disabled','label' =>false)); }else{ echo $this->Form->input('h_id',array('class'=>'form-control h-id','required','empty'=>'Select Hostel','id'=>'f_room'.$ids,'options'=>$hostel,'label' =>false));  } ?>
         </div>
         <div class="form-group">
            <div class="col-sm-6">
               <label for="inputEmail3" class="control-label">Room No<span style="color:red;">*</span></label>
               <?php if(!empty($students['is_hostel'])){ ?> 
               <select name="room_no" class="form-control" id="rom<?php echo $ids; ?>" disabled="disabled">
                  <option value="">Select Room No.</option>
                  <?php 
                     if($students['is_hostel']!="")
                     {
                     $students['is_hostel'];
                     $hos_id=$students['h_id'];
                        $hostelroms=$this->Comman->findrooms($hos_id);
                      
                        $hostelrom=$hostelroms['room_no'];
                        for($i=1; $i<=$hostelrom; $i++)
                     { ?>
                  <option value="<?php echo $i ?>" <?php if($i==$students['room_no']){ echo "selected";  } ?> ><?php echo $i ; ?></option>
                  <?php 
                     }
                      
                     }
                     	?>
               </select>
               <?php }else{ ?>
               <select name="room_no" class="form-control" id="rom<?php echo $ids; ?>">
                  <option value="">Select Room No.</option>
                  <?php 
                     if($students['is_hostel']!="")
                     {
                     $students['is_hostel'];
                     $hos_id=$students['h_id'];
                        $hostelroms=$this->Comman->findrooms($hos_id);
                      
                        $hostelrom=$hostelroms['room_no'];
                        for($i=1; $i<=$hostelrom; $i++)
                     { ?>
                  <option value="<?php echo $i ?>" <?php if($i==$students['room_no']){ echo "selected";  } ?> ><?php echo $i ; ?></option>
                  <?php 
                     }
                      
                     }
                     	?>
               </select>
               <?php } ?>
            </div>
            <span id="notice" style="color:red;margin-left: 302px;"></span>
         </div>
      </div>
   </div>
</div>
<!--./modal-body-->
<div class="modal-footer">
   <button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
   <?php 
      if(!empty($students['is_hostel'])){
      
       }else{ 
      echo $this->Form->submit(
          'Add', 
          array('class' => 'btn btn-info pull-left','style'=>'', 'title' => 'Add')
      );
      }
           ?>   
</div>
<!--./modal-footer-->
</form>
<?php if(empty($students['is_hostel'])){  ?>
<script>
   $('#rom<?php echo $ids; ?>').on('change',function(){
   var id = $('#f_room<?php echo $ids; ?>').val();
   var ids = $('#rom<?php echo $ids; ?>').val();
   
    $.ajax({ 
           type: 'POST', 
           url: '<?php echo ADMIN_URL ;?>students/find_rooms',
           data: {'id':id,'ids':ids}, 
           success: function(data){  
   
   	if(data=='1')
   	{
        $('#notice').html("Selected Room is Booked");
        $('#notice').show(); 
         $('.h-id').prop('selectedIndex',0);
        $('#rom<?php echo $ids; ?>').val('');
        }
        else
        {
         $('#notice').hide(); 
   	 }    
           }, 
           
       });  
   });
</script>
<?php } ?>
<?php $hos=implode(" ",$hostel);
   if(!empty($hos)){  ?>
<script>      
   $('#f_room<?php echo $ids; ?>').on('change',function(){
   var hostel = $('#f_room<?php echo $ids; ?>').val();
   
    $.ajax({ 
           type: 'POST', 
           url: '<?php echo ADMIN_URL ;?>students/find_roomslength',
           data: {'hostel':hostel}, 
           success: function(data){  
   
   			  $('#rom<?php echo $ids; ?>').html(data);
           }, 
           
       });  
   });
</script>
<?php } ?>