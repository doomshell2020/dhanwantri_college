 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       Transport Fee Manager
     </h1>

     <ol class="breadcrumb">
       <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="<?php echo ADMIN_URL; ?>transportfees/index">Manage Transport Fee</a></li>
     </ol>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <div class="col-xs-12">

         <div class="box">
           <div class="box-header">
             <h3 class="box-title">Transport Fee List</h3>
             <a href="<?php echo SITE_URL; ?>admin/transportfees/add">
               <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
                 Add </button></a>
           </div>
           <!-- /.box-header -->
           <?php echo $this->Flash->render(); ?>
           <div class="box-body">

             <table id="example1" class="table table-bordered table-striped">
               <thead>
                 <tr>
                   <th>S.No</th>
                   <th>Location</th>
                   <th>Acedamic Year</th>
                   <th>Quater(I)</th>
                   <th>Quater(II)</th>
                   <th>Quater(III)</th>
                   <th>Quater(IV)</th>
                   <!-- <th>Status</th> -->
                   <!-- <th>Action</th> -->
                 </tr>
               </thead>
               <tbody>
                 <?php $page = $this->request->params['paging']['Classfee']['page'];
                  $limit = $this->request->params['paging']['Classfee']['perPage'];
                  $counter = ($page * $limit) - $limit + 1;

                  if (isset($transportfeess) && !empty($transportfeess)) {
                    foreach ($transportfeess as $classfee) {
                  ?>
                     <tr>
                       <td><?php echo $counter; ?></td>
                       <td><a class='label label-success'><?php echo $classfee['location']['name']; ?></a></td>
                       <td><?php echo $classfee['academic_year']; ?></td>

                       <td><span class="text-black">&#8377; </span><?php echo $classfee['quarter1']; ?></br><?php echo date('Y-m-d', strtotime($classfee['fee_sub_q1'])); ?></td>

                       <td><span class="text-black">&#8377; </span><?php echo $classfee['quarter2']; ?></br><?php echo date('Y-m-d', strtotime($classfee['fee_sub_q2'])); ?></td>

                       <td><span class="text-black">&#8377; </span><?php echo $classfee['quarter3']; ?></br><?php echo date('Y-m-d', strtotime($classfee['fee_sub_q3'])); ?></td>

                       <td><span class="text-black">&#8377; </span><?php echo $classfee['quarter4']; ?></br><?php echo date('Y-m-d', strtotime($classfee['fee_sub_q4'])); ?></td>


                       <!-- <td><?php /*if ($classfee['status'] == 'Y') {
                              //echo $this->Html->link('Activate', [
                                'action' => 'status',
                                $classfee['id'],
                                $classfee['status'],
                              ], ['class' => 'label label-success']);
                            } else {
                              echo $this->Html->link('Deactivate', [
                                'action' => 'status',
                                $classfee['id'],
                                $classfee['status'],
                              ], ['class' => 'label label-primary']);
                            } */ ?>
                       </td> -->
                       <?php /*<td>
                       echo $this->Html->link('Edit', [
                              'action' => 'add',
                              $classfee['id']
                            ], ['class' => 'btn btn-primary']); ?>
                         
			             echo $this->Html->link('View', [
			            'action' => 'view',
			             $service->id
			            ],['class'=>'btn btn-success']); */ ?>
                       <?php /*
                          echo $this->Html->link('Delete', [
                            'action' => 'delete',
                            $classfee['id'],
                          ], ['class' => 'btn btn-danger', "onClick" => "javascript: return confirm('Are you sure do you want to delete this')"]); </td>*/ ?>
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