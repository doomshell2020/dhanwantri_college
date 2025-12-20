<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <h1>Board Details</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="#">Manage Board</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <!-- Form Box -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Branch Info</h3>
                    </div>

                    <?= $this->Flash->render(); ?>

                    <?= $this->Form->create($users_data, [
                        'class' => 'form-horizontal',
                        'id' => 'branch_form',
                        'enctype' => 'multipart/form-data'
                    ]); ?>

                    <div class="box-body">

                        <!-- Name -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-4">
                                <?= $this->Form->input('name', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Name',
                                    'label' => false,
                                    'required'
                                  
                                ]); ?>
                            </div>

                            <label class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-4">
                                <?= $this->Form->input('full_name', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Full Name',
                                    'label' => false,
                                     'required'
                                ]); ?>
                            </div>
                        </div>

                        <!-- Logo -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Logo</label>
                            <div class="col-sm-4">
                                <?= $this->Form->file('logo', [
                                    'id' => 'logo',
                                    'accept' => 'image/png,image/jpeg',
                                     'required'
                                ]); ?>
                            </div>

                            <label class="col-sm-2 control-label">Transparent Logo</label>
                            <div class="col-sm-4">
                                <?= $this->Form->file('transparent_logo', [
                                    'id' => 'transparent_logo',
                                    'accept' => 'image/png,image/jpeg'
                                ]); ?>
                            </div>
                        </div>

                    </div>

                    <!-- Form Footer -->
                    <div class="box-footer">
                        <div class="col-sm-8">
                            <?= $this->Form->submit(isset($work['id']) ? 'Update' : 'Submit', [
                                'class' => 'btn btn-info pull-right',
                                'title' => isset($work['id']) ? 'Update' : 'Add'
                            ]); ?>
                        </div>
                    </div>

                    <?= $this->Form->end(); ?>
                </div>

                <!-- Table to show branch data -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Board Data</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Full Name</th>
                                    <th>Logo</th>
                                    <th>Transparent Logo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($branches_data)) : ?>
                                    <?php foreach ($branches_data as $branch) : ?>
                                        <tr>
                                            <td><?= $branch->id; ?></td>
                                            <td><?= h($branch->name); ?></td>
                                            <td><?= h($branch->full_name); ?></td>
                                            <td>
                                                <?php if ($branch->logo) : ?>
                                                      <img src="<?php echo SITE_URL; ?><?php echo $branch['logo'] ?>" alt="Logo" height="100px" width="100px">
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($branch->transparent_logo) : ?>
                                                     <img src="<?php echo SITE_URL; ?><?php echo $branch['transparent_logo'] ?>" alt="Transparent Logo" height="100px" width="100px">
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo $this->Html->link('Edit', ['action' => 'viewboard', $branch->id], ['class' => 'btn btn-xs btn-warning']); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No records found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<!-- JS Image Validation -->
<script>
    function validateImage(input) {
        const file = input.files[0];
        if (!file) return true;

        const allowedExtensions = ['png', 'jpg', 'jpeg'];
        const fileExtension = file.name.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
            alert('Invalid file type. Only PNG or JPEG allowed.');
            input.value = '';
            return false;
        }

        return true;
    }

    // Attach change events
    document.getElementById('logo').addEventListener('change', function() {
        validateImage(this);
    });
    document.getElementById('transparent_logo').addEventListener('change', function() {
        validateImage(this);
    });
</script>