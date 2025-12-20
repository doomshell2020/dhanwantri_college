<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	    <section class="content-header">
		      <h1>
			Hostel  Manager
		      </h1>
		            		               <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>hostelrooms/index">Manage Hostel Room</a></li>
<li class="active">Create Room</li>
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
		      <h3 class="box-title"><?php if(isset($hostelrooms['id'])){ echo 'Edit Hostel Rooms'; }else{ echo 'Add hostelRooms';} ?></h3>
		    </div>
            <!-- /.box-header -->
            <!-- form start -->

		<?php echo $this->Flash->render(); ?>

 
          
		<?php echo $this->Form->create($hostelrooms, array(
                       
                       'class'=>'form-horizontal',
			'id' => 'sevice_form',
                       'enctype' => 'multipart/form-data'
                     	)); ?>
		   
		      <div class="box-body">
		       
		        <div class="form-group">
			   <div class="col-sm-6">
	    	<label>Select Hostel<span style="color:red;">*</span></label>
			<?php echo $this->Form->input('h_id',array('class'=>'form-control','required','id'=>'h_type','empty'=>'Select Hostel','options'=>$h_name,'label' =>false)); ?>  
		     <input type="hidden" id="h_types">     
		          </div>
		          
		              <div class="col-sm-6">
	    	<label>Hostel Type<span style="color:red;">*</span></label>
	<?php echo $this->Form->input('type',array('class'=>'form-control','required','maxlength'=>10,'id'=>'h_typ','placeholder'=>'Hostel Type','readonly','label' =>false)); ?>  
		          </div>
		   		</div>
		   		
 <div class="form-group">   		
	<div class="col-sm-6">
<label for="inputEmail3" class="control-label" > No Of floor</label>
 <select class="form-control" name="floor_no" >
 <?php for($i=1;$i<=10;$i++) { ?>
    <option value="<?php echo $i; ?>"  <?php if($i==$hostelrooms['floor_no']){ echo "selected";  } ?>     ><?php echo $i ; ?></option>
    <?php } ?>
    <option value="10+">10+</option>
    </select>
		        </div>

		  <div class="col-sm-6">
	   <label for="inputEmail3" class="control-label" >Select No Of Rooms</label>
 <select class="form-control" name="room_no" >
 <?php for($i=1;$i<=50;$i++) { ?>
    <option value="<?php echo $i; ?>" <?php if($i==$hostelrooms['room_no']){ echo "selected";  } ?>  ><?php echo $i ; ?></option>
    <?php } ?>
   
    
    <option value="50+"  <?php if($hostelrooms['room_no']=="50+"){ echo "selected";  } ?>>50+</option>
    </select>
		        </div>
		        </div>
		        
		     <div class="form-group">
		     <div class="col-sm-6">
	    	<label>Capacity</label>
			<?php echo $this->Form->input('capacity',array('class'=>'form-control','required','maxlength'=>10,'placeholder'=>'Capacity','label' =>false)); ?>  
		          </div>
		  
		     <div class="col-sm-6">
	    	<label>EPBX</label>
	    	<?php echo $this->Form->input('epax',array('class'=>'form-control','maxlength'=>7,'placeholder'=>'EPBX','label' =>false)); ?>   
		          </div>
			 </div>
		      <!-- /.form group -->
		        
		      </div>
		      <!-- /.box-body -->
		      <div class="box-footer">
			<?php
			echo $this->Html->link('Back', [
			    'action' => 'index'
			   
			],['class'=>'btn btn-default','style'=>'float: left;']); ?>
		      
			<?php
				if(isset($hostelrooms['id'])){
				echo $this->Form->submit(
				    'Update', 
				    array('class' => 'btn btn-info pull-right','style'=>'float: right;', 'title' => 'Update')
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
$('#h_type').on('change',function(){
var id = $('#h_type').val();
//alert(id);
 $.ajax({ 
        type: 'POST', 
        url: '<?php echo ADMIN_URL ;?>hostelrooms/find_type',
        data: {'id':id}, 
        success: function(data){  
//alert(data);
  $('#h_typ').val(data);
        }, 
        
    });  
});
});

</script>


