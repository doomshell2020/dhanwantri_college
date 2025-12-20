<div class="row" id="updt" class="table-responsive">
   <div class="col-lg-12">
      <form id="studttendance-form" action="<?php echo SITE_URL; ?>admin/Students/addstaffattendance" method="post">
         <table class="table table-striped table-hover" id="mytable">
            <tbody>
               <tr class="table_header" style="color: green;">
            <thead>
               <th>
                  <?php if (isset($attedenceall) && !empty($attedenceall)) { ?>
                  <input type="checkbox" class="check-all" checked=""> For Absent
                  <?php } else { ?>
                  <input type="checkbox" class="check-all"> For Absent
                  <?php } ?>
               </th>
               <th> Staff Name </th>
            </thead>
            </tr>
            <?php if (isset($attedenceall) && !empty($attedenceall)) {
               foreach ($attedenceall as $work) {
               ?>
            <tr class="stuname" style="cursor:pointer;">
               <td>
                  <?php if ($dates) { ?>
                  <input type="hidden" name="date" required="required" class="datepicks" value="<?php echo $dates; ?>">
                  <?php } else {?>
                  <input type="hidden" name="date" required="required" class="datepicks" value="<?php echo date('Y-m-d'); ?>">
                  <?php } ?>
                  <input type="hidden" name="academic" class="" value="<?php echo $academic; ?>">
                  <label><input type="checkbox" id="chk<?php echo $work['id']; ?>" class="StuAttendCk" name="emp_id[]" value="<?php echo $work['emp_id']; ?>" <?php if ($work['status'] == 'A') { ?>checked="checked" <?php } ?>> </label>
               </td>
               <td><b><?php echo $work['employee']['fname']; ?> <?php echo $work['employee']['middlename']; ?> <?php echo $work['employee']['lname']; ?></b></td>
            </tr>
            <?php }
               } else {
                   if (isset($studentsarry) && !empty($studentsarry)) {
                       foreach ($studentsarry as $krrt => $work) {
                       ?>
            <tr class="stunames" style="cursor:pointer;">
               <td>
                  <?php if ($dates) { ?>
                  <input type="hidden" name="date" required="required" class="datepicks" value="<?php echo $dates; ?>">
                  <?php } else { ?>
                  <input type="hidden" name="date" required="required" class="datepicks" value="<?php echo date('Y-m-d'); ?>">
                  <?php } ?>
                  <input type="hidden" name="academic" class="" value="<?php echo $academic; ?>">
                  <label><input type="checkbox" id="chk<?php echo $work['id']; ?>" class="StuAttendCk" name="emp_id[]" value="<?php echo $work['id']; ?>"> </label>
               </td>
               <td>
                  <b><?php echo $work['fname']; ?> <?php echo $work['middlename']; ?> <?php echo $work['lname']; ?></b>
               </td>
            </tr>
            <?php }
               }
               } ?>
            </tbody>
         </table>
         <?php echo $this->Form->submit(
            'Take Attendance',
            array('class' => 'btn btn-info pull-right', 'title' => 'Update')
            ); ?>
      </form>
   </div>
</div>