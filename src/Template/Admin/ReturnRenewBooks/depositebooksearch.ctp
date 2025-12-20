<?php
$session = $this->request->session();
$role_id = $session->read('Auth.User.role_id');
?>

<?php
$page = $this->request->params['paging']['books']['page'];
$limit = $this->request->params['paging']['books']['perPage'];
$counter = ($page * $limit) - $limit + 1;

if (isset($books) && !empty($books)) {
  foreach ($books as $work) {
    $dffg = $this->Comman->findstudentname1($work['holder_id'], $work['board']);
    $cls = $dffg['class']['title'] . ' - ' . $dffg['section']['title'];
    $d1 = $this->Time->format($work['issue_date'], 'dd-MM-Y');
    $d2 = $this->Time->format($work['due_date'], 'dd-MM-Y');

?>
    <tr>
      <td><?php echo $counter; ?></td>

      <td><?php if (isset($work['asn_no'])) {
            echo $work['asn_no'];
          } else {
            echo 'N/A';
          } ?></td>
      <td><?php if (isset($work['name'])) {
            echo ucfirst($work['name']);
          } else {
            echo 'N/A';
          } ?></td>

      <td><?php if (isset($work['ISBN_NO'])) {
            echo ucfirst($work['ISBN_NO']);
          } else {
            echo 'N/A';
          } ?></td>

      <td>
        <?php if (isset($work['holder_id'])) {
          if ($work['holder_type_id'] != 'Employee') {
            $stu = $this->Comman->findstudentname1($work['holder_id'], $work['board']);
            if ($stu) {
              echo $stu['enroll'] . '-' . $stu['fname'] . ' ' . $stu['middlename'] . ' ' . $stu['lname'];
            } else {
              echo ucfirst($work['holder_name']);
            }
          } else {
            echo ucfirst($work['holder_name']);
          }
        } else {
          echo 'N/A';
        } ?>
      </td>
      <td><?php if (isset($cls)) {
            echo ucfirst($cls);
          } else {
            echo 'N/A';
          } ?></td>
      <td><?php if (isset($work['holder_type_id'])) {
            echo ucfirst($work['holder_type_id']);
          } else {
            echo 'N/A';
          } ?></td>

      <td><?php if (!empty($d1)) {
            echo $d1;
          } else {
            echo "N/A";
          } ?></td>

      <td>
        <?php if ($work['holder_type_id'] != 'Employee') {
          if (!empty($d2)) {
            echo $d2;
          } else {
            echo "N/A";
          }
        } else {
          echo "-";
        } ?>
      </td>

      <td>
        <?php $a = '';
        if ($work['holder_type_id'] != 'Employee') {
          if (!empty($d1) && !empty($d2)) {
            if (strtotime(date("d-m-Y")) <= strtotime($d2)) {
              $diff = date_diff(date_create(date("d-m-Y")), date_create($d2));
              echo '<span class="label label-success" style="font-size:12px">' . $diff->format("Left: %a day(s)") . '</span>';
              $a = '1';
            } else {
              $diff = date_diff(date_create(date("d-m-Y")), date_create($d2));
              echo '<span class="label label-danger" style="font-size:12px">' . $diff->format("Overdue: %a day(s)") . '</span>';
              $a = '2';
            }
          } else {
            echo "N/A";
          }
        } else {
          echo "-";
        }
        ?>
      </td>

      <?php if ($role_id == ADMIN || $role_id == LIBRARY_COORDINATOR) { ?>
        <td>

          <a class='global1' title="Return Book" href="<?php echo SITE_URL; ?>admin/ReturnRenewBooks/returnbook/<?php echo $work['id']; ?>/<?php echo $a; ?>" data-target="#globalModaler" data-toggle="modal">
            <span class="fa fa-reply-all"></span>
          </a>
          &nbsp;&nbsp;
          <!-- <a class='global2' href="<?php echo SITE_URL; ?>admin/ReturnRenewBooks/update/<?php echo $work['id']; ?>" title="Update Book" 
                        data-target="#globalModal" data-toggle="modal">
 													<span class="glyphicon glyphicon-pencil"></span>
 												</a> -->

        </td>
      <?php } ?>

    </tr>
  <?php $counter++;
  }
} else { ?>
  <tr>
    <td colspan="10" style="text-align:center;">NO Data Available</td>
  </tr>
<?php } ?>



<script>
  //prepare the dialog
  //respond to click event on anything with 'overlay' class
  $(".global1").click(function(event) {
    //load content from href of link
    $('.modal-content').load($(this).attr("href"));
  });
</script>

<script>
  //prepare the dialog
  //respond to click event on anything with 'overlay' class
  $(".global2").click(function(event) {
    //load content from href of link
    $('.testeingprogress').load($(this).attr("href"));
  });
</script>