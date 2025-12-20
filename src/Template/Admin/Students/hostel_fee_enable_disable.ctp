<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title">
      <i class="fa fa-bed" aria-hidden="true"></i> Hostel Fees of <? echo ucwords(strtolower($name)); ?> (<? echo $enroll; ?>)
   </h4>
</div>
<div class="modal-body">
   <div class="row">
      <div class="col-sm-12">

         <?php
         echo $this->Form->create($asignHostel, array(
            'action' => 'hostel_fee_enable_disable',
            'type' => 'file',
            'inputDefaults' => array('div' => false, 'label' => false),
            'id' => '',
            'class' => 'form-horizontal',
            'entity' => $asignHostel // Set initial values from $asignHostel
         ));
         ?>

         <b>Hostel Fees Management </b><br>
         <?php
         if (date('Y', strtotime($asignHostel['checkin_date'])) != '1970') { ?>
            <b>Check-In Date:-(<?= date('d-m-Y', strtotime($asignHostel['checkin_date'])); ?>)</b>
         <?php } ?>



         <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
            <tbody>
               <tr class="table_header">
                  <th class="text-left bg-teal color-palette"> Fee Heads</th>
                  <!-- <th class="text-center bg-teal color-palette"></th> -->
                  <th class="text-right bg-teal color-palette"> Fee </th>
               </tr>

               <tr>

                  <td>
                     <?= $this->Form->input('fees_head_id', [
                        'class' => 'form-control',
                        'required',
                        'options' => $hostalFeesHeads,
                        'empty' => 'Choose Hostel',
                        'disabled' => $asignHostel ? 'disabled' : null,
                     ]); ?>

                  </td>
                  <td>
                     <!-- Text field for another input -->
                     <?= $this->Form->input('amount', ['class' => 'form-control', 'type' => 'text', 'readonly', 'id' => 'fee_money', 'required']); ?>
                     <input type="hidden" name="studentId" value="<?php echo $id; ?>">
                     <input type="hidden" name="fee_head_name" id="fee_head_name">
                     <?php if ($asignHostel) { ?>
                        <input type="hidden" name="data_id" value="<?php echo $asignHostel['id']; ?>">
                     <?php } ?>
                  </td>

               </tr>

               <tr>
                  <td colspan="6" class="text-left" style="font-weight:bold;font-size: 18px;">
                     <input type="checkbox" name="tikremarks" id="checkborx1" value="1"> Is Remark?
                  </td>
               </tr>

               <tr>
                  <td colspan="6">
                     <textarea style="display:none;" id="textbox1" rows="2" cols="84" name="remarks_lwt"></textarea>
                  </td>
               </tr>

            </tbody>

         </table>

         <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
            <tbody>
               <tr class="table_header">
                  <th class="bg-teal color-palette">#</th>
                  <th class="bg-teal color-palette">Head</th>
                  <th class="bg-teal color-palette">Amount</th>
                  <th class="bg-teal color-palette"> Check In Date </th>
                  <th class="bg-teal color-palette"> Check Out Date </th>
               </tr>
               <?php if ($getHostalData) {
                  $count = 1;
                  foreach ($getHostalData as $key => $value) {  ?>

                     <tr>
                        <td><?= $count++; ?></td>
                        <td><?= $value['fee_head_name']; ?></td>
                        <td><?= $value['amount']; ?></td>
                        <td><?= date('d-m-Y', strtotime($value['checkin_date'])); ?></td>
                        <td><?= date('d-m-Y', strtotime($value['checkout_date'])); ?></td>
                     </tr>

                  <?php  }
               } else { ?>
                  <tr>
                     <td colspan="5" style="text-align:center;">No Data Available</td>
                  </tr>


               <?php  } ?>

            </tbody>
         </table>

         <button data-dismiss="modal" class="btn btn-default pull-left" type="button">Cancel</button>

         <input type="submit" name="submit" value="<?php echo $asignHostel ? 'Check Out' : 'Check In'; ?>" class="btn <?php echo $asignHostel ? 'btn-danger' : 'btn-info'; ?> pull-right">

         <!-- <input type="submit" name="submit" value="Check In" class="btn btn-info pull-right"> -->
         <!-- <input type="submit" name="submit" value="Check Out" class="btn btn-danger pull-right"> -->

         <?php
         echo $this->Form->end();
         ?>

      </div>
   </div>

</div>


<script>
   $('#checkborx1').change(function() {
      if (this.checked) {
         $('#textbox1').show().prop('required', true);
      } else {
         $('#textbox1').hide().prop('required', false);
      }
   });

   //  <!-- check fees by hostel  -->

   $('#fees-head-id').on('change', function() {
      // var id = $('#fees-head-id').val();
      var selectedOption = $('#fees-head-id option:selected');
      var id = selectedOption.val();
      var name = selectedOption.text();
      $('#fee_head_name').val(name);

      if (id) {

         $.ajax({
            type: 'POST',
            url: "<?php echo SITE_URL ?>admin/students/find_hostal_fee",
            data: {
               'id': id
            },
            beforeSend: function(xhr) {
               xhr.setRequestHeader('X-CSRF-Token', $(
                  '[name="_csrfToken"]').val())
            },
            success: function(data) {
               $('#fee_money').empty();
               $('#fee_money').val(data);
            },
         });
      } else {
         $('#fee_money').val('');
      }
   });
</script>