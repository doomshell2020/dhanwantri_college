<div class="content-wrapper">
   <section class="content-header">
      <h1 style="margin: 0;
   font-size: 14px;
   color: aliceblue;">
         <ul class="nav nav-tabs responsive hidden-xs hidden-sm" id="">
            <li class="active" id="personal-tab"><a style="background: #00C0EF;color:#fff" href="<?php echo ADMIN_URL; ?>studentfees/index/496/2020-21?id=personal"><i class="fa fa-street-view"></i> Fee Structure <? echo $academic_year; ?></a></li>
            <? if ($student['category'] != "RTE") { ?>
               <li class="" id="personal-tab">
                  <a style="background: #00C0EF;color:#fff" title="Tution Fees Acknowledgement  2020-21" target="_blank" href="<?php echo ADMIN_URL; ?>report/feeacknowledgement/496/2020-21"> Fee Acnowledgement <? echo $academic_year; ?></a>
               </li>
            <?php } ?>
         </ul>
         Take Fee
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo ADMIN_URL; ?>studentfees/view"><i class="fa fa-home"></i>Home</a></li>
         <li><a href="<?php echo ADMIN_URL; ?>studentfees/view">Manage Student Fee</a></li>
         <li class="active">Deposit Fee</li>
      </ol>
      <section class="content">
         <div class="row">
            <div class="col-md-12">
               <div class="box box-info">
                  <div class="box-body">
                     <div class="box box-solid">
                        <div class="box-header left-align">
                           <div class="user-block col-sm-9 no-padding">
                              <img class="center-block img-circle img-thumbnail profile-img" src="<?php echo SITE_URL; ?>images/stu-image.png" alt="No Image">
                              <span class="username">
                                 <a href="<?php echo ADMIN_URL; ?>students/view/" <?php echo $student['id']; ?>><?php echo ucfirst($student['fname']); ?> <?php echo ucfirst($student['middlename']); ?> <?php echo ucfirst($student['lname']); ?></a> (<b style="color:green;"><?php echo $student['enroll']; ?></b>)
                              </span>
                              <span class="description">
                                 <strong>Class </strong> : <?php echo $student['class']['title']; ?> |
                                 <strong>Section </strong> : <?php echo $student['section']['title']; ?> |
                                 <strong>House </strong> : <?php echo ucfirst($student['house']['name']); ?> |
                                 <strong>Father Name </strong> : <?php echo ucwords($student['fathername']); ?> | <strong>Mobile No. : </strong> <?php echo $student['mobile']; ?> </span>
                              <? $findpendings = $this->Comman->studentshistoryagain($student['id']);
                              $findenroll = $this->Comman->findri($student['oldenroll']);
                              $findpendings23 = $this->Comman->studentshistory($findenroll['id']);

                              if (!empty($findpendings)) {
                                 foreach ($findpendings as $kkt => $rtt) {  ?> <?
                                                                                       $fetchdetail = 1;

                                                                                       if ($fetchdetail != '--') {  ?>
                                       <strong class="pull-right" style="color:red; margin-right: -135px;"> Pending Submit? <!-- <span class="text-black">₹ </span>  --><? //echo $fetchdetail; 
                                                                                                                                                                        ?></strong>
                                    <? } ?>

                                    &nbsp;<a href="<? echo ADMIN_URL; ?>studentfees/history/<? echo $rtt['stud_id']; ?>/<? echo $rtt['acedmicyear']; ?>" class="btn btn-info pull-right" style="margin-left: 15px;"> <? echo $rtt['acedmicyear']; ?> </a>&nbsp; <? }
                                                                                                                                                                                                                                                            } else if ($findpendings23['stud_id']) { ?>

                                 <a href="<? echo ADMIN_URL; ?>studentfees/history/<? echo $findpendings23['stud_id']; ?>/<? echo $findpendings23['acedmicyear']; ?>" class="btn btn-info pull-right"> <? echo $findpendings23['acedmicyear']; ?> </a> <? } ?>
                              <!---------------------------------------------------- For RTE CSS----------------------------------->
                              <? if ($students['category'] == "RTE") { ?>
                                 <style>
                                    #mytable2 {
                                       position: relative;
                                    }

                                    #mytable2::after {
                                       content: ;
                                       content: '';
                                       display: block;
                                       background-color: rgba(0, 0, 0, 0.5);
                                       position: absolute;
                                       left: 0px;
                                       right: 0px;
                                       bottom: 0px;
                                       top: 0px;
                                       z-index: 999;
                                    }
                                 </style>

                                 <span style="font-size:20px;color:red;float: right;font-weight: bold;">***RTE STUDENT***</span><? } ?>


                              <? if ($students['category'] == "Migration") { ?>
                                 <style>
                                    #mytable2 {
                                       position: relative;
                                    }

                                    #mytable2::after {
                                       content: ;
                                       content: '';
                                       display: block;
                                       background-color: rgba(0, 0, 0, 0.5);
                                       position: absolute;
                                       left: 0px;
                                       right: 0px;
                                       bottom: 0px;
                                       top: 0px;
                                       z-index: 999;
                                    }
                                 </style>

                                 <span style="font-size:20px;color:red;float: right;font-weight: bold;">***Migrated STUDENT***</span><? } ?>

                           </div>

                        </div>
                        <section class="content">
                           <div class="row edusec-user-profile">
                              <div class="col-sm-12">
                                 <?php if ($is_transport == '1') { ?>
                                    <!---------------------------------------------------- For Transport Enable -------------------------------------------------->
                                    <!--<ul class="nav nav-tabs responsive hidden-xs hidden-sm" id="">
<li id="guardians-tab"><a href="<?php echo ADMIN_URL; ?>studentfees/index/<?php echo $id; ?>/<?php echo $academic_year; ?>?id=guardians" ><i class="fa fa-bed"></i> Transport Fee</a></li>
		</ul>-->
                                 <?php } ?>
                                 <div id="content" class="tab-content responsive hidden-xs hidden-sm">
                                    <div class="tab-pane active" id="personal">
                                       <!------------------------------------------------------------Fee Deposit Form Start---------------------------------------------->
                                       <form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="sevice_form" validate="validate" action="<?php echo ADMIN_URL; ?>add">
                                          <input type="hidden" name="token" value="<?php echo uniqid(); ?>">
                                          <p style="text-align:center;"><input type="checkbox" name="is_special" value="1" class="check-alls"><span style="font-size:20px;"> Is Special</span> </p>
                                          <div class="row">
                                             <div class="col-lg-6">
                                                <table class="table table-striped table-hover table-condensed
                                    table-responsive" id="mytable">
                                                   <tbody>
                                                      <tr class="table_header">
                                                         <th class="bg-teal color-palette"></th>
                                                         <th class="text-left bg-teal color-palette"> Heads </th>
                                                         <th class="text-left bg-teal color-palette"> Last Date </th>
                                                         <th class="text-center bg-teal color-palette"> Fee </th>
                                                      </tr>
                                                      <tr>
                                                         <input type="hidden" name="student_id" value="496">
                                                         <input type="hidden" name="hdfb" id="hdfbd" value="2">
                                                      </tr>
                                                      <tr>
                                                         <input type="hidden" name="student_id" value="496">
                                                         </label></td>
                                                      </tr>
                                                      <tr>
                                                         <input type="hidden" name="student_id" value="496">
                                                         </label></td>
                                                      </tr>
                                                      <tr>
                                                         <input type="hidden" name="student_id" value="496">
                                                         <td style="width:4px;">
                                                            <label>
                                                               <input type="checkbox" id="chk3-4500" class="StuAttendCk  lnm" name="amount[]" onclick="check(3,4500,0,1602268200)" value="4500">
                                                            </label>
                                                         </td>
                                                         <td>
                                                            <input type="text" style="background-color: transparent;border: none;" value="Tuition Fee (OCT.-DEC.)">
                                                            <input type="hidden" style="background-color: transparent;border:
                                                none;" name="quater[]" id="s3-4500" class="quatyid" value="Quater3" readonly disabled="">
                                                            <input type="hidden" class="fehaedf" style="background-color: transparent;border: none;" id="sp3-4500" value="2" readonly disabled="">
                                                         </td>
                                                         <td>10-10-2020</td>
                                                         <td align="center"><span class="text-black">&#8377; </span><input type="text" style="width: 34%;" name="amountl[]" id="amoun7" maxlength="6" minlength="1" readonly="readonly" class="amounedit" value="4500">&nbsp;&nbsp;
                                                            <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 16px;color:red;display:none;"><i class="fa fa-times"></i></a>
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <input type="hidden" name="student_id" value="496">
                                                         <td style="width:4px;">
                                                            <label>
                                                               <input type="checkbox" id="chk4-4500" class="StuAttendCk  lnm" name="amount[]" onclick="check(4,4500,0,1610217000)" value="4500">
                                                            </label>
                                                         </td>
                                                         <td>
                                                            <input type="text" style="background-color: transparent;border: none;" value="Tuition Fee (JAN.-MARCH)">
                                                            <input type="hidden" style="background-color: transparent;border:
                                                none;" name="quater[]" id="s4-4500" class="quatyid" value="Quater4" readonly disabled="">
                                                            <input type="hidden" class="fehaedf" style="background-color: transparent;border: none;" id="sp4-4500" value="2" readonly disabled="">
                                                         </td>
                                                         <td>10-01-2021</td>
                                                         <td align="center"><span class="text-black">&#8377; </span><input type="text" style="width: 34%;" name="amountl[]" id="amoun8" maxlength="6" minlength="1" readonly="readonly" class="amounedit" value="4500">&nbsp;&nbsp;
                                                            <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 16px;color:red;display:none;"><i class="fa fa-times"></i></a>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                                <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
                                                   <tbody>
                                                      <tr class="table_header">
                                                         <th class="bg-teal color-palette"></th>
                                                         <th style="width: 27%;" class="bg-teal color-palette">Reference No.</th>
                                                         <th class="text-left bg-teal color-palette">Paydate </th>
                                                         <th class="text-left bg-teal color-palette"> Amount </th>
                                                         <th class="text-left bg-teal color-palette"> Print </th>
                                                      </tr>
                                                      <tr>
                                                         <td><label></label></td>
                                                         <td>1</td>
                                                         <td>
                                                            02-05-2020
                                                         </td>
                                                         <td>
                                                            <script src="/js/admin/confirmation.js"></script>
                                                            <span class="text-black">₹ </span>15000
                                                         </td>
                                                         <td>
                                                            <a title="Print Receipt" target="_blank" href="https://www.idsprime.com/admin/studentfees/printsadmission/8/2020-21"><i class="fa fa-file-text-o"></i></a>
                                                            <a title="Cancel Receipt" class="modalcancel" data-toggle="modal" data-val="8" data-id="1" data-options="2020-21" data-target="#myModal"><i class="fa fa-remove"></i></a>
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td><label></label></td>
                                                         <td>2</td>
                                                         <td>
                                                            02-05-2020
                                                         </td>
                                                         <td>
                                                            <span class="text-black">₹ </span>11100
                                                         </td>
                                                         <td>
                                                            <a title="Print Receipt" target="_blank" href="https://www.idsprime.com/admin/studentfees/printsadmission/9/2020-21"><i class="fa fa-file-text-o"></i></a>
                                                            <a title="Cancel Receipt" class="modalcancel" data-toggle="modal" data-val="9" data-id="2" data-options="2020-21" data-target="#myModal"><i class="fa fa-remove"></i></a>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                                <!----------------------------------------------------- For Paid Recipet Show before Migration------------------------------------->
                                                <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
                                                   <tbody>
                                                      <tr class="table_header">
                                                         <th class="bg-teal color-palette"></th>
                                                         <th style="width: 27%;" class="bg-teal color-palette">Before Migration Reference No.<br>(In Current Year)</th>
                                                         <th class="text-left bg-teal color-palette">Paydate </th>
                                                         <th class="text-left bg-teal color-palette"> Amount </th>
                                                         <th class="text-left bg-teal color-palette"> Print </th>
                                                      </tr>
                                                      <!----------------------------------------------------- For Cancel Recipet Script------------------------------------->
                                                      <tr>
                                                         <td colspan="5" class="text-center">No Deposit Fees Yet</td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                                <!----------------------------------------------------- For Sibling Data Show---------------------------------------->
                                             </div>
                                             <!----------------------------------------------------- For Pending Fee Show---------------------------------------->
                                             <div class="col-lg-6">
                                                <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
                                                   <tbody>
                                                      <tr class="table_header">
                                                         <th class="bg-teal color-palette" style=""></th>
                                                         <th style="width: 51%;" class="bg-teal color-palette">Description</th>
                                                         <th class="text-center bg-teal color-palette"> Due Fee </th>
                                                         <th class="text-right bg-teal color-palette"> Status </th>
                                                      </tr>
                                                      <tr>
                                                         <td style="width:4px;">
                                                            <label><input id="chk51--40" class="StuAttendCkrg" name="amounts[0]" onclick="checkpending(51,-40,0)" value="-40.00" type="checkbox">
                                                            </label>
                                                         </td>
                                                         <td style="width:4px;">
                                                            <label><input name="student_id" value="496" type="hidden">
                                                               <input name="refrencepending[]" value="9" type="hidden">
                                                               <input name="hdfb" id="hdfbd" type="hidden" value="2">
                                                               <input name="pendid[]" value="2" type="hidden">
                                                               Pending As Per Reference No 2 </label>
                                                         </td>
                                                         <td class="text-center">
                                                            <span class="text-black">₹ </span>-40.00
                                                         </td>
                                                         <td class="text-right"> Extra Paid </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                                <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
                                                   <tbody>
                                                      <div>
                                                         <tr class="assets_container">
                                                            <td colspan="4" width="50%">
                                                               <b>Other Fee Charge : &nbsp; </b>
                                                               <select name="quater[]" class="chkotherfeer" id="chkotherfee" onChange="chkotherfsees('chkotherfee');">
                                                                  <option value="0">- Add Other Fee -</option>
                                                                  <option value="62">Alumni Association Fee</option>
                                                                  <option value="68">ANNUAL CHARGES</option>
                                                                  <option value="63">Annual Fee</option>
                                                                  <option value="65">Art & Craft</option>
                                                                  <option value="11">Bank Cancellation Charge</option>
                                                                  <option value="56">Bank Charges</option>
                                                                  <option value="6">Computer Fee</option>
                                                                  <option value="60">CONVENIENCE FEE</option>
                                                                  <option value="55">Day Boarding</option>
                                                                  <option value="10">Examination Fee</option>
                                                                  <option value="59">ID CARD</option>
                                                                  <option value="5">Lab Charges</option>
                                                                  <option value="67">Laundry</option>
                                                                  <option value="61">Library Book Lost and Other Charges</option>
                                                                  <option value="58">Misc. Fee</option>
                                                                  <option value="57">Previous Due</option>
                                                                  <option value="66">Security Fee</option>
                                                                  <option value="64">Sports & Picnic</option>
                                                                  <option value="54">Summer Camp</option>
                                                                  <option value="52">T.C.</option>
                                                               </select>
                                                            </td>
                                                            <td colspan="2" width="50%">
                                                               <b><br> </b>
                                                               <input name="amount[]" readonly="readonly" id="otherfeeamts" value="0" placeholder="Enter Amount" type="number">
                                                            </td>
                                                            <td class="col-sm-2" class="subtype" style="position:relative;">
                                                               <label></label>
                                                               <a href="javascript:void(0);" class="add_field_butto" style="font-weight: bold; font-size: 21px;margin-top: 23px;"><i class="fa fa-plus-circle"></i></a>
                                                            </td>
                                                         </tr>
                                                      </div>
                                                      <div class="after-add-more"> </div>
                                                      </tr>
                                                      <tr>
                                                         <td colspan="4" width="50%">
                                                            <label>Receipt No.</label>
                                                            <input name="recipetno" type="text" value="4" class="form-control" readonly="readonly" required="required" id="recipitno" maxlength="9" placeholder="Enter Receipt No. Here">
                                                         </td>
                                                         <td colspan="6" id="formnos1" style="display:none;">
                                                            <label>Prospectus Form No.</label>
                                                            <input name="formno" class="form-control" id="formnos" maxlength="9" placeholder="Enter Prospectus Form No.">
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td colspan="8" width="50%">
                                                            <b style=" display:block;">Mode :</b> <span>&nbsp;&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" required id="radio1" name="mode" checked="checked" value="CASH" onclick="return checks(this);">Cash</label>
                                                               <label class="radio-inline"><input type="radio" name="mode" required id="radio2" onclick="return checks(this);" value="CHEQUE">Cheque</label>
                                                               <label class="radio-inline"><input type="radio" required id="radio1" name="mode" value="DD" onclick="return checks(this);">DD</label>
                                                               <label class="radio-inline"><input type="radio" required id="radio1" name="mode" value="NETBANKING" onclick="return checks(this);">Netbanking</label>
                                                               <label class="radio-inline"><input type="radio" required id="radio1" name="mode" value="Credit Card/Debit Card/UPI" onclick="return checks(this);">Credit Card/Debit Card/UPI</label>
                                                            </span>
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td colspan="4" width="50%">
                                                            <b>Discount : &nbsp; </b>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <select name="discountcategory" required="required" id="chkdiscountcateg" disabled>
                                                               <option value="0">-No Discount-</option>
                                                               <option value="1">WHOLE YEAR DISCOUNT</option>
                                                            </select>
                                                         </td>
                                                         <td colspan="4" width="50%">
                                                            <b>Paydate : &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                                                               &nbsp; &nbsp;</b>
                                                            <input type="text" style="max-width:
                                                126px;" class="abs_remark
                                                stuattendance-sa_date " readonly="readonly" name="paydate" maxlength="50" placeholder="Enter Paydate" value="02-05-2020" required="">
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td colspan="4" width="50%">
                                                            <b>Total Amount : &nbsp;</b> <span class="text-black">&#8377; </span><span class="tamount">0</span>
                                                            <input type="hidden" value="0" name="discount" id="fees_discount">
                                                            <input type="hidden" value="" name="discountcategorys" id="discountcategorys">
                                                         </td>
                                                         <td colspan="4" width="50%">
                                                            <b>(+)Late Fee :</b>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
                                                            <span class="text-black">&#8377; </span>
                                                            <input name="lfine" style="max-width: 42%;" id="lfines" value="0" type="number">
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td colspan="4" width="50%">
                                                            <b>(-)Discount : </b>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-black">&#8377; </span> <span class="discnt"> 0 </span>
                                                         </td>
                                                         <td colspan="4">
                                                            <b>(-)Add. Discount :&nbsp; </b>
                                                            <span class="text-black">&#8377; </span> <input type="number" placeholder="Additional Discount" min="0" id="additionaldis" name="addtionaldiscount" value="0" style="width: 42%;" maxlength="10">
                                                            <input type="checkbox" name="fulldiscount" value="5" id="fulldiscount" title="Whole Year Fee Discount (5%)" style="display:none;">
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td colspan="4">
                                                            <b>Net Amount : &nbsp;&nbsp;&nbsp;&nbsp;</b> <span class="text-black">&#8377; </span><span class="newamnt">0</span>
                                                            <input type="hidden" value="0" name="fee" class="afdiscount">
                                                            <input type="hidden" value="2020-21" name="acedmicyear" class="acedmicyear">
                                                            <input name="payer" type="hidden" value="" required>
                                                         </td>
                                                         <td colspan="4">
                                                            <b>Deposit Amount :&nbsp; <span class="text-black">&#8377; </span> </b> <input name="deposite_amt" class="newamnts" id="depositamt" style="width: 43%;" placeholder="Deposit Amount" type="number">
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td colspan="4">
                                                            <b>Due Amount :&nbsp;</b><span id="sum1"></span><input type="hidden" id="dueextras" name="dueextra">
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td colspan="4" id="che" style="display:none;">
                                                            <b>Cheque/Dd :&nbsp; </b>
                                                            <input type="text" placeholder="Cheque/Dd Number" style="max-width: 162px;" id="chequno" onclick="checks(1)" name="cheque_no" maxlength="10">
                                                         </td>
                                                         <td colspan="4" id="bnk" style="display:none;">
                                                            <b>Bank Name :&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
                                                            <input name="bank_id" style="max-width: 141px;" id="bank" placeholder="Enter Name" type="text">
                                                         </td>
                                                         <td colspan="4" id="ref" style="display:none;">
                                                            <b>Reference No. :&nbsp; </b>
                                                            <input type="text" id="refno" style="max-width: 152px;" onclick="" placeholder="Reference Number" name="ref_no" maxlength="25">
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td colspan="4" id="bnkcancellation" style="display:none;">
                                                            <b>Cancellation Charge :</b>
                                                            <input name="cancelid" id="cancelid" id='0' type="hidden">
                                                            <input name="bank_charge" style="max-width: 123px;" id="bankcharged" placeholder="Charge" type="number" maxlength='10'>
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td colspan="8"><label>Remarks :</label>
                                                            <textarea name="remarks" class="form-control rounded-0" id="exampleFormControlTextarea2" placeholder="Enter Remarks Here" rows="3"></textarea>
                                                            <input type="hidden" name="student_id" value="496">
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </div>
                                          </div>
                                          <div class="box-footer">
                                             <div class="submit"><input type="submit" class="btn btn-info pull-right addgen" title="Take Fee" style="display:none;" value="Take Fee" /></div>
                                             <div class="submit"><input type="submit" class="btn btn-info pull-right addgen23" title="Cancel Recipiet" style="display:none;" value="Cancel Recipiet" /></div>
                                             <a href="/admin/studentfees/view" class="btn btn-default">Back</a>
                                          </div>
                                       </form>
                                       <!-- Modal -->
                                       <div class="modal fade" id="myModal" role="dialog">
                                          <div class="modal-dialog">
                                             <form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="sevice_formtest" validate="validate" action="https://www.idsprime.com/admin/studentfees/cancelledstudent">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                   <div class="modal-header" style="background-color: #3c8dbc;">
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                      <h4 class="modal-title">Are You Sure ? Do You Want To Cancel This Reference No. <b class="ert"> </b></h4>
                                                   </div>
                                                   <div class="modal-body">
                                                      <textarea type="text" class="textryu" name="remarks" required="required" cols="78" rows="5" placeholder="Enter Remarks For Cancellation...."></textarea>
                                                      <input type="hidden" name="id" class="nkid">
                                                      <input type="hidden" name="academicyear" class="academikid">
                                                   </div>
                                                   <div class="modal-footer">
                                                      <div class="submit">
                                                         <input type="submit" class="btn btn-info pull-right" title="Cancel" style="display: block;" value="Submit">
                                                         <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                      </div>
                                                   </div>
                                                </div>
                                             </form>
                                          </div>
                                       </div>
                                       <!-------------------------------------------End Of Deposit Fee---------------------------------------------------------------->
                                    </div>
                        </section>
                        <div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
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
                     </div>
                  </div>
               </div>
            </div>
      </section>
</div>