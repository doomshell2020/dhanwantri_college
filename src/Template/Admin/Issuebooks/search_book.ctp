  <?php $role_id = $this->request->session()->read('Auth.User.role_id');
  $user_id = $this->request->session()->read('Auth.User.id');

  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-eye"></i> View Books</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>ISBN/ISSN No.</th>
          <th>Acc. No.</th>
          <th>Book Name</th>
          <th>Category</th>
          <th>Language</th>
          <th>Publisher</th>
          <th>Room</th>
          <th>Cupboard</th>
          <th>Shelf</th>
          <th>Author</th>
          <?php if ($role_id == LIBRARY_COORDINATOR) { ?>
            <th>Action</th>
          <?php } ?>
          <?php if ($role_id == LIBRARY_COORDINATOR) { ?>
            <th>Action</th>
          <?php } ?>
        </tr>
      </thead>

      <tbody>

        <?php

        $page = $this->request->params['paging']['books']['page'];
        $limit = $this->request->params['paging']['books']['perPage'];
        $counter = ($page * $limit) - $limit + 1;
        if (isset($books) && !empty($books)) {
          foreach ($books as $work) {
            if ($work['type'] == '1') {
              $jkl = $this->Comman->findperidetail($work['periodic_category_id']);
            }
        ?>
            <tr>

              <td><?php echo $counter; ?></td>
              <?php if ($work['type'] == '1') { ?>

                <td><?php if (isset($jkl['periodical_master']['ISBN_NO'])) {
                      echo ucfirst($jkl['periodical_master']['ISBN_NO']);
                    } else {
                      echo 'N/A';
                    } ?></td>
              <?php } else { ?>
                <td><?php if (isset($work['ISBN_NO'])) {
                      echo ucfirst($work['ISBN_NO']);
                    } else {
                      echo 'N/A';
                    } ?></td>
              <?php } ?>
              <td><?php if (isset($work['accsnno'])) {
                    echo ucfirst($work['accsnno']);
                  } else {
                    echo 'N/A';
                  } ?></td>

              <td><a href="<?php echo SITE_URL; ?>admin/Books/view/<?php echo $work['id']; ?>/<?php echo $work['type']; ?>"><?php if (isset($work['b_name'])) {
                      echo ucfirst($work['b_name']);} else {echo 'N/A';} ?></a>
                      </td>

              <?php if ($work['type'] == '1') { ?>
                <td><?php if (isset($jkl['periodical_master']['name'])) {
                      echo ucfirst($jkl['periodical_master']['name']);
                    } else {
                      echo 'N/A';
                    } ?></td>
              <?php } else { ?>
                <td><?php if (isset($work['b_category'])) {
                      echo ucfirst($work['b_category']);
                    } else {
                      echo 'N/A';
                    } ?></td>
              <?php } ?>
              <?php if ($work['type'] == '1') {
                $lasd = $this->Comman->findlang($jkl['periodical_master']['lang']); ?>
                <td><?php if (isset($lasd['language'])) {
                      echo ucfirst($lasd['language']);
                    } else {
                      echo 'N/A';
                    } ?></td>
              <?php } else {
                $lasd = $this->Comman->findlang($work['language']); ?>
                <td><?php if (isset($lasd['language'])) {
                      echo ucfirst($lasd['language']);
                    } else {
                      echo 'N/A';
                    } ?></td>
              <?php } ?>
              <?php if ($work['type'] == '1') { ?>
                <td><?php if (isset($jkl['periodical_master']['publisher'])) {
                      echo ucfirst($jkl['periodical_master']['publisher']);
                    } else {
                      echo 'N/A';
                    } ?></td>
              <?php } else { ?>
                <td><?php if (isset($work['publisher'])) {
                      echo ucfirst($work['publisher']);
                    } else {
                      echo 'N/A';
                    } ?></td>
              <?php } ?>

              <td><?php if (isset($work['roomid'])) {
                    echo ucfirst($work['roomid']);
                  } else {
                    echo 'N/A';
                  } ?></td>

              <td><?php if (isset($work['cupboard'])) {
                    echo ucfirst($work['cupboard']);
                  } else {
                    echo 'N/A';
                  } ?></td>

              <td><?php if (isset($work['cupboard_shelf'])) {
                    echo ucfirst($work['cupboard_shelf']);
                  } else {
                    echo 'N/A';
                  } ?></td>
              <?php if ($work['type'] == '1') { ?>
                <td><?php if (isset($jkl['periodical_master']['author'])) {
                      echo ucfirst($jkl['periodical_master']['author']);
                    } else {
                      echo 'N/A';
                    } ?></td>
              <?php } else { ?>
                <td><?php if (isset($work['author'])) {
                      echo ucfirst($work['author']);
                    } else {
                      echo 'N/A';
                    } ?></td>
              <?php } ?>
              <?php if ($role_id == LIBRARY_COORDINATOR && $work['roomid'] == '1') { ?>
                <td>
                  <?php if ($work['availableCount'] != '0') {  ?>

                    <!--
        <a onClick="javascript: return confirm('Are you sure you want to delete this?')" href="<?php echo SITE_URL; ?>admin/Books/delete/<?php echo $work['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i> </a>  
-->

                    <a href="<?php echo SITE_URL; ?>admin/Books/create/<?php echo $work['id']; ?>"><i class="fa fa-edit" aria-hidden="true"></i> </a>


                    <a class="btn btn-default btn-view btn-flat pull-right global globalsas" href="<?php echo SITE_URL; ?>admin/Issuebooks/issueBookInfo/<?php echo $work['asn_no']; ?>" data-target="#globalModal" data-toggle="modal"><i class="fa fa-book"></i>Issue</a>
                  <?php } else {
                    $holer_detail = $this->Comman->find_holder_detail($work['accsnno'], $work['board']);
                  ?>

                    <a href="<?php echo SITE_URL; ?>admin/Books/create/<?php echo $work['id']; ?>"><i class="fa fa-edit" aria-hidden="true"></i> </a>
                    <? if (isset($holer_detail)) {
                      if ($holer_detail['holder_type_id'] == 'Student') {
                        $classec = $this->Comman->findstudentname1($holer_detail['holder_id'], $work['board']);
                        $a = 'Holder Name :' . $holer_detail['holder_name'] . '(S) - ' . $classec['class']['title'] . '-' . $classec['section']['title'];
                    ?>
                        <a class="btn btn-danger pull-right" title="<?php echo $a; ?>"><i class="fa fa-book"></i>&nbsp; Issued</a>
                      <?php } else { ?>
                        <a class="btn btn-danger pull-right" title="Holder Name : <?php echo $holer_detail['holder_name'] . '(E)'; ?>"><i class="fa fa-book"></i>&nbsp; Issued</a>
                      <?php } ?>


                    <?php  } else { ?>

                      <a class="btn btn-danger pull-right"><i class="fa fa-book"></i>&nbsp; <? echo $work['savailableCount']; ?></a>

                  <? }
                  } ?>
                </td>
              <?php } elseif ($role_id == LIBRARY_COORDINATOR && $user_id == INTERNATIONAL_FEE_COORDINATOR  && $work['roomid'] == STUDENT) { ?>
                <td>
                  <?php if ($work['availableCount'] != '0') {  ?>

                    <a href="<?php echo SITE_URL; ?>admin/Books/create/<?php echo $work['id']; ?>"><i class="fa fa-edit" aria-hidden="true"></i> </a>

                    <!--
 <a onClick="javascript: return confirm('Are you sure you want to delete this?')" href="<?php echo SITE_URL; ?>admin/Books/delete/<?php echo $work['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i> </a>
-->

                    <a class="btn btn-default btn-view btn-flat pull-right global globalsas" href="<?php echo SITE_URL; ?>admin/Issuebooks/issueBookInfo/<?php echo $work['asn_no']; ?>" data-target="#globalModal" data-toggle="modal"><i class="fa fa-book"></i>Issue</a>
                  <?php } else {
                    $holer_detail = $this->Comman->find_holder_detail($work['accsnno'], $work['board']);
                  ?>
                    <a href="<?php echo SITE_URL; ?>admin/Books/create/<?php echo $work['id']; ?>"><i class="fa fa-edit" aria-hidden="true"></i> </a>

                    <? if (isset($holer_detail)) {
                      if ($holer_detail['holder_type_id'] == 'Student') {
                        $classec = $this->Comman->findstudentname1($holer_detail['holder_id'], $work['board']);
                        $a = 'Holder Name :' . $holer_detail['holder_name'] . '(S) - ' . $classec['class']['title'] . '-' . $classec['section']['title'];
                    ?>
                        <a class="btn btn-danger pull-right" title="<?php echo $a; ?>"><i class="fa fa-book"></i>&nbsp; Issued</a>
                      <?php } else { ?>
                        <a class="btn btn-danger pull-right" title="Holder Name : <?php echo $holer_detail['holder_name'] . '(E)'; ?>"><i class="fa fa-book"></i>&nbsp; Issued</a>
                      <?php } ?>
                    <?php  } else {  ?>

                      <a class="btn btn-danger pull-right" title="Holder Name : <?php echo $holer_detail['holder_name'];  ?>"><i class="fa fa-book"></i>&nbsp; <? echo $work['savailableCount']; ?></a>

                  <? }
                  } ?>
                </td>
              <?php } ?>

            </tr>
          <?php $counter++;
          }
        } else { ?>
          <tr>
            <td>NO Data Available</td>
          </tr>
        <?php } ?>
      </tbody>

    </table>

  </div>
  <!-- /.box-body -->


  <div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog dsf">
      <div class="modal-content resdr">
        <div class="modal-body">
          <div class="loader">
            <div class="es-spinner">
              <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(".globalsas").click(function(event) {
      $('.resdr').load($(this).attr("href")); //load content from href of link
    });
  </script>