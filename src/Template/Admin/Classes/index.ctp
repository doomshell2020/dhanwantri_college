 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       Course Manager

     </h1>
     <ol class="breadcrumb">
       <li><a href="<?php echo ADMIN_URL; ?>classes/index"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="<?php echo ADMIN_URL; ?>classes/index">Manage Course</a></li>
     </ol>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <div class="col-xs-12">

         <div class="box">
           <div class="box-header">
             <h3 class="box-title">Course List</h3>

             <!-- /.box-header -->
             <?php echo $this->Flash->render(); ?>


             <?php /* echo $this->Form->create($classes, array('url'=>array(
                       'controller'=>'classes',
                       'action'=>'add',
                       'class'=>'form-horizontal',
		              	'id' => 'sevice_form',
                       'enctype' => 'multipart/form-data'
                       
                     	))); ?>
                     	
				   <div class="form-group">
		       
		         <div class="col-sm-6">
				 <label>Title<span style="color:red;">*</span></label>
		<?php echo $this->Form->input('title',array('class'=>'form-control','placeholder'=>'Title', 'id'=>'title','label' =>false)); ?>
		          </div>
		    
	              <div class="col-sm-6">
		          <label>Type</label>
		       <?php $optn=array('0'=>'Pre','1'=>'Art','2'=>'Commerce','3'=>'Science')?>   
  <?php echo $this->Form->input('type',array('class'=>'form-control','type'=>'select','options'=>$optn,'label' =>false)); ?>  
         </div>
		       </div>
		  
		     <div class="form-group">
             <div class="col-sm-12" style="margin-top: 10px;">
      <button type="submit" class="btn btn-success">Submit</button>
       <button type="reset" class="btn btn-primary" id="re">Reset</button>
    </div>
  </div>
  
<?php echo $this->Form->end(); */ ?>
           </div>


           <div class="box-body">
             <table id="example1" class="table table-bordered table-striped">
               <thead>
                 <tr>
                   <th>Sr.No</th>
                   <th>Course Name</th>
                   <!--<th>Status</th> -->
                   <th>Action</th>
                 </tr>
               </thead>
               <tbody>
                 <?php $page = $this->request->params['paging']['Services']['page'];
                  $limit = $this->request->params['paging']['Services']['perPage'];
                  $counter = ($page * $limit) - $limit + 1;
                  if (isset($classes) && !empty($classes)) {
                    foreach ($classes as $service) {
                  ?>
                     <tr>
                       <td><?php echo $counter; ?></td>
                       <td><?php if (isset($service['title'])) {
                              echo ucfirst($service['title']);
                            } else {
                              echo 'N/A';
                            } ?></td>



                       <td><?php if ($service['status'] == 1) {
                              echo $this->Html->link('', [
                                'action' => 'status',
                                $service->id,
                                $service['status']
                              ], ['class' => 'fas fa-check-circle', 'style' => 'font-size: 16px !important; margin-left: 12px;     color: #36cb3c;']);
                            } else {
                              echo $this->Html->link('', [
                                'action' => 'status',
                                $service->id,
                                $service['status']
                              ], ['class' => 'fas fa-times-circle', 'style' => 'font-size: 16px !important; margin-left: 12px; color:#cd0404;']);
                            } ?>&nbsp;
                         <?php
                          echo $this->Html->link('', [
                            'action' => 'add',
                            $service->id
                          ], ['class' => 'fas fa-edit', 'style' => 'font-size: 16px !important;']); ?>
                         <?php /*
			echo $this->Html->link('View', [
			    'action' => 'view',
			    $service->id
			],['class'=>'btn btn-success']); */ ?>
                         <?php
                          /* echo $this->Html->link('Delete', [
			    'action' => 'delete',
			    $service->id
			],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]); */ ?></td>
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