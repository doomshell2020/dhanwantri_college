 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       Course Fee Structure Manager

     </h1>
     <ol class="breadcrumb">
       <li><a href="<?php echo ADMIN_URL; ?>studentfees/view"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="<?php echo ADMIN_URL; ?>classfee/index">Manage Course Fee Structure</a></li>
     </ol>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <div class="col-xs-12">

         <div class="box">
           <div class="box-header">
             <h3 class="box-title">Course Fee Structure</h3>

             <!-- <a href="<?php echo SITE_URL; ?>admin/classfee/add">
               <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
                 Add </button>
             </a> -->

           </div>
           <!-- /.box-header -->
           <?php echo $this->Flash->render(); ?>
           <div class="box-body">
             <div class="table-responsive">
               <table id="example1" class="table table-bordered table-striped">
                 <thead>
                   <tr>
                     <th>#</th>
                     <th>Course</th>
                     <th>1st Year</th>
                     <th>2nd Year</th>
                     <th>3rd Year</th>
                     <th>4th Year</th>
                     <th>Academic Year</th>
                     <th>Action</th>

                   </tr>
                 </thead>
                 <tbody>
                   <?php $page = $this->request->params['paging']['Classfee']['page'];
                    $limit = $this->request->params['paging']['Classfee']['perPage'];
                    $counter = ($page * $limit) - $limit + 1;
                    $art = array();

                    if (isset($classfee) && !empty($classfee)) {
                      foreach ($classfee as $classfee) { //pr($classfee); 
                    ?>
                       <tr>
                         <td><?php echo $counter; ?></td>

                         <td><?php $srts = $this->Comman->issuedCountstudents($classfee['slab']);
                              // pr($srts); die;
                              foreach ($srts as $rty => $rgh) {
                                $srts = $this->Comman->findclass123($rgh['class_id']);
                                echo $srts['title'] . "<br>";
                              } ?>
                         </td>

                         <td>
                           <?php $srt = $this->Comman->findfeeheadsclassfee($classfee['class_id'], $classfee['academic_year']);
                            foreach ($srt as $ss => $rt) {
                              if ($rt['qu1_fees']) {
                                echo "<b>" . $rt['feeshead']['name'] . "</b> - &nbsp;<span class='text-black'>&#8377; </span>" . $rt['qu1_fees'] . "</br>";
                              }
                            }

                            ?>
                         </td>

                         <td>
                           <?php $srt = $this->Comman->findfeeheadsclassfee($classfee['class_id'], $classfee['academic_year']);
                            foreach ($srt as $ss => $rt) { //pr($rt);
                              if ($rt['qu2_fees']) {
                                echo "<b>" . $rt['feeshead']['name'] . "</b> - &nbsp;<span class='text-black'>&#8377; </span>" . $rt['qu2_fees'] . "</br>";
                              }
                            }

                            ?>
                         </td>

                         <td>
                           <?php $srt = $this->Comman->findfeeheadsclassfee($classfee['class_id'], $classfee['academic_year']);
                            foreach ($srt as $ss => $rt) {
                              if ($rt['qu3_fees']) {
                                echo "<b>" . $rt['feeshead']['name'] . "</b> - &nbsp;<span class='text-black'>&#8377; </span>" . $rt['qu1_fees'] . "</br>";
                              }
                            }

                            ?>
                         </td>

                         <td>
                           <?php $srt = $this->Comman->findfeeheadsclassfee($classfee['class_id'], $classfee['academic_year']);
                            foreach ($srt as $ss => $rt) {
                              if ($rt['qu4_fees']) {
                                echo "<b>" . $rt['feeshead']['name'] . "</b> - &nbsp;<span class='text-black'>&#8377; </span>" . $rt['qu1_fees'] . "</br>";
                              }
                            }

                            ?>
                         </td>

                         <td><b><?php echo $classfee['academic_year']; ?></b></td>

                         <td>
                           <?php
                            // echo $this->Html->link('Update', [
                            //   'action' => 'edit',
                            //   $classfee['id']
                            // ], ['class' => 'btn btn-primary']); 
                            ?>
                           <?php /*
			echo $this->Html->link('View', [
			    'action' => 'view',
			    $service->id
			],['class'=>'btn btn-success']); */ ?>
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
   $(document).ready(function() {
     $('.sort').on('change', function() {
       var sort = $(this).val();
       var id = $(this).attr('data-val');
       $.ajax({
         type: 'POST',
         url: '<?php echo $this->Url->build('/admin/services/sort'); ?>',
         data: {
           'id': id,
           'sort': sort
         },
         success: function(data) {
           $('#sort').val(data);
         },

       });
     });
   });
 </script>
 <!-- /.content-wrapper -->