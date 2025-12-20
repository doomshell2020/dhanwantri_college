
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Class Sections Manager
       
      </h1>
      		     <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards/adminbranch"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>classections/index">Manage  Class Sections</a></li>
<li class="active">View Class Section</li>
	      </ol>    
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
       <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
		    <div class="box-header with-border">
		      <h3 class="box-title">View Class Section</h3>
		    </div>
            <!-- /.box-header -->
            <!-- form start -->
                   <div class="box-body">
		       <?php 	foreach($classes as $service){ ?>
   <div class="form-group">
		          <label for="inputEmail3" class="col-sm-4 control-label">Class</label>
			<?php  echo $service['Classes']['title']; ?>
			</div>
			
		   <div class="form-group">
		          <label for="inputEmail3" class="col-sm-4 control-label">Section</label>
				<?php  echo $service['Sections']['title']; ?>
			</div>
			
			
			   <div class="form-group">
		          <label for="inputEmail3" class="col-sm-4 control-label"> Teacher</label>
				<?php  echo ucfirst($service['Employees']['fname'])." ".$service['Employees']['middlename']." ".$service['Employees']['lname']." (".$service['Employees']['id'].")"; ?>
			</div>
			
			<div class="form-group">
		          <label for="inputEmail3" class="col-sm-4 control-label">Strength</label>
				<?php  echo $service['self_strength']; ?>
			</div>
			<div class="form-group">
		          <label for="inputEmail3" class="col-sm-4 control-label">Capacity</label>
		  <?php  echo $service['capacity']; ?>
			</div>
		      <?php } ?>
		      </div>
		      <!-- /.box-body -->
		      <div class="box-footer">
			<?php
			echo $this->Html->link('Back', [
			    'action' => 'index'
			   
			],['class'=>'btn btn-default']); ?>
		      
			
		      </div>
		      <!-- /.box-footer -->
		  
          </div>
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>




