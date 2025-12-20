   <?php echo $this->Form->create('Tasks2', array('url' => array('controller' => 'Studentfees', 'action' => 'savedata'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'TaskAdminCustomerForm2', 'class' => 'form-horizontal'));



    $role_id = $this->request->session()->read('Auth.User.role_id'); ?>
   <? if ($role_id == '5' || $role_id == '8') { ?>
     <button type="submit" class="btn btn-success" style="position: absolute;
top: -41px;
/* right: 0px; */
right: 19px;">Quick Update</button>

   <? } ?>
   <table id="example1" class="table table-bordered table-striped">
     <thead>
       <tr>


         <th>#</th>
         <th style="width: 16%;">Scholar No.</th>
         <th style="width: 15%;">Name</th>
         <th style="width: 18%;">Father Name</th>
         <th style="width: 14%;">Mother Name</th>

         <th style="width: 9%;">Class</th>
         <th style="width: 6%;">Section</th>
         <th style="width: 12%;">Mobile</th>
         <th style="width: 10%;">House</th>

       </tr>
       </tr>
     </thead>
     <tbody id="example2">

       <?php $page = $this->request->params['paging']['Students']['page'];
        $limit = $this->request->params['paging']['Students']['perPage'];
        $counter = ($page * $limit) - $limit + 1;
        if (isset($students) && !empty($students)) {
          foreach ($students as $work) {
        ?>
           <tr>
             <td><?php echo $counter; ?></td>

             <td><?php if ($role_id == '5' || $role_id == '8') {  ?><a title="View Detail" href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $work['id']; ?>"><?php echo $work['enroll']; ?></a>


                 <a title="Edit Student" href="<?php echo SITE_URL; ?>admin/students/edit/<?php echo  $work['id']; ?>"> <img src="<? echo SITE_URL; ?>images/edit.png" style="width: 18px;"></a>

                 <? if ($work['category'] != "RTE") { ?>

                   <a class='global1' title="Pending Fees" style="color:red;" href="<?php echo SITE_URL; ?>admin/students/view_out/<?php echo $work['id']; ?>" data-target="#global-drop-outs<?php echo $work['id']; ?>" data-toggle="modal"><img src="<? echo SITE_URL; ?>images/pending.png"></a>
                   <a title="Update Discount" href="<?php echo SITE_URL; ?>admin/students/discount/<?php echo $work['id']; ?>" data-target="#globaldiscountd" class="globaldiscountds" data-toggle="modal"><img src="<? echo SITE_URL; ?>images/discount.png"></a>

                   <a title="Tution Fees Acknowledgement  <?php echo $work['acedmicyear']; ?>" target="_blank" href="<?php echo SITE_URL; ?>admin/report/feeacknowledgement/<?php echo $work['id']; ?>/<?php echo $work['acedmicyear']; ?>"> <img src="<? echo SITE_URL; ?>images/fee_acnow.png"></a> <? } ?>
                 <?php $getdetailuser = $this->Comman->findacedemicyears();
                    if ($getdetailuser['is_monthlyfee'] == "Y") { ?>
                   <a title="Deposit Fees" href="<?php echo SITE_URL; ?>admin/Monthlyfees/index/<?php echo  $work['id']; ?>/<?php echo $work['acedmicyear']; ?>"> <img src="<? echo SITE_URL; ?>images/deposite_fee.png"></a>
                 <?php } else { ?>
                   <a title="Deposit Fees" href="<?php echo SITE_URL; ?>admin/studentfees/index/<?php echo  $work['id']; ?>/<?php echo $work['acedmicyear']; ?>"> <img src="<? echo SITE_URL; ?>images/deposite_fee.png"></a>

                 <?php } ?>

                 <div class="modal" id="global-drop-outs<?php echo $work['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true" style="display: none;">
                   <div class="modal-dialog">
                     <div class="modal-content modal-content-drop-out">
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
                     //prepare the dialog

                     //respond to click event on anything with 'overlay' class
                     $("#global-drop-outs<?php echo $work['id']; ?>").click(function(event) {
                       $('.modal-content-drop-out').html('');
                       //load content from href of link
                       $('.modal-content-drop-out').load($(this).attr("href"));

                     });
                   });
                 </script>



               <? } else { ?> <?php echo $work['enroll']; ?><? } ?>
             </td>



             <td><input type="text" value="<?php echo $work['fname']; ?> <?php echo $work['middlename']; ?> <?php echo $work['lname']; ?>" class="form-control" name="name[]" placeholder="Enter Pupil's Name"><?php if ($work['discountcategory']) { echo "<span style='color:green;font-weight:12px;'><b>" . $work['discountcategory'] . "</b></span>";   } ?><?php  if ($work['category'] == "Migration" || $work['oldenroll'] != 0) {  echo "<span style='color: red;font-weight:bold;'>(Migr.)*</span>";  }  ?>
             </td>
             <td> <input type="text" value="<?php echo $work['fathername'] ?>" class="form-control" name="fathername[]"></td>
             <td> <input type="text" value="<?php echo $work['mothername'] ?>" class="form-control" name="mothername[]"></td>


             <td>

               <!--
		 <script>
var cl='<? // echo $work['class_id']; 
        ?>';
var sl='<? //echo $work['section_id']; 
        ?>';
$('#class-idss'+cl).on('change',function(){
var id = $('#class-idss'+cl).val();
 $.ajax({ 
        type: 'POST', 
        url: '<?php //echo ADMIN_URL ;
              ?>ClasstimeTabs/find_section',
        data: {'id':id}, 
        success: function(data){  


  
   if(confirm("Are you sure you want to change this?")){
    $('#section-idss'+sl).empty();
  $('#section-idss'+sl).html(data);
   return false;
    }
    else{
        return false;
    }
        }, 
        
    });  
});


</script>  	
-->
               <input type="hidden" value="<?php echo $work['id']; ?>" class="form-control" name="id[]">
               <?php if ($work['category'] == "RTE") {
                  echo
                  $this->Form->input('class_id[]', array('class' => 'form-control', 'type' => 'select', 'disabled' => 'disabled', 'id' => 'class-idss' . $work['class_id'], 'value' => $work['class_id'], 'options' => $classes, 'label' => false,)); ?>

                 <input type="hidden" value="<?php echo $work['class_id']; ?>" class="form-control" name="class_id[]">
               <?php } else {

                  echo
                  $this->Form->input('class_id[]', array('class' => 'form-control', 'type' => 'select', 'id' => 'class-idss' . $work['class_id'], 'value' => $work['class_id'], 'options' => $classes, 'label' => false,));
                }   ?>
             </td>
             <td id="section-ids<? echo $work['class_id']; ?>">
               <?php $sectionslists = $this->Comman->findsectionddd($work['class_id']);
                echo $this->Form->input('section_id[]', array('class' => 'form-control', 'type' => 'select', 'id' => 'section-idss' . $work['section_id'], 'value' => $work['section_id'], 'options' => $sectionslist, 'label' => false)); ?> </td>
             <td>
               <input type="text" value="<?php echo $work['sms_mobile']; ?>" class="form-control" name="sms_mobile[]" placeholder="Enter  First Name">
             </td>

             <td>
               <?php echo  $this->Form->input('h_id[]', array('class' => 'form-control', 'type' => 'select', 'empty' => '-House-', 'value' => $work['h_id'], 'options' => $houses, 'label' => false)); ?>

             </td>


           </tr>
         <?php $counter++;
          }
        } else { ?>
         <tr>
           <td colspan="11" style="text-align:center;">NO Data Available</td>
         </tr>
       <?php } ?>
     </tbody>
   </table>
   <?php
    echo $this->Form->end();
    ?>
   <script>
     //prepare the dialog

     //respond to click event on anything with 'overlay' class
     $(".globaldiscountds").click(function(event) {

       $('.modal-content').load($(this).attr("href")); //load content from href of link

     });
   </script>
   <div class="modal globaldiscountds" id="globaldiscountd" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
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