<div class="modal-header" style="background-color: #2d95e3;">
    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title" style="margin: 0px !important;"></h4>
    <!-- <i class="fa fa-plus-square"></i> -->
</div>

<div class="modal-body">
<table class="table table-striped table-bordered" cellpadding="10">
    <thead>
        <tr>
            <th>#</th>
            <th>Exam Name</th>
            <th>Subject Name</th>
            <th>Year</th>
            <th>Result</th>
            <th>Exam Date</th>
            <th class="action-column">Exam Result Date</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $i = 1;
        $findexam_name = $this->Comman->findexam_id($students_id);

        foreach ($findexam_name as $key => $value) {


            $studetnt_result = $this->Comman->findStudentsResult($students_id, $value['id']);

            $studetnt_backlog_result = $this->Comman->findStudentsBacklogResult($students_id);



            foreach ($studetnt_result as $key => $values) {
                $findSubjName = $this->Comman->findsubjnames($values['subject_id']);
        ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $value['exam_name']; ?></td>
                    <td><?php echo $findSubjName['subject']; ?></td>
                    <td><?php echo $value['exam_year']; ?></td>
                    <td><?php echo $values['result']; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($value['exam_date'])); ?></td>
                    <td><?php echo date('d-m-Y', strtotime($value['result_date'])); ?></td>
                </tr>

            <?php $i++;
            }
            ?>

            <?php if (!empty($studetnt_backlog_result)) {
                foreach ($studetnt_backlog_result as $keys => $findStudentsResult) {
                    $findSubjName = $this->Comman->findsubjbacklog($findStudentsResult['subject_id']);
            ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value['exam_name']; ?></td>
                        <td><?php echo $findSubjName['subject']; ?></td>
                        <td><?php echo $value['exam_year']; ?></td>
                        <td><?php echo $findStudentsResult['result']; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($value['exam_date'])); ?></td>
                        <td><?php echo date('d-m-Y', strtotime($value['result_date'])); ?></td>
                    </tr>


        <?php     }
            }
        } ?>
    </tbody>
</table>

</div>
<div class="modal-footer" style="padding: 0px !important";>
</div>