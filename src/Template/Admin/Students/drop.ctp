<script>
   $(document).ready(function() {
      $("#TaskAdminCustomerForm").bind("submit", function(event) {
         $.ajax({
            async: true,
            type: "GET",
            url: "<?php echo ADMIN_URL; ?>students/drop_out_student_search",
            data: $("#TaskAdminCustomerForm").serialize(),
            dataType: "html",
            beforeSend: function(xhr) {
               xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())
               $('#load2').css("display", "block");
            },
            success: function(data) {
               $("#example2").html(data);
            },
            complete: function() {
               $('#load2').css("display", "none");
            },
         });
         return false;
      });
   });

   $(document).on('click', '.pagination a', function(e) {
      var target = $(this).attr('href');
      var res = target.replace("/students/drop_out_student_search", "/students/drop");
      window.location = res;
      return false;
   });
</script>

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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Student Drop Out Manager
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo ADMIN_URL; ?>students/index"><i class="fa fa-home"></i>Home</a></li>
         <li><a href="<?php echo ADMIN_URL; ?>students/index">Manage Student</a></li>
         <li><a href="#" class="active">Drop Student</a></li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <div class="box">
               <div class="box-header">
                  <i class="fa fa-search" aria-hidden="true"></i>
                  <h3 class="box-title">Search Student</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                  <div class="manag-stu">
                     <?php echo $this->Form->create('Task', array('url' => array('controller' => 'students', 'action' => 'search'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'TaskAdminCustomerForm', 'class' => 'form-horizontal')); ?>
                     <div class="form-group">
                        <div class="col-md-3 col-sm-3">
                           <label for="inputEmail3" class="control-label">Batch</label>
                           <?php
                           $batchValue = $_GET['batch'];
                           echo $this->Form->select(
                              'batch',
                              $academic_session,
                              [
                                 'class' => 'form-control',
                                 'placeholder' => '---Select Batch---',
                                 'empty' => '---Select Batch---',
                                 'id' => 'batch',
                                 // 'required' => true,
                                 'value' => $batchValue
                              ]
                           );
                           ?>
                        </div>
                        <div class="col-md-3 col-sm-3">
                           <label>Course</label>
                           <select class="form-control" name="class_id">
                              <option value="">Select Course</option>
                              <?php foreach ($classes as $esr => $es) { ?>
                                 <option value="<?php echo $esr; ?>"><?php echo $es; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                        <div class="col-md-3 col-sm-3">
                           <label>Year/Section</label>
                           <select class="form-control" name="section_id">
                              <option value=""> Select Year/Section </option>
                              <?php foreach ($sections as $er => $e) { ?>
                                 <option value="<?php echo $e['id']; ?>"><?php echo $e['title']; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                        <div class="col-md-3 col-sm-3">
                           <label>Sr.No</label>
                           <input type="text" class="form-control" name="enroll" placeholder="Enter Sr.No">
                        </div>
                        <div class="col-md-3 col-sm-3">
                           <label>Name of Pupil</label>
                           <input type="text" class="form-control" name="fname" placeholder="Enter First Name">
                        </div>


                        <!-- data peaker from and to  -->
                        <div class="col-md-3 col-sm-3">
                           <label>From</label>
                           <input type="date" class="form-control" name="from_date" id="from_date" placeholder="Select Date">
                        </div>
                        <div class="col-md-3 col-sm-3">
                           <label>To</label>
                           <input type="date" class="form-control" name="to_date" id="to_date" placeholder="Select Date">
                        </div>

                        <script>
                           const fromDate = document.getElementById('from_date');
                           const toDate = document.getElementById('to_date');

                           fromDate.addEventListener('change', function() {
                              toDate.min = this.value; // Set 'to_date' min as selected 'from_date'
                           });

                           toDate.addEventListener('change', function() {
                              fromDate.max = this.value; // Set 'from_date' max as selected 'to_date'
                           });
                        </script>


                        <!-- <div class="col-md-2 col-sm-2">
                           <label>Father Name</label>
                           <input type="text" class="form-control" name="fathername" placeholder="Enter Father Name">
                        </div> -->

                        <!-- <div class="col-md-2 col-sm-4">
                           <label>Status</label>
                           <select class="form-control" name="status_tc">
                              <option value=""> Select Action </option>
                              <option value="Y">W.T.C</option>
                              <option value="N">L.W.T.C</option>
                           </select>
                        </div> -->
                        <!-- <div class="form-group"> -->
                        <div class="col-sm-12 col-sm-3" style="padding-top: 23px;">
                           <button type="submit" class="btn btn-success">Search</button>
                           <a class="btn btn-info "
                              style="color:#ffffff !important; background-color: #8B0000; !important"
                              href="<?php echo SITE_URL; ?>admin/students/drop"><b>Reset</i></b></a>
                           <a
                              class="btn btn-info"
                              target="_blank"
                              href="<?php echo SITE_URL; ?>admin/students/download_drop_out_students">
                              Export to Excel
                           </a>
                        </div>
                        <!-- </div> -->
                     </div>
                     <!-- <div class="form-group">
                        <div class="col-sm-12 col-sm-2">
                           <button type="submit" class="btn btn-success">Search</button>
                           <button type="reset" class="btn btn-primary">Reset</button>
                        </div>
                     </div> -->
                     <?php
                     echo $this->Form->end();
                     ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <style>
         /* Tooltip container */
         .tooltip {
            position: relative;
            display: inline-block;
            border-bottom: 1px dotted black;
            /* If you want dots under the hoverable text */
         }

         /* Tooltip text */
         .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: black;
            color: #fff;
            text-align: center;
            padding: 5px 0;
            border-radius: 6px;
            /* Position the tooltip text - see examples below! */
            position: absolute;
            z-index: 1;
         }

         /* Show the tooltip text when you mouse over the tooltip container */
         .tooltip:hover .tooltiptext {
            visibility: visible;
         }
      </style>
      <div class="row">
         <div class="col-xs-12">
            <div class="box">
               <div class="box-header">
                  <i class="fa fa-search" aria-hidden="true"></i>
                  <h3 class="box-title">Student List</h3>

               </div>
               <!-- /.box-header -->
               <?php echo $this->Flash->render(); ?>
               <div class="box-body">
                  <div id="load2" style="display:none;"></div>
                  <div class="table-responsive" id="example2">
                     <table class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>S. No.</th>
                              <th>Pupil Name</th>
                              <th>Father Name</th>
                              <th>Mobile</th>
                              <th>Academic Year</th>
                              <th>Last Studied Course</th>
                              <th>Course/Year</th>
                              <!-- <th>Year/Section</th> -->
                              <!-- <th>Genrate T.C</th> -->
                              <th>
                                 <center>Action</center>
                              </th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $page = $this->request->params['paging']['DropOutStudent']['page'];
                           $limit = $this->request->params['paging']['DropOutStudent']['perPage'];
                           $counter = ($page * $limit) - $limit + 1;

                           if (isset($students) && !empty($students)) {
                              foreach ($students as $work) { ?>
                                 <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $work['enroll']; ?></td>
                                    <td>

                                       <?php
                                       $tc_alreay = $this->Comman->checktc($work['s_id']);
                                       /*
                                       $findstu = $this->Comman->findridacademicre($work['s_id'], $work['acedmicyear']);
                                       $tc_character = $this->Comman->tc_character($work['s_id']);
                                       $detained['id'] = '';

                                       if ($findstu['id'] == '') {
                                          $detained = $this->Comman->gethistoryyearstudentinfo45($work['s_id'], $work['acedmicyear']);
                                          $acd1 = $this->Comman->findfeesmonthstudentdrop($work['s_id'], $detained['acedmicyear']);
                                          $acd2 = $this->Comman->findfeesmonthstudentdrop2($work['s_id'], $detained['acedmicyear']);
                                          $acd3 = $this->Comman->findfeesmonthstudentdrop3($work['s_id'], $detained['acedmicyear']);
                                          $acd4 = $this->Comman->findfeesmonthstudentdrop4($work['s_id'], $detained['acedmicyear']);
                                       } else {
                                          $acd1 = $this->Comman->findfeesmonthstudentdrop($work['s_id'], $work['acedmicyear']);
                                          $acd2 = $this->Comman->findfeesmonthstudentdrop2($work['s_id'], $work['acedmicyear']);
                                          $acd3 = $this->Comman->findfeesmonthstudentdrop3($work['s_id'], $work['acedmicyear']);
                                          $acd4 = $this->Comman->findfeesmonthstudentdrop4($work['s_id'], $work['acedmicyear']);
                                       }   
                                       */
                                       ?>

                                       <a <?php if ($detained['id'] && $work['school_lastresult'] != "Pass") { ?>
                                          style="color:red;" title="View Detained Student" <?php } else { ?>
                                          title="View Drop Out Student" <? } ?>
                                          href="<?php echo SITE_URL; ?>admin/students/dropview/<?php echo $work['id']; ?>">
                                          <?php
                                          $name = $work['fname'] . ' ';
                                          if (!empty($work['middlename']))
                                             $name .= $work['middlename'] . ' ';
                                          echo $name .= $work['lname'];
                                          ?>
                                       </a>

                                       <!-- <a title="Edit Drop OutStudent" href="<?php echo SITE_URL; ?>admin/students/editdropout/<?php echo $work['id']; ?>">
                                          <img src="<?php echo SITE_URL; ?>images/edit.png" style="width: 18px;">
                                       </a> -->

                                       <!-- <a class="global1" title="Pending Fees" style="color:red;" href="<? echo ADMIN_URL; ?>students/drop_outs/<?php echo $work['s_id']; ?>" data-target="#global-drop-out<?php echo $work['id']; ?>" data-toggle="modal">
                                          <img src="<?php echo SITE_URL; ?>images/pending.png">
                                       </a>

                                       <a title="Tution Fees Acknowledgement <?php echo $work['updateacedemic']; ?>" target="_blank" href="<?php echo SITE_URL; ?>admin/report/drop_feeacknowledgement/<?php echo $work['id']; ?>/<?php echo $work['updateacedemic']; ?>"> <img src="<? echo SITE_URL; ?>images/fee_acnow.png">
                                       </a> -->

                                       <?php if ($work['remarks_lwt']) { ?>
                                          <i class="fa fa-pause-circle" title="<?php echo $work['remarks_lwt']; ?>"
                                             style="font-size:21px;color:red;">
                                          </i>
                                       <?php } ?>

                                    </td>
                                    <div class="modal" id="global-drop-out<?php echo $work['id']; ?>" tabindex="-1"
                                       role="dialog" aria-labelledby="esModalLabel" aria-hidden="true" style="display: none;">
                                       <div class="modal-dialog">
                                          <div class="modal-content modal-content-drop-out">
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

                                    <script>
                                       $(document).ready(function() {
                                          //prepare the dialog
                                          //respond to click event on anything with 'overlay' class
                                          $("#global-drop-out<?php echo $work['id']; ?>").click(function(event) {
                                             $('.modal-content').html('<div class="modal-body"><div class="loader"><div class="es-spinner"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div> </div></div>');
                                             $('.modal-content-drop-out').html('<div class="modal-body"><div class="loader"><div class="es-spinner"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div> </div></div>');
                                             $('.modal-content-drop-out').load($(this).attr("href"));

                                          });
                                       });
                                    </script>

                                    <td><?php echo $work['fathername']; ?></td>
                                    <td><?php echo $work['mobile']; ?></td>
                                    <td><?php echo $work['acedmicyear']; ?>
                                    </td>
                                    <td><?php $class = $this->Comman->findclass($work['laststudclass']);
                                          echo $class['title']; ?>
                                    </td>
                                    <td><?php echo $work['class']['title'] . '/' . $work['section']['title']; ?></td>
                                    <!-- <td><?php echo $work['section']['title']; ?></td> -->
                                    <!-- <td> -->
                                    <!-- for head branch  -->
                                    <?php
                                    /*
                                       if ($sitesettingdetail['branch_type'] == 'Headbranch' || $get_managesettings['is_tc'] == '0') {
                                          if ($work['status_tc'] == "N") {  ?>
                                             <a href="<?php echo SITE_URL; ?>admin/students/statusdrop/<?php echo $work['id']; ?>/Y" title="Assign for T.C">
                                                <i class="fa fa-clock-o" aria-hidden="true" style="font-size: 22px;color:red;"></i>
                                             </a>&nbsp;<b>L.W.T.C</b>
                                          <? } else { ?>
                                             <i class="fa fa-check-circle" aria-hidden="true" style="font-size: 22px;color:#3c8dbc;"></i>&nbsp;<b>W.T.C</b>
                                             <?php }
                                       } else {
                                          if ($work['status_tc'] == "N") {
                                             if ($work['request_status'] == "N" || $work['request_status'] == '') { ?>
                                                <a href="<?php echo SITE_URL; ?>admin/students/tc_approval/<?php echo $work['id']; ?>" data-target="#globalModalforbranchess" data-toggle="modal" class="global"><i class="fa fa-clock-o" aria-hidden="true" style="font-size: 22px;color:red;"></i>
                                                </a>&nbsp;<b>L.W.T.C</b>
                                             <?php } else { ?>
                                                <a href="<?php echo SITE_URL; ?>admin/students/tc_approval/<?php echo $work['id']; ?>" data-target="#globalModalforbranchess" data-toggle="modal" class="global"><i class="fa fa-clock-o" aria-hidden="true" style="font-size: 22px;color:green;"></i>
                                                </a>&nbsp;<b>Wait</b>
                                             <?php } ?>
                                             <!-- for sub branches  -->
                                          <?php } else { ?>
                                             <i class="fa fa-check-circle" aria-hidden="true" style="font-size: 22px;color:#3c8dbc;"></i>&nbsp;<b>W.T.C</b>

                                       <?php }
                                       } */ ?>
                                    <!-- </td> -->
                                    <td>
                                       <div>
                                          <?php /*

                                          if ($this->request->session()->read('Auth.User.role_id') != LEAD_COORDINATOR && $tc_alreay == 1) { ?>
                                             <a href="<?php echo SITE_URL; ?>admin/students/restore/<?php echo $work['id']; ?>"
                                                title="Restore Student" style="color: maroon;"
                                                onclick="return confirm('Are you sure you want to restore this student?');">
                                                <img src="https://use.fontawesome.com/releases/v5.0.13/svgs/solid/undo.svg"
                                                   width="15" height="15">
                                             </a>

                                          <?php } */ ?>


                                          <?php
                                          /*
                                          if ($work['status_tc'] == "Y") {

                                             if ($tc_alreay == 1) {
                                          ?>
                                                <a href="<?php echo SITE_URL; ?>admin/students/transfer_certificate_info/<?php echo $work['id']; ?>/<?php echo $work['s_id']; ?>" title="Transfer Certificate" style="color: red;" data-target="#globalModal" data-toggle="modal" class="global">
                                                   <i class="fa fa-file-pdf-o"></i>
                                                </a>
                                             <?php } else {  ?>
                                                <a href="<?php echo SITE_URL; ?>admin/students/transfer_certificate_pdf/<?php echo $work['s_id']; ?>" title="Download TC" style="color: green;" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                                             <?php }
                                             if ($tc_character == 1) { ?>
                                                &nbsp;
                                                <a href="<?php echo SITE_URL; ?>admin/students/character_certificate_info/<?php echo $work['id']; ?>" title="Character Certificate" data-target="#globalModals" data-toggle="modal" class="global" style="color: maroon;"> <i class="fa fa-file-pdf-o"></i>
                                                </a>&nbsp;
                                             <?php } else { ?>
                                                &nbsp;<a href="<?php echo SITE_URL; ?>admin/students/character_certificate_pdf/<?php echo $work['s_id']; ?>" title="Download Character" style="color: green;" target="_blank"> <i class="fa fa-file-pdf-o"></i>
                                                </a>&nbsp;
                                             <?php } ?>
                                             <a href="<?php echo SITE_URL; ?>admin/students/bonafide_certificate_pdf/<?php echo $work['id']; ?>" title="Bonafide Certificate" target="_blank" style="color: blue;">
                                                <i class="fa fa-file-pdf-o"></i>
                                             </a>


                                             &nbsp;
                                          <?php } */ ?>

                                       </div>
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
                     <?php echo $this->element('admin/pagination'); ?>
                  </div>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
         <!-- /.box -->
      </div>
      <!-- /.col -->
</div>
<div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true"
   style="display: none;">
   <div class="modal-dialog" style="overflow-y: scroll;
      height: 90vh;">
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
<!-- For approval canvcvas sub branchess  -->
<div class="modal" id="globalModalforbranchess" tabindex="-1" role="dialog" aria-labelledby="esModalLabel"
   aria-hidden="true" style="display: none;">
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
<!-- end  -->
<!-- For Palaceschool  -->
<div class="modal" id="globalModalforpalaceschool" tabindex="-1" role="dialog" aria-labelledby="esModalLabel"
   aria-hidden="true" style="display: none;">
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
<!-- end  -->
<div class="modal" id="globalModals" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true"
   style="display: none;">
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
<script>
   $(document).ready(function() {

      $(".global").click(function(event) {

         //load content from href of link
         $('.modal-content').html('<div class="modal-body"><div class="loader"><div class="es-spinner"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div> </div></div>');
         $('.modal-content-drop-out').html('<div class="modal-body"><div class="loader"><div class="es-spinner"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div> </div></div>');
         $('.modal-content').load($(this).attr("href"));
      });

   });
</script>