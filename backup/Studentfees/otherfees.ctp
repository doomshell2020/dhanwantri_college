 
<div class="content-wrapper">
<section class="content-header">
   <h1 style="margin-bottom:10px !important"><i class="fa fa-money"></i> Other Fees Deposit </h1>

    </section>
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title" style="margin:0px !important">Fee Deposit</h4>
                </div>
                <?php echo $this->Form->create($enquires, array('class' => '', 'id' => 'sevice_form1', 'enctype' => 'multipart/form-data', 'validate', 'autocomplete' => 'off')); ?>
                <input type="hidden" name="token" value=<?php echo uniqid(); ?>>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <label>Academic Year<span style="color:red;">*</span></label>
                            <select class="form-control" name="academicyear" required="required">
                                <option value="2018-19">2018-19</option>
                                <option value="2019-20" selected>2019-20</option>
                            </select>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <label>Date<span style="color:red;">*</span></label>
                            <?php echo $this->Form->input('paydate', array('class' => 'form-control', 'required', 'id' => 'datepicker', 'value' => date('d-m-Y'), 'label' => false)); ?>
                        </div>
                        <script>
                        $(function() {
                            $("#datepicker").datepicker({
                                dateFormat: 'dd-mm-yy',
                            });
                        });
                        </script>
                        <div class="col-sm-3 col-xs-6">
                            <label>Receipt No.<span style="color:red;">*</span></label>
                            <?php echo $this->Form->input('recipietno', array('class' => 'form-control', 'readonly', 'value' => $recipietno, 'type' => 'text', 'label' => false)); ?>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <label>Fees Title<span style="color:red;">*</span></label>
                            <?php echo $this->Form->input('title', array('class' => 'form-control', 'required', 'type'=>'select', 'options'=>$feesheadstotal, 'empty' => "--Select Fee Title--", 'label' => false)); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <label>Scholar No.</label>
                            <?php echo $this->Form->input('s_id', array('class' => 'form-control', 'maxlength' => 10, 'id' => 'scholar_no', 'type' => 'text', 'placeholder' => 'Scholar No', 'onkeypress' => 'return isNumber(event);', 'label' => false)); ?>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <label>Pupil's Name<span style="color:red;">*</span></label>
                            <?php echo $this->Form->input('pupilname', array('class' => 'form-control', 'required', 'maxlength' => 35, 'placeholder' => "Pupil's Name", 'id' => 'pupilname', 'label' => false)); ?>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <label>Parents Name<span style="color:red;">*</span></label>
                            <?php echo $this->Form->input('parentsname', array('class' => 'form-control', 'required', 'maxlength' => 35, 'id' => 'p_name', 'placeholder' => 'Full Name', 'label' => false)); ?>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <label>Mobile<span style="color:red;">*</span></label>
                            <?php echo $this->Form->input('mobile_no', array('class' => 'form-control', 'required', 'maxlength' => 10, 'id' => 'dup_mobile', 'placeholder' => 'Mobile', 'onkeypress' => 'return isNumber(event);', 'label' => false)); ?>
                        </div>
                        <script>
                        function isNumber(evt) {
                            evt = (evt) ? evt : window.event;
                            var charCode = (evt.which) ? evt.which : evt.keyCode;
                            if (charCode != 46 && charCode != 45 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                                alert("Please Enter Valid Value");
                                return false;
                            }
                            return true;
                        }
                        </script>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <label>Fees<span style="color:red;">*</span></label>
                            <?php echo $this->Form->input('amount', array('class' => 'form-control f1', 'placeholder' => 'Fees', 'value' => $feed, 'label' => false, 'onkeypress' => 'return isNumber(event)', 'id' => 'fees')); ?>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <label>Discount</label>
                            <?php echo $this->Form->input('discount', array('class' => 'form-control', 'id' => 'discount', 'placeholder' => 'Discount(If any)', 'onkeypress' => 'return isNumber(event)', 'label' => false)); ?>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <label>Total amount<span style="color:red;">*</span></label>
                            <?php echo $this->Form->input('total', array('class' => 'form-control', 'readonly', 'id' => 'dep', 'placeholder' => 'Total', 'label' => false)); ?>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                           <label>Class<span style="color:red;">*</span></label>
                           <?php echo $this->Form->input('class_id', array('class' => 'form-control', 'type' => 'select', 'id' => 'class_id', 'empty' => '--Select Class--', 'options' => $class_id, 'label' => false,'required')); ?>
                          </div>
                        <script>
                        $(document).ready(function() {

                            $("#fees,#discount").keyup(function() {
                                sum();

                            });

                            function sum() {
                                var a = $('#fees').val();
                                var b = $("#discount").val();
                                var result = a - b;
                                $("#dep").val(result);
                            }

                        });
                        </script>

                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <label>Remarks</label>
                            <?php echo $this->Form->input('remarks', array('class' => 'form-control', 'type' => 'textarea', 'placeholder' => 'Remarks', 'rows' => '2', 'label' => false)); ?>
                        </div>
                        <div class="col-sm-6" style="padding-top:20px;">
                            <label class="col-sm-2">Mode:<span style="color:red;">*</span></label>
                            <label class="radio-inline"><input type="radio" required id="radio1" name="mode"
                                    checked="checked" value="CASH" onclick="return checks(this);">Cash</label>

                            <label class="radio-inline"><input type="radio" name="mode" required id="radio2"
                                    onclick="return checks(this);" value="CHEQUE">Cheque</label>
                            <label class="radio-inline"><input type="radio" required id="radio1" name="mode" value="DD"
                                    onclick="return checks(this);">DD</label>


                            <label class="radio-inline"><input type="radio" required id="radio1" name="mode"
                                    value="NETBANKING" onclick="return checks(this);">Netbanking</label>

                            <label class="radio-inline"><input type="radio" required id="radio1" name="mode"
                                    value="CREDIT CARD/DEBIT CARD" onclick="return checks(this);">Credit
                                Card/Debit Card</label>
                            <table style="margin-top:15px; margin-left:12px; width:80%; text-align:left">
                                <tr>
                                    <td colspan="5" id="che" style="display:none;">
                                        <b>Cheque/Dd :&nbsp; </b>
                                        <input type="text" placeholder="Cheque/Dd Number" style="max-width: 162px;"
                                            id="chequno" onclick="checks(1)" name="cheque_no" maxlength="10">
                                    </td>
                                    <td colspan="5" id="bnk" style="display:none;">
                                        <b>Bank Name :&nbsp;</b>
                                        <input name="bank_id" style="max-width: 141px;" id="bank"
                                            placeholder="Enter Name" type="text">
                                    </td>
                                    <td colspan="4" id="ref" style="display:none;">
                                        <b>Reference No. :&nbsp; </b>
                                        <input type="text" id="refno" style="max-width: 152px;" onclick=""
                                            placeholder="Reference Number" name="ref_no" maxlength="25">
                                    </td>
                                </tr>
                            </table>
                            <script type="text/javascript">
                            $(function() {

                                window.checks = function(id) {



                                    var doc = $('input[name="mode"]:checked').val();
                                    //console.log(doc);
                                    if (doc == "CASH") {

                                        $("#che").css("display", "none");
                                        $("#ref").hide();
                                        $("#bnk").css("display", "none");

                                        document.getElementById('chequno').required = false;
                                        document.getElementById('bank').required = false;
                                        document.getElementById('refno').required = false;


                                    } else if (doc == "CHEQUE") {

                                        $("#che").show();
                                        $("#ref").hide();
                                        $("#bnk").show();

                                        document.getElementById('chequno').required = true;
                                        document.getElementById('bank').required = true;
                                        document.getElementById('refno').required = false;

                                    } else if (doc == "DD") {

                                        $("#che").show();

                                        $("#ref").hide();
                                        $("#bnk").show();
                                        
                                        document.getElementById('chequno').required = true;
                                        document.getElementById('bank').required = true;
                                        document.getElementById('refno').required = false;

                                    } else if (doc == "NETBANKING") {

                                        $("#ref").show();
                                        $("#che").hide();
                                       
                                        $("#bnk").hide();
                                        document.getElementById('chequno').required = false;
                                        document.getElementById('refno').required = true;
                                        document.getElementById('bank').required = false;

                                    } else if (doc == "CREDIT CARD/DEBIT CARD") {

                                        $("#ref").show();

                                        $("#che").hide();
                                        $("#bnk").hide();
                                        
                                        document.getElementById('chequno').required = false;
                                        document.getElementById('refno').required = true;
                                        document.getElementById('bank').required = false;

                                    } else {

                                        $("#che").show();
                                        $("#bnk").show();

                                        document.getElementById('chequno').required = true;
                                        document.getElementById('bank').required = true;

                                    }

                                }
                            });
                            </script>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo $this->Form->submit('Take Fee', array('class' => 'btn btn-info pull-right', 'style' => '', 'title' => 'Submit'));

