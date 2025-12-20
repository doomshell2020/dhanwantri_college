<div class="table-responsive student_listtb_rspv">
   <table id="example1" class="table table-bordered table-striped">
      <thead>
         <tr>
            <th>#</th>
            <th>Schloar. No.</th>
            <th>Name</th>
            <th>Class</th>
            <th>D.O.B</th>
            <th>Description</th>
            <th>School</th>
            <th>Date</th>
            <!-- <th>Dropout</th> -->
            <th width="70px">Action</th>
         </tr>
      </thead>
      <tbody id="example2">
         <?php $page = $this->request->params['paging']['Students']['page'];
            $limit = $this->request->params['paging']['Students']['perPage'];
            $counter = ($page * $limit) - $limit + 1;
            
            if (isset($students) && !empty($students)) {
                foreach ($students as $work) { //pr($work);
            ?>
         <tr>
            <td><?php echo $counter; ?></td>
            <td>
               <?php echo $work['enroll']; ?>&nbsp;<?php if ($role_id == CBSE_FEE_COORDINATOR || $role_id == INTERNATIONAL_FEE_COORDINATOR) { ?>
               <a title="View Student" href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $work['id']; ?>">
               <i class="fa fa-info-circle"></i>
               </a>
               <a title="Edit Student" href="<?php echo SITE_URL; ?>admin/students/edit/<?php echo $work['id']; ?>"><i class="fa fa-pencil"></i></a><? } ?>
            </td>
            <td>
               <?php echo ucfirst(strtolower($work['sname'])); ?>
            </td>
            <td><?php $class = $this->Comman->findclass($work['class_id']);
               $section = $this->Comman->findsecti($work['section_id']);
               echo $class['title'] . '-' . $section['title']; ?>
            </td>
            <td><?php echo date('d-m-Y', strtotime($work['dob'])); ?></td>
            <td><?php echo $work['description']; ?></td>
            <td><?php echo ucfirst(strtolower($work['school_name'])); ?></td>
            <td><?php echo date('d-m-Y', strtotime($work['created'])); ?></td>
            <td>
               <?php if ($work['status'] == 'N') { ?>
               <?php
                  echo $this->Html->link('Approval', [
                      'action' => 'Approval',
                      $work->id
                  ], ['class' => 'btn btn-success', "onClick" => "javascript: return confirm('Are you sure do you want to Approve Student')"]);
                  } else { ?>
               <span class="fa fa-check"> Approve</span>
               <?php } ?>
            </td>
         </tr>
         <?php $counter++;
            }
            } else { ?>
         <tr>
            <td>NO Data Available</td>
         </tr>
         <?php } ?>
      </tbody>
   </table>
</div>