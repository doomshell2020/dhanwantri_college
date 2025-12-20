
    
    
<?php //pr($result); die; ?>

    <tr style="background-color:#39cccc !important; color:white">
    <th>S.No</th>
    <th>Scholar No.</th>
    <th>Name of Student</th>
    <th>Father's Name</th>
    <th>Mobile No.</th>
    <th>Class</th>
    <th>Action</th>
    </tr>
		       
      <?php 
       
      $page = $this->request->params['paging']['Services']['page'];
		$limit = $this->request->params['pagc_c_iding']['Services']['perPage'];
		$counter = ($page * $limit) - $limit + 1;
	  
      
 
		if(isset($result) && !empty($result)){ 
            $i=0;
            $name=array();
            $p_name=array();
            $mobile=array();
            $scholar=array();
            $class_ids=array();
			foreach($result as $key=>$element) {
                $drop="";
                //pr($element); die;
                $name[$i]=$element['fname']." ".$element['middlename'];
                $p_name[$i]=$element['fathername'];
                $mobile[$i]=$element['sms_mobile'];
                $scholar[$i]=$element['enroll'];
                 if (isset($element['laststudclass']) && !empty($element['laststudclass'])) {
                  $class_ids[$i] = $element['laststudclass'];
                  } else {
                         $class_ids[$i] = $element['class_id'];
                         }
                $drop = $element['dropcreated'];
                if (isset($element['laststudclass']) && !empty($element['laststudclass'])) {
                $s_id = $element['laststudclass'];
                $c_id = '';
                } else {
                 $s_id = $element['class_id'];
                 $c_id = $element['section_id'];
                 }
                
                //pr($name);
				
                 $class=$this->Comman->findclasses($s_id);
                 $section=$this->Comman->findsections($c_id);
                 //pr($section); die;
		?>
				 <tr>
			     <td><?php echo $counter;?></td>
			     <td><?php echo $element['enroll'];?></td>
                 <td><?php echo $element['fname']." ".$element['middlename']; if(isset($drop) && !empty($drop)){ ?> <span style="color:red">(Drop Out Student)</span>  <? } ?></td>
                 <td><?php echo $element['fathername']; ?></td>
                 <td><?php echo $element['sms_mobile']; ?></td>
                 <td><?php  echo $class[0]['title']."&nbsp;".$section[0]['title']; ?></td>
			     <td><button type="button"  class="sele" value="<?php echo $i?>">Select</button></td>
	            
                          </tr>
		<?php $counter++; $i++;}
	  } else { ?>
	  <tr>
	  <td colspan="9" style="text-align:center;">No Data Available</td>   
	  </tr>
	  <?	}  ?>
      <script>
      
        $('.sele').click(function(){
            var i=$(this).val();
            //alert(i);
        var name=<?php echo json_encode($name); ?>;  
        var p_name=<?php echo json_encode($p_name); ?>;
        var mobile=<?php echo json_encode($mobile); ?>; 
        var scholar=<?php echo json_encode($scholar); ?>; 
        var class_ids = <?php echo json_encode($class_ids); ?>;
 
           $("#pupilname").val(name[i]);
           $("#p_name").val(p_name[i]);
           $("#dup_mobile").val(mobile[i]);
           $("#scholar_no").val(scholar[i]);
           $("#class_id").val(class_ids[i]);
           $("#src-rslt").hide();

          });
        </script>
     
                    
        
    
     

