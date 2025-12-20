
<?php 

echo WWW_ROOT; die;


eco 
if($attendence_status >0 ){

    
 $g=0;

foreach($attendences as $j){
    
    
  $mobile=trim($j['student']['sms_mobile']);
			

		$g++;			
	$mesg="Dear Parent, Please be informed that your ward is absent from school today.";

	//$result=$this->file_get_contents_curl('http://alerts.prioritysms.com/api/web2sms.php?workingkey=Afb7ede974e22367003ac66f8514bd152&to='.$mobile.'&sender=SNSKAR&message='.urlencode($mesg));

}
	
	
}else{
	
	echo "Fail"; die;	
	
}
echo "Success".$g; die;  ?>
