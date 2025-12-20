<?php $role_id = $this->request->session()->read('Auth.User.role_id');
   $db = $this->request->session()->read('Auth.User.db'); ?>
<?php $counter = 1;
   if (isset($students) && !empty($students)) {
   	foreach ($students as $work) {
   ?>
<tr>
   <?php if ($role_id == '5' || $role_id == '8' || $role_id == '6') {
      ?> 
   <!-- <td><input type="checkbox" class="emp_id checkboxs" name="id[]" value=<?php  // echo $work['id'];
      ?>></td> -->
   <?php } ?>
   <td><?php echo $counter; ?></td>
   <td> <?php if ($work['file']) {  ?>
      <img src="<?php echo SITE_URL; ?>/employees/<?php echo $work['file']; ?>" height="100px" width="100px">
      <?php } else { ?>
      <img src="<?php echo SITE_URL; ?>images/NOIMAGE.JPG" height="100px" width="100px">
      <?php } ?>
   </td>
   <td>
      <?php if ($role_id == '1'  || $role_id == '5' || $role_id == '8') { ?>
      <a href="<?php echo SITE_URL; ?>admin/employees/view/<?php echo $work['id']; ?>"> 
      <?php echo ucfirst(strtolower($work['fname'])); ?> <?php echo ucfirst(strtolower($work['middlename'])); ?> <?php echo ucfirst(strtolower($work['lname'])); ?></a> <br> <b>Department :</b><?php echo $work['department']['name']; ?> <br> <b>Designations</b> : <?php echo $work['designation']['name']; ?>
      <?php } else {  ?> 
      <a href="<?php echo SITE_URL; ?>admin/employees/view/<?php echo $work['id']; ?>"> 
      <?php echo ucfirst(strtolower($work['fname'])); ?> <?php echo ucfirst(strtolower($work['middlename'])); ?> <?php echo ucfirst(strtolower($work['lname'])); ?><?php } ?></a><br> <b>Qualification :</b><?php echo $work['department']['name']; ?> <br> <b>Designations</b> : <?php echo $work['designation']['name']; ?>
   </td>
   <td><?php echo $work['username']; ?></td>
   <td><?php echo $work['mobile']; ?></td>
   <td><?php echo $work['f_h_name']; ?></td>
   <td><?php echo date('d-m-Y', strtotime($work['dob'])); ?></td>
   <td><?php echo date('d-m-Y', strtotime($work['joiningdate'])); ?></td>
   <td>
      <?php if ($role_id == '1' || $role_id == '5' || $role_id == '8' || $role_id == '6' || $role_id == '105') {
         ?>
      <a href="<?php echo SITE_URL; ?>admin/employees/emp_edit/<?php echo $work['id']; ?>"><i class="fas fa-edit" style="font-size: 16px !important;" aria-hidden="true"></i></a>
      <a class="drop" data-id="<?php echo $work['id']; ?>" data-name="<?php echo ucfirst($work['fname'] . ' ' . $work['middlename'] . ' ' . $work['lname']); ?>" title="Drop out"><i class="fa fa-ban fa-1x" style="font-size: 16px !important;" aria-hidden="true"></i></a>
      <?php
         }
         ?>
      <?php
         echo $this->Html->link('', ['action' => 'delete', $work->id], ['class' => 'fas fa-trash-alt', 'style' => 'font-size: 16px !important; color:#cd0404; margin-right:4px !important;', "onClick" => "javascript: return confirm('Are you sure you want to delete this Employee')"]);
         ?>
   </td>
</tr>
<?php $counter++;
   }
   } else { ?>
<tr>
   <td colspan="10" style="text-align:center;">NO Data Available</td>
</tr>
<?php } ?>