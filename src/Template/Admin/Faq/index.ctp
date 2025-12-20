<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Faq Manager

    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header with-border">

            <a href="<?php echo ADMIN_URL; ?>Faq/add" class="btn btn-success pull-right">Add Faq</a>

          </div>


          <!-- /.box-header -->
          <div class="row">
            <?php echo $this->Flash->render(); ?>
            <div class="col-xs-12">
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <td>Sr.No.</td>
                      <th>Tittle</th>
                      <th>Discription</th>
                      <th>Category Name</th>
                      <th>Image</th>
                      <th>Action</th>



                    </tr>
                  </thead>
                  <?php $i = 1 ?>
                  <?php foreach ($result as $service) { ?>

                    <tbody>

                      <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?php echo  $service['faq_question']; ?></td>
                        <td><?php echo  $service['faq_answer']; ?></td>
                        <td> <?php if (isset($service['faq_category']['category_name'])) {
                                echo ($service['faq_category']['category_name']);
                              } else {
                                echo 'N/A';
                              } ?></td>
 
                        <td>
                          <?php if($service['image']){ ?>
                        <img src="<?php echo SITE_URL; ?>/faq_images/<?php echo $service['image'] ?>" height="50px"
                       width="50px">
                      <?php }else{?>
                        <img src="<?php echo SITE_URL; ?>/noimage/noimage.png" height="50px"
                       width="50px">
                       <?php }?>
                      </td>

                        <td> <?php
                              echo $this->Html->link('Edit', [
                                'action' => 'edit',
                                $service->id
                              ], ['class' => 'btn btn-primary']);
                              ?>

                          <?php
                          echo $this->Html->link('Delete', [
                            'action' => 'delete',
                            $service->id
                          ], ['class' => 'btn btn-primary', "onClick" => "javascript: return confirm('Are you sure do you want to delete this Faq')"]); ?>
                          <?php if ($service['status'] == 'Y') {
                            echo $this->Html->link('Activate', [
                              'action' => 'status',
                              $service->id,
                              $service['status']
                            ], ['class' => 'label label-success']);
                          } else {
                            echo $this->Html->link('Deactivate', [
                              'action' => 'status',
                              $service->id,
                              $service['status']
                            ], ['class' => 'label label-primary']);
                          } ?>

                        </td>


                      </tr>

                    </tbody>
                  <?php } ?>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>




          <div class="row">
            <?php echo $this->Flash->render(); ?>
            <div class="col-xs-12">
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">

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