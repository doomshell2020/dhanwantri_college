<div class="table-responsive">
   <table id="" class="table table-bordered table-striped">
      <tbody>
         <tr>
            <th>S.No</th>
            <th>Class</th>
            <th>Section</th>
            <th>Class Teacher</th>
            <th>Mobile No.</th>
            <th>Strength</th>
            <th> Absent Today </th>
            <th> Take Attendance </th>
         </tr>
         <?php
            $page = $this->request->params['paging']['Services']['page'];
            $limit = $this->request->params['pagc_c_iding']['Services']['perPage'];
            $counter = 1;
            $total = 0;
            $totalfee = 0;
            $out = 0;
            $total_discount = 0;
            $total_absent = 0;
            
            $session = $this->request->session();
            $session->delete($classess);
            $session->write('classess', $classess);
            if (isset($classess) && !empty($classess)) {
            
                $findstudentamount = 0;
                $findstudentrfidclass = 0;
                foreach ($classess as $element) {
            
                    if ($element['class_id']) {
                        $findstudenttotlaclassdds = $this->Comman->classtotalstudent($element['class_id'], $element['section_id']);
                        if ($findstudenttotlaclassdds == 0) {
                            continue;
                        }
            
                        $s_id = $element['class_id'];
                        $c_id = $element['section_id'];
            ?>
         <tr>
            <td><?php echo $counter;  ?></td>
            <td><?php $class = $this->Comman->findclasses($s_id); echo $class[0]['title']; ?> </td>
            <td><?php  echo $element['Sections']['title'];  ?> </td>
            <td><?php
               $ss = $this->Comman->findclassteachersorginal($element['class_id'], $element['section_id']);
               $studentname = ucwords(strtolower($ss['employee']['fname'] . " " . $ss['employee']['middlename'] . " " . $ss['employee']['lname']));
               echo $studentname;
               ?> 
            </td>
            <td><?php echo $ss['employee']['mobile']; ?> </td>
            <?php $findstudentamount = $this->Comman->findstudentcountclass($element['class_id'], $element['section_id']);  ?>
            <td> <?php  echo $findstudenttotlaclassdds; ?></td>
            <td> <?php
               $findstudenttotlacslasssabsent = $this->Comman->absentclasstodayreportss23($element['class_id'], $element['section_id'],$date);
               
               
               $classstodayreportss23 = $this->Comman->classtodayreportss23($element['class_id'], $element['section_id'],$date);
               
               
               $classstotalstudent = $findstudenttotlaclassdds;
               
               if ($classstodayreportss23) {
               if ($findstudenttotlacslasssabsent != '0') {
               ?><a target="_blank" href="<?php echo SITE_URL; ?>admin/students/searchabsent/<?php echo $element['class_id']; ?>/<?php echo $element['section_id']; ?>"> <? $total_absent += $findstudenttotlacslasssabsent;  echo $findstudenttotlacslasssabsent; ?></a> <?php } else {  echo 0;   }  } else{ ?><strong style="color:red;"><? echo $findstudenttotlaclassdds; ?></strong> </a> <?php  }   ?></a>
            </td>
            <td><?php if ($output['canTakeAttendance'] == 1) {
               $mid = base64_encode(base64_encode($element['class_id'] . '/' . $element['section_id'] . '/' . $acedmic.'/'.$date)) ?>
               <a href="<?php echo ADMIN_URL; ?>studattends/attendence/<?php echo $mid; ?>"><i class="fas fa-street-view"></i></a>
               <?php } else { ?> <i class="fas fa-ban"></i><?php } ?>
            </td>
         </tr>
         <?php $counter++;
            }
            }
            } else { ?>
         <td colspan="8" style="text-align:center;">No Student Data Available</td>
         <?    } ?>
   </table>
   <span id="tabsent" style="display:none;"><? echo $total_absent; ?></span>
   <script>
      $(document).ready(function() {
          var tabse = $("#tabsent").text();
          $("#tabsent2").html(tabse);
      
      });
   </script>
</div>