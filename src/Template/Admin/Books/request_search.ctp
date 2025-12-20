<table id="example14" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Date</th>
      <th>Acc No.</th>
      <th>Book Name</th>
      <th>Category</th>
      <th>Cupboard</th>
      <th>Shelf</th>
      <th>Students Name</th>
      <th>Class</th>
      <th>Enroll</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($bookRequests as $bookRequest) { ?>
      <tr>
        <td><?php echo date('d-m-Y', strtotime($bookRequest['created'])) ?></td>
        <td><?php echo $bookRequest['book']['accsnno'] ?></td>
        <td><?php echo $bookRequest['book']['name'] ?></td>
        <td><?php echo $bookCategory[$bookRequest['book']['book_category_id']] ?></td>
        <td><?php echo $cupboardLocation[$bookRequest['book']['cup_board_id']]['name'] ?></td>
        <td><?php echo $shelves[$bookRequest['book']['cup_board_shelf_id']] ?></td>
        <td><?php echo $bookRequest['student']['fname'] . ' ' . $bookRequest['student']['middlename'] ?></td>
        <td><?php echo $classes[$bookRequest['student']['class_id']] . ' ' . $sections[$bookRequest['student']['section_id']] ?></td>
        <td><?php echo $bookRequest['student']['enroll']; ?></td>
        <td><?php if (in_array($bookRequest['book']['id'], $bookCopyDetails)) { ?> <a class="btn btn-default btn-view btn-flat pull-right global globalsas" href="<?php echo SITE_URL; ?>admin/Issuebooks/issueBookInfo/<?php echo array_search($bookRequest['book']['id'], $bookCopyDetails) ?>/<?php echo $bookRequest['student']['id']; ?>" data-target="#globalModal" data-toggle="modal"><i class="fa fa-book"></i>Issue</a> <a href="javascript:void(0)" title="Reject" data-id="<?php echo $bookRequest['id']; ?>" class="reject" style="color:red"><i class="fa fa-times" aria-hidden="true"></i>
            </a> <?php } ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
<script>
  $(document).ready(function() {
    $(".reject").click(function(event) {
      var result = confirm("Reject Book Request?");
      if (!result) {
        return false;
      }
      var id = $(this).data('id');
      $.ajax({
        async: false,
        type: "POST",
        url: "<?php echo ADMIN_URL; ?>Books/reject_book_request",
        data: {
          id
        },
        dataType: "html",
        success: function(data) {
          if (data) {
            $('#search_submit').trigger('click');
          } else {
            alert('Error while processing please ty again');
          }
        }
      });
    });
  });
</script>