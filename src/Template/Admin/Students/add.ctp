<style type="text/css">
    ul#myUL {
        padding-left: 0px;
        background-color: #fefe;
        position: absolute;
        left: 0px;
        right: 0px;
        top: 100%;
        z-index: 999;
        height: 100px;
        overflow: scroll;
    }

    ul#myUL li {
        list-style: none;
    }

    ul#myUL li a {
        display: block;
        padding: 5px 12px;
    }

    .fieldset {
        border: solid 1px #000;
        padding: 10px;
        display: block;
        clear: both;
        margin: 5px 0px;
    }

    legend {
        padding: 0px 10px;
        background: #3c8dbc;
        color: #FFF;
    }

    #load2 {
        width: 100%;
        height: 100%;
        position: fixed;
        z-index: 9999;
        background-color: white !important;
        background: url("https://www.idsprime.com/images/Preloader_2.gif") no-repeat center center rgba(0, 0, 0, 0.75)
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add Student</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="<?php echo ADMIN_URL; ?>students/index">Manage Student</a></li>
            <li class="active">Create Student</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">

                    </div>
                    <?php echo $this->Flash->render(); ?>
                    <?php echo $this->Form->create($students, array(
                        'class' => 'form-horizontal',
                        'id' => 'student_form',
                        'enctype' => 'multipart/form-data',
                        'validate', 'autocomplete' => 'off',
                    )); ?>
                    <div class="box-body">
                        <div class="form-group add_stundaddmi">
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom:15px;">
                                        <div><label>Student Type</label></div>
                                        <label class="radio-inline">
                                            <input type="radio" name="mode" id="inlineRadio2" value="Govt" checked> GOVT.
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="mode" id="inlineRadio2" value="Management"> MANAGEMENT
                                        </label>

                                        <label class="radio-inline">
                                            <input type="radio" name="mode" id="inlineRadio2" value="Federation"> FEDERATION
                                        </label>


                                        <!-- <label class="radio-inline">
                                            <input type="radio" name="category" id="inlineRadio1" value="RTE"> RTE
                                        </label> -->
                                        <!-- <label class="radio-inline">
                                            <input type="radio" name="category" id="inlineRadio3" value="Migration"> MIGRATION
                                        </label> -->
                                    </div>

                                    <script language="javascript" type="text/javascript">
                                        $(document).ready(function(e) {
                                            $('#classs-id').prop('required', false);
                                            $("#inlineRadio1").click(function() {
                                                if ($(this).val() == 'RTE') {
                                                    $('#spinner').html('');
                                                    $('#spinners').html('');
                                                    $('#fname').val('');
                                                    $('#mname').val('');
                                                    $('#lname').val('');
                                                    $('#mobile').val('');
                                                    $('#f_name').val('');
                                                    $('#m_name').val('');
                                                    $('#ady').val('');
                                                    $('#acy').val('');
                                                    $('#datepick1').val('');
                                                    $('#sms_mobile').val('');
                                                    $('#frnofield').val('');
                                                    $('#frnofield2').val('');
                                                    $('#frnofield').prop('required', false);
                                                    $('#frnofield2').prop('required', false);
                                                    $("#frno").hide();
                                                    $('#class-id').prop('required', true);
                                                    $('#classs-id').prop('required', false);
                                                    $("#classmigrateon").hide();
                                                    $("#classmigrateoff").show();
                                                    $("#srnosss2").hide();
                                                    // $("#srnosss").show();
                                                    $("#frno2").hide();
                                                    $('#section-id').prop('selectedIndex', 0);
                                                    $('#house-id').prop('selectedIndex', 0);
                                                    $('#tounge').val('');
                                                    $('#fqualification').val('');
                                                    $('#foccupation').val('');
                                                    $('#mqualification').val('');
                                                    $('#moccupation').val('');
                                                    $('#mphone').val('');
                                                }
                                            });
                                            $("#inlineRadio2").click(function() {
                                                if ($(this).val() == 'Govt') {
                                                    $('#fname').val('');
                                                    $('#mname').val('');
                                                    $('#lname').val('');
                                                    $('#mobile').val('');
                                                    $('#f_name').val('');
                                                    $('#m_name').val('');
                                                    $('#ady').val('');
                                                    $('#acy').val('');
                                                    $('#datepick1').val('');
                                                    $('#sms_mobile').val('');
                                                    $('#spinners').html('');
                                                    // $('#frnofield').val('');
                                                    $('#frnofield').val($('#form_last_no').val());
                                                    $("#frno").show();
                                                    $("#srnosss2").hide();
                                                    $("#srnosss").show();
                                                    $('#frnofield').prop('required', true);
                                                    $('#frnofield2').prop('required', false);
                                                    $('#class-id').prop('required', true);
                                                    $('#classs-id').prop('required', false);
                                                    $("#classmigrateon").hide();
                                                    $("#classmigrateoff").show();
                                                    $("#frno2").hide();
                                                    $('#section-id').prop('selectedIndex', 0);
                                                    $('#house-id').prop('selectedIndex', 0);
                                                }
                                            });
                                            $("#inlineRadio3").click(function() {
                                                if ($(this).val() == 'Migration') {
                                                    $('#fname').val('');
                                                    $('#mname').val('');
                                                    $('#lname').val('');
                                                    $('#mobile').val('');
                                                    $('#f_name').val('');
                                                    $('#m_name').val('');
                                                    $('#ady').val('');
                                                    $('#acy').val('');
                                                    $('#datepick1').val('');
                                                    $('#sms_mobile').val('');
                                                    $('#spinner').html('');
                                                    $('#frnofield').val('');
                                                    $("#frno").hide();
                                                    $("#frno2").show();
                                                    $('#class-id').prop('required', false);
                                                    $('#classs-id').prop('required', true);
                                                    $("#classmigrateon").show();
                                                    $("#classmigrateoff").hide();
                                                    $("#srnosss2").show();
                                                    $("#srnosss").hide();
                                                    $('#frnofield2').prop('required', true);
                                                    $('#frnofield').prop('required', false);
                                                    $('#section-id').prop('selectedIndex', 0);
                                                    $('#house-id').prop('selectedIndex', 0);
                                                    $('#tounge').val('');
                                                    $('#fqualification').val('');
                                                    $('#foccupation').val('');
                                                    $('#mqualification').val('');
                                                    $('#moccupation').val('');
                                                    $('#mphone').val('');
                                                }
                                            });
                                        });
                                    </script>

                                    <?php $form_no  =  explode("_", $userDb); ?>

                                    <?php
                                    // pr($enroll_without_fees);
                                    // exit;



                                    if ($enroll_without_fees == 0) { ?>
                                        <div class="col-md-4" id="srnosss">
                                            <label for="inputEmail3" class="control-label">Scholar No.</label>
                                            <?php if (isset($students['id'])) { ?>
                                                <?php echo $this->Form->input('enroll', array('class' => 'form-control', 'placeholder' => 'Enrollnment', 'id' => 'enroll', 'type' => 'text', 'label' => false)); ?>
                                            <?php } else { ?>
                                            <?php $number = trim($studentsid['enroll']);
                                                $addst = $number + 1;
                                                echo $this->Form->input('enroll', array('class' => 'form-control', 'placeholder' => 'Enrollnment', 'type' => 'text', 'id' => 'enroll', 'value' => $addst, 'label' => false, 'readonly'));
                                            }  ?>
                                        </div>
                                    <?php } else { ?>

                                        <div class="col-md-4" id="srnosss2" style="display:none;">
                                            <label for="inputEmail3" class="control-label">Serial No.</label>
                                            <?php //if (isset($students['id'])) { 
                                            ?>
                                            <?php //echo $this->Form->input('enrolls', array('class' => 'form-control', 'placeholder' => 'Enrollnment', 'id' => 'enroll', 'label' => false)); 
                                            ?>
                                        <?php //} else {
                                        $numberdd = trim($studentsid['enroll']);
                                        $addstd = $numberdd + 1;
                                        echo $this->Form->input('enroll', array('class' => 'form-control', 'placeholder' => 'Enrollnment', 'id' => 'enroll', 'value' => $addstd, 'label' => false, 'readonly'));
                                    } ?>
                                        </div>
                                        <?php //} 
                                        ?>



                                        <div class="col-md-4" id="frno2" style="display:none;">
                                            <label for="inputEmail3" class="control-label">Existing Enroll No.<span style="color:red;">*</span></label>
                                            <?php echo $this->Form->input('oldenroll', array('class' => 'form-control secrh-loc2', 'placeholder' => 'Exisiting Enroll No.', 'autocomplete' => 'off', 'id' => 'frnofield2', 'type' => 'text', 'label' => false)); ?>
                                            <!-- <span id="spinners" style="color:red;"></span> -->
                                        </div>

                                        <div class="col-md-4">
                                            <label for="inputEmail3" class="control-label">Batch<span style="color:red;">*</span></label>
                                            <?php
                                            echo $this->Form->select(
                                                'batch',
                                                $batch,
                                                [
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Select Batch',
                                                    'required' => true,
                                                    'default' => $academic_year
                                                ]
                                            );
                                            ?>

                                        </div>



                                        <div class="col-md-4">
                                            <label for="inputEmail3" class="control-label">Roll Number.</label>
                                            <?php echo $this->Form->input('roll_no', array('class' => 'form-control', 'placeholder' => 'Roll Number', 'type' => 'text', 'label' => false)); ?>

                                        </div>

                                        <div class="col-md-4" id="frno">
                                            <label for="inputEmail3" class="control-label">Enrolment Number.</label>
                                            <?php echo $this->Form->input('enrolment_no', array('class' => 'form-control secrh-loc autoformnumber', 'value' => $fromnos, 'placeholder' => 'Enrolment Number.', 'autocomplete' => 'off', 'id' => 'frnofield', 'type' => 'text', 'label' => false)); ?>
                                            <span id="spinner" style="color:red;"></span>
                                        </div>


                                        <div class="col-md-4" id="frno">
                                            <label for="inputEmail3" class="control-label">RUHS/RNC/RPMC Enrolment</label>
                                            <?php echo $this->Form->input('ruhs_rnc_rpmc_enroll', array('class' => 'form-control', 'placeholder' => 'RUHS/RNC/RPMC Enrolment.', 'autocomplete' => 'off', 'id' => 'frnofield', 'type' => 'text', 'label' => false)); ?>
                                            <span id="spinner" style="color:red;"></span>
                                        </div>


                                </div>
                            </div>

                            <style>
                                #dvPreview {
                                    filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=image);
                                    text-align: center;
                                }
                            </style>

                            <div class="col-sm-3 " style="position: relative;">
                                <div id="dvPreview"> <img class="center-block img-circle img-thumbnail profile-img" src="<?php echo SITE_URL; ?>webroot/uploads/no-images.png" id="my_img">
                                </div>
                                <div class="photo-edit-admin1">
                                    <a id="lo" class="photo-edit-icon-admin1" href="#" title="Edit Profile Picture"><i class="fa fa-pencil"></i></a>
                                </div>
                                <input type="hidden" name="filesss1" id="img">
                            </div>

                            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

                            <script language="javascript" type="text/javascript">
                                $(function() {
                                    $("#pic1").change(function() {
                                        $("#dvPreview").html("");
                                        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
                                        if (regex.test($(this).val().toLowerCase())) {
                                            if ($.browser.msie && parseFloat(jQuery.browser.version) <=
                                                9.0) {
                                                $("#dvPreview").show();
                                                $("#dvPreview")[0].filters.item(
                                                        "DXImageTransform.Microsoft.AlphaImageLoader").src =
                                                    $(this).val();
                                            } else {
                                                if (typeof(FileReader) != "undefined") {
                                                    $("#dvPreview").show();
                                                    $("#dvPreview").append(
                                                        "<img  height='50%' width='50%'/>");
                                                    var reader = new FileReader();
                                                    reader.onload = function(e) {
                                                        $("#dvPreview img").attr("src", e.target
                                                            .result);
                                                    }
                                                    reader.readAsDataURL($(this)[0].files[0]);
                                                } else {
                                                    alert("This browser does not support FileReader.");
                                                }
                                            }
                                        } else {
                                            alert("Please upload a valid image file.");
                                        }
                                    });
                                });
                            </script>

                            <script type="text/javascript">
                                $(document).ready(function(e) {
                                    // $('.data').attr('readonly', 'readonly');
                                    var currentYear = new Date().getFullYear();
                                    $("#datepick1").datepicker({
                                        dateFormat: "dd-mm-yy",
                                        changeMonth: true,
                                        changeYear: true,
                                        yearRange: "1995:" + currentYear, // Adjusted the yearRange
                                        defaultDate: "01-01-2000", // Set defaultDate to January 1, 2000
                                        onSelect: function() {
                                            $('.data').trigger('change');
                                        }
                                    });
                                    $("#lo").click(function() {
                                        $("#pic1").trigger('click');
                                    });
                                });
                            </script>

                            <script>
                                $(function() {
                                    var psos = $('.secrh-loc').val();
                                    if (psos == '') {
                                        $('.secrh-loc').bind('blur', function() {
                                            var pos = $('.secrh-loc').val();
                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo ADMIN_URL; ?>Students/checkStudentExist',
                                                data: {
                                                    'fetch': pos
                                                },
                                                beforeSend: function(xhr) {
                                                    xhr.setRequestHeader('X-CSRF-Token', $(
                                                        '[name="_csrfToken"]').val());
                                                    $('#load2').css("display", "block");
                                                },
                                                success: function(data) {
                                                    var ar1 = data.split(',');
                                                    var im1 = ar1[0].split('/');
                                                    if (data == 0) {
                                                        // $('#spinner').html(
                                                        //     'Form number invalid  !!');
                                                        $('#fname').val('');
                                                        $('#mname').val('');
                                                        $('#lname').val('');
                                                        $('#mobile').val('');

                                                        $('#h1').val('');
                                                        $('#f_name').val('');
                                                        $('#m_name').val('');

                                                        $('#ady').val('');
                                                        $('#acy').val('');
                                                        $('#b1').val('');
                                                        $('#sms_mobile').val('');
                                                        $('#datepick1').val('');
                                                        $('#section-id').val('');
                                                        $('#addre').val('');
                                                        $('#house-id').val('');
                                                        $('#my_img').attr('src',
                                                            "<?php echo SITE_URL; ?>webroot/uploads/no-images.png"
                                                        );
                                                    } else {
                                                        $('#spinner').html('');
                                                        if (ar1[0] == 'r') {
                                                            $('#my_img').attr('src',
                                                                "<?php echo SITE_URL; ?>webroot/uploads/no-images.png"
                                                            );
                                                            $('#img').val('');
                                                        } else {
                                                            $('#my_img').attr('src', ar1[0]);
                                                            $('#img').val(im1[6]);
                                                        }
                                                        $('#fname').val(ar1[1]);
                                                        $('#mname').val(ar1[2]);
                                                        $('#lname').val(ar1[3]);
                                                        $('#mobile').val(ar1[8]);
                                                        $('#class-id').val(ar1[4]);
                                                        $('#h1').val(ar1[4]);
                                                        $('#f_name').val(ar1[6]);
                                                        $('#m_name').val(ar1[7]);
                                                        if (ar1[5] == "1970-01-01") {} else {
                                                            $('#datepick1').datepicker(
                                                                "setDate", new Date(ar1[5]));
                                                        }
                                                        $('#ady').val(ar1[9]);
                                                        $('#acy').val(ar1[9]);
                                                        $('#b1').val(ar1[10]);
                                                        $('#sms_mobile').val(ar1[11]);
                                                        var ksey = ar1[12];
                                                        var valssue = ar1[13];

                                                        $('#section-id').val(ksey);
                                                        var ksey2 = ar1[14];
                                                        var valssue2 = ar1[15];

                                                        $('#house-id').val(ksey2);
                                                        var ksey3 = ar1[16];
                                                        var valssue3 = ar1[17];
                                                        var gend = ar1[18];
                                                        if (gend == "Female") {
                                                            $('#inlineRadio2s').prop('checked',
                                                                true);
                                                        } else {
                                                            $('#inlineRadio1s').prop('checked',
                                                                true);
                                                        }
                                                        var mtongue = ar1[19];
                                                        $('#tounge').val(mtongue);
                                                        var f_qualification = ar1[20];
                                                        $('#fqualification').val(
                                                            f_qualification);
                                                        var f_occupation = ar1[21];
                                                        $('#foccupation').val(f_occupation);
                                                        var m_qualification = ar1[22];
                                                        $('#mqualification').val(
                                                            m_qualification);
                                                        var m_occupation = ar1[23];
                                                        $('#moccupation').val(m_occupation);
                                                        var m_phone = ar1[24];
                                                        $('#mphone').val(m_phone);
                                                        var f_phone = ar1[25];
                                                        $('#fphone').val(f_phone);
                                                        $('#class-id')
                                                            .html($("<option></option>")
                                                                .attr("value", ksey3)
                                                                .text(valssue3));
                                                        return false;

                                                    }
                                                },
                                                complete: function() {
                                                    $('#load2').css("display", "none");
                                                },
                                            });

                                            function secfind(id) {
                                                var hg = $('#fg').val();
                                                var gh = $('#b1').val();
                                                $.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo ADMIN_URL; ?>Students/findboard',
                                                    data: {
                                                        'id': gh
                                                    },
                                                    beforeSend: function(xhr) {
                                                        xhr.setRequestHeader('X-CSRF-Token', $(
                                                                '[name="_csrfToken"]')
                                                            .val())
                                                    },
                                                    success: function(data) {

                                                        $('#enroll').val(data);
                                                    },
                                                });

                                                $.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo ADMIN_URL; ?>ClasstimeTabs/find_section',
                                                    data: {
                                                        'id': id
                                                    },
                                                    beforeSend: function(xhr) {
                                                        xhr.setRequestHeader('X-CSRF-Token', $(
                                                                '[name="_csrfToken"]')
                                                            .val())
                                                    },
                                                    success: function(data) {
                                                        $('#section-id').empty();
                                                        $('#section-id').html(data);
                                                    },
                                                });
                                            }
                                        });
                                    } else {
                                        var pos = $('.secrh-loc').val();
                                        // console.log("🚀 ~ file: add.ctp:475 ~ pos:", pos);

                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo ADMIN_URL; ?>Students/studentsearch',
                                            data: {
                                                'fetch': pos
                                            },
                                            beforeSend: function(xhr) {
                                                xhr.setRequestHeader('X-CSRF-Token', $(
                                                    '[name="_csrfToken"]').val());
                                                $('#load2').css("display", "block");
                                            },
                                            success: function(data) {
                                                var ar1 = data.split(',');
                                                var im1 = ar1[0].split('/');
                                                if (data == 0) {
                                                    // $('#spinner').html('Form number invalid  !!');
                                                    $('#fname').val('');
                                                    $('#mname').val('');
                                                    $('#lname').val('');
                                                    $('#mobile').val('');

                                                    $('#h1').val('');
                                                    $('#f_name').val('');
                                                    $('#m_name').val('');

                                                    $('#ady').val('');
                                                    $('#acy').val('');
                                                    $('#b1').val('');
                                                    $('#sms_mobile').val('');
                                                    $('#datepick1').val('');
                                                    $('#section-id').val('');
                                                    $('#addre').val('');
                                                    $('#house-id').val('');
                                                    $('#my_img').attr('src',
                                                        "<?php echo SITE_URL; ?>webroot/uploads/no-images.png"
                                                    );
                                                } else {
                                                    $('#spinner').html('');
                                                    if (ar1[0] == 'r') {
                                                        $('#my_img').attr('src',
                                                            "<?php echo SITE_URL; ?>webroot/uploads/no-images.png"
                                                        );
                                                        $('#img').val('');
                                                    } else {
                                                        $('#my_img').attr('src', ar1[0]);
                                                        $('#img').val(im1[6]);
                                                    }
                                                    $('#fname').val(ar1[1]);
                                                    $('#mname').val(ar1[2]);
                                                    $('#lname').val(ar1[3]);
                                                    $('#mobile').val(ar1[8]);
                                                    $('#class-id').val(ar1[4]);
                                                    $('#h1').val(ar1[4]);
                                                    $('#f_name').val(ar1[6]);
                                                    $('#m_name').val(ar1[7]);
                                                    if (ar1[5] == "1970-01-01") {} else {
                                                        $('#datepick1').datepicker("setDate", new Date(
                                                            ar1[5]));
                                                    }
                                                    $('#ady').val(ar1[9]);
                                                    $('#acy').val(ar1[9]);
                                                    $('#b1').val(ar1[10]);
                                                    $('#sms_mobile').val(ar1[11]);
                                                    var ksey = ar1[12];
                                                    var valssue = ar1[13];

                                                    $('#section-id').val(ksey);
                                                    var ksey2 = ar1[14];
                                                    var valssue2 = ar1[15];

                                                    $('#house-id').val(ksey2);
                                                    var ksey3 = ar1[16];
                                                    var valssue3 = ar1[17];
                                                    var gend = ar1[18];
                                                    if (gend == "Female") {
                                                        $('#inlineRadio2s').prop('checked', true);
                                                    } else {
                                                        $('#inlineRadio1s').prop('checked', true);
                                                    }
                                                    var mtongue = ar1[19];
                                                    $('#tounge').val(mtongue);
                                                    var f_qualification = ar1[20];
                                                    $('#fqualification').val(f_qualification);
                                                    var f_occupation = ar1[21];
                                                    $('#foccupation').val(f_occupation);
                                                    var m_qualification = ar1[22];
                                                    $('#mqualification').val(m_qualification);
                                                    var m_occupation = ar1[23];
                                                    $('#moccupation').val(m_occupation);
                                                    var m_phone = ar1[24];
                                                    $('#mphone').val(m_phone);
                                                    var f_phone = ar1[25];
                                                    $('#fphone').val(f_phone);
                                                    $('#class-id')
                                                        .html($("<option></option>")
                                                            .attr("value", ksey3)
                                                            .text(valssue3));
                                                    return false;

                                                }
                                            },
                                            complete: function() {
                                                $('#load2').css("display", "none");
                                            },
                                        });

                                        // function secfind(id) {
                                        //     var hg = $('#fg').val();
                                        //     var gh = $('#b1').val();
                                        //     $.ajax({
                                        //         type: 'POST',
                                        //         url: '<?php //echo ADMIN_URL; 
                                                            ?>Students/findboard',
                                        //         data: {
                                        //             'id': gh
                                        //         },
                                        //         beforeSend: function(xhr) {
                                        //             xhr.setRequestHeader('X-CSRF-Token', $(
                                        //                 '[name="_csrfToken"]').val())
                                        //         },
                                        //         success: function(data) {

                                        //             $('#enroll').val(data);
                                        //         },
                                        //     });

                                        //     $.ajax({
                                        //         type: 'POST',
                                        //         url: '<?php //echo ADMIN_URL; 
                                                            ?>ClasstimeTabs/find_section',
                                        //         data: {
                                        //             'id': id
                                        //         },
                                        //         beforeSend: function(xhr) {
                                        //             xhr.setRequestHeader('X-CSRF-Token', $(
                                        //                 '[name="_csrfToken"]').val());
                                        //         },
                                        //         success: function(data) {
                                        //             $('#section-id').empty();
                                        //             $('#section-id').html(data);
                                        //         },
                                        //     });
                                        // }
                                    }
                                    // for Migration
                                    $('.secrh-loc2').bind('blur', function() {
                                        $('#spinners').html('');
                                        var pos = $('.secrh-loc2').val();
                                        var b1 = $('#b1').val();

                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo ADMIN_URL; ?>Students/studentsearch2',
                                            data: {
                                                'fetch': pos,
                                                'board': b1
                                            },

                                            beforeSend: function(xhr) {
                                                xhr.setRequestHeader('X-CSRF-Token', $(
                                                    '[name="_csrfToken"]').val());
                                                $('#load2').css("display", "block");
                                            },
                                            success: function(data) {
                                                var ar1 = data.split(',');
                                                var addree = data.split('&');
                                                var im1 = ar1[0].split('/');
                                                if (data == 0) {
                                                    $('#spinners').html(
                                                        'Enroll number invalid  !!');
                                                    $('#fname').val('');
                                                    $('#mname').val('');
                                                    $('#lname').val('');
                                                    $('#mobile').val('');

                                                    $('#f_name').val('');
                                                    $('#m_name').val('');

                                                    $('#ady').val('');
                                                    $('#acy').val('');

                                                    $('#sms_mobile').val('');
                                                    $('#datepick1').val('');

                                                    $('#addre').val('');
                                                    $('#house-id').val('');
                                                    $('#my_img').attr('src',
                                                        "<?php echo SITE_URL; ?>webroot/uploads/no-images.png"
                                                    );
                                                } else {
                                                    $('#spinner').html('');
                                                    if (ar1[0] == 'r') {
                                                        $('#my_img').attr('src',
                                                            "<?php echo SITE_URL; ?>webroot/uploads/no-images.png"
                                                        );
                                                        $('#img').val('');
                                                    } else {
                                                        $('#my_img').attr('src', ar1[0]);
                                                        $('#img').val(im1[6]);
                                                    }
                                                    $('#fname').val(ar1[1]);
                                                    $('#mname').val(ar1[2]);
                                                    $('#lname').val(ar1[3]);
                                                    $('#mobile').val(ar1[8]);
                                                    $('#f_name').val(ar1[6]);
                                                    $('#m_name').val(ar1[7]);
                                                    $('#datepick1').datepicker("setDate",
                                                        new Date(ar1[5]));
                                                    $('#ady').val(ar1[9]);
                                                    $('#acy').val(ar1[9]);

                                                    $('#sms_mobile').val(ar1[11]);

                                                    var ksey = ar1[12];
                                                    var valssue = ar1[13];
                                                    $('#section-id').val(ksey);
                                                    // var ksey3 = ar1[14];
                                                    // var valssue3 = ar1[15];
                                                    var ksey3 = ar1[16];
                                                    var valssue3 = ar1[17];

                                                    var valssssue3 = ar1[18];
                                                    if (valssssue3 == "Male") {
                                                        $("#inlineRadio1s").prop("checked",
                                                            true);
                                                        $("#inlineRadio2s").prop("checked",
                                                            false);
                                                    } else if (valssssue3 == "Female") {
                                                        $("#inlineRadio2s").prop("checked",
                                                            true);
                                                        $("#inlineRadio1s").prop("checked",
                                                            false);
                                                    }
                                                    $('#datepick1').val(ar1[19]);
                                                    var mtongue = ar1[20];
                                                    if (mtongue) {
                                                        $('#tounge').val(mtongue);
                                                    } else {
                                                        $('#tounge').val('Hindi');
                                                    }
                                                    var f_qualification = ar1[21];
                                                    $('#fqualification').val(f_qualification);
                                                    var f_occupation = ar1[22];
                                                    $('#foccupation').val(f_occupation);
                                                    var m_qualification = ar1[23];
                                                    $('#mqualification').val(m_qualification);
                                                    var m_occupation = ar1[24];
                                                    $('#moccupation').val(m_occupation);
                                                    var m_phone = ar1[25];
                                                    $('#mphone').val(m_phone);
                                                    var f_phone = ar1[26];
                                                    $('#fphone').val(f_phone);
                                                    var address = addree[1];
                                                    $('#addre').val(address);
                                                    $('#classs-id')
                                                        .html($("<option></option>")
                                                            .attr("value", ksey3)
                                                            .text(valssue3));
                                                    return false;
                                                }
                                            },
                                            complete: function() {
                                                $('#load2').css("display", "none");
                                            },
                                        });

                                        // function secfind(id) {
                                        //     var hg = $('#fg').val();
                                        //     var gh = $('#b1').val();
                                        //     $.ajax({
                                        //         type: 'POST',
                                        //         url: '<?php // echo ADMIN_URL; 
                                                            ?>Students/findboard',
                                        //         data: {
                                        //             'id': gh
                                        //         },
                                        //         beforeSend: function(xhr) {
                                        //             xhr.setRequestHeader('X-CSRF-Token', $(
                                        //                 '[name="_csrfToken"]').val())
                                        //         },
                                        //         success: function(data) {

                                        //             $('#enroll').val(data);
                                        //         },
                                        //     });

                                        //     $.ajax({
                                        //         type: 'POST',
                                        //         url: '<?php // echo ADMIN_URL; 
                                                            ?>ClasstimeTabs/find_section',
                                        //         data: {
                                        //             'id': id
                                        //         },
                                        //         beforeSend: function(xhr) {
                                        //             xhr.setRequestHeader('X-CSRF-Token', $(
                                        //                 '[name="_csrfToken"]').val())
                                        //         },
                                        //         success: function(data) {
                                        //             $('#section-id').empty();
                                        //             $('#section-id').html(data);
                                        //         },
                                        //     });
                                        // }


                                    });
                                });
                            </script>

                        </div>
                        <div class="form-group ">

                            <div id="load2" style="display: none;"></div>

                            <div class="col-sm-4 col-xs-6" id="classmigrateoff">
                                <label for="inputEmail3" class="control-label">Course<span style="color:red;">*</span></label>

                                <?php
                                echo $this->Form->select(
                                    'class_id',
                                    $course,
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => 'Select Course',
                                        'empty' => 'Select Course',
                                        // 'disabled' => true,
                                        'id' => 'class-id',
                                        'required' => true
                                    ]
                                );
                                ?>

                                <!-- <input type="hidden" name="class_id" id="h1"> -->
                            </div>

                            <div class="col-sm-4 col-xs-6">
                                <label for="inputEmail3" class="control-label">Year/Semester<span style="color:red;">*</span></label>

                                <?php
                                echo $this->Form->select(
                                    'section_id',
                                    $sections,
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => 'Year/Semester',
                                        // 'disabled' => true,
                                        'empty' => 'Select Year/Semester',
                                        'id' => 'section-id',
                                        'required' => true,

                                    ]
                                );
                                ?>

                            </div>
                            <!-- 
                            <div class="col-md-4 col-xs-6">
                                <label for="inputEmail3" class="control-label ">Organization<span style="color: red;">*</span></label>
                                <?php
                                // echo $this->Form->select(
                                //     'board_id',
                                //     $board_names,
                                //     [
                                //         'class' => 'form-control',
                                //         'placeholder' => 'Select Organization',
                                //         'required' => true
                                //     ]
                                // );
                                ?>
                            </div> -->

                            <div class="col-sm-4 col-xs-6">
                                <label for="inputEmail3" class="control-label">Pupil's First Name<span style="color:red;">*</span></label>
                                <?php echo $this->Form->input('fname', array('class' => 'form-control capitalize-word', 'placeholder' => 'First Name', 'required', 'id' => 'fname', 'label' => false)); ?>
                            </div>

                            <div class="col-sm-4 col-xs-6">
                                <label for="inputEmail3" class="control-label">Middle Name</label>
                                <?php echo $this->Form->input('middlename', array('class' => 'form-control capitalize-word', 'placeholder' => 'Middle Name', 'id' => 'mname', 'label' => false)); ?>
                            </div>
                            <div class="col-sm-4 col-xs-6">
                                <label for="inputEmail3" class="control-label">Last Name</label>
                                <?php echo $this->Form->input('lname', array('class' => 'form-control capitalize-word', 'placeholder' => 'Last Name', 'id' => 'lname', 'label' => false)); ?>
                            </div>

                            <div class="col-sm-4 col-xs-6">
                                <label for="inputEmail3" class="control-label">Date of Birth<span style="color:red;">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <?php echo $this->Form->input('dob', array('class' => 'form-control data',  'placeholder' => 'DD-MM-YYYY', 'id' => 'datepick1', 'label' => false,'readonly' => true)); ?>

                                </div>
                                <!-- <script>
                                    // this code use to dob readonly after chose date 
                                    $('.data').change(function() {
                                        stu_dob = $(this).val();
                                        if (stu_dob) {
                                            // $('.data').attr('readonly', 'readonly');
                                        } else {
                                            // $('.data').attr('readonly', false);
                                        }
                                    });
                                </script> -->
                                <span style="color:red; display:none;" class="display_error">New Student D.O.B.
                                    must have 6 years old.</span>
                            </div>

                            <div class="col-sm-4 col-xs-6">
                                <label for="inputEmail3" class="control-label">Email/Login Id</label>
                                <?php echo $this->Form->input('username', array('class' => 'form-control', 'placeholder' => 'Email', 'id' => 'mcheckmail', 'label' => false)); ?>
                                <span id="dividhere" style="display:none;color:red;">Email Already Exist</span>
                                <span id="ntc" style="color:red; display:none"><?php echo __("Invalid email"); ?></span>
                            </div>

                            <script>
                                function isValidEmailAddress(emailAddress) {
                                    var pattern =
                                        /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
                                    return pattern.test(emailAddress);
                                };
                                $(document).ready(function() {
                                    $("#mcheckmail").change(function() {
                                        var txt = $('#mcheckmail').val();
                                        var testCases = [txt];
                                        var test = testCases;
                                        if (isValidEmailAddress(test) != true) {
                                            $('#ntc').css('display', 'block');
                                            $('#mcheckmail').val('');
                                        } else {
                                            $('#ntc').css('display', 'none');
                                        }
                                    });
                                });
                            </script>

                            <div class="col-sm-4 col-xs-6">
                                <label for="inputEmail3" class="control-label">Mobile No<span style="color:red;">*</span></label>
                                <?php echo $this->Form->input('mobile', array('class' => 'form-control', 'minlength' => '10', 'maxlength' => '10', 'onkeypress' => 'return isNumber(event);', 'placeholder' => 'Mobile No.', 'id' => 'mobile', 'label' => false, 'required')); ?>
                                <!-- /.input group -->
                                <div id="erpfd" style="display:none;color:red;"></div>
                            </div>


                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <div>
                                    <label for="inputEmail3" class="control-label">Gender</label>
                                </div>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="inlineRadio1s" checked value="Male"> Male
                                </label>
                                <label for="inputEmail3" class="radio-inline">
                                    <input type="radio" name="gender" id="inlineRadio2s" value="Female"> Female
                                </label>
                            </div>

                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <label for="inputEmail3" class="control-label">Application Form/Date</label>
                                <?php echo $this->Form->input('applocation_form_date', array('class' => 'form-control', 'placeholder' => 'Application Form/Date', 'label' => false)); ?>
                            </div>

                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <label for="inputEmail3" class="control-label">Date of Joining</label>

                                <?php echo $this->Form->input('date_of_joining', array('class' => 'form-control', 'id' => 'datepick2', 'placeholder' => 'Application Form/Date', 'readonly', 'label' => false)); ?>

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        var currentYear = new Date().getFullYear();
                                        var currentDate = new Date();

                                        var day = ("0" + currentDate.getDate()).slice(-2);
                                        var month = ("0" + (currentDate.getMonth() + 1)).slice(-2);
                                        var year = currentDate.getFullYear();

                                        var defaultDate = day + "-" + month + "-" + year;

                                        $("#datepick2").datepicker({
                                            dateFormat: "dd-mm-yy",
                                            changeMonth: true,
                                            changeYear: true,
                                            yearRange: "1995:" + currentYear,
                                        });

                                        // Set the default date on the datepicker
                                        $("#datepick2").datepicker("setDate", defaultDate);

                                        // Trigger 'change' event on selection
                                        $("#datepick2").on("change", function() {
                                            $('.data').trigger('change');
                                        });
                                    });
                                </script>

                            </div>

                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <label for="hindiOutput" class="control-label">Full Name (Hindi)</label>
                                <?php echo $this->Form->input('hindiname', array('class' => 'form-control', 'placeholder' => 'Full Name (Hindi)', 'id' => 'hindiname', 'label' => false)); ?>
                            </div>


                            <div class="col-sm-4 col-xs-6" style="display: none;">
                                <label for="inputEmail3" class="control-label">Student Image</label>
                                <?php echo $this->Form->input('file12', array('class' => 'form-control', 'type' => 'file', 'id' => 'pic1', 'label' => false, 'accept' => 'image/*')); ?>
                            </div>

                            <input type="hidden" name="as" id="fg" value="<?php echo $studentsid['enroll']; ?>">

                            <script type="text/javascript">
                                $('#b1').change(function() {
                                    var hg = $('#fg').val();
                                    var gh = $('#b1').val();
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo ADMIN_URL; ?>Students/findboard',
                                        data: {
                                            'id': gh
                                        },
                                        beforeSend: function(xhr) {
                                            xhr.setRequestHeader('X-CSRF-Token', $(
                                                '[name="_csrfToken"]').val())
                                        },
                                        success: function(data) {
                                            $('#enroll').val(data);
                                        },
                                    });
                                });
                            </script>

                            <script>
                                $(document).ready(function(e) {
                                    $('.chji').click(function() {
                                        var hg = $('input[name=feecatss]:checked').val();
                                        if (hg != 'Other') {
                                            var gh = $('#frnofield').val();
                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo ADMIN_URL; ?>Students/findphoneno',
                                                data: {
                                                    'id': gh,
                                                    'fieln': hg
                                                },
                                                beforeSend: function(xhr) {
                                                    xhr.setRequestHeader('X-CSRF-Token', $(
                                                            '[name="_csrfToken"]')
                                                        .val())
                                                },
                                                success: function(data) {

                                                    $('#sms_mobile').val(data);
                                                },
                                            });
                                        } else {
                                            $('#sms_mobile').val('');
                                        }
                                    });
                                });
                            </script>

                            <script language="javascript" type="text/javascript">
                                $(document).ready(function(e) {
                                    $("#inlinefRadio0").click(function() {
                                        if ($(this).val() == 'Other') {
                                            $("#feerecivier").show();
                                            $('#feesubmittedby').prop('required', true);
                                        }
                                    });
                                    $("#inlinefRadio1").click(function() {
                                        if ($(this).val() == 'Mother') {
                                            $('#feesubmittedby').prop('required', false);
                                            $("#feerecivier").hide();
                                        }
                                    });
                                    $("#inlinefRadio2").click(function() {
                                        if ($(this).val() == 'Father') {
                                            $('#feesubmittedby').prop('required', false);
                                            $("#feerecivier").hide();
                                        }
                                    });
                                    $(".feesmode").click(function() {
                                        if ($(this).val() == 'CHEQUE') {
                                            $("#srnosss").hide();
                                        } else {
                                            $("#srnosss").show();
                                        }
                                    });
                                });



                                $(document).ready(function() {
                                    $('#class-id').on('change', function() {
                                        var id = $('#class-id').val();
                                        $.ajax({
                                            type: 'POST',
                                            url: "<?php echo SITE_URL ?>admin/ClasstimeTabs/find_section",
                                            data: {
                                                'id': id
                                            },
                                            beforeSend: function(xhr) {
                                                xhr.setRequestHeader('X-CSRF-Token', $(
                                                    '[name="_csrfToken"]').val())
                                            },
                                            success: function(data) {
                                                $('#section-id').empty();
                                                $('#section-id').html(data);
                                            },
                                        });
                                    });
                                });
                            </script>

                        </div>

                        <fieldset>
                            <legend><i class="fa fa-child" aria-hidden="true"></i> Academic Details</legend>
                            <div class="form-group add_acadmi_dtl">

                                <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">Aadhar No.</label>
                                    <input type="text" class="form-control" maxlength="12" onkeypress="return isNumber(event);" name="adaharnumber" placeholder="Aadhar No">
                                    <div id="erp" style="display:none;color:red;">Enter Only Number</div>
                                </div>


                                <div class="col-sm-4 col-xs-6" id="smsmobile" style="display:block;">
                                    <label for="inputEmail3" class="control-label">SMS Mobile<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter SMS Mobile Number" value="" maxlength="10" minlength="10" required="required" name="sms_mobile" id="sms_mobile" onkeypress="return isNumber(event);">
                                </div>

                                <div class="col-sm-4 col-xs-6" style="display: none;">
                                    <input type="hidden" class="form-control" name="acedmicyear" value="<?php echo $acedmicyearfi; ?>">
                                </div>

                                <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">Nationality</label>
                                    <select class="form-control" name="nationality" style="width: 100%;">
                                        <option value="INDIAN" <?php if ($students['nationality'] == 'INDIAN') { ?> selected="selected" <?php } ?>>INDIAN</option>
                                        <option value="OTHERS" <?php if ($students['nationality'] == 'OTHERS') { ?> selected="selected" <?php } ?>>OTHERS</option>
                                    </select>
                                </div>

                                <!-- <div class="col-sm-4 col-xs-6" id="classmigrateon" style="display:none;">
                                    <label for="inputEmail3" class="control-label">Course<span style="color:red;">*</span></label>
                                    <select class="form-control" name="classd_id" id="classs-id" required="required">
                                        <option value="">---Select Course---</option>
                                        <?php //foreach ($course as $key => $value) { 
                                        ?>
                                            <option value="<?php //echo $key; 
                                                            ?>"><?php //echo $value; 
                                                                ?></option>
                                        <?php //} 
                                        ?>
                                    </select>
                                </div> -->

                                <!-- <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">House</label>
                                    <select class="form-control" name="h_id" id="house-id">
                                        <option value=""> ---Select House--- </option>
                                        <?php // foreach ($houses as $esrht => $esht) { 
                                        ?>
                                            <option value="<?php  //echo $esht['id']; 
                                                            ?>"><?php // echo $esht['name']; 
                                                                ?></option>
                                        <?php // } 
                                        ?>
                                    </select>
                                </div> -->

                                <!-- <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">Third Language studied in previous
                                        class for VII,VIII,IX</label>
                                    <input type="text" class="form-control" name="thirdlang" placeholder="Enter Third Language" id="thirdlang">
                                </div> -->

                                <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">Category <span style="color:red;">*</span></label>
                                    <select class="form-control" onchange="castChoose(this)" name="cast" style="width: 100%;" required="required">
                                        <option value="Gen" <?= ($students['cast'] == 'Gen') ? 'selected' : '' ?>>General</option>
                                        <option value="OBC" <?= ($students['cast'] == 'OBC') ? 'selected' : '' ?>>O.B.C.</option>
                                        <option value="SC" <?= ($students['cast'] == 'SC') ? 'selected' : '' ?>>S.C.</option>
                                        <option value="ST" <?= ($students['cast'] == 'ST') ? 'selected' : '' ?>>S.T.</option>
                                        <option value="MBC" <?= ($students['cast'] == 'MBC') ? 'selected' : '' ?>>MBC</option>
                                        <option value="Others" <?= ($students['category'] == 'Others') ? 'selected' : '' ?>>Others</option>
                                    </select>
                                </div>

                                <script>
                                    function castChoose(selectElement) {
                                        var otherCasteOption = document.getElementById("othercasteoption");
                                        var otherCastTextField = document.getElementById("other_cast_text");

                                        if (selectElement.value === "Others") {
                                            otherCasteOption.style.display = "block";
                                            otherCastTextField.required = true;
                                        } else {
                                            otherCasteOption.style.display = "none";
                                            otherCastTextField.required = false;
                                        }
                                    }
                                </script>

                                <div class="col-sm-4 col-xs-6" id="othercasteoption" style="display:none;">
                                    <label for="inputEmail3" class="control-label">Category Name<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control"  placeholder="Enter Category Name" name="other_cast_text" id="other_cast_text">
                                </div>




                                <div class="col-sm-4 col-xs-6">
                                    <div><label>Fees Submitted By :</label></div>
                                    <label class="radio-inline">
                                        <input type="radio" name="feecat" id="inlinefRadio2" value="Father" checked>
                                        Father
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="feecat" id="inlinefRadio1" value="Mother"> Mother
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="feecat" id="inlinefRadio0" value="Other"> Other
                                    </label>

                                    <input type="hidden" class="form-control" name="admissionyear" id="ady" value="<? echo $acedmicyearfi; ?>" readonly>
                                </div>

                                <div class="col-sm-4 col-xs-6" id="feerecivier" style="display:none;">
                                    <label for="inputEmail3" class="control-label">Name<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter Fee Receiver Name" name="fee_submittedby" id="feesubmittedby">
                                </div>

                                <div class="col-sm-4 col-xs-12">
                                    <div><label>Sms Received By :</label></div>
                                    <label class="radio-inline">
                                        <input type="radio" name="feecatss" class="chji" id="inlinefRadios2" value="f_phone" checked> Father Mobile No
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="feecatss" class="chji" id="inlinefRadios1" value="m_phone"> Mother Mobile No.
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="feecatss" class="chji" id="inlinefRadios0" value="Other"> Other Mobile No.
                                    </label>
                                </div>

                                <div class="col-sm-4 col-xs-6">
                                    <div><label>Is Transport </label></div>
                                    <?php
                                    echo $this->Form->radio('is_transport', ['Y' => 'Y', 'N' => 'N',], ['class' => 'radio-inline', 'default' => 'N']); ?>
                                </div>


                                <!-- <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">Caste</label>
                                    <input type="text" class="form-control" name="caste" placeholder="Enter Caste" id="Caste">
                                </div>
                                <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">Bloodgroup</label>
                                    <select class="form-control" name="bloodgroup" style="width: 100%;">
                                        <option value="">---Select Bloodgroup---</option>
                                        <option value="A+" <?php // if ($students['bloodgroup'] == 'A') { 
                                                            ?> selected="selected" <?php // } 
                                                                                    ?>>A+</option>
                                        <option value="A-" <?php // if ($students['bloodgroup'] == 'A-') { 
                                                            ?> selected="selected" <?php //  } 
                                                                                    ?>>A-</option>
                                        <option value="B+" <?php // if ($students['bloodgroup'] == 'B+') { 
                                                            ?> selected="selected" <?php // } 
                                                                                    ?>>B+</option>
                                        <option value="B-" <?php // if ($students['bloodgroup'] == 'B-') { 
                                                            ?> selected="selected" <?php // } 
                                                                                    ?>>B-</option>
                                        <option value="O+" <?php // if ($students['bloodgroup'] == 'O+') { 
                                                            ?> selected="selected" <?php // } 
                                                                                    ?>>O+</option>
                                        <option value="AB" <?php // if ($students['bloodgroup'] == 'AB') { 
                                                            ?> selected="selected" <?php // } 
                                                                                    ?>>AB</option>
                                    </select>
                                </div> -->

                                <!-- 
                                <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">Religion<span style="color:red;">*</span></label>
                                    <select class="form-control" name="religion" style="width: 100%;" required="required">
                                        <option value="Hindu" <?php // if ($students['religion'] == 'Hindu') { 
                                                                ?> selected="selected" <?php // } 
                                                                                        ?>>Hindu</option>
                                        <option value="Muslim" <?php // if ($students['religion'] == 'Muslim') { 
                                                                ?> selected="selected" <?php // } 
                                                                                        ?>>Muslim</option>
                                        <option value="Sikh" <?php // if ($students['religion'] == 'Sikh') { 
                                                                ?> selected="selected" <?php // } 
                                                                                        ?>>Sikh</option>
                                        <option value="Christian" <?php // if ($students['religion'] == 'Christian') { 
                                                                    ?> selected="selected" <?php // } 
                                                                                            ?>>Christian</option>
                                        <option value="Jain" <?php // if ($students['religion'] == 'Jain') { 
                                                                ?> selected="selected" <?php // } 
                                                                                        ?>>Jain</option>
                                        <option value="Buddhist" <?php // if ($students['religion'] == 'Buddhist') { 
                                                                    ?> selected="selected" <?php // } 
                                                                                            ?>>Buddhist</option>
                                        <option value="Parsi" <?php // if ($students['religion'] == 'Parsi') { 
                                                                ?> selected="selected" <?php // } 
                                                                                        ?>>Parsi</option>
                                        <option value="Others" <?php // if ($students['religion'] == 'Others') { 
                                                                ?> selected="selected" <?php // } 
                                                                                        ?>>Others</option>
                                    </select>
                                </div> -->


                                <!-- <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">Height</label>
                                    <input type="text" class="form-control" name="height" placeholder="Height" id="height">
                                </div>
                                <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">Weight</label>
                                    <input type="text" class="form-control" name="weight" placeholder="Weight" id="weight">
                                </div> -->

                                <!-- <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">Is Disability</label>
                                    <?php // echo $this->Form->input('disability', array('class' => 'form-control', 'placeholder' => 'Disability', 'type' => 'select', 'id' => 'disability', 'empty' => 'Select', 'options' => $disabilityslist, 'label' => false)); 
                                    ?>
                                </div> -->
                                <!-- 
                                <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">Mother Tongue</label>
                                    <input type="text" class="form-control" name="mother_tounge" placeholder="Mother Tongue" id="tounge">
                                </div> -->

                            </div>
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend><i class="fa fa-user" aria-hidden="true"></i> Parent Information</legend>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Father Name<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control capitalize-word" maxlength="30" name="fathername" placeholder="Father Name" id="f_name" required="required">
                                </div>


                                <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Father Mobile No</label>
                                    <input type="text" class="form-control" name="f_phone" placeholder="Father Mobile No" id="fphone" onkeypress="return isNumber(event);" maxlength="10" minlength="10">
                                </div>



                                <!-- <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Father Qualification</label>
                                    <input type="text" class="form-control" name="f_qualification" placeholder="Father Qualification" id="fqualification">
                                </div> -->


                                <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Father Occupation</label>
                                    <input type="text" class="form-control capitalize-word" name="f_occupation" placeholder="Father Occupation" id="foccupation">
                                </div>


                                <!-- <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Father Annual Income<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="f_annual" placeholder="Father Annual Income" id="f_annual" required="required">
                                </div> -->




                                <!-- <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Father Aadhar Card No</label>
                                    <input type="text" class="form-control" name="f_aadhar" placeholder="Father Aadhar Card No" id="f_aadhar">
                                </div> -->


                                <!-- <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Father PAN Card No</label>
                                    <input type="text" class="form-control" name="f_pan" placeholder="Father PAN Card No" id="f_pan">
                                </div> -->

                                <!--                                 
                                <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Father Email</label>
                                    <input type="text" class="form-control" name="f_email" placeholder="Father Email" id="f_email">
                                </div> -->


                                <!-- <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Father Picture</label>
                                    <input type="file" class="form-control" name="father_pic" placeholder="Father Picture" id="father_pic" accept="image/*">
                                </div> -->


                                <!-- <div class="col-sm-12">
                                    <label for="inputEmail3" class="control-label"> Father Office Address<span style="color:red;">*</span></label>
                                    <textarea class="form-control" rows="3" placeholder="Enter Father Office Address ..." name="f_officeaddress" id="f_officeaddress" required="required"></textarea>
                                </div> -->



                            </div>

                            <div class="form-group">

                                <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Mother Name</label>
                                    <input type="text" class="form-control capitalize-word" maxlength="30" name="mothername" placeholder="Mother Name" id="m_name">
                                </div>


                                <!-- <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Mother Qualification</label>
                                    <input type="text" class="form-control" name="m_qualification" placeholder="Mother Qualification" id="mqualification">
                                </div> -->


                                <!-- 
                                <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Mother Annual Income</label>
                                    <input type="text" class="form-control" name="m_annual" placeholder="Mother Annual Income" id="moccupation">
                                </div> -->


                                <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Mother Mobile No<span style="color:red;"></span></label>
                                    <input type="text" class="form-control" name="m_phone" placeholder="Mother Mobile No" id="mphone" onkeypress="return isNumber(event);" maxlength="10" minlength="10">
                                </div>

                                <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Mother Occupation</label>
                                    <input type="text" class="form-control capitalize-word" name="m_occupation" placeholder="Mother Occupation" id="moccupation">
                                </div>


                                <!-- <div class="form-group"> -->
                                <div class="col-sm-12">
                                    <label for="inputEmail3" class="control-label">Residential Address<span style="color:red;">*</span></label>
                                    <textarea class="form-control capitalize-word" rows="3" placeholder="Enter Residential Address ..." name="address" id="addre" required="required"></textarea>
                                </div>
                                <!-- </div> -->

                            </div>

                        </fieldset>
                        <br>

                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <?php
                    if (isset($students['id'])) {
                        echo $this->Form->submit(
                            'Update',
                            array('class' => 'btn btn-info pull-right', 'title' => 'Update')
                        );
                    } else {
                        echo $this->Form->submit(
                            'Add',
                            array('class' => 'btn btn-info pull-right', 'title' => 'Add')
                        );
                    }
                    ?>
                    <?php
                    echo $this->Html->link('Back', [
                        'action' => 'index',
                    ], ['class' => 'btn btn-default']); ?>
                </div>
                <!-- /.box-footer -->
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<script>
    $(document).ready(function() {
        $('#username').on('change', function() {
            var username = $('#username').val();

            $.ajax({
                type: 'POST',
                url: '<?php echo ADMIN_URL; ?>students/find_username',
                data: {
                    'username': username
                },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())
                },
                success: function(data) {

                    if (data > 0) {
                        $('#username').val('');
                        $('#dividhere').show();

                    } else {
                        $('#dividhere').hide();
                    }
                },

            });
        });
    });


    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode != 45 && charCode > 31 && (charCode < 48 || charCode > 57)) {

            alert("Please Enter Numeric Value");
            return false;
        }
        return true;
    }
</script>

<script>
    // Get all input elements with the class 'capitalize-both'
    var inputElements = document.querySelectorAll('.capitalize-word');

    // Add an event listener to each input element
    inputElements.forEach(function(inputElement) {
        inputElement.addEventListener('input', function() {
            // Get the input value
            var inputValue = inputElement.value;

            // Capitalize the first letter of each word
            inputValue = inputValue.split(' ').map(function(word) {
                return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
            }).join(' ');

            // Set the modified value back to the input element
            inputElement.value = inputValue;
        });
    });
</script>