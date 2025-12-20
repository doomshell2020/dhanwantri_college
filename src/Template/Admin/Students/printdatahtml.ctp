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

        echo $temp;

        ?>
        <br>

        <div class="table-responsive student_listtb_rspv">
            <div class="text-right">
                <a id="" style=" display: block; width: max-content; margin-left: 1%;" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></a>
            </div>
            <table class="table newclss table-bordered ">
                <thead>
                    <tr>
                        <th width="5%">Sr. No.</th>
                        <th width="5%">Schloar. No.</th>
                        <th width="5%">Student Type</th>
                        <th width="10%">Name</th>
                        <th width="5%">Mobile</th>
                        <th width="10%">Fathername</th>
                        <th width="5%">Gender</th>
                        <th width="5%">Batch</th>
                        <th width="8%">Course</th>
                        <th width="5%">Year/Semester</th>
                        <th width="5%">Is Hostal</th>
                        <th width="5%">Is Transport</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 1;
                    if (isset($students) && !empty($students)) {
                        foreach ($students as $work) { //pr($work); die;
                    ?>
                            <tr>
                                <td> <?= $counter; ?></td>
                                <td> <?= $work['enroll']; ?></td>
                                <td> <?= $work['mode']; ?></td>
                                <td>
                                    <?php
                                    if (isset($work['fname'])) {
                                        echo ucwords(strtolower($work['st_full_name']));
                                    } ?> </td>
                                <td><?= (!empty($work['mobile'])) ? $work['mobile'] : "N/A"; ?></td>
                                <td><?= (!empty($work['fathername'])) ? ucwords(strtolower($work['fathername'])) : "N/A"; ?></td>
                                <td><?= $work['gender']; ?></td>
                                <td><?= $work['batch']; ?></td>
                                <td><?= $work['class']['title']; ?></td>
                                <td><?= $work['section']['title']; ?></td>
                                <td><?= ($work['is_hostel']) ? 'Y' : 'N'; ?></td>
                                <td><?= ($value['is_transport'] == 'Y') ? 'Y' : 'N'; ?></td>
                            <?php $counter++;
                        }
                    } else {
                            ?>
                            <tr>
                                <td>NO Data Available</td>
                            </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>