 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">

   <section class="content-header">
     <h1>
       <i class="fa fa-plus-square"> </i>

       <?php if (!isset($book['id'])) { ?>
         Add Book

       <? } else { ?>
         Edit Book
       <? } ?>
     </h1>
     <ol class="breadcrumb">
       <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="<?php echo ADMIN_URL; ?>Books/index">Manage Book</a></li>
       <li class="active">Create Book </li>
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
     <a class="btn btn-success pull-right" target="_blank" style="margin-right: 10px;" href="<?php echo SITE_URL; ?>admin/CupBoardShelves/index"><i class="fa fa-plus"></i> Shelf Manager</a>
     <a class="btn btn-success pull-right" target="_blank" style="margin-right: 10px;" href="<?php echo SITE_URL; ?>admin/CupBoards/index"><i class="fa fa-plus"></i> Cup Board Manager</a>


     <a class="btn btn-success pull-right" target="_blank" style="margin-right: 10px;" href="<?php echo SITE_URL; ?>admin/BookVendors/index"><i class="fa fa-plus"></i> Vendor Manager</a>
     <a class="btn btn-success pull-right" target="_blank" style="margin-right: 10px;" href="<?php echo SITE_URL; ?>admin/BookCategories/index"><i class="fa fa-plus"></i> Books Category</a>
     <a class="btn btn-success pull-right" target="_blank" style="margin-right: 10px;" href="<?php echo SITE_URL; ?>admin/Language/index"><i class="fa fa-plus"></i> Language</a>
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
                     dateFormat: 'dd-mm-yy'
                   });
                   $('#ghja').datepicker({
                     dateFormat: 'dd-mm-yy'
                   });
                   $('#enqiry_date2').datepicker({
                     dateFormat: 'dd-mm-yy'
                   }).datepicker("setDate", new Date());
                  });
           </script>

           <?php if (!isset($book['id'])) { ?>
             <script>
               $(function() {
                 $('#enqiry_date3').datepicker({
                   dateFormat: 'dd-mm-yy'
                 }).datepicker("setDate", new Date());
                 $('#dp5').datepicker({
                   dateFormat: 'dd-mm-yy',
                   maxDate: 0
                 }).datepicker("setDate", new Date());
                 $('#dp6').datepicker({
                   dateFormat: 'dd-mm-yy'
                 }).datepicker("setDate", new Date());
               });
             </script>

           <?php } else { ?>
             <script>
               $(function() {
                 $('#enqiry_date3').datepicker({
                   dateFormat: 'dd-mm-yy'
                 }).datepicker();
                 $('#dp5').datepicker({
                   dateFormat: 'dd-mm-yy',
                   maxDate: 0
                 }).datepicker();
                 $('#dp6').datepicker({
                   dateFormat: 'dd-mm-yy'
                 }).datepicker();
               });
             </script>

           <?php } ?>
           <script>
             $(document).ready(function() {
               $('#fdatefrom').datepicker({
                 dateFormat: 'yy-mm-dd',
                 onSelect: function(date) {
                   var selectedDate = new Date(date);
                   var endDate = new Date(selectedDate);
                   endDate.setDate(endDate.getDate());
                   $("#fendfrom").datepicker("option", "minDate", endDate);
                 }
               });

               $('#fendfrom').datepicker({
                 dateFormat: 'yy-mm-dd'
               });
             });
           </script>

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
                           return false;
                         }
                       }

                     });
                   },

                 });

               });
             });
           </script>

           <div class="box-body">
             <fieldset>
               <legend style="color:#3c8dbc;font-size: 16px;font-weight:bold;">Book Detail</legend>
               <div class="manag-stu">
                 <?php if (!isset($book['id'])) { ?>
                   <?php echo $this->Form->create($book, array('class' => 'form-horizontal', 'autocomplete' => 'on', 'id' => 'TaskAdminCustomerForm')); ?>
                 <? } else { ?>
                   <?php echo $this->Form->create($book, array('class' => 'form-horizontal', 'autocomplete' => 'on', 'id' => 'TaskAdminCustomerForm')); ?>
                 <? } ?>

                 <div class="form-group">

                   <?php if (isset($book['id'])) {  ?>
                     <script type="text/javascript">
                       $(document).ready(function() {
                         var vg = '<?php echo $book['book_category_id']; ?>';
                         var ng = '<?php echo $book['periodic_category_id']; ?>';

                         if (vg != '0' && ng == '0') {
                           $('#fgy').show();
                           $('#yui').hide();
                           $('#p1').val('');
                           $('#g1').val('');
                         } else {
                           $('#fgy').hide();
                           $('#yui').show();
                           $('#b1').val('');
                           $('#tags').val('');
                         }
                       });
                     </script>
                   <?php } ?>

                   <script type="text/javascript">
                     $(document).ready(function() {
                       var typ = $('#type').val();
                       if (typ == '1') {
                         $('#fgy').hide();
                         $('#yui').show();
                         $('#b1').val('');
                         $('#tags').val('');
                       } else {
                         $('#fgy').show();
                         $('#yui').hide();
                         $('#p1').val('');
                         $('#g1').val('');
                       }
                       $('#type').change(function() {
                         var ty = $(this).val();
                         if (ty == '1') {
                           $('#fgy').hide();
                           $('#yui').show();
                           $('#b1').val('');
                           $('#tags').val('');
                         } else {
                           $('#fgy').show();
                           $('#yui').hide();
                           $('#p1').val('');
                           $('#g1').val('');
                         }
                       });
                     });
                   </script>
                   <div class="col-sm-3">
                     <label>Type<span>
                         <font color="red"> *</font>
                       </span></label>
                     <?php if (isset($book['id'])) {
                        $fg = $book['typ']; ?>
                       <?php $option = array('0' => 'Normal', '1' => 'Periodical');
                        echo $this->Form->input('typ', array('class' => 'form-control nk', 'id' => 'type', 'options' => $option, 'value' => $fg, 'label' => false)); ?>
                       <input type="hidden" name="typ" value="<?php echo $fg; ?>">
                     <?php  } else {
                        $option = array('0' => 'Normal', '1' => 'Periodical');
                        echo $this->Form->input('typ', array('class' => 'form-control nk', 'id' => 'type', 'options' => $option, 'label' => false));
                      }


                      ?>
                   </div>
                   <div class="col-sm-3">
                     <label>Acc. No.<span>
                         <font color="red"> *</font>
                       </span><span id="isbn-status" style="color:red;"></span></label>
                     <?php if (!isset($book['id'])) { ?>
                       <?php echo $this->Form->input('accsnno', array('class' => 'form-control', 'required' => 'required', 'maxlength' => '10', 'id' => 'isbn-no', 'value' => $accssnno, 'type' => 'text', 'label' => false)); ?>
                     <? } else {  ?>
                       <?php echo $this->Form->input('accsnno', array('class' => 'form-control', 'readonly' => 'readonly', 'required' => 'required', 'maxlength' => '10', 'id' => 'isbn-noss', 'type' => 'text', 'label' => false)); ?>
                     <? } ?>

                   </div>
                   <div class="col-sm-3">
                     <label>ISBN No./ISSN No.</label>
                     <?php echo $this->Form->input('ISBN_NO', array('class' => 'form-control bn', 'id' => 'i1', 'maxlength' => '25', 'type' => 'text', 'label' => false)); ?>


                     <input type="hidden" name="book_type" value="General">
                   </div>

                   <div id="fgy">
                     <div class="col-sm-3">
                       <label>Book Category<span>
                           <font color="red"> *</font>
                         </span></label>
                       <?php
                        echo $this->Form->input(
                          'book_category_id',
                          array(
                            'class' => 'form-control', 'id' => 'b1', 'type' => 'select', 'empty' => 'Select Category',
                            'options' => $bookcategories, 'label' => false, 'required'
                          )
                        );
                        ?>
                     </div>
                     <div class="col-sm-6">
                       <label>Book Name<span>
                           <font color="red"> *</font>
                         </span></label>
                       <?php echo $this->Form->input('name', array('class' => 'form-control', 'id' => 'tags', 'maxlength' => '200', 'label' => false, 'required')); ?>
                     </div>
                   </div>

                   <div id="yui" style="display: none;">
                     <div class="col-sm-3">
                       <label>Periodical Category<span>
                           <font color="red"> *</font>
                         </span></label>
                       <?php $mg = $book['periodic_category_id'];
                        if (isset($book['id']) && $mg != '0') { ?>
                         <?php
                          echo $this->Form->input(
                            'periodic_category_id',
                            array(
                              'class' => 'form-control', 'id' => 'p1', 'type' => 'select', 'empty' => 'Select Category', 'value' => $mg,
                              'options' => $peri, 'label' => false
                            )
                          ); ?>
                         <input type="hidden" name="periodic_category_id" value="<?php echo $mg; ?>">
                       <?php   } else {
                          echo $this->Form->input(
                            'periodic_category_id',
                            array(
                              'class' => 'form-control', 'id' => 'p1', 'type' => 'select', 'empty' => 'Select Category',
                              'options' => $peri, 'label' => false
                            )
                          );
                        }
                        ?>
                     </div>
                     <div class="col-sm-12  container-fluid" style="display: none;" id="ghj"></div>

                     <div class="col-sm-6">
                       <label>Periodical Name<span>
                           <font color="red"> *</font>
                         </span></label>
                       <?php if (isset($book['id'])) {
                          echo $this->Form->input('prt', array('class' => 'form-control', 'id' => 'g1', 'maxlength' => '200', 'value' => $book['name'], 'label' => false));
                        } else {
                          echo $this->Form->input('prt', array('class' => 'form-control', 'id' => 'g1', 'maxlength' => '200', 'label' => false));
                        } ?>
                     </div>
                   </div>
                   <?php if (isset($book['id'])) {   ?>
                     <script>
                       $(function() {
                         var vg = '<?php echo $book['book_category_id']; ?>';
                         var ng = '<?php echo $book['periodic_category_id']; ?>';
                         if (vg != '0' && ng == '0') {
                           $('#nhg').show();
                           $('.subscrip').hide();
                           $('#normal').show();
                           $('.bn').prop("disabled", false);

                           $('#p1').prop("required", false);
                           $('#g1').prop("required", false);
                           $('#b1').prop("required", true);
                           $('#tags').prop("required", true);
                         } else {
                           $('.subscrip').hide();

                           $('#normal').hide();
                           $('#nhg').hide();
                           $('#ghj').html('');
                           $('#b1').prop("required", false);
                           $('#tags').prop("required", false);
                           $('#p1').prop("required", true);
                           $('#g1').prop("required", true);

                         }
                       });
                     </script>
                   <?php } ?>


                   <script>
                     $(function() {

                       $('#type').change(function() {
                         $('#isbn-status').hide();
                         var b_namse = $('#type').val();
                         $.ajax({
                           type: 'POST',
                           url: '<?php echo ADMIN_URL; ?>Books/autoaccessionfinder',
                           data: {
                             'types': b_namse
                           },
                           success: function(data) {
                             $('#isbn-no').val(data);
                           },
                         });

                         if ($('#type').val() == '1') {
                           $('.subscrip').hide();
                           $('#normal').hide();
                           $('#nhg').hide();
                           $('#ghj').html('');
                           $('#b1').prop("required", false);
                           $('#tags').prop("required", false);
                           $('#p1').prop("required", true);
                           $('#g1').prop("required", true);
                           $('#pag').html("Issue");
                         } else {
                           $('#nhg').show();
                           $('.subscrip').hide();
                           $('#normal').show();
                           $('.bn').prop("disabled", false);
                           $('.bn').val('');
                           $('#p1').prop("required", false);
                           $('#g1').prop("required", false);
                           $('#b1').prop("required", true);
                           $('#tags').prop("required", true);
                           $('#pag').html("Page Nos.");
                         }
                       });
                     });
                   </script>

                   <?php if (isset($book['id'])) { ?>
                     <script type="text/javascript">
                       $(document).ready(function() {
                         var vg = '<?php echo $book['book_category_id']; ?>';
                         var ng = '<?php echo $book['periodic_category_id']; ?>';
                         if (vg == '0' && ng != '0') {
                           var idf = ng;
                           $.ajax({
                             async: false,
                             type: 'POST',
                             url: '<?php echo ADMIN_URL; ?>Books/periodicSearch',
                             data: {
                               'idf': idf
                             },
                             success: function(data) {
                               $('#ghj').html(data);
                               $('#ghj').show();
                             },
                           });
                           $.ajax({
                             async: false,
                             type: 'POST',
                             url: '<?php echo ADMIN_URL; ?>Books/periodicData',
                             data: {
                               'idf': idf
                             },
                             success: function(data) {
                               var arr = data.split('#');
                               $('.bn').prop("disabled", true);
                               $('.nk').prop("disabled", true);
                               $('#s1').val(arr[0]);
                               $('#v1').val(arr[1]);
                               $('#lang').val(arr[2]);
                               $('#tr1').val(arr[3]);
                               $('#i1').val(arr[4]);
                               $('#bil1').val(arr[5]);
                               $('#dp5').val(arr[6]);
                               $('#ba').val(arr[7]);
                               $('#dp6').val(arr[8]);
                               $('#sd1').val(arr[9]);
                               $('#sd2').val(arr[10]);
                               $('#pr1').val(arr[11]);
                               $('#enqiry_date1').val(arr[12]);
                               $('#ghja').val(arr[13]);
                             },
                           });
                         }
                       });
                     </script>
                   <?php } ?>

                   <script type="text/javascript">
                     $(document).ready(function() {
                       $('#p1').change(function() {
                         var idf = $(this).val();
                         $.ajax({
                           async: false,
                           type: 'POST',
                           url: '<?php echo ADMIN_URL; ?>Books/periodicSearch',
                           data: {
                             'idf': idf
                           },
                           success: function(data) {
                             $('#ghj').html(data);
                             $('#ghj').show();
                           },
                         });

                         $.ajax({
                           async: false,
                           type: 'POST',
                           url: '<?php echo ADMIN_URL; ?>Books/findperiodicasscno',
                           data: {
                             'pid': idf
                           },
                           success: function(data) {
                             $('#isbn-no').val(data);
                           },
                         });

                         $.ajax({
                           async: false,
                           type: 'POST',
                           url: '<?php echo ADMIN_URL; ?>Books/periodicData',
                           data: {
                             'idf': idf
                           },
                           success: function(data) {
                             var arr = data.split('#');
                             $('.bn').prop("disabled", true);
                             var jk = $("#p1 option:selected").text();
                             $('#g1').val(jk);
                             $('#s1').val(arr[0]);
                             $('#v1').val(arr[1]);
                             $('#lang').val(arr[2]);
                             $('#tr1').val(arr[3]);
                             $('#i1').val(arr[4]);
                             $('#bil1').val(arr[5]);
                             $('#dp5').val(arr[6]);
                             $('#ba').val(arr[7]);
                             $('#dp6').val(arr[8]);
                             $('#sd1').val(arr[9]);
                             $('#sd2').val(arr[10]);
                             $('#pr1').val(arr[11]);
                             $('#enqiry_date1').val(arr[12]);
                             $('#ghja').val(arr[13]);
                           },
                         });
                       });
                     });
                   </script>


                   <div class="col-sm-3">
                     <label>Sub Title</label>
                     <?php
                      echo $this->Form->input('sub_title', array('class' => 'form-control bn', 'id' => 's1', 'type' => 'text', 'maxlength' => '200', 'label' => false));
                      ?>
                   </div>
                   <div class="col-sm-3">
                     <label>Book Vendor</label>
                     <?php
                      echo $this->Form->input('book_vendor_id', array(
                        'class' => 'form-control bn', 'id' => 'v1', 'type' => 'select', 'empty' => 'Select Vendor',
                        'options' => $bookvendors, 'label' => false
                      ));
                      ?>
                   </div>
                 </div>


                 <legend style="color:#3c8dbc;font-size: 16px;font-weight:bold;">Publisher Detail</legend>
                 <div class="form-group">
                   <div class="col-sm-6">
                     <label>Publisher</label>
                     <?php echo $this->Form->input('publisher', array('class' => 'form-control bn', 'id' => 'tr1', 'maxlength' => '60', 'label' => false)); ?>
                   </div>

                   <div class="col-sm-3">
                     <label>Volume</label>
                     <?php echo $this->Form->input('vol', array('class' => 'form-control', 'maxlength' => '10', 'id' => 'title', 'label' => false)); ?>
                   </div>
                   <div class="col-sm-3">
                     <label id="pag">Page Nos.</label>
                     <?php echo $this->Form->input('pageno', array('class' => 'form-control', 'type' => 'text', 'maxlength' => '4', 'label' => false)); ?>
                   </div>
                   <div class="col-sm-3">
                     <label>Date</label>
                     <div class="input-group">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <?php echo $this->Form->input('pbyr', array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'enqiry_date3', 'label' => false)); ?>
                     </div>
                   </div>

                   <div class="col-sm-3">
                     <label>Language<span>
                         <font color="red"> *</font>
                       </span></label>
                     <?php
                      echo $this->Form->input('lang', array('class' => 'form-control bn', 'id' => 'lang', 'options' => $lahu, 'label' => false)); ?>
                   </div>

                 </div>

               </div>


               <div class="form-group" id="nhg">
                 <div class="col-sm-6" style="margin-right: 0px;margin-left: -12px;">
                   <legend style="color:#3c8dbc;font-size: 16px;font-weight:bold;">Bill Info</legend>
                   <div class="col-sm-6" style="margin-right: 0px;margin-left: -12px;">
                     <label>Bill No.</label>
                     <?php echo $this->Form->input('bilno', array('class' => 'form-control', 'id' => 'bil1', 'label' => false)); ?>
                   </div>
                   <div class="col-sm-6" style="margin-right: 0px;margin-left: 11px;">
                     <label>Bill Date.</label>
                     <div class="input-group">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <?php echo $this->Form->input('bildt', array('class' => 'form-control ', 'readonly' => 'readonly', 'id' => 'dp5', 'label' => false)); ?>
                     </div>
                   </div>
                   <div class="col-sm-6" style="margin-right: 0px;margin-left: -12px;">
                     <!--
            <label>Bill Amount</label>
            <?php echo $this->Form->input('bamt', array('class' => 'form-control', 'id' => 'ba', 'maxlength' => '5', 'label' => false)); ?>
