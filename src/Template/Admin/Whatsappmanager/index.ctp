 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <section class="content-header">
         <h1>
             Manage Whatsapp Activation

         </h1>
         <ol class="breadcrumb">
             <li><a href="<?php echo ADMIN_URL; ?>Whatsappmanager/index"><i class="fa fa-home"></i>Home</a></li>
             <li><a href="<?php echo SITE_URL; ?>admin/Whatsappmanager">Manage Whatsapp Activation</a></li>
         </ol>
     </section>

     <!-- Main content -->
     <section class="content">
         <div class="row">
             <div class="col-xs-12">

                 <div class="box">
                     <div class="box-header">
                         <a href="https://www.idsprime.com/admin/Whatsappmanager/add" class="btn btn-success pull-right">Add </a>


                         <!-- /.box-header -->
                         <?php echo $this->Flash->render(); ?>
                     </div>
                     <div class="box-body">
                         <table id="example1" class="table table-bordered table-striped">
                             <thead>
                                 <tr>
                                     <th>S.No.</th>
                                     <th>School Name</th>
                                     <th>Last Purchase Date</th>
                                     <th>Current Balance</th>

                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $page = $this->request->params['paging']['Services']['page'];
                                    $limit = $this->request->params['paging']['Services']['perPage'];
                                    $counter = ($page * $limit) - $limit + 1;
                                    if (isset($users) && !empty($users)) {
                                        foreach ($users as $key => $service) { //pr($service);  die;
                                            $rr =  $this->Comman->findschoolname($service['client_id']);
                                           // pr($rr); die;
                                    ?>
                                         <tr>
                                             <td><?php echo $counter; ?></td>
                                             <td><?php echo ucfirst($rr[0]['school_name']); ?>
                                             <td><?php echo date('d-m-Y', strtotime($service['purchase_date'])); ?>
                                             <td><?php echo $rr[0]['msg_count']; ?>
                                             
                                             </td>

                                         </tr>
                                     <?php $counter++;
                                        }
                                        // die;
                                    } else { ?>
                                     <tr>
                                         <td>No Data Available</td>
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