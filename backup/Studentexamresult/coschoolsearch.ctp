
 
            
		<?php 
		$page = $this->request->params['paging']['Students']['page'];
		$limit = $this->request->params['paging']['Students']['perPage'];
		$counter = ($page * $limit) - $limit + 1; 
		if(isset($classes) && !empty($classes)){ 
		
		
	
		foreach($classes as $work){
		?>
                <tr>
               <td><?php echo $counter;?></td>
   
  
 
        <td><?php echo $work['Classes']['title']; ?></td>
            <td><?php echo $work['Sections']['title']; ?></td>
        <td><?php echo $term; ?></td>
     
    
     <td><?php echo $examtypes[0]['acedamicyear']; ?></td>
  
  
               
                   <td> 
      <?php  $totalsubjectmarks=$this->Comman->findcoactivityresult($work['Classes']['id'],$work['Sections']['id'],$term,$examtypes[0]['acedamicyear']);  
                   
                   if($totalsubjectmarks['id']){
					   
					   $role_id= $this->request->session()->read('Auth.User.role_id');
					       
					       if($role_id=='3'){
					    $findclasssection=$this->Comman->findclassectionsed();    
					    if ($findclasssection['class_id']==$work['Classes']['id'] &&  $findclasssection['section_id']==$work['Sections']['id']) { ?> 
                   
                   <a style="color:#900;" title="Update Result" href="<?php echo SITE_URL; ?>admin/Coactivityresults/addcsv/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $examtypes[0]['acedamicyear']; ?>/<?php echo $term; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
                    <a title="View Result" href="<?php echo SITE_URL; ?>admin/Coactivityresults/viewresult/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $examtypes[0]['acedamicyear']; ?>/<?php echo $term; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
                    <?php }else{ ?>
                    
                     <a title="View Result" href="<?php echo SITE_URL; ?>admin/Coactivityresults/viewresult/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $examtypes[0]['acedamicyear']; ?>/<?php echo $term; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
                    
                    
                     <?php } ?>
					    
				<?php }else{ ?>
                    
                    <a style="color:#900;" title="Update Result" href="<?php echo SITE_URL; ?>admin/Coactivityresults/addcsv/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $examtypes[0]['acedamicyear']; ?>/<?php echo $term; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
                    <a title="View Result" href="<?php echo SITE_URL; ?>admin/Coactivityresults/viewresult/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $examtypes[0]['acedamicyear']; ?>/<?php echo $term; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
                    
                    
                     <?php } }else{   
						 
						  $role_id= $this->request->session()->read('Auth.User.role_id');
					       
					     if($role_id=='3'){
					     $findclasssection=$this->Comman->findclassectionsed();    
					    if ($findclasssection['class_id']==$work['Classes']['id'] &&  $findclasssection['section_id']==$work['Sections']['id']) { ?>
                      <a style="color:#900;" title="Update Result" href="<?php echo SITE_URL; ?>admin/Coactivityresults/addcsv/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $examtypes[0]['acedamicyear']; ?>/<?php echo $term; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
                        <?php }else{ ?>
					    
					    
					    <?php } ?>
					    
					         <?php }else{ ?>
					         
					            <a style="color:#900;" title="Update Result" href="<?php echo SITE_URL; ?>admin/Coactivityresults/addcsv/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $examtypes[0]['acedamicyear']; ?>/<?php echo $term; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
                   
                    
                    
                    
                    
                    <?php   
                   } } ?> 
                   
                   
                  </td>
		
                </tr>
		<?php $counter++;}   }else{ ?>
		<tr>
		<td colspan="11" style="text-align:center;">NO Data Available</td>
		</tr>
		<?php } ?>	
               
