<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Cup Board Shelf Manager
    </h1>
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
            <h3 class="box-title">View Shelf</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <div class="box-body">

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
              <?php if (isset($cupboardshelf['name']) && !empty($cupboardshelf['name'])) {
                echo ucfirst($cupboardshelf['name']);
              } else {
                echo 'N/A';
              } ?>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Cupboard</label>
              <?php if (isset($cupboardshelf['cup_board']['name']) && !empty($cupboardshelf['cup_board']['name'])) {
                echo ucfirst($cupboardshelf['cup_board']['name']);
              } else {
                echo 'N/A';
              } ?>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Capacity</label>
              <?php if (isset($cupboardshelf['capacity']) && !empty($cupboardshelf['capacity'])) {
                echo ucfirst($cupboardshelf['capacity']);
              } else {
                echo 'N/A';
              } ?>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Details</label>
              <?php if (isset($cupboardshelf['details']) && !empty($cupboardshelf['details'])) {
                echo ucfirst($cupboardshelf['details']);
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