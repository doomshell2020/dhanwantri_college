<?php
$session = $this->request->session();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Deposit Book Report Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>ReturnRenewBooks/depositreport">Deposit Book Report Manager</a></li>
    </ol>

  </section>



  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div>
            <?php echo $this->Flash->render(); ?>
          </div>

          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-eye"></i> Search Deposit Book </h3>
          </div>
          <!-- /.box-header -->
          <script>
            $(document).ready(function() {

              $("#TaskAdminCustomerForm").bind("submit", function(event) {
                event.preventDefault();

                $.ajax({
                  async: true,
                  type: "POST",
                  url: "<?php echo ADMIN_URL; ?>ReturnRenewBooks/depositreportsearch",
                  data: $("#TaskAdminCustomerForm").serialize(),
                  dataType: "html",
                  beforeSend: function() {
                    // setting a timeout
                    $('#load2').css("display", "block");
                  },
                  success: function(data) {
                    $("#srch-rslt").html(data);
                  },
                  complete: function() {
                    $('#load2').css("display", "none");
                  },
                });
              });
            });
          </script>
          <style>
            #load2 {
              width: 100%;
              height: 100%;
              position: fixed;
              z-index: 9999;
              background-color: white !important;
              background: url("<? echo SITE_URL; ?>images/Preloader_2.gif") no-repeat center center rgba(0, 0, 0, 0.75)
            }
          </style>
          <script>
            $(document).ready(function() {
              $('#fdatefrom').datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function(date) {

                  var selectedDate = new Date(date);
                  var endDate = new Date(selectedDate);
                  endDate.setDate(endDate.getDate());

                  $("#fendfrom").datepicker("option", "minDate", endDate);

                  $("#fendfrom").val(date);
                }
              });
              $('#fdatefrom').datepicker('setDate', 'today');
              $("#fdatefrom").datepicker("option", "maxDate", 'today');

              $('#fendfrom').datepicker({
                dateFormat: 'yy-mm-dd'
              });
              $('#fendfrom').datepicker('setDate', 'today');
              $("#fendfrom").datepicker("option", "maxDate", 'today');
            });
          </script>
          <div class="box-body">
            <div class="manag-stu">

              <?php echo $this->Form->create($fine, array('class' => 'form-horizontal', 'id' => 'TaskAdminCustomerForm')); ?>

              <div class="form-group">

                <div class="col-sm-3">
                  <label>Date From</label>
                  <?php echo $this->Form->input('datefrom', array('class' => 'form-control', 'id' => 'fdatefrom', 'readonly', 'placeholder' => 'Date From', 'label' => false)); ?>
                </div>

                <div class="col-sm-3">
                  <label>Date To</label>
                  <?php echo $this->Form->input('dateto', array('class' => 'form-control', 'id' => 'fendfrom', 'readonly', 'placeholder' => 'Date To', 'label' => false)); ?>
                </div>
                <div class="col-sm-3">
                  <label></label>
                  <input type="submit" style="background-color:#00c0ef;width:100px !important; margin-left: 10px;margin-top: 26px;" class="btn btn4 btn_pdf myscl-btn date" value="Submit">
                  <button type="reset" style="background-color:#f4f4f4;width:100px !important; margin-left: 10px;margin-top: 26px;" class="btn btn4 btn_pdf myscl-btn date">Reset</button>
                </div>
              </div>
              <?php echo $this->Form->end(); ?>
            </div>
          </div>

          <div class="box-body">
            <div id="load2" style="display:none;"></div>
            <div id="srch-rslt">

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
  <div class="modal-dialog">
    <div class="modal-content testeingprogress">
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
  $(document).ready(function() {
    //prepare the dialog

    //respond to click event on anything with 'overlay' class
    $(".global1").click(function(event) {

      //load content from href of link
      $('.modal-content').load($(this).attr("href"));

    });
  });
</script>



<script>
  $(document).ready(function() {
    //prepare the dialog

    //respond to click event on anything with 'overlay' class
    $(".global2").click(function(event) {
      //load content from href of link
      $('.testeingprogress').load($(this).attr("href"));
    });
  });
</script>