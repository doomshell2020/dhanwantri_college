<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-wrapper">
      <section class="content-header">
         <h1>
            <i class="fa fa-info-circle" aria-hidden="true"></i> Shuffle Enroll
         </h1>
         <ul class="breadcrumb">
            <li><a href="/"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="/student/default/index">Student</a></li>
            <li class="active">Shuffle Enroll Number</li>
         </ul>
         <?php echo $this->Flash->render(); ?>
      </section>
      <section class="content">
         <?php echo $this->Form->create('shuffle', array('url' => array('controller' => 'students', 'action' => 'shuffle'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'shuffleForm', 'class' => 'form-horizontal', 'onSubmit' => 'return submitchk()')); ?>
         <div class="box box-solid">
            <div class="box-body">
               <div class="row shuffle_changedv">
                  <div class="col-sm-5">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           From Enroll Number
                        </div>
                        <div class="panel-body">
                           <div class="form-group">
                              <div class="col-md-7">
                                 <?php echo $this->Form->text('from_enroll', ['class' => 'form-control', 'label' => false, 'placeholder' => 'From Enroll Number', 'id' => 'from_enroll', 'required']); ?>
                              </div>
                              <div class="col-md-5">
                                 <a class="from_button btn btn-primary" href="javascript:void(0)">Search &
                                 Confirm</a>
                              </div>
                           </div>
                           <div class="table-responsive">
                              <table class="table" id="fromTable" style="display:none">
                                 <colgroup>
                                    <col style="width:125px">
                                 </colgroup>
                                 <tbody>
                                    <tr>
                                       <th>Name</th>
                                       <td id="fromName"></td>
                                    </tr>
                                    <tr>
                                       <th>Class</th>
                                       <td id="fromClass"></td>
                                    </tr>
                                    <tr>
                                       <th>Section</th>
                                       <td id="fromSection"></td>
                                    </tr>
                                    <tr>
                                       <th>Enrollment number</th>
                                       <td id="fromEnroll"></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-2" style="text-align:center">
                     <div style="font-size:25px;"><i class="fas fa-exchange-alt"></i>
                     </div>
                  </div>
                  <div class="col-sm-5">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           To Enroll Number
                        </div>
                        <div class="panel-body">
                           <div class="form-group">
                              <div class="col-md-7">
                                 <?php echo $this->Form->text('to_enroll', ['class' => 'form-control', 'label' => false, 'placeholder' => 'To Enroll Number', 'id' => 'to_enroll', 'required']); ?>
                              </div>
                              <div class="col-md-5">
                                 <a class="to_button btn btn-primary" href="javascript:void(0)">Search &
                                 Confirm</a>
                              </div>
                           </div>
                           <div class="table-responsive">
                              <table class="table" style="display:none" id="toTable">
                                 <colgroup>
                                    <col style="width:125px">
                                 </colgroup>
                                 <tbody>
                                    <tr>
                                       <th>Name</th>
                                       <td id="toName"></td>
                                    </tr>
                                    <tr>
                                       <th>Class</th>
                                       <td id="toClass"></td>
                                    </tr>
                                    <tr>
                                       <th>Section</th>
                                       <td id="toSection"></td>
                                    </tr>
                                    <tr>
                                       <th>Enrollment number</th>
                                       <td id="toEnroll"></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <input type="hidden" name="fromId" id="fromId" value="">
               <input type="hidden" name="toId" id="toId" value="">
               <div class="text-center">
                  <?php echo $this->Form->submit(__('Shuffle'), ['class' => 'btn btn-primary']); ?>
               </div>
            </div>
         </div>
         <?php $this->Form->end(); ?>
      </section>
   </div>
</div>
<script>
   var from = 0;
   var to = 0;
   $(document).ready(function() {
       $('.from_button').click(function() {
           var enroll = $('#from_enroll').val();
           if (enroll == '') {
               alert('Please Fill From Enroll Number');
               return false;
           }
           $.ajax({
               type: 'POST',
               data: {
                   enroll
               },
               url: "<?php echo ADMIN_URL; ?>Students/enroll_search",
               async: false,
               success: function(data) {
                   if (data.success == false) {
                       toastr.error('Invalid From Enroll Number');
                       from = 0;
                       $('#from_enroll').val('');
                       return false;
                   } else {
                       from = 1;
                       $('#fromName').html(data.student.name);
                       $('#fromClass').html(data.student.class);
                       $('#fromSection').html(data.student.section);
                       $('#fromEnroll').html(data.student.enroll);
                       $('#fromId').val(data.student.id);
                       $('#fromTable').show();
                   }
               }
           })
       });
       $('.to_button').click(function() {
           var enroll = $('#to_enroll').val();
           if (enroll == '') {
               toastr.error('Please Fill To Enroll Number');
               return false;
           }
           $.ajax({
               type: 'POST',
               data: {
                   enroll
               },
               url: "<?php echo ADMIN_URL; ?>Students/enroll_search",
               async: false,
               success: function(data) {
                   if (data.success == false) {
                       toastr.error('Invalid To Enroll Number');
                       to = 0;
                       $('#to_enroll').val('');
                       return false;
                   } else {
                       to = 1;
                       $('#toName').html(data.student.name);
                       $('#toClass').html(data.student.class);
                       $('#toSection').html(data.student.section);
                       $('#toEnroll').html(data.student.enroll);
                       $('#toId').val(data.student.id);
                       $('#toTable').show();
                   }
               }
           })
       });
   });
   
   function submitchk(event) {
       if (from != 1 || to != 1) {
           toastr.error('Please Confirm Students Details');
           return false;
       }
       return true;
   };
</script>