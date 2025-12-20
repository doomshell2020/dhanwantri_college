<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      View Cup Board
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>CupBoards/index">View Cup Board </a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <?php echo $this->Flash->render(); ?>
            <h3 class="box-title">Create Cup Board</h3>
          </div>
          <!-- /.box-header -->
          <?php echo $this->Form->create($cupboard, array('class' => 'form-horizontal')); ?>
          <div class="box-body">
            <div class="form-group">
              <div class="col-sm-6">

                <label class="control-label">Name<span>*</span></label>
                <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Cup Board Name', 'id' => 'title', 'label' => false, 'required', 'maxlength' => '100')); ?>

              </div>


              <div class="col-sm-6">
                <label class="control-label">Details</label>
                <?php echo $this->Form->textarea('details', array('rows' => '2', 'class' => 'form-control', 'label' => false)); ?>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">

                <?php
                if (isset($cupboard['id']) && !empty($cupboard['id'])) {
                  echo '<button type="submit" name="button" value="update" class="btn btn-success">Update</button> ';
                  echo $this->Html->link(
                    'Cancel',
                    ['action' => 'index'],
                    ['class' => 'btn btn-primary']
                  );
                } else {
                  echo '<button type="submit" class="btn btn-success">Create</button> ';
                  echo '<button type="reset" class="btn btn-primary">Reset</button>';
                }
                ?>

              </div>
            </div>
          </div>
          <?php echo $this->Form->end(); ?>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">View Cup Board</h3>
          </div>
          <!-- /.box-header -->

          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Name</th>
                  <th>Details</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $page = $this->request->params['paging']['cupboards']['page'];
                $limit = $this->request->params['paging']['cupboards']['perPage'];
                $counter = ($page * $limit) - $limit + 1;

                if (isset($cupboards) && !empty($cupboards)) {
                  foreach ($cupboards as $work) {
                    ?>
                    <tr>
                      <td><?php echo $counter; ?></td>
                      <td><?php if (isset($work['name'])) {
                        echo ucfirst($work['name']);
                      } else {
                        echo 'N/A';
                      } ?></td>

                      <td><?php if (isset($work['details'])) {
                        echo ucfirst($work['details']);
                      } else {
                        echo 'N/A';
                      } ?></td>

                      <td><?php if ($work['status'] == 'Y') {
                        echo $this->Html->link('', [
                          'action' => 'status',
                          $work->id,
                          $work['status']
                        ], ['class' => 'fas fa-check-circle', 'style' => 'font-size: 16px !important; margin-left: 12px;     color: #36cb3c;']);
                      } else {
                        echo $this->Html->link('', [
                          'action' => 'status',
                          $work->id,
                          $work['status']
                        ], ['class' => 'fas fa-times-circle', 'style' => 'font-size: 16px !important; margin-left: 12px; color:#cd0404;']);
                      } ?>&nbsp;
                        <?php
                        echo $this->Html->link('', [
                          'action' => 'index',
                          $work->id
                        ], ['class' => 'fas fa-edit', 'style' => "font-size: 16px !important;"]); ?>

                        <?php
                        echo $this->Html->link('', [
                          'action' => 'delete',
                          $work->id
                        ], ['class' => 'fa fa-trash', 'style' => "font-size: 16px !important;color:red;", "onClick" => "javascript: return confirm('Are you sure you want to delete this?')"]); ?>
                      </td>

                    </tr>
                    <?php $counter++;
                  }
                } else { ?>
                  <tr>
                    <td>NO Data Available</td>
                  </tr>
                <?php } ?>
              </tbody>

            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>

<!-- /.content-wrapper -->