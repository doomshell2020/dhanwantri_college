<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header ">
   <h1>Running Exams</h1>
     <ol class="breadcrumb">
    <li><a href="<?php echo ADMIN_URL;?>studentexamresult/examcontrolview"><i class="fa fa-home"></i>Home</a></li>
</ol>
    </section>

    <!-- Main content -->
    <section class="content">
    
     <div class="row">
        <div class="col-xs-12">
          
  <div class="box">
            <div class="box-header">
              <i class="fa fa-upload" aria-hidden="true"></i>
<h3 class="box-title">Absentees && New Students</h3>
      
            </div>
    
            <!-- /.box-header -->

            <div class="box-body">
             <div id="myProgress">
     <style>
  .overlay {
    background-color:#EFEFEF;
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: 1000;
    top: 0px;
    left: 0px;
    opacity: .5; /* in FireFox */ 
    filter: alpha(opacity=50); /* in IE */
}
</style>     
          <?  if($this->Flash->render()){  ?>
          <div id="salert">
         <div class="alert alert-success alert-dismissible" >
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        Exam Result Genrated Sucessfully !!    </div>
           </div>
          <script type="text/javascript" language="javascript">
<!-- Hide from browsers without javascript

window.onload=function()  //executes when the page finishes loading
{
	setTimeout(func1, 5000);  //sets a timer which calls function func1 after 2,000 milliseconds = 2 secs.
	
};
function func1()
{
	document.getElementById("myBar").className="hide";
	document.getElementById("salert").innerHTML="";
	
}

// End hiding -->
</script>
 <div id="myBar" >100%</div>
  <style>
#myBar {

    width: 100%;
    height: 30px;
    background-color: #4CAF50;
    text-align: center; /* To center it horizontally (if you want) */
    line-height: 30px; /* To center it vertically */
    color: white;
}
</style>
  
  <? }else{  ?>
    <div id="myBar" >10%</div>
  <style>
#myBar {
display:none;
    width: 10%;
    height: 30px;
    background-color: #4CAF50;
    text-align: center; /* To center it horizontally (if you want) */
    line-height: 30px; /* To center it vertically */
    color: white;
}
</style>
  <br>
 <?  } ?>
</div>
    
 <style>
         
         #load2{
    width:100%;
    height:100%;
    position:fixed;
    z-index:9999;
    background-color: white  !important;
    background:url("<? echo SITE_URL; ?>images/Preloader_2.gif") no-repeat center center rgba(0,0,0,0.75)
}

</style>
<div class="manag-stu">
  
<script inline="1">
//<![CDATA[
$(document).ready(function () {
$("#TaskAdminCustomerForm").bind("submit", function (event) {
$.ajax({
async:true,
 data:$("#TaskAdminCustomerForm").serialize(),
 dataType:"html", 
 beforeSend: function() {
        // setting a timeout
         $('#load2').css("display", "block");
    },
success:function (data, textStatus) {

$("#example2").html(data);}, 
 complete: function() {
           $('#load2').css("display", "none");
    },
type:"POST", 
url:"<?php echo SITE_URL; ?>admin/Studentexamresult/searchresult"});
return false;
});
});

