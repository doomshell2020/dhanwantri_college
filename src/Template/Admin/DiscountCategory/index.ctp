<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="min-height:0px !important;">
   <section class="content-header">
      <h1>
         Discount Scheme Manager
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
         <li><a href="<?php echo ADMIN_URL;?>Documentcategory/index">Manage Discount Category</a></li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <div class="box">
               <div class="box-header">
                  <?php echo $this->Flash->render(); ?>
                  <?  if($department['id']) { ?>
                  <h3 class="box-title">Edit Discount Scheme</h3>
                  <a class="pull-right"  style="font-size:17px;" href="<? echo ADMIN_URL; ?>DiscountCategory/index" ><i class="fa fa-plus-circle"></i> Add</a>
                  <? }else{ ?>
                  <h3 class="box-title">Add Discount Scheme</h3>
                  <? } ?>  
               </div>
               <!-- /.box-header -->
               <div class="box-body discount_scm_mngerdv">
                  <div class="manag-stu ">
                     <?php echo $this->Form->create('DiscountCategory',array('url'=>array('controller'=>'DiscountCategory','action'=>'index'),'type'=>'file','class'=>'form-horizontal','style'=>'position: relative;')); ?>
                     <div class="form-group ">
                        <script>
                           $(document).ready(function(){ 
                           
                           	
                                 $(".add_field_butto").click(function(){ 	
                             $('.after-add-more').append('<div class="assets_container asset2"> <div class="form-group"><div class="col-sm-3"><label>Fee Heads<span>*</span></label><div class="input select"><select name="fh_id[]" class="form-control" id="title" required="required"><option value="">-Select-</option> <? foreach($feeheads as $j=>$hh) { ?> <option value="<? echo $j; ?>"><? echo $hh; ?></option>  <? } ?></select></div>    </div><div class="col-sm-3"><label>Discount (%)<span>*</span></label><div class="input text"><input name="discount[]" class="form-control" placeholder="Discount in %" id="title" maxlength="3" required="required" type="text"></div></div><div class="col-sm-3"><label>Discount (In Amount)<span>*</span></label>   <div class="input text"><input name="discountamt[]" class="form-control" placeholder="Discount in Amount" id="title" maxlength="9" required="required" type="text"></div>   </div>    <div class="col-sm-2" style="position:relative;"><a href="javascript:void(0);" class="remove" style="font-weight: bold; font-size: 21px;margin-top: 23px;position: absolute;"><i class="fa fa-minus-circle"></i></a>  </div> </div></div> ');
                                 
                             });
                             
                              $("body").on("click",".remove",function(){ 
                                $(this).closest('.assets_container').remove();
                               });
                               
                               });  
                                 
                        </script>
                        <div class="col-sm-3">
                           <label>Scheme Name<span>*</span></label>
                           <?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'Scheme Name', 'value'=>$department['name'],'id'=>'title','label' =>false,'required')); ?>
                        </div>
                     </div>
                     <?  if($department['id']) { ?><input type="hidden" name="id" value="<? echo $department['id']; ?>">
                     <? 
                        $feeheadsh=unserialize($department['fh_id']);  $i=1;
                        
                         $discount=unserialize($department['discount']);
                         
                         if($discount!='0'){
                         
                         foreach($feeheadsh as $j=>$yu){
                         
                        
                          ?>
                     <div class="assets_container<? echo $i; ?> asset2">
                        <div class="form-group" style="display:flex; align-items:flex-end">
                           <div class="col-sm-3">
                              <label>Fee Heads<span>*</span></label>
                              <?php  echo $this->Form->input('fh_id[]',array('class'=>'form-control','empty'=>'-Select-','value'=>$j,'options'=>$feeheads,'label' =>false,'required')); ?>
                           </div>
                           <div class="col-sm-3">
                              <label>Discount (%)<span>*</span></label>
                              <?php echo $this->Form->input('discount[]',array('class'=>'form-control','placeholder'=>'Discount in %', 'value'=>$yu,'maxlength'=>'3','id'=>'title','label' =>false,'required')); ?>
                           </div>
                           <div class="col-sm-3">
                              <? 
                                 foreach($discount as $gg=>$hh){ if($gg==$j){ ?>
                              <label>Discount (In Amount)<span>*</span></label>
                              <?php echo $this->Form->input('discountamt[]',array('class'=>'form-control','placeholder'=>'Discount in Amount', 'value'=>$hh,'maxlength'=>'9','id'=>'title','label' =>false,'required')); ?>
                              <?   } } ?>
                           </div>
                           <? if($i=='1'){ ?>
                           <div class="col-sm-2" class="subtype" style="position:relative;" >
                              <label></label>
                              <a href="javascript:void(0);" class="add_field_butto" style="font-weight: bold; font-size: 21px;"><i class="fa fa-plus-circle"></i></a> 
                           </div>
                           <? }else{  ?>
                           <div class="col-sm-2" ><a href="javascript:void(0);" class="remove<? echo $i; ?>" style="font-weight: bold; font-size: 21px;"><i class="fa fa-minus-circle"></i></a>  </div>
                           <script>
                              $("body").on("click",".remove<? echo $i; ?>",function(){ 
                                $(this).closest('.assets_container<? echo $i; ?>').remove();
                               });
                              
                           </script>
                           <? } ?> 
                        </div>
                     </div>
                     <? $i++;
                        }  }else{  
                         foreach($feeheadsh as $j=>$yu){
                            ?>
                     <div class="assets_container<? echo $i; ?> asset2">
                        <div class="form-group" style="display:flex; align-items:flex-end">
                           <div class="col-sm-3">
                              <label>Fee Heads<span>*</span></label>
                              <?php  echo $this->Form->input('fh_id[]',array('class'=>'form-control','empty'=>'-Select-','value'=>$j,'options'=>$feeheads,'label' =>false,'required')); ?>
                           </div>
                           <div class="col-sm-3">
                              <label>Discount (%)<span>*</span></label>
                              <?php echo $this->Form->input('discount[]',array('class'=>'form-control','placeholder'=>'Discount in %', 'value'=>$yu,'maxlength'=>'3','id'=>'title','label' =>false,'required')); ?>
                           </div>
                           <div class="col-sm-3">
                              <label>Discount (In Amount)<span>*</span></label>
                              <?php echo $this->Form->input('discountamt[]',array('class'=>'form-control','placeholder'=>'Discount in Amount', 'value'=>'0','maxlength'=>'9','id'=>'title','label' =>false,'required')); ?>
                           </div>
                           <? if($i=='1'){ ?>
                           <div class="col-sm-2" class="subtype" style="position:relative;" >
                              <label></label>
                              <a href="javascript:void(0);" class="add_field_butto" style="font-weight: bold; font-size: 21px;"><i class="fa fa-plus-circle"></i></a> 
                           </div>
                           <? }else{  ?>
                           <div class="col-sm-2" ><a href="javascript:void(0);" class="remove<? echo $i; ?>" style="font-weight: bold; font-size: 21px;"><i class="fa fa-minus-circle"></i></a>  </div>
                           <script>
                              $("body").on("click",".remove<? echo $i; ?>",function(){ 
                                $(this).closest('.assets_container<? echo $i; ?>').remove();
                               });
                              
                           </script>
                           <? } ?> 
                        </div>
                     </div>
                     <? $i++;
                        }
                        }   }else{ 
                          ?>
                     <div class="assets_container asset2">
                        <div class="form-group" style="display:flex; align-items:flex-end">
                           <div class="col-sm-3">
                              <label>Fee Heads<span>*</span></label>
                              <?php  echo $this->Form->input('fh_id[]',array('class'=>'form-control','empty'=>'-Select-','options'=>$feeheads,'label' =>false,'required')); ?>
                           </div>
                           <div class="col-sm-3">
                              <label>Discount (%)<span>*</span></label>
                              <?php echo $this->Form->input('discount[]',array('class'=>'form-control','placeholder'=>'Discount in %','maxlength'=>'3','id'=>'title','label' =>false,'required')); ?>
                           </div>
                           <div class="col-sm-3">
                              <label>Discount (In Amount)<span>*</span></label>
                              <?php echo $this->Form->input('discountamt[]',array('class'=>'form-control','placeholder'=>'Discount in Amount','maxlength'=>'9','id'=>'title','label' =>false,'required')); ?>
                           </div>
                           <div class="col-sm-2" class="subtype" style="position:relative;">
                              <label></label>
                              <a href="javascript:void(0);" class="add_field_butto" style="font-weight: bold; font-size: 21px;"><i class="fa fa-plus-circle"></i></a> 
                           </div>
                        </div>
                     </div>
                     <?   } ?>
                     <div class="after-add-more" id="test">
                     </div>
                     <div class="col-sm-12"  style="position: absolute; width: max-content; right: 0px; bottom: 0px;">
                        <?php
                           if(isset($department['id'])){
                           echo $this->Form->submit(
                               'Update', 
                               array('class' => 'btn btn-info pull-right', 'title' => 'Update')
                           ); }else{ 
                           echo $this->Form->submit(
                               'Add', 
                               array('class' => 'btn btn-info pull-right', 'title' => 'Add')
                           );
                           }
                                ?>    
                     </div>
                  </div>
                  <?php
                     echo $this->Form->end();
                     ?>   
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12">
            <div class="box discount_scmtbl">
               <div class="box-header">
                  <h3 class="box-title">Discount Scheme List</h3>
                  <b class="pull-right" style="
                     margin-right: 33px;
                     "> Discounted Student:- <a target="_blank" href="<?php echo SITE_URL ?>admin/DiscountCategory/getdetails"><?php echo $count; ?></a></b>&nbsp;&nbsp;&nbsp;&nbsp;
                  <b class="pull-right" style="
                     margin-right: 41px;
                     "> Total Student:- <?php echo $student; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;
               </div>
               <!-- /.box-header -->
               <div class="box-body ">
                  <div class="table-responsive">
                     <table id="example1" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>Fee Heads</th>
                              <th>Discount %</th>
                              <th>Discount (In Amount)</th>
                              <th>Student</th>
                              <!-- <th>Action</th> -->
                           </tr>
                        </thead>
                        <tbody>
                           <?php $page = $this->request->params['paging']['classes']['page'];
                              $limit = $this->request->params['paging']['classes']['perPage'];
                              $counter = ($page * $limit) - $limit + 1;
                              if(isset($classes) && !empty($classes)){ 
                              foreach($classes as $work){
                              // pr($work);die;
                              ?>
                           <tr>
                              <td><?php echo $counter;?></td>
                              <td><?php if(isset($work['name'])){ echo ucfirst($work['name']);}else{ echo 'N/A';}?></td>
                              <td><?php if(isset($work['fh_id'])){ $whid=unserialize($work['fh_id']); // pr($whid);
                                 foreach ($whid as $h=>$dd){
                                    $findfeeheads=$this->Comman->findfeeheadsname($h); 
                                    // pr($findfeeheads);die;
                                 echo $findfeeheads['name']."<br>";
                                 }
                                 }else{ echo 'N/A';}    
                                  
                                  ?></td>
                              <td><?php if(isset($work['fh_id'])){ $whid=unserialize($work['fh_id']); // pr($whid);
                                 foreach ($whid as $h=>$dd){
                                 $findfeeheads=$this->Comman->findfeeheadsname($h); 
                                 echo $dd."% <br>";
                                 }
                                 }else{ echo 'N/A';}    
                                  
                                  ?></td>
                              <td><?php if(isset($work['discount']) && !empty($work['discount'])){ $swhid=unserialize($work['discount']); // pr($whid);
                                 foreach ($swhid as $hs=>$dds){
                                 
                                 echo $dds." <br>";
                                 }
                                 }else{ echo 'N/A';}    
                                 
                                  ?></td>
                              <td> <?php $findfeeheads = $this->Comman->feesallocationcounts($work['name']); ?> <a target="_blank" href="<?php echo SITE_URL ?>admin/DiscountCategory/getdetails/<?php echo str_replace("%","",$work['name']);  ?>"><?php echo count($findfeeheads);  ?></a> </td>
                              <!-- <td><?php
                                 //echo $this->Html->link('Edit', [
                                  //   'action' => 'index',
                                  //   $work->id
                                 //],['class'=>'btn btn-primary']); ?>
                                 <?php
                                    //echo $this->Html->link('Delete', [ 'action' => 'delete', $work->id],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]); ?>
                              </td> -->
                           </tr>
                           <?php $counter++;} }else{?>
                           <tr>
                              <td>NO Data Available</td>
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
<!-- /.content-wrapper -->