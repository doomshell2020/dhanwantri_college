<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style>
  /* IE 6 doesn't support max-height
	   * we use height instead, but this forces the menu to always be this tall
	   */
  * html .ui-autocomplete {
    height: 100px;
  }

  .modal {
    width: 852px !important;
  }

  .modal-content,
  .modal-dialog {
    width: 840px !important;
  }
</style>
<div class="content-wrapper">

  <section class="content-header">
    <h1>
      <!-- <i class="fa fa-th-list"></i> -->
      Manage Book Request 
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>Books/request">Book Request</a></li>
    </ol>
  </section>
  <section class="content">

    <!-- start -->
    <div class="row">
      <div class="col-xs-12">
        <?php echo $this->Flash->render(); ?>
        <div class="box">

          <div class="box-header">
            <h3 class="box-title">
              <i class="fa fa-search"></i> Search Book Request
            </h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="manag-stu">
              <?php echo $this->Form->create(null, array('class' => 'form-horizontal', 'id' => 'requestsearch')); ?>
              <div class="form-group">
                <div class="col-sm-3">
                  <label>Class</label>
                  <?php
                  echo $this->Form->input('class_id', array(
                    'class' => 'form-control bn', 'id' => 'v1', 'type' => 'select', 'empty' => 'Select Class',
                    'options' => $classes, 'label' => false
                  ));
                  ?>
                </div>
                <div class="col-sm-3 datepc1">
                  <label>From Date<span>
                      <font color="red"> *</font>
                    </span></label>
                  <?php echo $this->Form->input('d1', array('class' => 'form-control ', 'placeholder' => 'From Date', 'id' => 'datepick11', 'value' => '', 'label' => false)); ?>
                </div>

                <div class="col-sm-3 datepc2">
                  <label>To Date<span>
                      <font color="red"> *</font>
                    </span></label>
                  <?php echo $this->Form->input('d2', array('class' => 'form-control ', 'placeholder' => 'To Date', 'id' => 'datepick22', 'label' => false)); ?>
                </div>
              </div>




              <div class="form-group">
                <div class="col-sm-6">
                  <button type="submit" class="btn btn-success" id="search_submit">Search</button>&nbsp;
                  <button type="reset" class="btn btn-primary" id="cleardates">Reset</button>
                </div>
              </div>

              <?php echo $this->Form->end(); ?>
            </div>
          </div>
        </div>
      </div>
      <!-- end -->


      <!-- /.row -->
  </section>

  <script>
    $(document).ready(function() {

      $("#requestsearch").bind("submit", function(event) {
        event.preventDefault();
        var a = $('#v1').val();
        var b = $('#perop1').val();
        var c = $('#datepick11').val();
        var d = $('#datepick11').val();
        if (a != '' || b != '' || c != '' || d != '') {
          $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo ADMIN_URL; ?>Books/request_search",
            data: $("#requestsearch").serialize(),
            dataType: "html",
            success: function(data) {
              $("#srch-rslt").html(data);
            }
          });
        } else {
          alert('Select atleast one field');
          return false;
        }
        return false;
      });
    });
  </script>


  <script>
    $('#datepick11').datepicker({
      dateFormat: 'mm/dd/yy',
      minDate: '-2y',
      maxDate: '+0',
      onSelect: function(dateStr) {
        var min = $(this).datepicker('getDate') || new Date(); // Selected date or today if none
        var max = new Date();
        //max.setMonth(max.getMonth() + 60); // Add one month
        $('#datepick22').datepicker('option', {
          minDate: min,
          maxDate: max
        });
      },
    }).attr("readonly", "readonly");
    $('#datepick22').datepicker({
      dateFormat: 'mm/dd/yy',
      minDate: '',
      maxDate: '+0',
      autoclose: true,
      onSelect: function(dateStr) {

        var max = $(this).datepicker('getDate') || new Date(); // Selected date or null if none
        $('#datepick11').datepicker('option', {
          maxDate: max
        });
      },
    }).attr("readonly", "readonly");
  </script>
  <!-- /.content -->

  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-xs-12">

        <div class="box">

          <div>
            <?php echo $this->Flash->render(); ?>
          </div>

          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-search"></i> Book Requests</h3>
            <!--
        <a id="" style="position: absolute;
top: 122px;
/* right: 0px; */
right: 46px;" class="btn btn-info btn-sm pull-right" target="_blank" href="<?php echo ADMIN_URL; ?>report/user_prospectus"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export PDF</a>
-->
          </div>
          <!-- /.box-header -->

          <div class="box-body">
            <div id="srch-rslt">
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
                      <td> <?php if (in_array($bookRequest['book']['id'], $bookCopyDetails)) { ?> <a class="btn btn-default btn-view btn-flat pull-right global globalsas" href="<?php echo SITE_URL; ?>admin/Issuebooks/issueBookInfo/<?php echo array_search($bookRequest['book']['id'], $bookCopyDetails) ?>/<?php echo $bookRequest['student']['id']; ?>/<?php echo $bookRequest['id']; ?>" data-target="#globalModal" data-toggle="modal"><i class="fa fa-book"></i>Issue</a> <a href="javascript:void(0)" title="Reject" data-id="<?php echo $bookRequest['id']; ?>" class="reject" style="color:red"><i class="fa fa-times" aria-hidden="true"></i>
                          </a> <?php } ?> </td>
                    </tr>

                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>


<!-- /.content-wrapper -->
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
            alert('Error while processing please try again');
          }
        }
      });
    });
  });
</script>