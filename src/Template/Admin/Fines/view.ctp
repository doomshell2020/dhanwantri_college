
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Fine Manager
    </h1>      
           <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>Fines/index">Manage Fine </a></li>
<li class="active">View Fine</li>
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
          <h3 class="box-title">View Fine</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
        
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Holder Name</label>
            <?php if(isset($fine['holder_name']) && !empty($fine['holder_name'])){ echo ucfirst($fine['holder_name']); }else{ echo 'N/A';} ?>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Holder Type</label>
            <?php if(isset($fine['holder_type_id']) && !empty($fine['holder_type_id'])){ echo ucfirst($fine['holder_type_id']); }else{ echo 'N/A';} ?>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Amount</label>
            <?php if(isset($fine['amount']) && !empty($fine['amount'])){ echo ucfirst($fine['amount']); }else{ echo 'N/A';} ?>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Remarks</label>
            <?php if(isset($fine['remarks']) && !empty($fine['remarks'])){ echo ucfirst($fine['remarks']); }else{ echo 'N/A';} ?>
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
