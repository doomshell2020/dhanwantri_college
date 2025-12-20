<h3> Expense Entry   </h3>
<hr>

<?php echo $this->Flash->render(); ?>

<?php
echo $this->Form->create(
    $assignments,
    array(
        'class' => 'form-horizontal',
        'id' => 'student_form',
        'enctype' => 'multipart/form-data'
    )
);
?>

<div class="box-body">
    <div class="form-group">
        <div class="col-md-12">
            <label for="Head">Expense Head<span style="color:red;">*</span></label>
            <select class="form-control" name="Head" required>
                <option value="">Select</option>
                <?php foreach ($catgory as $id => $name) { ?>
                    <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <label for="Title">Expense Title <span style="color:red;">*</span></label>
            <input type="text" class="form-control" name="Title" required>
        </div>
    </div>
</div>

<div class="box-footer">
    <?php echo $this->Form->submit(
        'Add',
        array('class' => 'btn btn-info pull-right', 'title' => 'Add')
    ); ?>

  
</div>

<?php echo $this->Form->end(); ?>
