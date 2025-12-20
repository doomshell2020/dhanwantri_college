<?php 
class xtcpdf extends TCPDF {
 
}
 
   $this->set('pdf', new TCPDF('P','mm','A6'));


$pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

$pdf->SetTitle('Class_Timetable_'.$classtitle.'_'.$sectiontitle.'.pdf');
// set document information
$pdf->SetCreator(PDF_CREATOR);
 $pdf->SetPrintHeader(false);
 $pdf->SetPrintFooter(false);
$pdf->AddPage();
$srch=$this->Session->read('search');

//pdf->SetY(-550);
$pdf->SetFont('', '', 8, '', 'false');

	if($this->request->session()->read('Auth.User.db')=="kidsclub"){

    $db="Kids Club";
  }else{
    $db=$this->request->session()->read('Auth.User.db');
  }
$html='
<table width="100%">
<tr>
<td align="center"  width="100%">
<small style="display:block; color:#000; font-size:16px;">
'.strtoupper($db).' SCHOOL
</small><br>
</td>
</tr>
</table>
<span style="font-size:12px; text-align:center; display:block;">Time-Table Session-'.$acedmicyear.' &nbsp;|&nbsp;<b>Class:</b>'.$classtitle.'&nbsp;|&nbsp;<b>Section:</b>'.$sectiontitle.'</span><br>
<br>
 <table style="width:100%;">
        		<thead>
        			<tr><th style="width:10%; background-color:#39cccc; height:20px; line-height:15px; text-align:center; margin-right:1px; color:#fff;">Period Timing</th>
        				<th style="width:15%; background-color:#39cccc; height:20px; line-height:15px; text-align:center; color:#fff;">Monday</th>
        				<th style="width:15%; background-color:#39cccc; height:20px; line-height:15px; text-align:center; color:#fff;">Tuesday</th>
        				<th style="width:15%; background-color:#39cccc; height:20px; line-height:15px; text-align:center; color:#fff;">Wednesday</th>
        				<th style="width:15%; background-color:#39cccc; height:20px; line-height:15px; text-align:center; color:#fff;">Thursday</th>
        				<th style="width:15%; background-color:#39cccc; height:20px; line-height:15px; text-align:center; color:#fff;">Friday</th>
        				<th style="width:15%; background-color:#39cccc; height:20px; line-height:15px; text-align:center; color:#fff;">Saturday</th></tr>
        		</thead>
     <tbody>';
     
  if(isset($timetabledata) && !empty($timetabledata)){ 
		foreach($timetabledata as $work){  $getdata='0'; if($work['is_break'] != 1) {  
     $getdata= $this->Comman->gettimetable($work['id'],"Monday",$classid);

                                                  $sub=explode(',',$getdata[0]['subject_id']);
                                              $tea=explode(',',$getdata[0]['employee_id']); 

                                              
                                               $clsn=array();
                                               foreach ($sub as $key => $value) {
                                                foreach ($tea as $s => $val) {
                                                  if($key==$s){
                                              
                                                  $getteac= $this->Comman->findclassteachers($val);
                                               $subj= $this->Comman->findclassubject($value);
                                            
                                                  if($getteac['middlename']!='') {$clsn[]=$subj['alias']."(".$getteac['fname'].' '.substr($getteac['middlename'],0,2).")<br>"; }else{ $clsn[]=$subj['alias']."(".$getteac['fname'].' '.substr($getteac['lname'],0,2).")<br>";  } 
                                                  
                                                  }
                                                }
                                                 
                                               }
    
     
	$html.='<tr><td  style="width:10%; height:42px; line-height:30px; text-align:center; border-left:1px solid #e0e0e0; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;font-size:10px;">'.$work['name'].'-<span style="font-size:5px;">'.$work['time_from'].'-'.$work['time_to'].'</span></td><td style="width:15%; height:42px; line-height:11px; text-align:center; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;"><br><br>';
	if (strpos($work['weekday'], "Monday") !== false) {
		$html.='<span   rel="tooltip" data-toggle="tooltip" title="">'; 
		if(!empty($getdata)){ 
    foreach ($clsn as $key => $value1) {
    $html.= $value1;
    }                                          
		}else{ 
			 $html.='--';  }
			$html.='</span>';
	}
	 $html.='</td>';
	  $getdata= $this->Comman->gettimetable($work['id'],"Tuesday",$classid);

$sub=explode(',',$getdata[0]['subject_id']);
                                              $tea=explode(',',$getdata[0]['employee_id']); 

                                              
                                               $clsn=array();
                                               foreach ($sub as $key => $value) {
                                                foreach ($tea as $s => $val) {
                                                  if($key==$s){
                                                  $getteac= $this->Comman->findclassteachers($val);
                                                  $subj= $this->Comman->findclassubject($value);
                                                  if($getteac['middlename']!='') {$clsn[]=$subj['alias']."(".$getteac['fname'].' '.substr($getteac['middlename'],0,2).")<br>"; }else{ $clsn[]=$subj['alias']."(".$getteac['fname'].' '.substr($getteac['lname'],0,2).")<br>";  } 
                                                  }
                                                }
                                               }
    

    
     
	$html.='<td class="text-center" style="white-space: pre-wrap; word-break: keep-all; width:15%; height:42px; line-height:11px; text-align:center; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;"><br><br>';
	if (strpos($work['weekday'], "Tuesday") !== false) {
		$html.='<span   rel="tooltip" data-toggle="tooltip" title="">'; 
		if(!empty($getdata)){ 
			foreach ($clsn as $key => $value1) {
      $html.= $value1;
      } 
			
			 }else{ 
			 $html.='--';  }
			 $html.='</span>';
	}
	 $html.='</td>';
	 $getdata= $this->Comman->gettimetable($work['id'],"Wednesday",$classid);
    
      $sub=explode(',',$getdata[0]['subject_id']);
                                              $tea=explode(',',$getdata[0]['employee_id']);

                                              
                                               $clsn=array();
                                               foreach ($sub as $key => $value) {
                                                foreach ($tea as $s => $val) {
                                                  if($key==$s){
                                                  $getteac= $this->Comman->findclassteachers($val); 
                                               $subj= $this->Comman->findclassubject($value);
                                                  if($getteac['middlename']!='') {$clsn[]=$subj['alias']."(".$getteac['fname'].' '.substr($getteac['middlename'],0,2).")<br>"; }else{ $clsn[]=$subj['alias']."(".$getteac['fname'].' '.substr($getteac['lname'],0,2).")<br>";  } 
                                                  }
                                                }
                                               }
     
	$html.='<td class="text-center" style="white-space: pre-wrap; word-break: keep-all; width:15%; height:42px; line-height:11px; text-align:center; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;"><br><br>';
	if (strpos($work['weekday'], "Wednesday") !== false) {
		$html.='<span   rel="tooltip" data-toggle="tooltip" title="">'; 
		if(!empty($getdata)){ 
			
			
			foreach ($clsn as $key => $value1) {
              $html.= $value1;
              } 
			    }else{ 
			 $html.='--';  }
			 $html.='</span>';
	}
	 $html.='</td>';
	
      $getdata= $this->Comman->gettimetable($work['id'],"Thursday",$classid);
      $sub=explode(',',$getdata[0]['subject_id']);
                                              $tea=explode(',',$getdata[0]['employee_id']);
                                              
                                               $clsn=array();
                                               foreach ($sub as $key => $value) {
                                                foreach ($tea as $s => $val) {
                                                  if($key==$s){
                                                  $getteac= $this->Comman->findclassteachers($val); 
                                                  $subj= $this->Comman->findclassubject($value);
                                                  if($getteac['middlename']!='') {$clsn[]=$subj['alias']."(".$getteac['fname'].' '.substr($getteac['middlename'],0,2).")<br>"; }else{ $clsn[]=$subj['alias']."(".$getteac['fname'].' '.substr($getteac['lname'],0,2).")<br>";  } 
                                                  }
                                                }
                                               }
     
     
	$html.='<td class="text-center" style="white-space: pre-wrap; word-break: keep-all; width:15%; height:42px; line-height:11px; text-align:center; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;"><br><br>';
	if (strpos($work['weekday'], "Thursday") !== false) {
		$html.='<span   rel="tooltip" data-toggle="tooltip" title="">'; 
		if(!empty($getdata)){ 
			
			foreach ($clsn as $key => $value1) {
                     $html.= $value1;
           } 
                                                  			
			 }else{ 
			 $html.='--';  }
			 $html.='</span>';
	      }
	    $html.='</td>';
	    $getdata= $this->Comman->gettimetable($work['id'],"Friday",$classid);
      $sub=explode(',',$getdata[0]['subject_id']);
                                              $tea=explode(',',$getdata[0]['employee_id']);

                                               $clsn=array();
                                               foreach ($sub as $key => $value) {
                                                foreach ($tea as $s => $val) {;
                                                  if($key==$s){
                                                  $getteac= $this->Comman->findclassteachers($val); 
                                                  $subj= $this->Comman->findclassubject($value);
                                                  if($getteac['middlename']!='') {$clsn[]=$subj['alias']."(".$getteac['fname'].' '.substr($getteac['middlename'],0,2).")<br>"; }else{ $clsn[]=$subj['alias']."(".$getteac['fname'].' '.substr($getteac['lname'],0,2).")<br>";  } 
                                                  }
                                                }
                                               }
     
	$html.='<td class="text-center" style="white-space: pre-wrap; word-break: keep-all; width:15%; height:42px; line-height:11px; text-align:center; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;"><br><br>';
	if (strpos($work['weekday'], "Friday") !== false) {
		$html.='<span   rel="tooltip" data-toggle="tooltip" title="">'; 
		if(!empty($getdata)){ 
		foreach ($clsn as $key => $value1) {
                    $html.= $value1;
            } 
                                                  			
			 }else{ 
			 $html.='--';  }
			 $html.='</span>';
	}
	 $html.='</td>';
	$getdata= $this->Comman->gettimetable($work['id'],"Saturday",$classid);
    
    $sub=explode(',',$getdata[0]['subject_id']);
                                              $tea=explode(',',$getdata[0]['employee_id']);

                                               $clsn=array();
                                               foreach ($sub as $key => $value) {
                                                foreach ($tea as $s => $val) {
                                                  if($key==$s){
                                                  $getteac= $this->Comman->findclassteachers($val); 
                                                  $subj= $this->Comman->findclassubject($value);
                                             
                                                  if($getteac['middlename']!='') {$clsn[]=$subj['alias']."(".$getteac['fname'].' '.substr($getteac['middlename'],0,2).")<br>"; }else{ $clsn[]=$subj['alias']."(".$getteac['fname'].' '.substr($getteac['lname'],0,2).")<br>";  } 
                                                  }
                                                }
                                               }
     
	$html.='<td class="text-center" style="white-space: pre-wrap; word-break: keep-all; width:15%; height:42px; line-height:11px; text-align:center; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;"><br><br>';
	if (strpos($work['weekday'], "Saturday") !== false) {
		$html.='<span   rel="tooltip" data-toggle="tooltip" title="">'; 
		if(!empty($getdata)){ 
			
		foreach ($clsn as $key => $value1) {
                 $html.= $value1;
            } 
                                                  
			 }else{ 
			 $html.='--';  }
			$html.='</span>';
	}
	 	
	 $html.='</td></tr>';

  
}
if($work['is_break']) {  if($work['time_from']) {
	$html.='<tr style="line-height:6px;"><td  style="width:10%; height:15px; line-height:6px; text-align:center; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;  border-left:1px solid #e0e0e0;color:red;"><span title="Break" data-toggle="tooltip" style="color:red; text-align:center;  width:15%; height:15px; line-height:10px; font-size:6px;"> '.$work['time_from'].'-'.$work['time_to'];
	
	
	
	$html.='</span></td><td class="text-center" style="white-space: pre-wrap; word-break: keep-all; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0; "><span title="Break" data-toggle="tooltip" style="color:red; text-align:center;  width:15%; height:15px; line-height:6px; "> <br>Break</span></td>
   <td class="text-center" style="white-space: pre-wrap; word-break: keep-all; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;"><span title="Break" data-toggle="tooltip" style="color:red; text-align:center; line-height:6px;"> <br>Break</span></td>
   <td class="text-center" style="white-space: pre-wrap; word-break: keep-all; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;"><span title="Break" data-toggle="tooltip" style="color:red; text-align:center; line-height:6px;  "> <br>Break</span></td>
    <td class="text-center" style="white-space: pre-wrap; word-break: keep-all; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;"><span title="Break" data-toggle="tooltip" style="color:red; text-align:center; line-height:6px;  "> <br>Break</span></td>
  <td class="text-center" style="white-space: pre-wrap; word-break: keep-all; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;"><span title="Break" data-toggle="tooltip" style="color:red; text-align:center; line-height:6px;"> <br>Break</span></td>
   <td class="text-center" style="white-space: pre-wrap; word-break: keep-all; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;"><span title="Break" data-toggle="tooltip" style="color:red; text-align:center;   line-height:6px;"> <br>Break</span></td>
    </tr>';
  
   }}}}
    $html.='</tbody>
        </table>';

$pdf->WriteHTML($html, '', 0, 'L', true, 0, false, false, 0);
ob_end_clean();
echo $pdf->Output('Class_Timetable_'.$classtitle.'_'.$sectiontitle.'.pdf');
