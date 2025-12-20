 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">

   <section class="content-header">
     <h1>
       <i class="fa fa-th-list"></i>
       Periodical Manager
     </h1>
     <ol class="breadcrumb">
       <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="<?php echo ADMIN_URL; ?>Books/periodicView">Manage Periodicals</a></li>
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
             <span>
               <h3 class="box-title"><b>Periodical Name:</b> <?php echo $pname['name']; ?> </h3> | <h3 class="box-title"><b> Volume:</b> <?php echo $pcount; ?>
             </span>
           </div>
           <!-- /.box-header -->

           <div class="box-body">
             <table id="example1" class="table table-bordered table-striped">
               <thead>
                 <tr>
                   <th>#</th>
                   <th> Name</th>
                   <th>Asn. No.</th>
                   <th>ISBN NO.</th>
                   <th>Author</th>
                   <th>Vendor</th>
                   <th>Publisher</th>
                   <th>Price</th>
                   <th>Cupboard</th>
                   <th>Shelf</th>
                 </tr>
               </thead>
               <tbody>

                 <?php
                  $page = $this->request->params['paging']['pdetails']['page'];
                  $limit = $this->request->params['paging']['pdetails']['perPage'];
                  $counter = ($page * $limit) - $limit + 1;

                  if (isset($pdetails) && !empty($pdetails)) {
                    foreach ($pdetails as $work) { 
                      $vname = $this->Comman->findvendorname($work['book_vendor_id']);
                  ?>
                     <tr>
                       <td><?php echo $counter; ?></td>

                       <td><?php if (isset($work['name'])) {
                              echo ucfirst($work['name']);
                            } else {
                              echo 'N/A';
                            } ?></td>

                       <td><?php if (isset($work['accsnno'])) {
                              echo ucfirst($work['accsnno']);
                            } else {
                              echo 'N/A';
                            } ?></td>

                       <td><?php if (isset($work['ISBN_NO'])) {
                              echo ucfirst($work['ISBN_NO']);
                            } else {
                              echo 'N/A';
                            } ?></td>


                       <td><?php if (isset($work['author'])) {
                              echo ucfirst($work['author']);
                            } else {
                              echo 'N/A';
                            } ?></td>
                       <td><?php if (isset($vname['name'])) {
                              echo ucfirst($vname['name']);
                            } else {
                              echo 'N/A';
                            } ?></td>

                       <td><?php if (isset($work['publisher'])) {
                              echo ucfirst($work['publisher']);
                            } else {
                              echo 'N/A';
                            } ?></td>


                       <td><?php if (isset($work['book_cost'])) {
                              echo ucfirst($work['book_cost']);
                            } else {
                              echo 'N/A';
                            } ?></td>
                       <?php $cup = $this->Comman->findcupboardname($work['cup_board_id']);
                        $shelf = $this->Comman->findshelfname($work['cup_board_shelf_id']);
                        ?>
                       <td><?php if (isset($cup['name'])) {
                              echo ucfirst($cup['name']);
                            } else {
                              echo 'N/A';
                            } ?></td>
                       <td><?php if (isset($shelf['name'])) {
                              echo ucfirst($shelf['name']);
                            } else {
                              echo 'N/A';
                            } ?></td>

                       <!-- <td><?php
                                echo $this->Html->link('Edit', [
                                  'action' => 'periodicEdit',
                                  $work['id'], $work['periodic_id']
                                ], ['class' => 'btn btn-primary']); ?>
                 
                 </td> -->

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