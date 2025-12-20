 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">

     <section class="content-header">
         <h1>
             <i class="fa fa-th-list"></i>
             Book Manager
         </h1>
         <ol class="breadcrumb">
             <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
             <li><a href="<?php echo ADMIN_URL; ?>Books/index">Manage Book</a></li>
         </ol>
     </section>

     <!-- Main content -->
     <section class="content">

         <div class="row">
             <div class="col-xs-12">

                 <div class="box">

                     <div>
                         <?php echo $this->Flash->render(); ?>
                     </div>

                     <div class="box-header">
                         <h3 class="box-title"><i class="fa fa-search"></i> Books</h3>
                         <a class="btn btn-success pull-right" href="<?php echo SITE_URL; ?>admin/books/create"><i class="fa fa-plus-square"></i> Add Book</a>
                         <a class="btn btn-success pull-right" style="margin-right: 10px;" href="<?php echo SITE_URL; ?>admin/books/addcsv"><i class="fa fa-plus"></i> Add CSV</a>
                     </div>
                     <!-- /.box-header -->

                     <div class="box-body">
                         <table id="example1" class="table table-bordered table-striped">
                             <thead>
                                 <tr>
                                     <th>S.No</th>
                                     <th>ISBN No.</th>
                                     <th>Book Name</th>
                                     <th>Book Category</th>
                                     <th>Cupboard</th>
                                     <th>Cupboard Shelf</th>
                                     <th>Author</th>
                                     <th>Copy</th>
                                     <th>Action</th>
                                 </tr>
                             </thead>
                             <tbody>

                                 <?php
                                    $page = $this->request->params['paging']['books']['page'];
                                    $limit = $this->request->params['paging']['books']['perPage'];
                                    $counter = ($page * $limit) - $limit + 1;

                                    if (isset($books) && !empty($books)) {
                                        foreach ($books as $work) {
                                    ?>
                                         <tr>
                                             <td><?php echo $counter; ?></td>
                                             <td><?php if (isset($work['ISBN_NO'])) {
                                                        echo ucfirst($work['ISBN_NO']);
                                                    } else {
                                                        echo 'N/A';
                                                    } ?>
                                             </td>

                                             <td><?php if (isset($work['name'])) {
                                                        echo ucfirst($work['name']);
                                                    } else {
                                                        echo 'N/A';
                                                    } ?>
                                             </td>

                                             <td><?php if (isset($work['book_category']['name'])) {
                                                        echo ucfirst($work['book_category']['name']);
                                                    } else {
                                                        echo 'N/A';
                                                    } ?>
                                             </td>

                                             <td><?php if (isset($work['cup_board']['name'])) {
                                                        echo ucfirst($work['cup_board']['name']);
                                                    } else {
                                                        echo 'N/A';
                                                    } ?>
                                             </td>

                                             <td><?php if (isset($work['cup_board_shelf']['name'])) {
                                                        echo ucfirst($work['cup_board_shelf']['name']);
                                                    } else {
                                                        echo 'N/A';
                                                    } ?>
                                             </td>

                                             <td><?php if (isset($work['author'])) {
                                                        echo ucfirst($work['author']);
                                                    } else {
                                                        echo 'N/A';
                                                    } ?>
                                             </td>

                                             <td><?php if (isset($work['copy'])) {
                                                        echo ucfirst($work['copy']);
                                                    } else {
                                                        echo 'N/A';
                                                    } ?>
                                             </td>

                                             <td><?php if ($work['status'] == 'Y') {
                                                        echo $this->Html->link('', [
                                                            'action' => 'status',
                                                            $work->id,
                                                            $work['status']
                                                        ], ['title' => 'Active', 'class' => 'fas fa-check-circle', 'style' => 'font-size: 16px !important; margin-left: 12px; color: #36cb3c;']);
                                                    } else {
                                                        echo $this->Html->link('', [
                                                            'action' => 'status',
                                                            $work->id,
                                                            $work['status']
                                                        ], ['title' => 'Inactive', 'class' => 'fas fa-times-circle', 'style' => 'font-size: 16px !important; margin-left: 12px; color:#cd0404;']);
                                                    } ?>


                                                 <?php
                                                    echo $this->Html->link('', [
                                                        'action' => 'create',
                                                        $work->id
                                                    ], ['title' => 'Edit', 'class' => 'fas fa-edit', 'style' => 'font-size: 16px !important;']);
                                                    ?>
                                                 <?php
                                                    echo $this->Html->link('', [
                                                        'action' => 'view',
                                                        $work->id
                                                    ], ['title' => 'View', 'class' => 'fa fa-eye', 'style' => 'font-size: 16px !important;']);
                                                    ?>
                                                 <?php
                                                    echo $this->Html->link('', [
                                                        'action' => 'delete',
                                                        $work->id
                                                    ], ['title' => 'Delete', 'class' => 'fas fa-trash-alt', 'style' => 'font-size: 16px !important; color:#cd0404; margin-right:4px !important;', "onClick" => "javascript: return confirm('Are you sure you want to delete this?')"]); ?>
                                             </td>

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
                     <!-- /.box-body -->
                 </div>
                 <!-- /.box -->
             </div>
             <!-- /.col -->
         </div>
         <!-- /.row -->
     </section>
     <!-- /.content -->
 </div>


 <!-- /.content-wrapper -->