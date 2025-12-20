
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Staff Timetable Manager
       
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
    
     <div class="row">
        <div class="col-xs-12">
          
  <div class="box">
      <?php  $role= $this->request->session()->read('Auth.User.role_id'); 
 $username= $this->request->session()->read('Auth.User.email');   ?>
            <!-- /.box-header -->
<?php echo $this->Flash->render(); ?>
<span class="text-muted" style="padding-left: 10px; font-size: 15px;">
    <?php if($classsss) { ?>
      <strong>Class Teacher :</strong> <?php echo $fname; ?> <?php echo $middlename; ?> <?php echo $lname; ?> | <strong>Class Name: </strong> <?php echo $classsss; ?> <!-- | <strong>Section Name : </strong> <?php echo $sectionsss; ?> --> <!--  | <strong>Acedmicyear : </strong> <?php echo $acedimc; ?>  </span> -->
      
      <?php }else{ ?>
      <strong> Teacher :</strong> <?php echo $fname; ?> <?php echo $middlename; ?> <?php echo $lname; ?> | <strong>Acedmicyear : </strong> <?php echo $acedimc; ?>  </span>
      
      <?php } ?>
          </div>  </div>  </div>
    
    
    
    <div class="row" >
        <div class="col-xs-12">
          
  <div class="box" >
            <div class="box-header">
              <i class="fa fa-search" aria-hidden="true"></i>
<h3 class="box-title">TimeTable </h3>


            </div>
      <div class="row">
       <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
       
            <!-- /.box-header -->
            <!-- form start -->
                   <div class="box-body">
          <div class="box-body" id="resizable-tables">
                   <table class="table table-bordered table-striped">
            <thead>

       <!--      <p class="text-right btn-view-group">
  <a class="btn btn-primary" href="<?php echo SITE_URL;?>admin/ClasstimeTabs/pdf_teacher" target="blank"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
  </p>
 -->
  

              <tr> 

                <th class="text-center bg-teal color-palette">Class Timing</th>
                <?php 
  $date = date('Y-m-d');

