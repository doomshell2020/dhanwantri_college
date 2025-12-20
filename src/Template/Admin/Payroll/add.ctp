<!-- Content Wrapper. Contains page content -->
<script src="<?php echo SITE_URL; ?>js/admin/jquery.dataTables.mins.js"></script>
<script type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Employee Manager
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- right column -->
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">
              <?php if (isset($transports['id'])) {
                echo 'Edit Employee';
              } else {
                echo 'Add Employee';
              } ?></h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <?php echo $this->Flash->render(); ?>
          <?php echo $this->Form->create($transports, array(
            'class' => 'form-horizontal',
            'id' => 'sevice_form',
            'enctype' => 'multipart/form-data'
          )); //pr($transports); die; ?>
          <div class="box-body">
            <div class="form-group">

              <div class="field col-md-4" style="margin-bottom:15px;">
                <label class="control-label">Name</label>
                <?php echo $this->Form->input('name', array(
                  'class' =>
                    'longinput form-control',
                  'maxlength' => '20',
                  'required',
                  'placeholder' => 'Name',
                  'required',
                  'label' => false
                )); ?>
              </div>


              <div class="field col-md-4" style="margin-bottom:15px;">
                <label class="control-label">Gender</label>
                <div style="display:flex; align-items: center;">
                  <label class="radio-inline">
                    <input type="radio" name="gender" value="male" checked>Male
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="gender" value="female">Female
                  </label>
                </div>
              </div>


              <div class="field col-md-4" style="margin-bottom:15px;">
                <label class="control-label">DOB</label>
                <?php echo $this->Form->input('dob', array('class' => 'longinput form-control dob', 'required', 'placeholder' => 'Date of Birth', 'required', 'label' => false)); ?>
              </div>


              <div class="field col-md-4" style="margin-bottom:15px;">
                <label class="control-label">Contact Number</label>
                <?php echo $this->Form->input('cnum', array('class' => 'longinput form-control', 'required', 'placeholder' => 'Contact Number', 'required', 'onkeypress' => 'return testabc(event)', 'label' => false)); ?>
              </div>


              <div class="field col-md-4" style="margin-bottom:15px;">
                <label class="control-label">Address</label>
                <?php echo $this->Form->input('address', array('class' => 'longinput form-control', 'required', 'placeholder' => 'Address', 'required', 'label' => false)); ?>
              </div>


              <div class="field col-md-4" style="margin-bottom:15px;">
                <label class="control-label">Department</label>
                <!-- <?php echo $this->Form->input('departments', array(
                  'class' =>
                    'longinput form-control',
                  'type' => 'select',
                  'options' => $de,
                  'empty' => 'Select Department',
                  
                  'required',
                  'label' => false
                )); ?> -->



                <select class="form-control" name="departments" style="width: 100%;">
                  <option value="Medical" <?php if ($students['departments'] == 'Medical') { ?> selected="selected" <?php } ?>>Medical</option>
                  <option value="Teaching" <?php if ($students['departments'] == 'Teaching') { ?> selected="selected"
                    <?php } ?>>Teaching</option>
                 
                </select>
              </div>


              <div class="field col-md-4" style="margin-bottom:15px;">
                <label class="control-label">Bank Account No.</label>
                <?php  echo $this->Form->input('bankaccountno', array(
                  'class' =>
                    'longinput form-control',
                  'type' => 'text',
                  'placeholder' => 'Bank Account No.',
                  'label' => false
                )); ?>
              </div>

              <div class="field col-md-4" style="margin-bottom:15px;">
                <label class="control-label">Basic Salary</label>
                <?php echo $this->Form->input('basicsalary', array('class' => 'longinput form-control', 'required', 'placeholder' => 'Basic Salary', 'required', 'label' => false, 'onkeypress' => 'return testabc(event)')); ?>
              </div>


              <div class="field col-md-4" style="margin-bottom:15px;">
                <label class="control-label">DA(%)</label>

                <?php echo $this->Form->input('Da', array('class' => 'longinput form-control', 'required', 'placeholder' => 'DA', 'required', 'label' => false)); ?>
              </div>

              <div class="field col-md-4" style="margin-bottom:15px;">
                <label class="control-label">PF A/c No.</label>

                <?php echo $this->Form->input('pfnumber', array('class' => 'longinput form-control', 'required', 'placeholder' => 'PF A/c No.', 'required', 'label' => false)); ?>
              </div>
              <div class="field col-md-4" style="margin-bottom:15px; position: relative;">
                <label class="control-label">SD(%)</label>
                <?php echo $this->Form->input('sd', array('class' => 'longinput form-control', 'placeholder' => 'SD', 'label' => false)); ?>
                <span style="color: green; position: absolute; left: 15px; bottom: -20px;">Enter value in %</span>
              </div>

              <div class="field col-md-4" style="margin-bottom:15px;">
                <label class="control-label">UAN No.</label>
                <?php echo $this->Form->input('uan', array('class' => 'longinput form-control', 'required', 'placeholder' => 'UAN No.', 'maxlength' => '12', 'required', 'label' => false)); ?>
              </div>
              <div class="field col-md-4" style="margin-bottom:15px; margin-top:15px;">
                <label class="control-label">ESI No.</label>
                <?php echo $this->Form->input('esi', array('class' => 'longinput form-control', 'placeholder' => 'ESI No.', 'label' => false, 'required')); ?>
              </div>

              <div class=" col-md-8" style="margin-bottom:15px; margin-top:15px;">
                <label class="control-label">Charge Deduction</label>

                <div>
                  <label class="checkbox-inline"><input name="leve" type="checkbox" value="1" <?php if ($transports['leve'] == '1') { ?> checked <?php } ?>>Leave Deduction</label>
                  <label class="checkbox-inline"><input name="HRA" type="checkbox" value="1" <?php if ($transports['HRA'] == '1') { ?> checked <?php } ?>>HRA</label>
                  <label class="checkbox-inline"><input name="LTA" type="checkbox" value="1" <?php if ($transports['LTA'] == '1') { ?> checked <?php } ?>>LTA</label>
                  <label class="checkbox-inline"><input name="TA" type="checkbox" value="1" <?php if ($transports['TA'] == '1') { ?> checked <?php } ?>>TA</label>
                  <label class="checkbox-inline"><input name="PF" type="checkbox" value="1" <?php if ($transports['PF'] == '1') { ?> checked <?php } ?>>PF</label>
                  <label class="checkbox-inline"><input name="ESI_choice" type="checkbox" value="1" <?php if ($transports['ESI_choice'] == '1') { ?> checked <?php } ?>>ESI</label>
                  <label class="checkbox-inline"><input name="EPS" type="checkbox" value="1" <?php if ($transports['EPS'] == '1') { ?> checked <?php } ?>>EPS</label>
                </div>
              </div>
            </div>

            <div style="display: flex; justify-content: space-between;">
              <?php
              echo $this->Html->link('Back', [
                'action' => 'index'
              ], ['class' => 'btn btn-default']); ?>
              <?php
              if (isset($transports['id'])) {
                echo $this->Form->submit(
                  'Update',
                  array('class' => 'btn btn-info pull-right', 'title' => 'Update')
                );
              } else {
                echo $this->Form->submit(
                  'Add',
                  array('class' => 'btn btn-info pull-right', 'title' => 'Add')
                );
              }

              // pr($transports);die;
              ?>
            </div>
          </div>
          <?php echo $this->Form->end(); ?>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>

<script>
  $(document).ready(function () {
    $('#c-id').on('change', function () {
      var id = $('#c-id').val();
     alert(id);
      $.ajax({
        type: 'POST',
        url: '<?php echo ADMIN_URL; ?>cities/find_state',
        data: { 'id': id },
        success: function (data) {
          alert(data);
          $('#s-id').empty();
          $('#s-id').html(data);
        },

      });
    });
  });
  var site_url = '<?php echo SITE_URL; ?>';
  $(document).ready(function () {
    var date_input = $('input[name="dob"]'); //our date input has the name "date"
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    var options = {
      format: 'dd/mm/yyyy',
      container: container,
      todayHighlight: true,
      autoclose: true,
      changeYear: true,
      changeMonth: true,
      yearRange: "-100:+0",
    };
     date_input.datepicker(options);
  })
  function testabc(evt) {

    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;

    if (charCode != 46 && charCode != 45 && charCode > 31 && (charCode < 48 || charCode > 57)) {

      $('#valage').html("Enter only Numeric value");
      return false;
    }
    $('#valage').hide();
    return true;
  }
</script>