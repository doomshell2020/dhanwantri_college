<table id="" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Sr No.</th>
            <th>Student Name</th>
            <th>Class</th>
            <th>Father Name</th>
            <th>Mother Name</th>
            <th>Acedmic Year</th>
            <th>Action</th>

        </tr>
    </thead>
    <tbody>
        <?php $page = $this->request->params['paging']['Solditem']['page'];
        $limit = $this->request->params['paging']['Solditem']['perPage'];
        $counter = ($page * $limit) - $limit + 1;
        if (isset($feedata) && !empty($feedata)) {
            foreach ($feedata as $intusr) { //pr($intusr);exit;
        ?>
                <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo $intusr['student']['fname']; ?></td>
                    <td><?php echo $intusr['student']['class']['title'] . '-' . $intusr['student']['section']['title']; ?></td>
                    <td><?php echo $intusr['student']['fathername']; ?></td>
                    <td><?php echo $intusr['student']['mothername']; ?></td>
                    <td><?php echo $intusr['acedmicyear']; ?></td>
                    <td><a title="Print Receipt" target="_blank" href="<?php echo ADMIN_URL; ?>studentfees/newprintsadmission/<?php echo $intusr['id']; ?>/<?php echo $intusr['acedmicyear']; ?>"><i class="fa fa-file-text-o"></i></a></td>


                </tr>
            <?php $counter++;
            }
        } else { ?>
        <?php } ?>
    </tbody>
</table>