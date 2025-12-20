<!-- Content Wrapper. Contains page content -->
<style>
   .checkbox input[type="checkbox"] {
   opacity: 1;
   }
</style>
<style>
   #load2 {
   width: 100%;
   height: 100%;
   position: fixed;
   z-index: 9999;
   background-color: white !important;
   background: url("<?echo SITE_URL; ?>images/Preloader_2.gif") no-repeat center center rgba(0, 0, 0, 0.75)
   }
</style>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
        Substitute Report Search
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo ADMIN_URL; ?>cancelledrecipiet"><i class="fa fa-home"></i>Home</a></li>
        <li><a href="<?php echo ADMIN_URL; ?>report/cancelledrecipiet">Manage Receipt </a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
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
            <script inline="1">
                $(document).ready(function() {
                
                  $("#sevice_form1").bind("submit", function(event) {
                
                    //alert();
                    $.ajax({
                      async: true,
                      data: $("#sevice_form1").serialize(),
                      dataType: "html",
                      type: "POST",
                      beforeSend: function() {
                        //Show image container
                        $("#loader").show();
                      },
                      url: "<?php echo ADMIN_URL; ?>Employeeattendance/substitution_report_search",
                      success: function(data) {
                        $('#src-rslt').show();
                
                        $(".updt").html(data);
                      },
                
                    });
                
                    return false;
                  });
                });
                //]]>
            </script>
            <?php echo $this->Form->create('Fees', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'sevice_form1', 'class' => 'form-horizontal')); ?>
            <div class="form-group">
                <input type="hidden" name="acedmicyear" value="<?echo $acedmic; ?>">
                <div class="col-sm-2">
                  <script>
                      $(document).ready(function() {
                        $('#fdatefrom').datepicker({
                          dateFormat: 'yy-mm-dd',
                          maxDate: '+0',
                        });
                        //$('#fdatefrom').datepicker('setDate', 'today');
                      });
                  </script>
                  <label for="inputEmail3">Select Date</label>
                  <?php echo $this->Form->input('date', array('class' => 'form-control', 'id' => 'fdatefrom', 'readonly', 'placeholder' => 'Select Date', 'label' => false)); ?>
                </div>
                <div class="col-sm-4" style="padding-top:23px">
                  <input type="submit" style="background-color:#00c0ef;color:#fff;width:100px !important; margin-left: 10px;"
                      class="btn btn4 btn_pdf myscl-btn date" value="Submit">
                  <button type="reset" style="background-color:#333333;color:#fff;width:100px !important; margin-left: 10px;"
                      class="btn btn4 btn_pdf myscl-btn date">Reset</button>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
            <!-- /.box-header -->
            <?php echo $this->Flash->render(); ?>
          </div>

          <div class="box-body" id="src-rslt" style="display:none; padding-top:0px;">
            <div class="updt" id="example12"> </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>