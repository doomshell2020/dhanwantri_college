<?php $page = $this->request->params['paging']['Students']['page'];
$limit = $this->request->params['paging']['Students']['perPage'];
$counter = ($page * $limit) - $limit + 1;
if (isset($notifications) && !empty($notifications)) {
    foreach ($notifications as $work) { //pr($work);
?>
        <tr>
            <td><?php echo $counter; ?></td>
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
    <?php  }
} else { ?>
    <tr>
        <td colspan="9">NO Data Available</td>
    </tr>
<?php } ?>