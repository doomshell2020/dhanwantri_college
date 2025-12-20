 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       Section Manager

     </h1>
     <ol class="breadcrumb">
       <li><a href="<?php echo ADMIN_URL; ?>sections/index"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="<?php echo ADMIN_URL; ?>sections/index">Manage Sections</a></li>
     </ol>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <div class="col-xs-12">

         <div class="box">
           <div class="box-header">
             <h3 class="box-title">Section List</h3>


             <?php /* echo $this->Form->create($classes, array('url'=>array(
                       'controller'=>'sections',
                       'action'=>'add',
                       'class'=>'form-horizontal',
		              	'id' => 'sevice_form',
                       'enctype' => 'multipart/form-data'
                       
                     	))); ?>
                     	
				   <div class="form-group">
		       
		         <div class="col-sm-12">
				 <label>Title<span style="color:red;">*</span></label>
		<?php echo $this->Form->input('title',array('class'=>'form-control','placeholder'=>'Title','required'=>true, 'id'=>'title','label' =>false)); ?>
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
           <!-- /.box-header -->
           <?php echo $this->Flash->render(); ?>
           <div class="box-body">
             <table id="example1" class="table table-bordered table-striped">
               <thead>
                 <tr>
                   <th>#</th>
                   <th>Title</th>
                   <th>Status</th>
                   <!--<th>Action</th>-->
                 </tr>
               </thead>
               <tbody>
                 <?php $page = $this->request->params['paging']['Works']['page'];
                  $limit = $this->request->params['paging']['Works']['perPage'];
                  $counter = ($page * $limit) - $limit + 1;
                  // pr($sections);die;
                  if (isset($sections) && !empty($sections)) {
                    foreach ($sections as $work) {
                  ?>
                     <tr>
                       <td><?php echo $counter; ?></td>
                       <td><?php if (isset($work['title'])) {
                              echo ucfirst($work['title']);
                            } else {
                              echo 'N/A';
                            } ?></td>

                       <td><?php if ($work['status'] == 1) {
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
                            } ?>
                       </td>
                       <? /* ?><td><?php 
			echo $this->Html->link('Edit', [
			    'action' => 'add',
			    $work->id
			],['class'=>'btn btn-primary']); ?>
			<?php 
			echo $this->Html->link('View', [
			    'action' => 'view',
			    $work->id
			],['class'=>'btn btn-success']); 
			echo $this->Html->link('Delete', [
			    'action' => 'delete',
			    $work->id
			],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]); ?>
		  </td> <? */ ?>

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