-->
                   </div>
                   <div class="col-sm-6" style="margin-right: 0px; margin-left: 11px;">
                     <label>Paid On</label>
                     <div class="input-group">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <?php echo $this->Form->input('bpaidon', array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'dp6', 'label' => false)); ?>
                     </div>
                   </div>
                 </div>
               </div>


               <div class="form-group" id="normal">
                 <div class="col-sm-6">
                   <legend style="color:#3c8dbc;font-size: 16px;font-weight:bold;">Books Author's</legend>
                   <div class="col-sm-12">
                     <label>Author 1</label>
                     <?php echo $this->Form->input('author', array('class' => 'form-control', 'maxlength' => '30', 'id' => 'title', 'label' => false)); ?>
                   </div>
                   <div class="col-sm-12">
                     <label>Author 2</label>
                     <?php echo $this->Form->input('athr2', array('class' => 'form-control', 'maxlength' => '30', 'id' => 'title', 'label' => false)); ?>
                   </div>

                   <div class="col-sm-12">
                     <label>Author 3</label>
                     <?php echo $this->Form->input('athr3', array('class' => 'form-control', 'id' => 'title', 'maxlength' => '30', 'label' => false)); ?>
                   </div>


                   <div class="col-sm-12">
                     <label>Author 4</label>
                     <?php echo $this->Form->input('athr4', array('class' => 'form-control', 'maxlength' => '30', 'id' => 'title', 'label' => false)); ?>
                   </div>
                 </div>
               </div>



               <div class="form-group subscrip" style="display:none;">
                 <div class="col-sm-6">
                   <legend style="color:#3c8dbc;font-size: 16px;font-weight:bold;">Subscription Info</legend>
                   <div class="col-sm-6">
                     <label>Sub No.</label>
                     <?php echo $this->Form->input('subsno', array('class' => 'form-control', 'maxlength' => '6', 'id' => 'sd1', 'label' => false)); ?>
                   </div>
                   <div class="col-sm-6">
                     <label>Subscription Amount</label>
                     <?php echo $this->Form->input('subs', array('class' => 'form-control', 'id' => 'sd2', 'maxlength' => '50', 'label' => false)); ?>
                   </div>
                   <div class="col-sm-6">
                     <label>Sub Start Date.</label>
                     <div class="input-group">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <?php echo $this->Form->input('subsdt', array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'enqiry_date1', 'label' => false)); ?>
                     </div>
                   </div>

                   <div class="col-sm-6">
                     <label>Sub End Date.</label>
                     <div class="input-group">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <?php echo $this->Form->input('subedt', array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'ghja', 'label' => false)); ?>
                     </div>
                   </div>
                   <div class="col-sm-6">
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
                     </div>
                   </div>

                   <?php echo $this->Form->input('bid', array('class' => 'form-control', 'value' => $bnid, 'type' => 'hidden', 'label' => false)); ?>
                   <div class="col-sm-6">
                     <label>Per Annum From.</label>
                     <div class="input-group">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <?php echo $this->Form->input('panumdtf', array('class' => 'form-control', 'readonly' => 'readonly', 'id' => 'fdatefrom', 'label' => false)); ?>
                     </div>
                   </div>
                   <div class="col-sm-6">
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
                   </div>
                 </div>
               </div>

               <div class="form-group">
                 <legend style="color:#3c8dbc;font-size: 16px;font-weight:bold;">Library Info</legend>
                 <div class="col-sm-6" style="margin-right: 0px;margin-left: -12px;">
                   <label>Cupboard<span>
                       <font color="red"> *</font>
                     </span></label>
                   <?php
                    echo $this->Form->input(
                      'cup_board_id',
                      array(
                        'class' => 'form-control', 'type' => 'select', 'empty' => 'Select Cupboard',
                        'options' => $cupboards, 'required' => 'required', 'label' => false
                      )
                    );
                    ?>
                 </div>

                 <div class="col-sm-6">
                   <label>Cupboard Shelf<span>
                       <font color="red"> *</font>
                     </span></label>
                   <?php
                    if (isset($book[id]) && !empty($book[id])) {
                      $so = $shelves;
                    } else {
                      $so = [];
                    }

                    echo $this->Form->input(
                      'cup_board_shelf_id',
                      array(
                        'class' => 'form-control', 'type' => 'select', 'empty' => 'Select Cupboard Shelf',
                        'options' => $so, 'required' => 'required', 'label' => false
                      )
                    );
                    ?>
                 </div>
               </div>



               <div class="form-group">
                 <div class="col-sm-6" style="margin-right: 0px;margin-left: -12px;">
                   <label>Price<span>
                       <font color="red"> *</font>
                     </span></label>
                   <?php echo $this->Form->input('book_cost', array('class' => 'form-control bn',  'required' => 'required', 'maxlength' => '5', 'id' => 'pr1', 'min' => 1, 'label' => false)); ?>
                 </div>
               </div>

               <div class="form-group">
                 <?php
                  echo $this->Form->input('copy', array('value' => '1', 'type' => 'hidden', 'maxlength' => '4', 'label' => false, 'required'));
                  ?>
               </div>

               <br>
               <div class="form-group">
                 <div class="col-sm-12">
                   <br>
                   <?php
                    if (isset($book[id]) && !empty($book[id])) {
                      //echo '<button type="submit" name="button" value="update" class="btn btn-success">Update</button> ';
                      echo $this->Form->submit(
                        'Update',
                        array('class' => 'btn btn-info pull-left', 'style' => 'margin-right: 10px; ', 'value' => 'update', 'name' => 'button')
                      );

                      echo $this->Html->link(
                        'Cancel',
                        ['action' => 'index'],
                        ['class' => 'btn btn-primary pull-right']
                      );
                    } else {
                      echo $this->Form->submit(
                        'Create',
                        array('class' => 'btn btn-success')
                      );
                      echo '<button type="reset" class="btn btn-primary pull-right">Reset</button>';
                    }
                    ?>
                 </div>
               </div>

               <?php echo $this->Form->end(); ?>
               <script>
                 jQuery('form').submit(function() {
                   $(this).find(':submit').attr('disabled', 'disabled');
                 });
               </script>

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
             var fg = data.trim();
             if (fg == 'OK') {
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