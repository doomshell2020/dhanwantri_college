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
    <tbody id="example23"></tbody>
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
                    <a href="<?= SITE_URL; ?>admin/studentfees/view/<?= $work['id']; ?>" target="_blank">
                        <i class="fa fa-money" title="Deposit Fees" aria-hidden="true"></i></a>
                </td>
                <td><?php echo $work['fathername']; ?></td>
                <td><?php echo $work['mobile']; ?></td>
                <td><?php echo $work['batch']; ?></td>
                <td><?php echo $work['classtitle']; ?></td>
                <td><b>CheckIn Date :</b> <?php echo $checkIndate; ?><br><b>CheckOut Date :</b> <?php echo $checkOutdate; ?>
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