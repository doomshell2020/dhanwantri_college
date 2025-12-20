<head>

  <style>
    .ui-autocomplete {
      max-height: 100px;
      overflow-y: auto;
      /* prevent horizontal scrollbar */
      overflow-x: hidden;
    }
    
    /* IE 6 doesn't support max-height
     * we use height instead, but this forces the menu to always be this tall
     */
     * html .ui-autocomplete {
      height: 100px;
     }
  </style>

</head>

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">

  <section class="content-header">
    <h1>
      Fine Manager
    </h1>
       <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>Fines/index">Manage Fine </a></li>
	      </ol>
  </section>

  <!-- Main content -->
  <section class="content">
   <div class="row">
    <div class="col-xs-12">

     <div class="box">
      <div class="box-header">
       <?php echo $this->Flash->render(); ?>


       <h3 class="box-title"><i class="fa fa-plus-square"></i> Take Fine</h3>
     </div>
     <!-- /.box-header -->

     <div class="box-body">


      <div class="manag-stu">

      <?php echo $this->Form->create($fine, array('class'=>'form-horizontal')); ?>

        <div class="form-group">

          <div class="col-sm-4">
            <label>Holder Type<span><font color="red"> *</font></span></label>
            <?php
            echo $this->Form->input('holder_type_id', array('class'=>'form-control fine-amnt','type'=>'select', 'empty'=>'Select Holder Type',
              'options'=>$holder_type, 'label' =>false));
            ?>
          </div>

         <div class="col-sm-4">
           <label>Holder Name<span><font color="red"> *</font></span></label>
           <?php echo $this->Form->input('holder_name',array('class'=>'form-control fine-amnt','placeholder'=>'Enter Name/ID', 'id'=>'tags','label' =>false)); ?>
         </div>

         <div class="col-sm-4">
          <label>ASN No.<span><font color="red"> *</font></span></label>
          <?php echo $this->Form->input('asn_no', array('class'=>'form-control fine-amnt', 'type'=>'select', 'empty'=>'Select ASN No.', 'label' =>false)); ?>
        </div>

      </div>

      <div class="form-group">

        <div class="col-sm-4">
          <label>Fine Type<span><font color="red"> *</font></span></label>
          <?php echo $this->Form->input('fine_type', array('class'=>'form-control', 'type'=>'select', 'empty'=>'Select Fine Type',
            'options'=>$fine_type, 'label' =>false)); ?>
        </div>

        <div class="col-sm-4">
          <label>Amount<span><font color="red"> *</font></span></label>
          <?php echo $this->Form->input('amount',array('class'=>'form-control', 'label' =>false, 'readonly')); ?>
        </div>

        <div class="col-sm-4">
          <label>Remarks</label>
          <?php echo $this->Form->textarea('remarks', array('rows'=>'2', 'class'=>'form-control', 'label' =>false)); ?>
        </div>   

      </div>


      <div class="form-group">

        <div class="col-sm-12">   

          <?php
          if( isset( $fine[id] ) && !empty( $fine[id] ) )
          {
            echo '<button type="submit" name="button" value="update" class="btn btn-success">Update</button> ';

            echo $this->Html->link(
              'Cancel',
              ['action' => 'index'],
              ['class'=>'btn btn-primary']
              );
          }
          else
          {
            echo '<button type="submit" class="btn btn-success">Take Fine</button> ';
            echo '<button type="reset" class="btn btn-primary">Reset</button>';
          }
          ?>

        </div>

      </div>

      <?php echo $this->Form->end(); ?>   

    </div>

  </div>

