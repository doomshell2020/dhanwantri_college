<table class="table table-bordered table-striped">
   <thead>
      <tr>
         <th>#</th>
         <th>S.No.</th>
         <th>Pupil Name</th>
         <th>Father Name</th>
         <th>Mobile</th>
         <th>Academic Year</th>
         <th>Last Studied Course</th>
         <th>Course/Year</th>
         <!-- <th>Year/Section</th> -->
         <!-- <th>Genrate T.C</th> -->
         <th>
            <center>Action</center>
         </th>
      </tr>
   </thead>
   <tbody>
      <?php
      // pr($this->request->params);die;
      $page = $this->request->params['paging']['DropOutStudent']['page'];
      $limit = $this->request->params['paging']['DropOutStudent']['perPage'];
      $counter = ($page * $limit) - $limit + 1;
      // pr(count($students));exit;

      if (isset($students) && !empty($students)) {
         foreach ($students as $work) {
      ?>
            <tr>
               <td><?php echo $counter; ?></td>
               <td><?php echo $work['enroll']; ?></td>
               <?php $findstu = $this->Comman->findridacademicre($work['s_id'], $work['acedmicyear']);
               $tc_alreay = $this->Comman->checktc($work['s_id']);
               $detained['id'] = '';
               // if ($findstu['id'] == '') {
               //    $detained = $this->Comman->gethistoryyearstudentinfo45($work['s_id'], $work['acedmicyear']);
               //    $acd1 = $this->Comman->findfeesmonthstudentdrop($work['s_id'], $detained['acedmicyear']);
               //    $acd2 = $this->Comman->findfeesmonthstudentdrop2($work['s_id'], $detained['acedmicyear']);
               //    $acd3 = $this->Comman->findfeesmonthstudentdrop3($work['s_id'], $detained['acedmicyear']);
               //    $acd4 = $this->Comman->findfeesmonthstudentdrop4($work['s_id'], $detained['acedmicyear']);
               // } else {
               //    $acd1 = $this->Comman->findfeesmonthstudentdrop($work['s_id'], $work['acedmicyear']);
               //    $acd2 = $this->Comman->findfeesmonthstudentdrop2($work['s_id'], $work['acedmicyear']);
               //    $acd3 = $this->Comman->findfeesmonthstudentdrop3($work['s_id'], $work['acedmicyear']);
               //    $acd4 = $this->Comman->findfeesmonthstudentdrop4($work['s_id'], $work['acedmicyear']);
               // } 
               ?>
               <td><a <?php if ($detained['id'] && $work['school_lastresult'] != "Pass") { ?> style="color:red;"
                     title="View Detained Student" <?php } else { ?> title="View Drop Out Student" <? } ?>
                     href="<?php echo SITE_URL; ?>admin/students/dropview/<?php echo $work['id']; ?>">
                     <?php
                     $name = $work['fname'] . ' ';

                     if (!empty($work['middlename']))
                        $name .= $work['middlename'] . ' ';

                     echo $name .= $work['lname'];
                     ?></a>
                  <!-- <a title="Edit Drop OutStudent" href="<?php echo SITE_URL; ?>admin/students/editdropout/<?php echo $work['id']; ?>"> <img src="<?php echo SITE_URL; ?>images/edit.png" style="width: 18px;"></a>
            <a title="Tution Fees Acknowledgement <?php echo $work['acedmicyear']; ?>" target="_blank" href="<?php echo SITE_URL; ?>admin/report/drop_feeacknowledgement/<?php echo
                                                                                                                                                                           $work['id']; ?>/<?php echo $work['updateacedemic']; ?>"> <img src="<? echo SITE_URL; ?>images/fee_acnow.png"></a>-->
                  <?php if ($work['remarks_lwt']) { ?>
                     <i class="fa fa-pause-circle" title="<?php echo $work['remarks_lwt']; ?>" style="font-size:21px;color:red;">
                     </i>
                  <?php } ?>
               </td>
               <td><?php echo $work['fathername']; ?></td>
               <td><?php echo $work['mobile']; ?></td>
               <td><?php //echo $work['updateacedemic']; 
                     echo $work['acedmicyear'];
                     ?></td>
               <!-- <td><?php $class = $this->Comman->findclass($work['laststudclass']);
                        echo $class['title']; ?></td>
         <td><?php echo $work['classtitle'] . '/' . $work['sectiontitle']; ?></td> -->
               <td><?php $class = $this->Comman->findclass($work['laststudclass']);
                     echo $class['title']; ?>
               </td>
               <td><?php echo $work['class']['title'] . '/' . $work['section']['title']; ?></td>
               <!-- <td><?php echo $work['sectiontitle']; ?></td> -->
               <!-- <td>
            <? if ($work['status_tc'] == "N") { ?>
               <a href="<?php echo SITE_URL; ?>admin/students/statusdrop/<?php echo $work['id']; ?>/Y" title="Assign for T.C">
                  <i class="fa fa-clock-o" aria-hidden="true" style="font-size: 22px;color:red;"></i></a>&nbsp;<b>L.W.T.C</b>
            <? } else { ?>
               <i class="fa fa-check-circle" aria-hidden="true" style="font-size: 22px;color:#3c8dbc;"></i>&nbsp;<b>W.T.C</b>
            <? } ?>
         </td> -->
               <td>
                  <center>
                     <? if ($this->request->session()->read('Auth.User.role_id') != LEAD_COORDINATOR && $tc_alreay == 1) { ?>
                        <a href="<?php echo SITE_URL; ?>admin/students/restore/<?php echo $work['id']; ?>"
                           title="Restore Student" style="color: maroon;"
                           onclick="return confirm('Are you sure you want to restore this student?');">
                           <img src="https://use.fontawesome.com/releases/v5.0.13/svgs/solid/undo.svg" width="15" height="15">
                        </a>
                     <? } ?>
                  </center>
               </td>
            </tr>
         <?php $counter++;
         }
      } else { ?>
         <tr>
            <td style="text-align:center;" colspan="9">NO Data Available</td>
         </tr>
      <?php } ?>
      <div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true"
         style="display: none;">
         <div class="modal-dialog" style="overflow-y: scroll;
      height: 90vh;">
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
      <script>
         $(document).ready(function() {

            $(".global").click(function(event) {

               //load content from href of link
               $('.modal-content').html('<div class="modal-body"><div class="loader"><div class="es-spinner"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div> </div></div>');
               $('.modal-content-drop-out').html('<div class="modal-body"><div class="loader"><div class="es-spinner"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div> </div></div>');
               $('.modal-content').load($(this).attr("href"));
            });

         });
      </script>
   </tbody>
</table>
<?php echo $this->element('admin/pagination'); ?>