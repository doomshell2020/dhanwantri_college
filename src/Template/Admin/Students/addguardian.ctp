<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title">
      <i class="fa fa-plus-square"></i> <?php if(isset($classes['id'])){ echo 'Edit Guardian'; }else{ echo 'Add Guardian';} ?>
   </h4>
</div>
<?php echo $this->Form->create($classes, array(
   'class'=>'',
   'id' => 'sevice_form',
   'enctype' => 'multipart/form-data',
   'validate',
   
   )); ?>
<div class="modal-body">
   <div class="row">
      <div class="col-sm-12">
         <div class="form-group">
            <?php $id=$_GET['id']; ?>
            <?php echo $this->Form->input('hide', array('class' => 'smallselect  form-control', 'required', 'style'=>'margin: 6px 7px 9px 0; width: 30%;','value'=>$id,'type'=>'hidden'));  ?>
            <div class="col-sm-6">
               <label for="inputEmail3" class="control-label">Full Name<span style="color:red;">*</span></label>
               <input type="hidden" id="" name="user_id" value="<?php echo $ids; ?>">
               <?php echo $this->Form->input('fullname',array('class'=>'form-control','required','maxlength'=>35,'placeholder'=>'Full Name','label' =>false)); ?>
            </div>
            <div class="col-sm-6">
               <label for="inputEmail3" class="control-label">Relation<span style="color:red;">*</span></label>
               <select class="form-control" name="relation" style="width: 100%;" required="required">
                  <option  value="Father" <?php  if ($classes['relation']=='Father') { ?> selected="selected" <?php } ?>>Father</option>
                  <option value="Uncle" <?php  if ($classes['relation']=='Uncle') { ?> selected="selected" <?php } ?>>Uncle</option>
                  <option value="Mother" <?php  if ($classes['relation']=='Mother') { ?> selected="selected" <?php } ?>>Mother</option>
                  <option value="Aunty" <?php  if ($classes['relation']=='Aunty') { ?> selected="selected" <?php } ?>>Aunty</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <div class="col-sm-6">
               <label for="inputEmail3" class="control-label">Qualification</label>
               <?php echo $this->Form->input('qualification',array('class'=>'form-control','maxlength'=>15,'placeholder'=>'Qualification','label' =>false)); ?>
            </div>
            <div class="col-sm-6">
               <label for="inputEmail3" class="control-label">Occupation</label>
               <?php echo $this->Form->input('occupation',array('class'=>'form-control','maxlength'=>'10','maxlength'=>20,'placeholder'=>'Occupation','label' =>false)); ?>
               <!-- /.input group -->  
            </div>
         </div>
         <div class="form-group">
            <div class="col-sm-6">
               <label for="inputEmail3" class="control-label">Total Income</label>
               <?php echo $this->Form->input('total_Income',array('class'=>'form-control','type'=>'text','placeholder'=>'Total Income','maxlength'=>9,'label' =>false)); ?>
            </div>
            <div class="col-sm-6">
               <label for="inputEmail3" class="control-label">Mobile No<span style="color:red;">*</span></label>
               <?php echo $this->Form->input('mobileno',array('class'=>'form-control','required','placeholder'=>'Mobile No','minlength'=>10,'maxlength'=>10,'label' =>false)); ?>
            </div>
         </div>
         <div class="form-group">
            <div class="col-sm-12">
               <label for="inputEmail3" class="control-label">Email Id<span style="color:red;">*</span></label>
               <?php echo $this->Form->input('email',array('class'=>'form-control','maxlength'=>30,'required','placeholder'=>'Email Id','label' =>false,'value'=>$classes['emails'])); ?>
            </div>
         </div>
         <div class="form-group">
            <div class="col-sm-12">
               <label> Address<span style="color:red;">*</span></label>
               <?php echo $this->Form->input('address',array('class'=>'form-control','required','placeholder'=>'Address','label' =>false)); ?>
            </div>
         </div>
      </div>
   </div>
</div>
<!--./modal-body-->
<div class="modal-footer">
   <button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
   <?php
      if(isset($classes['id'])){
      echo $this->Form->submit(
          'Update', 
          array('class' => 'btn btn-info pull-left','style'=>'', 'title' => 'Update')
      ); }else{ 
      echo $this->Form->submit(
          'Add', 
          array('class' => 'btn btn-info pull-left','style'=>'', 'title' => 'Add')
      );
      }
           ?>   
</div>
<!--./modal-footer-->
</form>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>