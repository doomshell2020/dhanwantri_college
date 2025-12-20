<!-- Content Wrapper. Contains page content -->
<style>
  #testUL {
    position: relative;
  }

  #testUL ul {
    position: absolute;
    z-index: 999;
    overflow: scroll;
    height: 100px;
    top: 100%;
    left: 0px;
    right: 0px;
    list-style-type: none;
    background-color: white;
    padding-left: 0px;
  }

  #testUL ul li {
    padding: 5px 8px;
    border: 1px solid lightgray;
  }

  #testUL ul li a {
    color: black;
  }

  .preview {
    margin-right: 15px;
  }

  .dataTables_wrapper.form-inline.dt-bootstrap.no-footer {
    margin-top: 0px;
  }
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Vendors
    </h1>
    <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>vendors/index">Vendors</a></li>
    </ol>
  </section>
  <div class="posAlertDv">
  <?php echo $this->Flash->render(); ?>
  </div>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header" >
         
            <a href="<?php echo SITE_URL; ?>admin/vendors/add" style="display: block; text-align:right; height:0px;">
              <button class="btn btn-success m-top10" style=" margin-bottom: -60px; z-index: 999; position: relative;"><i class="fa fa-plus" aria-hidden="true"></i>
                Add </button></a>
            <script>
              function cllbckretail0(id, cid, sid) {
                $('.secrh-retail').val(id);
                $('#retail_ids').val(cid);
                $('#testUL').hide();
              }
              $(function() {
                $('.secrh-retail').bind('keyup', function() {
                  var pos = $(this).val();
                  //alert(pos);
                  var check = 0;
                  //var catid=$('#subcategory').val();
                  //alert(pos);
                  $('#testUL').show();
                  $('#retail_ids').val('');
                  var count = pos.length;
                  if (count > 0) {
                    $.ajax({
                      type: 'POST',
                      url: '<?php echo ADMIN_URL; ?>vendors/getname',
                      data: {
                        'fetch': pos,
                        'check': check
                      },
                      success: function(data) {
                        console.log(data);
                        $('#testUL ul').html(data);
                      },
                    });
                  } else {
                    $('#testUL').hide();
                  }
                });
              });
            </script>
            <script inline="1">
              $(document).ready(function() {
                $("#vendorsdetails").bind("submit", function(event) {
                  $.ajax({
                    async: true,
                    data: $("#vendorsdetails").serialize(),
                    dataType: "html",
                    type: "POST",
                    url: "<?php echo ADMIN_URL; ?>vendors/searchitem",
                    beforeSend: function() {},
                    success: function(data) {
                      $("#updt").html(data);
                    },
                    complete: function(data) {},
                  });
                  return false;
                });
              });
            </script>

            <?php echo $this->Form->create('Vendor', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'vendorsdetails', 'class' => 'form-horizontal')); ?>
            <div class="form-group" style="display:flex; align-items:flex-end; margin-bottom:0px;">

              <div class="col-sm-2">
                <label for="inputEmail3" class="control-label">Vendor</label>
                <input type="hidden" required="required" name="vendor_id" id="retail_ids">
                <?php echo $this->Form->input('nitem', array('class' => 'form-control secrh-retail', 'id' => 'itemname', 'type' => 'text', 'label' => false, 'autofocus', 'autocomplete' => 'off', 'placeholder' => 'Enter Vendor Name')); ?>
                <div id="testUL" style="display:none;">
                  <ul></ul>
                </div>
              </div>

              <div class="col-sm-2">
                <label for="inputEmail3" class="control-label">Contact No.</label>
                <?php echo $this->Form->input('contact', array('class' => 'form-control', 'type' => 'text', 'label' => false, 'autofocus', 'autocomplete' => 'off', 'placeholder' => 'Enter Contact No.')); ?>
              </div>
              <div class="col-sm-2">
                <label for="inputEmail3" class="control-label">Email ID</label>
                <?php echo $this->Form->input('email', array('class' => 'form-control', 'type' => 'text', 'label' => false, 'autofocus', 'autocomplete' => 'off', 'placeholder' => 'Enter Email ID')); ?>
              </div>
              <div class="col-sm-2">
                <input type="submit" style="background-color:#00c0ef; color:#fff;width:100px !important;" id="Mysubscriptions" class="btn btn4 btn_pdf myscl-btn date" value="Search">
              </div>
            </div>
            <?php echo $this->Form->end(); ?>
     
          </div>
          <!-- /.box-header -->
          <div class="box-body" id="updt" >
            <div class="table-responsive">

              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Vendor Name</th>
                    <th>Pan No</th>
                    <th>Contact </th>
                    <th>Email</th>
                    <th>Contact Person</th>
                    <th>Type</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $page = $this->request->params['paging']['vendors']['page'];
                  $limit = $this->request->params['paging']['vendors']['perPage'];
                  $counter = ($page * $limit) - $limit + 1;
                  if (isset($vendors) && !empty($vendors)) {
                    foreach ($vendors as $work) {
                      // pr($work); die; ?>
                      <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php echo $work['name']  ?></td>
                        <td><?php echo $work['pancard_number']  ?></td>
                        <td><?php echo $work['contact_no']  ?></td>
                        <td><?php echo $work['email']  ?></td>
                        <td><?php echo $work['contact_person']  ?></td>
                        <td><?php echo $work['type']  ?></td>
                        <td><?php
                            echo $this->Html->link('', [
                              'action' => 'add',
                              $work->id
                            ], ['class' => 'fas fa-edit', 'style' => 'font-size: 18px;']); ?>
                          <?php
                          echo $this->Html->link('', [
                            'action' => 'delete',
                            $work->id
                          ], ['class' => 'fas fa-trash-alt', 'style' => 'font-size: 18px; color:#c12020;', "onClick" => "javascript: return confirm('Are you sure you want to delete this Vendor ?')"]); ?>
                        </td>
                      </tr>
                    <?php $counter++;
                    }
                  } else { ?>
                    <tr>
                      <td colspan="8">NO Data Available</td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
              <?php echo $this->element('admin/pagination'); ?>
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
<script>
  $(document).ready(function() {
    $('#datepicker1').datepicker({
      dateFormat: 'dd-mm-yy',
    });
    //$('#datepicker1').datepicker('setDate', 'today');
  });
</script>
<script type="text/javascript">
  $("#myemail").change(function() {
    //alert('hello');
    var txt = $('#myemail').val();
    var testCases = [txt];
    var test = testCases;
    if (isValidEmailAddress(test) != true) {
      $('#mailvalid').css('display', 'block');
      $('#myemail').val('');
    } else {
      $('#mailvalid').css('display', 'none');
    }
  });
</script>
<script>
  function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
  };

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 46 || charCode > 57 || charCode == 47)) {
      alert("Please Enter Only Numeric Characters!!!!");
      return false;
    }
    return true;
  }

  function checkLength() {
    var textbox = document.getElementById("addnum");
    if (textbox.value.length >= 10 && textbox.value.length <= 12) {
      return true;
    } else {
      alert("Enter minimum 10 digits of your mobile number");
      $('#addnum').val('');
      return false;
    }
  }
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $(".billtos #billto_state_ids").on('change', function() {
      var id = $(this).val();
      $(".billtoc #billto_city_ids").find('option').remove();
      //$("#city").find('option').remove();
      if (id) {
        var dataString = id;
        $.ajax({
          type: "POST",
          url: '<?php echo SITE_URL; ?>/admin/vendors/getcity',
          data: {
            'dataString': id
          },
          cache: false,
          success: function(html) {
            //alert(html);
            $('<option>').val("").text("Select City").appendTo($(".billtoc #billto_city_ids"));
            $.each(html, function(key, value) {
              $('<option>').val(key).text(value).appendTo($(".billtoc #billto_city_ids"));
            });
          }
        });
      }
    });
    $(".shiptos #shipto_state_ids").on('change', function() {
      var id = $(this).val();
      $(".shiptoc #shipto_city_ids").find('option').remove();
      //$("#city").find('option').remove();
      if (id) {
        var dataString = id;
        $.ajax({
          type: "POST",
          url: '<?php echo SITE_URL; ?>/admin/vendors/getcity',
          data: {
            'dataString': id
          },
          cache: false,
          success: function(html) {
            //alert(html);
            $('<option>').val("").text("Select City").appendTo($(".shiptoc #shipto_city_ids"));
            $.each(html, function(key, value) {
              $('<option>').val(key).text(value).appendTo($(".shiptoc #shipto_city_ids"));
            });
          }
        });
      }
    });
  });
</script>
<script>
  $(document).ready(function() {
    $(".add-billto-fields").click(function() {
      var numItems = $('.billto_video_details').length;
      numItems++;
      $.ajax({
        type: "POST",
        url: '<?php echo SITE_URL; ?>admin/vendors/billto',
        data: {
          'srno': numItems,
        },
        cache: false,
        success: function(html) {
          //alert(html);
          $(".billto_product_containes").append(html);
        }
      });
    });
    $("body").on("click", ".billto_remove", function() {
      $(this).closest('.billto_video_details').remove();
    });
    $(".add-shipto-fields").click(function() {
      var numItems = $('.shipto_video_details').length;
      numItems++;
      $.ajax({
        type: "POST",
        url: '<?php echo SITE_URL; ?>admin/vendors/shipfrom',
        data: {
          'srno': numItems,
        },
        cache: false,
        success: function(html) {
          //alert(html);
          $(".shipto_product_containes").append(html);
        }
      });
    });
    $("body").on("click", ".shipto_remove", function() {
      $(this).closest('.shipto_video_details').remove();
    });
  });
</script>