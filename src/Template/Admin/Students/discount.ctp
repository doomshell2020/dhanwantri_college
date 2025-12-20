<?= $this->Html->script('admin/jquery-2.2.3.min.js') ?>
<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title">
      <i class="fa fa-plus-square"></i> <?php if(!empty($discount['is_discount'])){ echo 'Edit Discount'; }else{ echo 'Add Discount';} ?>
   </h4>
</div>
<?php echo $this->Form->create($discount, array(
   'class'=>'',
   'id' => 'sevice_form',
   'enctype' => 'multipart/form-data',
   'validate',
   
   )); ?>
<div class="modal-body">
<div class="row">
   <div class="col-sm-12">
      <div class="form-group">
         <?php $discountsd=$this->Comman->finddisountstudent($ids,$acedemic); 
            $discounthostal=$this->Comman->finddisounthostal($ids,$acedemic,$h_id); 
            $discounttransport=$this->Comman->findpaidtransportamount($ids,$acedemic); 
            
                      
            			  
                        	?>
         <input type="hidden" id="" name="id" value="<?php echo $ids; ?>">
         <label class="col-sm-6">Select Discount Scheme<span style="color:red;">*</span></label>
         <div class="col-sm-6">
            <select name="discountcategory"  id="chk">
               <option value="">-No Discount-</option>
               <?php foreach($discountCategorylist as $ky=>$item){ ?>
               <option value="<?php echo $item['name']; ?>" <? if($discountcategory==$item['name']){ echo "selected"; } ?>><?php echo $item['name']; ?></option>
               <? } ?>
            </select>
         </div>
      </div>
   </div>
   <a title="Update Discount" href="javascript:void(0);" class="globaldiscountdssss btn btn-info pull-right">Send OTP For Update</a>
</div>
<!--./modal-body-->
<script>
   $(document).ready(function() {
     //prepare the dialog
   
     //respond to click event on anything with 'overlay' class
   $(".globaldiscountdssss").click(function(event){
   
    
   var stuid="<?php echo $ids; ?>";
   
         $.ajax({
         async:false,
         type: 'POST', 
   
         url: '<?php echo ADMIN_URL;?>students/genrateotp',
   
         data: {'student_id':stuid},
   
         success: function(data){
          
           $(".updateotp").show();
           $(".globaldiscountdssss").hide(); 
           timer(120);
         }
   
       });  
     
   
       });
   }); 
   
   let timerOn = true;
   
   function timer(remaining) {
   var m = Math.floor(remaining / 60);
   var s = remaining % 60;
   
   m = m < 10 ? '0' + m : m;
   s = s < 10 ? '0' + s : s;
   $('.timer').html(m + ':' + s);
   remaining -= 1;
   
   if(remaining >= 0 && timerOn) {
     setTimeout(function() {
         timer(remaining);
     }, 1000);
     return;
   }
   
   if(!timerOn) {
     // Do validate stuff here
     return;
   }
   
   // Do timeout stuff here
   alert('Timeout for OTP, Kindly Resend OTP to Coordinator !');
   $(".globaldiscountdssss").show(); 
   $(".updateotp").hide(); 
   }
   
   
</script>
<div class="modal-footer updateotp" style="display:none;">
   <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label"></label>
      <div class="col-sm-5">
         <input class="form-control" type="text" maxlength="4" name="otp"  placeholder="Enter OTP For Update Discount" required> 
      </div>
      <div class="col-sm-3" style="color:red;font-size:bold;">Time left = <span class="timer"></span></div>
   </div>
</div>
<div class="modal-footer updateotp" style="display:none;">
   <button data-dismiss="modal" class="btn btn-default pull-left" type="button">Close</button>
   <?php
      if(!empty($discount['is_discount'])){
      echo $this->Form->submit(
          'Update', 
          array('class' => 'btn btn-info pull-right','style'=>'', 'title' => 'Update')
      ); }else{ 
      echo $this->Form->submit(
          'Add', 
          array('class' => 'btn btn-info pull-right','style'=>'', 'title' => 'Add')
      );
      }
           ?>   
</div>
<!--./modal-footer-->
</form>
<?php if(!empty($discount['is_discount'])){ ?>
<script>
   $('#chk').prop('checked', true);	
   	
   	
   	
</script>
<?php } ?>