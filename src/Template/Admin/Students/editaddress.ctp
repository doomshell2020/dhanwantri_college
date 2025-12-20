<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title" style="
      margin-top: -2px !important;
      margin-bottom: -7px !important;
      ">
      <i class="fa fa-plus-square"></i> Edit Address 
   </h4>
</div>
<script>
   var ckbox = $('#checkboxsd');
   
   $(ckbox).on('click',function () {
       if (ckbox.is(':checked')) {
          
           var caddress= $('#c-address').val();
             $('#p-address').val(caddress);
                   var caddress= $('#c-c-id').val();
             $('#p-c-id').val(caddress);
             
                 var caddress= $('#c-s-id').val();
             $('#p-s-id').val(caddress);
                 var caddress= $('#c-city-id').val();
             $('#p-city-id').val(caddress);
             var caddress= $('#c-pincode').val();
             $('#p-pincode').val(caddress);
             
       } else {
   
             $('#p-address').val('');
                  
             $('#p-c-id').val('');
             
               
             $('#p-s-id').val('');
          
             $('#p-city-id').val('');
            
             $('#p-pincode').val('');
       }
   });
   
</script>
<script>
   $('#c-c-id').on('change',function(){
   
   var id = $('#c-c-id').val();
   
    $.ajax({ 
           type: 'POST', 
           url: '<?php echo SITE_URL ;?>admin/cities/find_state',
           data: {'id':id}, 
           success: function(data){  
   
    $('#c-s-id').empty();
    $('#c-city-id').empty();
   
     $('#c-s-id').html(data);
           }, 
           
       });  
   });
   
   $('#c-s-id').on('change',function(){
   	//alert();
   var id = $('#c-s-id').val();
   
    $.ajax({ 
           type: 'POST', 
           url: '<?php echo SITE_URL ;?>admin/cities/find_cities',
           data: {'id':id}, 
           success: function(data){  
   //alert(data);
    $('#c-city-id').empty();
     $('#c-city-id').html(data);
           }, 
           
       });  
   });
   
   $('#p-c-id').on('change',function(){
   var id = $('#p-c-id').val();
    $.ajax({ 
           type: 'POST', 
           url: '<?php echo SITE_URL ;?>admin/cities/find_state',
           data: {'id':id}, 
           success: function(data){  
    $('#p-s-id').empty();
    $('#p_city_id').empty();
     $('#p-s-id').html(data);
           }, 
           
       });  
       
       
       
       
   });
   
   $('#p-s-id').on('change',function(){
   	//alert();
   var id = $('#p-s-id').val();
   
    $.ajax({ 
           type: 'POST', 
           url: '<?php echo SITE_URL ;?>admin/cities/find_cities',
           data: {'id':id}, 
           success: function(data){  
   //alert(data);
    $('#p-city-id').empty();
     $('#p-city-id').html(data);
     
           }, 
           
       });  
       
      
   });
   
   
</script>
<?php echo $this->Form->create($students, array(
   'class'=>'',
   'id' => 'sevice_form',
   'enctype' => 'multipart/form-data',
   'validate'
   )); ?>
<div class="modal-body" style="max-height:600px">
   <?php echo $this->Flash->render(); ?>
   <div class="row">
      <div class="col-sm-12">
         <h5>
            Address	
         </h5>
         <div class="form-group field-empaddress-emp_cadd">
            <label class="control-label" for="empaddress-emp_cadd">Address</label>
            <?php echo $this->Form->input('address',array('class'=>'form-control','type'=>'textarea','required'=>'required','label' =>false,'placeholder'=>'Enter Address')); ?>  
            <input type="hidden" name="id" value="<?php echo $sid; ?>">
         </div>
      </div>
   </div>
</div>
<!--./modal-body-->
<div class="modal-footer">
   <button type="submit" class="btn btn-info pull-left"><i class="fa fa-upload"></i> Update</button>	<button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
</div>
<!--./modal-footer-->
</form>