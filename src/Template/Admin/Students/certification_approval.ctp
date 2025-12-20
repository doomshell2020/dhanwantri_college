<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Certificates Approval Manager
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo ADMIN_URL; ?>students/certification_approval"><i class="fa fa-home"></i>Home</a></li>
         <li><a href="<?php echo ADMIN_URL; ?>students/certification_approval">Manage Certificates</a></li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
   <div id="load"></div>
   <div class="row">
      <div class="col-xs-12">
         <?php echo $this->Flash->render(); ?>
         <div class="box">
            <style>
               #load {
               width: 100%;
               height: 100%;
               position: fixed;
               z-index: 9999;
               background-color: white !important;
               background: url("<? echo SITE_URL; ?>images/Preloader_2.gif") no-repeat center center rgba(0, 0, 0, 0.75)
               }
            </style>
            <style>
               #load2 {
               width: 100%;
               height: 100%;
               position: fixed;
               z-index: 9999;
               background-color: white !important;
               background: url("<? echo SITE_URL; ?>images/Preloader_2.gif") no-repeat center center rgba(0, 0, 0, 0.75)
               }
            </style>
            <script>
               document.onreadystatechange = function() {
                   var state = document.readyState
                   if (state == 'complete') {
                       document.getElementById('interactive');
                       document.getElementById('load').style.visibility = "hidden";
                   }
               }
            </script>
            <div class="box-header">
               <h3 class="box-title">Search Student</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <div class="clearfix">
                  <?php $role_id = $this->request->session()->read('Auth.User.role_id'); ?>
               </div>
               <div class="manag-stu">
                  <script inline="1">
                     //<![CDATA[
                     $(document).ready(function() {
                         $("#TaskAdminCustomerForm").bind("submit", function(event) {
                             $.ajax({
                                 async: true,
                                 data: $("#TaskAdminCustomerForm").serialize(),
                                 dataType: "html",
                                 beforeSend: function(xhr) {
                                     xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())
                                     $('#load2').css("display", "block");
                                 },
                                 success: function(data, textStatus) {
                                     $("#example23").html(data);
                                 },
                                 complete: function() {
                                     $('#load2').css("display", "none");
                                 },
                                 type: "POST",
                                 url: "<?php echo ADMIN_URL; ?>students/search_approval"
                             });
                             return false;
                         });
                     
                         $('#datefrom').datepicker({
                             dateFormat: 'dd-mm-yy',
                             onSelect: function(date) {
                                 var selectedDate = new Date(date);
                                 var endDate = new Date(selectedDate);
                                 endDate.setDate(endDate.getDate());
                     
                                 $("#datefrom").datepicker("option", "minDate", endDate);
                                 $("#datefrom").val(date);
                             }
                     
                         });
                     
                         $('#dateto').datepicker({
                             dateFormat: 'dd-mm-yy',
                             onSelect: function(date) {
                                 var selectedDate = new Date(date);
                                 var endDate = new Date(selectedDate);
                                 endDate.setDate(endDate.getDate());
                                 $("#dateto").datepicker("option", "minDate", endDate);
                                 $("#dateto").val(date);
                             }
                         });
                     });
                     //]]>
                  </script>
                  <?php echo $this->Form->create('Task', array('url' => array('controller' => 'students', 'action' => 'search_approval'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'TaskAdminCustomerForm', 'class' => 'form-horizontal', 'autocomplete' => 'off'));
                     ?>
                  <div class="form-group form_gpr_colm">
                     <div class="col-sm-3">
                        <label>&nbsp;Date From</label>
                        <input type="text" class="form-control datepicker" id="datefrom" name="datefrom" placeholder="dd-mm-yy">
                     </div>
                     <div class="col-sm-3">
                        <label>&nbsp;Date To</label>
                        <input type="text" class="form-control datepicker" id="dateto" name="dateto" placeholder="dd-mm-yy">
                     </div>
                     <div class="col-sm-3">
                        <label>&nbsp;School</label>
                        <input type="text" class="form-control" name="school_name" placeholder="Enter Scholar Name.">
                     </div>
                     <div class="col-sm-3">
                        <label>&nbsp;Pupil's Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Pupil's Name">
                     </div>
                     <div class="col-sm-12 text-center" style="padding: 23px;">
                        <label>&nbsp;</label>
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-success">Search</button>
                        <button type="reset" class="btn btn-primary">Reset</button>
                     </div>
                  </div>
                  <?php //echo $this->Form->end(); 
                     ?>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div id="load2" style="display:none;"></div>
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <div style="display:flex; justify-content: space-between;align-items:center;">
                  <h3 class="box-title">Student List </h3>
               </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="example23">
               <div class="table-responsive student_listtb_rspv">
                  <table id="example1" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Schloar. No.</th>
                           <th>Name</th>
                           <th>Class</th>
                           <th>D.O.B</th>
                           <th>Description</th>
                           <th>School</th>
                           <th>Date</th>
                           <!-- <th>Dropout</th> -->
                           <th width="70px">Action</th>
                        </tr>
                     </thead>
                     <tbody id="example2">
                        <?php $page = $this->request->params['paging']['Students']['page'];
                           $limit = $this->request->params['paging']['Students']['perPage'];
                           $counter = ($page * $limit) - $limit + 1;
                           
                           if (isset($students) && !empty($students)) {
                               foreach ($students as $work) { //pr($work);
                           ?>
                        <tr>
                           <td><?php echo $counter; ?></td>
                           <td>
                              <?php echo $work['enroll']; ?>&nbsp;<?php if ($role_id == '5' || $role_id == '8') { ?>
                              <a title="View Student" href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $work['id']; ?>">
                              <i class="fa fa-info-circle"></i>
                              </a>
                              <a title="Edit Student" href="<?php echo SITE_URL; ?>admin/students/edit/<?php echo $work['id']; ?>"><i class="fa fa-pencil"></i></a><? } ?>
                           </td>
                           <td>
                              <?php echo ucfirst(strtolower($work['sname'])); ?>
                           </td>
                           <td><?php $class = $this->Comman->findclass($work['class_id']);
                              $section = $this->Comman->findsecti($work['section_id']);
                              echo $class['title'] . '-' . $section['title']; ?>
                           </td>
                           <td><?php echo date('d-m-Y', strtotime($work['dob'])); ?></td>
                           <td><?php echo $work['description']; ?></td>
                           <td><?php echo ucfirst(strtolower($work['school_name'])); ?></td>
                           <td><?php echo date('d-m-Y', strtotime($work['created'])); ?></td>
                           <td>
                              <?php if ($work['status'] == 'N') { ?>
                              <?php
                                 echo $this->Html->link('Approval', [
                                     'action' => 'Approval',
                                     $work->id
                                 ], ['class' => 'btn btn-success', "onClick" => "javascript: return confirm('Are you sure do you want to Approve Student')"]);
                                 } else { ?>
                              <span class="fa fa-check"> Approve</span>
                              <?php } ?>
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
            </div>
            <!-- /.box-body -->
         </div>
      </div>
      <!-- /.box -->
   </div>
   <!-- /.col -->
</div>
<!-- /.row -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->