
  
  <?php $role_id= $this->request->session()->read('Auth.User.role_id');

    if($role_id=='3'){ 
 
		$page = $this->request->params['paging']['Students']['page'];
		$limit = $this->request->params['paging']['Students']['perPage'];
		$counter = ($page * $limit) - $limit + 1; 
		if(isset($classes) && !empty($classes)){ 
		
		
		foreach ($examtypes  as $key){
	    foreach ($csection as $key => $sec) {
		?>
                <tr>
   
       <td><?php echo $counter;?></td>

       <td><?php echo $sec['Sections']['title']; ?></td>
 
        <td><?php echo $sec['Classes']['title']; ?></td>

      <td><?php echo $examtypes[0]['Examtypes']['name']; ?></td>
     <td><?php echo $examtypes[0]['acedamicyear']; ?></td>
  
  
                  <td><?php if($examtypes[0]['status']=='Y'){  ?>
	<span class="label label-primary">Activate</span>
	
<?php $this->Session->write('User.email', 'abc@example.com');
$this->Session->write('User.phone', '090x108986');
$this->Session->write('User.site', 'http://rao5s.vn');
// Now you can read a array from Session
$arrUser = $this->Session->read('User'); ?>



			<?php  }else{ ?>
				<span class="label label-primary">Deactivate</span>
				
			<?php } ?>
</td>
                   <td> 
                  <?php $totalsubjectmarks=$this->Comman->findexamresult($examtypes[0]['id'],$work['Sections']['id']);  if($totalsubjectmarks['id']){  
					       $role_id= $this->request->session()->read('Auth.User.role_id');
					       
					       if($role_id=='3'){
					    $findclasssection=$this->Comman->findclassectionsed();    
					    if ($findclasssection['class_id']==$work['Classes']['id'] &&  $findclasssection['section_id']==$work['Sections']['id']) { ?>
					    	<a style="color:#900;" title="Update Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
                    <a title="View Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/viewresult/<?php echo $examtypes[0]['id']; ?>/<?php echo $sec['Sections']['id']; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
					    
					    <?php }else{ ?>
					      <a title="View Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/viewresult/<?php echo $examtypes[0]['id']; ?>/<?php echo $sec['Sections']['id']; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
					    
					    <?php } ?>
					    
				<?php }else{ ?>
                    
                    
                    
                    	<a style="color:#900;" title="Update Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
                    <a title="View Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/viewresult/<?php echo $examtypes[0]['id']; ?>/<?php echo $sec['Sections']['id']; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
                    
                    
                   <?php } }else{    
					   $role_id= $this->request->session()->read('Auth.User.role_id');
					       
					     if($role_id=='3'){
					     $findclasssection=$this->Comman->findclassectionsed();    
					    if ($findclasssection['class_id']==$work['Classes']['id'] &&  $findclasssection['section_id']==$work['Sections']['id']) { ?>
					      <a title="Submit Result"  href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $examtypes[0]['id']; ?>/<?php echo $sec['Sections']['id']; ?>"><i class="fa fa-upload" aria-hidden="true"></i></a>
					    
					    <?php }else{ ?>
					    
					    
					    <?php } ?>
                   
              
                   
                    
                   <?php }else{ ?>
                   
                    <a title="Submit Result"  href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $examtypes[0]['id']; ?>/<?php echo $sec['Sections']['id']; ?>"><i class="fa fa-upload" aria-hidden="true"></i></a>
                   
                   
                <?php   
                   } } ?> 
                   </td>
		
                </tr>
		<?php $counter++;}  } } } elseif($role_id!='3'){ ?>
		<?php 
		$page = $this->request->params['paging']['Students']['page'];
		$limit = $this->request->params['paging']['Students']['perPage'];
		$counter = ($page * $limit) - $limit + 1; 
		if(isset($classes) && !empty($classes)){ 
		
		
		foreach ($examtypes  as $key){
		foreach($classes as $work){ 
		?>
                <tr>
               <td><?php echo $counter;?></td>
   
      <td><?php echo $work['Sections']['title']; ?></td>
 
        <td><?php echo $work['Classes']['title']; ?></td>
     
      <td><?php echo $examtypes[0]['Examtypes']['name']; ?></td>
     <td><?php echo $examtypes[0]['acedamicyear']; ?></td>
  
  
                  <td><?php if($examtypes[0]['status']=='Y'){  ?>
	<span class="label label-primary">Activate</span>
			
			<?php  }else{ ?>
				<span class="label label-primary">Deactivate</span>
				
			<?php } ?>
</td>
                   <td> 
                  <?php $totalsubjectmarks=$this->Comman->findexamresult($examtypes[0]['id'],$work['Sections']['id']);  if($totalsubjectmarks['id']){  
					       $role_id= $this->request->session()->read('Auth.User.role_id');
					       
					       if($role_id=='3'){
					    $findclasssection=$this->Comman->findclassectionsed();    
					    if ($findclasssection['class_id']==$work['Classes']['id'] &&  $findclasssection['section_id']==$work['Sections']['id']) { ?>
					    	<a style="color:#900;" title="Update Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
                    <a title="View Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/viewresult/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
					    
					    <?php }else{ ?>
					      <a title="View Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/viewresult/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
					    
					    <?php } ?>
					    
				<?php }else{ ?>
                    
                    
                    
                    	<a style="color:#900;" title="Update Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
                    <a title="View Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/viewresult/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
                    
                    
                   <?php } }else{    
					   $role_id= $this->request->session()->read('Auth.User.role_id');
					       
					     if($role_id=='3'){
					     $findclasssection=$this->Comman->findclassectionsed();    
					    if ($findclasssection['class_id']==$work['Classes']['id'] &&  $findclasssection['section_id']==$work['Sections']['id']) { ?>
					      <a title="Submit Result"  href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>"><i class="fa fa-upload" aria-hidden="true"></i></a>
					    
					    <?php }else{ ?>
					    
					    
					    <?php } ?>
                   
              
                   
                    
                   <?php }else{ ?>
                   
                    <a title="Submit Result"  href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>"><i class="fa fa-upload" aria-hidden="true"></i></a>
                   
                   
                <?php   
                   } } ?> 
                   </td>
		
                </tr>
		<?php $counter++;}  } }}else{ ?>
		<tr>
		<td colspan="11" style="text-align:center;">NO Data Available</td>
		</tr>
		<?php } ?>	
               
