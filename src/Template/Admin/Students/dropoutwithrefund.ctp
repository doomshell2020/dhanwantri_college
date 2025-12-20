<?php
$getFeesDetails = $this->Comman->getstudenttotalfeesdetails($student);

// Calculate total deposited and discount
$totalDeposit = 0;
$totalDiscount = 0;

foreach ($getFeesDetails as $key => $val) {
   if (strpos($key, '_deposite') !== false && is_numeric($val)) {
      $totalDeposit += $val;
   }

   if (strpos($key, '_discount') !== false && is_numeric($val)) {
      $totalDiscount += $val;
   }
}
?>

<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button">
      <span aria-hidden="true">×</span>
   </button>
   <h4 class="modal-title">
      <i class="fa fa-info-circle" aria-hidden="true"></i> Refund Details of <?= ucwords(strtolower($name)); ?> (<?= $enroll; ?>)
   </h4>
</div>

<?= $this->Form->create('Students', [
   'action' => 'dropwithrefund',
   'type' => 'file',
   'inputDefaults' => ['div' => false, 'label' => false],
   'class' => 'form-horizontal'
]); ?>

<div class="modal-body">
   <div class="container-fluid">
      <div class="row mb-3">
         <div class="col-md-6">
            <label><strong>Total Deposited Amount:</strong></label>
            <input type="text" class="form-control" name="total_deposited_amount" value="<?= $totalDeposit; ?>" readonly id="total_deposit">
         </div>
         <div class="col-md-6">
            <label><strong>Total Discount Given:</strong></label>
            <input type="text" class="form-control" value="<?= $totalDiscount; ?>" readonly>
         </div>
      </div>

      <div class="row mb-3">
         <div class="col-md-6">
            <label for="refund_fee_amount">Refund Amount (Fee)</label>
            <input type="number" min="0" step="0.01" name="refund_fee_amount" id="refund_fee_amount" class="form-control" required>
         </div>
         <div class="col-md-6">
            <label for="refund_fee_amount">Payment Mode</label>
            <select name="payment_mode" id="payment_mode" class="form-control" required>
               <option value="">Select Payment Mode</option>
               <option value="CASH">Cash</option>
               <option value="Bank Transfer">Bank Transfer</option>
               <option value="DD">DD</option>
               <option value="CHEQUE">Cheque</option>
               <option value="NETBANKING">NETBANKING</option>
               <option value="Credit Card/Debit Card/UPI">Credit Card/Debit Card/UPI</option>
            </select>
         </div>
         <div class="row-mb-12" id="reference_number_section" style="display: none;">
            <div class="col-md-12">
               <label for="ref_no">Reference Number</label>
               <input type="text" name="ref_no" id="ref_no" class="form-control">
            </div>
         </div>

         <script>
            document.getElementById('payment_mode').addEventListener('change', function() {
               const mode = this.value;
               const refSection = document.getElementById('reference_number_section');
               const refInput = document.getElementById('ref_no');

               if (mode === 'CASH' || mode === '') {
                  refSection.style.display = 'none';
                  refInput.removeAttribute('required');
                  refInput.value = '';
               } else {
                  refSection.style.display = 'block';
                  refInput.setAttribute('required', 'required');
               }
            });
         </script>

      </div>

      <div class="row mb-3">
         <div class="col-md-12">
            <label for="remarks_lwt">Remarks</label>
            <textarea name="remarks_lwt" rows="3" class="form-control" placeholder="Enter any remarks..."></textarea>
         </div>
      </div>

      <input type="hidden" name="studentId" value="<?= $id; ?>">
   </div>
</div>

<div class="modal-footer">
   <input type="submit" name="submit" value="Submit Refund" class="btn btn-success">
   <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
</div>

<?= $this->Form->end(); ?>

<script>
   $(document).ready(function() {
      function validateRefund() {
         const totalDeposit = parseFloat($('#total_deposit').val()) || 0;
         const feeRefund = parseFloat($('#refund_fee_amount').val()) || 0;

         if ((feeRefund) > totalDeposit) {
            alert("Total refund amount cannot exceed the deposited amount.");
            $('#refund_fee_amount').val('');
         }
      }

      $('#refund_fee_amount').on('input', validateRefund);
   });
</script>