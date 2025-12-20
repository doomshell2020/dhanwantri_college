<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title">
      <i class="fa fa-ban" aria-hidden="true"></i> Pending Detail of <? echo ucwords(strtolower($name)); ?> (<? echo $enroll; ?>)
   </h4>
</div>
<div class="modal-body">
   <div class="row">
      <div class="col-sm-12">
         <h2 class="text-center"><b>Pending Detail</b></h2>
         <table class="table">
            <thead>
               <tr>
                  <th>Total Fees</th>
                  <th>Total Discount</th>
                  <th>Total Paid</th>
                  <th>Total Pending</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $getFeesDetails = $this->Comman->getstudentfeesdetails($student);
               ?>
               <tr>
                  <td><?= $getFeesDetails['totalFeesToPay']; ?></td>
                  <td><?= $getFeesDetails['discount']; ?></td>
                  <td><?= $getFeesDetails['totalFeesPay']; ?></td>
                  <td><?= $getFeesDetails['totalPending']; ?></td>
               </tr>
            </tbody>
         </table>
      </div>

   </div>
   <script>
      $('#checkborx1').change(function() {
         if (this.checked) {
            $('#textbox1').show();
         } else {
            $('#textbox1').hide();
         }

      });
   </script>
</div>
<div class="modal-footer">
   <?php echo $this->Form->create('Task', array('action' => 'dropsubmit', 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => '', 'class' => 'form-horizontal')); ?>
   <table>
      <tbody>
         <tr>
            <td colspan="6" class="text-left" style="font-weight:bold;font-size: 18px;">
               <input type="checkbox" name="tikremarks" id="checkborx1" value="1"> Is Remark?
               <input type="hidden" name="id" id="" value="<?php echo $id; ?>">
            </td>
         </tr>
         <tr>
            <td colspan="6" class="text-right"><textarea style="display:none;" id="textbox1" rows="2" cols="80" name="remarks_lwt"></textarea></td>
         </tr>
      </tbody>
   </table>
   <input type="submit" name="submit" value="Drop out ?" class="btn btn-info pull-left">
   <button data-dismiss="modal" class="btn btn-default pull-right" type="button">Cancel</button>
   <?php
   echo $this->Form->end();
   ?>
</div>