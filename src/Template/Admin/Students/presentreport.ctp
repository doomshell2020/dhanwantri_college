<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      <i class="fa fa-money"></i> RFID Present Report 
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL;?>students/presentreport">Manage  RFID Present Report </a></li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
<span class="description">
<?  $cio=0;
   if(isset($studentrfidsd) && !empty($studentrfidsd)){ 
   
   
   foreach($studentrfidsd as $element) {
   
   if($element['class_id']){
   
   $cio++;
   
   
   }
   
   
   } }
   
   
   ?>
</span>
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-header">
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
   <script inline="1">
      //<![CDATA[
      $(document).ready(function () {
      
       $("#rfidsearch").bind("submit", function (event) {
          $.ajax({
            async:true,
            data:$("#rfidsearch").serialize(),
            dataType:"html", 
            type:"POST", 
           url:"<?php echo ADMIN_URL ;?>students/searchrfidreport",
            beforeSend: function(){
          // Show image container
          $("#loader").show();
         },
            success:function (data) {
      		//  alert(data); 
      		  
       
              $("#updt").html(data); }, 
              complete:function(data){
          // Hide image container
          $("#loader").hide();
         },
        });
          return false;
      });
      });
      //]]>
   </script>
   <style>
      #loader {
      display: none;
      position: absolute;
      top: 5%;
      left: 45%;
      width: 200px;
      height: 200px;
      padding:30px 15px 0px;
      border: 3px solid #ababab;
      box-shadow:1px 1px 10px #ababab;
      border-radius:20px;
      background-color: white;
      z-index: 1002;
      text-align:center;
      overflow: auto;
      }
   </style>
   <div id="loader" >
      <img src="<?php echo SITE_URL; ?>img/loading-gif-loader-v4.gif" class="img-responsive" />
   </div>
   <?php echo $this->Form->create('Fees',array('type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'rfidsearch','class'=>'form-horizontal')); ?>
   <div class="form-group">
      <input type="hidden" name="acedmicyear" value="<? echo $acedmic; ?>">
      <div class="col-sm-2" >
         <script>
            $(document).ready(function(){		  
            			$('#fdatefrom').datepicker({    
            dateFormat: 'yy-mm-dd',
                   onSelect: function(date){ 
            
                   var selectedDate = new Date(date);
                   var endDate = new Date(selectedDate);
                    endDate.setDate(endDate.getDate());
                
                 $("#fendfrom").datepicker( "option", "minDate", endDate );
                  $("#fendfrom").val(date);
               }
                
               });
               $('#fdatefrom').datepicker('setDate', 'today');
               
            $('#fendfrom').datepicker({    
            dateFormat: 'yy-mm-dd'});
             $('#fendfrom').datepicker('setDate', 'today');
            		 });
            		   
         </script>	
         <label for="inputEmail3" class="control-label">Date From</label>
         <?php echo $this->Form->input('datefrom',array('class'=>'form-control','readonly','id'=>'fdatefrom','placeholder'=>'Date From','label' =>false)); ?>  
      </div>
      <div class="col-sm-2" >
         <label for="inputEmail3" class="control-label">Date To</label>
         <?php echo $this->Form->input('dateto',array('class'=>'form-control','readonly','id'=>'fendfrom','placeholder'=>'Date To','label' =>false)); ?>  
      </div>
   </div>
   <div class="form-group">  
      <input type="submit" id="YourbuttonId" style="background-color:#00c0ef;width:100px !important; margin-left: 10px;" class="btn btn4 btn_pdf myscl-btn date" value="Submit">  
      <button type="reset" style="background-color:#f4f4f4;width:100px !important; margin-left: 10px;" class="btn btn4 btn_pdf myscl-btn date">Reset</button>  
   </div>
   <?php 
      echo $this->Form->end();
      ?>     
   <!-- /.box-header -->
   <?php echo $this->Flash->render(); ?>
</div>
<div id="updt">
<div class="table-responsive">
<table id="" class="table table-bordered table-striped">
   <tbody>
      <tr>
      </tr>
      <tr>
         <th>No</th>
         <th>Sr.No</th>
         <th>Date</th>
         <th>Student Name</th>
         <th>Class</th>
         <th>Section</th>
         <th>Father's Name</th>
         <th>Mobile</th>
         <th> Machine Status</th>
      </tr>
      <?php 
         $page = $this->request->params['paging']['Services']['page'];
         $limit = $this->request->params['pagc_c_iding']['Services']['perPage'];
         $counter = 1;
         $total=0;
         $totalfee=0;
         $out=0;
         $total_discount=0;
         
         
         if(isset($studentrfidsd) && !empty($studentrfidsd)){ 
         
         
         foreach($studentrfidsd as $element) {
         
         if($element['class_id']){
         
         
         $s_id=$element['class_id'];
         $c_id=$element['section_id'];
         ?>
      <tr>
         <td><?php echo $counter;  ?></td>
         <td><?php echo $element['enroll'];  ?></td>
         <td><?php echo date('d-m-Y',strtotime($element['resultdate']));  ?></td>
         <td><?php   $studentname= $element['fname']." ".$element['middlename']." ".$element['lname']; echo $studentname; ?></td>
         <td><?php $class=$this->Comman->findclasses($s_id);
            echo $class[0]['title'];
            ?>    </td>
         <td><?php 
            $section=$this->Comman->findsections($c_id);
               echo $section[0]['title'];
            ?>    </td>
         <td><?php echo $element['fathername'];?></td>
         <td><?php echo $element['sms_mobile'];?></td>
         <td> <?  echo "Present";?></td>
      </tr>
      <?php $counter++;}}
         } else { ?>
      <td colspan="8" style="text-align:center;">No Present Data Available</td>
      <?	} ?>
</table>
<div>      
</div>