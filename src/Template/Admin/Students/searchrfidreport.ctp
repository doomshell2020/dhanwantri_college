<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="table-responsive">
<table id="" class="table table-bordered table-striped">
   <tbody>
      <tr>
      </tr>
      <tr>
         <th>No</th>
         <th>Sr.No</th>
         <th>Date </th>
         <th>Student Name</th>
         <th>Class</th>
         <th>Section</th>
         <th>Father's Name</th>
         <th>Mobile</th>
         <th> Machine Status</th>
      </tr>
      <?php 
         $page = $this->request->params['paging']['Services']['page'];
         $limit = $this->request->params['pagc_c_iding']['Services']['perPage'];
         $counter = 1;
         $total=0;
         $totalfee=0;
         $out=0;
         $total_discount=0;
         
         
         if(isset($studentrfidsd) && !empty($studentrfidsd)){ 
         foreach($studentrfidsd as $element) {
         if($element['class_id']){
         $s_id=$element['class_id'];
         $c_id=$element['section_id'];
         ?>
      <tr>
         <td><?php echo $counter;  ?></td>
         <td><?php echo $element['enroll'];  ?></td>
         <td><?php echo date('d-m-Y',strtotime($element['resultdate']));  ?></td>
         <td><?php   $studentname= $element['fname']." ".$element['middlename']." ".$element['lname']; echo $studentname; ?></td>
         <td><?php $class=$this->Comman->findclasses($s_id);
            echo $class[0]['title'];
            ?>    </td>
         <td><?php 
            $section=$this->Comman->findsections($c_id);
               echo $section[0]['title'];
            ?>    </td>
         <td><?php echo $element['fathername'];?></td>
         <td><?php echo $element['sms_mobile'];?></td>
         <td> <?  echo "Present";?></td>
      </tr>
      <?php $counter++;}}
         } else { ?>
      <td colspan="8" style="text-align:center;">No Present Data Available</td>
      <?	} ?>
</table>
<div>