<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      SMS Template Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL;?>students/smsmanager"><i class="fa fa-home"></i>Home</a></li>
     <li><a href="#">Sms Count:- <?php echo $msg_count; ?></a></li> 

    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <?php echo $this->Flash->render(); ?>
              <?php echo $this->Form->create($sms, array(
                  'class'=>'form-horizontal',
                  'id' => 'sevice_form',
                  'enctype' => 'multipart/form-data'

                  )); ?>
              <div class="form-group add_smstmpletfrm" style="margin-bottom:0px;">
                  <div class="col-md-3 col-sm-4">
                    <label>SMS Category<span style="color:red;">*</span></label>
                    <?php echo $this->Form->input('category',array('class'=>'form-control','placeholder'=>'SMS Category','required'=>true, 'id'=>'category','label' =>false)); ?>
                  </div>
                  <div class="col-md-3 col-sm-4">
                    <label>SMS For<span style="color:red;">*</span></label><br>
                    <div style="display:flex; align-items: center; justify-content:space-between; height:34px;">
                      <label style="margin-bottom:0px;"> <input type="radio" name="sms_for" required="required" value="S" style="margin-top:0px; vertical-align: -1px;" > Students</label>
                      <label style="margin-bottom:0px;"> <input type="radio" name="sms_for" required="required"  value="E" style="margin-top:0px; vertical-align: -1px;" > Employees</label>
                      <label style="margin-bottom:0px;"> <input type="radio" name="sms_for" required="required"  value="B" style="margin-top:0px; vertical-align: -1px;" checked> Both</label>
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-4">
                    <label>SMS Message<span style="color:red;">*</span></label>
                    <?php echo $this->Form->input('message',array('class'=>'form-control','placeholder'=>'SMS Message','required'=>true,'type'=>'text','id'=>'message','label' =>false)); ?>
                  </div>
                  <div class="col-md-3 col-sm-12 text-right" style="margin-top: 24px;">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <?php if(empty($ids) && !isset($ids)) {?>
                    <button type="reset" class="btn btn-primary" id="re">Reset</button>
                    <?php } else {
                        echo $this->Html->link('Back', [
                            'controller' => 'banks',
                            'action' => 'index'
                          
                        ],['class'=>'btn btn-default']); 
                        } ?>
                  </div>
              </div>
              <?php echo $this->Form->end(); ?>
            </div>

            <div class="box-body">
              <div class="table-responsive sms_templet_tbl">
                <table id="" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>SMS For</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $page = $this->request->params['paging']['Services']['page'];
                      $limit = $this->request->params['paging']['Services']['perPage'];
                      $counter = ($page * $limit) - $limit + 1;
                      if(isset($smslist) && !empty($smslist)){ 
                      foreach($smslist as $service){
                    ?>
                    <tr>
                      <td><?php echo $counter;?></td>
                      <td><?php if(isset($service['category'])){ echo ucwords(strtolower($service['category']));}else{ echo 'N/A'; } ?></td>
                      <td><?php if($service['sms_for']=="E"){ echo "Employees"; } else if($service['sms_for']=="B"){ echo "Both"; } else{ echo "Students"; } ?></td>
                      <td><?php if(isset($service['message'])){ echo $service['message'];}else{ echo 'N/A'; } ?></td>
                      <td><?php
                        echo $this->Html->link('Edit', [
                            'action' => 'smsmanager',
                            $service->id
                        ],['class'=>'btn btn-primary']); ?>
                      
                      </td>
                    </tr>
                    <?php $counter++;} }else{?>
                    <tr>
                      <td colspan="5">NO Data Available</td>
                    </tr>
                    <?php } ?>	
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      </div>
    </div>
  </section>
</div>
<script>
  $(document).ready(function(){
  $('.sort').on('change',function(){
  var sort = $(this).val();
  var id = $(this).attr('data-val');
  $.ajax({
          type: 'POST',
          url: '<?php echo $this->Url->build('/admin/services/sort'); ?>',
          data: {'id':id,'sort':sort},
          success: function(data){
            $('#sort').val(data);
          },

      });
  });
  });

</script>
<!-- /.content-wrapper -->