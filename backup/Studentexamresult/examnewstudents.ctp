
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header ">
   <h1>Upload Class <b style="color:red;"><? echo $students[0]['class']['title']; ?>-<? echo $students[0]['section']['title']; ?></b> New Students Result</h1>
     <ol class="breadcrumb">
    <li><a href="<?php echo ADMIN_URL;?>studentexamresult/examcontrolview"><i class="fa fa-home"></i>Home</a></li>
</ol>
    </section>

    <!-- Main content -->
    <section class="content">
     <div class="row"  >
		     <?  echo $this->Flash->render();  ?>
<?   $rolepresent= $this->request->session()->read('Auth.User.role_id');
?>
        <div class="col-xs-12">
          
  <div class="box" >
            <div class="box-header">
              <i class="fa fa-search" aria-hidden="true"></i>
<h3 class="box-title">New Students <? echo $students[0]['class']['title']; ?>-<? echo $students[0]['section']['title']; ?> Result </h3>


            </div>
      <div class="row">
       <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
       
            <!-- /.box-header -->
            <!-- form start -->
                   <div class="box-body">
          <div class="box-body" >
          
         

                    <table id="example1" class="table table-bordered table-striped" >
                
  
 <thead>
	 	
    <tr>
<th>#</th>
<th>Student Name</th>
<th>Class</th>
<th>Exam</th>
<th>Type</th>
<th>Upload</th>
</tr>
 </thead>
                <tbody id="example2">
   <?php
		$page = $this->request->params['paging']['Students']['page'];
		$limit = $this->request->params['paging']['Students']['perPage'];
		$counter = ($page * $limit) - $limit + 1; 
	
		
		if(isset($students) && !empty($students)){ 
		

		foreach ($students  as $students){ ?>
		
		<tr>
			<td><? echo $counter; ?></td>
			<td><? echo $students['fname']." ".$students['middlename']." ".$students['lname']; ?></td>
			<td><? echo $students['class']['title']."-".$students['section']['title']; ?></td>
<td><? foreach ($examtypes  as $keys){
    $termm=$keys['termf'];
    $e_type_id=explode(',',$keys['e_type_id']);
                
    $stcounr=$this->Comman->findexamner2($students['class']['id'],$e_type_id[0],$termm);
    if($stcounr['examname']){  echo $stcounr['examname']."<br>"; 
		 } } ?></td>
	<td>Term<? echo $termm; ?></td>
<td> <a title="New Student Detail" target="_blank"  href="<? echo ADMIN_URL; ?>studentexamresult/examnewstudentsdetail/<?php echo $students['id']; ?>/<?php echo $students['class']['id']; ?>/<?php echo $students['section']['id']; ?>/<?php echo $examtypes[0]['id']; ?>"  style="text-decoration: underline;"> <i class="fa fa-upload" aria-hidden="true"></i></a></td>
		
  
  
              
		
                </tr>
		<?php $counter++; } } else{ ?>
		<tr>
		<td colspan="11" style="text-align:center;">NO Data Available</td>
		</tr>
		<?php } ?>	
               
                </tbody>
               
              </table>
              
              
         
    <script>
      $(document).ready(function() {
    //prepare the dialog

    //respond to click event on anything with 'overlay' class
    $(".globalmodalclasssection").click(function(event){

  $('.modal-content').html('');
     
        $('.modal-content').load($(this).attr("href"));  //load content from href of link

      });
  }); 
</script>
        
   
            

            
          </div>
          <!-- /.box-body -->
          
      
          </div>
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
    <!-- /.content -->
  </div>
