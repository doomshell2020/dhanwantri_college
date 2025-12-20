<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Branch Complain
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo ADMIN_URL; ?>Feedbacks/index"><i class="fa fa-home"></i>Home</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">

                        <!-- /.box-header -->
                        <?php echo $this->Flash->render(); ?>

                        <script>
                            $(document).ready(function() {
                                $("#Mysubscriptions").bind("submit", function(event) {
                                    $('.lds-facebook').show();
                                    $.ajax({
                                        async: true,
                                        data: $("#Mysubscriptions").serialize(),
                                        dataType: "html",
                                        type: "POST",
                                        url: "<?php echo ADMIN_URL; ?>Feedbacks/search",
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
                        <div class="form-group" style="display:flex; align-items: flex-end;">

                            <div class="col-sm-10">
                                <div class="row" style=align-item:end;display:flex;>

                                    <div class="col-sm-3">
                                        <label for="inputEmail3" class="control-label">Feedbacks Status</label>
                                        <select name="status" class="form-control" style="width:200px" required>
                                            <option value="N"> Open
                                            <option value="Y"> Close
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="inputEmail3" class="control-label" style="text-align: left !important;">Branch Name</label><span style="color:red;">*</span>
                                        <select name="branch_name" class="form-control" style="width:200px" required="required">
                                            <option value="">Select Branch Name</option>
                                            <?php foreach ($expload_branch_name as  $value) {  ?>
                                                <option value="<?php echo $value;
                                                                $branch_name = explode('_', $value);
                                                                ?>"><?php echo ucfirst($branch_name[1]); ?></option> <?php  } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3" style=" display: flex; align-items: end;">
                                        <input type="submit" style="background-color:#00c0ef; color:#fff;width:100px !important; margin-top: 20px;" id="Mysubscriptions" class="btn btn4 btn_pdf myscl-btn date" value="Search">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>

                                    <th>S.No.</th>
                                    <th>Branch Name</th>
                                    <th>Date</th>
                                    <th>Given FeedBack</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>FeedBack Category</th>
                                    <th>Feedback</th>
                                    <th>Remarks</th>
                                    <th>Contact No.</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $page = $this->request->params['paging']['Services']['page'];
                                $limit = $this->request->params['paging']['Services']['perPage'];
                                $counter = ($page * $limit) - $limit + 1;
                                if (isset($expload_branch_name) && !empty($expload_branch_name)) {
                                    foreach ($expload_branch_name as $val) {

                                        $feedback_data = $this->Comman->feedbackdata($val);
                                        if (!empty($feedback_data)) {
                                            foreach ($feedback_data as $value) {
                                                $created = date('d-m-Y', strtotime($value['created']));
                                                $curent_date = date('d-m-Y');
                                                $currenttime = date('d-m-Y', strtotime($curent_date . ' - 3 days'));
                                                if ($created <= $currenttime && $value['status'] == 'N') {   ?>

                                                    <tr>
                                                        <td><?php echo $counter; ?></td>
                                                        <td><?php
                                                            $branch_name = explode('_', $val);
                                                            echo ucfirst($branch_name['1']); ?></td>
                                                        <td><?php echo date('d-m-Y', strtotime($value['created'])); ?></td>
                                                        <td><?php echo $value['student_name']; ?></td>
                                                        <td><?php echo $value['class']; ?></td>
                                                        <td><?php echo $value['section']; ?></td>
                                                        <td><?php echo $value['name']; ?></td>
                                                        <td><?php echo $value['feedback']; ?></td>
                                                        <td><?php echo $value['remarks']; ?></td>
                                                        <td><?php echo $value['phone']; ?></td>
                                                        <td><?php echo $value['status'] == 'N' ? 'Open' : 'Close'; ?></td>
                                                    </tr>

                                    <?php $counter++;
                                                }
                                            }
                                        }
                                    }
                                } else { ?>
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