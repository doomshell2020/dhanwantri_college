<div class="content-wrapper">
  <section class="content-header">
    <h1 style="margin-bottom:10px !important">Daily Staff Attendance Report </h1>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="box">
          <div class="box-header">
            <h4 class="box-title" style="margin:0px !important">Report Search</h4>
          </div>
          <?php echo $this->Form->create('', array('class' => '', 'id' => 'sevice_form1', 'enctype' => 'multipart/form-data', 'validate', 'autocomplete' => 'off')); ?>
          <div class="box-body">
            <div class="row" style="display:flex; flex-wrap:wrap; align-items:flex-end">
              <div class="col-md-4">
                <div>
                  <label class="control-label">Date:<span style="color:red;">*</span></label>
                  <?php echo $this->Form->input('date', array('class' => 'form-control', 'required', 'id' => 'datepicker', 'value' => date('d-m-Y'), 'label' => false)); ?>
                </div>
              </div>
              <script>
                  $(function() {
                    $("#datepicker").datepicker({
                      dateFormat: 'yy-mm-dd',
                      maxDate: '0'
                    });
                    $('#datepicker').datepicker('setDate', 'today');
                  });
              </script>
              <div class="col-md-4">
                  <label>Type:<span style="color:red;">*</span></label>
                  <div style="display:flex;align-items:center">
                    <label class="form-control" style="margin-right:10px; margin-bottom:0px;"><input type="radio" name="status" value="R" checked="checked" style="vertical-align:-2px;"> All</label>
                    <label class="form-control" style="margin-right:10px; margin-bottom:0px;"><input type="radio" name="status" value="P" style="vertical-align:-2px;"> Present</label>
                    <label class="form-control" style="margin-right:10px; margin-bottom:0px;"><input type="radio" name="status" value="A" style="vertical-align:-2px;"> Absent</label>
                  </div>
              </div>
              <div class="col-md-4">
                  <?php echo $this->Form->submit('Submit', array('class' => 'btn btn-info pull-left', 'style' => '', 'title' => 'Submit'));
                    echo $this->Form->end(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row" style="display:none" id="src-rslt">
      <div class="col-sm-12">
          <div class="box" id="updt"></div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="box" id="report">
          <div class="box-header">
            <i class="fa fa-search" aria-hidden="true"></i>
            <h3 class="box-title">View Details</h3>
            <a href="<?php echo ADMIN_URL; ?>Employeeattendance/atn_report_excel" class = "btn btn-info pull-right">Export To Excel</a>
          </div>
          <div class="box-body" id="example12">
            <div id="load2" style="display:none;"></div>
            <!-- <div id="example12"> -->
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Teacher's Name</th>
                    <th>A0</th>
                    <th>A1</th>
                    <th>A2</th>
                    <th>A3</th>
                    <th>A4</th>
                    <th>A5</th>
                    <th>A6</th>
                    <th>A7</th>
                  </tr>
                </thead>
                <?php $date = date('d-m-Y');
                  //pr($students);die;?>
                <tbody id="example2">
                  <?php $page = $this->request->params['paging']['Services']['page'];
                    $limit = $this->request->params['paging']['Services']['perPage'];
                    $counter = ($page * $limit) - $limit + 1;
                    if (isset($students) && !empty($students)) {
                      foreach ($students as $service) { //pr($service);
                        $absent = array();
                        $present = array();
                        $att_exist = $this->Comman->findEmployeeAttendanceReport($service['id']);
                        //pr($att_exist);die;
                        if (!empty($att_exist['absent_periods'])) {
                            $absent = explode(',', $att_exist['absent_periods']);
                        }
                        if (!empty($att_exist['present_periods'])) {
                            $present = explode(',', $att_exist['present_periods']);
                        }
                        //pr($absent);die;
                  ?>
                    <tr <?php if (!empty($absent) && isset($absent)) {?> style="color:red;" <?php }?>>
                      <td><?php echo $counter; ?></td>
                      <td>
                        <?php echo $date; ?>
                      </td>
                      <td><?php if (isset($service['fname'])) {?>
                        <?php echo strtoupper($service['fname']) . "\x20" . strtoupper($service['middlename']) . strtoupper($service['lname']); ?>
                        <?php } else {echo 'N/A';}?>
                      </td>
                      <td><?php if (in_array('A0', $absent)) {?><span style="color:red">A</span><?php } else if (in_array('A0', $present)) {?><span
                        style="color:green">P</span><?php } else {echo "N/A";}?>
                      </td>
                      <td><?php if (in_array('A1', $absent)) {?><span style="color:red">A</span><?php } else if (in_array('A1', $present)) {?><span
                        style="color:green">P</span><?php } else {echo "N/A";}?>
                      </td>
                      <td><?php if (in_array('A2', $absent)) {?><span style="color:red">A</span><?php } else if (in_array('A2', $present)) {?><span
                        style="color:green">P</span><?php } else {echo "N/A";}?>
                      </td>
                      <td><?php if (in_array('A3', $absent)) {?><span style="color:red">A</span><?php } else if (in_array('A3', $present)) {?><span
                        style="color:green">P</span><?php } else {echo "N/A";}?>
                      </td>
                      <td><?php if (in_array('A4', $absent)) {?><span style="color:red">A</span><?php } else if (in_array('A4', $present)) {?><span
                        style="color:green">P</span><?php } else {echo "N/A";}?>
                      </td>
                      <td><?php if (in_array('A5', $absent)) {?><span style="color:red">A</span><?php } else if (in_array('A5', $present)) {?><span
                        style="color:green">P</span><?php } else {echo "N/A";}?>
                      </td>
                      <td><?php if (in_array('A6', $absent)) {?><span style="color:red">A</span><?php } else if (in_array('A6', $present)) {?><span
                        style="color:green">P</span><?php } else {echo "N/A";}?>
                      </td>
                      <td><?php if (in_array('A7', $absent)) {?><span style="color:red">A</span><?php } else if (in_array('A7', $present)) {?><span
                        style="color:green">P</span><?php } else {echo "N/A";}?>
                      </td>
                    </tr>
                  <?php $counter++;
                      }} else {?>
                  <tr>
                      <td colspan="11">NO Data Available</td>
                  </tr>
                  <?php }?>
                </tbody>
            </table>

            <?php if ($oid) {?>
            <script type="text/javascript">
              $('#<?php echo $oid; ?>')[0].click();
            </script>
            <?php }?>

            <!-- </div> -->
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script inline="1">
  $(document).ready(function() {
  
    $("#sevice_form1").bind("submit", function(event) {
      $.ajax({
        async: true,
        data: $("#sevice_form1").serialize(),
        dataType: "html",
        type: "POST",
        beforeSend: function() {
          //Show image container
          $("#loader").show();
        },
        url: "<?php echo ADMIN_URL; ?>Employeeattendance/report_search",
  
        success: function(data) {
          //alert(data);
          $('#src-rslt').show();
          $('#report').hide();
          $("#updt").html(data);
        },
  
      });
  
      return false;
    });
  });
  //]]>
</script>