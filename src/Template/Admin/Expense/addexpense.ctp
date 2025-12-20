<style>
    .modal-dialog {
        max-width: 500px;
    }
</style>

<h3> Expense Entry   </h3>
<hr>
<?php echo $this->Flash->render(); ?>
<?php echo $this->Form->create(
    $assignments,
    array(

        'class' => 'form-horizontal',
        'id' => 'student_form',
        'enctype' => 'multipart/form-data',
        'validate'
    )
); ?>

<div class="row">
    <div class="col-md-12 mb-3">
        <div class="row">
            <div class="col-md-12">
                <lable><b>Date</b><span style="color:red;">*</span></lable>
            </div>
            <div class="col-md-12" >
                <input type="date" id="css" name="datefrom" required="required">
            </div>
        </div>
    </div>

    <input type="hidden" name="Head" value="<?php echo $ex_id; ?>">

    <div class="col-sm-12" required="required">
        <label>Description<span style="color:red;">*</span></label>
        <select class="form-control" required="required" name="Description" >
            <?php foreach ($catgory as $id => $name) {
                ?>
                <option value="<?php echo $name['id']; ?>"><?php echo $name['title']; ?></option>
            <?php } ?>
        </select>
    </div>


    <div class="col-md-12 mb-3">
        <div class="row">
            <div class="col-md-12">
                <label>Mode<span style="color:red;">*</span></label>
            </div>
            <div class="col-md-12">
                <label>
                    <input type="radio" checked name="Mode" value="1">&nbsp;Cash
                </label>
                <label>
                    <input type="radio" name="Mode" value="2">&nbsp;Other
                </label>
            </div>
        </div>
    </div>



    <div class="col-md-12 mb-3">
        <div class="row">
            <div class="col-md-12">
                <label>Amount<span style="color:red;">*</span></label>
            </div>
            <div class="col-md-12">
                <?php echo $this->Form->input(
                    'Amount',
                    array(
                        'class' => 'form-control',
                        'placeholder' => 'Amount',
                        'label' => false,
                        'id' => 'amount',
                        'autocomplete' => 'off',
                        'required' => true,
                        'type' => 'number',
                        'step' => '0.01'
                    )
                ); ?>
            </div>
        </div>
    </div>




    <div class="col-md-12 mb-3">
        <div class="row">
            <div class="col-md-12">
                <lable><b>Notes</b></lable>
            </div>
            <div class="col-md-12">
                <?php echo $this->Form->input(
                    'Notes',
                    array(
                        'class' =>
                            'form-control',
                        'placeholder' => ' Notes',
                        'label' => false,
                        'id' => 'name',
                        'autocomplete' => 'off',
                        'type' => 'number',
                       
                    )
                ); ?>
            </div>
        </div>
    </div>



    <div class="col-md-12 mb-3 text-center" style="padding: 20px;">
        <?php

        echo $this->Form->submit(
            'Add',
            array('class' => 'btn btn-info pull-right', 'title' => 'Add')
        );

        ?>

    </div>
</div>

<!-- -->
<?php echo $this->Form->end(); ?>