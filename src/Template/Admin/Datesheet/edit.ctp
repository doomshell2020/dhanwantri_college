<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Edit DateSheet
    </h1>
    <ol class="breadcrumb">
    <li><a href="<?php echo ADMIN_URL; ?>dashboards/"><i class="fa fa-home"></i>Home</a></li>
    <li><a href="#">Edit DateSheet</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <!-- /.box-header -->

          <div class="box-body">

            <?php echo $this->Form->create($sheet_det, array('class' => 'form-horizontal', 'controller' => 'Datesheet', 'action' => 'edit/' . $sheet_det['id'], 'onsubmit' => 'return ValidateExtension(this);', 'enctype' => 'multipart/form-data')); ?>

            <div class="form-group">
              <div class="col-sm-3">
                <label>Select Class<span>
                    <font color="red"> *</font>
                  </span></label>
                <select name="class_id[]" required="required" class="form-control" multiple="multiple">
                  <option value="0">--Select Class--</option>
                  <?php $class = explode(',', $sheet_det['class_id']);?>
                  <?php foreach ($class_id as $jk => $rt) {
    ?>
                  <option value="<?echo $jk; ?>" <?if (in_array($jk, $class)) {?>selected
                    <?}?> >
                    <?echo $rt; ?>
                  </option>



                  <?}?>
                </select>

              </div>

              <div class="col-sm-3">
                <label>Name<span>
                    <font color="red"> *</font>
                  </span></label>
                <?php echo $this->Form->input('title', array('class' => 'form-control', 'placeholder' => 'Enter Album Name', 'type' => 'text', 'id' => 'title', 'label' => false,
    'required')); ?>
              </div>

              <div class="col-sm-3">
                <label>Select DateSheet<span>
                    <font color="red"> *</font>
                  </span></label>
                <?php echo $this->Form->input('sheet_name', array('class' => 'form-control file', 'id' => 'imagename', 'type' => 'file', 'label' => false)); ?>

              </div>
            </div>
            <script>
            $(function() {
              $("#imagename").change(function() {
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.pdf|.doc|.docx)$/;
                if (regex.test($(this).val().toLowerCase())) {
                  return true;

                } else {
                  $('#imagename').val('');
                  alert("Please upload a valid image file.");
                }
              });
            });
            </script>
            <div class="form-group">
              <div class="col-sm-3">
                <label>Start Date<span>
                    <font color="red"> *</font>
                  </span></label>
                <?php echo $this->Form->input('start_date', array('class' => 'form-control file', 'id' => 'datepicker1', 'type' => 'text', 'label' => false, 'required')); ?>
              </div>
              <div class="col-sm-3">
                <label>End Date<span>
                    <font color="red"> *</font>
                  </span></label>
                <?php echo $this->Form->input('end_date', array('class' => 'form-control file', 'id' => 'datepicker2', 'type' => 'text', 'label' => false, 'required')); ?>

              </div>

            </div>
            <script>
            $(document).ready(function() {
              var edit = '<?php echo date('Y-m-d', strtotime($sheet_det['start_date'])); ?>';
              $("#datepicker1").val(edit);
              var edit1 = '<?php echo date('Y-m-d', strtotime($sheet_det['end_date'])); ?>';
              $("#datepicker2").val(edit1);
              $('#datepicker1').datepicker({
                dateFormat: 'yy-mm-dd',

                onSelect: function(date) {

                  var selectedDate = new Date(date);
                  var endDate = new Date(selectedDate);
                  endDate.setDate(endDate.getDate());

                  $("#datepicker2").datepicker("option", "minDate", endDate);
                  //$("#datepicker2").val(date);
                }

              });




              $('#datepicker2').datepicker({
                dateFormat: 'yy-mm-dd'
              });

            });
            </script>

            <div class="form-group">



              <div class="col-sm-6">


                <button type="submit" style="margin-top: 23px;" class="btn btn-success">Update</button>
                <button type="reset" style="margin-top: 23px;" class="btn btn-primary">Reset</button>


              </div>

            </div>

            <?php echo $this->Form->end(); ?>

          </div>

        </div>
      </div>
    </div>
</div>
</section>