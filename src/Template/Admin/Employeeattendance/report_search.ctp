<div class="box-header col-sm-12">
  <i class="fa fa-search" aria-hidden="true"></i>
  <h4 class="box-title">Search Attendance Report</h4>
  <a href="<?php echo ADMIN_URL; ?>Employeeattendance/atn_report_excel/<?php echo $date; ?>"
    class="btn btn-info pull-right">Export To Excel</a>

</div>
<div class="box-body">
  <div class="example2">



    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr style="background-color:#39cccc !important; color:white">
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
      <?php //$date = date('d-m-Y');
//pr($students);die;?>

      <tbody id="example2">
        <?php $page = $this->request->params['paging']['Services']['page'];
$limit = $this->request->params['paging']['Services']['perPage'];
$counter = ($page * $limit) - $limit + 1;
if (isset($employees) && !empty($employees)) {

    foreach ($employees as $service) { //pr($service);
        $absent = array();
        $present = array();

        if (!empty($service['absent_periods'])) {
            $absent = explode(',', $service['absent_periods']);
        }
        if (!empty($service['present_periods'])) {
            $present = explode(',', $service['present_periods']);
        }
        //pr($absent);die;
        ?>
        <tr <?php if (!empty($absent) && isset($absent)) {?> style="color:red;" <?php }?>>
          <td><?php echo $counter; ?></td>
          <td>
            <?php echo $date1; ?>
          </td>
          <td><?php if (isset($service['employee']['fname'])) {?>
            <?php echo strtoupper($service['employee']['fname']) . "\x20" . strtoupper($service['employee']['middlename']) . strtoupper($service['employee']['lname']); ?>
            <?php } else {echo 'N/A';}?>
          </td>

          <td><?php if (in_array('A0', $absent)) {?><span style="color:red">A</span><?php } else {?><span
              style="color:green">P</span><?php }?>
          </td>
          <td><?php if (in_array('A1', $absent)) {?><span style="color:red">A</span><?php } else {?><span
              style="color:green">P</span><?php }?>
          </td>

          <td><?php if (in_array('A2', $absent)) {?><span style="color:red">A</span><?php } else {?><span
              style="color:green">P</span><?php }?>
          </td>
          <td><?php if (in_array('A3', $absent)) {?><span style="color:red">A</span><?php } else {?><span
              style="color:green">P</span><?php }?>
          </td>
          <td><?php if (in_array('A4', $absent)) {?><span style="color:red">A</span><?php } else {?><span
              style="color:green">P</span><?php }?>
          </td>

          <td><?php if (in_array('A5', $absent)) {?><span style="color:red">A</span><?php } else {?><span
              style="color:green">P</span><?php }?>
          </td>
          <td><?php if (in_array('A6', $absent)) {?><span style="color:red">A</span><?php } else {?><span
              style="color:green">P</span><?php }?>
          </td>
          <td><?php if (in_array('A7', $absent)) {?><span style="color:red">A</span><?php } else {?><span
              style="color:green">P</span><?php }?>
          </td>


        </tr>
        <?php $counter++;

    }} else {?>
        <tr>
          <td colspan="6">NO Data Available</td>
        </tr>
        <?php }?>
      </tbody>

    </table>
  </div>
</div>