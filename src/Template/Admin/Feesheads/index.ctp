<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        Fee Head Manager
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
        <li><a href="<?php echo ADMIN_URL;?>feesheads/index">Manage Fee Head </a></li>
      </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                  <h3 class="box-title">Add Fee Head</h3>
                  <?php echo $this->Flash->render(); ?>
                  <div class="box-body">
                    <?php echo $this->Form->create($feesheads, array(
                        'class'=>'form-horizontal',
                        'id' => 'sevice_form',
                        'enctype' => 'multipart/form-data'
                        )); ?>
                    <div class="form-group add_feeheaddv">
                        <div class="col-md-3 col-sm-6">
                          <label>Fee Head<span style="color:red;">*</span></label>
                          <?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'Fee Head','required'=>true, 'id'=>'title','label' =>false)); ?>
                        </div>
                        <div class="col-md-3 col-sm-6">
                          <label>CBSE Fee<span style="color:red;">*</span></label>
                          <?php echo $this->Form->input('cbse_fee',array('class'=>'form-control','placeholder'=>'Enter CBSE Fee','required'=>true, 'id'=>'title','type'=>'number','label' =>false)); ?>
                        </div>
                        <div class="col-md-3 col-sm-6">
                          <label>CAMBRIDGE Fee<span style="color:red;">*</span></label>
                          <?php echo $this->Form->input('cambridge_fee',array('class'=>'form-control','placeholder'=>'Enter CAMBRIDGE Fee','type'=>'number','required'=>true, 'id'=>'title','label' =>false)); ?>
                        </div>
                        <div class="col-md-3 col-sm-6">
                          <label>IBDP Fee<span style="color:red;">*</span></label>
                          <?php echo $this->Form->input('ibdp_fee',array('class'=>'form-control','placeholder'=>'Enter IBDP Fee','required'=>true, 'id'=>'title','type'=>'number','label' =>false)); ?>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:0px;">
                        <div class="col-sm-12 text-center" style="margin-top: 10px;">
                        <?php if(empty($ids) && !isset($ids)) {?>
                          <button type="submit" class="btn btn-success">Submit</button>
                          <?php } else {?>
                            <button type="submit" class="btn btn-success">Update</button>
                            <?php  } 
                          ?>
                          <?php if(empty($ids) && !isset($ids)) {?>

                          <button type="reset" class="btn btn-primary" id="re">Reset</button>

                          <?php } else {

                              echo $this->Html->link('Back', [
                                  'controller' => 'feesheads',
                                  'action' => 'index'                                
                              ],['class'=>'btn btn-default']); 
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
                  <h3 class="box-title">Fee Head List</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                  <div class="table-responsive">
                    <table id="" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>CBSE Fee</th>
                              <th>CAMBRIDGE Fee</th>
                              <th>IBDP Fee</th>
                              <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $page = $this->request->params['paging']['Services']['page'];
                              $limit = $this->request->params['paging']['Services']['perPage'];
                              $counter = ($page * $limit) - $limit + 1;
                              if(isset($feesheadss) && !empty($feesheadss)){ 
                              foreach($feesheadss as $service){
                          ?>
                          <tr>
                            <td><?php echo $counter;?></td>
                            <td><?php if(isset($service['name'])){ echo ucfirst($service['name']);}else{ echo 'N/A'; } ?></td>
                            <td><?php if(isset($service['cbse_fee'])){   if($service['id']=='2') {  ?><a target="_blank"
                              href="<? echo SITE_URL; ?>admin/classfee">
                              <? echo "View Detail";?></a>
                              <?  }else{  echo ucfirst($service['cbse_fee']); } }else{ echo 'N/A'; } ?>
                            </td>
                            <td><?php if(isset($service['cambridge_fee'])){   if($service['id']=='2') {  ?><a target="_blank"
                              href="<? echo SITE_URL; ?>admin/classfee">
                              <? echo "View Detail";?></a>
                              <?  }else{ echo ucfirst($service['cambridge_fee']); } }else{ echo 'N/A'; } ?>
                            </td>
                            <td><?php if(isset($service['ibdp_fee'])){  if($service['id']=='2') {   ?><a target="_blank"
                              href="<? echo SITE_URL; ?>admin/classfee">
                              <? echo "View Detail";?></a>
                              <?  }else{ echo ucfirst($service['ibdp_fee']); } }else{ echo 'N/A'; } ?>
                            </td>
                            <td><?php
                              echo $this->Html->link('', [
                                  'action' => 'index',
                                  $service->id
                              ],['class' => 'fas fa-edit', 'style' => 'font-size: 16px !important;']); ?>
                              <?php /*
                                  echo $this->Html->link('View', [
                                      'action' => 'view',
                                      $service->id
                                  ],['class'=>'btn btn-success']); */?>
                              <?php $role_id=$this->request->session()->read('Auth.User.role_id');   if($role_id=='5' || $role_id=='1'){
                                  // echo $this->Html->link('Delete', [
                                  //     'action' => 'delete',
                                  //     $service->id
                                  // ],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]);
                                  
                                  echo $this->Html->link('', [
                                    'action' => 'delete',
                                    $service->id
                                  ],['class'=> 'fas fa-trash-alt','style'=>'font-size: 16px !important; color:#cd0404; margin-right:4px !important;'	
                                  ,"onClick"=>"javascript: return confirm('Are you sure do you want to delete this Item')"]); 
                                  } ?>
                            </td>
                          </tr>
                          <?php $counter++; }}else{?>
                          <tr>
                              <td>NO Heads Available</td>
                          </tr>
                          <?php } ?>
                        </tbody>
                    </table>
                  </div>
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
        url: '<?php echo $this->Url->build(' / admin / services / sort '); ?>',
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