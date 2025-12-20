<script>
    $(document).ready(function () {
        $("#TaskAdminCustomerForm").bind("submit", function (event) {
            $.ajax({
                async: true,
                data: $("#TaskAdminCustomerForm").serialize(),
                dataType: "html",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())
                    $('#load2').css("display", "block");
                },
                success: function (data, textStatus) {
                    $("#example23").html(data);
                },
                complete: function () {
                    $('#load2').css("display", "none");
                },
                type: "get",
                url: "<?php echo ADMIN_URL; ?>report/hostelcollectionsearch"
            });
            return false;
        });
    });

    $(document).on('click', '.pagination a', function (e) {
        var target = $(this).attr('href');
        var res = target.replace("/report/hostelcollectionsearch", "/hostelcollection");
        window.location = res;
        return false;
    });
</script>

<style>
    #load2 {
        width: 100%;
        height: 100%;
        position: fixed;
        z-index: 9999;
        background-color: white !important;
        background: url("<? echo SITE_URL; ?>images/Preloader_2.gif") no-repeat center center rgba(0, 0, 0, 0.75)
    }


    .dropppss:after {
        display: inline-block;
        width: 0;
        height: 0;
        margin-left: .255em;
        vertical-align: .255em;
        content: "";
        border-top: .3em solid;
        border-right: .3em solid transparent;
        border-bottom: 0;
        border-left: .3em solid transparent;
    }

    .hover:hover {
        background-color: #f1f1f1;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Hostel Fee Collection
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo ADMIN_URL; ?>report/hostelcollection"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="<?php echo ADMIN_URL; ?>report/hostelcollection">Hostel Fee Collection</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <h3 class="box-title">Search Student</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="manag-stu">
                            <?php
                            echo $this->Form->create('Task', array('url' => array('controller' => 'report', 'action' => 'hostelcollectionsearch'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'TaskAdminCustomerForm', 'class' => 'form-horizontal')); ?>

                            <div class="form-group">

                                <div class="col-md-2 col-sm-4">
                                    <label>Batch</label>
                                    <select class="form-control" name="batch">
                                        <option value="">Select Batch</option>
                                        <?php foreach ($academic_session as $esr => $es) { ?>
                                            <option value="<?php echo $esr; ?>"><?php echo $es; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-2 col-sm-4">
                                    <label>Course</label>
                                    <select class="form-control" name="class_id">
                                        <option value="">Select Course</option>
                                        <?php foreach ($classes as $esr => $es) { ?>
                                            <option value="<?php echo $esr; ?>"><?php echo $es; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                               
                                <div class="col-md-2 col-sm-4">
                                    <label>Name of Student</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Enter First Name">
                                </div>



                                <div class="col-md-4 col-sm-4" style="margin-top:23px;">
                                    <button type="submit" class="btn btn-success">Search</button>

                                    <a href="<?php echo SITE_URL; ?>admin/report/hostelcollection"
                                        class="btn btn-primary">Reset</a>


                                    <button class="btn btn-success dropdown-toggle dropppss" type="button"
                                        style="background: #00a65a;padding-left:20px;" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Report
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                        style="left: -30px !important; ">
                                        <a target="_blank" class="dropdown-item hover"
                                            style="display: block; color:black; padding:5px;"
                                            href="<?php echo SITE_URL; ?>admin/report/hostelcollectionhtml">Print</a>

                                        <a class="dropdown-item hover" style="display: block; color:black; padding:5px;"
                                            href="<?php echo SITE_URL; ?>admin/report/hostelfeesreport">Export to
                                            Excel</a>
                                    </div>
                                </div>


                            </div>

                            <?php
                            echo $this->Form->end();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            /* Tooltip container */
            .tooltip {
                position: relative;
                display: inline-block;
                border-bottom: 1px dotted black;
                /* If you want dots under the hoverable text */
            }

            /* Tooltip text */
            .tooltip .tooltiptext {
                visibility: hidden;
                width: 120px;
                background-color: black;
                color: #fff;
                text-align: center;
                padding: 5px 0;
                border-radius: 6px;
                /* Position the tooltip text - see examples below! */
                position: absolute;
                z-index: 1;
            }

            /* Show the tooltip text when you mouse over the tooltip container */
            .tooltip:hover .tooltiptext {
                visibility: visible;
            }
        </style>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <!-- /.box-header -->
                    <?php echo $this->Flash->render(); ?>
                    <div class="box-body">
                        <div id="load2" style="display:none;"></div>
                        <div class="table-responsive">
                            <div id="example23">

                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sr. No.</th>
                                            <th>Pupil Name</th>
                                            <th>Father Name</th>
                                            <th>Mobile</th>
                                            <th>Batch</th>
                                            <th>Course</th>
                                            <th>Info</th>
                                            <th>Total Fee</th>
                                            <th>Paid</th>
                                            <th>Discount</th>
                                            <th>Due Fee</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                         $page = $paging['page'];
                                         $limit = $paging['limit'];
                                         $counter = ($page * $limit) - $limit + 1;

                                        if (isset($student_rec_all) && !empty($student_rec_all)) {
                                            foreach ($student_rec_all as $work) {
                                                $findLastCheckOutDate = $this->Comman->findLastCheckOutDate($work['id']);
                                                $checkOutdate = (date('Y', strtotime($findLastCheckOutDate['checkout_date'])) == '1970') ? 'N/A' : date('d-m-Y', strtotime($findLastCheckOutDate['checkout_date']));
                                                $checkIndate = (date('Y', strtotime($findLastCheckOutDate['checkin_date'])) == '1970') ? 'N/A' : date('d-m-Y', strtotime($findLastCheckOutDate['checkin_date']));
                                                ?>
                                                <tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td><?php echo $work['enrollno']; ?></td>
                                                    <td>
                                                        <?php echo $work['studentname']; ?>
                                                        <a href="<?= SITE_URL; ?>admin/studentfees/view/<?= $work['id']; ?>"
                                                            target="_blank">
                                                            <i class="fa fa-money" title="Deposit Fees"
                                                                aria-hidden="true"></i></a>
                                                    </td>
                                                    <td><?php echo $work['fathername']; ?></td>
                                                    <td><?php echo $work['mobile']; ?></td>
                                                    <td><?php echo $work['batch']; ?></td>
                                                    <td><?php echo $work['classtitle']; ?></td>
                                                    <td><b>CheckIn Date :</b> <?php echo $checkIndate; ?><br><b>CheckOut Date
                                                            :</b>
                                                        <?php echo $checkOutdate; ?>
                                                    </td>
                                                    <td><?php echo $work['totalFeesToPay']; ?></td>
                                                    <td><?php echo $work['totalFeesPay']; ?></td>
                                                    <td><?php echo $work['discount']; ?></td>
                                                    <td><?php echo $work['totalPending']; ?></td>
                                                </tr>
                                                <?php $counter++;
                                            }
                                        } else { ?>
                                            <tr>
                                                <td>NO Data Available</td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>

                                <?php echo $this->element('admin/custompagination'); ?>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
</div>