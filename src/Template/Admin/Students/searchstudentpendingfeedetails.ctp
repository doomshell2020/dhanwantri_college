<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<table class="table table-bordered table-striped">
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
         } ?>
      <?php } else { ?>
         <tr>
            <td>NO Data Available</td>
         </tr>
      <?php } ?>
   </tbody>
</table>
<?php // echo $this->element('admin/pagination'); ?>
<?php echo $this->element('admin/custompagination'); ?>


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