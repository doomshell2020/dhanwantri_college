<head>

</head>

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">

  <section class="content-header">
    <h1>
      <i class="glyphicon glyphicon-th-list"></i> Manage |<small>Shift</small>
    </h1>
    <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>shift/index">Manage Shift</a></li>
    </ol> 
  </section>

<!-- Main content -->
<section class="content">

<div class="row">
  <div class="col-xs-12">
     <?php echo $this->Flash->render(); ?>
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Shift</h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">
      <table id="" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Shift Name</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $page = $this->request->params['paging']['Shift']['page'];
            $limit = $this->request->params['paging']['Shift']['perPage'];
            $counter = ($page * $limit) - $limit + 1;
            
            if(isset($shifts) && !empty($shifts)){
              foreach($shifts as $work){

                if( isset($work->start_time) && isset($work->end_time) )
                {
                  $start_time = date('h:i a', strtotime($work->start_time));
                  $end_time = date('h:i a', strtotime($work->end_time));
                }
          ?>
              <tr>
                <td><?php echo $counter; ?></td>

                <td><?php if(isset($work['name'])){ echo ucfirst($work['name']);}else{ echo 'N/A';}?></td>

                <td><?php if(!empty($start_time)){ echo $start_time;}else{ echo 'N/A';}?></td>

                <td><?php if(!empty($end_time)){ echo $end_time;}else{ echo 'N/A';}?></td>

                <td>
                	<a class="btn btn-primary btn-view global" href="<?php echo SITE_URL; ?>admin/Shift/edit/<?php echo $work->id; ?>"
        					data-target="#globalModal" data-toggle="modal">
        						Edit
        					</a>
                </td>

             </tr>
             <?php $counter++;} }else{?>
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

<div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true" style="display: none;">
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

<script>

  $(document).ready(function() {

    $(".global").click(function(event){
        //load content from href of link
        $('.modal-content').load($(this).attr("href"));
      });
    
  });

  //--------------------------------------------------------
  
  $('#globalModal').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
  });

</script>
