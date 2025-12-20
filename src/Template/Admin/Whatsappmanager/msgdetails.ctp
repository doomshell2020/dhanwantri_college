<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <section class="content-header">
         <h1>
             Message Details Manager
         </h1>
         <ol class="breadcrumb">
             <li><a href="<?php echo ADMIN_URL;?>Whatsappmanager/msgdetails"><i class="fa fa-home"></i>Home</a></li>
             <li><a href="<?php echo ADMIN_URL;?>Whatsappmanager/msgdetails">Manage Message</a></li>
         </ol>
     </section>

     <!-- Main content -->
     <section class="content">
         <div class="row">
             <div class="col-xs-12">

                 <div class="box">
                     <div class="box-header">
                         <!-- <h3 class="box-title">Class List</h3> -->
                         <!-- /.box-header -->
                         <?php echo $this->Flash->render(); ?>
                     </div>
                     <div class="box-body">
                         <table id="example1" class="table table-bordered table-striped">
                             <thead>
                                 <tr>
                                     <th>#</th>
                                     <th>School Name</th>
                                     <th>Purchase Date</th>
                                     <th>Total Messages</th>
                                     <th>Sent Messages</th>
                                     <th>Total Pending</th>
                                     <!-- <th>Action</th> -->
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $page = $this->request->params['paging']['Services']['page'];
                                $limit = $this->request->params['paging']['Services']['perPage'];
                                $counter = ($page * $limit) - $limit + 1;
                                if(isset($resultall) && !empty($resultall)){ 
                                foreach($resultall as $key => $service){ //pr($total_msg); die;?>
                                 <tr>
                                     <td><?php echo $counter;?></td>
                                     <td><?php echo ucfirst($service['school_name']); ?> </td>
                                     <td><?php echo date('d-m-Y',strtotime($service['purchase_date']));?> </td>
                                     <td><?php echo $total_msg['count']; ?> </td>
                                     <td><?php echo $sms_count; ?> </td>
                                     <td><?php 
                                     $pending_sms = $total_msg['count']-$sms_count;
                                     echo $pending_sms; ?> </td>
                                 </tr>
                                 <?php $counter++;} }else{?>
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