</div>	</div>	</div>
<div class="row">
  <div class="col-xs-12">

   <div class="box">
    <div class="box-header">
      <h3 class="box-title">
        <i class="fa fa-search"></i> View Fine Details
      </h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Holder Name</th>
            <th>Holder Type</th>
            <th>Amount</th>
            <th>Remarks</th>
            <th>Status</th>
            <th>Action</th>	
          </tr>
        </thead>
        <tbody>
          <?php $page = $this->request->params['paging']['fines']['page'];
          $limit = $this->request->params['paging']['fines']['perPage'];
          $counter = ($page * $limit) - $limit + 1;
          
          if(isset($fines) && !empty($fines)){ 
            foreach($fines as $work){
              //pr($work);die;
              ?>
              <tr>
                <td><?php echo $counter;?></td>

                <td><?php if(isset($work['holder_name'])){ echo ucfirst($work['holder_name']);}else{ echo 'N/A';}?></td>

                <td><?php if(isset($work['holder_type_id'])){ echo ucfirst($work['holder_type_id']);}else{ echo 'N/A';}?></td>

                <td>
                  <?php if(isset($work['amount'])){ echo ucfirst($work['amount']);}else{ echo '<font color="red"><i><small>(not set)</small></i></font>'; } ?>
                </td>

                <td><?php if(isset($work['remarks'])){ echo ucfirst($work['remarks']);}else{ echo 'N/A';}?></td>

                <td><?php if($work['status']=='Y'){ 
                   echo $this->Html->link('Activate',[
                     'action' => 'status',
                     $work->id,
                     $work['status']  
                     ],['class'=>'label label-success']);

                   }else{ 
                    echo $this->Html->link('Deactivate', [
                     'action' => 'status',
                     $work->id,
                     $work['status']
                     ],['class'=>'label label-primary']);

                   } ?>
                </td>

                <td>
                  <!-- <?php
                   echo $this->Html->link('Edit', [
                     'action' => 'index',
                     $work->id
                     ],['class'=>'btn btn-primary']); ?> -->

                 <?php
                 echo $this->Html->link('View', [
                   'action' => 'view',
                   $work->id
                   ],['class'=>'btn btn-success']); ?>
                   
                 <?php
                 echo $this->Html->link('Delete', [
                   'action' => 'delete',
                   $work->id
                   ],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure you want to delete this?')"]); ?>
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

<script>

$(document).ready(function () {

  $('#holder-type-id').on('change', function(){ 

    $("#tags").val('');
    $("#asn-no").html('<option value="">Select ASN No.</option>');

    var h_type = $('#holder-type-id').val();
    //alert(h_type);
    $.ajax({

      type: 'POST', 

      url: '<?php echo ADMIN_URL;?>Fines/autocompleteList',

      data: {'h_type':h_type}, 

      dataType: "json",

      success: function(data){ 
        alert(data);
        $( "#tags" ).autocomplete({
          
          source: data,

          change: function( event, ui ) {
            val = $(this).val();
            exists = $.inArray(val,data);
            if (exists<0) {
              $(this).val("");
              return false;
            }
          }
          
        });
      }

    });

  });

  //-------------------------------------------------------------

  $('#tags').bind({

    blur: function(){

    var h_type = $('#holder-type-id').val();
    var h_name = $('#tags').val();
      //alert(h_type);
      $.ajax({

        type: 'POST', 

        url: '<?php echo ADMIN_URL;?>Fines/asnNoList',

        data: {'h_type':h_type, 'h_name':h_name},

        success: function(data){ 
          // alert(data);
          // $("#asn-no").empty();
          $("#asn-no").html(data);
        }

      });

    }
    // ,

    // blur: function(){
    //   alert('element blur...');
    // }

  });

});

</script>


<script>

$(document).ready(function () {

  $('.fine-amnt').on('change', function(){

    $("#fine-type").val('');
    $("#amount").val('');

  });

  //--------------------------------------------

  $('#fine-type').on('change', function(){

    var fine_type = $('#fine-type').val();
    var asn_no = $('#asn-no').val();

    if( fine_type != '' && asn_no != '' )
    {
        $.ajax({

        type: 'POST', 

        url: '<?php echo ADMIN_URL;?>Fines/calculateFine',

        data: {'fine_type':fine_type, 'asn_no':asn_no},

        success: function(data){ 
          //alert(data);
          $("#amount").val(data);
        }

      });  
    }
    else
    {
      $("#amount").val('');
    }

  });

});

</script>
