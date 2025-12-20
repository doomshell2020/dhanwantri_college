
<div class="table-responsive">
  <div id="load2" style="display:none;"></div>
  <table id="example1 updt" class="table table-bordered table-striped">
  <tr>
      <td><a id="" style="position: absolute;
top: -33px;
/* right: 0px; */
right: 46px;" class="btn btn-info btn-sm pull-right" target="_blank"
          href="<?php echo ADMIN_URL; ?>Employeeattendance/substitute_pdf/<?php echo $date ?>"><i class="fa fa-file-excel-o" aria-hidden="true"></i>
          Export To PDF</a></td>
    </tr>
    <thead>
      <th>Sr.No.</th>
      <th>Teacher's Name</th>
      <th>A0</th>
      <th>A1</th>
      <th>A2</th>
      <th>A3</th>
      <th>A4</th>
      <th>A5</th>
      <th>A6</th>
      <th>A7</th>
    </thead>
    <tbody>
      <?php if (isset($emp_det) && !empty($emp_det)) {?>
      <?php $i = 1;
    foreach ($emp_det as $emp_value) {?>
      <tr>
        <td><?php echo $i; ?></td>
        <td style="color:red"><B><?php $name = $this->Comman->findempname($emp_value['employee_id']);
        echo strtoupper($name['fname']) . "\x20" . strtoupper($name['middlename']) . strtoupper($name['lname']);?></b></td>

        <?php $sub_chk = array();
        foreach ($periods as $per_value) {
            if ($per_value['id'] != 8) {
                $per_name = $per_value['name'][0];

                $sub_chk = $this->Comman->checksubstitute_date($per_value['id'], $emp_value['employee_id'], $date);
                if (!empty($sub_chk)) {
                    $class = $this->Comman->findclass($sub_chk['class_id']);
                    $section = $this->Comman->findsecti($sub_chk['sec_id']);
                    $empname = $this->Comman->findempname($sub_chk['new_empid']);
                    ?> <td>
          <?php echo $class['title'] . '-' . $section['title'] . '(' . $empname['fname'] . "\x20" . $empname['middlename'] . $empname['lname'] . ')'; ?> <?php

                } else {?>
        <td>--</td><?php }

                ?>
        <?php }?>
        <?php }?>
      </tr>
      <?php $i++;}}
      else{ ?>
		  <tr>
		  <td>No Data Available</td>
		  </tr>
		  
		<?php  }
      
      ?>
    </tbody>
  </table>
</div>