//]]>
</script>

   <?php echo $this->Form->create('Task',array('url'=>array('controller'=>'ClasstimeTabs','action'=>'viewtimetable'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>
    <?php $role_id= $this->request->session()->read('Auth.User.role_id');
                 
               ?>
  <div class="form-group">
    
    <div class="col-sm-2">
 <label>Select Class<span style="color:red;">*</span></label>
    <?php  foreach($examtypei as $gg=>$tt){
    
    
             
              
              $classidd[]=$tt['class_id'];
              
                         
                        } 
                      
                        function array_map_assoc( $callback , $array ){
  $r = array();
  foreach ($array as $key=>$value)
    $r[$key] = $callback($key,$value);
  return $r;
}
 
                       $mpassoc= implode(',',array_map_assoc(function($k,$v){return "$v";},$classidd));



$arr=explode(',',$mpassoc);

$drt=array_unique($arr);


 
                         foreach($drt as $k=>$ty){
                        $classnme=$this->Comman->findclass($ty); 
                         
                       $rrt[$ty]= $classnme['title'];  
                        }  
            
    if (isset($classid)) {
      echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','required','empty'=>'Select Class','options'=>$rrt,'label' =>false,'selected'=>'selected','value'=>$classid));
     
    }else{
      echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','required','empty'=>'Select Class ','options'=>$rrt,'label' =>false));
    
    }
    
     ?>
    </div>  

   <div class="col-sm-3" id="examtypes">
 <label>Select Exam<span style="color:red;">*</span></label>
    <?php 

  if (isset($examtypesi)) {
     echo $this->Form->input('examtypesi',array('class'=>'form-control','type'=>'select','required','empty'=>'All Exam','label' =>false,'selected'=>'selected','value'=>$examtypesi));
  } else
  {
    echo $this->Form->input('examtypesi',array('class'=>'form-control','type'=>'select','required','empty'=>'All Exam','label' =>false));
  }
  
      ?>  
    </div> 
      
  
    <script>
$(document).ready(function(){
$('#class-id').on('change',function(){
var id = $('#class-id').val();

 $.ajax({ 
        type: 'POST', 
        url: '<?php echo ADMIN_URL ;?>Studentexamresult/find_etype',
        data: {'id':id}, 
        success: function(data){  
//alert(data);
 $('#examtypes').empty();
  $('#examtypes').html(data);
        }, 
        
    });  
});
});

</script>

<script>


$(document).ready(function(){





$('.uploadfromd').on('click',function(e){

var foo=this.href;
$.ajax({
       async:true,
       url: foo,
       method: 'get', 
  //if you're sure its returning json you can set this
       beforeSend: function(xhr) {
$("#myBar").show();
	document.getElementById("myBar").className="show";
 $('html, body').animate({
      scrollTop: 0
    }, 500);
   var elem = document.getElementById("myBar");
    var width = 10;
    var id = setInterval(frame, 1500);
    function frame() {
        if (width >= 99) {
            clearInterval(id);
        } else {
            width++;
            elem.style.width = width + '%';
            elem.innerHTML = width * 1 + '%';
        }
    }
 var div= document.createElement("div");
    div.className += "overlay";
    document.body.appendChild(div);
},
       success: function(data) {
       
       
 
       },
       error: function(error) {
           //handle error json here
       }
});

//event.preventDefault();
});
});
 
  

/*
function mosve(sfg) {

alert(sfg);

$.ajax({
url: "doquery.php",
data: {crit1: "value1", crit2: "value2"},
beforeSend: function(xhr) {
$("#page-loader").show();
},
success: function(data, status) {
$("#content").html(data);
$("#page-loader").hide();
});
});


}   





 
    */
    

</script>



       
    <div class="col-sm-3" style="top: 22px;">
      <button type="submit" class="btn btn-success">Search</button>
       <button type="reset" class="btn btn-primary">Reset</button>
    </div>
    
<?   $rolepresent= $this->request->session()->read('Auth.User.role_id');
if($rolepresent=='4'){     /* ?>
     <div class="col-sm-3" style="top: 22px;">
    <a id="" style="position: absolute;

right: 13px;" class="btn btn-info btn-sm pull-right" target="_blank" href="<?php echo ADMIN_URL ;?>Studentexamresult/totalabsence"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Total Absent</a>
</div>
  </div>
 

     <?php */  }
echo $this->Form->end();
?>   
  
</div>
        
        </div>
        
          </div>  </div>  </div>
    
    
    
    
    
    
      <div class="row"  >
        <div class="col-xs-12">
			 <div id="load2" style="display:none;"></div>
          
  <div class="box" >
            <div class="box-header">
              <i class="fa fa-search" aria-hidden="true"></i>
<h3 class="box-title">  Absentees && New Students </h3>


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
      
     <th>Class</th>
    
<th>Exam </th>
<th>Total </th>
<th>Absentees</th>
<th>New Pending Students</th>
<th>Type </th>
<th>Last Date</th>
<th>Declaration Date</th>

</tr>
 </thead>
                <tbody id="example2">
   
	<?php /*foreach ($examtypes  as $key){
		foreach($classes as $work){
		 pr($work['Sections']['title']); die;}
			}*/ ?>	
		<?php // pr($examtypes);examcontrolview
		$page = $this->request->params['paging']['Students']['page'];
		$limit = $this->request->params['paging']['Students']['perPage'];
		$counter = ($page * $limit) - $limit + 1; 
		
		$arrt=array();
		if(isset($examtypei) && !empty($examtypei)){ 
		
		
		foreach ($examtypei  as $key){
		
		
		$classid=explode(',',$key['class_id']);
                         
foreach($classid as $k=>$ty){
	if(!in_array($ty,$arrt)){
		$arrt[]=$ty;
     $classnme=$this->Comman->findclassesdesc($ty); 
		foreach($classnme as $work){ 

		?>
                <tr>
               <td><?php echo $counter;?></td>
        <td> <a href="<? echo ADMIN_URL; ?>studentexamresult/searcharea/<? echo $work['Classes']['id']; ?>/<? echo $work['Sections']['id']; ?>" title="View Student List" target="_blank"><?php echo $work['Classes']['title']."-".$work['Sections']['title']; ?></a>
      </td>
      <td><?php 
      
      
      $e_type_id=explode(',',$key['e_type_id']);
                         
      $stcounr=$this->Comman->findexamner($work['Classes']['id'],$e_type_id[0]);
       echo $stcounr['examname']; ?></td>
          
      
   
        <td>  <? $stcounr=$this->Comman->findexamresultstudentcounts2($work['Classes']['id'],$work['Sections']['id']); ?> <? echo $stcounr; ?></td>
        
        
        
        <td><?  $absentcounr=$this->Comman->findexamresultstudentabsentcount($work['Classes']['id'],$work['Sections']['id'],$key['id']);  if($absentcounr>0){  ?><a title="Retest Absent Student" target="_blank"  href="<? echo ADMIN_URL; ?>studentexamresult/retestprocess/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $key['id']; ?>"  style="text-decoration: underline;"><?   echo $absentcounr;   ?></a>  <?  }else{  echo "0";  } ?>  </td>
        
                <td><? $absentcounr1=$this->Comman->findexamresultstudentcounts2($work['Classes']['id'],$work['Sections']['id']);
                
                 $absentcounr2=$this->Comman->findexamresultstudentgivecount($work['Classes']['id'],$work['Sections']['id'],$key['id']); 
               
                  $as=count($absentcounr1);   $as2=count($absentcounr2); 
                 $stcounrss=$this->Comman->findexamresultstudentcounts2($work['Classes']['id'],$work['Sections']['id']);
                 
                 
               if($as2 < $as){
				
				   $extracnt=$as-$as2;
			
				 ?>
				  <? if($stcounrss==$extracnt){ echo "--";  }elseif($as2=='0'){ echo "--";  }else{ ?>
				   <a title="New Student" target="_blank"  href="<? echo ADMIN_URL; ?>studentexamresult/examnewstudents/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $key['id']; ?>"  style="text-decoration: underline;"><? echo $extracnt; ?></a>
				   <? } }else{  echo "--"; } ?> </td>
        
      
    <td> <? 
        $excount= $this->Comman->findexamresultcount($work['Classes']['id'],$work['Sections']['id']);  if($key['Examtypes']['id']=='4' || $key['Examtypes']['id']=='9' ){  if($excount>=$examtypesterm1) { ?>
        
        
        <a class="uploadfromd"  href="<? echo ADMIN_URL; ?>studentexamresult/genratecard/<? echo $work['Classes']['id']; ?>/<? echo $work['Sections']['id']; ?>/<? echo "Term".$key['Examtypes']['term']; ?>"><? echo "Generate Term".$key['Examtypes']['term']." Result"?></a><br>
        
        <?    if (!file_exists(WWW_ROOT.'excel_file/student/'.$work['Classes']['title'].'-'.$work['Sections']['title'].'-Term'.$key['Examtypes']['term'].'.pdf')) {   
$filefounsd ='0';                         
}else{
$filefounsd='1';

}

if($filefounsd=='1'){

?><a target="_blank" href="<?php echo SITE_URL; ?>excel_file/student/<? echo $work['Classes']['title']; ?>-<? echo $work['Sections']['title']; ?>-Term<? echo $key['Examtypes']['term']; ?>.pdf" >View Result</a> <?  }

?>
        
        
        <? }else{
        echo "Term 1".$key['Examtypes']['term'];
        
        
        }  }else{
        
        
         echo "Term 1".$key['Examtypes']['term'];
        } ?></td>
      
     <td><?php echo date('d-m-Y',strtotime($key['resultuploadlast_date'])); ?></td>
      <td><?php echo date('d-m-Y',strtotime($key['resultdeclare_date'])); ?></td>
  
  
                 
		
                </tr>
		<?php $counter++;  } } } } } else{ ?>
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




