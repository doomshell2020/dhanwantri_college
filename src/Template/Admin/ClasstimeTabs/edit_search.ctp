<?php $array = array();foreach ($employee as $key => $value) {
    $array[$key] = str_replace(";", " ", $value);

}?>
<?php $array1 = array();foreach ($newemployees as $key => $value) {
    $array1[$key] = str_replace(";", " ", $value);

}?>
<div class="box-header" style="margin-top:15px;margin-bottom:15px">
<div class="row">
<?php echo $this->Form->create('', ['url' => ['controller' => 'ClasstimeTabs', 'action' => 'aggsn_other']]); ?>
<div class="col-sm-3">
<?php echo $this->Form->input('', ['type' => 'select', 'class' => 'form-control', 'empty' => 'Select Teacher', 'options' => $array, 'value' => $teacherId, 'label' => false, 'disabled']); ?>
<?php echo $this->Form->input('old_id', ['type' => 'hidden', 'class' => 'form-control','value' => $teacherId, 'label' => false]); ?>
</div>
<div class="col-sm-3">
<p class="btn-success" style="text-align:center; width:10%;margin:auto"><i class="fa fa-chevron-right" aria-hidden="true"></i> <i class="fa fa-chevron-right" aria-hidden="true"></i></p>
</div>
<div class="col-sm-3">
<?php echo $this->Form->input('new_id', ['type' => 'select', 'class' => 'form-control', 'empty' => 'Select Teacher', 'options' => $array1, 'label' => false, 'required']); ?>
</div>
<div class="col-sm-3">
<?php echo $this->Form->input('Submit', ['type' => 'submit', 'value' => 'submit', 'class' => 'btn btn-success', 'label' => false]); ?>
</div>
<?php echo $this->Form->end(); ?>
</div>
</div>
<div class="box-body">
<table class="table table-bordered table-striped">
    <thead>

        <p class="text-right btn-view-group">
                <a class="btn btn-primary"
                href="<?php echo SITE_URL;?>admin/ClasstimeTabs/pdf_teacher/<?php echo $teacherId; ?>"
                target="blank"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
        </p>

        <?php $role =$this->request->session()->read("Auth.User.role_id"); ?>

        <tr>
            <th class="text-center bg-teal color-palette">Period</th>
        <?php foreach($response['timeTable'] as $day =>$dayValue){ 
            if($day=='break'){
                continue;
            } ?>
            <th class="text-center bg-teal color-palette"><?php echo $day; ?></th>
        <?php }
        ?>
        </tr>
    </thead>
    <tbody>
    <?php 
    foreach($time_tab as $timeTab){ ?>
    <tr>
        <td><?php echo $timeTab['name']; ?></td>
        <?php
        if($timeTab['is_break']!=1){
        foreach($response['timeTable'] as $day =>$dayValue){ ?>
            <td><?php 
            if(!empty($dayValue[$timeTab['id']])){
            foreach($dayValue[$timeTab['id']] as $classSub){
                echo $classSub.'<br>'; 
            } ?>
            <a href="javascript:void(0)" class="delete_time" data-tId="<?php echo $timeTab['id'];?>" data-teacherId="<?php echo $teacherId;?>" data-weekDay="<?php echo $day; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
        <?php }else{
            echo "-";
        }
          ?>
          </td>
        <?php }
        }else{
                for($i=1;$i<=count($response['timeTable']);$i++){
                ?>
                    <td>Break</td>
               <?php  } 
        } ?>
        </tr>
    <?php }
    ?>
    </tbody>
</table>
</div>
<script>
 $('.delete_time').click(function(e) {
        //prevent Default functionality
        e.preventDefault();
        if(confirm("Are you sure do you want to delete?")){
        //get the action-url of the form
        var actionurl = '<?php echo ADMIN_URL ;?>ClasstimeTabs/delete_staff_timetable';
        var classTimeId=$(this).attr("data-tId");
        var teacherId=$(this).attr("data-teacherId");
        var weekDay=$(this).attr("data-weekDay");
        //do your own request an handle the results
        $.ajax({
                url: actionurl,
                type: 'post',
                data: {classTimeId,teacherId,weekDay},
                success: function(data) {
                  data=JSON.parse(data);
                   if(data.success==true){
                    toastr.success('Record deleted successfully');
                    $('#staff-search').trigger( "click" );
                   }else{
                    toastr.error('Error while deleting Timetable'); 
                   }
                }
        });
        }

    });
</script>

