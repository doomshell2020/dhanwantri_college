<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

 <style>
   /* IE 6 doesn't support max-height
	   * we use height instead, but this forces the menu to always be this tall
	   */
   * html .ui-autocomplete {
     height: 100px;
   }

   .modal {
     width: 852px !important;
   }

   .modal-content,
   .modal-dialog {
     width: 840px !important;
   }
 </style>
 <div class="content-wrapper">

   <section class="content-header">
     <h1>
       <i class="fa fa-th-list"></i>
       Periodical Manager
     </h1>
     <ol class="breadcrumb">
       <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="<?php echo ADMIN_URL; ?>Books/periodicView">Manage Periodicals</a></li>
     </ol>
   </section>
   <section class="content">

     <!-- start -->
     <div class="row">
       <div class="col-xs-12">

         <?php echo $this->Flash->render(); ?>

         <div class="box">

           <div class="box-header">
             <h3 class="box-title">
               <i class="fa fa-search"></i> Search Book
             </h3>
           </div>
           <!-- /.box-header -->

           <div class="box-body">


             <div class="manag-stu">

               <?php echo $this->Form->create(null, array('class' => 'form-horizontal', 'id' => 'TaskAdminCustomerForm')); ?>

               <div class="form-group">

                 <div class="col-sm-3">
                   <label>Vendor</label>
                   <?php
                    echo $this->Form->input('book_vendor_id', array(
                      'class' => 'form-control bn', 'id' => 'v1', 'type' => 'select', 'empty' => 'Select Vendor',
                      'options' => $bookvendors, 'label' => false,
                    ));
                    ?>
                 </div>
                 <div class="col-sm-3">
                   <label>Periodical Search</label>
                   <?php
                    echo $this->Form->input('per_search', array(
                      'class' => 'form-control bn', 'id' => 'perop1', 'type' => 'select', 'empty' => 'Select Vendor',
                      'options' => $peropt1, 'label' => false, 'empty' => '--Select Periodical--'
                    ));
                    ?>
                 </div>


                 <div class="col-sm-3 datepc1">
                   <label>From Date<span>
                       <font color="red"> *</font>
                     </span></label>
                   <?php echo $this->Form->input('d1', array('class' => 'form-control ', 'placeholder' => 'From Date', 'id' => 'datepick1', 'value' => '', 'label' => false)); ?>
                 </div>

                 <div class="col-sm-3 datepc2">
                   <label>To Date<span>
                       <font color="red"> *</font>
                     </span></label>
                   <?php echo $this->Form->input('d2', array('class' => 'form-control ', 'placeholder' => 'To Date', 'id' => 'datepick2', 'label' => false)); ?>
                 </div>
               </div>

               <div class="form-group">
                 <div class="col-sm-6">
                   <button type="submit" class="btn btn-success">Search</button>&nbsp;
                   <button type="reset" class="btn btn-primary" id="cleardates">Reset</button>
                 </div>
               </div>
               <?php echo $this->Form->end(); ?>
             </div>
           </div>
         </div>
       </div>
       <!-- end -->


       <!-- /.row -->
   </section>

   <script>
     $(document).ready(function() {
       $("#v1").change(function(event) {
         var sl = $("#v1").val();
         $.ajax({
           type: 'POST',
           url: '<?php echo ADMIN_URL; ?>Books/selectopt',
           data: {
             'value': sl
           },
           success: function(html) {
             console.log(html);
             var count = 1;
             $.each(html, function(key, value) {
               if (count == 1) {
                 $('#perop1')
                   .find('option')
                   .remove();
               }
               $('<option>').val(key).text(value).appendTo($("#perop1"));
               count++;
             });
           },
         });
       });

     });
   </script>



   <script>
     $(document).ready(function() {

       $("#TaskAdminCustomerForm").bind("submit", function(event) {
         event.preventDefault();
         var a = $('#v1').val();
         var b = $('#perop1').val();
         var c = $('#datepick1').val();
         var d = $('#datepick1').val();
         if (a != '' || b != '' || c != '' || d != '') {
           $.ajax({
             async: false,
             type: "POST",
             url: "<?php echo ADMIN_URL; ?>Books/searchperiodicals",
             data: $("#TaskAdminCustomerForm").serialize(),
             dataType: "html",
             success: function(data) {
               $("#srch-rslt").html(data);
             }
           });
         } else {
           alert('Select atleast one field');
           return false;
         }
         return false;
       });
     });
   </script>


   <script>
     $('#datepick1').datepicker({
       dateFormat: 'mm/dd/yy',
       minDate: '-2y',
       maxDate: '+0',
       onSelect: function(dateStr) {
         var min = $(this).datepicker('getDate') || new Date(); // Selected date or today if none
         var max = new Date();

         //max.setMonth(max.getMonth() + 60); // Add one month
         $('#datepick2').datepicker('option', {
           minDate: min,
           maxDate: max
         });
       },
     }).attr("readonly", "readonly");
     $('#datepick2').datepicker({
       dateFormat: 'mm/dd/yy',
       minDate: '',
       maxDate: '+0',
       autoclose: true,
       onSelect: function(dateStr) {

         var max = $(this).datepicker('getDate') || new Date(); // Selected date or null if none
         $('#datepick1').datepicker('option', {
           maxDate: max
         });
       },
     }).attr("readonly", "readonly");
   </script>
   <!-- /.content -->

   <!-- Main content -->
   <section class="content">

     <div class="row">
       <div class="col-xs-12">

         <div class="box">

           <div>
             <?php echo $this->Flash->render(); ?>
           </div>

           <div class="box-header">
             <h3 class="box-title"><i class="fa fa-search"></i> Periodicals</h3>
             <a class="btn btn-success pull-right" href="<?php echo SITE_URL; ?>admin/books/periodic"><i class="fa fa-plus-square"></i> Add Periodical</a>
             <a class="btn btn-success pull-right" style="margin-right: 10px;" href="<?php echo SITE_URL; ?>admin/books/periodicExcel"><i class="fa fa-file-excel-o"></i> Export Excel</a>
             <!--
        <a id="" style="position: absolute;
