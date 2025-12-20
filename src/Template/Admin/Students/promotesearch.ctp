<input type="hidden" name="year" value="<?php echo $year; ?>">
<input type="hidden" name="class" value="<?php echo $class; ?>">
<input type="hidden" name="section" value="<?php echo $section; ?>">
<?php $page = $this->request->params['paging']['Students']['page'];
$limit = $this->request->params['paging']['Students']['perPage'];
$counter = ($page * $limit) - $limit + 1;
$cnt = 1;
if (isset($students) && !empty($students)) {
   foreach ($students as $work) {  //pr($work);exit; 
?>
      <tr>
         <td><input type="checkbox" id="chk12009" class="StuAttendCk" name="stud_id[]" value="<?php echo $work['id']; ?>">
         </td>
         <td><?php echo $cnt++; ?></td>
         <td><?php echo $work['enroll']; ?></td>
         <td><a target="_blank" href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $work['id']; ?>"><? echo ucwords(strtolower($work['st_full_name'])); ?> </a></td>
         <td>
            <?php echo ucwords(strtolower($work['fathername'])); ?>
         </td>
         <td><?php echo $work['mobile']; ?></td>
         <td><?php echo $work['acedmicyear']; ?></td>
         <td><?php echo $work['class']['title']; ?></td>
         <td><?php echo $work['section']['title']; ?></td>
         <td>
            <?php if ($work['category'] == "RTE") {
               echo "<b style='color:red;'>--RTE--</b>";
            } else {
               echo $work['due_fees'];
            }
            ?>
         </td>
         <td><span class="label bg-blue">In Progress</span></td>
         <td><?php if ($work['status'] == 'Y') {
               ?>
               <span class="label label-success">Active</span>
            <?php } else {
            ?>
               <span class="label label-primary">Deactivate</span>
            <?php  } ?>
         </td>
      </tr>
   <?php $counter++;
   }
} else { ?>
   <tr>
      <td colspan="12" style="text-align:center;">NO Data Available</td>
   </tr>
<?php } ?>