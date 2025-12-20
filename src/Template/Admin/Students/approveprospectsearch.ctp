<div class="box-body">
   <table id="example1" class="table table-bordered table-striped">
      <thead>
         <tr>
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
            if(isset($t_enquiry) && !empty($t_enquiry)){ 
            foreach($t_enquiry as $service){ // pr($service);
            ?>
         <tr>
            <td><?php echo $counter;?></td>
            <td><?php if(isset($service['id'])){ echo $service['sno'];}else{ echo 'N/A'; } ?></td>
            <td><?php if(isset($service['enquire']['s_name'])){ echo ucfirst($service['enquire']['s_name']);}else{ echo 'N/A'; } ?></td>
            <td><?php if(isset($service['enquire']['mobile'])){ echo ucfirst($service['enquire']['mobile']);}else{ echo 'N/A'; } ?></td>
            <?php $cls=$this->Comman->showclasstitle($service['class_id']);  ?>
            <td><?php if(isset($cls['title'])){ echo ucfirst($cls['title']);}else{ echo 'N/A'; } ?></td>
            <?php $bls=$this->Comman->showboardtitle($service['enquire']['mode1_id']);  ?>
            <td><?php if(isset($bls['name'])){ echo ucfirst($bls['name']);}else{ echo 'N/A'; } ?></td>
            <td style="color:green;" ><?php if($service['status']){ echo "Approved";}else{ echo 'N/A'; } ?></td>
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