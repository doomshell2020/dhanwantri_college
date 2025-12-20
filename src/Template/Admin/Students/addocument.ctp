<?php //pr($documentcategory);exit; ?>
<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title"><i class="fa fa-plus-square"></i> Upload New Documents</h4>
</div>
<?php echo $this->Form->create($documents, array(
   'class' => '',
   'id' => 'sevice_form',
   'enctype' => 'multipart/form-data',
   'validate'
)); ?>
<div class="modal-body">
   <?php echo $this->Flash->render(); ?>
   <div class="row">
      <div class="col-sm-12">
         <div class="form-group">
            <label class="control-label">Category</label>
            <?php echo $this->Form->input('doccat_id', array('class' => 'form-control', 'type' => 'select', 'empty' => 'Select Category', 'required' => 'required','value' =>$selectDocument, 'options' => $documentcategory, 'label' => false)); ?>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-sm-12">
         <div class="form-group">
            <label class="control-label">Document Details</label>
            <input type="hidden" id="user_id" name="user_id" value="<?php echo $ids; ?>">
            <?php echo $this->Form->input('description', array('class' => 'form-control', 'type' => 'textarea', 'maxlength' => '100', 'placeholder' => 'Enter Document Related Description', 'required' => 'required', 'label' => false)); ?>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-sm-12">
         <div class="form-group">
            <label class="control-label" for="studocs-stu_docs_submited_at">Submited Date</label>
            <?php if ($rt == '0') {
               $date = date('d-m-Y');
               echo $this->Form->input('created', array('class' => 'form-control ', 'type' => 'text', 'placeholder' => 'Date', 'required' => 'required', 'id' => 'datepsicksd', 'value' => $date, 'label' => false));
            } else {
               echo $this->Form->input('created', array('class' => 'form-control ', 'type' => 'text', 'placeholder' => 'Date', 'required' => 'required', 'readonly', 'label' => false));
            } ?>
            <script>
               $('#datepsicksd').datepicker({
                  "changeMonth": true,
                  'maxDate': '0',
                  "yearRange": "1980:2018",
                  "changeYear": true,
                  "autoSize": true,
                  "autoclose": true,
                  "dateFormat": "dd-mm-yy",
                  "todayHighlight": 'TRUE'
               });

               $('#datepsicksd').datepicker().on('changeDate', function(ev) {
                  $('.datepicker').hide();
               });
            </script>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-sm-12">
         <div class="form-group">
            <label class="control-label" for="studocs-stu_docs_path">Document</label>
            <input type="file" id="studocs-stu_docs_path" name="photo" title="Browse Document">
            <div class="hint-block">NOTE : Upload only JPG, JPEG, PNG, TXT and PDF file</div>
         </div>
      </div>
   </div>
</div>
<!--./modal-body-->
<div class="modal-footer">
   <button type="submit" class="btn btn-info pull-left"><i class="fa fa-upload"></i> Upload</button> <button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
</div>
<!--./modal-footer-->
</form>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
 
   if (window.FormData) {
      $('input[type="file"]').bind({
         change: function() {
            var input = this,
               files = input.files;
            var f = input.files[0];
            var fileSizeInBytes = f.size || f.fileSize;
            var sizeInKB = fileSizeInBytes / 1024;
            var sizeInMB = sizeInKB / 1024;
            var sizeLimitMB = 2;

            if (sizeInMB > sizeLimitMB) {
               alert('Upload Max file size 2 MB !!');
               $('input[type="file"]').val('');
            } else {
               var ext = $('#studocs-stu_docs_path').val().split('.').pop().toLowerCase();
            }
         }
      });
   } else {
      alert('Browser does not support FormData');
   }
</script>