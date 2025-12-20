<table class="table table-bordered table-striped">
    <!--
                        <tr>
                        <td><a id="" style="position: absolute;
                        top: -163px;
                        /* right: 0px; */
                        right: 46px;" class="btn btn-info btn-sm pull-right" target="_blank" href="<?php echo ADMIN_URL; ?>report/smsdeliverdreports"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Excel</a></td>
                        </tr>
                        -->
    <thead>
        <tr>
            <th width="3%"># </th>
            <th width="4%">S.No.</th>
            <th width="12%">Student Name</th>
            <th width="12%">Fathers Name</th>
            <th width="9%">Class/Year</th>
            <!-- <th width="4%">Section</th> -->
            <th width="32%">Category</th>
            <th width="12%">Document Detail</th>
            <th width="8%">Submitted Date</th>
            <th width="6%">Download</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $page = $this->request->params['paging']['Documents']['page'];
        $limit = $this->request->params['paging']['Documents']['perPage'];
        $counter = ($page * $limit) - $limit + 1;

        if (isset($students) && !empty($students)) {
            foreach ($students as $work) {//pr($work);
                if ($work['student']['fname']) {
                    ?>
                    <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo $work['student']['enroll']; ?></td>
                    <td>
                        <?php echo $work['student']['fname'] . ' ' . $work['student']['middlename'] . ' ' . $work['student']['lname']; ?>
                    </td>
                    <td><?php echo $work['student']['fathername']; ?></td>
                    <td>
                        <?php $classname = $this->Comman->findclass123($work['student']['class_id']);
                        $sectionname = $this->Comman->findsection123($work['student']['section_id']);
                        echo $classname['title'] . '/' . $sectionname['title']; ?>
                    </td>
                    <!-- <td>
                            <?php $sectionname = $this->Comman->findsection123($work['student']['section_id']);
                            echo $sectionname['title']; ?>
                          </td> -->
                    <td><?php echo $work['documentcategory']['categoryname']; ?></td>
                    <td><?php echo $work['description']; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($work['created'])); ?></td>
                    <td><?php if (isset($value['photo'])) { ?><a download="Document.<?php echo $work['ext']; ?>"
                                href="<?php echo SITE_URL; ?>webroot/img/<?php echo $work['photo']; ?>" class="btn btn-default btn-sm"
                                target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a> <?php } else {
                        echo "N\A";
                    } ?><br>
                    </td>
                    </tr>
                    <?php $counter++;
                }
            }
        } else { ?>
            <tr>
                <td colspan="10" style="text-align:center;"><b>NO Dosument Added Yet</b></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php echo $this->element('admin/pagination'); ?>