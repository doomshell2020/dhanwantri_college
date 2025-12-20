 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       Rejected Registration
     </h1>
     <ol class="breadcrumb">
       <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="<?php echo ADMIN_URL; ?>report/prospect">Prospectus Report</a></li>
     </ol>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <div class="col-xs-12">
         <?php echo $this->Flash->render(); ?>
         <div class="box">
           <div class="box-header">
             <div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                 <div class="modal-content">
                   <div class="modal-body">
                     <div class="loader">
                       <div class="es-spinner">
                         <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
             <!-- /.box-header -->
             <?php echo $this->Flash->render(); ?>

           </div>
           <?php if (isset($rej_appli) && !empty($rej_appli)) {  ?>
             <div id="updt">
               <?php echo $this->Form->create('Interaction', array('url' => array('controller' => 'Students', 'action' => 'prosapproval'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'stud-attendance-form', 'class' => '')); ?>
               <div class="form-group">

                 <div class="col-sm-4">
                   <input type="submit" style="background-color:red;width:100px !important; margin-left: 10px;" class="btn btn4 btn_pdf myscl-btn date inv" name="Approve" value="Approve">
                 </div>
               </div>
               <div style="clear: both;"></div>
               <div class="box-body">
                 <table id="example1" class="table table-bordered table-striped">
                   <thead>
                     <tr>
                       <th><input type="checkbox" id='checkall' /> Select All</th>
                       <th>S.No.</th>
                       <th>Form No.</th>
                       <th>Name</th>
                       <th>Mobile</th>
                       <th>Class</th>
                       <th>Board</th>
                       <th>Receipt</th>
                       <th>Status</th>
                     </tr>
                   </thead>
                   <tbody id="example22">
                     <?php $page = $this->request->params['paging']['Services']['page'];
                      $limit = $this->request->params['paging']['Services']['perPage'];
                      $counter = ($page * $limit) - $limit + 1;

                      foreach ($rej_appli as $service) { 
                      ?>
                       <tr>
                         <td><input type="checkbox" class='checkbox' name="p_id[]" value=<?php echo $service['enquire']['formno']; ?> /> </td>
                         <td><?php echo $counter; ?></td>
                         <td><?php if (isset($service['id'])) {
                                echo $service['sno'];
                              } else {
                                echo 'N/A';
                              } ?></td>
                         <td><?php if (isset($service['enquire']['s_name'])) {
                                echo ucfirst($service['enquire']['s_name']);
                              } else {
                                echo 'N/A';
                              } ?></td>
                         <td><?php if (!empty($service['enquire']['mobile'])) {
                                echo $service['enquire']['mobile'];
                              } else {
                                echo 'N/A';
                              } ?></td>
                         <?php $cls = $this->Comman->showclasstitle($service['class_id']); 
                          ?>
                         <td><?php if (isset($cls['title'])) {
                                echo ucfirst($cls['title']);
                              } else {
                                echo 'N/A';
                              } ?></td>
                         <?php $bls = $this->Comman->showboardtitle($service['enquire']['mode1_id']); 
                          ?>

                         <td><?php if (isset($bls['name'])) {
                                echo ucfirst($bls['name']);
                              } else {
                                echo 'N/A';
                              } ?></td>
                         <td> <a title="Registration Receipt" id="s<?php echo $service['id']; ?>" target="_blank" href="<?php echo SITE_URL; ?>admin/Students/applicant_recipt/<?php echo $service['id']; ?>"><i class="fa fa-file-text-o"></i></a> </td>
                         <td style="color:red;"><?php if ($service['status_r']) { echo "Rejected"; } else { echo 'N/A'; } ?></td>

                       </tr>
                     <?php $counter++;
                      }
                    } else { ?>
                     <h3 style="text-align: center;color: red;">NO Rejected Applicants.</h3>
                   <?php } ?>
                   <script type='text/javascript'>
                     // Changing state of CheckAll checkbox 
                     $(".checkbox").click(function() {

                       if ($(".checkbox").length == $(".checkbox:checked").length) {
                         $("#checkall").prop("checked", true);
                       } else {
                         $("#checkall").removeAttr("checked");
                       }

                     });
                   </script>
                   </tbody>

                 </table>
               </div>
               <?php echo $this->Form->end(); ?>
             </div>
             