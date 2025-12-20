<?php $page = $this->request->params['paging']['Students']['page'];
$limit = $this->request->params['paging']['Students']['perPage'];
$counter = ($page * $limit) - $limit + 1;

if (isset($student_data) && !empty($student_data)) {
  foreach ($student_data as $work) { //pr($work);
?>
    <tr>
      <td><?php echo $counter; ?></td>
      <td><?php echo $work['scholar_no']; ?></td>
      <td><?php echo $work['name']; ?></td>
      <td><?php echo $work['f_mobile']; ?></td>
      <td><?php echo $work['m_mobile']; ?></td>
      <td><?php echo date('Y-m-d', strtotime($work['admission_date'])); ?></td>
      <td><?php echo $work['class']; ?></td>
      <td><?php echo $work['section']; ?></td>
      <td><?php echo $work['fname']; ?></td>
      <td><?php echo $work['mname']; ?></td>
      <td><?php $branch_name = explode('_', $work['branch_name']);
          echo ucfirst($branch_name[1]); ?>
      </td>

    </tr>
  <?php $counter++;
  }
} else { ?>
  <tr>
    <td colspan="11" style="text-align:center;">NO Data Available</td>
  </tr>
<?php } ?>