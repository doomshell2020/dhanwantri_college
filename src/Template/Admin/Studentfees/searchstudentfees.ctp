   <section class="content">
     <div class="row edusec-user-profile">
       <div class="col-sm-12">



         <div id="content" class="tab-content responsive hidden-xs hidden-sm">


           <div class="tab-pane active" id="personal">

             <div class="row">
               <div class="col-lg-6">


                 <!----------------------------------------------------- For Paid Recipet Show------------------------------------->
                 <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">

                   <tbody>
                     <tr class="table_header">
                       <th class="bg-teal color-palette">Session</th>
                       <th style="width: 27%;" class="bg-teal color-palette">Reference No.</th>
                       <th class="text-left bg-teal color-palette">Paydate </th>

                       <th class="text-left bg-teal color-palette"> Amount </th>
                       <th class="text-left bg-teal color-palette"> Print </th>
                     </tr>

                     <?
									 if($studentfeesk){ $unique=array(); foreach($studentfeesk as $valsf){
                    if( ! in_array($valsf['class'], $unique) ){
                          ?>

                     <tr>
                       <?php	 $unique[] = $valsf['class'];
								//	$sclass=$this->Comman->finndstudentreport($valsf['student_id'],$valsf['acedmicyear']);
								 ?>
                       <td><label style="font-weight:bold;color:green;"><?php echo $valsf['acedmicyear']; ?></label>
                         <b>(<?php echo $valsf['class'];?>)</b>
                       </td>

                       <?php
									$studentfeeskss=$this->Comman->findacedmicdetailallstudents($valsf['student_id'],$valsf['acedmicyear']);
									 if($studentfeeskss){ $quass=array(); foreach($studentfeeskss as $valsf){


						$quass=unserialize($valsf['quarter']);
						$rst=array();
				foreach($quass as $sj=>$dt){

					$rst[]=$sj;
				} ?>
                     <tr>
                       <td><label></label></td>
                       <td>
                         <?php echo $valsf['recipetno'];  if (in_array("Bank Cancellation Charge", $rst)) { echo "<strong  title='Bank Cancellation Charge' style='color:red;'>*</strong>";  }  ?>
                       </td>
                       <td>

                         <?php $dats= date('Y-m-d',strtotime($valsf['paydate'])); if($dats!='1970-01-01'){ echo date('d-m-Y',strtotime($dats)); }else{ echo "not-set"; } ?>

                       </td>

                       <td>

                         <span class="text-black">₹ </span><?php echo $valsf['deposite_amt']; ?></td>
                       <td>
                         <?
				$quass=array();

				if($valsf['refrencepending']=='0'){
					$quass[]=unserialize($valsf['quarter']);

					$quafs=array();

							foreach($quass as $h=>$vales){

								$quafs=array_merge($quafs,$vales);

								}
						$rt=array();
						$quas=array();
				foreach($quafs as $sjs=>$ts){
           
					$quas[]=$sjs;
				}

			}else{
					$quas=array();
				$quas[]=$valsf['quarter'];
			}

      // pr($valsf); die;
			if (in_array("Caution Money", $quas)) {
					?>

                        
                         <a title="Print Caution Money" onclick="return printrecipt(this.href)" target="_blank"
                           <?php if($acedemic==$valsf['acedmicyear']){ ?>
                           href="<? echo ADMIN_URL; ?>studentfees/printscaution/<?php echo $valsf['id']; ?>/<?php echo $valsf['acedmicyear']; ?>?gid=1"
                           <?php }else{ ?>
                           href="<? echo ADMIN_URL; ?>studentfees/printscautionhistory/<?php echo $valsf['id']; ?>/<?php echo $valsf['acedmicyear']; ?>?gid=1"
                           <?php } ?>><i class="fa fa-file-text-o"></i></a>



                         <? }else{  ?>
                         <a title="Print Receipt" onclick="return printrecipt(this.href)" target="_blank"
                           <?php if($acedemic==$valsf['acedmicyear']){ ?>
                           href="<? echo ADMIN_URL; ?>studentfees/printsadmission/<?php echo $valsf['id']; ?>/<?php echo $valsf['acedmicyear']; ?>?gid=1"
                           <?php }else{ ?>
                           href="<? echo ADMIN_URL; ?>studentfees/printsadmissionhistory/<?php echo $valsf['id']; ?>/<?php echo $valsf['acedmicyear']; ?>?gid=1"
                           <?php } ?>><i class="fa fa-file-text-o"></i></a>



                         <? } ?>



                       </td>

                     </tr>
                     <?  } }else{ ?>

                     <tr>
                       <td colspan="5" class="text-center">No Deposit Fees Yet</td>
                     </tr>
                     <?php } } } }else{ ?>


                     <tr>
                       <td colspan="5" class="text-center">No Deposit Fees Yet</td>
                     </tr>
                     <? } ?>

                   </tbody>
                 </table>


                 <!----------------------------------------------------- For Other Paid Recipet Show------------------------------------->
                 <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">

                   <tbody>
                     <tr class="table_header">
                       <th class="bg-teal color-palette">Session</th>
                       <th style="width: 27%;" class="bg-teal color-palette">Reference No.</th>
                       <th class="text-left bg-teal color-palette">Paydate </th>

                       <th class="text-left bg-teal color-palette"> Amount </th>
                       <th class="text-left bg-teal color-palette"> Print </th>
                     </tr>

                     <?
									 if($detail){ $unique=array(); foreach($detail as $valsf){
                    if( ! in_array($valsf['class_id'], $unique) ){
                          ?>

                     <tr>
                       <?php	$unique[] = $valsf['class_id']; ?>
                       <td><label style="font-weight:bold;color:green;"><?php echo $valsf['academicyear']; ?></label>
                         <b>(<?php $clsstitel=$this->Comman->showclasstitle($valsf['class_id']); echo $clsstitel['title'];?>)</b>
                       </td>



                       <td>
                         <?php echo $valsf['receipt_no'];  ?>
                       </td>
                       <td>

                         <?php $dats= date('Y-m-d',strtotime($valsf['paydate'])); if($dats!='1970-01-01'){ echo date('d-m-Y',strtotime($dats)); }else{ echo "not-set"; } ?>

                       </td>

                       <td>

                         <span class="text-black">₹ </span><?php echo $valsf['amount']; ?></td>
                       <td>

<a title="Print Caution Money" onclick="return printrecipt(this.href)" target="_blank" href="<? echo ADMIN_URL; ?>studentfees/otherfees_receipt/<?php echo $valsf['id']; ?>?gid=1"><i class="fa fa-file-text-o"></i></a>





                       </td>

                     </tr>

                     <?php } } }else{ ?>


                     <tr>
                       <td colspan="5" class="text-center">No Deposit Fees Yet</td>
                     </tr>
                     <? } ?>

                   </tbody>
                 </table>


               </div>

               <script>
               function printrecipt(id) {

                 $('.ifrmecalac').attr("src", id);
                 $('.ifrmecalac').css("display", "block");
                 return false;
               }
               </script>
               <div class="col-lg-6">



                 <div>

                   <iframe class="ifrmecalac" style="display:none;" src="" width="550px" height="800px" />

                 </div>



               </div>
             </div>
             <div class="box-footer">

               <a href="/admin/studentfees/view" class="btn btn-default">Back</a>
             </div>














             <!-------------------------------------------End Of Deposit Fee---------------------------------------------------------------->
           </div>
         </div>
       </div>
     </div>
   </section>