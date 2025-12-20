
 
            
		<?php $page = $this->request->params['paging']['Students']['page'];
		$limit = $this->request->params['paging']['Students']['perPage'];
		$counter = ($page * $limit) - $limit + 1; 
		if(isset($students) && !empty($students)){ 
		foreach($students as $work){
		?>
                <tr>
               <td><?php echo $counter;?></td>
   
      <td><?php echo $work['enroll']; ?></td>
 
      <td><a href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $work['id']; ?>"> <?php echo $work['fname']; ?> <?php echo $work['middlename']; ?> <?php echo $work['lname']; ?> </a></td>
       <td><?php echo $work['fathername']; ?></td>
     
    
     <td><?php echo $work['classtitle']; ?></td>
       <td><?php echo $work['sectiontitle']; ?></td>
  
                   <td><?php  $house=$this->Comman->findhouse($work['h_id']); echo $house['name']; ?></td>
         <td><a title="Print Fee Ack." href="<?php echo SITE_URL; ?>admin/report/feeacknowledgement/<?php echo $work['id']; ?>"><i class="fa fa-file-text-o"></i></a>
                   </td>
		
                </tr>
		<?php $counter++;} }else{ ?>
		<tr>
		<td colspan="11" style="text-align:center;">NO Data Available</td>
		</tr>
		<?php } ?>	
               