echo $this->Form->end(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <script>
    $(document).ready(function() {
        $('#pupilname').keyup(function() {
            $.ajax({
                async: true,
                data: $("#pupilname").serialize(),
                dataType: "html",
                type: "POST",
                

                url: "<?php echo ADMIN_URL; ?>studentfees/otherfee_select",
                success: function(data) {
                    //  alert(data);

                    $("#src-rslt").show();

                    $("#updt").html(data);
                    },
                     

            });
            return false;
        });
        $('#scholar_no').keyup(function() {
            var len=$('#scholar_no').val().length;
            if(len<4){
                $("#src-rslt").hide();
            }
           else if(len >=4){
            $.ajax({
                async: true,
                data: $("#scholar_no").serialize(),
                dataType: "html",
                type: "POST",
                beforeSend: function() {
                    // setting a timeout
                },

                url: "<?php echo ADMIN_URL; ?>studentfees/otherfee_select",
                success: function(data) {
                    //  alert(data);

                    $("#src-rslt").show();

                    $("#updt").html(data);
                },

            });
        }
            return false;
        });
        $('#dup_mobile').keyup(function() {
            $.ajax({
                async: true,
                data: $("#dup_mobile").serialize(),
                dataType: "html",
                type: "POST",
                beforeSend: function() {
                    // setting a timeout
                },

                url: "<?php echo ADMIN_URL; ?>studentfees/otherfee_select",
                success: function(data) {
                    //  alert(data);

                    $("#src-rslt").show();

                    $("#updt").html(data);
                },

            });
            return false;
        });
    });
    </script>
    
    <div class="row" style="display:none" id="src-rslt">
        <div class="box col-sm-12">
            <div class="box-header col-sm-12">
            <i class="fa fa-search" aria-hidden="true"></i>
                <h4 class="box-title">Search Results</h4>
            </div>
            <div class="box-body">
                <div class="example2">
                    <table class="table table-bordered table-striped">
                        <tbody id="updt"> </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <h3 class="box-title">View Details</h3>
                </div>
                <div class="box-body" id="example12">

                    <div id="load2" style="display:none;"></div>
                    <!-- <div id="example12"> -->
                        <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr style="background-color:#39cccc !important; color:white">
                                    <th>#</th>
                                    <th>#Sr.No.</th>
                                    <th>Pupil's Name</th>
                                    <th>Parents Name</th>
                                    <th>Mobile</th>
                                    <th>Class</th>
                                    <th>Fee Title</th>
                                    <th>Academic Year</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Receipt No.</th>

                                    <th>Receipt/ Edit</th>
                                </tr>
                            </thead>
                            <tbody id="example2">
                                <?php $page = $this->request->params['paging']['Services']['page'];
$limit = $this->request->params['paging']['Services']['perPage'];
$counter = ($page * $limit) - $limit + 1;
if (isset($detail) && !empty($detail)) {
    foreach ($detail as $service) { //pr($service);
        ?>
                                <tr <?php if ($service['status'] == 'N') {?> style="color:red;" <?php }?>>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php if (isset($service['s_id'])) {echo ucfirst($service['s_id']);} else {echo '--';}?>
                                    </td>
                                    <td><?php if (isset($service['pupilname'])) {echo ucfirst($service['pupilname']);} else {echo 'N/A';}?>
                                    </td>
                                    <td><?php if (isset($service['parentsname'])) {?>
                                        <?php echo ucfirst($service['parentsname']); ?> <?php } else {echo 'N/A';}?>
                                    </td>

                                    <td><?php if (isset($service['mobile_no'])) {echo $service['mobile_no'];} else {echo 'N/A';}?>
                                    </td>
                                    <td><?php if (isset($service['class_id']) && !empty($service['class_id'])) {$class = $this->Comman->findclasses($service['class_id']);
                                    echo $class[0]['title'];} else { echo 'N/A';} ?></td>
                                    <td><?php if (isset($service['title'])) {echo ucfirst($service['title']);} else {echo 'N/A';}?>
                                    </td>

                                    <td><?php if (isset($service['academicyear'])) {echo $service['academicyear'];} else {echo 'N/A';}?>
                                    </td>
                                    <td><?php if (isset($service['paydate'])) {echo $date = date("d-m-Y", strtotime($service['paydate']));}?>
                                    </td>
                                    <td><?php if (isset($service['total'])) {echo $service['total'];}?></td>

                                    <td><?php if (isset($service['receipt_no'])) {echo $service['receipt_no'];}?></td>


                                    <td>

                                        <a title="Print Receipt" target="_blank" id="<?php echo $service['id']; ?>"
                                            target="_blank"
                                            href="<?php echo SITE_URL; ?>admin/Studentfees/otherfees_receipt/<?php echo $service['id']; ?>"><i
                                                class="fa fa-file-text-o"></i></a>
                                        <!--<a title="Delete Receipt" style="margin-left:10px;" target="_blank"  target="_blank" href="<?php echo SITE_URL; ?>admin/Studentfees/otherfees_delete/<?php echo $service['id']; ?>"><i class="fa fa-times"></i></a> -->
                                        <a title="Cancel Receipt" class="modalcancel" style="margin-left:10px;"
                                            data-toggle="modal" data-val="<?php echo $service['id']; ?>"
                                            data-id="<?php echo $service['receipt_no']; ?>"
                                            data-options="<?php echo $service['academicyear']; ?>"
                                            data-target="#myModal"><i class="fa fa-remove"></i></a>

                                    </td>


                                </tr>
                                <?php $counter++;

    }} else {?>
                                <tr>
                                    <td colspan="6">No Data Available</td>
                                </tr>
                                <?php }?>
                            </tbody>

                        </table>
    </div>
                        <?php
if ($oid) {?>
    <script type="text/javascript">
    $('#<?php echo $oid; ?>')[0].click();
    </script>

    <?php }?>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
$('.modalcancel').on('click',function(){
    // $("#sevice_form1 :input").prop("disabled", true);
	$('.nkid').val('');
	$('.academikid').val('');
	$('.textryu').val('');

var idn = $(this).data("val");
$('.nkid').val(idn);
var recipetn = $(this).data("id");

$('.ert').html(recipetn);
var academicy = $(this).data("options");
$('.academikid').val(academicy);

});
});
</script>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    <form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="sevice_formtest" validate="validate" action="<?echo ADMIN_URL; ?>studentfees/otherfees_delete">
      <!-- Modal content-->
      <div class="modal-content">


        <div class="modal-header" style="background-color: #3c8dbc;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Are You Sure ? Do You Want To Cancel This Reference No. <b class="ert"> </b></h4>
        </div>
        <div class="modal-body">

         <textarea type="text" class="textryu" name="reasonforcancelling"  required="required" cols="78" rows="5" placeholder="Enter Remarks For Cancellation...."></textarea>
         <input type="hidden" name="id" class="nkid" >
        </div>
        <div class="modal-footer">

          <div class="submit">
			  <input type="submit" class="btn btn-info pull-right" title="Cancel" style="display: block;" value="Submit">
			     <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button></div>
        </div>
      </div>
        </form>
    </div>
  </div>
