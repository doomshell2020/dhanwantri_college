 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       Class Timetables Manager
     </h1>

   </section>
   <!-- Main content -->
   <section class="content">
     <div class="row">
       <div class="col-xs-12">

         <div class="box">
           <div class="box-header">
             <h3 class="box-title">Class Timetable List</h3>
             <a href="<?php echo SITE_URL; ?>admin/ClasstimeTabs/add">
               <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
                 Add </button></a>
           </div>
           <!-- /.box-header -->
           <?php echo $this->Flash->render(); ?>
           <div class="box-body">
             <table id="example1" class="table table-bordered table-striped">
               <thead>
                 <tr>
                   <th>S.No.</th>
                   <th>Class</th>
                   <th>Subject</th>
                   <th>Employee</th>
                   <th>Period</th>
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
                       <td>
                        <?php
                        echo $work['class']['title']; ?>
                        </td>
                       <td><?php echo $work['Subjects']['name']; ?></td>
                       <td><?php echo $work['Employees']['fname']; ?> <?php echo $work['Employees']['middlename']; ?> <?php echo $work['Employees']['lname']; ?></br>
                         (<?php echo $work['Employees']['id']; ?>)</td>
                       <td><?php echo  $work['Timetables']['name'] ?></td>



                       <td><?php if ($work['status'] == 1) {
                              echo $this->Html->link('', [
                                'action' => 'status',
                                $work->id,
                                $work['status']
                              ], ['class' => 'fas fa-check-circle', 'style' => 'font-size: 16px !important; margin-left: 12px;    color: #36cb3c;']);
                            } else {
                              echo $this->Html->link('', [
                                'action' => 'status',
                                $work->id,
                                $work['status']
                              ], ['class' => 'fas fa-times-circle', 'style' => 'font-size: 16px !important; margin-left: 12px; color:#cd0404;']);
                            } ?>


                         <?php
                          echo $this->Html->link('', [
                            'action' => 'add',
                            $work->id
                          ], ['class' => 'fas fa-edit', 'style' => 'font-size: 16px !important;']);
                          ?>
                         <?php
                          echo $this->Html->link('', [
                            'action' => 'delete',
                            $work->id
                          ], ['class' => 'fas fa-trash-alt',  'style' => 'font-size: 16px !important; color: #cd0404;', "onClick" => "javascript: return confirm('Are you sure do you want to delete this')"]); ?>
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