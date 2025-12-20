 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">

   <section class="content-header">
     <h1>
     Manage Book Vendor
     </h1>
     <ol class="breadcrumb">
       <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="<?php echo ADMIN_URL; ?>BookVendors/index">Manage Book Vendor</a></li>
     </ol>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <div class="col-xs-12">

         <div class="box">
           <div class="box-header">
             <?php echo $this->Flash->render(); ?>
             <h3 class="box-title">Create Vendor</h3>
           </div>
           <!-- /.box-header -->
           <div class="box-body">

             <div class="manag-stu">
               <?php echo $this->Form->create($bookvendor, array('class' => 'form-horizontal')); ?>
               <div class="form-group">
                 <div class="col-sm-6">
                   <label>Name<span>
                       <font color="red">*</font>
                     </span></label>
                   <?php echo $this->Form->input('name', array('class' => 'form-control', 'id' => 'title', 'label' => false, 'required')); ?>
                 </div>

                 <div class="col-sm-6">
                   <label>Address</label>
                   <?php echo $this->Form->textarea('address', array('rows' => '2', 'class' => 'form-control', 'label' => false)); ?>
                 </div>
               </div>

               <div class="form-group">
                 <div class="col-sm-6">
                   <label>Contact No</label>
                   <?php echo $this->Form->input('contact_no', array('class' => 'form-control', 'type' => 'text', 'label' => false)); ?>
                 </div>

                 <div class="col-sm-6">
                   <label>Email Id</label>
                   <?php echo $this->Form->input('email', array('class' => 'form-control', 'type' => 'text', 'id' => 'title', 'label' => false)); ?>
                 </div>
               </div>

               <div class="form-group">
                 <div class="col-sm-12">
                   <?php
                    if (isset($bookvendor['id']) && !empty($bookvendor['id'])) {
                      echo '<button type="submit" name="button" value="update" class="btn btn-success">Update</button> ';

                      echo $this->Html->link(
                        'Cancel',
                        ['action' => 'index'],
                        ['class' => 'btn btn-primary']
                      );
                    } else {
                      echo '<button type="submit" class="btn btn-success">Create</button> ';
                      echo '<button type="reset" class="btn btn-primary">Reset</button>';
                    }
                    ?>
                 </div>
               </div>
               <?php echo $this->Form->end(); ?>
             </div>
           </div>
         </div>
       </div>
     </div>
     <div class="row">
       <div class="col-xs-12">

         <div class="box">
           <div class="box-header">
             <h3 class="box-title">View Vendors</h3>
           </div>
           <!-- /.box-header -->

           <div class="box-body">
             <table id="example1" class="table table-bordered table-striped">
               <thead>
                 <tr>
                   <th>S.No</th>
                   <th>Name</th>
                   <th>Address</th>
                   <th>Contact No</th>
                   <th>Email Id</th>
                   <!-- <th>Status</th> -->
                   <th>Action</th>
                 </tr>
               </thead>
               <tbody>
                 <?php $page = $this->request->params['paging']['bookvendors']['page'];
                  $limit = $this->request->params['paging']['bookvendors']['perPage'];
                  $counter = ($page * $limit) - $limit + 1;

                  if (isset($bookvendors) && !empty($bookvendors)) {
                    foreach ($bookvendors as $work) {
                     
                  ?>
                     <tr>
                       <td><?php echo $counter; ?></td>

                       <td><?php if (isset($work['name'])) {
                              echo ucfirst($work['name']);
                            } else {
                              echo 'N/A';
                            } ?></td>

                       <td><?php if (isset($work['address'])) {
                              echo ucfirst($work['address']);
                            } else {
                              echo 'N/A';
                            } ?></td>

                       <td>
                         <?php $ert = explode(',', $work['contact_no']); 
                          if (isset($work['contact_no'])) {
                            foreach ($ert as $fg) {
                              echo $fg . '<br>';
                            }
                          } else {
                            echo 'N/A';
                          }
                          ?>
                       </td>

                       <td><?php $rty = explode(',', $work['email']); 

                            if (isset($work['email'])) {
                              foreach ($rty as $df) {
                                echo $df . '<br>';
                              }
                            } else {
                              echo 'N/A';
                            } ?></td>

                       <td><?php if ($work['status'] == 'Y') {
                              echo $this->Html->link('', [
                                'action' => 'status',
                                $work->id,
                                $work['status']
                              ], ['class' => 'fas fa-check-circle', 'style' => 'font-size: 16px !important; margin-left: 12px;     color: #36cb3c;']);
                            } else {
                              echo $this->Html->link('', [
                                'action' => 'status',
                                $work->id,
                                $work['status']
                              ], ['class' => 'fas fa-times-circle', 'style' => 'font-size: 16px !important; margin-left: 12px; color:#cd0404;']);
                            } ?>&nbsp;
                         <?php
                          echo $this->Html->link('', [
                            'action' => 'index',
                            $work->id
                          ], ['class' => 'fas fa-edit', 'style' => "font-size: 16px !important;"]); ?>

                         <?php
                          echo $this->Html->link('', [
                            'action' => 'delete',
                            $work->id
                          ], ['class' => 'fa fa-trash', 'style' => "font-size: 16px !important;color:red;", "onClick" => "javascript: return confirm('Are you sure you want to delete this?')"]); ?>
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