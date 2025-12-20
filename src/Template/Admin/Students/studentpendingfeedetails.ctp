<style>
   .dropppss:after {
      display: inline-block;
      width: 0;
      height: 0;
      margin-left: .255em;
      vertical-align: .255em;
      content: "";
      border-top: .3em solid;
      border-right: .3em solid transparent;
      border-bottom: 0;
      border-left: .3em solid transparent;
   }

   .hover:hover {
      background-color: #f1f1f1;
   }
</style>

<script>
   $(document).ready(function () {
      $("#TaskAdminCustomerForm").bind("submit", function (event) {
         $.ajax({
            async: true,
            data: $("#TaskAdminCustomerForm").serialize(),
            dataType: "html",
            beforeSend: function (xhr) {
               xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())
               $('#load2').css("display", "block");
            },
            success: function (data, textStatus) {
               $("#example23").html(data);
            },
            complete: function () {
               $('#load2').css("display", "none");
            },
            type: "get",
            url: "<?php echo ADMIN_URL; ?>students/searchstudentpendingfeedetails"
         });
         return false;
      });

   });

   $(document).on('click', '.pagination a', function (e) {
      var target = $(this).attr('href');
      var res = target.replace("/students/searchstudentpendingfeedetails", "/students/studentpendingfeedetails");
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
         Student Pending Fee Report
      </h1>
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
                     <?php 
                     echo $this->Form->create('Task', array('url' => array('controller' => 'students', 'action' => 'searchstudentpendingfeedetails'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'TaskAdminCustomerForm', 'class' => 'form-horizontal')); ?>
                     <div class="form-group">

                        <div class="col-md-2 col-sm-4">
                           <label for="inputEmail3" class="control-label">Batch</label>
                           <?php
                           $batchValue = $_REQUEST['batch'];
                           echo $this->Form->select(
                              'batch',
                              $academic_session,
                              [
                                 'class' => 'form-control',
                                 'placeholder' => '---Select Batch---',
                                 'empty' => '---Select Batch---',
                                 'id' => 'batch',
                                 'value' => $batchValue
                              ]
                           );
                           ?>
                        </div>

                        <div class="col-md-2 col-sm-4">
                           <label>Course</label>
                           <select class="form-control" name="class_id">
                              <option value="">Select Course</option>
                              <?php foreach ($classes as $esr => $es) { ?>
                                 <option  value="<?php echo $esr; ?>" <?php echo $_REQUEST['class_id'] == $esr ? 'selected' : ''; ?>> <?php echo $es; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                        <div class="col-md-2 col-sm-4">
                           <label>Name of Student</label>
                           <input type="text" class="form-control" name="fname" placeholder="Enter First Name">
                        </div>
                        <div class="col-md-2 col-sm-4">
                           <label style="display: block;">Include No Dues</label>
                           <input type="checkbox" value="1" <?php echo $_REQUEST['no_dues'] == 1 ? 'checked' : ''; ?> name="no_dues">
                        </div>

                        <div class="col-md-3 col-sm-4" style="margin-top:23px;">
                           <button type="submit" class="btn btn-success">Search</button>

                           <a href="<?php echo SITE_URL; ?>admin/students/studentpendingfeedetails"
                              class="btn btn-primary">Reset</a>


                           <button class="btn btn-success dropdown-toggle dropppss" type="button"
                              style="background: #00a65a;padding-left:20px;" id="dropdownMenuButton"
                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Report
                           </button>
                           <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                              style="left: -30px !important; ">
                              <a target="_blank" class="dropdown-item hover"
                                 style="display: block; color:black; padding:5px;"
                                 href="<?php echo SITE_URL; ?>admin/students/exportpendingfeesinhtml">Print</a>

                              <a class="dropdown-item hover" style="display: block; color:black; padding:5px;"
                                 href="<?php echo SITE_URL; ?>admin/students/excelexportpendingfees2">Export to
                                 Excel</a>
                           </div>
                        </div>


                     </div>
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
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script>
         $(document).ready(function () {
            //prepare the dialog

            //respond to click event on anything with 'overlay' class
            $(".globalModals").click(function (event) {
               $('.modal-content').load($(this).attr("href")); //load content from href of link
            });
         });
      </script>

      <div class="row">
         <div class="col-xs-12">
            <div class="box">

               <?php echo $this->Flash->render(); ?>
               <div class="box-body">

                  <div id="load2" style="display:none;"></div>
                  <div class="table-responsive">
                     <div id="example23">

                        <table id="" class="table table-bordered table-striped">
                           <thead>
                              <tr>
                                 <th>S.No</th>
                                 <th>Schloar No.</th>
                                 <th>Name<br>(Fathername)<br>Mobile</th>
                                 <th width="4%">Batch</th>
                                 <th width="6%">Course<br>Year</th>
                                 <th>Prev Due</th>
                                 <th>Prev Paid</th>
                                 <th>1stYr Fee</th>
                                 <th>1stYr Paid</th>
                                 <th>1stYr Trans Fee</th>
                                 <th>1stYr Trans Paid</th>
                                 <th>2ndYr Fee</th>
                                 <th>2ndYr Paid</th>
                                 <th>2ndYr Trans Fee</th>
                                 <th>2ndYr Trans Paid</th>
                                 <th>3rdYr Fee</th>
                                 <th>3rdYr Paid</th>
                                 <th>3rdYr Trans Fee</th>
                                 <th>3rdYr Trans Paid</th>
                                 <th>4thYr Fee</th>
                                 <th>4thYr Paid</th>
                                 <th>4thYr Trans Fee</th>
                                 <th>4thYr Trans Paid</th>
                                 <th>Discount</th>
                                 <th>Balance</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              $page = $paging['page'];
                              $limit = $paging['limit'];
                              $counter = ($page * $limit) - $limit + 1;
                              if (isset($students) && !empty($students)) {
                                 foreach ($students as $work) {
                                    $getFeesDetails = $this->Comman->getstudenttotalfeesdetails($work);

                                    $section_id = $work['section_id'];

                                    if ($section_id == 1) {
                                       $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'];
                                       $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'];
                                       $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'];
                                    } elseif ($section_id == 2) {
                                       $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'];
                                       $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'];
                                       $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'];
                                    } elseif ($section_id == 3) {
                                       $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'];
                                       $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'];
                                       $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'];
                                    } else {
                                       $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['4th_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'] + $getFeesDetails['4th_year_transport_fees'];
                                       $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['4th_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'] + $getFeesDetails['4th_year_students_transport_deposite'];
                                       $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'] + $getFeesDetails['4th_year_students_discount'];
                                    }

                                    $total_balance = $total_batch_fee - $total_batch_paid_fee - $getFeesDetails['discount'];
                                    ?>
                                    <tr>
                                       <td><?php echo $counter; ?></td>
                                       <td><?php echo $work['enroll']; ?></td>
                                       <td>
                                          <?php echo $work['st_full_name'] . '<br>(' . $work['fathername'] . ')<br>' . $work['mobile']; ?>
                                       </td>
                                       <td><?php echo $work['batch']; ?></td>
                                       <td><?php echo $work['class']['title'] . '<br>' . $work['section']['title']; ?></td>
                                       <td><?php echo $getFeesDetails['previous_year']; ?></td>
                                       <td><?php echo $getFeesDetails['previous_year_students_fee_deposite']; ?></td>
                                       <td><?php echo $getFeesDetails['1st_year_total_fees']; ?></td>
                                       <td><?php echo $getFeesDetails['1st_year_students_fee_deposite']; ?></td>


                                       <?php if ($classfeeData['qu1_fees'] > 0 || empty($classfeeData)) { ?>
                                          <td><?php echo $getFeesDetails['1st_year_transport_fees']; ?></td>
                                          <td><?php echo $getFeesDetails['1st_year_students_transport_deposite']; ?></td>
                                       <?php } else { ?>
                                          <td>NA</td>
                                          <td>NA</td>
                                       <?php } ?>

                                       <?php if ($section_id == 2 || $section_id == 3 || $section_id == 4) { ?>
                                          <td><?php echo $getFeesDetails['2nd_year_total_fees']; ?></td>
                                          <td><?php echo $getFeesDetails['2nd_year_students_fee_deposite']; ?></td>
                                          <?php if ($classfeeData['qu2_fees'] > 0 || empty($classfeeData)) { ?>
                                             <td><?php echo $getFeesDetails['2nd_year_transport_fees']; ?></td>
                                             <td><?php echo $getFeesDetails['2nd_year_students_transport_deposite']; ?></td>
                                          <?php } else { ?>
                                             <td>NA</td>
                                             <td>NA</td>
                                          <?php }
                                       } else { ?>
                                          <td>NA</td>
                                          <td>NA</td>
                                          <td>NA</td>
                                          <td>NA</td>
                                       <?php } ?>

                                       <?php if ($section_id == 3 || $section_id == 4) { ?>
                                          <td><?php echo $getFeesDetails['3rd_year_total_fees']; ?></td>
                                          <td><?php echo $getFeesDetails['3rd_year_students_fee_deposite']; ?></td>
                                          <?php if ($classfeeData['qu3_fees'] > 0 || empty($classfeeData)) { ?>
                                             <td><?php echo $getFeesDetails['3rd_year_transport_fees']; ?></td>
                                             <td><?php echo $getFeesDetails['3rd_year_students_transport_deposite']; ?></td>
                                          <?php } else { ?>
                                             <td>NA</td>
                                             <td>NA</td>
                                          <?php }
                                       } else { ?>
                                          <td>NA</td>
                                          <td>NA</td>
                                          <td>NA</td>
                                          <td>NA</td>
                                       <?php } ?>

                                       <?php if ($section_id == 4) { ?>
                                          <td><?php echo $getFeesDetails['4th_year_total_fees']; ?></td>
                                          <td><?php echo $getFeesDetails['4th_year_students_fee_deposite']; ?></td>
                                          <?php if ($classfeeData['qu4_fees'] > 0 || empty($classfeeData)) { ?>
                                             <td><?php echo $getFeesDetails['4th_year_transport_fees']; ?></td>
                                             <td><?php echo $getFeesDetails['4th_year_students_transport_deposite']; ?></td>
                                          <?php } else { ?>
                                             <td>NA</td>
                                             <td>NA</td>
                                          <?php }
                                       } else { ?>
                                          <td>NA</td>
                                          <td>NA</td>
                                          <td>NA</td>
                                          <td>NA</td>
                                       <?php } ?>

                                       <td><?php echo $getFeesDetails['discount']; ?></td>
                                       <td><?php echo $total_balance; ?></td>

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

                        <?php echo $this->element('admin/custompagination'); ?>

                     </div>

                  </div>
                  <div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel"
                     aria-hidden="true">
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
                  <?php echo $this->Form->end(); ?>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
         <!-- /.box -->
      </div>
      <!-- /.col -->
</div>


<script type="text/javascript">
   $(document).ready(function () {
      $("#checkall").change(function () {
         var checked = $(this).is(':checked');
         $(".checkbox").prop("checked", checked);
      });
   });
</script>
<script type="text/javascript">
   $('.inv').click(function () {
      var sd = $(".checkbox:checked").length;
      if (sd == 0) {
         alert("Please Select One Student Atleast.")
         return false;
      } else {
         return true;
      }
   });
</script>

<script>
   $(document).ready(function () {
      //prepare the dialog
      //respond to click event on anything with 'overlay' class
      $(".globalModals").click(function (event) {
         $('.modal-content').load($(this).attr("href")); //load content from href of link
      });
   });
</script>