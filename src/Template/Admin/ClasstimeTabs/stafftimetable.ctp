<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
        Timetables Manager
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <?php  $role= $this->request->session()->read('Auth.User.role_id');
            $username= $this->request->session()->read('Auth.User.email');  if($role== ADMIN || $role== CENTER_COORDINATOR || $role== TEACHER){ ?>
          <div class="box-header">
            <i class="fa fa-search" aria-hidden="true"></i>
            <h3 class="box-title">Search Time Table </h3>
            <?php if($role!=CENTER_COORDINATOR) { ?>
            <a href="<?php echo SITE_URL; ?>admin/Timetables/index">
            <button class="btn btn-success pull-right m-top10">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Class Timing </button>
            </a>
            <?php } ?>
          </div>
          <?php } ?>
          <!-- /.box-header -->
          <?php echo $this->Flash->render(); ?>
          <?php  if($role == ADMIN || $role==CENTER_COORDINATOR || $role== TEACHER){  ?>
          <div class="box-body">
            <div class="manag-stu">
                <script inline="1">
                  //<![CDATA[
                  $(document).ready(function () {
                  $("#TaskAdminCustomerForm").bind("submit", function (event) {
                  $.ajax({
                  async:true,
                    data:$("#TaskAdminCustomerForm").serialize(),
                    dataType:"html",
                  success:function (data, textStatus) {
                  $("#resizable-tables").html(data);},
                  type:"POST",
                  url:"<?php echo SITE_URL; ?>admin/ClasstimeTabs/editSearch"});
                  return false;
                  });
                  });
                  //]]>
                </script>
                <?php echo $this->Form->create('Task',array('url'=>array('controller'=>'ClasstimeTabs'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>
                <div class="form-group">
                  <div class="col-sm-4">
                      <label>Select Teacher</label>
                      <?php $array=array();   foreach($employee as $key=>$value){
                        $array[$key]=str_replace(";"," ",$value);
                        } ?>
                      <?php if($seletedclassid){  echo $this->Form->input('teach_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Teacher','options'=>$array,'value'=>$seletedclassid,'label' =>false,'required')); }
                        else{
                        echo $this->Form->input('teach_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Teacher','options'=>$array,'label' =>false,'required'));
                        } ?>
                  </div>
                  <div class="col-sm-4" style="top: 22px;">
                      <button type="submit" class="btn btn-success" id="staff-search">Search</button>
                      <button type="reset" class="btn btn-primary">Reset</button>
                  </div>
                </div>
                <?php
                  echo $this->Form->end();
                  ?>
            </div>
          </div>
          <?php } ?>

          <div class="box-body" id="resizable-tables">
            <?php if($classectionid) { ?>
            <table class="table">
              <thead>
                  <tr>
                    <th>Subject</th>
                  </tr>
              </thead>
              <tbody>
                  <?php if($subjectslist){ foreach($subjectslist as $key=>$value) { ?>
                  <tr>
                    <td><?php echo $key; ?> :<?php echo $value; ?></td>
                  </tr>
                  <?php } }  ?>
              </tbody>
            </table>
            <?php } ?>
            <script>
              //prepare the dialog
              //respond to click event on anything with 'overlay' class
              $(".globalModals").click(function(event){
                  $('.modal-content').load($(this).attr("href"));  //load content from href of link
                  });
                $(".globalModalss").click(function(event){
                  $('.modal-content').load($(this).attr("href"));  //load content from href of link
                  });
            </script>
            <div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
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
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<script>
  $(function() {
    //hang on event of form with id=myform
    $(document).on("submit", ".timestable_form" , function(e) {
      //prevent Default functionality
      e.preventDefault();
      //get the action-url of the form
      var actionurl = '<?php echo ADMIN_URL ;?>ClasstimeTabs/update_staff_timetable';
      //do your own request an handle the results
      $.ajax({
        url: actionurl,
        type: 'post',
        data: $(this).serialize(),
        success: function(data) {
          data=JSON.parse(data);
            if(data.success==true){
            toastr.success('Timetable updated successfully');
            $('#globalModal').modal('hide');
            $('#staff-search').trigger( "click" );
            }else{
            toastr.error('Error while updating Timetable');
            }
        }
      });
    });
  });
</script>