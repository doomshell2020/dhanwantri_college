<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Book Category Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>BookCategories/index">Manage Book Category</a></li>
      <li class="active"><?php echo ucfirst($bookcategory['name']); ?></li>
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
            <h3 class="box-title">View Book Category</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <div class="box-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Book Category</label>
              <?php if (isset($bookcategory['name'])) {
                echo ucfirst($bookcategory['name']);
              } else {
                echo 'N/A';
              } ?>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <?php
            echo $this->Html->link('Back', [
              'action' => 'index'
            ], ['class' => 'btn btn-default']); ?>
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