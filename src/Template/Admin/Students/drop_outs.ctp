<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title">
      <i class="fa fa-ban" aria-hidden="true"></i> Pending Detail of <? echo ucwords(strtolower($name)); ?> (<? echo $enroll; ?>)
   </h4>
</div>
<div class="modal-body">
   <div class="row">
      <div class="col-sm-12">
         <b>Pending Detail</b>
         <? $def = 0;
            $quas = array();
            foreach ($studentfees as $k => $value) {
               $quas[] = unserialize($value['quarter']);
            }
            $quaf = array();
            foreach ($quas as $h => $vale) {
               $quaf = array_merge($quaf, $vale);
            }
            $rt = array();
            foreach ($quaf as $j => $t) {
               $qua[] = $j;
            }
            if (!in_array("Admission Fee", $qua) || !in_array("Development Fee", $qua) || !in_array("Caution Money", $qua)  || !in_array("Miscellaneous Fee", $qua)  || !in_array("Quater1", $qua)  || !in_array("Quater2", $qua) || !in_array("Quater3", $qua) || !in_array("Quater4", $qua)) {  ?>
         <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
            <tbody>
               <tr class="table_header">
                  <th class="text-left bg-teal color-palette"> Fee Heads </th>
                  <th class="text-center bg-teal color-palette"> Last Date </th>
                  <th class="text-right bg-teal color-palette"> Fee </th>
               </tr>
               <?php
                  if (isset($classfee) && !empty($classfee)) {
                     $jk = 1;
                     $kl = 0;
                     $y = 1;
                     foreach ($preclassfee as $krt => $value) {
                  ?>
               <tr>
                  <? $findfee = $this->Comman->findfeeheadsname($value['fee_h_id']); ?>
                  <? if ($findfee['name'] == "Admission Fee") {
                     if (!in_array("Admission Fee", $qua)) {  ?>
                  <? }
                     } else if ($findfee['name'] == "Caution Money") {
                        if (!in_array("Caution Money", $qua)) {  ?>
                  <? }
                     } else if ($findfee['name'] == "Development Fee") {
                        if (!in_array("Development Fee", $qua)) {  ?>
                  <? }
                     } else if ($findfee['name'] == "Miscellaneous Fee") {
                        if (!in_array("Miscellaneous Fee", $qua)) {  ?>
                  <td> <input type="text" style="background-color: transparent;border: none;" name="quater[]" id="s<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['name']; ?>" readonly disabled="">
                     <input type="hidden" style="background-color: transparent;border: none;" id="sp<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['id']; ?>" readonly disabled="">
                  </td>
                  <? }
                     } ?>
                  <? if ($findfee['name'] == "Admission Fee") {
                     if (!in_array("Admission Fee", $qua)) {  ?>
                  <? }
                     } else if ($findfee['name'] == "Caution Money") {
                        if (!in_array("Caution Money", $qua)) {  ?>
                  <? }
                     } else if ($findfee['name'] == "Development Fee") {
                        if (!in_array("Development Fee", $qua)) {  ?>
                  <? }
                     } else if ($findfee['name'] == "Miscellaneous Fee") {
                        if (!in_array("Miscellaneous Fee", $qua)) {  ?>
                  <td class="text-center"><?php $dat = date('Y-m-d', strtotime($value['qu' . $jk . '_date']));
                     if ($dat != '1970-01-01') {
                        echo date('d-m-Y', strtotime($dat));
                     } else {
                        echo "not-set";
                     } ?></td>
                  <? }
                     } ?>
                  <? if ($findfee['name'] == "Admission Fee") {
                     if (!in_array("Admission Fee", $qua)) {  ?>
                  <? }
                     } else if ($findfee['name'] == "Caution Money") {
                        if (!in_array("Caution Money", $qua)) {  ?>
                  <? }
                     } else if ($findfee['name'] == "Development Fee") {
                        if (!in_array("Development Fee", $qua)) {  ?>
                  <? }
                     } else if ($findfee['name'] == "Miscellaneous Fee") {
                        if (!in_array("Miscellaneous Fee", $qua)) {  ?>
                  <td class="text-right"><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
                     echo number_format($value['qu' . $jk . '_fees']);
                     } else {
                     echo "not-set";
                     } ?></td>
                  <? }
                     } ?>
               </tr>
               <? $y++;
                  }
                  for ($i = 1; $i < 5; $i++) {     ?>
               <tr>
                  <?php
                     $rg = $this->Comman->findclassfee($academic_class, $academic_year);
                     $currentdoate = strtotime(date('d-m-Y'));
                     $clodate = strtotime(date('Y-m-d', strtotime($rg['qu' . $i . '_date'])));
                     $kb = $i - 1;
                     $clodateprev = strtotime(date('Y-m-d', strtotime($rg['qu' . $kb . '_date'])));
                     $rg = $this->Comman->findclassfee($academic_class, $academic_year);
                     if ($i == 1) {
                        if (!in_array("Quater" . $i, $qua)) {   ?>
                  <td>
                     <input type="text" style="background-color: transparent;border: none;" value="Tution Fee (APRIL-JUNE)">
                  </td>
                  <? }
                     } else if ($i == 2) {
                        if (!in_array("Quater" . $i, $qua)) {  ?>
                  <td>
                     <input type="text" style="background-color: transparent;border: none;" value="Tution Fee (JULY-SEPT.)">
                  </td>
                  <? }
                     } else if ($i == 3) {
                        if (!in_array("Quater" . $i, $qua)) { ?>
                  <td>
                     <input type="text" style="background-color: transparent;border: none;" value="Tution Fee (OCT.-DEC.)">
                  </td>
                  <? }
                     } else if ($i == 4) {
                        if (!in_array("Quater" . $i, $qua)) { ?>
                  <td>
                     <input type="text" style="background-color: transparent;border: none;" value="Tution Fee (JAN.-MARCH)">
                  </td>
                  <? }
                     } ?>
                  <?php if (!in_array("Quater" . $i, $qua)) {  ?>
                  <input type="hidden" style="background-color: transparent;border: none;" name="quater[]" id="s<?php echo $i; ?><?php echo $classfee[0]['qu' . $i . '_fees']; ?>" value="Quater<?php echo $i; ?>" readonly disabled="">
                  <input type="hidden" style="background-color: transparent;border: none;" id="sp<?php echo $i; ?><?php echo $classfee[0]['qu' . $i . '_fees']; ?>" value="2" readonly disabled="">
                  <?php } ?>
                  <? $rg = $this->Comman->findclassfee($academic_class, $academic_year);
                     if ($i == 1) {
                        if (!in_array("Quater" . $i, $qua)) {   ?>
                  <td class="text-center"><?php $dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
                     if ($dat != '1970-01-01') {
                        echo date('d-m-Y', strtotime($dat));
                     } else {
                        echo "not-set";
                     } ?></td>
                  <? }
                     } else if ($i == 2) {
                        if (!in_array("Quater" . $i, $qua)) {  ?>
                  <td class="text-center"><?php $dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
                     if ($dat != '1970-01-01') {
                        echo date('d-m-Y', strtotime($dat));
                     } else {
                        echo "not-set";
                     } ?></td>
                  <? }
                     } else if ($i == 3) {
                        if (!in_array("Quater" . $i, $qua)) { ?>
                  <td class="text-center"><?php $dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
                     if ($dat != '1970-01-01') {
                        echo date('d-m-Y', strtotime($dat));
                     } else {
                        echo "not-set";
                     } ?></td>
                  <? }
                     } else if ($i == 4) {
                        if (!in_array("Quater" . $i, $qua)) { ?>
                  <td class="text-center"><?php $dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
                     if ($dat != '1970-01-01') {
                        echo date('d-m-Y', strtotime($dat));
                     } else {
                        echo "not-set";
                     } ?></td>
                  <? }
                     } ?>
                  <? $rg = $this->Comman->findclassfee($academic_class, $academic_year);
                     if ($i == 1) {
                        if (!in_array("Quater" . $i, $qua)) {   ?>
                  <td class="text-right"><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
                     echo number_format($classfee[0]['qu' . $i . '_fees']);
                     } else {
                     echo "not-set";
                     } ?></td>
                  <? }
                     } else if ($i == 2) {
                        if (!in_array("Quater" . $i, $qua)) {  ?>
                  <td class="text-right"><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
                     echo number_format($classfee[0]['qu' . $i . '_fees']);
                     } else {
                     echo "not-set";
                     } ?></td>
                  <? }
                     } else if ($i == 3) {
                        if (!in_array("Quater" . $i, $qua)) { ?>
                  <td class="text-right"><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
                     echo number_format($classfee[0]['qu' . $i . '_fees']);
                     } else {
                     echo "not-set";
                     } ?></td>
                  <? }
                     } else if ($i == 4) {
                        if (!in_array("Quater" . $i, $qua)) { ?>
                  <td class="text-right"><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
                     echo number_format($classfee[0]['qu' . $i . '_fees']);
                     } else {
                     echo "not-set";
                     } ?></td>
                  <? }
                     } ?>
               </tr>
               <?php }
                  } ?>
            </tbody>
         </table>
         <? } ?>
         <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
            <tbody>
               <tr class="table_header">
                  <th style="width: 51%;" class="bg-teal color-palette">Due Description</th>
                  <th class="text-right bg-teal color-palette"> Due Fee </th>
                  <th class="text-right bg-teal color-palette"> Status </th>
               </tr>
               <?
                  $nk = "51";
                  if ($student_feepending) {
                     foreach ($student_feepending as $val) {  ?>
               <tr>
                  <td style="width:4px;">
                     <label>
                     Pending As Per Reference No <?php echo $val['r_id']; ?>
                     </label>
                  </td>
                  <td class="text-right">
                     <span class="text-black">₹ </span><?php echo round($val['amt']); ?>
                  </td>
                  <td class="text-right">Pending</td>
               </tr>
               <? $nk++;
                  }
                  } else { ?>
               <tr>
                  <td colspan="4" class="text-center">No Pending Fees Yet</td>
               </tr>
               <? } ?>
            </tbody>
         </table>
         <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
            <tbody>
               <tr class="table_header">
                  <th style="width: 51%;" class="text-left bg-teal color-palette">Issue Book Name</th>
                  <th class="text-right bg-teal color-palette"> Issue Date </th>
                  <th class="text-right bg-teal color-palette"> Due Date </th>
               </tr>
               <?
                  if ($issueBook) {
                     foreach ($issueBook as $val) {  ?>
               <tr>
                  <td class="text-left">
                     <?php $namebook = $this->Comman->findbooknameaccession($val['asn_no']);
                        echo $namebook['name']; ?>
                  </td>
                  <td class="text-right">
                     <?php echo date('d-m-Y', strtotime($val['issue_date'])); ?>
                  </td>
                  <td class="text-right">
                     <?php echo date('d-m-Y', strtotime($val['due_date'])); ?>
                  </td>
               </tr>
               <?  }
                  } else { ?>
               <tr>
                  <td colspan="4" class="text-center">No Issue Book Yet</td>
               </tr>
               <? } ?>
            </tbody>
         </table>
         <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
            <tbody>
               <tr class="table_header">
                  <th class="text-left bg-teal color-palette"> Receipt No.</th>
                  <th class="text-left bg-teal color-palette"> Description </th>
                  <th class="text-left bg-teal color-palette"> Mode</th>
                  <th class="text-left bg-teal color-palette"> Cheque no. </th>
                  <th class="text-left bg-teal color-palette"> Deposit</th>
                  <th class="text-right bg-teal color-palette"> Paydate </th>
               </tr>
               <?
                  if ($studentfeesk) {
                     $rrr = 0;
                     foreach ($studentfeesk as $vals) {
                        $rrr = '1'; ?>
               <tr>
                  <td class="text-left">
                     <?php echo $vals['recipetno']; ?>
                  </td>
                  <td class="text-left">
                     <?php
                        $quasu = unserialize($vals['quarter']);
                        foreach ($quasu as $ke => $valur) {
                           $resulat = preg_replace("/[^a-zA-Z0-9]+/", "", $ke);
                           echo $resulat . "<br>";
                        }  ?>
                  </td>
                  <td class="text-left">
                     <?php echo $vals['mode']; ?>
                  </td>
                  <td class="text-left">
                     <?php if ($vals['mode'] == 'CHEQUE') {
                        echo $vals['cheque_no'];
                        } else {
                        echo "N/A";
                        } ?>
                  </td>
                  <td class="text-left">
                     <?php echo $vals['deposite_amt']; ?>
                  </td>
                  <td class="text-right">
                     <?php echo date('d-m-Y', strtotime($vals['paydate'])); ?>
                  </td>
               </tr>
               <?   }
                  } ?>
               <?
                  if ($studentfeeshj4) {
                     $rrr = 0;
                     foreach ($studentfeeshj4 as $vals) {
                        $rrr = '1'; ?>
               <tr>
                  <td class="text-left">
                     <?php echo $vals['recipetno']; ?>
                  </td>
                  <td class="text-left">
                     <?php
                        $quasu = unserialize($vals['quarter']);
                        foreach ($quasu as $ke => $valur) {
                           $resulat = preg_replace("/[^a-zA-Z0-9]+/", "", $ke);
                           echo $resulat . "<br>";
                        }  ?>
                  </td>
                  <td class="text-left">
                     <?php echo $vals['mode']; ?>
                  </td>
                  <td class="text-left">
                     <?php if ($vals['mode'] == 'CHEQUE') {
                        echo $vals['cheque_no'];
                        } else {
                        echo "N/A";
                        } ?>
                  </td>
                  <td class="text-left">
                     <?php echo $vals['deposite_amt']; ?>
                  </td>
                  <td class="text-right">
                     <?php echo date('d-m-Y', strtotime($vals['paydate'])); ?>
                  </td>
               </tr>
               <?   }
                  } ?>
            </tbody>
         </table>
         <label style="color: red;"><? if ($rrr == '1') { ?>Kindly Verify Cheque Deposit Fess are Clear or Not <label style="color: red;">?</label><? } ?>
      </div>
   </div>
</div>
<div class="modal-footer">
   <button data-dismiss="modal" class="btn btn-default pull-right" type="button">Cancel</button>
</div>