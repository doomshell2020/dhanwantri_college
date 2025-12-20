 <!-- Content Wrapper. Contains page content -->
 <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
 <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
 <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
 <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
 <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
 <div class="content-wrapper">

   <section class="content-header">
     <h1>
       Template Manager
     </h1>
     <ol class="breadcrumb">
       <li><a href="<?php echo SITE_URL; ?>Template"><i class="fa fa-home"></i>Home</a></li>
     </ol>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <div class="col-xs-12">

         <div class="box">
           <div class="box-header">

             <?php echo $this->Flash->render(); ?>

             <h3 class="box-title">Add Template</h3>
           </div>
           <!-- /.box-header -->

           <div class="box-body">

             <?php 
             echo $this->Form->create($template, array('class' => 'form-horizontal', 'action' => 'index')); ?>
             <input type="hidden" name="edit" value="<?php echo $template['id']; ?>">
             <div class="form-group">
               <div class="col-sm-3">
                 <label>Name<span>
                     <font color="red"> *</font>
                   </span></label>
                 <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Enter Template Name', 'type' => 'text', 'id' => 'title', 'label' => false,
    'required')); ?>
               </div>
             </div>
             <div class="form-group">

               <div class="col-sm-9">
                 <label>Template<span>
                     <font color="red"> *</font>
                   </span></label>
                 <textarea id="summernote"
                   name="template"><?php if (!empty($template)) {echo $template['template'];}?></textarea>

               </div>
             </div>
             <div class="form-group">
               <div class="col-sm-3">
                 <label>Template Category<span>
                     <font color="red"> *</font>
                   </span></label>
                 <?php 
                 if(!empty($template))  $selected=explode(',',$template['category']);
                 echo $this->Form->input('category[]', array('class' => 'form-control', 'placeholder' => 'Enter Template Name', 'type' => 'select', 'id' => 'category', 'label' => false, 'options' => $temp_cat,
    'required', 'empty' => '--Select category--','multiple', 'value' =>$selected)); ?>
               </div>
             </div>
             <div class="form-group">



               <div class="col-sm-6">


                 <button type="submit" style="margin-top: 23px;" class="btn btn-success">Add</button>
                 <button type="reset" style="margin-top: 23px;" class="btn btn-primary">Reset</button>


               </div>

             </div>

             <?php echo $this->Form->end(); ?>

           </div>

         </div>
       </div>
     </div>
     <script>
     $(document).ready(function() {
       $('#summernote').summernote();
     });
     </script>
     <div class="row">
       <div class="col-xs-12">
         <div>
           <?php echo $this->Flash->render(); ?>
         </div>
         <div class="box">
           <div class="box-body">



             <table id="example1" class="table table-bordered table-striped">
               <thead>
                 <tr>
                   <th>#</th>
                   <th>Category</th>
                   <th>Title</th>
                   <th>Template</th>
                   <th>Action</th>
                 </tr>
               </thead>
               <tbody>

                 <?php $counter = 1;if (count($templates) > 0) { //pr($events);?>
                 <?php  foreach ($templates as $key => $value) {
                   ?>
                 <tr>
                   <td><?php echo $counter; ?></td>
                   <td><?php echo $value['category']; ?></td>

                   <td> <?php echo ucfirst($value['name']); ?></td>
                   <td>
                     <a href="<?php echo ADMIN_URL; ?>Template/view/<?php echo $value['id']; ?>" target="_blank">View
                       Template</a></td>

                   <td>
                     <a href="<?php echo ADMIN_URL ?>Template/index/<?php echo $value['id']; ?>"
                       class="btn btn4 btn_trash_a" style="font-size:10px;"><i class="fa fa-pencil fa-2x"
                         aria-hidden="true"></i></a>
                     <a href="<?php echo ADMIN_URL ?>Template/delete/<?php echo $value['id']; ?>"
                       class="btn btn4 btn_trash_a" style="font-size:10px;"><i class="fa fa-trash fa-2x"
                         aria-hidden="true"></i></a>
                   </td>
                 </tr>

                 <?php $counter++;}?>
                 <?php } else {?>
                 <tr>
                   <td colspan="7" align="center">No Data Available</td>
                 </tr>
                 <?php }?>
               </tbody>
             </table>
           </div>

         </div>

       </div>

     </div>
   </section>
   <!-- /.content -->
 </div>