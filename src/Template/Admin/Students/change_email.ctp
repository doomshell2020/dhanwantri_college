<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title">
      <i class="fa fa-pencil-square-o"></i>Update Email/Login ID/<?php echo $name['fname']; ?>
   </h4>
</div>
<?php echo $this->Form->create($students, array(
   'class'=>'',
   'id' => 'studentss_form',
   'enctype' => 'multipart/form-data',
   'validate'
   )); ?>
<div class="modal-body">
<div class="row">
   <div class="col-sm-12"></div>
   <div class="form-group">
      <div class="col-sm-12">
         <label for="inputEmail3" class="control-label">Email/Login Id<span style="color:red;">*</span></label>
         <?php echo $this->Form->input('username',array('class'=>'form-control','required','placeholder'=>'Email', 'id'=>'changeemail','label' =>false)); ?>
         <span id="dividhere" style="display:none;color:red;">Email Already Exist</span>
      </div>
   </div>
</div>
<!--./modal-body-->
<div class="modal-footer">
   <button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
   <?php
      if(isset($students['id'])){
      echo $this->Form->submit(
          'Update', 
          array('class' => 'btn btn-info pull-left', 'title' => 'Update')
      ); }else{ 
      echo $this->Form->submit(
          'Add', 
          array('class' => 'btn btn-info pull-right','style'=>'margin-right: 10px;', 'title' => 'Add')
      );
      }
           ?>   
</div>
<!--./modal-footer-->
</form>
<script>
   $('#changeemail').on('change',function(){
   var username = $('#changeemail').val();
    $.ajax({ 
           type: 'POST', 
           url: '<?php echo ADMIN_URL ;?>students/find_username',
           data: {'username':username}, 
           success: function(data){ //alert(data);
   		if(data > 0)
   			{
   		        $('#changeemail').val('');
   				$('#dividhere').show();
   			
   			}
   			else
   			{
   $('#dividhere').hide();
   }
           }, 
           
       });  
   });
   
</script>