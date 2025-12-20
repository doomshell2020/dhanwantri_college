<style>
    .box-body {
        background-color: #fff;
    }

    .glyphicon.glyphicon-print::before {
        font-size: 22px;
    }
</style>


<div class="box-body" style="padding: 30px;">
    <?php
    $logo = SITE_URL . 'images/' . $sitesetting['small_logo'];

    $temp = str_replace(array('{logo}', '{sitetitle}', '{subtitle1}', '{subtitle2}', '{address1}', '{address2}', '{phone}', '{fax}', '{email}', '{website}'), array($logo, $sitesetting['sitetitle'], $sitesetting['subtitle1'], $sitesetting['subtitle2'], $sitesetting['address1'], $sitesetting['address2'], $sitesetting['phone'], $sitesetting['fax'], $sitesetting['email'], $sitesetting['website']), $det['template']);

    echo $temp;

    ?>
    <br>
    <td> <a id="" style=" display: block; width: max-content; margin-left: 0%;" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></a>
    <div class="table-responsive">
        <table id="" class="table table-bordered table-striped tableCellWidthMin">
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
            <tbody id="example2">
                <?php
                $page = $this->request->params['paging']['DropOutStudent']['page'];
                $limit = $this->request->params['paging']['DropOutStudent']['perPage'];
                $counter = ($page * $limit) - $limit + 1;

                if (isset($student_rec_all) && !empty($student_rec_all)) {
                    foreach ($student_rec_all as $work) {

                        $findLastCheckOutDate = $this->Comman->findLastCheckOutDate($work['id']);
                        // pr($findLastCheckOutDate['checkout_date']);

                        $checkOutdate = (date('Y', strtotime($findLastCheckOutDate['checkout_date'])) == '1970') ? 'N/A' : date('d-m-Y', strtotime($findLastCheckOutDate['checkout_date']));

                        $checkIndate = (date('Y', strtotime($findLastCheckOutDate['checkin_date'])) == '1970') ? 'N/A' : date('d-m-Y', strtotime($findLastCheckOutDate['checkin_date']));

                ?>
                        <tr>
                            <td><?php echo $counter; ?></td>
                            <td><?php echo $work['enrollno']; ?></td>
                            <td><?php echo $work['studentname']; ?></td>
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
    </div>
</div>