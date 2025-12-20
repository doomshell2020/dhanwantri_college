
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Cup Board Manager
    </h1>  
         <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>CupBoards/index">Manage Cup Board </a></li>
<li class="active"><?php echo ucfirst($cupboard['name']); ?></li>
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
          <h3 class="box-title">View Cup Board</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
            <?php if(isset($cupboard['name'])){ echo ucfirst($cupboard['name']); }else{ echo 'N/A';} ?>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Details</label>
            <?php if(isset($cupboard['details'])){ echo ucfirst($cupboard['details']); }else{ echo 'N/A';} ?>
          </div>

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
