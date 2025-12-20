<?php // pr($examtypes);
		$page = $this->request->params['paging']['Students']['page'];
		$limit = $this->request->params['paging']['Students']['perPage'];
		$counter = ($page * $limit) - $limit + 1; 
		
		
		if(isset($classes) && !empty($classes)){ 
		
		
		foreach ($examtypes  as $key){
//pr($key);
		foreach($classes as $work){ 

		
		?>
                 <tr>
               <td><?php echo $counter;?></td>
   
     
 
        <td> <a href="<? echo ADMIN_URL; ?>studentexamresult/searcharea/<? echo $work['Classes']['id']; ?>/<? echo $work['Sections']['id']; ?>" title="View Student List" target="_blank"><?php echo $work['Classes']['title']."-".$work['Sections']['title']; ?></a>
      </td>
      <td><?php $e_type_id=explode(',',$key['e_type_id']);
                         
      $stcounr=$this->Comman->findexamner($work['Classes']['id'],$e_type_id[0]);
       echo $stcounr['examname']; ?></td>
          
      
   
        <td>  <? $stcounr=$this->Comman->findexamresultstudentcounts2($work['Classes']['id'],$work['Sections']['id']); ?> <? echo $stcounr; ?></td>
        
        
        
        <td><?  $absentcounr=$this->Comman->findexamresultstudentabsentcount($work['Classes']['id'],$work['Sections']['id'],$key['id']);  if($absentcounr>0){ ?><a title="Retest Absent Student" target="_blank"  href="<? echo ADMIN_URL; ?>studentexamresult/retestprocess/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $key['id']; ?>"  style="text-decoration: underline;"><? echo "View"; ?></a>  <? }else{  echo "0";  } ?>  </td>
        
                <td><? $absentcounr1=$this->Comman->findexamresultstudentcounts2($work['Classes']['id'],$work['Sections']['id']);
                
                 $absentcounr2=$this->Comman->findexamresultstudentgivecount($work['Classes']['id'],$work['Sections']['id'],$key['id']); 
                 
                 $as=count($absentcounr1);  $as2=count($absentcounr2); 
                 $stcounrss=$this->Comman->findexamresultstudentcounts2($work['Classes']['id'],$work['Sections']['id']);
                 
                 
               if($as2 < $as){
				   $extracnt=$as-$as2;
			
				 ?>
				  <? if($stcounrss==$extracnt){ echo "--";  }else{ ?>
				   <a title="New Student" target="_blank"  href="<? echo ADMIN_URL; ?>studentexamresult/examnewstudents/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $key['id']; ?>"  style="text-decoration: underline;"><? echo $extracnt; ?></a>
				   <? } }else{  echo "--"; } ?> </td>

    
  
             
        <td> <? 
        $excount= $this->Comman->findexamresultcount($work['Classes']['id'],$work['Sections']['id']);  if($key['Examtypes']['id']=='4' || $key['Examtypes']['id']=='9' ){  if($excount>=$examtypesterm1) { ?>
        
        
        <a class="uploadfromd"  href="<? echo ADMIN_URL; ?>studentexamresult/genratecard/<? echo $work['Classes']['id']; ?>/<? echo $work['Sections']['id']; ?>/<? echo "Term".$key['Examtypes']['term']; ?>"><? echo "Generate Term".$key['Examtypes']['term']." Result"?></a><br>
        
        <?    if (!file_exists(WWW_ROOT.'excel_file/student/'.$work['Classes']['title'].'-'.$work['Sections']['title'].'-Term'.$key['Examtypes']['term'].'.pdf')) {   
$filefounsd ='0';                         
}else{
$filefounsd='1';

}

if($filefounsd=='1'){

?><a target="_blank" href="<?php echo SITE_URL; ?>excel_file/student/<? echo $work['Classes']['title']; ?>-<? echo $work['Sections']['title']; ?>-Term<? echo $key['Examtypes']['term']; ?>.pdf" >View Result</a> <?  }

?>
        
        
        <? }else{
        echo "Term 2".$key['Examtypes']['term'];
        
        
        }  }else{
        
        
         echo "Term 2".$key['Examtypes']['term'];
        } ?></td>
      
     <td><?php echo date('d-m-Y',strtotime($key['resultuploadlast_date'])); ?></td>
      <td><?php echo date('d-m-Y',strtotime($key['resultdeclare_date'])); ?></td>
  
  
                 
                 
		
                </tr>
		<?php $counter++; }  } }else{ ?>
		<tr>
		<td colspan="11" style="text-align:center;">NO Data Available</td>
		</tr>
		<?php } ?>	
               <script>

$('.uploadfromd').on('click',function(e){

var foo=this.href;
$.ajax({
       async:true,
       url: foo,
       method: 'get', 
  //if you're sure its returning json you can set this
       beforeSend: function(xhr) {
$("#myBar").show();
	document.getElementById("myBar").className="show";
 $('html, body').animate({
      scrollTop: 0
    }, 500);
   var elem = document.getElementById("myBar");
    var width = 10;
    var id = setInterval(frame, 900);
    function frame() {
        if (width >= 99) {
            clearInterval(id);
        } else {
            width++;
            elem.style.width = width + '%';
            elem.innerHTML = width * 1 + '%';
        }
    }
 var div= document.createElement("div");
    div.className += "overlay";
    document.body.appendChild(div);
},
       success: function(data) {
       
       
 
       },
       error: function(error) {
           //handle error json here
       }
});

//event.preventDefault();
});
</script>
