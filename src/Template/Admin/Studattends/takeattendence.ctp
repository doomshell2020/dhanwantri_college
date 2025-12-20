<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	    <section class="content-header">
		      <h1>
		 Take Student Attendance <?php echo date('d-m-Y'); ?>
		      </h1>
		       <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>Studattends/attendence">Manage Student Attendance</a></li>
	      </ol>    
	    </section>

    <!-- Main content -->
    <section class="content">
		
		
	
		
      <div class="row">
		  <?php echo $this->Flash->render(); ?>
       
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
		    <div class="box-header with-border">
		    
		      <span class="text-muted" style="padding-left: 10px; font-size: 15px;">
		
					 <strong>Acedmicyear : </strong><?php echo $acedmic; ?>  | <strong>Attendance Date : </strong><?php echo date('d-m-Y'); ?> 	</span>

		    </div>
     

		<?php echo $this->Flash->render();   ?>
		
	
		
	
		      <div class="box-body">


		  
		   
	<div class="row">
		<?php if(isset($output['classes'])){ foreach($output['classes'] as $key=>$item){ ?>
				<div class="col-lg-6">
		
	  		<table class="table table-striped table-hover" id="mytable" >
				
					<tbody>
					
						
						<tr><thead>
						
						<th  class="">Class Name :</th>
						<th  class="" style="font-weight: normal;"><?php echo $item['className']; ?></th>
					
						</thead>
					</tr>
					
						<tr><thead>
						
						<th>Section Name :</th>
						<th style="font-weight: normal;"><?php echo $item['sectionName']; ?></th>
					
						</thead>
					</tr>
					
					<tr><thead>
						
						<th>Teacher Role :</th>
						<th style="font-weight: normal;"><?php echo $item['role']; ?></th>
					
						</thead>
					</tr>
					
					<tr><thead>
						
						<th>Total Students :</th>
						<th style="font-weight: normal;"><?php echo $item['totalstudent']; ?></th>
					
						</thead>
					</tr>
					<tr><thead>
						
						<th>Presents Students :</th>
						<th style="font-weight: normal;"><?php echo $item['present']; ?></th>
					
						</thead>
					</tr>
						<tr><thead>
						
						<th>Absent Students :</th>
						<th style="font-weight: normal;"><?php echo $item['absent']; ?></th>
					
						</thead>
					</tr>
					<tr><thead>
						
						<th colspan="4" class="text-center">
		<?php if($output['canTakeAttendance']==1){ ?>
		<a href="<?php echo ADMIN_URL; ?>studattends/attendence/<?php echo $item['classId']; ?>/<?php echo $item['sectionId']; ?>/<?php echo $acedmic; ?>" class="btn btn-info pull-right" >Take Attendance</a>
					 <?php }else{ ?>		<a href="<?php echo ADMIN_URL; ?>studattends/totalabsent/<?php echo $item['classId']; ?>/<?php echo $item['sectionId']; ?>/<?php echo $acedmic; ?>" class="btn btn-info pull-right" >Total Absent</a>    <?php } ?>
						</th>
						
					
						</thead>
					</tr>
					
												</tbody></table></div>  
												
												 <?php } } ?><div class="col-lg-12">
															<?php 
														$role= $this->request->session()->read('Auth.User.role_id'); if($role=='3'){  	 
			echo $this->Html->link('Back To Timetable', [
			  'controller'=>'classtime_tabs', 'action' => 'teachertimetable'
			   
			],['class'=>'btn btn-default']); }else{ 
				echo $this->Html->link('Back To Timetable', [
			  'controller'=>'classtime_tabs', 'action' => 'view/'.$seletedclassid.'/'.$seletedsectionid
			   
			],['class'=>'btn btn-default']);
				
				
				
				
				} ?>
				</div>
			</div>
			<div class="box-footer">
							
		
		       
		      </div>
		      <!-- /.box-footer -->
	
		      </div>
		      <!-- /.box-body -->
		     
		
		      
		
        
         
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


