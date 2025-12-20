 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">

   <section class="content-header">
     <h1>
       <i class="fa fa-plus-square"></i>


       Edit Periodical

     </h1>
     <ol class="breadcrumb">
       <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="<?php echo ADMIN_URL; ?>Books/index">Manage Periodical</a></li>
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
               $('#enqiry_date1').datepicker({
                 dateFormat: 'dd-mm-yy',
                 changeYear: 'true',
                 changeMonth: 'true',
               });

               $('#fghj').datepicker({
                 dateFormat: 'dd-mm-yy',
                 changeYear: 'true',
                 changeMonth: 'true',
               });

               $('#enqiry_date2').datepicker({
                 dateFormat: 'dd-mm-yy'
               }).datepicker("setDate", new Date());
               $('#enqiry_date3').datepicker({
                 dateFormat: 'dd-mm-yy'
               }).datepicker("setDate", new Date());
               $('#dp5').datepicker({
                 dateFormat: 'dd-mm-yy',
                 maxDate: 0
               }).datepicker();
               $('#dp6').datepicker({
                 dateFormat: 'dd-mm-yy'
               }).datepicker();
             });
           </script>

           <script>
             $(document).ready(function() {
               $('#fdatefrom').datepicker({
                 dateFormat: 'yy-mm-dd',
                 onSelect: function(date) {s
                   var selectedDate = new Date(date);
                   var endDate = new Date(selectedDate);
                   endDate.setDate(endDate.getDate());
                   $("#fendfrom").datepicker("option", "minDate", endDate);
                   //$("#fendfrom").val(date);
                 }
               });
               $('#fendfrom').datepicker({
                 dateFormat: 'yy-mm-dd'
               });
             });
           </script>

           <div class="box-body">
             <fieldset>
               <legend style="color:#3c8dbc;font-size: 16px;font-weight:bold;">Periodical Detail</legend>
               <div class="manag-stu">
                 <?php echo $this->Form->create($prty, array('class' => 'form-horizontal', 'autocomplete' => 'on', 'id' => 'TaskAdminCustomerForm')); ?>
                 <div class="form-group">
                   <div class="col-sm-6">
                     <label>Name<span>
                         <font color="red"> *</font>
                       </span></label>
                     <?php echo $this->Form->input('name', array('class' => 'form-control', 'id' => 'tags', 'maxlength' => '200', 'label' => false, 'required')); ?>
                   </div>

                   <div class="col-sm-6">
                     <label>ISBN No./ISSN No.</label>
                     <?php echo $this->Form->input('ISBN_NO', array('class' => 'form-control', 'maxlength' => '25', 'type' => 'text', 'label' => false, 'required')); ?>
                   </div>
                 </div>

                 <div class="form-group">
                   <div class="col-sm-6">
                     <label>Sub Title</label>
                     <?php
                      echo $this->Form->input('subtitle', array('class' => 'form-control', 'type' => 'text', 'maxlength' => '200', 'label' => false));
                      ?>
                   </div>
                   <div class="col-sm-6">
                     <label>Book Vendor<span>
                         <font color="red"> *</font>
                       </span></label>
                     <?php
                      echo $this->Form->input('vendor', array(
                        'class' => 'form-control', 'type' => 'select', 'empty' => 'Select Vendor',
                        'options' => $bookvendors, 'label' => false, 'required'
                      ));
                      ?>
                   </div>
                 </div>

                 <legend style="color:#3c8dbc;font-size: 16px;font-weight:bold;">Publisher Detail</legend>

                 <div class="form-group">
                   <div class="col-sm-4">
                     <label>Publisher</label>
                     <?php echo $this->Form->input('publisher', array('class' => 'form-control', 'id' => 'title', 'maxlength' => '60', 'label' => false)); ?>
                   </div>


                   <div class="col-sm-4">
                     <label>Language<span>
                         <font color="red"> *</font>
                       </span></label>
                     <?php
                      echo $this->Form->input('lang', array('class' => 'form-control', 'id' => 'lang', 'options' => $lahu, 'label' => false, 'required')); ?>
                   </div>

                   <div class="col-sm-4">
                     <label>Author</label>
                     <?php
                      echo $this->Form->input('author', array('class' => 'form-control', 'id' => 'ghj', 'label' => false)); ?>
                   </div>
                 </div>
               </div>


               <div class="form-group">
                 <div class="col-sm-6" style="margin-right: 0px;margin-left: -12px;">

                   <legend style="color:#3c8dbc;font-size: 16px;font-weight:bold;">Bill Info</legend>
                   <div class="col-sm-6" style=" margin-right: 0px;margin-left: -12px;"><?php 
  ?>
                     <label>Bill No.<span>
                         <font color="red"> *</font>
                       </span></label>
                     <?php echo $this->Form->input('bill_no', array('class' => 'form-control', 'maxlength' => '6', 'id' => 'title', 'label' => false, 'value' => $pdty['bill_no'], 'required')); ?>
                   </div>
                   <div class="col-sm-6" style="margin-right: 0px;margin-left: 11px;">
                     <label>Bill Date.</label>
                     <div class="input-group">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <?php echo $this->Form->input('bill_date', array('class' => 'form-control ', 'readonly' => 'readonly', 'value' => date('d-m-Y', strtotime($pdty['bill_date'])), 'id' => 'dp5', 'label' => false)); ?>
                     </div>
                   </div>
                   <div class="col-sm-6" style="margin-right: 0px;margin-left: -12px;">
                     <label>Bill Amount.<span>
                         <font color="red"> *</font>
                       </span></label>
                     <?php echo $this->Form->input('bill_amount', array('class' => 'form-control', 'id' => 'title', 'value' => $pdty['bill_amount'], 'maxlength' => '5', 'label' => false, 'required')); ?>
                   </div>
                   <div class="col-sm-6" style="margin-right: 0px;margin-left: 11px;">
                     <label>Paid On</label>
                     <div class="input-group">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <?php echo $this->Form->input('bill_pay_date', array('class' => 'form-control', 'readonly' => 'readonly', 'value' => date('d-m-Y', strtotime($pdty['bill_pay_date'])), 'id' => 'dp6', 'label' => false)); ?>
                     </div>
                   </div>
                 </div>
               </div>


               <div class="form-group" id="subscrip">
                 <div class="col-sm-6">

                   <legend style="color:#3c8dbc;font-size: 16px;font-weight:bold;">Subscription Info</legend>

                   <div class="col-sm-6">
                     <label>Sub No.<span>
                         <font color="red"> *</font>
                       </span></label>
                     <?php echo $this->Form->input('subs_no', array('class' => 'form-control', 'maxlength' => '6', 'id' => 'title', 'value' => $pdty['subs_no'], 'label' => false, 'required')); ?>
                   </div>
                   <div class="col-sm-6">
                     <label>Subscription Amount<span>
                         <font color="red"> *</font>
                       </span></label>
                     <?php echo $this->Form->input('subs_amount', array('class' => 'form-control', 'id' => 'title', 'value' => $pdty['subs_amount'], 'maxlength' => '50', 'label' => false, 'required')); ?>
                   </div>
                   <div class="col-sm-6">
                     <label>Sub Start Date.</label>
                     <div class="input-group">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <?php echo $this->Form->input('subs_start_date', array('class' => 'form-control', 'readonly' => 'readonly', 'value' => date('d-m-Y', strtotime($pdty['subs_start_date'])), 'id' => 'enqiry_date1', 'label' => false)); ?>
                     </div>
                   </div>

                   <div class="col-sm-6">
                     <label>Sub End Date.</label>
                     <div class="input-group">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <?php echo $this->Form->input('subs_end_date', array('class' => 'form-control', 'readonly' => 'readonly', 'value' => date('d-m-Y', strtotime($pdty['subs_end_date'])), 'id' => 'fghj', 'label' => false)); ?>
                     </div>
                   </div>
                   <!--  <div class="col-sm-6">
            <label>Order No.</label>
            <?php echo $this->Form->input('ordrno', array('class' => 'form-control', 'maxlength' => '20', 'id' => 'title', 'label' => false)); ?>
          </div> 
          <div class="col-sm-6">
			      <div class="input-group">
              <div class="input-group-addon">
    <i class="fa fa-calendar"></i>
    </div>
            <label>Order Date</label>
            <?php echo $this->Form->input('ordrdt', array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'enqiry_date2', 'label' => false)); ?>
          </div>     </div>  
              
          <?php echo $this->Form->input('bid', array('class' => 'form-control', 'value' => $bnid, 'type' => 'hidden', 'label' => false)); ?>   -->
                   <!-- <div class="col-sm-6">
            <label>Per Annum From.</label>
            <div class="input-group">
              <div class="input-group-addon">
    <i class="fa fa-calendar"></i>
    </div>
            <?php echo $this->Form->input('panumdtf', array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'fdatefrom', 'label' => false)); ?>
          </div>   </div> 
          <div class="col-sm-6" >
            <label>To</label>
             <div class="input-group">
    <div class="input-group-addon">
    <i class="fa fa-calendar"></i>
    </div>
            <?php echo $this->Form->input('panumdtt', array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'fendfrom', 'label' => false)); ?>
            </div> 
          </div> 
           <div class="col-sm-6">
            <label>Per Volume (Issues)</label>
            <?php echo $this->Form->input('pvolissue', array('class' => 'form-control', 'maxlength' => '5', 'id' => 'title', 'label' => false)); ?> 
          </div>  -->
                 </div>
               </div>




               <div class="form-group">
                 <div class="col-sm-6" style="margin-right: 0px; margin-left: -12px;">
                   <label>Price<span>
                       <font color="red"> *</font>
                     </span></label>
                   <?php echo $this->Form->input('per_volume_cost', array('class' => 'form-control', 'required' => 'required', 'value' => $pdty['per_volume_cost'], 'maxlength' => '5', 'id' => 'title', 'min' => 1, 'label' => false)); ?>
                 </div>

                 <div class="col-sm-6" style="margin-right: 0px;margin-left: 11px;">
                   <label>Periodicity<span>
                       <font color="red"> *</font>
                     </span></label>
                   <?php echo $this->Form->input('periodicity', array('class' => 'form-control', 'options' => $pere, 'label' => false, 'required')); ?>
                 </div>
               </div>
               <div class="form-group">
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
                      echo '<button type="submit" class="btn btn-success">Create</button> ';
                      echo '<button type="reset" class="btn btn-primary pull-right">Reset</button>';
                    }
                    ?>

                 </div>

               </div>

               <?php echo $this->Form->end(); ?>

           </div>
           </fieldset>
         </div>

       </div>

     </div>

 </div>

 <!-- /.row -->
 </section>
 <!-- /.content -->
 </div>


 <!-- /.content-wrapper -->

 <script>
   $(document).ready(function() {
     $("#isbn-no").on("blur", function(event) {
       var isbn = $('#isbn-no').val();
       if (isbn != '') {
         $.ajax({
           async: false,
           type: 'POST',
           url: '<?php echo ADMIN_URL; ?>Books/check_isbn',
           data: {
             'isbnno': isbn
           },
           success: function(data) {
             if (data == "OK") {
               $('#isbn-status').hide();
               return true;
             } else {
               $('#isbn-status').text(data).show();
               //   event.preventDefault();
               $('#isbn-no').val('');
               return false;
             }
           },

         });
       }
     });
   });

   $(document).ready(function() {
     $('#cup-board-id').on('change', function() {
       var id = $('#cup-board-id').val();
       //alert(id);
       $.ajax({
         type: 'POST',
         url: '<?php echo ADMIN_URL; ?>Books/find_shelf',
         data: {
           'id': id
         },
         success: function(data) {
           //alert(data);
           $('#cup-board-shelf-id').empty();
           $('#cup-board-shelf-id').html(data);
         },
       });
     });
   });

   //-------------------
 </script>