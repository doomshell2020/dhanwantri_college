
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Student Exam Report Card
       
      </h1>
        <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>studentexamresult/schoolexamview">Result</a></li>
	      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    
     	
		
      <div class="row"  >
        <div class="col-xs-12">
          
	<div class="box" >
	<?php echo $this->Flash->render(); ?>
            <div class="box-header">
              <i class="fa fa-search" aria-hidden="true"></i>
<h3 class="box-title"> Report Card </h3>


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
		      <div class="box-body" id="example2" >
                    <table id="example1" class="table table-bordered table-striped" >
                
  
 <thead>
    <tr>
      <th>#</th>

      <th>Class</th>
      <th>Section</th>
       <th>Term 1</th>
      <th>Term 2</th>
    </tr>
 </thead>
                <tbody >
		<?  if(isset($classes)){
		$counter=1;
		foreach($classes as $f=>$value){ 
		
		$sddf=$this->Comman->findstudentexamresultsection($f); 
		
		foreach($sddf as $gg=>$hhf){
		 $fff=$this->Comman->findsecti($hhf['sect_id']); ?>
		<tr> <td><? echo $counter++; ?></td>
		<td><a href="<? echo ADMIN_URL; ?>studentexamresult/searcharea/<? echo $f; ?>/<? echo $hhf['sect_id']; ?>" title="View Student List" target="_blank"><? echo $value; ?></a></td>
		<td><? echo $fff['title']; ?></td>
		
		<td><a href="<? echo ADMIN_URL; ?>studentexamresult/genratecard/<? echo $f; ?>/<? echo $hhf['sect_id']; ?>/Term1"><? echo "Generate Result"?></a><br>
		
		<?    if (!file_exists(WWW_ROOT.'excel_file/student/'.$value.'-'.$fff['title'].'-Term1.pdf')) {   
$filefounsd ='0';                         
}else{
$filefounsd='1';

}

if($filefounsd=='1'){

?><a target="_blank" href="<?php echo SITE_URL; ?>excel_file/student/<? echo $value; ?>-<? echo $fff['title']; ?>-Term1.pdf" >View Result</a> <?  }else if($filefounsd=='0'){ ?>

<a href="#">Result Pending</a> 

<?
}

?></td>
		<td>
		
		<a href="<? echo ADMIN_URL; ?>studentexamresult/genratecard/<? echo $f; ?>/<? echo $hhf['sect_id']; ?>/Term2"><? echo "Genrate Result"?></a><br>
		
		<?    if (!file_exists(WWW_ROOT.'excel_file/student/'.$value.'-'.$fff['title'].'-Term2.pdf')) {   
$filefounsdty ='0';                         
}else{
$filefounsdty='1';

}

if($filefounsdty=='1'){

?><a target="_blank" href="<?php echo SITE_URL; ?>excel_file/student/<? echo $value; ?>-<? echo $fff['title']; ?>-Term2.pdf" >View Result</a> <?  }else if($filefounsdty=='0'){ ?>

<a href="#">Result Pending</a> 

<?
}

?>
		
		
		</td>
		
		
		
		</tr>
		
		
		
		<?  } }
		
		
		
		}else{ ?>
		<tr>
		<td style="text-align:center;" colspan="5">NO Data Available</td>
		</tr>
			<? } ?>
                </tbody>
               
              </table>
    		
    		
		
		        

		        
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




