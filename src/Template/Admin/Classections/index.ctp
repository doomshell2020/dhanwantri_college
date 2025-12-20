 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
     Course Sections Allocation

     </h1>
     <ol class="breadcrumb">
       <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="<?php echo ADMIN_URL; ?>Classections/index">Manage Course Sections</a></li>
     </ol>
   </section>
   <?php $roleid = $this->request->session()->read('Auth.User.role_id');
    if ($roleid == 1 || $roleid == 6) { ?>
     <!-- Main content -->
     <section class="content">
       <div class="row">
         <div class="col-xs-12">

           <div class="box">
             <div class="box-header">
               <h3 class="box-title">Course List</h3>

               <a href="<?php echo SITE_URL; ?>admin/classections/add">
                 <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus-square" aria-hidden="true"></i>
                   Add Course Section </button></a>

               <a class="btn btn-success pull-right" style="margin-right: 10px;" href="<?php echo SITE_URL; ?>admin/classections/addcsv"><i class="fa fa-plus"></i> Add CSV</a>

               <a id="" style="margin-right: 10px;" class="btn btn-success pull-right" href="<?php echo ADMIN_URL; ?>Classections/classsection_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
             </div>
             <!-- /.box-header -->
             <?php echo $this->Flash->render(); ?>
             <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
             <style>
               .sortable {
                 list-style-type: none;
                 margin: 0;
                 padding: 0;
                 width: 60%;
               }

               .sortable li {
                 margin: 0 3px 3px 3px;
                 padding: 0.4em;
                 padding-left: 1.5em;
                 font-size: 0.8em;
                 height: 24px;
                 width: 281px;
               }

               .sortable li span {
                 position: absolute;
                 margin-left: -1.3em;
               }
             </style>

             <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

             <div class="box-body">
               <table id="example1" class="table table-bordered table-striped">
                 <thead>
                   <tr>
                     <th>Sr.No</th>
                     <th>Course</th>
                     <th>Section</th>
                     <th>Course Teacher</th>
                     <th>Strength</th>
                     <th>Capacity</th>
                     <!-- <th>Status</th> -->
                     <!-- <th>Action</th> -->
                   </tr>
                 </thead>
                 <tbody>
                   <?php $page = $this->request->params['paging']['Services']['page'];
                    $limit = $this->request->params['paging']['Services']['perPage'];
                    $counter = ($page * $limit) - $limit + 1;

                    if (isset($classes) && !empty($classes)) {
                      foreach ($classes as $service) {
                        $empid = explode(',', $service['teacher_id']);
                    ?>
                       <tr>
                         <td><?php echo $counter; ?></td>
                         <td><?php echo $service['Classes']['title']; ?></td>
                         <td><?php echo $service['Sections']['title']; ?></td>
                         <td> <?php $subjectlist = $this->Comman->find_subjects($service['Classes']['id']); //pr($subjectlist); 
                              ?>

                           <script>
                             $(function() {
                               $("#sortable<?php echo $service['id']; ?>").sortable();
                               //$( "#sortable<?php echo $service['id']; ?>" ).disableSelection();
                             });
                           </script>
                           <ul id="sortable<?php echo $service['id']; ?>" class="sortable"><?
                                                                                            foreach ($empid as $key => $list) {
                                                                                              $empname = $this->Comman->findempname($list);
                                                                                            ?>

                               <li class="ui-state-default" id="sorting<?php echo $list['id']; ?>"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo ucfirst($empname['fname']) . " " . $empname['middlename'] . " " . $empname['lname']; ?>

                               </li>

                             <?php } ?>
                           </ul>
                         </td>
                         <td><?php echo $service['self_strength']; ?></td>
                         <td><?php echo $service['capacity']; ?></td>
                         <!-- <td> -->
                           <?php

                            /*if ($service['status'] == 'Y') {
                                echo $this->Html->link('', [
                                  'action' => 'status',
                                  $service->id,
                                  $service['status']
                                ], ['title' => 'Active', 'class' => 'fa fa-check-circle', 'style' => 'font-size: 21px !important; margin-left: 12px;  color: #36cb3c;']);
                              } else {
                                echo $this->Html->link('', [
                                  'action' => 'status',
                                  $service->id,
                                  $service['status']
                                ], ['title' => 'Inactive', 'class' => 'fa fa-times-circle-o', 'style' => 'font-size: 21px !important; margin-left: 12px; color:#FF5722;']);
                              } ?>
                           &nbsp;<?php
                                  echo $this->Html->link('', [
                                    'action' => 'add',
                                    $service->id
                                  ], ['class' => 'fas fa-edit', 'style' => 'font-size: 16px !important;']); ?>
                           <?php
                            echo $this->Html->link('', [
                              'action' => 'view',
                              $service->id
                            ], ['class' => 'fas fa-eye', 'style' => 'font-size: 16px !important;']); ?>
                           <?php
                            echo $this->Html->link('', [
                              'action' => 'delete',
                              $service->id
                            ], [
                              'class' => 'fas fa-trash-alt', 'style' => 'font-size: 16px !important;color:#bd1111', "onClick" => "javascript: return confirm('Are you sure do you want to delete this Company Record'"
                            ]);*/ ?>
                            <!-- </td> -->
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
   <?php } else if ($roleid == 3) { ?>


     <section class="content">
       <div class="row">
         <div class="col-xs-12">

           <div class="box">
             <div class="box-header">
               <h3 class="box-title">Class Section Allocation</h3>




             </div>
             <!-- /.box-header -->
             <?php echo $this->Flash->render(); ?>

             <div class="box-body">
               <table id="example1" class="table table-bordered table-striped">
                 <thead>
                   <tr>
                     <th>#</th>
                     <th>Class</th>
                     <th>Section</th>
                     <th>Subject</th>
                     <th>Times</th>
                     <th>Weekday</th>
                     <th>Status</th>

                   </tr>
                 </thead>
                 <tbody>
                   <?php $page = $this->request->params['paging']['ClasstimeTabs']['page'];
                    $limit = $this->request->params['paging']['ClasstimeTabs']['perPage'];
                    $counter = ($page * $limit) - $limit + 1;

                    if (isset($classesdata) && !empty($classesdata)) {
                      foreach ($classesdata as $service) {
                    ?>
                       <tr>
                         <td><?php echo $counter; ?></td>
                         <td><?php $ert = $this->Comman->find_alls($service['class_id']);
                              echo $ert['Classes']['title']; ?></td>
                         <td><?php echo  $ert['Sections']['title']; ?></td>
                         <td><?php echo $service['Subjects']['name']; ?></td>

                         <td><?php echo $service['Timetables']['time_from'] . "-" . $service['Timetables']['time_to']; ?></td>
                         <td><?php echo $service['weekday']; ?></td>
                         <td><?php if ($service['status'] == 'Y') {
                                echo $this->Html->link('Activate', [
                                  'action' => '#'

                                ], ['class' => 'label label-success']);
                              } else {
                                echo $this->Html->link('Deactivate', [
                                  'action' => '#'
                                ], ['class' => 'label label-primary']);
                              } ?>
                         </td>
                         <td></td>
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


   <?php } ?>
 </div>

 <script type="text/javascript">
   function updateSubjectSeqs(id) {
     /*
              // var sortableLinks = $("#sortable"+id);
     $("#sortable"+id).sortable({
         handle: '.handle',
         update: function() {
             var order = $("#sortable"+id).sortable('toArray');
            
         }
     });
           $.post("<?php echo $this->Url->build('/admin/Subjectclass/managesubjectsequence'); ?>",order,
               function(response){
     alert(response);
                 //console.log(response);
                // $("#state").html(response);
                 alert("Sequence updated successfully.");
               }); 
     */
   }


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