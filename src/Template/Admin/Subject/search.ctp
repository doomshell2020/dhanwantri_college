<table id="" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Subject Name</th>
            <th>Course Name</th>
            <th>Year/Semester</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="example2">
        <?php $page = $this->request->params['paging']['CourseSubjects']['page'];
        $limit = $this->request->params['paging']['CourseSubjects']['perPage'];
        $counter = ($page * $limit) - $limit + 1;
        if (isset($course_subject) && !empty($course_subject)) {
            foreach ($course_subject as $subject) {
        ?>
                <tr>
                    <td><?php echo $counter++; ?></td>
                    <td><?php echo $subject['subject']; ?></td>
                    <td><?php $class = $this->Comman->findclass($subject['course_id']);
                        echo $class['title']; ?></td>
                    <td><?php $section = $this->Comman->findsecti($subject['year']);
                        echo $section['title'];
                        ?>
                    </td>
                    <td>
                        <!-- <?php if ($subject['featured'] == 'Y') {
                                    echo $this->Html->link('', [
                                        'action' => 'status',
                                        $subject->id, 'Y'
                                    ], ['title' => 'Active', 'class' => 'fas fa-check-circle', 'style' => 'font-size: 16px !important; margin-left: 12px; color: #36cb3c;']);
                                } else {
                                    echo $this->Html->link('', [
                                        'action' => 'status', $subject->id, 'N'
                                    ], ['title' => 'Inactive', 'class' => 'fas fa-times-circle', 'style' => 'font-size: 16px !important; margin-left: 12px; color:#cd0404;']);
                                } ?> -->
                        <a title='Delete' href="<?php echo SITE_URL; ?>admin/subject/delete/<?php echo $subject->id; ?>" style="font-size: 16px !important; color: red;" onclick="javascript: return confirm('Are you sure do you want to delete this Notification.')"><span class="fa fa-trash"></span></a>
                        <!-- <a title='Edit' href="<?php // echo SITE_URL; 
                                                    ?>admin/subject/edit/<?php //echo $subject->id; 
                                                                            ?>" style="font-size: 16px !important; color: blue;"><span class="fa fa-edit"></span></a> -->
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
<?php
// if (count($course_subject) > 50) {
    echo $this->element('admin/pagination');
// }

?>