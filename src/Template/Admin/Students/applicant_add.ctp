<!-- Content Wrapper. Contains page content -->
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
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Registration Manager</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo ADMIN_URL; ?>report/prospect"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="<?php echo ADMIN_URL; ?>report/prospect">Manage Applicant</a></li>
            <li class="active">Create Registration</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- right column -->
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> Register Student</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php echo $this->Flash->render(); ?>
                    <?php echo $this->Form->create($applicant, array(
                        'class' => 'form-horizontal',
                        'id' => 'student_form',
                        'enctype' => 'multipart/form-data',
                        'validate',
                    )); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-md-4 col-sm-6">
                                <label for="inputEmail3" class="control-label">Form Serial No<span style="color:red;">*</span></label>
                                <?php echo $this->Form->input('sno', array('class' => 'form-control secrh-loc', 'placeholder' => 'Form serial no.', 'required', 'id' => 'title', 'label' => false)); ?>
                                <span id="spinner" style="color: red;"></span>
                            </div>

                            <?php $getdetailuser = $this->Comman->findacedemicyears();
                            if ($getdetailuser['is_prospectskip'] == "N") { ?>

                                <script>
                                    var SITE_URL = '<?php echo SITE_URL ?>';
                                    $(function() {

                                        $('.secrh-loc').bind('blur', function() {
                                            var pos = $('.secrh-loc').val();
                                            var radioValue = $("input[name='category']:checked").val();
                                            var pl = pos.length;
                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo ADMIN_URL; ?>Students/tasksearch',
                                                data: {
                                                    'fetch': pos,
                                                    'radioValue': radioValue
                                                },
                                                beforeSend: function(xhr) {
                                                    xhr.setRequestHeader('X-CSRF-Token', $(
                                                        '[name="_csrfToken"]').val())
                                                },
                                                success: function(data) {

                                                    if (data == 1) {
                                                        $('#spinner').css("display", "inline");
                                                        $('#spinner').html(
                                                            "This Applicant is already exists.");
                                                        $('.secrh-loc').val("");
                                                        $('.secrh-loc').focus();
                                                    } else if (data == 0) {
                                                        $('#spinner').html("No records available.");
                                                        $('#spinner').css("display", "inline");
                                                        $('.secrh-loc').val("");
                                                        $('#fname').val("");
                                                        $('#mname').val('');
                                                        $('#lname').val('');
                                                        $('#subjt').val('');
                                                        $('#f_phone').val('');
                                                        //$('.secrh-loc').focus();
                                                    } else {
                                                        $('#spinner').css("display", "none");
                                                        var ar1 = data.split(',');
                                                        var bn = ar1[0].split(' ');
                                                        var lk = bn.length;

                                                        $('#fname').val(bn[0]);
                                                        $('#lname').val(bn[1]);
                                                        $('#subjt').val(ar1[1]);
                                                        //  $('#h1').val(ar1[1]);
                                                        $('#f_phone').val(ar1[2]);
                                                        $('#name').val(ar1[3]);
                                                        $('#fathername').val(ar1[4]);
                                                        $('#mname').val(ar1[5]);
                                                        // $('#mother_tounge').val(ar1[6]);
                                                        $('#f_qualification').val(ar1[7]);
                                                        $('#f_occupation').val(ar1[8]);
                                                        $('#m_name').val(ar1[9]);
                                                        $('#m_qualification').val(ar1[10]);
                                                        $('#m_occupation').val(ar1[11]);
                                                        $('#m_phone').val(ar1[12]);
                                                        $('#m_qualification').val(ar1[13]);
                                                        //  $('#pob').val(ar1[14]);
                                                        $('#lname').val(ar1[15]);
                                                        $('#academic').val(ar1[16]);

                                                    }
                                                },

                                            });
                                        });
                                    });
                                </script>
                            <?php } else { ?>
                                <script>
                                    var SITE_URL = '<?php echo SITE_URL ?>';
                                    $(function() {

                                        $('.secrh-loc').bind('blur', function() {

                                            var pos = $('.secrh-loc').val();

                                            var radioValue = $("input[name='category']:checked").val();

                                            var pl = pos.length;


                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo ADMIN_URL; ?>Students/tasksearch',
                                                data: {
                                                    'fetch': pos,
                                                    'radioValue': radioValue
                                                },
                                                beforeSend: function(xhr) {
                                                    xhr.setRequestHeader('X-CSRF-Token', $(
                                                        '[name="_csrfToken"]').val())
                                                },
                                                success: function(data) {

                                                    if (data == 1) {
                                                        $('#spinner').css("display", "inline");
                                                        $('#spinner').html(
                                                            "This Applicant is already exists.");
                                                        $('.secrh-loc').val("");
                                                        $('.secrh-loc').focus();
                                                    } else if (data == 0) {
                                                        //$('#spinner').html("No records available.");
                                                        // $('#spinner').css("display", "inline");
                                                        //$('.secrh-loc').val("");
                                                        $('#spinner').css("display", "none");
                                                        $('#fname').val("");
                                                        $('#mname').val('');
                                                        $('#lname').val('');
                                                        $('#subjt').val('');
                                                        $('#f_phone').val('');
                                                        //$('.secrh-loc').focus();
                                                    } else {
                                                        $('#spinner').css("display", "none");
                                                        var ar1 = data.split(',');
                                                        var bn = ar1[0].split(' ');
                                                        var lk = bn.length;

                                                        $('#fname').val(bn[0]);
                                                        $('#lname').val(bn[1]);
                                                        $('#subjt').val(ar1[1]);
                                                        //  $('#h1').val(ar1[1]);
                                                        $('#f_phone').val(ar1[2]);
                                                        $('#name').val(ar1[3]);
                                                        $('#fathername').val(ar1[4]);
                                                        $('#mname').val(ar1[5]);
                                                        // $('#mother_tounge').val(ar1[6]);
                                                        $('#f_qualification').val(ar1[7]);
                                                        $('#f_occupation').val(ar1[8]);
                                                        $('#m_name').val(ar1[9]);
                                                        $('#m_qualification').val(ar1[10]);
                                                        $('#m_occupation').val(ar1[11]);
                                                        $('#m_phone').val(ar1[12]);
                                                        $('#m_qualification').val(ar1[13]);
                                                        //  $('#pob').val(ar1[14]);
                                                        $('#lname').val(ar1[15]);
                                                        $('#academic').val(ar1[16]);



                                                    }
                                                },

                                            });
                                        });
                                    });
                                </script>
                            <?php } ?>
                            <? /* ?>
                     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
                     <script
                        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
                     <link rel="stylesheet"
                        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
                     <script>
                        $(document).ready(function() {
                        
                            $('#mname').typeahead({
                                source: function(query, result) {
                                    $.ajax({
                                        url: "<? echo ADMIN_URL; ?>students/findlname",
                                        method: "POST",
                                        data: {
                                            query: query
                                        },
                                        dataType: "json",
                                        success: function(data) {
                                            result($.map(data, function(item) {
                                                return item;
                                            }));
                                        }
                                    })
                                }
                            });
                        
                        });
                     </script>
                     <? */ ?>
                            <div class="col-md-4 col-sm-6">
                                <div><label>If Switch Registration</label></div>
                                <label class="radio-inline">
                                    <input type="radio" name="category" id="inlinessRadio2" class="cnormm" value="NORMAL" checked> NORMAL
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="category" id="inlinessRadio3" class="cnormm" value="Migration"> Migration
                                </label>
                            </div>
                            <script language="javascript" type="text/javascript">
                                $(document).ready(function(e) {

                                    $("#inlinessRadio2").click(function() {
                                        if ($(this).val() == 'NORMAL') {

                                            // $('.secrh-loc').blur();
                                            var query = '1';
                                            $.ajax({
                                                url: "<? echo ADMIN_URL; ?>students/findacdemicbck",
                                                method: "POST",
                                                data: {
                                                    query: query
                                                },
                                                dataType: "json",
                                                beforeSend: function(xhr) {
                                                    xhr.setRequestHeader('X-CSRF-Token', $(
                                                        '[name="_csrfToken"]').val())
                                                },
                                                success: function(data) {

                                                    $('.reciii').val(data);
                                                }
                                            });
                                        }

                                    });

                                    $("#inlinessRadio3").click(function() {
                                        if ($(this).val() == 'Migration') {
                                            // $('.secrh-loc').blur();
                                            var query = '2';
                                            $.ajax({
                                                url: "<? echo ADMIN_URL; ?>students/findacdemicbck",
                                                method: "POST",
                                                data: {
                                                    query: query
                                                },
                                                dataType: "json",
                                                beforeSend: function(xhr) {
                                                    xhr.setRequestHeader('X-CSRF-Token', $(
                                                        '[name="_csrfToken"]').val())
                                                },
                                                success: function(data) {

                                                    $('.reciii').val(data);
                                                }
                                            });
                                        }

                                    });

                                });
                            </script>
                            <div class="col-md-4 col-sm-6">
                                <label for="inputEmail3" class="control-label">Class<span style="color:red;">*</span></label>
                                <?php echo $this->Form->input('class_id', array('class' => 'form-control', 'id' => 'subjt', 'type' => 'select', 'empty' => 'Select Class', 'options' => $classes, 'label' => false, 'required')); ?>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <label for="inputEmail3" class="control-label">Academic Year<span style="color:red;">*</span></label>

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
                            <div class="col-md-4 col-sm-6">
                                <label for="inputEmail3" class="control-label">Receipt No<span style="color:red;">*</span></label>
                                <?php echo $this->Form->input('recipietno', array('class' => 'form-control reciii', 'readonly', 'value' => $recipietno, 'type' => 'text', 'label' => false)); ?>
                            </div>
                        </div>
                        <div class="form-group select_paymodedv">
                            <div class="col-md-12 col-xs-12">
                                <div><label style="color:red;">Select Payment Mode<span> *</span></label></div>
                                <label class="radio-inline">
                                    <input type="radio" name="modes" class="mode radio-inline checkstr" value="CASH" checked>&nbsp;CASH
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="modes" class="mode radio-inline checkstr" value="NETBANKING">&nbsp;NETBANKING
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="modes" class="mode radio-inline checkstr" value="Credit Card/Debit Card/UPI">&nbsp;CREDIT
                                    CARD/DEBIT CARD
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="modes" class="mode radio-inline checkstr" value="Z">&nbsp;Zero Deposit
                                </label>
                            </div>

                            <script type="text/javascript">
                                $(".checkstr").click(function() {
                                    var docgh = $('input[name="modes"]:checked').val();
                                    if (docgh == "CASH") {
                                        $("#refs").hide();
                                        document.getElementById('refnos').required = false;
                                    } else if (docgh == "NETBANKING") {
                                        $("#refs").show();
                                        document.getElementById('refnos').required = true;
                                    } else if (docgh == "Credit Card/Debit Card/UPI") {
                                        $("#refs").show();
                                        document.getElementById('refnos').required = true;
                                    }
                                });
                            </script>


                            <div class="col-md-4 col-sm-6" id="refs" style="display:none">
                                <label for="inputEmail3" class="control-label">Reference Number<span style="color:red;">*</span></label>
                                <?php echo $this->Form->input('ref_no', array('class' => 'form-control', 'maxlength' => '30', 'id' => 'refnos', 'placeholder' => 'Reference Number', 'type' => 'text', 'label' => false)); ?>
                            </div>
                        </div>
                        <fieldset>
                            <legend><i class="fa fa-child" aria-hidden="true"></i> Applicant Information</legend>
                            <div class="form-group">
                                <div class="col-md-4 col-sm-6">
                                    <label for="inputEmail3" class="control-label">Pupil's First Name<span style="color:red;">*</span></label>
                                    <?php echo $this->Form->input('fname', array('class' => 'form-control', 'placeholder' => 'First Name', 'required', 'autocomplete' => 'off', 'id' => 'fname', 'label' => false)); ?>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <label for="inputEmail3" class="control-label">Middle Name</label>
                                    <?php echo $this->Form->input('middlename', array('class' => 'form-control', 'placeholder' => 'Middle Name', 'autocomplete' => 'off', 'id' => 'mname', 'label' => false)); ?>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <label for="inputEmail3" class="control-label">Last Name</label>
                                    <?php echo $this->Form->input('lname', array('class' => 'form-control', 'placeholder' => 'Last Name', 'autocomplete' => 'off', 'id' => 'lname', 'label' => false)); ?>
                                </div>
                                <div class="col-md-4 col-sm-6" style="margin-top:10px;">
                                    <div><label for="inputEmail3" class="control-label">Gender</label></div>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" id="inlineRadio1" checked value="Male"> Male
                                    </label>
                                    <label for="inputEmail3" class="radio-inline">
                                        <input type="radio" name="gender" id="inlineRadio2" value="Female"> Female
                                    </label>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <label for="inputEmail3" class="control-label ">DATE Of BIRTH<span style="color:red;">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php echo $this->Form->input('dob', array('class' => 'form-control data', 'autocomplete' => 'off', 'placeholder' => 'Date Of Birth', 'id' => 'datepick1', 'label' => false, 'required')); ?>
                                    </div>
                                    <span style="color:red; display:none;" class="display_error">New Student
                                        D.O.B. must have 2
                                        years old.</span>
                                    <span style="color:red; display:none;" class="display_age">Age: <span id="age"></span> Years <span id="age_mon"></span> Months old</span>
                                </div>


                                <script type="text/javascript">
                                    $("#datepick1").change(function() {

                                        var stu = $("#datepick1").val().split('/');
                                        var wMonths = ['January', 'February', 'March', 'April', 'May', 'June',
                                            'July', 'August',
                                            'September', 'October', 'November', 'December'
                                        ]
                                        var final = toWords(stu[0]) + " " + wMonths[parseInt(stu[1]) - 1] + " " +
                                            toWords(stu[2])
                                        $('#bhu').val(final);
                                        var mdate = $("#datepick1").val().toString();
                                        var dayThen = parseInt(mdate.substring(0, 2), 10);
                                        var monthThen = parseInt(mdate.substring(3, 5), 10);
                                        var yearThen = parseInt(mdate.substring(6, 10), 10);
                                        var today = new Date();
                                        var birthday = new Date(yearThen, monthThen - 1, dayThen);
                                        var differenceInMilisecond = today.valueOf() - birthday.valueOf();
                                        var year_age = Math.floor(differenceInMilisecond / 31536000000);
                                        var day_age = Math.floor((differenceInMilisecond % 31536000000) / 86400000);
                                        var month_age = Math.floor(day_age / 30);
                                        day_age = day_age % 30;
                                        $('#age').html(year_age);
                                        $('#age_mon').html(month_age);
                                        $('.display_age').show();
                                    });

                                    // American Numbering System
                                    var th = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];
                                    var dg = ['Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight',
                                        'Nine'
                                    ];
                                    var tn = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen',
                                        'Seventeen',
                                        'Eighteen', 'Nineteen'
                                    ];
                                    var tw = ['Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

                                    function toWords(s) {
                                        s = s.toString();
                                        s = s.replace(/[\, ]/g, '');
                                        if (s != parseFloat(s)) return 'not a number';
                                        var x = s.indexOf('.');
                                        if (x == -1) x = s.length;
                                        if (x > 15) return 'too big';
                                        var n = s.split('');
                                        var str = '';
                                        var sk = 0;
                                        for (var i = 0; i < x; i++) {
                                            if ((x - i) % 3 == 2) {
                                                if (n[i] == '1') {
                                                    str += tn[Number(n[i + 1])] + ' ';
                                                    i++;
                                                    sk = 1;
                                                } else if (n[i] != 0) {
                                                    str += tw[n[i] - 2] + ' ';
                                                    sk = 1;
                                                }
                                            } else if (n[i] != 0) {
                                                str += dg[n[i]] + ' ';
                                                if ((x - i) % 3 == 0) str += 'hundred ';
                                                sk = 1;
                                            }
                                            if ((x - i) % 3 == 1) {
                                                if (sk) str += th[(x - i - 1) / 3] + ' ';
                                                sk = 0;
                                            }
                                        }
                                        if (x != s.length) {
                                            var y = s.length;
                                            str += 'point ';
                                            for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
                                        }
                                        return str.replace(/\s+/g, ' ');
                                    }
                                </script>

                                <script>
                                    // this code use to dob readonly after chose date 
                                    $('.data').change(function() {
                                        stu_dob = $(this).val();
                                        if (stu_dob) {
                                            $('.data').attr('readonly', 'readonly');
                                        } else {
                                            $('.data').attr('readonly', false);
                                        }
                                    });
                                </script>



                                <script>
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

                                <div class="col-md-4 col-sm-6">
                                    <label for="inputEmail3" class="control-label">DATE OF BIRTH(IN WORDS)</label>
                                    <?php echo $this->Form->input('dob_word', array('class' => 'form-control', 'placeholder' => 'Date of Birth in Words', 'id' => 'bhu', 'label' => false, 'readonly')); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4 col-sm-6">
                                    <label for="inputEmail3" class="control-label">PLACE OF BIRTH</label>
                                    <?php echo $this->Form->input('pob', array('class' => 'form-control', 'placeholder' => 'Place of Birth', 'id' => 'pob', 'label' => false)); ?>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <label for="inputEmail3" class="control-label">PREVIOUS BOARD<span style="color:red;">*</span></label>
                                    <?php
                                    echo $this->Form->input('previous_board', array('class' => 'form-control', 'placeholder' => 'Previous Board', 'type' => 'select', 'options' => $board_name, 'id' => 'previous_board', 'label' => false)); ?>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <label for="inputEmail3" class="control-label">MOTHER TONGUE</label>
                                    <?php echo $this->Form->input('mother_tounge', array('class' => 'form-control', 'placeholder' => 'Language', 'value' => 'HINDI', 'id' => 'mother_tounge', 'label' => false)); ?>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <label for="inputEmail3" class="control-label">Registration Fee Submitted by</label>
                                    <?php echo $this->Form->input('fee_submittedby', array('class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Name', 'id' => 'name', 'label' => false)); ?>
                                </div>
                            </div>
                        </fieldset>
                        <hr>
                        <fieldset>
                            <legend><i class="fa fa-user" aria-hidden="true"></i> Parent Information</legend>
                            <div class="form-group st_parent_infodv">
                                <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">FATHER'S NAME</label>
                                    <?php echo $this->Form->input('f_name', array('class' => 'form-control', 'placeholder' => 'Father Name', 'autocomplete' => 'off', 'id' => 'fathername', 'required', 'label' => false)); ?>
                                </div>
                                <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">QUALIFICATION</label>
                                    <?php echo $this->Form->input('f_qualification', array('class' => 'form-control', 'placeholder' => 'Qualification', 'id' => 'f_qualification', 'label' => false)); ?>
                                </div>
                                <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">OCCUPATION</label>
                                    <?php echo $this->Form->input('f_occupation', array('class' => 'form-control', 'placeholder' => 'Occupation', 'id' => 'f_occupation', 'label' => false)); ?>
                                </div>
                                <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">MOTHER/GUARDIAN'S NAME</label>
                                    <?php echo $this->Form->input('m_name', array('class' => 'form-control', 'placeholder' => 'Guardians Name', 'autocomplete' => 'off', 'id' => 'm_name', 'label' => false)); ?>
                                </div>
                                <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">QUALIFICATION</label>
                                    <?php echo $this->Form->input('m_qualification', array('class' => 'form-control', 'placeholder' => 'Qualification', 'id' => 'm_qualification', 'label' => false)); ?>
                                </div>
                                <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">OCCUPATION</label>
                                    <?php echo $this->Form->input('m_occupation', array('class' => 'form-control', 'placeholder' => 'Occupation', 'id' => 'm_occupation', 'label' => false)); ?>
                                </div>
                                <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">NATIONALITY</label>
                                    <select class="form-control" name="nationality" style="width: 100%;">
                                        <option value="INDIAN" selected="selected">INDIAN</option>
                                        <option value="OTHERS">OTHERS</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">PHONE NUMBER(MOTHER)</label>
                                    <?php echo $this->Form->input('m_phone', array('class' => 'form-control', 'placeholder' => 'Phone Number', 'autocomplete' => 'off', 'maxlength' => '10', 'minlength' => '10', 'id' => 'm_phone', 'label' => false, 'onkeypress' => 'return isNumber(event);')); ?>
                                </div>
                                <div class="col-sm-4 col-xs-6">
                                    <label for="inputEmail3" class="control-label">PHONE NUMBER(FATHER)<span style="color:red;">*</span></label>
                                    <?php echo $this->Form->input('f_phone', array('class' => 'form-control', 'placeholder' => 'Phone Number', 'autocomplete' => 'off', 'maxlength' => '10', 'minlength' => '10', 'id' => 'f_phone', 'label' => false, 'required', 'onkeypress' => 'return isNumber(event);')); ?>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend><i class="fa fa-user" aria-hidden="true"></i> Guardian Information</legend>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">GUARDIAN NAME</label>
                                    <?php echo $this->Form->input('fullname', array('class' => 'form-control', 'placeholder' => 'GUARDIAN NAME', 'autocomplete' => 'off', 'id' => 'fullname', 'label' => false)); ?>
                                </div>

                                <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">MOBILE No.</label>
                                    <?php echo $this->Form->input('mobileno', array('class' => 'form-control', 'onkeypress' => 'return isNumber(event);', 'placeholder' => 'MOBILE NO', 'id' => 'mobileno', 'label' => false, 'minlength' => '10', 'maxlength' => '10')); ?>
                                </div>

                                <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">RELATION</label>
                                    <?php echo $this->Form->input('relation', array('class' => 'form-control', 'placeholder' => 'RELATION', 'id' => 'relation', 'label' => false)); ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <?php
                    echo $this->Form->submit(
                        'Add',
                        array('class' => 'btn btn-info pull-right', 'title' => 'Add')
                    );
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
        <!--/.col (right) -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>