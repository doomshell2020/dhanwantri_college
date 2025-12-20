 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       Student List
     </h1>

     <ol class="breadcrumb">
       <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="<?php echo ADMIN_URL; ?>transportfees/index">Manage Student Fee</a></li>
     </ol>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <div class="col-xs-12">

         <div class="box">
           <div class="box-header">
             <h3 class="box-title">Transport Fee List</h3>
             <!-- <a href="<?php //echo SITE_URL; ?>admin/transportfees/add_student">
               <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
                 Add Student </button></a> -->
                 <a href="<?php echo SITE_URL; ?>admin/transportfees/exportexcel">
               <button class="btn btn-success pull-right m-top10"><i class="fa fa-file-excel-o" aria-hidden="true"></i>
                 Export Excel </button></a>
           </div>
           <!-- /.box-header -->
           <?php echo $this->Flash->render(); ?>
           <div class="box-body">

             <table id="example1" class="table table-bordered table-striped">
               <thead>
                 <tr>
                   <th width="6%">#</th>
                   <th>Name</th>
                   <th>Location</th>
                   <th>Bus</th>
                   <th>Class</th>
                   <th>Section</th>
                   <th>Quater1</th>
                   <th>Quater2</th>
                   <th>Quater3</th>
                   <th>Quater4</th>
                   <!-- <th>Fees</th> -->
                   <th>Academic Year</th>
                   <!-- <th>Status</th> -->
                   <th>Action</th>
                 </tr>
               </thead>
               <tbody>
                 <?php $page = $this->request->params['paging']['id']['page'];
                  $limit = $this->request->params['paging']['id']['perPage'];
                  $counter = ($page * $limit) - $limit + 1;

                  if (isset($alldata) && !empty($alldata)) {
                    foreach ($alldata as $student_data) {

                      $findsubquater = $this->Comman->findtransportfees($student_data['location_id'],$student_data['acadamic_year']);
                  ?>
                     <tr>
                       <td><?php echo $counter; ?></td>
                       <td><?php echo ucwords($student_data['student']['fname'].' '.$student_data['student']['middlename'].' '.$student_data['student']['lname']); ?></td>
                       <td><?php echo  ucwords($student_data['location']['name']); ?></td>
                       <td><?php echo $student_data['bus_number']; ?></td>
                       <td><?php echo $student_data['student']['class']['title'] ?></td>
                       <td><?php echo $student_data['student']['section']['title'] ?></td>
                       <td>
                       <span class="text-black">&#8377; </span><?php echo $student_data['qu1_fees']; ?></br><?php echo date('Y-m-d', strtotime($findsubquater['fee_sub_q1'])); ?>
                       </td>

                       <td>
                       <span class="text-black">&#8377; </span><?php echo $student_data['qu2_fees']; ?></br><?php echo date('Y-m-d', strtotime($findsubquater['fee_sub_q2'])); ?>
                       </td>

                       <td>
                       <span class="text-black">&#8377; </span><?php echo $student_data['qu3_fees']; ?></br><?php echo date('Y-m-d', strtotime($findsubquater['fee_sub_q3'])); ?>
                       </td>

                       <td>
                       <span class="text-black">&#8377; </span><?php echo $student_data['qu4_fees']; ?></br><?php echo date('Y-m-d', strtotime($findsubquater['fee_sub_q4'])); ?>
                       </td>

                       <td>
                       <?php echo $student_data['acadamic_year']; ?>
                       </td>

                       <!-- <td> -->
                       <?php //if ($student_data['status'] == 'Y') {
                            //   echo $this->Html->link('Activate', [
                            //     'action' => 'ststatus',
                            //     $student_data['id'],
                            //     $student_data['status'],
                            //   ], ['class' => 'label label-success']);
                            // } else {
                            //   echo $this->Html->link('Deactivate', [
                            //     'action' => 'ststatus',
                            //     $student_data['id'],
                            //     $student_data['status'],
                            //   ], ['class' => 'label label-primary']);
                            // }
                        ?>
                       <!-- </td> -->

                       <td><?php
                           echo $this->Html->link('Edit', [
                              'action' => 'add_student',
                              $student_data['id']
                            ], ['class' => 'btn btn-primary']); ?>
                         <?php /*
                        echo $this->Html->link('View', [
                            'action' => 'view',
                            $service->id
                        ],['class'=>'btn btn-success']); */ ?>
                         <?php
                          echo $this->Html->link('Delete', [
                            'action' => 'deletest',
                            $student_data['id'],
                          ], ['class' => 'btn btn-danger', "onClick" => "javascript: return confirm('Are you sure do you want to delete this')"]); ?>
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

 <script>
   $(document).ready(function() {
     $('.sort').on('change', function() {
       var sort = $(this).val();
       var id = $(this).attr('data-val');
       $.ajax({
         type: 'POST',
         url: '<?php echo $this->Url->build('/admin/services/sort'); ?>',
         data: {
           'id': id,
           'sort': sort
         },
         success: function(data) {
           $('#sort').val(data);
         },

       });
     });
   });
 </script>
 <!-- /.content-wrapper -->