<!-- Content Wrapper. Contains page content -->
<style type="text/css">
    .note-group-select-from-files {
        display: none;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-plus-square"></i> Add Expenses
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i>

                            <?php echo 'Add Expenses'; ?>

                        </h3>
                    </div>
                    <?php echo $this->Flash->render(); ?>
                    <?php echo $this->Form->create(
                        '',
                        array(

                            'class' => 'form-horizontal',
                            'id' => 'student_form',
                            'enctype' => 'multipart/form-data',
                            'validate'
                        )
                    ); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label>Expenses Head<span style="color:red;">*</span></label>
                                <select class="form-control" name="Head">
                                    <option value="<?php echo $expenseCat->id; ?>">
                                        <?php echo $expenseCat->category_name; ?>
                                    </option>

                                    <?php foreach ($expenseCategories as $id => $name) {
                                        // pr($expenseCategories);
                                        if (!isset($expenseCat[$id])) {
                                            ?>
                                            <option value="<?php echo $name['id']; ?>">
                                                <?php echo $name['category_name']; ?>
                                            </option>
                                            <?php
                                        }
                                    } ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="inputEmail3" class="control-label">Expenses Title<span
                                        style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="title" required="required"
                                    value="<?php echo h($assign_details->title); ?>">
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <?php
                           
                                echo $this->Form->submit(
                                    'Update',
                                
                                    array('class' => 'btn btn-info pull-right', 'title' => 'Update')
                                );
                          
                            ?> <?php
                             echo $this->Html->link('Back', [
                                 'controller' => 'Expense',
                                 'action' => 'index'

                             ], ['class' => 'btn btn-default']); ?>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
    </section>
    <!-- /.content -->
</div>