<?php echo $this->Form->create('Interaction',array('url'=>array('controller'=>'Students','action'=>'prosapproval'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'stud-attendance-form','class'=>'')); ?> 
<div class="form-group">
   <div class="col-sm-4">
      <input type="submit" style="background-color:red;width:100px !important; margin-left: 10px;" class="btn btn4 btn_pdf myscl-btn date inv" name="Approve" value="Approve">
   </div>
</div>
<div style="clear: both;"></div>
<div class="box-body">
   <table id="example1" class="table table-bordered table-striped">
      <thead>
         <tr>
            <th><input type="checkbox" id='checkall' /> Select All</th>
            <th>#</th>
            <th>Form No.</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Class</th>
            <th>Board</th>
            <th>Status</th>
         </tr>
      </thead>
      <tbody id="example22">
         <?php $page = $this->request->params['paging']['Services']['page'];
            $limit = $this->request->params['paging']['Services']['perPage'];
            $counter = ($page * $limit) - $limit + 1;
            if(isset($rej_appli) && !empty($rej_appli)){ 
            foreach($rej_appli as $service){ // pr($service);
            ?>
         <tr>
            <td><input  type="checkbox" class='checkbox'  name="p_id[]" value=<?php echo $service['enquire']['id']; ?> /> </td>
            <td><?php echo $counter;?></td>
            <td><?php if(isset($service['id'])){ echo $service['sno'];}else{ echo 'N/A'; } ?></td>
            <td><?php if(isset($service['enquire']['s_name'])){ echo ucfirst($service['enquire']['s_name']);}else{ echo 'N/A'; } ?></td>
            <td><?php if(isset($service['enquire']['mobile'])){ echo ucfirst($service['enquire']['mobile']);}else{ echo 'N/A'; } ?></td>
            <?php $cls=$this->Comman->showclasstitle($service['class_id']); //pr($cls); ?>
            <td><?php if(isset($cls['title'])){ echo ucfirst($cls['title']);}else{ echo 'N/A'; } ?></td>
            <?php $bls=$this->Comman->showboardtitle($service['enquire']['mode1_id']); //pr($cls); ?>
            <td><?php if(isset($bls['name'])){ echo ucfirst($bls['name']);}else{ echo 'N/A'; } ?></td>
            <td style="color:red;" ><?php if($service['status_r']){ echo "Rejected";}else{ echo 'N/A'; } ?></td>
         </tr>
         <?php $counter++;} }else{?>
         <tr>
            <td>NO Data Available</td>
         </tr>
         <?php } ?>  
         <script type='text/javascript'>
            // Changing state of CheckAll checkbox 
            $(".checkbox").click(function(){
            
              if($(".checkbox").length == $(".checkbox:checked").length) {
                $("#checkall").prop("checked", true);
              } else {
                $("#checkall").removeAttr("checked");
              }
            
            });
            
         </script>      
      </tbody>
   </table>
</div>
<?php echo $this->Form->end(); ?>