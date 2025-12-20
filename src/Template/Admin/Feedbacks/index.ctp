<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
  /* IE 6 doesn't support max-height
	   * we use height instead, but this forces the menu to always be this tall
	   */

  * html .ui-autocomplete {
    height: 100px;
  }
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Complain Management</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>Feedbacks/index">FeedBacks</a></li>
    </ol>
  </section>

  <section class="content" style>
    <div class="row">
      <div class="col-xs-12">
        <?php echo $this->Flash->render(); ?>
        <div class="box">
          <!-- /.box-header -->
          <div class="box-body">
            <div class="manag-stu">
              <?php echo $this->Form->create(null, array('class' => 'form-horizontal', 'id' => 'gatepassearch')); ?>
              <div class="form-group">
                <div class="col-sm-3">
                  <label>Name</label>
                  <?php echo $this->Form->input('name', array('class' => 'form-control bn', 'type' => 'text', 'id' => 'v1', 'placeholder' => 'Name', 'autocomplete' => 'off', 'label' => false)); ?>
                </div>
                <div class="col-sm-3">
                  <label>Class</label>
                  <?php echo $this->Form->input('class_id', array('class' => 'form-control bn', 'type' => 'select', 'id' => 'classId', 'empty' => 'Select Class', 'options' => $classes, 'label' => false));

                  ?>
                </div>
                <div class="col-sm-3 datepc1">
                  <label>From Date<span>
                      <font color="red"> *</font>
                    </span></label>
                  <?php echo $this->Form->input('d1', array('class' => 'form-control ', 'placeholder' => 'From Date', 'id' => 'datepick1', 'value' => '', 'label' => false)); ?>
                </div>
                <div class="col-sm-3 datepc2">
                  <label>To Date<span>
                      <font color="red"> *</font>
                    </span></label>
                  <?php echo $this->Form->input('d2', array('class' => 'form-control ', 'placeholder' => 'To Date', 'id' => 'datepick2', 'label' => false)); ?>
                </div>
              </div>
              <div class="form-group" style="margin-bottom:0px;">
                <div class="col-sm-6">
                  <button type="submit" class="btn btn-success">Search</button>&nbsp;
                  <button type="reset" class="btn btn-primary" id="cleardates">Reset</button>
                </div>
              </div>
              <?php echo $this->Form->end(); ?>
            </div>
          </div>

          <div class="box-body">
            <div id="srch-rslt">
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
                  <?php $cnt = 1;
                  foreach ($feedbacks as $feedback) { ?>
                    <tr>
                      <td>
                        <?php echo $cnt; ?>
                      </td>
                      <td>
                        <?php echo date('d-m-Y', strtotime($feedback['created'])); ?>
                      </td>
                      <td>
                        <?php
                        if ($feedback['student']['fname']) {
                          echo $feedback['student']['fname'] . ' ' . $feedback['student']['middlename'] . ' ' . $feedback['lname'];
                        } else {
                          echo $feedback['student_name'];
                        }?>
                      </td>
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
                          }?>
                      </td>
                      <td>
                        <?php echo $feedback['feedback_cat']['name']; ?>
                      </td>
                      <td>
                        <?php echo $feedback['feedback']; ?>
                      </td>
                      <td>
                        <?php echo $feedback['phone']; ?>
                      </td>
                      <td>
                        <?php echo $feedback['status'] == 'N' ? 'Open' : 'Close'; ?>
                      </td>
                      <td>
                        <?php if ($feedback['status'] == 'N') { ?> <a title="Cancel" class="modalcancel pull-right btn btn-info" style="margin-left:10px;" data-toggle="modal" data-val="<?php echo $feedback['id']; ?>" data-target="#delete_Modal">Close</a>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php $cnt++;
                  }
                  if (empty($feedback)) { ?>
                    <tr>
                      <td colspan="9">No Feedbacks Request </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
    $(document).ready(function() {
      $("#gatepassearch").bind("submit", function(event) {
        event.preventDefault();
        var a = $('#v1').val();
        var b = $('#perop1').val();
        var c = $('#datepick1').val();
        var d = $('#datepick1').val();
        if (a != '' || b != '' || c != '' || d != '') {
          $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo ADMIN_URL; ?>Feedbacks/feedback_search",
            data: $("#gatepassearch").serialize(),
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
    $('#datepick1').datepicker({
      dateFormat: 'mm/dd/yy',
      minDate: '-2y',
      maxDate: '+0',
      onSelect: function(dateStr) {
        var min = $(this).datepicker('getDate') || new Date(); // Selected date or today if none
        var max = new Date();
        //max.setMonth(max.getMonth() + 60); // Add one month
        $('#datepick2').datepicker('option', {
          minDate: min,
          maxDate: max
        });
      },
    }).attr("readonly", "readonly");
    $('#datepick2').datepicker({
      dateFormat: 'mm/dd/yy',
      minDate: '',
      maxDate: '+0',
      autoclose: true,
      onSelect: function(dateStr) {
        var max = $(this).datepicker('getDate') || new Date(); // Selected date or null if none
        $('#datepick1').datepicker('option', {
          maxDate: max
        });
      },
    }).attr("readonly", "readonly");
  </script>
</div>
<!-- /.content-wrapper -->
<div class="modal fade" id="delete_Modal" role="dialog" style="width:500px">
  <div class="modal-dialog">
    <form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="sevice_formtest" validate="validate" action="<? echo ADMIN_URL; ?>feedbacks/close">
      <!-- Modal content-->
      <div class="modal-content" style="width:100%">
        <div class="modal-header" style="background-color: #3c8dbc;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 style="color:white">Close Feedback</h3>
        </div>
        <div class="modal-body">
          <textarea type="text" class="textryu" name="closing_remark" required="required" cols="70" rows="5" placeholder="Closing Remarks"></textarea>
          <input type="hidden" name="feedback_id" class="nkid">
        </div>
        <div class="modal-footer" style="width:100%">
          <div class="submit">
            <input type="submit" class="btn btn-info pull-right" title="Cancel" style="display: block;" value="Submit">
            <button type="button" class="btn btn-default pull-left " data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('.modalcancel').on('click', function() {
      // $("#sevice_form1 :input").prop("disabled", true);
      $('.nkid').val('');
      $('.textryu').val('');
      var idn = $(this).data("val");
      $('.nkid').val(idn);
    });
  });
</script>