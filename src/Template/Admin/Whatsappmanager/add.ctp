<script>
$(document).ready(function() {
    $("#Mysubscriptions").bind("submit", function(event) {
        $('.lds-facebook').show();
        $.ajax({
            async: true,
            data: $("#Mysubscriptions").serialize(),
            dataType: "html",
            type: "POST",
            url: "<?php echo ADMIN_URL ;?>Whatsappmanager/search",
            success: function(data) {
                $('.lds-facebook').hide();
                $("#example2").html(data);
            },
        });
        return false;
    });
});
</script>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Whatsapp Manager
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="<?php echo SITE_URL; ?>admin/Whatsappmanager">Whatsapp Manager</a></li>
        </ol>
    </section>
    <!-- content header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header" style="padding-bottom:0px;">
                        <?php echo $this->Flash->render(); ?>
                        <?php echo $this->Form->create($sms_details, array(
                     'class'=>'form-horizontal',
                     'enctype' => 'multipart/form-data',
                     'controller' => 'Whatsappmanager',
                     'validate'
                     )); ?>
                        <div class="form-group" style="margin-bottom:0px;">
                            <div class="col-sm-4">
                                <label for="inputEmail3" class="control-label">School Name<strong
                                        style='color:red;'>*</strong></label>
                                <?php echo $this->Form->input('client_id', array('class' => 'form-control', 'type' => 'select', 'options'=>$franchise_schools,'label' => false, 'empty' => 'Select School', 'autofocus', 'autocomplete' => 'off')); ?>
                            </div>

                            <div class="col-sm-4">
                                <label for="inputEmail3" class="control-label">Purchase Date<strong
                                        style='color:red;'>*</strong></label>
                                <?php echo $this->Form->input('purchase_date', array('class' => 'form-control input1','label'=>false,'placeholder'=>'Purchase Date','id'=>'datepicker1','autocomplete'=>'off','readonly')); ?>
                            </div>

                            <div class="col-sm-4">
                                <label for="inputEmail3" class="control-label">Message Count<strong
                                        style='color:red;'>*</strong></label>
                                <?php echo $this->Form->input('message_count', array('class' => 'form-control', 'type' => 'number', 'required', 'label' => false, 'placeholder' => 'Enter Message Count', 'autofocus', 'autocomplete' => 'off')); ?>
                            </div>


                            <div class="col-sm-4 col-xs-6">
                                <label for="inputEmail3" class="control-label "
                                    style="display:block; text-align:left;">Mode Of Payment :</label>
                                <label class="radio-inline">
                                    <input type="radio" name="payment_mode" id="inlinefRadio2" value="Cash" checked>
                                    Cash
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="payment_mode" id="inlinefRadio1" value="Netbanking">
                                    Netbanking
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="payment_mode" id="inlinefRadio0"
                                        value="Credit Card / Debit card"> Credit Card / Debit Card
                                </label>
                            </div>
                            <div class="col-sm-4 col-xs-6" id="feerecivier" style="display:none;">
                                <label for="inputEmail3" class="control-label">Reference No.<span
                                        style="color:red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Reference No." name="reference_no"
                                    id="feesubmittedby">
                            </div>


                            <div class="col-sm-4">
                                <label for="inputEmail3" class="control-label">Amount<strong
                                        style='color:red;'>*</strong></label>
                                <?php echo $this->Form->input('amount', array('class' => 'form-control', 'type' => 'number', 'required', 'label' => false, 'placeholder' => 'Enter Amount ', 'autofocus', 'autocomplete' => 'off')); ?>
                            </div>

                            <div class="col-sm-12" style="margin-top:15px;">
                                <?php
                           if(isset($cat['id'])){
                             echo $this->Form->submit(
                               'Update', 
                               array('class' => 'btn btn-info pull-right', 'title' => 'Update')
                             ); }else{ 
                               echo $this->Form->submit(
                                 'Add', 
                                 array('class' => 'btn btn-info', 'title' => 'Add')
                               );
                             }
                           ?>
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>

                        <!-- /.box-header -->
                    </div>
                    <div class="box-body" id="example2" style="padding-top:0px;">
                        <div class="container-fluid">
                            <?php  echo $this->Form->create('Mysubscription',array('type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'Mysubscriptions','class'=>'form-horizontal')); ?>
                            <div class="form-group row"
                                style="display:flex; align-items: center; justify-content: flex-end">
                                <div class="col-md-3" style="text-align:right;">
                                    <label for="inputEmail3" class="control-label"
                                        style="text-align: right !important; padding-top:0px;">School Name</label>
                                </div>

                                <div class="col-md-3">
                                    <?php echo $this->Form->input('id', array('class' => 'form-control', 'type' => 'select', 'options'=>$franchise_schools,'label' => false, 'empty' => 'Select School', 'autofocus', 'autocomplete' => 'off')); ?>
                                </div>

                                <input type="submit" style="background-color:#00c0ef; color:#fff;" id="Mysubscriptions"
                                    class="btn btn4 btn_pdf myscl-btn date" value="Search">
                            </div>
                        </div>
                        <table id="example14" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="4%">S.No.</th>
                                    <th width="16%">School Name</th>
                                    <th width="16%">Purchase Date</th>
                                    <th width="16%">Amount</th>
                                    <th width="16%">Message Count</th>
                                    <th width="16%">Payment Mode</th>
                                    <th width="8%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $page = $this->request->params['paging']['']['page'];
                           $limit = $this->request->params['paging']['']['perPage'];
                           $counter = ($page * $limit) - $limit + 1;
                           if(isset($users) && !empty($users)){ 
                               foreach($users as $intusr){ //pr($intusr); die;
                           ?>
                                <tr>
                                    <td><?php echo $counter;?></td>
                                    <td><?php echo $intusr['school']['school_name'];?></td>
                                    <td><?php echo date('d-m-Y',strtotime($intusr['purchase_date']));?></td>
                                    <td><?php echo $intusr['amount'];?></td>
                                    <td><?php echo $intusr['message_count'];?></td>
                                    <td><?php echo $intusr['payment_mode'];?></td>

                                    <td>
                                        <?php /*
                              <strong>
                                 <?php
                                    echo $this->Html->link('', [
                                    'action' => 'edit',
                                    $intusr->id,
                                    ], ['class' => 'glyphicon glyphicon-edit', 'style' => '']);
                                    ?>
                                        <!-- status  -->
                                        <?php if($intusr['status']=='Y'){ 
                                    echo $this->Html->link('', [
                                        'action' => 'status',
                                        $intusr->id,'Y'
                                    ],['title'=>'Active','class'=>'fa fa-check-circle','style'=>'color: #36cb3c;']);
                                    }else{ 
                                    echo $this->Html->link('', [
                                        'action' => 'status',$intusr->id,'N'
                                    ],['title'=>'Inactive','class'=>'fa fa-times-circle-o','style'=>'color:#FF5722;']);
                                    } ?>
                                        <!-- status end -->
                                        */?>
                                        <?php
                                    echo $this->Html->link('', [
                                    'action' => 'delete',
                                    $intusr->id
                                    ],['class'=> 'fa fa-trash fa-2px','style'=>''	
                                    ,"onClick"=>"javascript: return confirm('Are you sure do you want to delete this  Record')"]); ?>
                                        </strong>
                                    </td>

                                </tr>
                                <?php $counter++; } }else{ ?>
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
<!-- content-wrapper -->
<div class="modal fade" id="globalModalbag" style="width:51% !important;" tabindex="-1" role="dialog"
    aria-labelledby="esModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:100% !important;">
        <div class="modal-content personal">
            <div class="modal-body">
                <div class="col-sm-6 col-md-6 col-sm-offset-2 col-md-offset-2">
                </div>
                <div class="loader">
                    <div class="es-spinner">
                        <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script>
$(function() {
    var dateFormat = 'dd-mm-yy',
        from = $("#datepicker1")
        .datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            numberOfMonths: 1
        })
        .on("change", function() {
            to.datepicker("option", "minDate", getDate(this));
        }),
        to = $("#datepicker2").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            numberOfMonths: 1
        })
        .on("change", function() {
            from.datepicker("option", "maxDate", getDate(this));
        });

    function getDate(element) {
        var date;
        try {
            date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
            date = null;
        }
        return date;
    }
});
</script>

<script language="javascript" type="text/javascript">
$(document).ready(function(e) {
    $("#inlinefRadio0").click(function() {
        if ($(this).val() == 'Credit Card / Debit card') {
            $("#feerecivier").show();
            $('#feesubmittedby').prop('required', true);
        }
    });
    $("#inlinefRadio1").click(function() {
        if ($(this).val() == 'Netbanking') {
            $('#feesubmittedby').prop('required', true);
            $("#feerecivier").show();
        }
    });
    $("#inlinefRadio2").click(function() {
        if ($(this).val() == 'Cash') {
            $('#feesubmittedby').prop('required', false);
            $("#feerecivier").hide();

        }
    });

});
</script>