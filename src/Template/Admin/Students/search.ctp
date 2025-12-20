<?php
$role_id = $this->request->session()->read('Auth.User.role_id');
?>

<a href="<?php echo SITE_URL; ?>admin/report/feesreport">
   <button class="btn btn-success pull-right m-top10" style="margin-bottom: 10px;">
      <i class="fa fa-file-excel-o" aria-hidden="true"></i>
      Fees Details
   </button>
</a>

<a href="<?php echo SITE_URL; ?>admin/report/hostelfeesreport">
   <button class="btn btn-success pull-right m-top10" style="margin-right: 10px;">
      <i class="fa fa-file-excel-o" aria-hidden="true"></i>
      Hostel Fees Details
   </button>
</a>

<table id="example1" class="table table-bordered table-striped">
   <thead>
      <tr>
         <th>S.No</th>
         <th>Schloar. No.</th>
         <th>Name</th>
         <th>Mobile</th>
         <th>Fathername</th>
         <th>Admission Date</th>
         <th width="5%">Batch</th>
         <th>Course/Year</th>
         <th>Fee</th>
         <th>Discount</th>
         <th>Paid</th>
         <th>Balance</th>
         <th>Deposit</th>
         <?php if (in_array($role_id, [CENTER_COORDINATOR, ADMIN])) { ?>
            <th>Action</th>
         <?php } ?>
      </tr>
   </thead>
   <tbody id="example2">
      <?php
      $page = $this->request->params['paging']['Students']['page'];
      $limit = $this->request->params['paging']['Students']['perPage'];
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
               <td><?= $counter; ?></td>
               <td>
                  <?= $work['enroll']; ?>&nbsp;
                  <?php if (in_array($role_id, [CBSE_FEE_COORDINATOR, CENTER_COORDINATOR, ADMIN])) { ?>
                     <a title="View Student" href="<?= SITE_URL; ?>admin/students/view/<?= $work['id']; ?>">
                        <i class="fa fa-info-circle"></i>
                     </a>
                     <a title="Edit Student" href="<?= SITE_URL; ?>admin/students/edit/<?= $work['id']; ?>">
                        <i class="fa fa-pencil"></i>
                     </a>
                  <?php } ?>
               </td>
               <td>
                  <?php
                  if (isset($work['fname'])) {
                     echo ucwords(strtolower($work['st_full_name']));
                  }

                  if ($work['category'] == "Migration" || $work['oldenroll'] != 0) {
                     echo '<span style="color: red; font-weight:bold;">(Migr.)*</span>';
                  }

                  if ($work['is_transport'] == 'Y') {
                     echo '&nbsp;<i class="fa fa-bus"></i>';
                  }
                  ?>
                  <!-- For Hostel Fees Start -->
                  <a class='global1' title="<?= ($work['is_hostel']) ? 'Hostel Assigned' : 'Hostel Unassigned'; ?>"
                     href="<?= SITE_URL; ?>admin/students/hostel_fee_enable_disable/<?= $work['id']; ?>"
                     data-target="#hostal-fee-enable-disable<?= $work['id']; ?>" data-toggle="modal">
                     <i class="fas fa-bed" style="color: <?= ($work['is_hostel']) ? 'green;' : 'red;'; ?>"></i>
                  </a>
                  <!-- For Hostel Fees End -->
               </td>
               <td><?= (!empty($work['mobile'])) ? $work['mobile'] : "N/A"; ?></td>
               <td><?= (!empty($work['fathername'])) ? ucwords(strtolower($work['fathername'])) : "N/A"; ?></td>
               <td><?= date('d-m-Y', strtotime($work['created'])); ?></td>
               <td><?= $work['batch']; ?></td>
               <td><?= $work['class']['title'] . '/' . $work['section']['title']; ?></td>
               <td><?= $total_batch_fee; ?></td>
               <td><?= $getFeesDetails['discount']; ?></td>
               <td><?= $total_batch_paid_fee; ?></td>
               <td><?= $total_balance; ?></td>
               <td>
                  <a href="<?= SITE_URL; ?>admin/studentfees/view/<?= $work['id']; ?>" target="_blank">
                     <i class="fa fa-money" title="Deposit Fees" aria-hidden="true"></i>
                  </a>
               </td>
               <?php
               $allowedRoles = [ADMIN, CENTER_COORDINATOR];

               if (in_array($role_id, $allowedRoles) && $get_managesettings['drop_out_student'] == '0') {
                  ?>
                  <td>
                     <a class='global1' title="Drop Out" href="<?= SITE_URL; ?>admin/students/drop_out/<?= $work['id']; ?>"
                        data-target="#global-drop-out<?= $work['id']; ?>" data-toggle="modal">
                        <i class="fa fa-ban" aria-hidden="true"></i>
                     </a>
                  </td>
               <?php } ?>
            </tr>
            <!-- Drop Out Modal Start -->
            <div class="modal" id="global-drop-out<?php echo $work['id']; ?>" tabindex="-1" role="dialog"
               aria-labelledby="esModalLabel" aria-hidden="true" style="display: none;">
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
               $(document).ready(function () {
                  $("#global-drop-out<?php echo $work['id']; ?>").click(function (event) {
                     $('.modal-content-drop-out').load($(this).attr("href"));

                  });
               });
            </script>
            <!-- Drop Out Modal End -->

            <!-- For Hostal Fees Start -->
            <script>
               $(document).ready(function () {

                  $("#hostal-fee-enable-disable<?php echo $work['id']; ?>").click(function (event) {
                     $('.modal-content-hostal').load($(this).attr("href"));
                  });

               });
            </script>
            <div class="modal" id="hostal-fee-enable-disable<?php echo $work['id']; ?>" tabindex="-1" role="dialog"
               aria-labelledby="esModalLabel" aria-hidden="true" style="display: none;">
               <div class="modal-dialog">
                  <div class="modal-content modal-content-hostal">
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
            <!-- For Hostal Fees End -->

            <?php
            $counter++;
         }
      } else {
         ?>
         <tr>
            <td>NO Data Available</td>
         </tr>
      <?php } ?>
   </tbody>
</table>
<?php echo $this->element('admin/pagination'); ?>