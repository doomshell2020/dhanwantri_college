<?php 
class xtcpdf extends TCPDF {
 
}


   $this->set('pdf', new TCPDF('L','mm','A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();


$pdf->SetFont('', '', 9, '', 'false');

$html.='<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Result Print</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"></head>
<body style="font-family:"trebuchet MS",Arial,Helvetica,sans-serif;">
<h2>'.$examname.' Exam Result 
 </h2><h3><span class="text-muted" style="font-size:9px;">
 <strong>Class Name : </strong>'.$classname.' | <strong>Section Name : </strong>'.$sectionname.' | <strong>Exam : </strong>'.$examname.' | <strong>Academic Year : '.$acedamicyear.'</strong>  </span></h3> <br><br>';
			  
			  $roleid=$this->request->session()->read('Auth.User.role_id');
			  
			 
     if($roleid=='4' || $roleid=='13' ){ 
        
		   $html.='<table  width="100%" border="1"   align="center">
        <thead>
    <tr>
      <th width="5%"><b>S.No</b></th>
     <th width="6%"> <b>Sr.No.</b></th>
 <th width="20%"><b>Name</b></th>';

$st=$this->Comman->findsubjectopt($class_id,$section);
				
			
				if(in_array("65",$st) || in_array("70",$st) || in_array("71",$st)){
					
			if($class_id=="10"){
						$rh='29';
						$studentsubject=$this->Comman->fsubjectonlyteachersbysubject($examid,$section,$class_id,$rh);
						
						
						
						
					}
					
					
					if($class_id=="11"){
						$rh='38';
							$studentsubject=$this->Comman->fsubjectonlyteachersbysubject($examid,$section,$class_id,$rh);
					
						
					}
				}else if(in_array("66",$st) || in_array("67",$st) || in_array("68",$st)){
					if($class_id=="10"){
						$rh='28';
						$studentsubject=$this->Comman->fsubjectonlyteachersbysubject($examid,$section,$class_id,$rh);
					
					}
					
					
					if($class_id=="11"){
						$rh='37';
							$studentsubject=$this->Comman->fsubjectonlyteachersbysubject($examid,$section,$class_id,$rh);
					
						
					}
					
				}else{
$studentsubject=$this->Comman->fsubjectonly($examid,$section,$class_id);
}


$findroleexamtype=$this->Comman->findeexamtsype($examid,$section,$class_id);
   if(isset($studentsubject) && !empty($studentsubject)){ 
	   foreach($findroleexamtype as $er){  
		   
		   $findetypname=$this->Comman->findsubjectstotalssnames2($er['etype_id']);
	   
	   
		foreach($studentsubject as $works){ 
			$html.='<th><b>'.$findetypname[0]['name']."-".$works['exam_subject']['exprint'].'</b></th>';
			
		}
	} 
	
}
      
   $roleid=$this->request->session()->read('Auth.User.role_id');
   
    $html.='</tr>
 </thead>
                <tbody >';
$counter = 1; 
    if(isset($students) && !empty($students)){ 
    foreach($studentsda as $work){
    
 $html.='<tr><td width="5%">'.$counter.'</td>';
   
       $html.='<td  width="6%">'.$work['student']['enroll'].'</td>';
 
   $html.='<td align="left" width="20%">&nbsp;'.ucwords(strtolower($work['student']['fname']))." ".ucwords(strtolower($work['student']['middlename']))." ".ucwords(strtolower($work['student']['lname'])).'</td>';
  
   
    if(isset($studentsubject) && !empty($studentsubject)){
		
				 foreach($findroleexamtype as $ers){
					 $findetypnasme=$this->Comman->findsubjectstotalssnames2($ers['etype_id']);
		$studentexamresult=$this->Comman->fsubjectmarks($examid,$work['student']['id'],$section,$class_id,$ers['etype_id']);
		 
		foreach($studentexamresult as $works){ 
			
			
    

  
  if($findetypnasme[0]['id']=="1" || $findetypnasme[0]['id']=="26"){ 
		
					
					if($works['marks']!='0' && $works['marks']!='A' ){ 
					
					$weighted=$works['marks']/2;  
					
					
					  $html.='<td><b>'.round($weighted).'</b></td>'; 
					
					 }else{
						
					
						  $html.='<td><b>'.$works['marks'].'</b></td>'; 
						
						} 
		
		}else{
					  $html.='<td><b>'.$works['marks'].'</b></td>'; 
			
			
		}
		
    
 } }  }
              $html.='</tr>';
          $counter++;
          } }else{ 
     $html.='<tr>
    <td>NO Data Available</td>
    </tr>';
   } 
    $html.='</tbody></table>';
  
        
        
    }
    
     if($roleid=='3'){  
		
		  $html.='<table  width="100%" border="1"   align="center">
                
  
 <thead>
    <tr>
      <th width="5%"><b>S.No</b></th>
     <th width="6%"> <b>Sr.No.</b></th>
 <th width="20%"><b>Name</b></th>';

  $st=$this->Comman->findsubjectopt($class_id,$section);

if($subjecname){
	
	$studentsubject=$this->Comman->fsubjectonlyteachers2($examid,$section,$class_id,$subjecname);
	
}else{
	
	$studentsubject=$this->Comman->fsubjectonlyteachers($examid,$section,$class_id);
	
}

$findroleexamtype=$this->Comman->findroleexamtype($examid,$section,$class_id);

   if(isset($studentsubject) && !empty($studentsubject)){ 
	   
	   
	      foreach($findroleexamtype as $er){  
		   
		   $findetypname=$this->Comman->findsubjectstotalssnames2($er['etype_id']);
		foreach($studentsubject as $works){ 
			$html.='<th ><b>'.$findetypname[0]['name']."-".$works['exam_subject']['exprint'].'</b></th>';
			
			if($findetypname[0]['id']=="1" || $findetypname[0]['id']=="26"){  
				
				$html.='<th 
				><b>'.$findetypname[0]['name']."-".$works['exam_subject']['exprint'].'<br>(Weighted marks)</b></th>';
				 } 
			
		}
	} 
  }else{
		
		if(in_array("65",$st) || in_array("70",$st) || in_array("71",$st)){
					
			if($class_id=="10"){
						$rh='29';
						$studentsubjects=$this->Comman->fsubjectonlyteachersbysubject($examid,$section,$class_id,$rh);
						
						
					
						
					}
					
					
					if($class_id=="11"){
						$rh='38';
						$studentsubjects=$this->Comman->fsubjectonlyteachersbysubject($examid,$section,$class_id,$rh);
					
						
					}
				}else if(in_array("66",$st) || in_array("67",$st) || in_array("68",$st)){
					if($class_id=="10"){
						$rh='28';
						$studentsubjects=$this->Comman->fsubjectonlyteachersbysubject($examid,$section,$class_id,$rh);
					
					}
					
					
					if($class_id=="11"){
						$rh='37';
				  $studentsubjects=$this->Comman->fsubjectonlyteachersbysubject($examid,$section,$class_id,$rh);
					
						
					}
					
				}
				//pr($studentsubjects);
				
				$findroleexamtype2=$this->Comman->findroleexamtype2($examid,$section,$class_id);
				if(isset($studentsubjects) && !empty($studentsubjects)){
	   
	   
	   
	  foreach($findroleexamtype2 as $er){  
		   
		   $findetypname=$this->Comman->findsubjectstotalssnames2($er['etype_id']);
		foreach($studentsubjects as $works){ 
			$html.='<th ><b>'.$findetypname[0]['name']."-".$works['exam_subject']['exprint'].'</b></th>';
			
			if($findetypname[0]['id']=="1" || $findetypname[0]['id']=="26"){  
				
				$html.='<th 
				><b>'.$findetypname[0]['name']."-".$works['exam_subject']['exprint'].'<br>(Weighted marks)</b></th>';
				 } 
			
		}
	} 
		
		
	}
		

		
		}
   $roleid=$this->request->session()->read('Auth.User.role_id');
   
    $html.='</tr>
 </thead>
                <tbody>';
$counter = 1; 
      if(isset($students) && !empty($students)){ 
		
		
    foreach($studentsda as $work){
    
                 $html.='<tr>';
             
  
   
   
   $st=$this->Comman->findsubjectopt($class_id,$section);
			
			
				
    if(isset($studentsubject) && !empty($studentsubject)){ 
		$g=0;
		$ert='0';
		 foreach($findroleexamtype as $ers){
			 
			  $findetypnasme=$this->Comman->findsubjectstotalssnames2($ers['etype_id']);
			
			
			 
	 
		   
		   	
			if($subjecname){
	
   $studentexamresult=$this->Comman->fsubjectmarksteachers2($examid,$work['student']['id'],$section,$class_id,$ers['etype_id'],$subjecname);	
	
}else{
	
   $studentexamresult=$this->Comman->fsubjectmarksteachers($examid,$work['student']['id'],$section,$class_id,$ers['etype_id']);	
	
}	

if(empty($studentexamresult)){
		if($subjecname){
	
   $studentexamresult=$this->Comman->fsubjectmarksteachers21($examid,$work['student']['id'],$section,$class_id,$ers['etype_id'],$subjecname);	
	
}else{
	
   $studentexamresult=$this->Comman->fsubjectmarksteachers212($examid,$work['student']['id'],$section,$class_id,$ers['etype_id']);	
	
}


}


 if(!empty($studentexamresult)){
			 	foreach($studentexamresult as $works){ 
							$ert=$works['marks'];
						}
			if($g==0 ){
 

		   $html.='<td width="5%">'.$counter++.'</td>';
   
      $html.='<td width="6%">'.$work['student']['enroll'].'</td>';
 
      $html.='<td width="20%" align="left" >&nbsp;'.ucwords(strtolower($work['student']['fname'])).' '.ucwords(strtolower($work['student']['middlename'])).' '.ucwords(strtolower($work['student']['lname'])).'</td>';
		$g++;} 
		foreach($studentexamresult as $works){ 
			
		
			$html.='<td><b>'.$works['marks'].'</b></td>';
		 if($ers['etype_id']=="1" || $ers['etype_id']=="26"){ 
			
				$html.='<td><b>';
				if($works['marks']!='0' && $works['marks']!='A' ){ 
					
					$weighted=$works['marks']/2;  
					$html.=round($weighted);  
					 }else{
			
						$html.=$works['marks'];
						
						} 
						$html.='</b></td>';
			
		}
  } } } }else{
	  $gs=0;
	
	  $ert='0';
	  
	  	 foreach($findroleexamtype2 as $ers){
			 
			  $findetypnasme=$this->Comman->findsubjectstotalssnames2($ers['etype_id']); 
	  
	   if(in_array("65",$st) || in_array("70",$st) || in_array("71",$st)){
					
			if($class_id=="10"){
						$rh='29';
						$studentexamresults=$this->Comman->fsubjectmarksteachersbysubject($examid,$work['student']['id'],$section,$class_id,$rh,$ers['etype_id']);
						foreach($studentexamresults as $works){ 
							$ert=$works['marks'];
						}
						
						
						
					}
					
					
					if($class_id=="11"){
						$rh='38';
							$studentexamresults=$this->Comman->fsubjectmarksteachersbysubject($examid,$work['student']['id'],$section,$class_id,$rh,$ers['etype_id']);
					foreach($studentexamresults as $works){ 
							$ert=$works['marks'];
						}
						
					}
				}else if(in_array("66",$st) || in_array("67",$st) || in_array("68",$st)){
					if($class_id=="10"){
						$rh='28';
						$studentexamresults=$this->Comman->fsubjectmarksteachersbysubject($examid,$work['student']['id'],$section,$class_id,$rh,$ers['etype_id']);
						foreach($studentexamresults as $works){ 
							$ert=$works['marks'];
						}
					
					}
					
					
					if($class_id=="11"){
						$rh='37';
							$studentexamresults=$this->Comman->fsubjectmarksteachersbysubject($examid,$work['student']['id'],$section,$class_id,$rh,$ers['etype_id']);
							foreach($studentexamresults as $works){ 
							$ert=$works['marks'];
						}
					
						
					}
					
				}
	   if(!empty($studentexamresults)){
	 if($gs==0){
    

		  $html.='<td width="5%">'.$counter++.'</td>';
   
      $html.='<td width="6%">'.$work['student']['enroll'].'</td>';
 
      $html.='<td width="20%" align="left" >'.ucwords(strtolower($work['student']['fname'])).' '.ucwords(strtolower($work['student']['middlename'])).' '.ucwords(strtolower($work['student']['lname'])).'</td>';
		$gs++;
		} 
	  
	  	foreach($studentexamresults as $works){ 
		
			$html.='<td><b>'.$works['marks'].'</b></td>';
		if($ers['etype_id']=="1" || $ers['etype_id']=="26"){ 
			
				$html.='<td><b>';
				if($works['marks']!='0' && $works['marks']!='A' ){ 
					
					$weighted=$works['marks']/2;  
					$html.=round($weighted);
					   }else{
						
						$html.=$works['marks'];
						
						} 
						
						$html.='</b></td>';
			
		}
  }
	  
	  
  }
	  
	} }
             
    
                $html.='</tr>';
            

                
   } }else{ 
    $html.='<tr>
    <td>NO Student Data Available</td>
    </tr>';
     } 
    $html.='</tbody></table>';
   } 
$html.='</body></html>';
$pdf->WriteHTML($html, true, false, true, false, '');
echo $pdf->Output('PrintResult.pdf');
exit;
ob_end_clean();
?>