top: 122px;
/* right: 0px; */
right: 46px;" class="btn btn-info btn-sm pull-right" target="_blank" href="<?php echo ADMIN_URL; ?>report/user_prospectus"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export PDF</a>
-->
           </div>
           <!-- /.box-header -->

           <div class="box-body">
             <div id="srch-rslt">
               <table id="example1" class="table table-bordered table-striped">
                 <thead>

                   <tr>
                     <th>S.No</th>
                     <th>Periodical Name</th>
                     <th>Periodicity</th>
                     <th>Language</th>
                     <th>Subs. Start</th>
                     <th>Subs. End</th>
                     <th>Price</th>
                     <th>Editor</th>
                     <th>Issue</th>

                     <th>Action</th>
                   </tr>
                 </thead>
                 <tbody>

                   <?php

                    $page = $this->request->params['paging']['perio']['page'];
                    $limit = $this->request->params['paging']['perio']['perPage'];
                    $counter = ($page * $limit) - $limit + 1;

                    if (isset($perio) && !empty($perio)) {
                      foreach ($perio as $work) {
                        $pid = $work['periodic_id'];
                        $perdet = $this->Comman->findperiodicalmaster($pid);
                        $stat = $perdet['sub_status'];
                    ?>
                       <tr <?php $d1 = date('Y-m-d');
                            if ($work['subs_end_date'] < $d1) { ?> style="color:red;" <?php } ?>>
                         <td><?php echo $counter; ?></td>

                         <td><?php if (isset($perdet['name'])) {
                                echo ucfirst($perdet['name']);
                                if ($stat == '1') { ?>
                               <span style="color:red;"><?php echo "(SUBSCRIPTION CLOSED)"; ?></span>
                           <?php }
                              } else {
                                echo 'N/A';
                              } ?>
                         </td>
                         <?php $prty = $this->Comman->findperiodicityname($perdet['periodicity']); ?>
                         <td><?php if (isset($prty['name'])) {
                                echo ucfirst($prty['name']);
                              } else {
                                echo 'N/A';
                              } ?></td>
                         <?php $lasd = $this->Comman->findlang($perdet['lang']); ?>
                         <td><?php if (isset($lasd['language'])) {
                                echo ucfirst($lasd['language']);
                              } else {
                                echo 'N/A';
                              } ?></td>


                         <td><?php if (isset($work['subs_start_date'])) {
                                echo date('d-m-Y', strtotime($work['subs_start_date']));
                              } else {
                                echo 'N/A';
                              } ?></td>

                         <td><?php if (isset($work['subs_end_date'])) {
                                echo date('d-m-Y', strtotime($work['subs_end_date'])); ?> <?php } else {
                                                                                                                                echo 'N/A';
                                                                                                                              } ?></td>

                         <td><?php if (isset($work['per_volume_cost'])) {
                                echo ucfirst($work['per_volume_cost']);
                              } else {
                                echo 'N/A';
                              } ?></td>

                         <td><?php if (isset($perdet['author'])) {
                                echo ucfirst($perdet['author']);
                              } else {
                                echo 'N/A';
                              } ?></td>
                         <?php $pval = $this->Comman->findperiodicalvoiume($work['periodic_id']);  ?>
                         <td><?php if (isset($pval)) { ?><?php echo $pval; ?> <a target="_blank" href="<?php echo SITE_URL; ?>admin/books/periodicVolume/<?php echo $work['periodic_id']; ?> ">View Detail</a><?php } else {echo 'N/A';} ?></td>
                         <td>
                           <?php if ($stat == '0') {
                              $status = 1;
                            } else {
                              $status = 0;
                            }
                            ?>

                           <a target="_blank" href="<?php echo SITE_URL; ?>admin/books/periodicEdit/<?php echo $work['id']; ?>/<?php echo $work['periodic_id']; ?> "><img src="<?php echo SITE_URL; ?>/images/edit.png"></a>
                           <?php if ($stat == '0') { ?> <a target="_blank" href="<?php echo SITE_URL; ?>admin/books/periodicRenew/<?php echo $work['id']; ?>/<?php echo $work['periodic_id']; ?> "><img src="<?php echo SITE_URL; ?>/images/renew.png"></a> <?php } ?>
                           <?php if ($stat == '0') { ?><a href="<?php echo ADMIN_URL; ?>Books/updatesubstatus/<?php echo $work['periodic_id']; ?>/<?php echo $status; ?>"><img src="<?php echo SITE_URL; ?>/images/subscription.png"></a> <?php } else { ?>
                             <a href="<?php echo ADMIN_URL; ?>Books/updatesubstatus/<?php echo $work['periodic_id']; ?>/<?php echo $status; ?>"><img src="<?php echo SITE_URL; ?>/images/subscriptionred.png"></a> <?php } ?>

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


 <!-- /.content-wrapper -->