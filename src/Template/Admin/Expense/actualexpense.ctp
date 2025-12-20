<div class="content-wrapper">
  <section class="content-header">
    <h1>Actual Expense Detail</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>dashboards/adminbranch"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>Expense/actualexpense">Actual Expense List</a></li>
    </ol>
  </section>
  <section class="content">
    <div id="load"></div>
    <?php echo $this->Flash->render(); ?>
    <div class="row">

      <div id="load2" style="display:none;"></div>
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <!-- <div style="display:flex; justify-content: space-between;align-items:center; margin-bottom: 4px;">
              <h3 class="box-title" style="flex:1;">Expense List</h3>
             
            </div> -->

            <!-- <?php echo $this->Form->create('Mysubscription', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'Mysubscriptions', 'class' => 'form-horizontal')); ?> -->

            <?php echo $this->Form->create('Mysubscription', array('type' => 'get', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'Mysubscriptions', 'class' => 'form-horizontal', 'method' => 'get')); ?>


            <div class="col-md-10">
              <?php echo $this->Form->create('Mysubscription', array('type' => 'get', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'Mysubscription', 'class' => 'form-horizontal', 'method' => 'POST'));
              //  $year = array('2022' => '2021-2022', '2021' => '2020-2021', '2020' => '2019-2020', '2019' => '2018-2019', '2018' => '2017-2018', '2017' => '2016-2017', '2016' => '2015-2016');
              $currentYear = date("Y");
              $yearRange = range($currentYear - 2, $currentYear);
              $yearRange = array_reverse($yearRange);
              $years = array();

              foreach ($yearRange as $year) {
                $years[$year] = $year . '-' . ($year + 1);
              }

              ?>

              <div class="row">


                <div class="col-sm-3">
                  <label>Summary Type</label>
                  <select class="form-control" name="Head" id="summarySelect" onchange="toggleSummaryFields()">
                    <option value="finSum">Financial Year Summary</option>
                    <option value="dateSum">Date Summary</option>
                  </select>
                </div>


                <div class="col-sm-3" id="finSumField" >
                <label for="inputEmail3" class="control-label">Financial Year</label>
                  <?php echo $this->Form->input('prev_year', array('class' => 'form-control', 'id' => 'prev_year', 'label' => false, 'options' => $years, 'autofocus', 'required')); ?>
                </div>


                <div class="col-sm-3" id="dateSumField1" style="display:none;">
                  <script>
                    $(document).ready(function () {
                      $('#fdatefrom').datepicker({
                        dateFormat: 'yy-mm-dd',
                        yearRange: '2018:2025',
                        changeMonth: true,
                        onSelect: function (date) {
                          var selectedDate = new Date(date);
                          var endDate = new Date(selectedDate);
                          endDate.setDate(endDate.getDate());
                          $("#fendfrom").datepicker("option", "minDate", endDate);
                          $("#fendfrom").val(date);
                        }
                      });
                      $('#fendfrom').datepicker({
                        changeMonth: true,
                        dateFormat: 'yy-mm-dd'
                      });
                    });
                  </script>
                  <label for="inputEmail3" class="control-label">Date From</label>
                  <?php echo $this->Form->input('datefrom', array('class' => 'form-control', 'id' => 'fdatefrom', 'readonly', 'placeholder' => 'Date From', 'label' => false)); ?>
                </div>

                <div class="col-sm-3" id="dateSumField2" style="display:none;">
                  <label for="inputEmail3" class="control-label">Date To</label>
                  <?php echo $this->Form->input('dateto', array('class' => 'form-control', 'id' => 'fendfrom', 'readonly', 'placeholder' => 'Date To', 'label' => false)); ?>
                </div>



                <script>
                  function toggleSummaryFields() {
                    var selectedOption = document.getElementById('summarySelect').value;
                    var finSumField = document.getElementById('finSumField');
                    var dateSumField1 = document.getElementById('dateSumField1');
                    var dateSumField2 = document.getElementById('dateSumField2');

                    if (selectedOption === 'finSum') {
                      finSumField.style.display = 'block';
                      dateSumField1.style.display = 'none';
                      dateSumField2.style.display = 'none';
                    } else if (selectedOption === 'dateSum') {
                      finSumField.style.display = 'none';
                      dateSumField1.style.display = 'block';
                      dateSumField2.style.display = 'block';
                    } else {
                      finSumField.style.display = 'none';
                      dateSumField1.style.display = 'none';
                      dateSumField2.style.display = 'none';
                    }
                  }
                </script>


                <div class="col-sm-3" style='padding-top: 24px;'>
                  <input type="submit" style="background-color:green;color: #fff; margin-top: 0px; padding: 6px;"
                    id="Mysubscriptions" class="btn btn-success" value="Search">
                  <?php echo $this->Form->end(); ?>

                  <a target="blank" href="<?php echo SITE_URL; ?>admin/Expense/actualexpensepdf"
                    class="btn btn-primary add_amploy">
                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf </a>
                </div>

              </div>
            </div>
          </div>
          <div class="box-body" id="example23">
            <div>
              <table class="table table-bordered table-striped" style="width:100%;">
                <thead>
                  <tr>
                    <th style="width:15%;text-align:left;">Expense</th>
                    <th style="width:5%;text-align:right !important;">April</th>
                    <th style="width:5%;text-align:right !important;">May</th>
                    <th style="width:5%;text-align:right !important;">June</th>
                    <th style="width:5%;text-align:right !important;">July</th>
                    <th style="width:5%;text-align:right !important;">Aug</th>
                    <th style="width:5%;text-align:right !important;">Sep</th>
                    <th style="width:5%;text-align:right !important;">Oct</th>
                    <th style="width:5%;text-align:right !important;">Nov</th>
                    <th style="width:5%;text-align:right !important;">Dec</th>
                    <th style="width: 5%;text-align:right !important;">Jan</th>
                    <th style="width: 5%;text-align:right !important;">Feb</th>
                    <th style="width:5%;text-align:right !important;">March</th>
                    <th style="width:5%;text-align:right !important;">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $mnths = array('1' => '4', '2' => '5', '3' => '6', '4' => '7', '5' => '8', '6' => '9', '7' => '10', '8' => '11', '9' => '12', '10' => '1', '11' => '2', '12' => '3');
                  foreach ($ex_cat as $ex_catt) {

                    $ex_id = $ex_catt['id'];
                    // pr($ex_id);
                    ?>
                    <tr>
                      <td><b><?php echo $ex_catt['category_name']; ?></b>

                        <a title="Add Expense"
                          href="<?php echo SITE_URL; ?>admin/Expense/addexpense/<?php echo $ex_id; ?>">
                          <i class="fa fa-plus view-details" data-target="#modal_<?php echo $ex_id; ?>"></i>
                        </a>

                        <div class="modal fade" id="modal_<?php echo $ex_id; ?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-body"></div>
                            </div>
                          </div>
                        </div>


                      </td>
                      <?php
                      $total = 0;
                      for ($i = 1; $i <= 12; $i++) {
                        $unique_id = uniqid('modal_');
                        $m = $this->Comman->getMonthTotal($ex_catt['id'], $mnths[$i], $yea);
                        $amount = $m['sum'] ? $m['sum'] : 0;
                        $total += $amount;
                        ?>
                        <td style="text-align:right !important;">
                          <a href="<?php echo ADMIN_URL; ?>expense/viewexpense/<?php echo $ex_catt['id']; ?>/<?php echo $mnths[$i]; ?>/<?php echo $yea; ?>"
                            class="globalModalghs" data-toggle="modal" data-target="#<?php echo $unique_id; ?>">
                            <?php echo $amount; ?>
                          </a>
                        
                          <div class="modal fade" id="<?php echo $unique_id; ?>" tabindex="-1" role="dialog"
                            aria-labelledby="esModalLabel" aria-hidden="true">
                            <div class="modal-dialog" style="max-width: 1500px;">
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
                        </td>
                      <?php } ?>
                      <td style="text-align:right !important;"><?php echo $total; ?></td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td style="text-align:right !important;"><b>Total</b></td>
                    <?php
                    $total_sum = 0;
                    for ($i = 1; $i <= 12; $i++) { ?>
                      <td style="text-align:right !important;">
                        <?php
                        $m = $this->Comman->getMonthTotalSum($mnths[$i], $yea);
                        echo $m['sum'] ? $m['sum'] : 0;
                        ?>
                      </td>
                      <?php
                      $total_sum += $m['sum'];
                    } ?>
                    <td style="text-align:right !important;"><?php echo $total_sum; ?></td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
</div>
</div>

<script>
  $(document).on('click', '.globalModalghs', function (e) {
    e.preventDefault();
    var targetUrl = $(this).attr('href');

    var modalId = $(this).data('target');
    $(modalId).modal('show');
    $(modalId + ' .modal-body').html('<div class="loader"><div class="es-spinner"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div></div>');

    $.ajax({
      url: targetUrl,
      success: function (data) {
        $(modalId + ' .modal-body').html(data);
      },
      error: function () {
        $(modalId + ' .modal-body').html('<p>Error loading content. Please try again.</p>');
      }
    });
  });
</script>




<script>
  $(document).on('click', '.view-details', function (e) {
    e.preventDefault();
    var targetUrl = $(this).parent('a').attr('href');
    var modalId = $(this).data('target');

    $(modalId).modal('show').find('.modal-body').load(targetUrl);
    

  });

  $(document).on('click', '.cancel-request', function (e) {
    e.preventDefault();
    var targetUrl = $(this).attr('href');
    var modalId = $(this).data('target');

    $(modalId).modal('show').find('.modal-body').load(targetUrl);
  });
</script>

<div class="modal fade" id="cancelsorts">
  <div class="modal-dialog" style="max-width:600px !important;">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $("#Mysubscriptions").bind("submit", function (event) {
      $('.lds-facebook').show();

      $.ajax({
        async: true,
        data: $("#Mysubscriptions").serialize(),
        dataType: "html",
        type: "POST",
        url: "<?php echo ADMIN_URL; ?>expense/searchexpense",
        success: function (data) {
          $('.lds-facebook').hide();
          $("#example23").html(data);
        },
      });
      return false;
    });
  });
</script>


