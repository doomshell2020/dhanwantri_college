 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       Timetables Manager

     </h1>
     <ol class="breadcrumb">
       <li><a href="<?php echo ADMIN_URL; ?>Timetables/index"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="<?php echo ADMIN_URL; ?>Timetables/index">Manage Timetables</a></li>
     </ol>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <div class="col-xs-12">

         <div class="box">
           <div class="box-header">
             <h3 class="box-title">Timetable List</h3>
           </div>
           <!-- /.box-header -->
           <?php echo $this->Flash->render(); ?>
           <div class="box-body">
             <table id="example1" class="table table-bordered table-striped">
               <thead>
                 <tr>
                   <th>S.No.</th>
                   <th>Name</th>
                   <th>Times From</th>
                   <th>Times To</th>
                   <th>is_break</th>
                   <th>Action</th>
                 </tr>
               </thead>
               <tbody>
                 <?php $page = $this->request->params['paging']['Works']['page'];
                  $limit = $this->request->params['paging']['Works']['perPage'];
                  $counter = ($page * $limit) - $limit + 1;
                  if (isset($timetabledata) && !empty($timetabledata)) {
                    foreach ($timetabledata as $work) {
                  ?>
                     <tr>
                       <td><?php echo $counter; ?></td>
                       <td><?php if (isset($work['name'])) {
                              echo
                              ucfirst($work['name']);
                            } else {
                              echo 'N/A';
                            } ?></td>
                       <td><?php echo $work['time_from']; ?></td>
                       <td><?php echo $work['time_to']; ?></td>
                       <td><?php if ($work['is_break'] == '1') {
                              echo "Yes";
                            } else {
                              echo "No";
                            } ?></td>

                       <td><?php
                            echo $this->Html->link('', [
                              'action' => 'add',
                              $work->id
                            ], ['class' => 'fas fa-edit', 'style' => 'font-size: 16px !important;', 'aria-hidden' => 'true']); ?>

                         <?php
                          echo $this->Html->link('', [
                            'action' => 'view',
                            $work->id
                          ], ['class' => 'fas fa-eye', 'style' => 'font-size: 16px !important;', 'aria-hidden' => 'true']); ?>
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
           <div class="box-footer">
             <?php
              echo $this->Html->link('Back', [
                'controller' => 'ClasstimeTabs',
                'action' => 'view'
              ], ['class' => 'btn btn-default']); ?>


           </div>
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