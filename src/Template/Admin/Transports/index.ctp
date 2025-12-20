 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       Transport Manager

     </h1>

     <ol class="breadcrumb">
       <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="<?php echo ADMIN_URL; ?>transports/index">Manage Transport</a></li>
     </ol>

     <?php echo $this->Flash->render(); ?>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <div class="col-xs-12">

         <div class="box">
           <div class="box-header">
             <h3 class="box-title">Transport List</h3>
           </div>

           <!-- /.box-header -->

           <div class="row">
             <div class="col-xs-12">
               <div class="box">
                 <div class="clearfix">
                   <a href="<?php echo SITE_URL; ?>admin/transports/add">
                     <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
                       Add Transport</button></a>

                       <a  style='color:red;text-align: center;' data-html="true"  tabindex='0' class='popover-dismiss pull-right btn btn-success' data-toggle='popover' data-placement='right' data-trigger='focus' title='Available Studnets' data-content='<?
                                  $i = 0;
                                  foreach ($studnetdata as $key => $stundename) {
                                    $i++;
                                    $stundename['fname'];
                                    echo $stundename['fname'].'<br/>';
                                  }
                                  ?>'><? echo '('.$i;?>)</a> 

                                  &nbsp; <a class="btn btn-success pull-right m-top10" href="<?php echo SITE_URL; ?>admin/transports/exportexcel">Export Excel<i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                 </div>
                 <div class="box-body">
                   <table id="example1" class="table table-bordered table-striped">
                     <thead>
                       <tr>
                         <th>S.No.</th>
                         <th>Vechical_no</th>
                         <th>Driver Name</th>
                         <th>Driver Mobile</th>
                         <th>Helper Name</th>
                         <th>Helper Mobile</th>
                         <th>GPS Device ID</th>
                         <th>Bus Strength</th>
                         <th>Route</th>
                         <th>Status</th>
                       </tr>
                     </thead>
                     <tbody>
                       <?php $page = $this->request->params['paging']['Services']['page'];
                        $limit = $this->request->params['paging']['Services']['perPage'];
                        $counter = ($page * $limit) - $limit + 1;
                        if (isset($transports) && !empty($transports)) {
                          foreach ($transports as $service) {
                        ?>
                           <tr>
                             <td><?php echo $counter; ?></td>
                             <td><?php if (isset($service['vechical_no'])) {
                                    echo ucfirst($service['vechical_no']);
                                  } else {
                                    echo 'N/A';
                                  } ?></td>
                             <td><?php if (isset($service['driver_name'])) {
                                    echo ucfirst($service['driver_name']);
                                  } else {
                                    echo 'N/A';
                                  } ?>
                             </td>
                             <td><?php if (isset($service['driver_mobile'])) {
                                    echo ucfirst($service['driver_mobile']);
                                  } else {
                                    echo 'N/A';
                                  } ?>
                              </td>
                              <td><?php if (isset($service['helper_name'])) {
                                    echo ucfirst($service['helper_name']);
                                  } else {
                                    echo 'N/A';
                                  } ?>
                             </td>
                             <td><?php if (isset($service['helper_mobile'])) {
                                    echo ucfirst($service['helper_mobile']);
                                  } else {
                                    echo 'N/A';
                                  } ?>
                              </td>

                              <td><?php if (isset($service['gps_deviceid'])) {
                                    echo ucfirst($service['gps_deviceid']);
                                  } else {
                                    echo 'N/A';
                                  } ?>
                              </td>

                              <td><?php if ($service['strength']!=null || $service['strength']!=0) {
                                    echo $service['strength'].' / ';?>
                               
                                  <? echo $service['occupation'];?></a>
                                <?  } else {
                                    echo 'N/A';
                                  } ?>
                              </td>

                             <td> <?php $routes = explode(",", $service['route']);
                                  foreach ($routes as $key => $value) {
                                    $loct = $this->Comman->findroutes($value);
                                  ?>
                                 <?php if (isset($loct['route_name'])) {
                                      echo ucfirst($loct['route_name']);
                                    } else {
                                      echo 'N/A';
                                    } ?>&nbsp;
                               <?php   }    ?></td>

                             <td><?php if ($service['status'] == 'Y') {
                                    echo $this->Html->link('', [
                                      'action' => 'status',
                                      $service->id,
                                      $service['status']
                                    ], ['class' => 'fas fa-check-circle', 'style' => 'font-size: 16px !important; margin-left: 12px;     color: #36cb3c;']);
                                  } else {
                                    echo $this->Html->link('', [
                                      'action' => 'status',
                                      $service->id,
                                      $service['status']
                                    ], ['class' => 'fas fa-times-circle', 'style' => 'font-size: 16px !important; margin-left: 12px; color:#cd0404;']);
                                  } ?>
                             </td>
                             <!-- <td><?php
                                  /*echo $this->Html->link('Edit', [
                                    'action' => 'add',
                                    $service->id
                                  ], ['class' => 'btn btn-primary']); ?>
                               <?php  
                                echo $this->Html->link('View', [
                                    'action' => 'view',
                                    $service->id
                                ],['class'=>'btn btn-success']); */ ?>
                               <?php
                                /*echo $this->Html->link('Delete', [
                                  'action' => 'delete',
                                  $service->id
                                ], ['class' => 'btn btn-danger', "onClick" => "javascript: return confirm('Are you sure do you want to delete this')"]); */?></td> -->
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

<script>
$(document).ready(function(){
  $('.popover-dismiss').popover({
  trigger: 'focus'
})   
});
</script>

 <!-- /.content-wrapper -->