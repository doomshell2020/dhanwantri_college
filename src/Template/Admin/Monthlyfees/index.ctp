<div class="content-wrapper">
   <section class="content-header">
      <h1 style="margin: 0;
   font-size: 14px;
   color: aliceblue;">
         <ul class="nav nav-tabs responsive hidden-xs hidden-sm" id="">
            <li class="active" id="personal-tab"><a style="background: #00C0EF;color:#fff" href="<?php echo ADMIN_URL; ?>studentfees/index/<?php echo $student['id']; ?>/<? echo $academic_year; ?>?id=personal"><i class="fa fa-street-view"></i> Fee Structure <? echo $academic_year; ?></a></li>
            <? if ($student['category'] != "RTE") { ?>
               <li class="" id="personal-tab">
                  <a style="background: #00C0EF;color:#fff" title="Tution Fees Acknowledgement  <? echo $academic_year; ?>" target="_blank" href="<?php echo ADMIN_URL; ?>report/feeacknowledgement/<?php echo $student['id']; ?>/<? echo $academic_year; ?>"> Fee Acnowledgement <? echo $academic_year; ?></a>
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
                     <?php echo $this->Flash->render(); ?>
                     <div class="box box-solid">
                        <div class="box-header left-align">
                           <div class="user-block col-sm-9 no-padding">
                              <?php



                              if ($student['board_id'] == '1') {
                                 $bordd = "";
                              } else if ($student['board_id'] == '2') {
                                 $bordd = "CAM";
                              } else if ($student['board_id'] == '3') {

                                 $bordd = "IB";
                              }


                              $filename2 = '/var/www/html/idsprime/webroot/' . $db['db'] . 'schools/' . $bordd . $student['enroll'] . '.JPG';


                              if (file_exists($filename2)) {  ?>

                                 <img style="width: 85px;
                     height: 85px;
                     float: left;
                     margin-top: -17px;" class="center-block img-circle img-thumbnail profile-img" src="<?php echo SITE_URL . $db['db']; ?>schools/<?php echo
                                                                                                                                                $bordd . $student['enroll']; ?>.JPG" alt="No Image">


                              <?php } else { ?>
                                 <img class="center-block img-circle img-thumbnail profile-img" src="<?php echo SITE_URL; ?>images/stu-image.png" alt="No Image">
                              <?php } ?>

                              <span class="username">
                                 <a href="<?php echo ADMIN_URL; ?>students/view/<?php echo $student['id']; ?>"><?php echo ucfirst($student['fname']); ?> <?php echo ucfirst($student['middlename']); ?> <?php echo ucfirst($student['lname']); ?></a> (<b style="color:green;"><?php echo $student['enroll']; ?></b>)
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
                                       <? if ($student['category'] != "") {  ?>
                                          <!------------------------------------------------------------Fee Deposit Form Start---------------------------------------------->
                                          <form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="sevice_form" validate="validate" action="<?php echo ADMIN_URL; ?>Monthlyfees/add">
                                             <input type="hidden" name="token" value="<?php echo uniqid(); ?>">
                                             <p style="text-align:center;"><input type="checkbox" name="is_special" value="1" class="check-alls"><span style="font-size:20px;"> Is Special</span> </p>
                                             <div class="row">
                                                <div class="col-lg-6">
                                                   <?php if (!in_array("Admission Fee", $qua) || !in_array("Development Fee", $qua) || !in_array("Caution Money", $qua)  || !in_array("Miscellaneous Fee", $qua)  || !in_array("Quater1", $qua)  || !in_array("Quater2", $qua) || !in_array("Quater3", $qua) || !in_array("Quater4", $qua)) { ?>
                                                      <? if ($student['category'] == "RTE" || $student['category'] == "Migration") { ?>
                                                         <table class="table table-striped table-hover table-condensed 
					 	table-responsive" id="mytable2">

                                                         <? } else {  ?>
                                                            <table class="table table-striped table-hover table-condensed 
					 	table-responsive" id="mytable">
                                                            <? } ?>
                                                            <tbody>
                                                               <tr class="table_header">
                                                                  <th class="bg-teal color-palette"></th>
                                                                  <th class="text-left bg-teal color-palette"> Heads </th>
                                                                  <th class="text-left bg-teal color-palette"> Last Date </th>
                                                                  <th class="text-center bg-teal color-palette"> Fee </th>
                                                               </tr>
                                                               <?php
                                                               $y = 1;
                                                               foreach ($classFees as $classFee) {
                                                               ?>

                                                                  <?php
                                                                  if (!array_key_exists('Admission Fee', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Admission Fee') {
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu1_date']));
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" class="StuAttendCk" name="amount[Admission Fee]" value="<?php echo $classFee['qu1_fees']; ?>" data-date="" data-discount="<?php echo !empty($studentDiscount['Admission Fee']) ? $studentDiscount['Admission Fee'] : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name']; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $classFee['qu1_fees']; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
		                                       16px;color:red;display:none;" data-name="Admission Fee" data-value="<?php echo $classFee['qu1_fees']; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php  }
                                                                  if (!array_key_exists('Annual Charges', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Annual Charges') {
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu1_date']));
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" id="chk<? echo $y; ?>1-<?php echo $classFee['qu1_fees']; ?>" class="StuAttendCk imp news" name="amount[Annual Charges]" value="<?php echo $classFee['qu1_fees']; ?>" data-date="" data-discount="<?php echo !empty($studentDiscount['Annual Charges']) ? $studentDiscount['Annual Charges'] : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name']; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $classFee['qu1_fees']; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
                                                16px;color:red;display:none;" data-name="Annual Charges" data-value="<?php echo $classFee['qu1_fees']; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php  }
                                                                  if (!array_key_exists('Development Fee', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Development Fee') {
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu1_date']));
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" id="chk<? echo $y; ?>1-<?php echo $classFee['qu1_fees']; ?>" class="StuAttendCk imp news" name="amount[Development Fee]" value="<?php echo $classFee['qu1_fees']; ?>" data-date="" data-discount="<?php echo !empty($studentDiscount['Development Fee']) ? $studentDiscount['Development Fee'] : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name']; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $classFee['qu1_fees']; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
		                                       16px;color:red;display:none;" data-name="Development Fee" data-value="<?php echo $classFee['qu1_fees']; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php }
                                                                  if (!array_key_exists('Caution Money', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Caution Money') {
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu1_date']));
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" id="chk<? echo $y; ?>1-<?php echo $classFee['qu1_fees']; ?>" class="StuAttendCk imp news" name="amount[Caution Money]" value="<?php echo $classFee['qu1_fees']; ?>" data-date="" data-discount="<?php echo !empty($studentDiscount['Caution Money']) ? $studentDiscount['Caution Money'] : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name']; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $classFee['qu1_fees']; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
                                                16px;color:red;display:none;" data-name="Caution Money" data-value="<?php echo $classFee['qu1_fees']; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php
                                                                  }
                                                                  if (!array_key_exists('Miscellaneous Fee', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Miscellaneous Fee') {
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu1_date']));
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" id="chk<? echo $y; ?>1-<?php echo $classFee['qu1_fees']; ?>" class="StuAttendCk imp news" name="amount[Miscellaneous Fee]" value="<?php echo $classFee['qu1_fees']; ?>" data-date="" data-discount="<?php echo !empty($studentDiscount['Miscellaneous Fee']) ? $studentDiscount['Miscellaneous Fee'] : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name']; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $classFee['qu1_fees']; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
                                                16px;color:red;display:none;" data-name="Miscellaneous Fee" data-value="<?php echo $classFee['qu1_fees']; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php
                                                                  }
                                                                  if (!array_key_exists('April', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Tution Fee') {
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu1_date']));
                                                                     $fees = $classFee['qu1_fees'] / 3;
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" id="chk<? echo $y; ?>1-<?php echo $fees; ?>" value="<?php echo $fees ?>" class="StuAttendCk imp news" name="amount[April]" data-date="<?php echo date('Y', strtotime($dat)); ?>-04-<?php echo date('d', strtotime($dat)); ?>" data-discount="<?php echo !empty($studentDiscount['Tution Fee']) ? $studentDiscount['Tution Fee'] / 3 : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name'] . '(April)'; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $fees; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
                                                16px;color:red;display:none;" data-name="April" data-value="<?php echo $fees; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php
                                                                  }
                                                                  if (!array_key_exists('May', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Tution Fee') {
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu1_date']));
                                                                     $fees = $classFee['qu1_fees'] / 3;
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" id="chk<? echo $y; ?>1-<?php echo $fees; ?>" value="<?php echo $fees ?>" class="StuAttendCk imp news" name="amount[May]" data-date="<?php echo date('Y', strtotime($dat)); ?>-05-<?php echo date('d', strtotime($dat)); ?>" data-discount="<?php echo !empty($studentDiscount['Tution Fee']) ? $studentDiscount['Tution Fee'] / 3 : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name'] . '(May)'; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $fees; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
                                                16px;color:red;display:none;" data-name="May" data-value="<?php echo $fees; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php }
                                                                  if (!array_key_exists('June', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Tution Fee') {
                                                                     $fees = $classFee['qu1_fees'] / 3;
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu1_date']));
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" id="chk<? echo $y; ?>1-<?php echo $fees; ?>" value="<?php echo $fees ?>" class="StuAttendCk imp news" name="amount[June]" data-date="<?php echo date('Y', strtotime($dat)); ?>-06-<?php echo date('d', strtotime($dat)); ?>" data-discount="<?php echo !empty($studentDiscount['Tution Fee']) ? $studentDiscount['Tution Fee'] / 3 : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name'] . '(June)'; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $fees; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
                                                16px;color:red;display:none;" data-name="June" data-value="<?php echo $fees; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php }
                                                                  if (!array_key_exists('July', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Tution Fee') {
                                                                     $fees = $classFee['qu2_fees'] / 3;
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu2_date']));
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" id="chk<? echo $y; ?>1-<?php echo $fees; ?>" value="<?php echo $fees ?>" class="StuAttendCk imp news" name="amount[July]" data-date="<?php echo date('Y', strtotime($dat)); ?>-07-<?php echo date('d', strtotime($dat)); ?>" data-discount="<?php echo !empty($studentDiscount['Tution Fee']) ? $studentDiscount['Tution Fee'] / 3 : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name'] . '(July)'; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $fees; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
                                                16px;color:red;display:none;" data-name="July" data-value="<?php echo $fees; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php  }
                                                                  if (!array_key_exists('August', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Tution Fee') {
                                                                     $fees = $classFee['qu2_fees'] / 3;
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu2_date']));
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" id="chk<? echo $y; ?>1-<?php echo $fees; ?>" value="<?php echo $fees ?>" class="StuAttendCk imp news" name="amount[August]" data-date="<?php echo date('Y', strtotime($dat)); ?>-08-<?php echo date('d', strtotime($dat)); ?>" data-discount="<?php echo !empty($studentDiscount['Tution Fee']) ? $studentDiscount['Tution Fee'] / 3 : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name'] . '(August)'; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $fees; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
                                                16px;color:red;display:none;" data-name="August" data-value="<?php echo $fees; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php  }
                                                                  if (!array_key_exists('September', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Tution Fee') {
                                                                     $fees = $classFee['qu2_fees'] / 3;
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu2_date']));
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" id="chk<? echo $y; ?>1-<?php echo $fees; ?>" value="<?php echo $fees ?>" class="StuAttendCk imp news" name="amount[September]" data-date="<?php echo date('Y', strtotime($dat)); ?>-09-<?php echo date('d', strtotime($dat)); ?>" data-discount="<?php echo !empty($studentDiscount['Tution Fee']) ? $studentDiscount['Tution Fee'] / 3 : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name'] . '(September)'; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $fees; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
                                                16px;color:red;display:none;" data-name="September" data-value="<?php echo $fees; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php }
                                                                  if (!array_key_exists('October', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Tution Fee') {
                                                                     $fees = $classFee['qu3_fees'] / 3;
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu3_date']));
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" id="chk<? echo $y; ?>1-<?php echo $fees; ?>" value="<?php echo $fees ?>" class="StuAttendCk imp news" name="amount[October]" data-date="<?php echo date('Y', strtotime($dat)); ?>-10-<?php echo date('d', strtotime($dat)); ?>" data-discount="<?php echo !empty($studentDiscount['Tution Fee'] / 3) ? $studentDiscount['Tution Fee'] / 3 : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name'] . '(October)'; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $fees; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
                                                16px;color:red;display:none;" data-name="October" data-value="<?php echo $fees; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php }
                                                                  if (!array_key_exists('November', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Tution Fee') {
                                                                     $fees = $classFee['qu3_fees'] / 3;
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu3_date']));
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" id="chk<? echo $y; ?>1-<?php echo $fees; ?>" value="<?php echo $fees ?>" class="StuAttendCk imp news" name="amount[November]" data-date="<?php echo date('Y', strtotime($dat)); ?>-11-<?php echo date('d', strtotime($dat)); ?>" data-discount="<?php echo !empty($studentDiscount['Tution Fee']) ? $studentDiscount['Tution Fee'] / 3 : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name'] . '(November)'; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $fees; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
                                                16px;color:red;display:none;" data-name="November" data-value="<?php echo $fees; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php  }
                                                                  if (!array_key_exists('December', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Tution Fee') {
                                                                     $fees = $classFee['qu3_fees'] / 3;
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu3_date']));
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" id="chk<? echo $y; ?>1-<?php echo $fees; ?>" value="<?php echo $fees ?>" class="StuAttendCk imp news" name="amount[December]" data-date="<?php echo date('Y', strtotime($dat)); ?>-12-<?php echo date('d', strtotime($dat)); ?>" data-discount="<?php echo !empty($studentDiscount['Tution Fee']) ? $studentDiscount['Tution Fee'] / 3 : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name'] . '(December)'; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $fees; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
                                                16px;color:red;display:none;" data-name="December" data-value="<?php echo $fees; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php }
                                                                  if (!array_key_exists('January', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Tution Fee') {
                                                                     $fees = $classFee['qu4_fees'] / 3;
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu4_date']));
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" id="chk<? echo $y; ?>1-<?php echo $fees; ?>" value="<?php echo $fees ?>" class="StuAttendCk imp news" name="amount[January]" data-date="<?php echo date('Y', strtotime($dat)); ?>-01-<?php echo date('d', strtotime($dat)); ?>" data-discount="<?php echo !empty($studentDiscount['Tution Fee']) ? $studentDiscount['Tution Fee'] / 3 : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name'] . '(January)'; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $fees; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
                                                16px;color:red;display:none;" data-name="January" data-value="<?php echo $fees; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php }
                                                                  if (!array_key_exists('February', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Tution Fee') {
                                                                     $fees = $classFee['qu4_fees'] / 3;
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu4_date']));
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" id="chk<? echo $y; ?>1-<?php echo $fees; ?>" value="<?php echo $fees ?>" class="StuAttendCk imp news" name="amount[February]" data-date="<?php echo date('Y', strtotime($dat)); ?>-02-<?php echo date('d', strtotime($dat)); ?>" data-discount="<?php echo !empty($studentDiscount['Tution Fee']) ? $studentDiscount['Tution Fee'] / 3 : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name'] . '(February)'; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $fees; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
                                                16px;color:red;display:none;" data-name="February" data-value="<?php echo $fees; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php }
                                                                  if (!array_key_exists('March', $studentPaidHeads) && $classFee['feeshead']['name'] == 'Tution Fee') {
                                                                     $fees = $classFee['qu4_fees'] / 3;
                                                                     $dat = date('Y-m-d', strtotime($classFee['qu4_date']));
                                                                  ?>
                                                                     <tr>
                                                                        <td style="width:4px;"><label><input type="checkbox" id="chk<? echo $y; ?>1-<?php echo $fees; ?>" value="<?php echo $fees ?>" class="StuAttendCk imp news" name="amount[March]" data-date="<?php echo date('Y', strtotime($dat)); ?>-03-<?php echo date('d', strtotime($dat)); ?>" data-discount="<?php echo !empty($studentDiscount['Tution Fee']) ? $studentDiscount['Tution Fee'] / 3 : '0'; ?>"></label></td>
                                                                        <td><?php echo $classFee['feeshead']['name'] . '(March)'; ?></td>
                                                                        <td><?php
                                                                              if ($dat != '1970-01-01') {
                                                                                 echo date('d-m-Y', strtotime($dat));
                                                                              } ?></td>
                                                                        <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                    if ($dat != '1970-01-01') { //echo number_format($value['qu'.$jk.'_fees']); 
                                                                                                                                    ?>
                                                                              <input type="text" name="amountl[]" style="width: 34%;" maxlength="6" minlength="1" id="amoun1" readonly="readonly" class="amounedit" value="<? echo $fees; ?>">&nbsp;&nbsp;
                                                                              <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 
                                                16px;color:red;display:none;" data-name="March" data-value="<?php echo $fees; ?>"><i class="fa fa-times"></i></a>
                                                                           <?
                                                                                                                                    } else {
                                                                                                                                       echo "not-set";
                                                                                                                                    } ?>
                                                                        </td>
                                                                     </tr>
                                                                  <?php }

                                                                  ?>
                                                               <?php $y++;
                                                               } ?>
                                                            </tbody>
                                                            </table>
                                                         <?php } ?>

                                                         <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
                                                            <tbody>
                                                               <tr class="table_header">
                                                                  <th class="bg-teal color-palette"></th>
                                                                  <th style="width: 27%;" class="bg-teal color-palette">Reference No.</th>
                                                                  <th class="text-left bg-teal color-palette">Paydate </th>
                                                                  <th class="text-left bg-teal color-palette"> Amount </th>
                                                                  <th class="text-left bg-teal color-palette"> Print </th>
                                                               </tr>
                                                               <?php if (!empty($notSpecialFees)) {
                                                                  $cnt = 1;
                                                                  foreach ($notSpecialFees as $studentfee) {
                                                               ?>
                                                                     <tr>
                                                                        <td><label></label></td>
                                                                        <td><?php echo $cnt; ?></td>
                                                                        <td>
                                                                           <?php echo date('d-m-Y', strtotime($studentfee['paydate'])); ?>
                                                                        </td>
                                                                        <td>
                                                                           <script src="/js/admin/confirmation.js"></script>
                                                                           <span class="text-black">₹ </span> <?php echo $studentfee['deposite_amt']; ?>
                                                                        </td>
                                                                        <td>
                                                                           <a title="Print Receipt" target="_blank" href="<?php echo ADMIN_URL; ?>studentfees/printsadmission/<?php echo $studentfee['id']; ?>/<? echo $academic_year; ?>"><i class="fa fa-file-text-o"></i></a>
                                                                           <a title="Cancel Receipt" class="modalcancel" data-toggle="modal" data-id="<?php echo $studentfee['id']; ?>" data-receiptno="<?php echo $studentfee['recipetno']; ?>" data-options="<? echo $academic_year; ?>" data-target="#myModal"><i class="fa fa-remove"></i></a>
                                                                        </td>
                                                                     </tr>
                                                                  <?php $cnt++;
                                                                  }
                                                               } else { ?>
                                                                  <tr>
                                                                     <td colspan="5">No Paid History Found</td>
                                                                  </tr>
                                                               <?php } ?>

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
                                                <div class="col-lg-6">
                                                   <!------ remove special field------->
                                                   <div id="special-fileds"></div>
                                                   <!----------------------------------------------------- For Pending Fee Show---------------------------------------->
                                                   <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
                                                      <tbody>
                                                         <tr class="table_header">
                                                            <th class="bg-teal color-palette" style=""></th>
                                                            <th style="width: 51%;" class="bg-teal color-palette">Description</th>
                                                            <th class="text-center bg-teal color-palette"> Due Fee </th>
                                                            <th class="text-right bg-teal color-palette"> Status </th>
                                                         </tr>
                                                         <?php if (!empty($studentFeePendings)) {
                                                            foreach ($studentFeePendings as $studentFeePending) { ?>
                                                               <tr>
                                                                  <td style="width:4px;">
                                                                     <label><input id="chk51--40" class="StuAttendCkrg" name="pending[amount]" value="<?php echo $studentFeePending['amt']; ?>" type="checkbox">
                                                                     </label>
                                                                  </td>
                                                                  <td style="width:4px;">
                                                                     <input name="pending[reference_id]" value="<?php echo $studentFeePending['r_id']; ?>" type="hidden">
                                                                     <input name="hdfb" id="hdfbd" type="hidden" value="2">
                                                                     <input name="pending[id]" value="<?php echo $studentFeePending['id']; ?>" type="hidden">
                                                                     Pending As Per Reference No <?php echo $studentFeePending['id']; ?> </label>
                                                                  </td>
                                                                  <td class="text-center">
                                                                     <span class="text-black">₹ </span><?php echo $studentFeePending['amt']; ?>
                                                                  </td>
                                                                  <td class="text-right"><? if ($studentFeePending['amt'] < 0) { ?> Extra Paid <? } else { ?> Pending<? } ?></td>
                                                               </tr>
                                                            <?php }
                                                         } else { ?> <tr>
                                                               <td colspan="3">No Pending Fees</td>
                                                            </tr> <?php } ?>
                                                      </tbody>
                                                   </table>
                                                   <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
                                                      <tbody class="after-add-more"></tbody>
                                                      <tbody>
                                                         <tr class="assets_container">
                                                            <td colspan="4" width="50%">
                                                               <b>Other Fee Charge : &nbsp; </b>
                                                               <select name="otherfee[0][]" class="chkotherfeer" id="chkotherfee" onChange="chkotherfsees('chkotherfee');" data-id="">
                                                                  <option value="">- Add Other Fee -</option>
                                                                  <?php foreach ($feeHeads as $ky => $item) { ?>
                                                                     <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                                                                  <? } ?>
                                                               </select>
                                                            </td>
                                                            <td colspan="2" width="50%">
                                                               <b><br> </b>
                                                               <input name="otherfee[0][]" readonly="readonly" id="otherfeeamts" value="0" placeholder="Enter Amount" type="number">
                                                            </td>
                                                            <td class="col-sm-2" class="subtype" style="position:relative;">
                                                               <label></label>
                                                               <a href="javascript:void(0);" class="add_field_butto" style="font-weight: bold; font-size: 21px;margin-top: 23px;"><i class="fa fa-plus-circle"></i></a>
                                                            </td>
                                                         </tr>
                                                         <?php if (!empty($practicalFee)) { ?>
                                                            <tr>
                                                               <td colspan="4" width="50%"> <input type="checkbox" id="practicalFeeBox" class="" name="amount[]" value="0" disabled>
                                                                  <label>Practical Fees</label>
                                                               </td>
                                                               <td colspan="2" width="50%">
                                                                  <input name="practical_fee" type="text" value="<?php echo $practicalFee; ?>" class="form-control" readonly="readonly" id="practicalFeeId" maxlength="9" placeholder="Practical Fee">
                                                               </td>
                                                            </tr>
                                                         <?php } ?>
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
                                                                  <?php foreach ($discountCategorylist as $ky => $item) { ?>
                                                                     <option value="<?php echo $item['id']; ?>" <?php if ($item['name'] == $discountCategory) { ?> selected="selected" <? } ?>><?php echo $item['name']; ?></option>

                                                                  <? } ?>
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
                                                               <input type="hidden" name="discountcategorys" id="discountcategorys" value="<?php echo $discountCategory; ?>">
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
                                                               <b>Due Amount :&nbsp;</b><span id="sum1">0.00</span><input type="hidden" id="dueextras" name="dueextra" value="0">
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
                                                            <?php if ($discountCategory != '') { ?>
                                                               <td colspan="4" width="50%" style="color:red;">
                                                                  <b>Discount Taken :</b> <?php echo $discountCategory; ?>

                                                               </td>
                                                            <? } ?>
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
                                                               <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                                                            </td>
                                                         </tr>
                                                      </tbody>
                                                   </table>
                                                </div>
                                             </div>
                                             <div class="box-footer">

                                                <?php
                                                if (isset($classes['id'])) {
                                                   echo $this->Form->submit(
                                                      'Take Fee',
                                                      array('class' => 'btn btn-info pull-right', 'title' => 'Update')
                                                   );
                                                } else {
                                                   echo $this->Form->submit(
                                                      'Take Fee',
                                                      array('class' => 'btn btn-info pull-right addgen', 'title' => 'Take Fee', 'style' => 'display:none;')
                                                   );
                                                   echo $this->Form->submit(
                                                      'Cancel Recipiet',
                                                      array('class' => 'btn btn-info pull-right addgen23', 'title' => 'Cancel Recipiet', 'style' => 'display:none;')
                                                   );
                                                }
                                                ?>
                                                <?php
                                                echo $this->Html->link('Back', [
                                                   'action' => 'view'

                                                ], ['class' => 'btn btn-default']); ?>

                                             </div>
                                          <?
                                          echo $this->Form->end();
                                       } else { ?>
                                             <table class="table table-striped table-hover" id="mytable">

                                                <tbody>

                                                   <tr class="table_header">
                                                      <th style="text-align:center;"> No Fees Structure for RTE Student!!</th>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          <? } ?>
                                          <!-- Modal -->
                                          <div class="modal fade" id="myModal" role="dialog">
                                             <div class="modal-dialog">
                                                <form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="sevice_formtest" validate="validate" action="<?php echo ADMIN_URL; ?>Monthlyfees/cancelledstudent">
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

<script>
   $(document).ready(function() {
      var x = 1;

      $(".add_field_butto").click(function() {
         $('.after-add-more').append('<tr class="assets_container asset2"><td colspan="4" width="50%"><b>Other Fee Charge : &nbsp; </b><select name="otherfee[' + x + '][]" id="chkotherfee' + x + '"  class="chkotherfeer"  style="width:86%" data-id="' + x + '"><option value="">- Add Other Fee -</option><? foreach ($feeHeads as $ky => $item) { ?>  <option value="<?php echo $item["id"]; ?>"><?php echo $item["name"]; ?></option> <? } ?></select></td><td colspan="2" width="50%"><b><br> </b><input name="otherfee[' + x + '][]" readonly="readonly" id="otherfeeamts' + x + '" value="0" placeholder="Enter Amount" type="number"> </td><td class="col-sm-2" class="subtype" style="position:relative;" ><label></label><a href="javascript:void(0);" class="remove" id="removes' + x + '" onclick="calculatremain(' + x + ')" style="font-weight: bold; font-size: 21px;margin-top: 23px;position: absolute;"><i class="fa fa-minus-circle"></i></a> </td></tr>');
         x++;
      });

      $("body").on("click", ".remove", function() {
         // $(this).closest('.assets_container').remove();
      });

   });
</script>
<script>
   function calculatremain(sx) {
      var sums0h = 0;

      $("#otherfeeamts" + sx).each(function() {

         if (!isNaN(this.value) && this.value.length != 0) {
            sums0h += parseFloat(this.value);
            $(this).css("background-color", "#FEFFB0");
         } else if (this.value.length != 0) {
            $(this).css("background-color", "red");
         }
      });


      if (sums0h == '0') {

         $('#removes' + sx).closest('.assets_container').remove();

         var ssx = "#chkotherfee" + sx;
         $(ssx + ' option[value=" "]').attr("selected", true);


      }
   }
</script>
<script>
   $(document).on("change", "select.chkotherfeer", function() {
      let boxId = $(this).data('id');
      let opt = $(this).val();
      let boardst = '<?php echo $student['board_id']; ?>';
      $.ajax({
         async: false,
         type: 'POST',
         data: {
            boardst,
            opt
         },
         url: "<?php echo ADMIN_URL; ?>Studentfees/findotherfees",
         success: function(data) {
            $('#otherfeeamts' + boxId).val(data);
         }
      });
   });

   function checks(id) {
      var doc = $('input[name="mode"]:checked').val();
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
         var lastchequ = '<? echo $student_datasmaxssss; ?>';
         $("#chequno").val(lastchequ);
         var lastbank = '<? echo $student_databank; ?>';
         $("#bank").val(lastbank);
         document.getElementById('chequno').required = true;
         document.getElementById('bank').required = true;
         document.getElementById('refno').required = false;

      } else if (doc == "DD") {

         $("#che").show();

         $("#ref").hide();
         $("#bnk").show();
         var lastchequ = '<? echo $student_datasmaxssss; ?>';
         $("#chequno").val(lastchequ);
         var lastbank = '<? echo $student_databank; ?>';
         $("#bank").val(lastbank);
         document.getElementById('chequno').required = true;
         document.getElementById('bank').required = true;
         document.getElementById('refno').required = false;

      } else if (doc == "NETBANKING") {

         $("#ref").show();
         $("#che").hide();
         var lastref = '<? echo $student_datasmref_no; ?>';
         $("#bnk").hide();
         $("#refno").val(lastref);
         document.getElementById('chequno').required = false;
         document.getElementById('refno').required = true;
         document.getElementById('bank').required = false;

      } else if (doc == "Credit Card/Debit Card/UPI") {

         $("#ref").show();

         $("#che").hide();
         $("#bnk").hide();
         var lastref = '<? echo $student_datasmref_no; ?>';
         $("#refno").val(lastref);
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
</script>
<script>
   let totalDiscount = 0;
   let netFee = 0;
   let totalFee = 0;
   let dueAmount = 0;
   $(document).ready(function() {
      $('.StuAttendCk').click(function() {
         let currentDate = new Date();
         let lastDate = $(this).data('date');
         let lastDateTime = new Date(lastDate + ' 11:55 PM');
         let perDayFine = '<?php echo $perDayFine; ?>';
         let diffDays;
         let fine;
         let PracticalFee = "<?php echo $practicalFee; ?>";
         let totalPracticalFee = $('#practicalFeeBox').val();
         let discount = $(this).data('discount');
         let fee = $(this).val();
         let practicalFeeCount = 0;
         let lateFee = $('#lfines').val();
         $('.addgen').show();
         if (lastDate !== "" && $(this).prop("checked") && (currentDate > lastDateTime)) {
            diffDays = Math.ceil((currentDate - lastDateTime) / (1000 * 60 * 60 * 24));
            fine = diffDays * perDayFine;
            lateFee = parseInt(lateFee) + parseInt(fine);
            $('#lfines').val(lateFee);
         } else if (!$(this).prop("checked") && currentDate > lastDateTime) {
            diffDays = Math.ceil((currentDate - lastDateTime) / (1000 * 60 * 60 * 24));
            fine = diffDays * perDayFine;
            lateFee = parseInt(lateFee) - parseInt(fine);
            $('#lfines').val(lateFee);
         }
         let month = parseInt(lastDateTime.getMonth()) + parseInt(1);
         if ((month == '04' || month == "07" || month == "10" || month == "01") && PracticalFee !== "") {
            if (month == '04' && $(this).prop("checked")) {
               totalPracticalFee = parseInt(totalPracticalFee) + parseInt(PracticalFee);
               $('#practicalFeeBox').val(totalPracticalFee);
               $('#practicalFeeId').val(totalPracticalFee);
            }
            if (month == '07' && $(this).prop("checked")) {
               totalPracticalFee = parseInt(totalPracticalFee) + parseInt(PracticalFee);
               $('#practicalFeeBox').val(totalPracticalFee);
               $('#practicalFeeId').val(totalPracticalFee);
            }
            if (month == '10' && $(this).prop("checked")) {
               totalPracticalFee = parseInt(totalPracticalFee) + parseInt(PracticalFee);
               $('#practicalFeeBox').val(totalPracticalFee);
               $('#practicalFeeId').val(totalPracticalFee);
            }
            if (month == '01' && $(this).prop("checked")) {
               totalPracticalFee = parseInt(totalPracticalFee) + parseInt(PracticalFee);
               $('#practicalFeeBox').val(totalPracticalFee);
               $('#practicalFeeId').val(totalPracticalFee);
            }
            if (month == '04' && !$(this).prop("checked")) {
               totalPracticalFee = parseInt(totalPracticalFee) - parseInt(PracticalFee);
               $('#practicalFeeBox').val(totalPracticalFee);
               $('#practicalFeeId').val(totalPracticalFee);
            }
            if (month == '07' && !$(this).prop("checked")) {
               totalPracticalFee = parseInt(totalPracticalFee) - parseInt(PracticalFee);
               $('#practicalFeeBox').val(totalPracticalFee);
               $('#practicalFeeId').val(totalPracticalFee);
            }
            if (month == '10' && !$(this).prop("checked")) {
               totalPracticalFee = parseInt(totalPracticalFee) - parseInt(PracticalFee);
               $('#practicalFeeBox').val(totalPracticalFee);
               $('#practicalFeeId').val(totalPracticalFee);
            }
            if (month == '01' && !$(this).prop("checked")) {
               totalPracticalFee = parseInt(totalPracticalFee) - parseInt(PracticalFee);
               $('#practicalFeeBox').val(totalPracticalFee);
               $('#practicalFeeId').val(totalPracticalFee);
            }
            $('#practicalFeeBox').attr('checked', true);

         }
         if ($(this).prop("checked")) {
            totalFee = parseInt(totalFee) + parseInt(fee);
            totalDiscount = parseInt(totalDiscount) + parseInt(discount);
         }
         if (!$(this).prop("checked")) {
            totalFee = parseInt(totalFee) - parseInt(fee);
            totalDiscount = parseInt(totalDiscount) - parseInt(discount);
         }
         let currentLateFee = $('#lfines').val();
         let addDiscount = $('#additionaldis').val();
         netFee = parseInt(totalFee) - parseInt(totalDiscount) + parseInt(currentLateFee) - parseInt(addDiscount);
         $('.tamount').html(totalFee);
         $('.newamnt').html(netFee);
         $('.discnt').html(totalDiscount);
         $('#fees_discount').val(totalDiscount);
      });
      $('#lfines').keyup(function() {
         let currentLateFee = $(this).val();
         let addDiscount = $('#additionaldis').val();
         netFee = parseInt(totalFee) - parseInt(totalDiscount) + (currentLateFee === "" ? 0 : parseInt(currentLateFee)) - parseInt(addDiscount === "" ? 0 : parseInt(addDiscount));
         $('.newamnt').html(netFee);
      })
      $('#additionaldis').keyup(function() {
         let currentLateFee = $('#lfines').val();
         let addDiscount = $(this).val();
         netFee = parseInt(totalFee) - parseInt(totalDiscount) + (currentLateFee === "" ? 0 : parseInt(currentLateFee)) - (addDiscount === "" ? 0 : parseInt(addDiscount));
         $('.newamnt').html(netFee);
      })
      $('#depositamt').keyup(function() {
         let depositAmount = $(this).val();
         dueAmount = parseInt(netFee) - (depositAmount === "" ? 0 : parseInt(depositAmount));
         $('#sum1').html(dueAmount);
         $('#dueextras').val(dueAmount);
      });
      $('.stuattendance-sa_date').datepicker({

         maxDate: 0,
         changeMonth: true,
         dateFormat: 'dd-mm-yy',
         onSelect: function() {
            $('#stud-attendance-form').submit();
         }
      });
      $('.check-alls').click(function() {
         $('.addgen').show();
         if ($(this).prop("checked")) {
            $('.remove_special').show();
            $('.StuAttendCk').attr('disabled', true);
            $('.chkotherfeer').attr('disabled', true);
            $('#lfines').attr('disabled', true);
            $('#additionaldis').attr('disabled', true);
            $('#depositamt').attr('disabled', true);
         } else {
            $('.remove_special').hide();
            $('.StuAttendCk').attr('disabled', false);
            $('.chkotherfeer').attr('disabled', false);
            $('#lfines').attr('disabled', false);
            $('#additionaldis').attr('disabled', false);
            $('#depositamt').attr('disabled', false);
         }
      });
      $('.remove_special').click(function() {
         $(this).parent().parent().remove();
         let name = $(this).data('name');
         let value = $(this).data('value');
         $('#special-fileds').append('<input type="hidden" class="fieldname" name="special[' + name + ']" value="' + value + '" />');
      });
      $('.modalcancel').click(function() {
         let id = $(this).data('id');
         let academic = $(this).data('options');
         $('.nkid').val(id);
         $('.academikid').val(academic);
      });
   });
</script>