<style>
    .box-body {
        background-color: #fff;
    }

    .glyphicon.glyphicon-print::before {
        font-size: 22px;
    }
</style>
<div class="row">
    <div class="box-body" id="example23" style="padding: 30px;">
        <?php
        $logo = SITE_URL . 'images/' . $sitesetting['small_logo'];

        $temp = str_replace(array('{logo}', '{sitetitle}', '{subtitle1}', '{subtitle2}', '{address1}', '{address2}', '{phone}', '{fax}', '{email}', '{website}'), array($logo, $sitesetting['sitetitle'], $sitesetting['subtitle1'], $sitesetting['subtitle2'], $sitesetting['address1'], $sitesetting['address2'], $sitesetting['phone'], $sitesetting['fax'], $sitesetting['email'], $sitesetting['website']), $det['template']);

       // pr($sitesetting['small_logo']);die;
        echo $temp;
        ?>
        <br>

        <div class="table-responsive student_listtb_rspv">
            <div class="text-right">
                <a id="" style=" display: block; width: max-content; margin-left: 1%;" onclick="window.print()"><span
                        class="glyphicon glyphicon-print"></span></a>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Schloar No.</th>
                        <th>Name<br>(Fathername)<br>Mobile</th>
                        <th width="4%">Batch</th>
                        <th width="6%">Course<br>Year</th>
                        <th>Prev Due</th>
                        <th>Prev Paid</th>
                        <th>1stYr Fee</th>
                        <th>1stYr Paid</th>
                        <th>1stYr Trans Fee</th>
                        <th>1stYr Trans Paid</th>
                        <th>2ndYr Fee</th>
                        <th>2ndYr Paid</th>
                        <th>2ndYr Trans Fee</th>
                        <th>2ndYr Trans Paid</th>
                        <th>3rdYr Fee</th>
                        <th>3rdYr Paid</th>
                        <th>3rdYr Trans Fee</th>
                        <th>3rdYr Trans Paid</th>
                        <th>4thYr Fee</th>
                        <th>4thYr Paid</th>
                        <th>4thYr Trans Fee</th>
                        <th>4thYr Trans Paid</th>
                        <th>Discount</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 1;
                    if (isset($students) && !empty($students)) {

                        $total_discount = 0;
                        $totalsbatchfee = 0;
                        $totalbatchpaids = 0;
                        $sumbalance = 0;

                        foreach ($students as $work) {
                            $getFeesDetails = $this->Comman->getstudenttotalfeesdetails($work);

                            $section_id = $work['section_id'];

                            if ($section_id == 1) {
                                $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'];
                                $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'];
                                $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'];
                            } elseif ($section_id == 2) {
                                $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'];
                                $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'];
                                $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'];
                            } elseif ($section_id == 3) {
                                $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'];
                                $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'];
                                $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'];
                            } else {
                                $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['4th_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'] + $getFeesDetails['4th_year_transport_fees'];
                                $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['4th_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'] + $getFeesDetails['4th_year_students_transport_deposite'];
                                $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'] + $getFeesDetails['4th_year_students_discount'];
                            }

                            $total_balance = $total_batch_fee - $total_batch_paid_fee - $getFeesDetails['discount'];
                            if ($total_balance == 0) {
                                if ($no_dues == 1) {
                                } else {
                                    continue;
                                }
                            }
                            ?>
                            <tr>
                                <td><?php echo $counter; ?></td>
                                <td><?php echo $work['enroll']; ?></td>
                                <td>
                                    <?php echo $work['st_full_name'] . '<br>(' . $work['fathername'] . ')<br>' . $work['mobile']; ?>
                                </td>
                                <td><?php echo $work['batch']; ?></td>
                                <td><?php echo $work['class']['title'] . '<br>' . $work['section']['title']; ?></td>
                                <td><?php echo $getFeesDetails['previous_year']; ?></td>
                                <td><?php echo $getFeesDetails['previous_year_students_fee_deposite']; ?></td>
                                <td><?php echo $getFeesDetails['1st_year_total_fees']; ?></td>
                                <td><?php echo $getFeesDetails['1st_year_students_fee_deposite']; ?></td>
                                <td><?php echo $getFeesDetails['1st_year_transport_fees']; ?></td>
                                <td><?php echo $getFeesDetails['1st_year_students_transport_deposite']; ?></td>


                                <?php if ($section_id == 2 || $section_id == 3 || $section_id == 4) { ?>
                                    <td><?php echo $getFeesDetails['2nd_year_total_fees']; ?></td>
                                    <td><?php echo $getFeesDetails['2nd_year_students_fee_deposite']; ?></td>
                                    <td><?php echo $getFeesDetails['2nd_year_transport_fees']; ?></td>
                                    <td><?php echo $getFeesDetails['2nd_year_students_transport_deposite']; ?></td>
                                <?php } else { ?>
                                    <td>NA</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                <?php } ?>

                                <?php if ($section_id == 3 || $section_id == 4) { ?>
                                    <td><?php echo $getFeesDetails['3rd_year_total_fees']; ?></td>
                                    <td><?php echo $getFeesDetails['3rd_year_students_fee_deposite']; ?></td>
                                    <td><?php echo $getFeesDetails['3rd_year_transport_fees']; ?></td>
                                    <td><?php echo $getFeesDetails['3rd_year_students_transport_deposite']; ?></td>
                                <?php } else { ?>
                                    <td>NA</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                <?php } ?>

                                <?php if ($section_id == 4) { ?>
                                    <td><?php echo $getFeesDetails['4th_year_total_fees']; ?></td>
                                    <td><?php echo $getFeesDetails['4th_year_students_fee_deposite']; ?></td>
                                    <td><?php echo $getFeesDetails['4th_year_transport_fees']; ?></td>
                                    <td><?php echo $getFeesDetails['4th_year_students_transport_deposite']; ?></td>
                                <?php } else { ?>
                                    <td>NA</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                    <td>NA</td>
                                <?php } ?>

                                <td><?php echo $getFeesDetails['discount']; ?></td>
                                <td><?php echo $total_balance; ?></td>

                                <?php
                                // total previous year
                                $previous_year_total_fee += $getFeesDetails['previous_year'];
                                $previous_year_paid_fee += $getFeesDetails['previous_year_students_fee_deposite'];

                                // 1st year total  fees footer
                                $first_year_total_fee += $getFeesDetails['1st_year_total_fees'];
                                $first_year_paid_fee += $getFeesDetails['1st_year_students_fee_deposite'];
                                $first_year_transport_total_fee += $getFeesDetails['1st_year_transport_fees'];
                                $first_year_transport_paid_fee += $getFeesDetails['1st_year_students_transport_deposite'];

                                // 2nd year total fees footer
                                if ($section_id == 2 || $section_id == 3 || $section_id == 4) {
                                    $second_year_total_fee += $getFeesDetails['2nd_year_total_fees'];
                                    $second_year_paid_fee += $getFeesDetails['2nd_year_students_fee_deposite'];
                                    $second_year_transport_total_fee += $getFeesDetails['2nd_year_transport_fees'];
                                    $second_year_transport_paid_fee += $getFeesDetails['2nd_year_students_transport_deposite'];
                                }

                                //3rd year total fees footer
                                if ($section_id == 3 || $section_id == 4) {
                                    $third_year_total_fee += $getFeesDetails['3rd_year_total_fees'];
                                    $third_year_paid_fee += $getFeesDetails['3rd_year_students_fee_deposite'];
                                    $third_year_transport_total_fee += $getFeesDetails['3rd_year_transport_fees'];
                                    $third_year_transport_paid_fee += $getFeesDetails['3rd_year_students_transport_deposite'];
                                }

                                //4th year total fees footer
                                if ($section_id == 4) {
                                    $fourth_year_total_fee += $getFeesDetails['4th_year_total_fees'];
                                    $fourth_year_paid_fee += $getFeesDetails['4th_year_students_fee_deposite'];
                                    $fourth_year_transport_total_fee += $getFeesDetails['4th_year_transport_fees'];
                                    $fourth_year_transport_paid_fee += $getFeesDetails['4th_year_students_transport_deposite'];
                                }

                                // discount total
                                $total_discount += $getFeesDetails['discount'];
                                // balance total
                                $total += $total_balance;
                                ?>
                            </tr>
                            <?php $counter++;
                        } ?>
                        <tr>
                            <td colspan="5"><b>Total</b></td>
                            <td><b><?php echo $previous_year_total_fee; ?></b></td>
                            <td><b><?php echo $previous_year_paid_fee; ?></b></td>

                            <td><b><?php echo $first_year_total_fee; ?></b></td>
                            <td><b><?php echo $first_year_paid_fee; ?></b></td>
                            <td><b><?php echo $first_year_transport_total_fee; ?></b></td>
                            <td><b><?php echo $first_year_transport_paid_fee; ?></b></td>

                            <td><b><?php echo $second_year_total_fee; ?></b></td>
                            <td><b><?php echo $second_year_paid_fee; ?></b></td>
                            <td><b><?php echo $second_year_transport_total_fee; ?></b></td>
                            <td><b><?php echo $second_year_transport_paid_fee; ?></b></td>

                            <td><b><?php echo $third_year_total_fee; ?></b></td>
                            <td><b><?php echo $third_year_paid_fee; ?></b></td>
                            <td><b><?php echo $third_year_transport_total_fee; ?></b></td>
                            <td><b><?php echo $third_year_transport_paid_fee; ?></b></td>

                            <td><b><?php echo $fourth_year_total_fee; ?></b></td>
                            <td><b><?php echo $fourth_year_paid_fee; ?></b></td>
                            <td><b><?php echo $fourth_year_transport_total_fee; ?></b></td>
                            <td><b><?php echo $fourth_year_transport_paid_fee; ?></b></td>

                            <td><b><?php echo $total_discount; ?></b></td>
                            <td><b><?php echo $total; ?></b></td>
                        </tr>

                    <?php } else { ?>
                        <tr>
                            <td>NO Data Available</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>