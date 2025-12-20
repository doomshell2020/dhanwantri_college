<!-- Content Wrapper. Contains page content -->
<?php //pr($classt); die; ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Class Teacher/Co-Class Teacher Manager</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL;?>classteacher"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL;?>Classections/classteacher">Class Teacher Manager </a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
                <i class="fa fa-search" aria-hidden="true"></i>
                <h3 class="box-title"> &nbsp;Search </h3>
            </h3>
          </div>
          <?php echo $this->Flash->render(); ?>
          <div class="box-body">
              <script inline="1">
                //<![CDATA[
                $(document).ready(function () {
                  $("#TaskAdminCustomerForm").bind("submit", function (event) {
                    $.ajax({
                      async:true,
                      data:$("#TaskAdminCustomerForm").serialize(),
                      dataType:"html",
                      type:"POST",
                  beforeSend: function(xhr) {
                  xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())
                
                    },
                      url:"<?php echo ADMIN_URL ;?>Classections/classteachersearch",
                      success:function (data) {
                
                    $("#updt").show();
                        $("#updt").html(data);
                      },
                  });
                    return false;
                });});
              </script>
              <?php echo $this->Form->create('classteacher',array('url'=>array('controller'=>'Classections'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>
              <div class="form-group" style="">
                <!--<div class="col-sm-2">
                  <label >Class<span style="color:red;">*</span></label>
                  <?php
                  // echo $this->Form->input('class_id.',array('class'=>'form-control','type'=>'select','empty'=>'Select Class','multiple','options'=>$classes,'label' =>false));
                  ?>
                </div>-->
                <div class="col-md-12" style="margin-bottom:10px;">
                    <!-- <b style=" display:inline-block;">&nbsp;</b> -->
                    <label class="radio-inline"><input required="" id="radio1" name="teacher_type" checked="checked" value="1" type="radio">Class Teacher</label>
                    <label class="radio-inline"><input name="teacher_type" required="" id="radio2" value="2" type="radio">Co-Class Teacher</label>
                </div>
                <div class="col-md-3 col-sm-6  col-xs-6">
                    <input type="text" class="form-control" name="fname" placeholder="Enter Teacher First Name">
                </div>
                <script>
                    $(document).ready(function(){
                    $('#class-ids').on('change',function(){
                    var id = $('#class-ids').val();
                    //alert(id);
                    $.ajax({
                            type: 'POST',
                            url: '<?php echo ADMIN_URL ;?>ClasstimeTabs/find_section',
                            data: {'id':id},
                              beforeSend: function(xhr) {
                                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())
                                },
                            success: function(data){
                    
                    $('#section-id').empty();
                      $('#section-id').html(data);
                            },
                    
                        });
                    });
                    });
                    
                </script>
                <div class="col-md-3 col-sm-6  col-xs-6">
                    <?php
                      echo
                      $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','id'=>'class-ids','empty'=>'Select Class','options'=>$classes,'label' =>false));
                        ?>
                </div>
                <div class="col-md-3 col-sm-6  col-xs-6">
                    <?php
                      echo $this->Form->input('section_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Section','options'=>$sectionslist,'label' =>false));
                      
                        ?>
                </div>
                <div class="col-md-3 text-sm-center">
                    <input type="submit" class="btn btn-success form-control" value="Search">
                    <button type="reset" class="btn btn-primary form-control" id="re">Reset</button>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 text-right" >
                    <?php    $role_id = $this->request->session()->read('Auth.User.role_id');
                      if($role_id == '5' || $role_id=='8' ||  $role_id=='6')
                        { ?>
                    <button type="button" class="btn btn-success m-top10 pull-right" style="margin-right:10px;margin-top: 24px;"><i class="fa fa-plus" aria-hidden="true"></i> <a href="<?php echo SITE_URL; ?>admin/Classections/classteacher_add">
                    <span style="color:#FFF">Add</span></a></button>
                    <!-- <button type="button" class="btn btn-success m-top10 pull-right" style="margin-right:15px;margin-top: 24px;"><i class="fa fa-plus" aria-hidden="true"></i> <a href="<?php echo SITE_URL; ?>admin/Classes/classTeacherImport">
                      <span style="color:#FFF">Import</span></a></button>-->
                    <button type="button" class="btn btn-success m-top10 pull-right" style="margin-right:15px;margin-top: 24px;">
                    <i class="fa fa-plus" aria-hidden="true"></i><a id=""   target="_blank" href="<?php echo ADMIN_URL ;?>Classections/classteacherpdf"> <span style="color:#FFF">Export PDF</span></a></button>
                    <?php } ?>
                </div>
                <?php echo $this->Form->end();  ?>
              </div>

              <div id="updt">
                <?php $role_id = $this->request->session()->read('Auth.User.role_id'); ?>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <!-- <th>Email</th> -->
                            <th>Mobile</th>
                            <?php if($role_id == '5' || $role_id == '8' || $role_id == '6'){ ?>
                            <th>Password</th>
                            <?php } ?>
                            <th>Type</th>
                            <th>Class</th>
                            <th>Section</th>
                            <?php if($role_id == '5' || $role_id == '8'  || $role_id == '6'){ ?>
                            <th>Action</th>
                            <?php } ?>
                          </tr>
                      </thead>
                      <tbody>
                          <?php $page = $this->request->params['paging']['Services']['page'];
                            $limit = $this->request->params['paging']['Services']['perPage'];
                              $counter = ($page * $limit) - $limit + 1;
                              if(isset($classts) && !empty($classts)){
                              foreach($classts as $service){// pr($service);
                              ?>
                          <tr>
                            <td><?php echo $counter;?></td>
                            <td><?php if(isset($service['employee']['fname'])){ echo ucwords(strtolower($service['employee']['fname'])).' '.ucwords(strtolower($service['employee']['middlename'])).' '.ucwords(strtolower($service['employee']['lname']));}else{ echo 'N/A'; } ?></td>
                            <!-- <td><?php //if(isset($service['employee']['username'])){ echo $service['employee']['username'];}else{ echo 'N/A'; } ?></td> -->
                            <td><?php if(isset($service['employee']['mobile'])){ echo $service['employee']['mobile'];}else{ echo 'N/A'; } ?></td>
                            <?php if($role_id == '5' || $role_id == '8'  || $role_id == '6'){ ?>
                            <td><?php if(isset($service['employee']['id'])){  $dt=$this->Comman->findapass($service['employee']['id']); echo $dt['confirm_pass']; }else{ echo 'N/A'; } ?></td>
                            <?php } ?>
                            <td><?php if(isset($service['teacher_type'])){ if($service['teacher_type']=='1'){echo "Class Teacher";}else{ echo "Co-Class Teacher"; } }else{ echo 'N/A'; } ?></td>
                            <td><?php if(isset($service['class_id'])){ echo ucfirst($service['class']['title']);}else{ echo 'N/A'; } ?></td>
                            <td><?php if(isset($service['section_id'])){ echo ucfirst($service['section']['title']);}else{ echo 'N/A'; } ?></td>
                            <?php if($role_id == '5' || $role_id == '8'  || $role_id == '6'){ ?>
                            <td><?php
                                echo $this->Html->link('', [
                                    'action' => 'classteacher_add',
                                    $service->id
                                ],['class' => 'fas fa-edit', 'style' => 'font-size: 16px !important;']); ?>
                                <?php /*
                                  echo $this->Html->link('View', [
                                      'action' => 'view',
                                      $service->id
                                  ],['class'=>'btn btn-success']); */?>
                                <?php $role_id=$this->request->session()->read('Auth.User.role_id');
                                  echo $this->Html->link('', [
                                      'action' => 'deleteclassteacher',
                                      $service->id
                                  ],['class'=> 'fas fa-trash-alt','style'=>'font-size: 16px !important; color:#cd0404; margin-right:4px !important;'	
                                  ,"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]);  ?>
                            </td>
                            <?php } ?>
                          </tr>
                          <?php $counter++; }}else{?>
                          <tr>
                            <td colspan="8">NO Data Available</td>
                          </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->