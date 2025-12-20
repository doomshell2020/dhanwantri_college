<?php //echo date('Y-m-d'); die; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        Substitute Manager
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo ADMIN_URL;?>leavetype/index"><i class="fa fa-home"></i>Home</a></li>
        <li><a href="<?php echo ADMIN_URL;?>leavetype/index">Substitute Manager</a></li>
      </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box">
              <div class="box-header" style="text-align:right;">
                <a id="" class="btn btn-info" href="<?php echo ADMIN_URL ;?>Employeeattendance/substitute_excel">
                  <i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel
                </a>
              </div>
              <div class="box-body">
                <table id="" class="table table-bordered table-striped">
                  <thead>
                      <tr>
                        <th>#</th>
                        <th>EmpId</th>
                        <th>E-Name</th>
                        <th>E-Mobile</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php $page = $this->request->params['paging']['Services']['page'];
                        $limit = $this->request->params['paging']['Services']['perPage'];
                        $counter = ($page * $limit) - $limit + 1;
                        if(isset($Leave) && !empty($Leave)){
                        foreach($Leave as $service){
                        ?>
                      <tr>
                        <td><?php echo $counter;?></td>
                        <td><?php if(isset($service['id'])){ echo $service['emp_id'];}else{ echo 'N/A'; } ?></td>
                        <td><?php if(isset($service['employee']['fname'])){ ?> <a  href="<?php echo SITE_URL;?>admin/Employeeattendance/timetableshow/<?php echo  $service['employee']['id']; ?>"><?php  echo $service['employee']['fname']." ".$service['employee']['middlename']." ".$service['employee']['lname'];}else{ ?></a><?php  echo 'N/A'; } ?></td>
                        <td><?php if(isset($service['employee']['mobile'])){ echo $service['employee']['mobile'];}else{ echo 'N/A'; } ?></td>
                        <td><?php if(isset($service['leave_type_id'])){ echo $service['leavetype']['name'];}else{ echo 'N/A'; } ?></td>
                        <td><?php if(isset($service['date_from'])){ echo  $date=date("d-m-Y", strtotime($service['date_from'] )); } ?></td>
                        <td><?php if(isset($service['date_to'])){ echo  $date=date("d-m-Y", strtotime($service['date_to'] )); } ?></td>
                      </tr>
                      <?php $counter++;} }else{?>
                      <tr>
                        <td colspan="7">NO Data Available</td>
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
  $(document).ready(function(){
    $.ajax({
          type: 'POST',
          url: '<?php echo ADMIN_URL ;?>Employeeattendance/checkallsubstitute',
          data: {'id':id,'sort':sort},
          success: function(data){
          },
      });
</script>
<!-- /.content-wrapper -->