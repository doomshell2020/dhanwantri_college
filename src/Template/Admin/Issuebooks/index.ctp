 <!-- Content Wrapper. Contains page content -->

 <head>

   <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->

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

 </head>
 <div class="content-wrapper">

   <section class="content-header">
     <h1>
       Issue Book Manager
     </h1>
     <ol class="breadcrumb">
       <li><a href="<?php echo ADMIN_URL; ?>Issuebooks/index"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="<?php echo ADMIN_URL; ?>Issuebooks/index">Manage Issue Book</a></li>
     </ol>
   </section>

   <!-- Main content -->
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
                   <label>ISBN No.</label>
                   <?php echo $this->Form->input('isbn_no', array('class' => 'form-control f', 'label' => false)); ?>
                 </div>

                 <div class="col-sm-3">
                   <label>Book Name</label>
                   <?php echo $this->Form->input('b_name', array('class' => 'form-control f', 'id' => 'tags', 'label' => false)); ?>
                 </div>

                 <div class="col-sm-3">
                   <label>Publisher</label>
                   <?php echo $this->Form->input('publisher', array('class' => 'form-control f', 'label' => false)); ?>
                 </div>

                 <div class="col-sm-3">
                   <label>Author</label>
                   <?php echo $this->Form->input('author', array('class' => 'form-control f', 'label' => false)); ?>
                 </div>

               </div>

               <script>
                 $(document).ready(function() {
                   $('#tags').on('keyup', function() {
                     var b_name = $('#tags').val();
                     $.ajax({
                       type: 'POST',
                       url: '<?php echo ADMIN_URL; ?>Issuebooks/autobookfinder',
                       data: {
                         'b_name': b_name
                       },

                       dataType: "json",
                       success: function(data) {
                         $("#tags").autocomplete({
                           source: data,

                           change: function(event, ui) {
                             val = $(this).val();
                             exists = $.inArray(val, data);
                             if (exists < 0) {
                               $(this).val("");
                               return false;
                             }
                           }
                         });
                       },
                     });
                   });
                 });
               </script>


               <div class="form-group">
                 <div class="col-sm-3">
                   <label>Book Category</label>
                   <?php
                    echo $this->Form->input(
                      'sbj',
                      array(
                        'class' => 'form-control f', 'type' => 'select', 'empty' => 'Select Book Category',
                        'options' => $b_category, 'label' => false
                      )
                    );
                    ?>
                 </div>

                 <div class="col-sm-3">
                   <label>Acc. No.</label>
                   <?php echo $this->Form->input('asn_no', array('class' => 'form-control f', 'label' => false)); ?>
                 </div>

                 <div class="col-sm-3">
                   <label>Book Type</label>
                   <?php $df = array('1' => 'Periodical');
                    echo $this->Form->input(
                      'type',
                      array(
                        'class' => 'form-control f', 'type' => 'select', 'empty' => 'Select Book Type',
                        'options' => $df, 'label' => false
                      )
                    );
                    ?>
                 </div>

                 <div class="col-sm-3">
                   <label>Book Subtitle</label>
                   <?php echo $this->Form->input('sub_title', array('class' => 'form-control f', 'label' => false)); ?>
                 </div>
               </div>

               <div class="form-group">
                 <div class="col-sm-12">
                   <button type="submit" class="btn btn-success">Search</button>&nbsp;
                   <button type="reset" class="btn btn-primary">Reset</button>
                 </div>
               </div>

               <?php echo $this->Form->end(); ?>

             </div>

           </div>

         </div>
       </div>
     </div>
     <!-- end -->

     <div class="row">
       <div class="col-xs-12">

         <div class="box" id="srch-rslt">

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



 <script>
   //--------------------------------------------------------
   $('#globalModal').on('hidden.bs.modal', function() {
     $(this).find('form')[0].reset();
     $("#asn-no").html('<option value="">Select Acc. No.</option>');
   });
 </script>


 <!-- custom search script: start -->
 <script>
   $(document).ready(function() {

     $("#TaskAdminCustomerForm").bind("submit", function(event) {
       event.preventDefault();
       var hasInput = false;
       $('.f').each(function() {
         if ($(this).val() !== "") {
           hasInput = true;
         }
       });
       if (!hasInput) {
         alert("Fill at least one option");
         return false;
       } else {
         $.ajax({
           async: false,
           type: "POST",
           url: "<?php echo ADMIN_URL; ?>Issuebooks/searchBook",
           data: $("#TaskAdminCustomerForm").serialize(),
           dataType: "html",
           success: function(data) {
             $("#srch-rslt").html(data);
           }
         });
       }
       return false;
     });
   });
 </script>

 <!-- custom search script: end -->