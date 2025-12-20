<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Student Fee Details
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="#">Student Fee Details</a> </li>
        </ol>
    </section>
    <!-- content header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <?php echo $this->Flash->render(); ?>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $("#Mysubscriptions").bind("submit", function(event) {
                                $('.lds-facebook').show();
                                $.ajax({
                                    async: true,
                                    data: $("#Mysubscriptions").serialize(),
                                    dataType: "html",
                                    type: "POST",
                                    url: "<?php echo ADMIN_URL; ?>studentfees/searchreq",
                                    success: function(data) {
                                        $('.lds-facebook').hide();
                                        $("#example2").html(data);
                                    },
                                });
                                return false;
                            });
                        });
                    </script>

                    <?php echo $this->Form->create('Mysubscription', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'Mysubscriptions', 'class' => 'form-horizontal')); ?>
                    <div class="" style="padding-bottom:10px; padding-left:15px; padding-right:15px; display:flex; align-items:center; justify-content:space-start;">

                        <div style="margin-right:20px">
                            <label for="inputEmail3" class="ontrol-label" style="text-align: left !important;">Student Name:<label>
                        </div>

                        <div style="margin-right:30px; width: 200px;">
                            <input type="hidden" name="stu_id" id="retail_id" value="id">
                            <?php echo $this->Form->input('name', array('class' => 'form-control secrh-students stu_name', 'type' => 'text', 'label' => false, 'autofocus', 'autocomplete' => 'off', 'placeholder' => 'Enter Student Name', 'required')); ?>
                            <div id="test" style="display:none;">
                                <ul></ul>
                            </div>
                        </div>

                        <div style="margin-right:20px">
                            <label for="inputEmail3" class="ontrol-label" style="text-align: left !important;">Acedmic Year:<label>
                        </div>

                        <div style="margin-right:30px; width: 200px;">
                            <select class="form-control" name="acedmicyear" required="required">
                                <?php
                                $current_year = date('Y');
                                for ($i = 0; $i < 3; $i++) {
                                    $selected = ($i == 0) ? 'selected' : ''; // Set the current year as selected by default
                                    $start_year = $current_year - $i;
                                    $end_year = $start_year + 1;
                                    $year_range = $start_year . '-' . substr($end_year, 2);  // Format the year range
                                ?>
                                    <option value="<?php echo $year_range; ?>" <?php echo $selected; ?>><?php echo $year_range; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>


                        <div class="" style="text-align:right">
                            <input type="submit" style="background-color:#00c0ef;" id="Mysubscriptions" class="btn btn4 btn_pdf myscl-btn date" style="margin-left:auto;" value="Search">
                        </div>
                    </div>
                </div>
                <div class="box-body" id="example2">

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
<!-- /.   content-wrapper -->
<style>
    #test {
        position: relative;
    }

    #test ul {
        position: absolute;
        z-index: 999;
        overflow: scroll;
        height: 100px;
        top: 100%;
        left: 0px;
        right: 0px;
        list-style-type: none;
        background-color: white;
        padding-left: 0px;
    }

    #test ul li {
        padding: 5px 8px;
        border: 1px solid lightgray;
    }

    #test ul li a {
        color: black;
    }

    .preview {
        margin-right: 15px;
    }

    .dataTables_wrapper.form-inline.dt-bootstrap.no-footer {
        margin-top: 0px;
    }
</style>


<script>
    function cllbckretail0(id, cid, sid) {
        $('.secrh-students').val(id);
        $('#retail_id').val(cid);
        $('#test').hide();
    }
    $(function() {
        $('.secrh-students').bind('keyup', function() {
            var pos = $(this).val();
            //alert(pos);
            var check = 0;
            //var catid=$('#subcategory').val();
            //alert(pos);
            $('#test').show();
            $('#retail_id').val('');
            var count = pos.length;
            if (count > 0) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo ADMIN_URL; ?>Solditems/getstudentname',
                    data: {
                        'fetch': pos,
                        'check': check,

                    },
                    success: function(data) {
                        /// alert(data);
                        console.log(data);
                        $('#test ul').html(data);
                    },
                });
            } else {
                $('#test').hide();
            }
        });
    });
</script>