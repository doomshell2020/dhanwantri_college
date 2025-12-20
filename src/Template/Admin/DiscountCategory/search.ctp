          <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Receipt Number</th>
                       <th>Sr. No.</th>
                  <th>Name</th>
                  <th>Class</th>
                  <th>Section</th>
                  <th>Father name</th>
                  <th>Mobile</th>
                   <th>Discount</th>
                 
                </tr>
                </thead>
                <tbody id="example3">
		<?php $counter=1;
		if(isset($students) && !empty($students)){ 
		foreach($students as $work){ 

		?>
                <tr>
                  <td><?php echo $counter;?></td>
				                   

                  <td><?php if(isset($work['id'])){  
					  
					  $wrecipiet=$this->Comman->findrecipiet($work['id'],$work['discountcategory']);   
					  
					   echo ucfirst($wrecipiet['recipetno']);}else{ echo '-';}?></td>
                                    <td><?php if(isset($work['enroll'])){ echo ucfirst($work['enroll']);}else{ echo 'N/A';}?></td>
                  <td><a target="_blank" href="<?php echo SITE_URL ?>admin/studentfees/index/<? echo $work['id']; ?>/<? echo $work['acedmicyear']; ?>"><?php if(isset($work['fname'])){ echo ucfirst(strtolower($work['fname'])); ?>&nbsp; <? echo ucfirst(strtolower($work['middlename'])); ?>&nbsp; <? echo ucfirst(strtolower($work['lname']));}else{ echo 'N/A';}?></a></td>
                  <td><?php if(isset($work['classname'])){ echo ucfirst($work['classname']);}else{ echo 'N/A';}?></td>
                  <td><?php if(isset($work['sectionname'])){ echo ucfirst($work['sectionname']);}else{ echo 'N/A';}?></td>
                  <td><?php if(isset($work['fathername'])){ echo ucfirst($work['fathername']);}else{ echo 'N/A';}?></td>
                  <td><?php if(isset($work['sms_mobile'])){ echo ucfirst($work['sms_mobile']);}else{ echo 'N/A';}?></td>
                    <td><?php if(isset($work['discountcategory'])){ echo ucfirst($work['discountcategory']);}else{ echo 'N/A';}?></td>
				  

		
                </tr>
		<?php $counter++;} }else{?>
		<tr>
		<td>NO Data Available</td>
		</tr>
		<?php } ?>	
                </tbody>
               
              </table>
