
<?php echo "search.ctp"; die; ?>
<table class="table table-bordered table-striped">
   <thead>
      <tr>
         <th>S.No.</th>
         <th>Branch Name</th>
         <th>Date</th>
         <th>Given FeedBack</th>
         <th>Class</th>
         <th>Section</th>
         <th>FeedBack Category</th>
         <th>Feedback</th>
         <th>Remarks</th>
         <th>Contact No.</th>
         <th>Status</th>
      </tr>
   </thead>
   <tbody>
      <?php
      $page = $this->request->params['paging'][$this->request->params['controller']]['page'];
      $limit = $this->request->params['paging'][$this->request->params['controller']]['perPage'];
      $counter = ($page * $limit) - $limit + 1;

      $feedback_datas = $this->Comman->searchfeedbackdata($branch_name, $status);

      foreach ($feedback_datas as $intusr) { 
         $branch_names = explode("_", $branch_name);
         $created = date('d-m-Y', strtotime($intusr['created']));
         $curent_date = date('d-m-Y');
         $currenttime = date('d-m-Y', strtotime($curent_date . ' - 3 days'));
         if ($created <= $currenttime) {
      ?>

            <tr>
               <td><?php echo $counter; ?></td>
               <td><?php echo Ucfirst($branch_names[1]); ?></td>
               <td><?php echo date('d-m-Y', strtotime($intusr['created'])); ?></td>
               <td><?php echo Ucfirst($intusr['student_name']); ?></td>
               <td><?php echo Ucfirst($intusr['class']); ?></td>
               <td><?php echo Ucfirst($intusr['section']); ?></td>
               <td><?php echo Ucfirst($intusr['name']); ?></td>
               <td><?php echo $intusr['feedback']; ?></td>
               <td><?php echo $intusr['remarks']; ?></td>
               <td><?php echo $intusr['phone']; ?></td>
               <td><?php echo $intusr['status'] == 'N' ? 'Open' : 'Close'; ?></td>
            </tr>
      <?php $counter++;
         }
      } ?>

   </tbody>
</table>