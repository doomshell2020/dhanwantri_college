 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">

   <section class="content-header">
     <h1>
       Cup Board Shelf Manager
     </h1>
     <ol class="breadcrumb">
       <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="#">Library</a></li>
       <li><a href="#">Cup Board Shelf</a></li>
     </ol>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <div class="col-xs-12">
         <?php echo $this->Flash->render(); ?>
         <div class="box">
           <div class="box-header">
             <h3 class="box-title">Create Shelf</h3>
           </div>
           <!-- /.box-header -->
           <div class="box-body">
             <div class="manag-stu">
               <?php echo $this->Form->create($cupboardshelf, array('class' => 'form-horizontal')); ?>
               <div class="form-group">
                 <div class="col-sm-6">
                   <label>Shelf Name<span>*</span></label>
                   <?php echo $this->Form->input('name', array(
                      'class' => 'form-control', 'placeholder' => 'Shelf name', 'id' => 'title', 'label' => false,
                      'required'
                    )); ?>
                 </div>


                 <div class="col-sm-6">
                   <label>Cupboard<span>*</span></label>
                   <?php
                    echo $this->Form->input(
                      'cup_board_id',
                      array(
                        'class' => 'form-control', 'type' => 'select', 'empty' => 'Select Cupboard',
                        'options' => $cupboards, 'label' => false, 'required'
                      )
                    );
                    ?>
                 </div>
               </div>
               <div class="form-group">

                 <div class="col-sm-6">
                   <label>Details</label>
                   <?php echo $this->Form->textarea('details', array('rows' => '2', 'class' => 'form-control', 'label' => false)); ?>
                 </div>
                 <div class="col-sm-6">
                   <?php
                    if (isset($cupboardshelf[id]) && !empty($cupboardshelf[id])) {
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
               <?php echo $this->Form->end(); ?>
             </div>
           </div>
         </div>
       </div>
     </div>
     <div class="row">
       <div class="col-xs-12">

         <div class="box">
           <div class="box-header">
             <h3 class="box-title">View Cup Board Shelf</h3>
           </div>
           <!-- /.box-header -->

           <div class="box-body">
             <table id="example1" class="table table-bordered table-striped">
               <thead>
                 <tr>
                   <th>#</th>
                   <th>Shelf Name</th>
                   <th>Cupboard</th>

                   <th>Details</th>
                   <!-- <th>Status</th> -->
                   <th>Action</th>
                 </tr>
               </thead>
               <tbody>
                 <?php $page = $this->request->params['paging']['cupboardshelfs']['page'];
                  $limit = $this->request->params['paging']['cupboardshelfs']['perPage'];
                  $counter = ($page * $limit) - $limit + 1;

                  if (isset($cupboardshelfs) && !empty($cupboardshelfs)) {
                    foreach ($cupboardshelfs as $work) {
                      //pr($work);die;
                  ?>
                     <tr>
                       <td><?php echo $counter; ?></td>

                       <td><?php if (isset($work['name'])) {
                              echo ucfirst($work['name']);
                            } else {
                              echo 'N/A';
                            } ?></td>

                       <td><?php if (isset($work['cup_board']['name'])) {
                              echo ucfirst($work['cup_board']['name']);
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
                              echo $this->Html->link('Deactivate', [
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