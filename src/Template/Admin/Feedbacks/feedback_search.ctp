<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>S.No.</th>
      <th>Date</th>
      <th>Given FeedBack</th>
      <th>Class</th>
      <th>Section</th>
      <th>FeedBack Category</th>
      <th>Feedback</th>
      <th>Contact No.</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $cnt = 1;
    foreach ($feedbacks as $feedback) {
    ?>
      <tr>
        <td><?php echo $cnt; ?></td>
        <td><?php echo date('d-m-Y', strtotime($feedback['created'])); ?></td>
        <td><?php
            if ($feedback['student']['fname']) {
              echo $feedback['student']['fname'] . ' ' . $feedback['student']['middlename'] . ' ' . $feedback['lname'];
            } else {
              echo $feedback['student_name'];
            }
            ?></td>
        <td><?php
            if ($feedback['class']) {

              echo $feedback['class'];
            } else {

              echo "-";
            }

            ?></td>
        <td><?php

            if ($feedback['section']) {
              echo $feedback['section'];
            } else {
              echo "-";
            }
            ?></td>
        <td><?php echo $feedback['feedback_cat']['name']; ?></td>
        <td><?php echo $feedback['feedback']; ?></td>
        <td><?php echo $feedback['phone']; ?></td>
        <td><?php echo $feedback['status'] == 'N' ? 'Open' : 'Close'; ?></td>
        <td><?php if ($feedback['status'] == 'N') { ?> <a title="Cancel" class="modalcancel pull-right btn btn-info" style="margin-left:10px;" data-toggle="modal" data-val="<?php echo $feedback['id']; ?>" data-target="#delete_Modal">Close</a> <?php } ?></td>
      </tr>
    <?php $cnt++;
    } ?>
    <?php /*
if (empty($gatepasses)) {?>
<tr><td colspan="9">No Gatepass Request forToday</td></tr>
<?php } */ ?>

  </tbody>

</table>