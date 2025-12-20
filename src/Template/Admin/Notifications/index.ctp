<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h3>
            Manage | Notification
        </h3>
        <ol class="breadcrumb">
            <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="<?php echo ADMIN_URL; ?>assignments/index">Manage Assignment</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            <i class="fa fa-search"></i> View Notification List
                        </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <div class="clearfix">

                        </div>
                        <div class="manag-stu">
                            <script src="http://code.jquery.com/jquery-1.12.3.min.js"></script>
                            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
                            <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
                            <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

                            <script inline="1">
                                //<![CDATA[
                                $(document).ready(function() {
                                    $("#notificationsearch").bind("submit", function(event) {
                                        $.ajax({
                                            async: true,
                                            data: $("#notificationsearch").serialize(),
                                            dataType: "html",
                                            type: "POST",
                                            url: "<?php echo ADMIN_URL; ?>notifications/search",
                                            success: function(data) {
                                                //	$("#updt").show();
                                                $("#example2").html(data);
                                            },
                                        });
                                        return false;
                                    });

                                    jQuery($ => {

                                        let $checkBox = $('#type').on('change', e => {
                                            var $select = $(e.target).closest('.form-group').find('.action');
                                            if (e.target.value == 'Staff') {
                                                $('.action').prop('disabled', 'disabled');

                                            } else {
                                                $('.action').prop('disabled', false);
                                                $('.action').attr('required', true);
                                            }

                                        });
                                    });

                                });
                                //]]>
                            </script>
                            <?php echo $this->Form->create('Task', array('url' => array('controller' => 'notifications', 'action' => 'search'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'notificationsearch', 'class' => 'form-horizontal')); ?>
                            <div class="form-group">

                                <div class="col-sm-3">
                                    <label for="inputEmail3" class="control-label">&nbsp;&nbsp;&nbsp;Select Type <span style="color:red">*</span></label>

                                    <?php $type = ['Student' => 'Student', 'Staff' => 'Staff']; ?>

                                    <?php echo $this->Form->input('type', array('class' => 'form-control type', 'type' => 'select', 'id' => 'type', 'empty' => '--Select Type--', 'options' => $type, 'label' => false, 'required' => true)); ?>
                                </div>

                                <div class="col-sm-3">
                                    <label for="inputEmail3" class="control-label">Class<span style="color:red;">*</span></label>
                                    <select class="form-control action" name="class_section" id="class_id">
                                        <option value="">--Select Class--</option>

                                        <?php foreach ($cls as $ks => $val1) {
                                            foreach ($sec as $kd => $val2) {
                                                if ($ks == $kd) {
                                                    $cl1 = $this->Comman->findclass123($val1);
                                                    $sl2 = $this->Comman->findsection123($val2);

                                        ?>
                                                    <option value="<?php echo $val1 . '-' . $val2; ?>"><?php echo $cl1['title'] . ' (' . $sl2['title'] . ')'; ?></option>

                                        <?php }
                                            }
                                        }  ?>

                                    </select>
                                </div>


                                <div class="col-sm-3" style="margin-top:24px;">
                                    <button type="submit" class="btn btn-success">Search</button>
                                    <button type="reset" class="btn btn-primary">Reset</button>
                                </div>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header" style="display: flex; align-items: center;">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <h3 class="box-title" style="flex: 1;">Post Home work List</h3>
                        <!-- <div class="text-right"> -->
                        <a href="<?php echo ADMIN_URL; ?>notifications/add" class="btn btn-default">Send Notification</a>
                        <!-- </div> -->
                    </div>
                    <!-- /.box-header -->
                    <?php echo $this->Flash->render(); ?>
                    <div class="box-body">
                        <table id="" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="20%">Message</th>
                                    <th width="20%">Image</th>

                                    <th>Type</th>
                                    <th width="15%">Class-Section</th>
                                    <!-- <th>Subject</th> -->
                                    <!-- <th>Allocate Date</th> -->
                                    <th>Date</th>
                                    <!-- <th>Download</th> -->
                                    <?php //if ($role_id == '3' || $role_id == '1' || $role_id == '6') { 
                                    ?>
                                    <th width="7%">Action</th>
                                    <?php //} 
                                    ?>
                                </tr>
                            </thead>
                            <tbody id="example2">
                                <?php $page = $this->request->params['paging']['Students']['page'];
                                $limit = $this->request->params['paging']['Students']['perPage'];
                                $counter = ($page * $limit) - $limit + 1;
                                if (isset($notifications) && !empty($notifications)) {
                                    foreach ($notifications as $work) {
                                        // pr($work); die;
                                ?>
                                        <tr>
                                            <td><?php echo $counter++; ?></td>
                                            <td><?php echo $work['message']; ?></td>
                                            <td><?php
                                                $db = $this->request->session()->read('Auth.User.db');
                                                $img = explode(",", $work['image']);
                                                foreach ($img as $value) {  //pr($value);
                                                    if ($value) {

                                                ?>

                                                        <img src="<?php echo  SITE_URL . $db . "_image/" . $value ?>" height="100px" width="100px">

                                                    <?php } else { ?>
                                                        <h6> No Image Available </h6>
                                                <?php    }
                                                } ?>
                                            </td>

                                            <td><?php echo $work['type']; ?></td>
                                            <td><?php $clid = explode(',', $work['class_id']);
                                                $slid = explode(',', $work['section_id']);
                                                foreach ($clid as $kd => $va1) {
                                                    foreach ($slid as $ks => $va2) {
                                                        if ($kd == $ks) {
                                                            $cl1 = $this->Comman->findclass123($va1);
                                                            $sl2 = $this->Comman->findsection123($va2);
                                                            echo $cl1['title'] . ' -' . $sl2['title'] . '<br>';
                                                        }
                                                    }
                                                } ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($work['create_date'])); ?></td>

                                            <?php //$role = $this->request->session()->read('Auth.User.role_id');
                                            // if ($role == '3' || $role_id == '1' || $role_id == '6') {   
                                            ?>
                                            <td><?php
                                                // echo $this->Html->link('Edit', [
                                                //     'action' => 'edit',
                                                //     $work->id
                                                // ], ['class' => 'btn btn-primary']); 
                                                ?>

                                                <?php if ($work['featured'] == 'Y') {
                                                    echo $this->Html->link('', [
                                                        'action' => 'status',
                                                        $work->id, 'Y'
                                                    ], ['title' => 'Active', 'class' => 'fas fa-check-circle', 'style' => 'font-size: 16px !important; margin-left: 12px; color: #36cb3c;']);
                                                } else {
                                                    echo $this->Html->link('', [
                                                        'action' => 'status', $work->id, 'N'
                                                    ], ['title' => 'Inactive', 'class' => 'fas fa-times-circle', 'style' => 'font-size: 16px !important; margin-left: 12px; color:#cd0404;']);
                                                } ?>

                                                <a title='Delete' href="<?php echo SITE_URL; ?>admin/notifications/delete/<?php echo $work->id; ?>" style="font-size: 16px !important; color: red;" onclick="javascript: return confirm('Are you sure do you want to delete this Notification.')"><span class="fa fa-trash"></span></a>
                                            </td>
                                            <?php // } 
                                            ?>
                                        </tr>
                                    <?php $counter + 1;
                                    }
                                } else { ?>
                                    <tr>
                                        <td colspan="9">NO Data Available</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <?php
                        // $role = $this->request->session()->read('Auth.User.role_id');
                        // if ($role == '3') {
                        //     echo $this->Html->link('Back To Timetable', [
                        //         'controller' => 'classtime_tabs', 'action' => 'teachertimetable'
                        //     ], ['class' => 'btn btn-default']);
                        // } else {
                        //     echo $this->Html->link('Back To Timetable', [
                        //         'controller' => 'classtime_tabs', 'action' => 'view/' . $seletedclassid . '/' . $seletedsectionid
                        //     ], ['class' => 'btn btn-default']);
                        // } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>