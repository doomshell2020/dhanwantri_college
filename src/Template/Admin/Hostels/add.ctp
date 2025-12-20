<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	    <section class="content-header">
		      <h1>
			Hostel  Manager
		      </h1>
		               <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>hostels/index">Manage Hostel </a></li>
<li class="active">Create Hostel</li>
	      </ol>        
		      
	    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
       
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
		    <div class="box-header with-border">
		      <h3 class="box-title"><?php if(isset($hostels['id'])){ echo 'Edit Hostel'; }else{ echo 'Add Hostel';} ?></h3>
		    </div>
            <!-- /.box-header -->
            <!-- form start -->

		<?php echo $this->Flash->render(); ?>

 
          
		<?php echo $this->Form->create($hostels, array(
                       
                       'class'=>'form-horizontal',
			'id' => 'sevice_form',
                       'enctype' => 'multipart/form-data'
                     	)); ?>
		   
		      <div class="box-body">
		        <div class="form-group">
					
			 <div class="col-sm-6">
	    	<label>Name<span style="color:red;">*</span></label>
			<?php echo 
			$this->Form->input('name',array('class'=>'form-control','maxlength'=>50,'required','placeholder'=>'Hostel Name','label' =>false)); ?>  
		          </div>
		          			
		     <div class="col-sm-6">
	    	<label>Hostel Type<span style="color:red;">*</span></label>
	    	<?php $optn=array('0' =>'Boys','1' =>'Girls'); ?>
			<?php echo $this->Form->input('type',array('class'=>'form-control','required','empty'=>'Select Type','options'=>$optn,'label' =>false)); ?>  
		          </div>
             </div>
		         <div class="form-group">
						
		     <div class="col-sm-6">
	    	<label>Warden Name</label>
			<?php echo $this->Form->input('wardenname',array('class'=>'form-control','maxlength'=>50,'placeholder'=>'Warden Name','label' =>false)); ?>  
		          </div>

		     <div class="col-sm-6">
				<script>
	
function isNumber(evt) {
evt = (evt) ? evt : window.event;
var charCode = (evt.which) ? evt.which : evt.keyCode;
if (charCode != 46 && charCode != 45 && charCode > 31 && (charCode < 48 || charCode > 57)) {
alert("Please Enter Numeric Value");
return false;
}
return true;
}
</script>	 
	    	<label>Warden Mobile</label>
			<?php echo $this->Form->input('w_mobile',array('class'=>'form-control','maxlength'=>10,'onkeypress'=>'return isNumber(event);','placeholder'=>'Warden Mobile','label' =>false)); ?>  
		          </div>
		        </div>
		    
		        <div class="form-group">
						
		     <div class="col-sm-6">
	    	<label>Fees<span style="color:red;">*</span></label>
	    	<?php echo $this->Form->input('fees',array('class'=>'form-control','required','onkeypress'=>'return isNumber(event);','maxlength'=>6,'type'=>'text','placeholder'=>'Fees','label' =>false)); ?>   
		          </div>
		          
		               <div class="col-sm-6">
	    	<label>Last Submisson Date<span style="color:red;">*</span></label>
	    	<?php echo $this->Form->input('lastdate',array('class'=>'form-control','id'=>'fee_date1','required','type'=>'text','placeholder'=>'Last Submisson Date','label' =>false)); ?>   
	    	<script>

  $(document).ready(function(){
 
   $('#fee_date1').datepicker({ 'minDate':'0',"changeMonth":true, "changeYear":true,"dateFormat":"yy-mm-dd" })
   
   
});    	</script>
		          </div>
			 </div>
			 
  <div class="form-group">				
		     <div class="col-sm-6">			 
 <label for="inputEmail3" class="control-label">Academic Year<span style="color:red;">*</span></label>
    
 <input type="text" class="form-control" name="academicyear" value="<?php echo date("Y") ?>-<?php echo date("y")+1;?>" readonly >
    </div>   
    </div>
		      <!-- /.form group -->
		        
		      </div>
		      <!-- /.box-body -->
		      <div class="box-footer">
			<?php
			echo $this->Html->link('Back', [
			    'action' => 'index'
			   
			],['class'=>'btn btn-default','style'=>'float: left;
']); ?>
		      
			<?php
				if(isset($hostels['id'])){
				echo $this->Form->submit(
				    'Update', 
				    array('class' => 'btn btn-info pull-right', 'style'=>'float: right;','title' => 'Update')
				); }else{ 
				echo $this->Form->submit(
				    'Add', 
				    array('class' => 'btn btn-info pull-right','style'=>'float: right;', 'title' => 'Add')
				);
				}
		       ?>
		       
<div style="clear:both"></div>
		      </div>
		      <!-- /.box-footer -->
		  <?php echo $this->Form->end(); ?>
          </div>
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  
<script>
$(document).ready(function(){
$('#c-id').on('change',function(){
var id = $('#c-id').val();
//alert(id);
 $.ajax({ 
        type: 'POST', 
        url: '<?php echo ADMIN_URL ;?>cities/find_state',
        data: {'id':id}, 
        success: function(data){  
alert(data);
 $('#s-id').empty();
  $('#s-id').html(data);
        }, 
        
    });  
});
});

</script>