// parse about any English textual datetime description into a Unix timestamp 
$ts = strtotime($date);
// find the year (ISO-8601 year number) and the current week
$year = date('o', $ts);
$week = date('W', $ts);
// print week for the current date
for($i = 1; $i <= 7; $i++) { ?>
   <?php 
   $ts = strtotime($year.'W'.$week.$i);
   $hol= date("l", $ts);
              if($hol!='Sunday'){  ?>

                                  <th class="text-center bg-teal color-palette"> <?php $ts = strtotime($year.'W'.$week.$i);
                             

    print date("d-m-Y", $ts) . "<br>".date("l", $ts);?></th>
  <?php  }}  ?>
  

                             
                            </tr>
            </thead>

            <style type="text/css">
              .unselectable1{ background-color: #ddd; cursor: not-allowed; }
               a.unselectable{pointer-events:none;}
            </style>
              

            
            <tbody>
          <?php     if($classectionid) { if(isset($timetabledata) && !empty($timetabledata)){  
    foreach($timetabledata as $work){ // pr($work); 
             
  $getdata='0';  if($work['is_break'] != 1 ) { ?>
                            <tr>
                              <?php
/*                         
$day= date("l"); ?>

<?php //echo $day;*/ ?>
                            <td class="text-center"><?php echo '<b>'.$work['name'].' </b>'; ?> </td>
                                        <td class="text-center <?php if ($day!='Monday')  { ?>unselectable1 <?php } ?>" 
  style="word-break: keep-all;"><?php if (strpos($work['weekday'], "Monday") !== false )  {


                  $getdata= $this->Comman->gettimetableteacher($work['id'],"Monday",$classectionid);
                 
                 // pr($getdata);
                  $clsssection=$this->Comman->find_alls($getdata[0]['class_id']);
                  //pr($clsssection); 
                  $section_id=$clsssection['section_id'];
                  $class=$clsssection['class_id']; 

                   $cksub= $this->Comman->checksubstitute($work['id'],"Monday",$class);
                  //pr($cksub); 
                   $nid=$cksub[0]['new_empid'];
                          $fsub= $this->Comman->findempname($nid);
                           //pr($empname);
                  $subj_id=  $cksub[0]['subject_id'];
                  $fsub= $this->Comman->findsubjectsubs($subj_id);
                 // pr($fsub); die;
                       $section=$clsssection['section_id'];  $classtitle=$clsssection['Classes']['title']; 

                       $sectiontitle=$clsssection['Sections']['title']; ?>

                       <span rel="tooltip" data-toggle="tooltip" title="<?php   if(!empty($getdata)){ echo $getdata[0]['Subjects']['name'].'&nbsp;('.$getdata[0]['Employees']['fname'].'&nbsp;'.$getdata[0]['Employees']['middlename'].'&nbsp;'.$getdata[0]['Employees']['lname'].')';  }else{ echo "Assign Lecture"; } ?>">


                        <?php if(!empty($getdata)){ if(empty($cksub )) {  ?><a class="globalModals <?php if ($day!='Monday')  { ?>unselectable <?php } ?>" href="<?php echo SITE_URL;?>admin/EmployeeAttendance/add/<?php echo $work['id'] ?>/<?php echo $class; ?>/Monday/<?php echo $emp; ?>/<?php echo $section; ?>" data-target="#globalModal" data-toggle="modal"><?php echo $getdata[0]['Subjects']['alias'];  ?></a> </br><?php echo  $classtitle; ?>( <?php echo $sectiontitle; ?>)<?php } else { ?>


<a class="globalModals <?php if ($day!='Monday')  { ?>unselectable <?php } ?>" href="<?php echo SITE_URL;?>admin/EmployeeAttendance/edit/<?php echo $cksub[0]['id'] ?>/<?php echo $emp; ?>" data-target="#globalModal" data-toggle="modal"><?php echo $fsub['alias'];  ?></a>  </br><?php echo  $classtitle; ?>( <?php echo $sectiontitle; ?>)<br><p style="color:green;"><b><?php echo $fsub['fname'].' '.$fsub['middlename'].' '.$fsub['lname']; ?></b></p> <?php } ?>

                     
                   
                        <?php  }else{ echo "-"; } ?> </span> 


                      <?php  }  ?></td>


                      <td class="text-center <?php if ($day!='Tuesday')  { ?>unselectable1 <?php } ?>" style=" word-break: keep-all;"><?php if (strpos($work['weekday'], "Tuesday") !== false) {

                       $getdata= $this->Comman->gettimetableteacher($work['id'],"Tuesday",$classectionid); 

                       $clsssection=$this->Comman->find_alls($getdata[0]['class_id']); 

                        $class=$clsssection['class_id']; 
                         $section=$clsssection['section_id'];  
                        $cksub= $this->Comman->checksubstitute($work['id'],"Tuesday",$class);
                        $nid=$cksub[0]['new_empid'];
                          $fsub= $this->Comman->findempname($nid);
                        $classtitle=$clsssection['Classes']['title']; 
                        $sectiontitle=$clsssection['Sections']['title']; ?>

                        <span title="<?php   if(!empty($getdata)){ echo $getdata[0]['Subjects']['name'].'&nbsp;('.$getdata[0]['Employees']['fname'].'&nbsp;'.$getdata[0]['Employees']['middlename'].'&nbsp;'.$getdata[0]['Employees']['lname'].')';  }else{ echo "Assign Lecture"; } ?>" data-toggle="tooltip" >

                       <?php if(!empty($getdata)){ if(empty($cksub )) {  ?><a class="globalModals" href="<?php echo SITE_URL;?>admin/EmployeeAttendance/add/<?php echo $work['id'] ?>/<?php echo $class; ?>/Tuesday/<?php echo $emp; ?>/<?php echo $section; ?>" data-target="#globalModal" data-toggle="modal"><?php echo $getdata[0]['Subjects']['alias'];  ?></a>  </br><?php echo  $classtitle; ?>( <?php echo $sectiontitle; ?>)<?php } else { ?>


<a class="globalModals" href="<?php echo SITE_URL;?>admin/EmployeeAttendance/edit/<?php echo $cksub[0]['id'] ?>/<?php echo $emp; ?>" data-target="#globalModal" data-toggle="modal"><?php echo $getdata[0]['Subjects']['alias'];  ?></a>   </br><?php echo  $classtitle; ?>( <?php echo $sectiontitle; ?>)<br><p style="color:green;"><b><?php echo $fsub['fname'].' '.$fsub['middlename'].' '.$fsub['lname']; ?></b></p><?php } ?>

                     <?php  }else{ echo "-";
                        } ?> </span><?php } ?></td>

                        <td class="text-center <?php if ($day!='Wednesday')  { ?>unselectable1 <?php } ?>" style=" word-break: keep-all;"><?php if (strpos($work['weekday'], "Wednesday") !== false) { 

                          $getdata= $this->Comman->gettimetableteacher($work['id'],"Wednesday",$classectionid); 

                          $clsssection=$this->Comman->find_alls($getdata[0]['class_id']);  

                          $class=$clsssection['class_id'];  
                          $section=$clsssection['section_id']; 
                          $cksub= $this->Comman->checksubstitute($work['id'],"Wednesday",$class);
                         
                          $nid=$cksub[0]['new_empid'];
                          $fsub= $this->Comman->findempname($nid);
                           //pr($empname);

                           $classtitle=$clsssection['Classes']['title']; 
                           $sectiontitle=$clsssection['Sections']['title'];  ?>

                           <span title="<?php   if(!empty($getdata)){ echo $getdata[0]['Subjects']['name'].'&nbsp;('.$getdata[0]['Employees']['fname'].'&nbsp;'.$getdata[0]['Employees']['middlename'].'&nbsp;'.$getdata[0]['Employees']['lname'].')';  }else{ echo "Assign Lecture"; } ?>" data-toggle="tooltip" >



                          <?php if(!empty($getdata)){  if(empty($cksub )) {  ?><a class="globalModals" href="<?php echo SITE_URL;?>admin/EmployeeAttendance/add/<?php echo $work['id'] ?>/<?php echo $class; ?>/Wednesday/<?php echo $emp; ?>/<?php echo $section; ?>" data-target="#globalModal" data-toggle="modal"><?php echo $getdata[0]['Subjects']['alias'];  ?></a> </br><?php echo  $classtitle; ?>( <?php echo $sectiontitle; ?>)<?php } else { ?>


<a class="globalModals" href="<?php echo SITE_URL;?>admin/EmployeeAttendance/edit/<?php echo $cksub[0]['id'] ?>/<?php echo $emp; ?>" data-target="#globalModal" data-toggle="modal"><?php echo $getdata[0]['Subjects']['alias'];  ?></a>  </br><?php echo  $classtitle; ?>( <?php echo $sectiontitle; ?>)<br><p style="color:green;"><b><?php echo $fsub['fname'].' '.$fsub['middlename'].' '.$fsub['lname']; ?></b></p><?php } ?>

                      

                      <?php  }else{ echo "-"; } ?></span> <?php } ?></td>


                            <td class="text-center" style=" word-break: keep-all;"><?php if (strpos($work['weekday'], "Thursday") !== false) {

                              $getdata= $this->Comman->gettimetableteacher($work['id'],"Thursday",$classectionid); 
                              $clsssection=$this->Comman->find_alls($getdata[0]['class_id']);  
                              $class=$clsssection['class_id']; 
                              $cksub= $this->Comman->checksubstitute($work['id'],"Thursday",$class);
                              $nid=$cksub[0]['new_empid'];
                          $fsub= $this->Comman->findempname($nid); 
                              $section=$clsssection['section_id'];  
                              $classtitle=$clsssection['Classes']['title']; 
                              $sectiontitle=$clsssection['Sections']['title']; ?>

                              <span title="<?php  if(!empty($getdata)){ echo $getdata[0]['Subjects']['name'].'&nbsp;('.$getdata[0]['Employees']['fname'].'&nbsp;'.$getdata[0]['Employees']['middlename'].'&nbsp;'.$getdata[0]['Employees']['lname'].')';  }else{ echo "Assign Lecture"; } ?>" data-toggle="tooltip" >

                              <?php if(!empty($getdata)){ if(empty($cksub )) {  ?><a class="globalModals" href="<?php echo SITE_URL;?>admin/EmployeeAttendance/add/<?php echo $work['id'] ?>/<?php echo $class; ?>/Thursday/<?php echo $emp; ?>/<?php echo $section; ?>" data-target="#globalModal" data-toggle="modal"><?php echo $getdata[0]['Subjects']['alias'];  ?></a><?php } else { ?>


<a class="globalModals" href="<?php echo SITE_URL;?>admin/EmployeeAttendance/edit/<?php echo $cksub[0]['id'] ?>/<?php echo $emp; ?>" data-target="#globalModal" data-toggle="modal"><?php echo $getdata[0]['Subjects']['alias'];  ?></a>  </br><?php echo  $classtitle; ?>( <?php echo $sectiontitle; ?>)<br><p style="color:green;"><b><<?php echo $fsub['fname'].' '.$fsub['middlename'].' '.$fsub['lname']; ?></b></p> <?php } ?>

                     

                      <?php  }else{ echo "-"; } ?> </span><?php } ?> </td>

                                <td class="text-center" style=" word-break: keep-all;">  <?php if (strpos($work['weekday'], "Friday") !== false) {

                                  $getdata= $this->Comman->gettimetableteacher($work['id'],"Friday",$classectionid); $clsssection=$this->Comman->find_alls($getdata[0]['class_id']);  

                                  $class=$clsssection['class_id'];  

                                  $section=$clsssection['section_id'];  
                                  $cksub= $this->Comman->checksubstitute($work['id'],"Friday",$class);
                                  $nid=$cksub[0]['new_empid'];
                          $fsub= $this->Comman->findempname($nid);
                                  $classtitle=$clsssection['Classes']['title'];

                                   $sectiontitle=$clsssection['Sections']['title']; ?>

                                   <span title="<?php   if(!empty($getdata)){ echo $getdata[0]['Subjects']['name'].'&nbsp;('.$getdata[0]['Employees']['fname'].'&nbsp;'.$getdata[0]['Employees']['middlename'].'&nbsp;'.$getdata[0]['Employees']['lname'].')';  }else{ echo "Assign Lecture"; } ?>" data-toggle="tooltip">

                                   <?php if(!empty($getdata)){ if(empty($cksub )) {  ?><a class="globalModals" href="<?php echo SITE_URL;?>admin/EmployeeAttendance/add/<?php echo $work['id'] ?>/<?php echo $class; ?>/Friday/<?php echo $emp; ?>/<?php echo $section; ?>" data-target="#globalModal" data-toggle="modal"><?php echo $getdata[0]['Subjects']['alias'];  ?></a> 
                      </br><?php echo  $classtitle; ?>( <?php echo $sectiontitle; ?>)<?php } else { ?>


<a class="globalModals" href="<?php echo SITE_URL;?>admin/EmployeeAttendance/edit/<?php echo $cksub[0]['id'] ?>/<?php echo $emp; ?>" data-target="#globalModal" data-toggle="modal"><?php echo $getdata[0]['Subjects']['alias'];  ?></a> 
                      </br><?php echo  $classtitle; ?>( <?php echo $sectiontitle; ?>)<br><p style="color:green;"><b><?php echo $fsub['fname'].' '.$fsub['middlename'].' '.$fsub['lname']; ?></b></p><?php } ?>


                      <?php } }else{ echo "-"; } ?> </span> <?php } ?> </td>


                                    <td class="text-center" style=" word-break: keep-all;"> <?php if (strpos($work['weekday'], "Saturday") !== false) {

                                      $getdata= $this->Comman->gettimetableteacher($work['id'],"Saturday",$classectionid); 

                                      $clsssection=$this->Comman->find_alls($getdata[0]['class_id']);  

                                      $class=$clsssection['class_id'];  

                                      $section=$clsssection['section_id']; 
                                      $cksub= $this->Comman->checksubstitute($work['id'],"Saturday",$class);
                                      $nid=$cksub[0]['new_empid'];
                          $fsub= $this->Comman->findempname($nid);
                                       $classtitle=$clsssection['Classes']['title']; 

                                       $sectiontitle=$clsssection['Sections']['title']; ?>

                                       <span title="<?php   if(!empty($getdata)){ echo $getdata[0]['Subjects']['name'].'&nbsp;('.$getdata[0]['Employees']['fname'].'&nbsp;'.$getdata[0]['Employees']['middlename'].'&nbsp;'.$getdata[0]['Employees']['lname'].')';  }else{ echo "Assign Lecture"; } ?>" data-toggle="tooltip" > 


                                      <?php if(!empty($getdata)){ if(empty($cksub )) {  ?><a class="globalModals" href="<?php echo SITE_URL;?>admin/EmployeeAttendance/add/<?php echo $work['id'] ?>/<?php echo $class; ?>/Saturday/<?php echo $emp; ?>/<?php echo $section; ?>" data-target="#globalModal" data-toggle="modal"><?php echo $getdata[0]['Subjects']['alias'];  ?></a>  </br><?php echo  $classtitle; ?>( <?php echo $sectiontitle; ?>)<?php } else { ?>


<a class="globalModals" href="<?php echo SITE_URL;?>admin/EmployeeAttendance/edit/<?php echo $cksub[0]['id'] ?>/<?php echo $emp; ?>" data-target="#globalModal" data-toggle="modal"><?php echo $getdata[0]['Subjects']['alias'];  ?></a>   </br><?php echo  $classtitle; ?>( <?php echo $sectiontitle; ?>)<br><p style="color:green;"><b><?php echo $fsub['fname'].' '.$fsub['middlename'].' '.$fsub['lname']; ?></b></p><?php } ?>

                     

                      <?php  }else{ echo "-"; }  ?></span> </td> </tr>


                                        <?php } if($work['is_break']==1) {   if($work['time_from']) { ?><tr><td class="text-center"><?php echo '<b>'. $work['name'].'</b>';?></td>

                          <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;"  > Break</span></td>
                                                            <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;" >Break</span></td>
                                                             <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;" >Break</span></td>
                                                            <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;" >Break</span></td>
                                                       <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;" >Break</span></td>
                                                              <td class="text-center" style=" word-break: keep-all;"><span title="Break" data-toggle="tooltip" style="color:red;" >Break</span></td>
                                                </tr>   
                                                
                                       
                                            
                              <?php  } } } }   ?>
                          
                              <?php  }else{  ?>
                            <tr><td class="text-center text-bold" colspan="7">No Data Selected</td>
                              </tr><?php } ?>
                          </tbody>
        </table>
        </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
        <script>

    //prepare the dialog

    //respond to click event on anything with 'overlay' class
    $(".globalModals").click(function(event){

 
     
        $('.modal-content').load($(this).attr("href"));  //load content from href of link

        });
    
    
    
    
    
      $(".globalModalss").click(function(event){

 
     
        $('.modal-content').load($(this).attr("href"));  //load content from href of link

        });
    
    
    
    
</script>
          <div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="loader">
                                <div class="es-spinner">
                                    <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      
  