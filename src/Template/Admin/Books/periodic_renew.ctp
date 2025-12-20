 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">

   <section class="content-header">
     <h1>
       <i class="fa fa-plus-square"></i>
       Renew Periodical Subscription
     </h1>
     <ol class="breadcrumb">
       <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="<?php echo ADMIN_URL; ?>Books/periodicView">Manage Periodical</a></li>
       <li class="active">Create Periodical</li>
     </ol>
   </section>
   <style>
     .ui-autocomplete {
       max-height: 100px;
       overflow-y: auto;
       /* prevent horizontal scrollbar */
       overflow-x: hidden;
     }

     /* IE 6 doesn't support max-height
     * we use height instead, but this forces the menu to always be this tall
     */
     * html .ui-autocomplete {
       height: 100px;
     }
   </style>
   <!-- Main content -->
   <section class="content">

     <!-- <a class="btn btn-success pull-right" target="_blank" style="margin-right: 10px;" href="<?php echo SITE_URL; ?>admin/books/addcsv"><i class="fa fa-plus"></i> Add Book CSV</a>-->
     <div class="row">
       <div class="col-xs-12">

         <div>
           <?php echo $this->Flash->render(); ?>
         </div>

         <div class="box">

           <!-- /.box-header -->
           <script>
             $(function() {
               $('#enqiry_date2').datepicker({
                 dateFormat: 'dd-mm-yy'
               }).datepicker("setDate", new Date());
               $('#enqiry_date3').datepicker({
                 dateFormat: 'dd-mm-yy'
               }).datepicker("setDate", new Date());
             });
           </script>

           <script>
             $(document).ready(function() {
               $('#enqiry_date1').datepicker({
                 dateFormat: 'yy-mm-dd',
                 changeYear: 'true',
                 changeMonth: 'true',

                 onSelect: function(date) {

                   var selectedDate = new Date(date);
                   var endDate = new Date(selectedDate);
                   endDate.setDate(endDate.getDate());

                   $("#fghj").datepicker("option", "minDate", endDate);

                 }

               });


               $('#fghj').datepicker({
                 dateFormat: 'yy-mm-dd',
                 changeYear: 'true',
                 changeMonth: 'true',
               });

               $('#dp5').datepicker({
                 dateFormat: 'yy-mm-dd',
                 onSelect: function(date) {

                   var selectedDate = new Date(date);
                   var endDate = new Date(selectedDate);
                   endDate.setDate(endDate.getDate());

                   $("#dp6").datepicker("option", "minDate", endDate);
                   //$("#fendfrom").val(date);
                 }
               });
               $('#dp6').datepicker({
                 dateFormat: 'yy-mm-dd'
               });
             });
           </script>

           <div class="box-header">
             <fieldset>

               <?php echo $this->Form->create($book, array('class' => 'form-horizontal', 'autocomplete' => 'on', 'id' => 'TaskAdminCustomerForm')); ?>


               <div class="form-group">
                 <div class="col-sm-6" style="margin-right: 0px;margin-left: -12px;">
                   <legend style="color:#3c8dbc;font-size: 16px;font-weight:bold;">Bill Info</legend>
                   <div class="col-sm-6" style="margin-right: 0px;margin-left: -12px;">
                     <label>Bill No.<span>
                         <font color="red"> *</font>
                       </span></label>
                     <?php echo $this->Form->input('bill_no', array('class' => 'form-control', 'maxlength' => '6', 'id' => 'title', 'label' => false, 'required')); ?>
                   </div>
                   <div class="col-sm-6" style=" margin-right: 0px; margin-left: 11px;">
                     <label>Bill Date.</label>
                     <div class="input-group">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <?php echo $this->Form->input('bill_date', array('class' => 'form-control ', 'readonly' => 'readonly', 'id' => 'dp5', 'label' => false)); ?>
                     </div>
                   </div>
                   <div class="col-sm-6" style="margin-right: 0px; margin-left: -12px;">
                     <label>Bill Amount.<span>
                         <font color="red"> *</font>
                       </span></label>
                     <?php echo $this->Form->input('bill_amount', array('class' => 'form-control', 'id' => 'title', 'label' => false, 'required')); ?>
                   </div>
                   <div class="col-sm-6" style="margin-right: 0px;margin-left: 11px;">
                     <label>Paid On</label>
                     <div class="input-group">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <?php echo $this->Form->input('bill_pay_date', array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'dp6', 'label' => false)); ?>
                     </div>
                   </div>
                 </div>

                 <div class="col-sm-6">
                   <legend style="color:#3c8dbc;font-size: 16px;font-weight:bold;">Subscription Info</legend>
                   <div class="col-sm-6">
                     <label>Sub No.<span>
                         <font color="red"> *</font>
                       </span></label>
                     <?php echo $this->Form->input('subs_no', array('class' => 'form-control', 'maxlength' => '6', 'id' => 'title', 'label' => false, 'required')); ?>
                   </div>
                   <div class="col-sm-6">
                     <label>Subscription Amount<span>
                         <font color="red"> *</font>
                       </span></label>
                     <?php echo $this->Form->input('subs_amount', array('class' => 'form-control', 'id' => 'title', 'maxlength' => '50', 'label' => false, 'required')); ?>
                   </div>
                   <div class="col-sm-6">
                     <label>Sub Start Date.</label>
                     <div class="input-group">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <?php echo $this->Form->input('subs_start_date', array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'enqiry_date1', 'label' => false)); ?>
                     </div>
                   </div>

                   <div class="col-sm-6">
                     <label>Sub End Date.</label>
                     <div class="input-group">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <?php echo $this->Form->input('subs_end_date', array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'fghj', 'label' => false)); ?>
                     </div>
                   </div>

                 </div>
               </div>


               <div class="form-group">
                 <div class="col-sm-6" style=" margin-right: 0px; margin-left: -12px;">
                   <label>Price<span>
                       <font color="red"> *</font>
                     </span></label>
                   <?php echo $this->Form->input('per_volume_cost', array('class' => 'form-control', 'required' => 'required', 'maxlength' => '5', 'id' => 'title', 'min' => 1, 'label' => false)); ?>
                 </div>
               </div>

               <br>
               <div class="form-group">
                 <div class="col-sm-12">
                   <br>
                   <?php
                    if (isset($book[id]) && !empty($book[id])) {
                      echo '<button type="submit" name="button" value="update" class="btn btn-success">Update</button> ';

                      echo $this->Html->link(
                        'Cancel',
                        ['action' => 'index'],
                        ['class' => 'btn btn-primary pull-right']
                      );
                    } else {
                      echo '<button type="submit" class="btn btn-success">Renew Now</button> ';
                      echo '<button type="reset" class="btn btn-primary pull-right">Reset</button>';
                    }
                    ?>
                 </div>
               </div>
               <?php echo $this->Form->end(); ?>
           </div>
           </fieldset>

           <div class="box-body">
             <div class="box-header">
               <h3 class="box-title"><b>HISTORY OF SUBSCRIPTION</b>


             </div>
             <table id="example1" class="table table-bordered table-striped">
               <thead>
                 <tr>
                   <th>#</th>
                   <th>Subscription No.</th>
                   <th>Subs. Start</th>
                   <th>Subs. End</th>
                   <th>Subscription Amount</th>
                   <th>Price</th>
                   <th>Status</th>
                 </tr>
               </thead>
               <tbody>

                 <?php

                  $page = $this->request->params['paging']['pwer']['page'];
                  $limit = $this->request->params['paging']['pwer']['perPage'];
                  $counter = ($page * $limit) - $limit + 1;

                  if (isset($pwer) && !empty($pwer)) {
                    foreach ($pwer as $work) {
                  ?>
                     <tr>
                       <td><?php echo $counter; ?></td>

                       <td><?php if (isset($work['subs_no'])) {
                              echo ucfirst($work['subs_no']);
                            } else {
                              echo 'N/A';
                            } ?></td>

                       <td><?php if (isset($work['subs_start_date'])) {
                              echo date('d-m-Y', strtotime($work['subs_start_date']));
                            } else {
                              echo 'N/A';
                            } ?></td>

                       <td><?php if (isset($work['subs_end_date'])) {
                              echo date('d-m-Y', strtotime($work['subs_end_date']));
                            } else {
                              echo 'N/A';
                            } ?></td>

                       <td><?php if (isset($work['subs_amount'])) {
                              echo ucfirst($work['subs_amount']);
                            } else {
                              echo 'N/A';
                            } ?></td>

                       <td><?php if (isset($work['per_volume_cost'])) {
                              echo ucfirst($work['per_volume_cost']);
                            } else {
                              echo 'N/A';
                            } ?></td>
                       <?php $d1 = strtotime(date('Y-m-d'));



                        $sdate = strtotime(date('Y-m-d', strtotime($work['subs_end_date'])));

                        if ($sdate >= $d1) { ?>
                         <td style="color:green;"><?php
                          if (isset($work['id'])) {echo "Activated";} else {echo 'N/A';} ?></td>
                       <?php } else { ?>
                         <td style="color:red;"><?php 
                         if (isset($work['id'])) {echo "Expired";} else {echo 'N/A';} ?></td>
                       <?php } ?>
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
       </div>
     </div>
 </div>

 <!-- /.row -->
 </section>
 <!-- /.content -->
 </div>


 <!-- /.content-wrapper -->