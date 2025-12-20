<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Expense Head Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>dashboards/adminbranch"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>Expense/index">Manage Expense</a></li>
    </ol>
  </section>
  <section class="content">
    <div id="load"></div>
    <?php echo $this->Flash->render(); ?>

    <div class="row">
      <div id="load2" style="display:none;"></div>
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <div style="display:flex; justify-content: space-between;align-items:center; margin-bottom: 4px;">
              <h3 class="box-title " style="flex:1;">Expense List </h3>
              <a href="<?php echo SITE_URL; ?>admin/Expense/add" class="btn btn-primary  addpopup fa-fa-plus"
                style="margin-right:10px;" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"
                aria-hidden="true"> <i class="fa fa-plus view-details" ?></i>Add Expense</a>

            </div>
          </div>

          <div class="box-body" id="example23">
            <script>
              $(".globalModalghs").click(function (event) {
                $('.modal-content2').load($(this).attr("href"));
              });
            </script>
            <div>
              <table class="table table-bordered table-striped" style="width:100%;">
                <thead>
                  <tr>
                    <th style="width:03%;">S.No.</th>
                    <th style="width:12%;">Expense Title</th>
                    <th style="width:08%;">Expense Head</th>
                    <th style="width:09%;">Add Date</th>
                    <th style="width:12%;">Action </th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  if (isset($rec) && !empty($rec)) {
                    foreach ($rec as $product) {
                      // pr($product);
                      $expancedetails = $this->Comman->findexpansename($product['exp_category']);
                      // pr($expancedetails);die;
                      ?>
                      <tr>

                        <td><?php echo $counter + 1; ?></td>
                        <td><?php echo $product['title']; ?></td>
                        <td><?php
                        echo $expancedetails['category_name'];

                        ?></td>
                        <td><?php echo date('d-m-Y', strtotime($product['add_date'])); ?></td>
                        <td>
                          <a class="editpopup" href="<?php echo ADMIN_URL; ?>expense/edit/<?php echo $product->id; ?>">
                            <i class="fa fa-pencil-square-o fa-lg" data-toggle="modal" data-target="#exampleModal"
                              data-whatever="@mdo" aria-hidden="true" style="font-size: 21px"></i>
                          </a>
                          <?php if ($product->status == 'Y'): ?>
                            <?= $this->Html->link(
                              '',
                              ['action' => 'status', $product->id, 'N'],
                              ['title' => 'Active',
                                'class' => 'fas fa-check-circle',
                                'style' => 'margin-left: 12px; color: #2f760b !important;'
                              ]
                            ) ?>
                          <?php else: ?>
                            <?= $this->Html->link(
                              '',
                              ['action' => 'status', $product->id, 'Y'],
                              [
                                'title' => 'Inactive',
                                'class' => 'fas fa-times-circle',
                                'style' => 'margin-left: 12px; color: #c10d0d !important;'
                              ]
                            ) ?>
                          <?php endif; ?>

                        </td>
                      </tr>
                      <?php $counter++;
                    }
                  } ?>

                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
</div>
</div>



<div class="modal fade" id="addpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" >
      <!-- <div class="modal-header"> -->
        <!-- <h5 class="modal-title" id="exampleModalLabel" style="color: #302e33;">Expense Entry</h5> -->
          <!-- <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button> -->
      <!-- </div> -->
      <div class="modal-body"></div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <!-- <button type="button" class="btn btn-primary">Send message</button> -->
      </div>
    </div>
  </div>
</div>


<script>
$('.addpopup').click(function(e) {
    e.preventDefault();
    $('#addpopup').modal('show').find('.modal-body').load($(this).attr('href'));
});

$('.editpopup').click(function(e) {
    e.preventDefault();
    $('#editpopup').modal('show').find('.modal-body').load($(this).attr('href'));
});
</script>