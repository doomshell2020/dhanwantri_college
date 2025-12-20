<!-- Content Wrapper. Contains page content -->
<style type="text/css">
  .note-group-select-from-files {
    display: none;
  }
</style>
<script src="http://code.jquery.com/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

<script type="text/javascript">
  $(document).ready(function() {

    $('#summernote').summernote({
      placeholder: 'Write here...',
      height: 300, // set editor height
      minHeight: null, // set minimum height of editor
      maxHeight: null,
      callbacks: {
        onImageUpload: function(image) {
          sendFile(image[0]);
        }
      }
    });

    function sendFile(image) {
      data = new FormData();
      data.append("image", image);
      alert('Uploading in progress...');
      $.ajax({
        url: "<?php echo SITE_URL; ?>admin/category/uploader",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(result) {

          $('#summernote').summernote("insertImage", result, 'filename');
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus + " " + errorThrown);
        }
      });
    }

    $('#summernote').summernote("backColor", "red");
    $("#summernote").summernote("foreColor", "blue");


  });

  jQuery($ => {
    
    // $('.action').prop('disabled', true);
    let $checkBox = $('.check').on('change', e => {
      var $select = $(e.target).closest('.form-group').find('.action');

      if(e.target.value == 'Staff'){
        $('.action').prop('disabled', 'disabled');
        $('.action').attr('required', false);

      }else{

        $('.action').prop('disabled', false);
        $('.action').attr('required', true);
      }

    });
  });
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-plus-square"></i> Post Notifications
    </h1>
    <!--
<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
<li><a href="#">Student</a></li>
<li><a href="#">Manage Student</a></li>
<li class="active">Create New Student</li>
	      </ol>   -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">

      <!-- right column -->
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php if (isset($students['id'])) { echo 'Edit Notifications';  } else {  echo 'Add Notifications';  } ?></h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->

          <?php echo $this->Flash->render(); ?>



          <?php echo $this->Form->create($notifications, array(

            'class' => 'form-horizontal',
            'id' => 'student_form',
            'enctype' => 'multipart/form-data',
            'validate'
          )); ?>

          <style>
            .col-sm-6.d-flex label {
              display: flex;
              margin-right: 20px;
            }

            .col-sm-6.d-flex label input {

              margin-right: 5px;
            }
          </style>



          <div class="box-body">

            <div class="form-group">

              <div class="col-sm-4 d-flex">
                <label for="inputEmail3" class="control-label ">Select<span style="color:red;">*</span></label>
                  <input type="radio" class="check" id="Student" name="type" value="Student" required>
                  <label for="html">Student</label><br>
                  <input type="radio" class="check" id="Staff" name="type" value="Staff">
                  <label for="Staff">Staff</label><br>
              </div>
              
              <div class="col-sm-4">
              <label>Select Image<span><font color="red"> *</font> </span></label>
                   <?php echo $this->Form->input('image[]', array('class' => 'form-control','multiple','type' => 'file', 'label' => false,'onchange'=>'return fileValidation();','id'=>'file')); ?>
                   <span style="color:red;display:none;" id="image_ext">Invalid Image Type</span>
              </div>

              <div class="col-sm-4">
                <label for="inputEmail3" class="control-label ">Class<span style="color:red;">*</span></label>
                <select class="form-control action" name="class_id[]" id="class-id" multiple="multiple">

                  <?php foreach ($cls as $ks => $val1) {
                    foreach ($sec as $kd => $val2) {
                      if ($ks == $kd) {  //pr($val1); 
                        $cl1 = $this->Comman->findclass123($val1);
                        $sl2 = $this->Comman->findsection123($val2);
                        //pr($cl1);
                  ?>
                        <option value="<?php echo $val1 . '-' . $val2; ?>"><?php echo $cl1['title'] . ' (' . $sl2['title'] . ')'; ?></option>

                  <?php } } }  ?>

                </select>

              </div>

            </div>

            <div class="form-group">
              <div class="col-sm-8">
                <label>Description</label>
                <textarea name="description" id="summernotes" placeholder="Place some text here" style="width: 1151px; height: 84px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px;" required></textarea>
              </div>
            </div>

       
            <!-- /.box-body -->
            <div class="box-footer">


              <?php
              if (isset($assignments['id'])) {
                echo $this->Form->submit(
                  'Update',
                  array('class' => 'btn btn-info pull-right', 'title' => 'Update')
                );
              } else {
                echo $this->Form->submit(
                  'Submit',
                  array('class' => 'btn btn-info pull-right', 'title' => 'Submit')
                );
              }
              ?> <?php
                  echo $this->Html->link('Back', [
                    'controller' => 'notifications',
                    'action' => 'index'

                  ], ['class' => 'btn btn-default']); ?>
            </div>
            <!-- /.box-footer -->
            <?php echo $this->Form->end(); ?>
          </div>

        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
  </section>
  <!-- /.content -->
</div>

<script src="http://code.jquery.com/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script> 


<!----- Image upload validation !--->
<script>
    function fileValidation() {
      var fileInput =
        document.getElementById('file');
      var filePath = fileInput.value;
      // Allowing file type
      var allowedExtensions =
          /(\.jpg|\.jpeg|\.png|\.gif)$/i;
      
      if (!allowedExtensions.exec(filePath)) {
        $('#image_ext').show('');
        fileInput.value = '';
      }else{

        $('#image_ext').hide('');
      }

        }
  </script>