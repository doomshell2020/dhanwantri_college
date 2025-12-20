<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title">
      <i class="fa fa-info-circle" aria-hidden="true"></i> Pending Detail For Scholar No.<? echo $enroll; ?>
   </h4>
</div>
<?php echo $this->Form->create(null, ['class' => 'form-horizontal']); ?>
<div class="modal-body">
   <div class="row">
      <div class="col-sm-12">
         <span class="description">
         <strong>Name </strong> : <?php echo $fname . " " . $middlename . " " . $lname; ?> |
         <strong>Class </strong> : <?php echo $ctitle; ?> |
         <strong>Section </strong> : <?php echo $stitle; ?>
         </span>
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
                  <th class="text-left bg-teal color-palette" align="left"> Fee Heads </th>
                  <th class="text-center bg-teal color-palette" align="left"> Last Date </th>
                  <th class="text-center bg-teal color-palette" align="left">
                     Discount 
                  </th>
                  <th class="text-right bg-teal color-palette" style="width: 19%;" align="left">
                     Due Fee 
                  </th>
                  <? if (
                     $class_ids == 12 || $class_ids == 13 || $class_ids == 15 ||
                     $class_ids == 17 || $class_ids == 20 || $class_ids == 22  ||
                     $class_ids == 26  || $class_ids == 27
                     ) {   ?>
                  <th align="left" class="text-right bg-teal color-palette"> Practical </th>
                  <? } ?>
               </tr>
               <?php
                  if (isset($classfee) && !empty($classfee)) {
                  	$toclasscalc = 0;
                  	$toclasspending = 0;
                  
                  	$jk = 1;
                  	$kl = 0;
                  	$y = 1;
                  	foreach ($preclassfee as $krt => $value) {
                  ?>
               <tr>
                  <? $findfee = $this->Comman->findfeeheadsname($value['fee_h_id']); ?>
                  <? if ($findfee['name'] == "Admission Fee") {
                     if (!in_array("Admission Fee", $qua)) {  ?>
                  <td> <input type="text" style="background-color: transparent;border: none;" name="quater[]" id="s<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['name']; ?>" readonly disabled="">
                     <input type="hidden" style="background-color: transparent;border: none;" id="sp<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['id']; ?>" readonly disabled="">
                  </td>
                  <? }
                     } else if ($findfee['name'] == "Caution Money") {
                     	if (!in_array("Caution Money", $qua)) {  ?>
                  <td> <input type="text" style="background-color: transparent;border: none;" name="quater[]" id="s<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" class="paper1" value="<? echo $findfee['name']; ?>" readonly disabled="">
                     <input type="hidden" style="background-color: transparent;border: none;" id="sp<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['id']; ?>" readonly disabled="">
                  </td>
                  <? }
                     } else if ($findfee['name'] == "Development Fee") {
                     	if (!in_array("Development Fee", $qua)) {  ?>
                  <td> <input type="text" style="background-color: transparent;border: none;" name="quater[]" id="s<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['name']; ?>" readonly disabled="">
                     <input type="hidden" style="background-color: transparent;border: none;" id="sp<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['id']; ?>" readonly disabled="">
                  </td>
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
                  <td class="text-center"><?php $dat = date('Y-m-d', strtotime($value['qu' . $jk . '_date']));
                     if ($dat != '1970-01-01') {
                     	echo date('d-m-Y', strtotime($dat));
                     } else {
                     	echo "not-set";
                     } ?></td>
                  <? }
                     } else if ($findfee['name'] == "Caution Money") {
                     	if (!in_array("Caution Money", $qua)) {  ?>
                  <td class="text-center"><?php $dat = date('Y-m-d', strtotime($value['qu' . $jk . '_date']));
                     if ($dat != '1970-01-01') {
                     	echo date('d-m-Y', strtotime($dat));
                     } else {
                     	echo "not-set";
                     } ?></td>
                  <? }
                     } else if ($findfee['name'] == "Development Fee") {
                     	if (!in_array("Development Fee", $qua)) {  ?>
                  <td class="text-center"><?php $dat = date('Y-m-d', strtotime($value['qu' . $jk . '_date']));
                     if ($dat != '1970-01-01') {
                     	echo date('d-m-Y', strtotime($dat));
                     } else {
                     	echo "not-set";
                     } ?></td>
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
                  <td><? if ($discountcategory != '') {
                     echo $discountcategory;
                     } else {
                     echo
                     "--";
                     } ?></td>
                  <td class="text-right"><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
                     echo number_format($value['qu' . $jk . '_fees']);
                     $toclasscalc += $value['qu' . $jk . '_fees'];
                     } else {
                     echo "not-set";
                     } ?></td>
                  <? if (
                     $class_ids == 12 || $class_ids == 13 || $class_ids == 15 ||
                     $class_ids == 17 || $class_ids == 20 || $class_ids == 22  ||
                     $class_ids == 26  || $class_ids == 27
                     ) {   ?>
                  <td>--</td>
                  <? } ?>
                  <? }
                     } else if ($findfee['name'] == "Caution Money") {
                     	if (!in_array("Caution Money", $qua)) {  ?>
                  <td><? if ($discountcategory != '') {
                     echo $discountcategory;
                     } else {
                     echo
                     "--";
                     } ?></td>
                  <td class="text-right"><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
                     echo number_format($value['qu' . $jk . '_fees']);
                     $toclasscalc += $value['qu' . $jk . '_fees'];
                     } else {
                     echo "not-set";
                     } ?></td>
                  <? if (
                     $class_ids == 12 || $class_ids == 13 || $class_ids == 15 ||
                     $class_ids == 17 || $class_ids == 20 || $class_ids == 22  ||
                     $class_ids == 26  || $class_ids == 27
                     ) {   ?>
                  <td>--</td>
                  <? }
                     ?>
                  <? }
                     } else if ($findfee['name'] == "Development Fee") {
                     	if (!in_array("Development Fee", $qua)) {  ?>
                  <td><? if ($discountcategory != '') {
                     echo $discountcategory;
                     } else {
                     echo
                     "--";
                     } ?></td>
                  <td class="text-right"><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
                     echo number_format($value['qu' . $jk . '_fees']);
                     $toclasscalc += $value['qu' . $jk . '_fees'];
                     } else {
                     echo "not-set";
                     } ?></td>
                  <? if (
                     $class_ids == 12 || $class_ids == 13 || $class_ids == 15 ||
                     $class_ids == 17 || $class_ids == 20 || $class_ids == 22  ||
                     $class_ids == 26  || $class_ids == 27
                     ) {   ?>
                  <td>--</td>
                  <? } ?>
                  <? }
                     } else if ($findfee['name'] == "Miscellaneous Fee") {
                     	if (!in_array("Miscellaneous Fee", $qua)) {  ?>
                  <td><? if ($discountcategory != '') {
                     echo $discountcategory;
                     } else {
                     echo
                     "--";
                     } ?></td>
                  <td class="text-right"><span class="text-black">&#8377; </span><?php
                     if ($dat != '1970-01-01') {
                     	echo number_format($value['qu' . $jk . '_fees']);
                     	$toclasscalc += $value['qu' . $jk . '_fees'];
                     } else {
                     	echo "not-set";
                     } ?></td>
                  <? if (
                     $class_ids == 12 || $class_ids == 13 || $class_ids == 15 ||
                     $class_ids == 17 || $class_ids == 20 || $class_ids == 22  ||
                     $class_ids == 26  || $class_ids == 27
                     ) {   ?>
                  <td>--</td>
                  <? }
                     ?>
                  <? }
                     } ?>
               </tr>
               <? $y++;
                  }
                  
                  for ($i = 1; $i < 5; $i++) {     ?>
               <tr>
                  <input type="hidden" name="student_id" value="<?php echo $id; ?>">
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
                  <td><? if ($discountcategory != '') {
                     echo $discountcategory;
                     } else {
                     echo
                     "--";
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
                  <td><? if ($discountcategory != '') {
                     echo $discountcategory;
                     } else {
                     echo
                     "--";
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
                  <td><? if ($discountcategory != '') {
                     echo $discountcategory;
                     } else {
                     echo
                     "--";
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
                  <td><? if ($discountcategory != '') {
                     echo $discountcategory;
                     } else {
                     echo
                     "--";
                     } ?></td>
                  <? }
                     } ?>
                  <? $rg = $this->Comman->findclassfee($academic_class, $academic_year);
                     if ($i == 1) {
                     	if (!in_array("Quater" . $i, $qua)) {   ?>
                  <td class="text-right"><span class="text-black">&#8377;
                     </span><?php if ($dat != '1970-01-01') {
                        $tec = 0;
                        if ($discountcategory != '') {
                        	$calui = 0;
                        	$calui2 = 0;
                        	$calui = $this->Comman->finddiscountqtr($discountcategory);
                        	if ($calui == 0) {
                        		$calui2 = $this->Comman->finddiscountqtr2($discountcategory);
                        	}
                        	if ($calui) {
                        		$tak = $calui * $classfee[0]['qu' . $i . '_fees'] / 100;
                        
                        		$tec = floor($tak);
                        	} else {
                        		$tec = $calui2;
                        	}
                        }
                        if ($tec != '0') {
                        
                        	$remain = 0;
                        	$remain = $classfee[0]['qu' . $i . '_fees'] - $tec;
                        	if ($remain) { ?><strike style="color:red;"><?
                        echo number_format($classfee[0]['qu' . $i . '_fees']);
                        ?></strike>
                     <? echo
                        number_format($remain);
                        $toclasscalc += $remain;
                        }
                        } else {
                        
                        echo number_format($classfee[0]['qu' . $i . '_fees']);
                        $toclasscalc += $classfee[0]['qu' . $i . '_fees'];
                        }
                        } else {
                        echo "not-set";
                        } ?>
                  </td>
                  <? if (
                     $class_ids == 12 || $class_ids == 13 || $class_ids == 15 ||
                     $class_ids == 17 || $class_ids == 20 || $class_ids == 22  || $class_ids == 26  || $class_ids == 27
                     ) {
                     
                     $calpractical = 0;
                     $compsid = array();
                     $optsid = array();
                     $compsid = explode(',', $comp_sid);
                     $optsid = explode(',', $opt_sid);
                     foreach ($compsid as $k => $g) {
                     	$subjectpracticals = $this->Comman->classspractical($g);
                     	if ($subjectpracticals) {
                     		$calpractical += $subjectpracticals['is_practicalfee'];
                     	}
                     }
                     foreach ($optsid as $ks => $gs) {
                     	$subjectpracticalss = $this->Comman->classspractical($gs);
                     	if ($subjectpracticalss) {
                     		$calpractical += $subjectpracticalss['is_practicalfee'];
                     	}
                     } ?>
                  <td class="text-right"><span class="text-black">&#8377;
                     </span><? echo $calpractical;
                        $toclasspending += $calpractical; ?>
                  </td>
                  <? } ?>
                  <? }
                     } else if ($i == 2) {
                     	if (!in_array("Quater" . $i, $qua)) {  ?>
                  <td class="text-right"><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
                     $tec = 0;
                     if ($discountcategory != '') {
                     	$calui = 0;
                     
                     	$calui2 = 0;
                     
                     	$calui = $this->Comman->finddiscountqtr($discountcategory);
                     
                     	if ($calui == 0) {
                     		$calui2 = $this->Comman->finddiscountqtr2($discountcategory);
                     	}
                     
                     	if ($calui) {
                     		$tak = $calui * $classfee[0]['qu' . $i . '_fees'] / 100;
                     
                     		$tec = floor($tak);
                     	} else {
                     		$tec = $calui2;
                     	}
                     }
                     if ($tec != '0') {
                     
                     	$remain = 0;
                     	$remain = $classfee[0]['qu' . $i . '_fees'] - $tec;
                     	if ($remain) { ?><strike style="color:red;"><?
                     echo number_format($classfee[0]['qu' . $i . '_fees']);
                     
                     ?></strike>
                     <? echo
                        number_format($remain);
                        $toclasscalc += $remain;
                        }
                        } else {
                        
                        echo number_format($classfee[0]['qu' . $i . '_fees']);
                        $toclasscalc += $classfee[0]['qu' . $i . '_fees'];
                        }
                        } else {
                        echo "not-set";
                        } ?>
                  </td>
                  <? if (
                     $class_ids == 12 || $class_ids == 13 || $class_ids == 15 ||
                     $class_ids == 17 || $class_ids == 20 || $class_ids == 22  || $class_ids == 26  || $class_ids == 27
                     ) {
                     
                     $calpractical = 0;
                     $compsid = array();
                     $optsid = array();
                     $compsid = explode(',', $comp_sid);
                     $optsid = explode(',', $opt_sid);
                     foreach ($compsid as $k => $g) {
                     	$subjectpracticals = $this->Comman->classspractical($g);
                     	if ($subjectpracticals) {
                     		$calpractical += $subjectpracticals['is_practicalfee'];
                     	}
                     }
                     foreach ($optsid as $ks => $gs) {
                     	$subjectpracticalss = $this->Comman->classspractical($gs);
                     	if ($subjectpracticalss) {
                     		$calpractical += $subjectpracticalss['is_practicalfee'];
                     	}
                     } ?>
                  <td class="text-right"><span class="text-black">&#8377; </span><? echo $calpractical;
                     $toclasspending += $calpractical; ?></td>
                  <? } ?>
                  <? }
                     } else if ($i == 3) {
                     	if (!in_array("Quater" . $i, $qua)) { ?>
                  <td class="text-right"><span class="text-black">&#8377;
                     </span><?php if ($dat != '1970-01-01') {
                        $tec = 0;
                        if ($discountcategory != '') {
                        	$calui = 0;
                        
                        	$calui2 = 0;
                        
                        	$calui = $this->Comman->finddiscountqtr($discountcategory);
                        
                        	if ($calui == 0) {
                        		$calui2 = $this->Comman->finddiscountqtr2($discountcategory);
                        	}
                        
                        	if ($calui) {
                        		$tak = $calui * $classfee[0]['qu' . $i . '_fees'] / 100;
                        
                        		$tec = floor($tak);
                        	} else {
                        		$tec = $calui2;
                        	}
                        }
                        if ($tec != '0') {
                        
                        	$remain = 0;
                        	$remain = $classfee[0]['qu' . $i . '_fees'] - $tec;
                        	if ($remain) { ?><strike style="color:red;"><?
                        echo number_format($classfee[0]['qu' . $i . '_fees']);
                        ?></strike>
                     <? echo
                        number_format($remain);
                        $toclasscalc += $remain;
                        }
                        } else {
                        
                        echo number_format($classfee[0]['qu' . $i . '_fees']);
                        $toclasscalc += $classfee[0]['qu' . $i . '_fees'];
                        }
                        } else {
                        echo "not-set";
                        } ?>
                  </td>
                  <? if (
                     $class_ids == 12 || $class_ids == 13 || $class_ids == 15 ||
                     $class_ids == 17 || $class_ids == 20 || $class_ids == 22  || $class_ids == 26  || $class_ids == 27
                     ) {
                     
                     $calpractical = 0;
                     $compsid = array();
                     $optsid = array();
                     $compsid = explode(',', $comp_sid);
                     $optsid = explode(',', $opt_sid);
                     foreach ($compsid as $k => $g) {
                     	$subjectpracticals = $this->Comman->classspractical($g);
                     	if ($subjectpracticals) {
                     		$calpractical += $subjectpracticals['is_practicalfee'];
                     	}
                     }
                     foreach ($optsid as $ks => $gs) {
                     	$subjectpracticalss = $this->Comman->classspractical($gs);
                     	if ($subjectpracticalss) {
                     		$calpractical += $subjectpracticalss['is_practicalfee'];
                     	}
                     } ?>
                  <td class="text-right"><span class="text-black">&#8377;
                     </span><? echo $calpractical;
                        $toclasspending += $calpractical; ?>
                  </td>
                  <? } ?>
                  <? }
                     } else if ($i == 4) {
                     	if (!in_array("Quater" . $i, $qua)) { ?>
                  <td class="text-right"><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
                     $tec = 0;
                     if ($discountcategory != '') {
                     	$calui = 0;
                     
                     	$calui2 = 0;
                     
                     	$calui = $this->Comman->finddiscountqtr($discountcategory);
                     
                     	if ($calui == 0) {
                     		$calui2 = $this->Comman->finddiscountqtr2($discountcategory);
                     	}
                     
                     	if ($calui) {
                     		$tak = $calui * $classfee[0]['qu' . $i . '_fees'] / 100;
                     
                     		$tec = floor($tak);
                     	} else {
                     		$tec = $calui2;
                     	}
                     }
                     if ($tec != '0') {
                     
                     	$remain = 0;
                     	$remain = $classfee[0]['qu' . $i . '_fees'] - $tec;
                     	if ($remain) { ?><strike style="color:red;"><?
                     echo number_format($classfee[0]['qu' . $i . '_fees']);
                     ?></strike>
                     <? echo
                        number_format($remain);
                        $toclasscalc += $remain;
                        }
                        } else {
                        
                        echo number_format($classfee[0]['qu' . $i . '_fees']);
                        $toclasscalc += $classfee[0]['qu' . $i . '_fees'];
                        }
                        } else {
                        echo "not-set";
                        } ?>
                  </td>
                  <? if (
                     $class_ids == 12 || $class_ids == 13 || $class_ids == 15 ||
                     $class_ids == 17 || $class_ids == 20 || $class_ids == 22  || $class_ids == 26  || $class_ids == 27
                     ) {
                     
                     $calpractical = 0;
                     $compsid = array();
                     $optsid = array();
                     $compsid = explode(',', $comp_sid);
                     $optsid = explode(',', $opt_sid);
                     foreach ($compsid as $k => $g) {
                     	$subjectpracticals = $this->Comman->classspractical($g);
                     	if ($subjectpracticals) {
                     		$calpractical += $subjectpracticals['is_practicalfee'];
                     	}
                     }
                     foreach ($optsid as $ks => $gs) {
                     	$subjectpracticalss = $this->Comman->classspractical($gs);
                     	if ($subjectpracticalss) {
                     		$calpractical += $subjectpracticalss['is_practicalfee'];
                     	}
                     } ?>
                  <td class="text-right"><span class="text-black">&#8377; </span><? echo $calpractical;
                     $toclasspending += $calpractical; ?></td>
                  <? } ?>
                  <? }
                     } ?>
               </tr>
               <?php }
                  } ?>
               <tr>
                  <td <? if (
                     $class_ids == 12 || $class_ids == 13 || $class_ids == 15 ||
                     $class_ids == 17 || $class_ids == 20 || $class_ids == 22  ||
                     $class_ids == 26  || $class_ids == 27
                     ) {  ?> colspan="2" <? } else { ?> colspan="3" <? } ?> style="color:green;"><b> Total </b></td>
                  <td class="text-right"> <b><span class="text-black">&#8377; </span>
                     <? setlocale(LC_MONETARY, 'en_IN');
                        $toclasscalcs = money_format('%!i', $toclasscalc);
                        echo $toclasscalcs;
                        ?> </b>
                  </td>
                  <? if (
                     $class_ids == 12 || $class_ids == 13 || $class_ids == 15 ||
                     $class_ids == 17 || $class_ids == 20 || $class_ids == 22  || $class_ids == 26  || $class_ids == 27
                     ) {  ?>
                  <td class="text-left"><b>+ <span class="text-black">&#8377;
                     </span> <? $toclasspendings = money_format('%!i', $toclasspending);
                        echo $toclasspendings; ?>
                  </td>
                  <td><b> = <?
                     $topracticalfeewithfee = $toclasscalc + $toclasspending;
                     $topracticalfeewithfees = money_format('%!i', $topracticalfeewithfee);
                     echo "<span 
                     class='text-black' style='color:green !important;'>&#8377; 
                     " . $topracticalfeewithfees; ?></span></b></td>
                  <? } ?>
               </tr>
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
      </div>
   </div>
</div>
<div class="modal-footer">
   <button data-dismiss="modal" class="btn btn-default pull-right" type="button">Cancel</button>
</div>
<?php echo $this->Form->end(); ?>