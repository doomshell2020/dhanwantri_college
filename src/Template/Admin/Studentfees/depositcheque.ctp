<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Deposit Fee Manager

    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>studentfees/view"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>studentfees/view">Manage Student Fee</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div id="load"></div>
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <i class="fa fa-search" aria-hidden="true"></i>

          </div>

          <style>
            #load {
              width: 100%;
              height: 100%;
              position: fixed;
              z-index: 9999;
              background-color: white !important;
              background: url("<? echo SITE_URL; ?>images/Preloader_2.gif") no-repeat center center rgba(0, 0, 0, 0.75)
            }
          </style>
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
            document.onreadystatechange = function() {
              var state = document.readyState
              if (state == 'complete') {
                document.getElementById('interactive');
                document.getElementById('load').style.visibility = "hidden";
              }
            }
          </script>
          <!-- /.box-header -->
          <?php echo $this->Flash->render(); ?>
          <div class="box-body">

            <?php
            if ($ids || $ids3) { ?>

              <?php
              if ($ids3 && $ids4) { ?>

                <a href="<? echo ADMIN_URL; ?>studentfees/<?php echo $ids3; ?>/<?php echo $ids4; ?>/<?php echo $acedemicdd; ?>" target="_blank" id="redicaution"></a>

                <script type="text/javascript">
                  $('#redicaution')[0].click();
                </script>


              <? }
              if ($ids && $ids2) { ?>
                <a href="<? echo ADMIN_URL; ?>studentfees/<?php echo $ids; ?>/<?php echo $ids2; ?>/<?php echo $acedemicdd; ?>" target="_blank" id="redi"></a>

                <script type="text/javascript">
                  $('#redi')[0].click();
                </script>



            <?php }
            } ?>
            <div class="manag-stu">

              <script inline="1">
                //<![CDATA[
                $(document).ready(function() {
                  $("#TaskAdminCustomerForm").bind("submit", function(event) {
                    $.ajax({
                      async: true,
                      data: $("#TaskAdminCustomerForm").serialize(),
                      dataType: "html",
                      beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())
                        $('#load2').css("display", "block");
                      },

                      success: function(data, textStatus) {

                        $("#example12").html(data);
                      },
                      complete: function() {
                        $('#load2').css("display", "none");
                      },
                      type: "POST",
                      url: "<?php echo SITE_URL; ?>admin/Studentfees/search"
                    });
                    return false;
                  });
                });
              </script>

            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div id="load2" style="display:none;"></div>
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <i class="fa fa-search" aria-hidden="true"></i>
            <h3 class="box-title"> Cheque Deposits </h3>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="box box-info">
                <div class="box-body">
                  <div class="box-body" id="example12">
                    <div class="table-responsive">
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>#</th>

                            <th>Student Name</th>
                            <th>Reciept No</th>
                            <th>Type</th>
                            <th>Mode</th>
                            <th>Bank</th>
                            <th>Cheque No</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody id="example2">
                          <?php $cnt = 1;
                          foreach ($studentsfees as $key => $st) {
                            // pr($st);
                            // die;
                          ?>
                            <tr>
                              <td><?php echo $cnt ?></td>

                              <th><?php echo $st['student']['fname'] ?> <?php echo $st['student']['middlename'] ?> <?php echo $st['student']['lname'] ?></th>
                              <td><?php echo $st['recipetno']; ?></td>
                              <td><?php echo $st['type']; ?></td>

                              <td><?php echo $st['mode']; ?></td>
                              <td><?php echo $st['bank']; ?></td>
                              <td><?php echo $st['cheque_no']; ?></td>
                              <td>
                                <?php 
                                // pr($st);exit;
                                if ($st['cheque_status'] == 'Y') { ?>
                                  <span class="fa fa-check"> Accepted</span>
                                <?php } else if ($st['cheque_status'] === 'N') { ?>
                                  <span class="fa fa-ban"> Rejected</span>
                                <?php } else { ?>
                                  <?php echo $this->Html->link('', ['action' => 'accept_cheque', $st['student']['id'], $st['id']], ['title' => 'Accept', 'class' => 'fa fa-check', 'style' => 'color:#0dd900; margin-left: 13px; font-size: 19px !important;', "onClick" => "javascript: return confirm('Are you sure do you want to accept this Cheque')"]); ?>
                                <?php echo $this->Html->link('', ['action' => 'reject_cheque', $st['student']['id'], $st['id']], ['title' => 'Reject', 'class' => 'fa fa-ban', 'style' => 'color:#FF0000; margin-left: 13px; font-size: 19px !important;', "onClick" => "javascript: return confirm('Are you sure do you want to reject this Cheque')"]);
                                } ?>


                              </td>
                            </tr>
                          <?php $cnt++;
                          } ?>
                        </tbody>
                      </table>
                    </div>
                    <!-- <div class="modal globaldiscountdss" id="globaldiscountjh" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
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
    </div> -->

                    <!-- <div class="modal globaldiscountds" id="globaldiscountd" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
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
    </div> -->

                    <script>
                      $('.accept_cheque').click(function(e) {
                        e.preventDefault();
                        $('#accept_chequesorts').modal('show').find('.modal-body').load($(this).attr('href'));
                      });
                    </script>
                  </div>
                </div>
              </div>
            </div>
  </section>
</div>
<div class="modal fade" id="accept_chequesorts">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <!-- Modal body -->
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>