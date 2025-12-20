<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Qtr-wise Students Fee Report
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <style>
                    #loader {
                        display: none;
                        position: absolute;
                        top: 0%;
                        left: 45%;
                        width: 200px;
                        height: 200px;
                        padding: 30px 15px 0px;
                        border: 3px solid #ababab;
                        box-shadow: 1px 1px 10px #ababab;
                        border-radius: 20px;
                        background-color: white;
                        z-index: 1002;
                        text-align: center;
                        overflow: auto;
                    }
                </style>
                <div id="loader">
                    <img src="<?php echo SITE_URL; ?>img/loading-gif-loader-v4.gif" class="img-responsive" />
                </div>
                <div class="box">
                    <?php echo $this->Flash->render(); ?>
                    <div class="box-header">
                        <script inline="1">
                            //<![CDATA[
                            $(document).ready(function() {
                                $("#feesexl").bind("submit", function(event) {
                                    $.ajax({
                                        async: true,
                                        data: $("#feesexl").serialize(),
                                        dataType: "html",
                                        type: "POST",
                                        url: "<?php echo ADMIN_URL; ?>Feesreport/defaultersearch",
                                        beforeSend: function() {
                                            // Show image container
                                            $("#loader").show();
                                        },
                                        success: function(data) {
                                            $("#updt").html(data);
                                        },
                                        complete: function(data) {
                                            // Hide image container
                                            $("#loader").hide();
                                        },
                                    });
                                    return false;
                                });
                            });
                            //]]>
                        </script>
                        <?php echo $this->Form->create('Fees', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'feesexl', 'class' => 'form-horizontal')); ?>
                        <div class="form-group student_all_fgroup">
                            <input type="hidden" name="acedmicyear" value="<? echo $academicyear; ?>">
                            <div class="col-sm-4">
                                <label>Acedamic Year<span style="color:red;">*</span></label>
                                <select class="form-control" name="acedmicyear" required="required">
                                    <option selected="" value="<?php echo $academicyear; ?>"><?php echo $academicyear; ?></option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="inputEmail3" class="control-label">Select Class</label>
                                <select class="form-control" name="class_id[]" required="required" multiple="multiple">
                                    <?php foreach ($classes as $esr => $es) { ?>
                                        <option value="<?php echo $esr; ?>" selected="selected"><?php echo $es; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="inputEmail3" class="control-label">Select Section</label>
                                <select class="form-control" name="section_id[]" required="required" multiple="multiple">
                                    <?php foreach ($sectionslist as $esr => $es) { ?>
                                        <option value="<?php echo $esr; ?>" selected="selected"><?php echo $es; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-2s col-sm-4">
                                <label for="inputEmail3" class="control-label">Quater(Tuition Fee)<span style="color:red;">*</span></label>
                                <?php $quat = array('Quater1' => 'Quater1', 'Quater2' => 'Quater2', 'Quater3' => 'Quater3', 'Quater4' => 'Quater4');
                                // echo $this->Form->input('quarter', array('class' => 'form-control', 'required' => 'required', 'options' => $quat, 'empty' => 'Select Quater', 'label' => false)); 
                                ?>
                                <select class="form-control" name="quater[]" required="required" multiple="multiple">
                                    <?php foreach ($quat as $esr => $es) { ?>
                                        <option value="<?php echo $esr; ?>" selected="selected"><?php echo $es; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-8" style="margin-top:20px;display: flex; justify-content: space-between; align-items: center;">

                                <input type="submit" style="background-color:#00c0ef;color:#fff;width:100px !important; margin-left: 50px;" class="btn btn4 btn_pdf myscl-btn date" value="Submit">

                                <a class="btn btn-info btn-sm pull-right" href="<?php echo ADMIN_URL; ?>Feesreport/feesexcelreport"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Excel</a>
                            </div>

                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>

                <div id="updt">

                </div>

                <div class="box-body" style="display:none;">

                    <script type="text/javascript">
                        $("#checkall").change(function() {
                            var checked = $(this).is(':checked');
                            if (checked) {
                                $(".checkbox").each(function() {
                                    $(this).prop("checked", true);
                                });
                            } else {
                                $(".checkbox").each(function() {
                                    $(this).prop("checked", false);
                                });
                            }
                        });
                    </script>


                </div>
            </div>
        </div>
</div>
</section>
</div>
<!-- /.content-wrapper -->