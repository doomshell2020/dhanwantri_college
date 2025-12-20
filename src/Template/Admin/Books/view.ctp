<?php //pr($tid);die; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Book Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL;?>Books/index">Manage Book</a></li>
      <li class="active"><?php echo ucfirst($book['name']); ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!--/.col (left) -->
      <!-- right column -->
      <div class="col-md-12">

        <div>
          <?php echo $this->Flash->render(); ?>
        </div>

        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">View Book</h3>

            <a class="btn btn-default btn-view btn-flat pull-right"
              href="<?php echo SITE_URL; ?>admin/issuebooks/index">
              <i class="fa fa-chevron-circle-left"></i> Back
            </a>
          </div>
          <!-- /.box-header -->
          <!-- box-body start -->

          <div class="box-body no-padding table-responsive">
            <table class="table table-striped table-bordered detail-view">
              <tbody>

                <tr class="odd">
                  <th class="col-sm-3">Book Name</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['name']) && !empty($book['name'])){ echo ucfirst($book['name']); }else{ echo 'N/A';} ?>
                  </td>

                  <th class="col-sm-3">Subtitle</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['sub_title']) && !empty($book['sub_title'])){ echo ucfirst($book['sub_title']); }else{ echo 'N/A';} ?>
                  </td>
                </tr>

                <tr class="even">
                  <?php if($tid=='0'){ ?>
                  <th class="col-sm-3">Book Category</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['book_category']['name']) && !empty($book['book_category']['name'])){ echo ucfirst($book['book_category']['name']); }
										else{ echo 'N/A';} ?>
                  </td>
                  <?php } else { ?>
                  <th class="col-sm-3">Periodical Category</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['periodical_master']['name']) && !empty($book['periodical_master']['name'])){ echo ucfirst($book['periodical_master']['name']); }
										else{ echo 'N/A';} ?>
                  </td>
                  <?php } ?>
                  <?php if($tid=='0'){ ?>
                  <th class="col-sm-3">ISBN No.</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['ISBN_NO']) && !empty($book['ISBN_NO'])){ echo ucfirst($book['ISBN_NO']); }else{ echo 'N/A';} ?>
                  </td>
                  <?php } else { ?>
                  <th class="col-sm-3">ISBN No.</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['periodical_master']['ISBN_NO']) && !empty($book['periodical_master']['ISBN_NO'])){ echo ucfirst($book['periodical_master']['ISBN_NO']); }else{ echo 'N/A';} ?>

                  </td>
                  <?php } ?>
                </tr>

                <tr class="odd">
                  <?php if($tid=='0'){ ?>
                  <th class="col-sm-3">Author</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['author']) && !empty($book['author'])){ echo ucfirst($book['author']); }else{ echo 'N/A';} ?>
                  </td>
                  <?php } else { ?>
                  <th class="col-sm-3">Author</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['periodical_master']['author']) && !empty($book['periodical_master']['author'])){ echo ucfirst($book['periodical_master']['author']); }else{ echo 'N/A';} ?>
                  </td>
                  <?php } ?>

                  <?php if($tid=='0'){ ?>
                  <th class="col-sm-3">Publisher</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['publisher']) && !empty($book['publisher'])){ echo ucfirst($book['publisher']); }else{ echo 'N/A';} ?>
                  </td>
                  <?php } else { ?>
                  <th class="col-sm-3">Publisher</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['periodical_master']['publisher']) && !empty($book['periodical_master']['publisher'])){ echo ucfirst($book['periodical_master']['publisher']); }else{ echo 'N/A';} ?>
                  </td>
                  <?php } ?>

                </tr>

                <tr class="even">
                  <th class="col-sm-3">Edition</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['edition']) && !empty($book['edition'])){ echo $book['edition']; }else{ echo 'N/A';} ?>
                  </td>


                  <th class="col-sm-3">Book Vendor</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['book_vendor_id']) && ($book['book_vendor_id']!='0')){ 
											$vname =$this->Comman->findvendorname($book['book_vendor_id']);
											echo ucfirst($vname['name']); }
										else{ echo 'N/A';} ?>
                  </td>
                </tr>

                <tr class="odd">
                  <th class="col-sm-3">Cupboard</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['cup_board']['name']) && !empty($book['cup_board']['name'])){ echo ucfirst($book['cup_board']['name']); }
										else{ echo 'N/A';} ?>
                  </td>

                  <th class="col-sm-3">Cupboard Shelf</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['cup_board_shelf']['name']) && !empty($book['cup_board_shelf']['name']))
										{ echo ucfirst($book['cup_board_shelf']['name']); } else { echo 'N/A';} ?>
                  </td>
                </tr>

                <tr class="even">
                  <th class="col-sm-3">Copy</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['copy']) && !empty($book['copy'])){ echo ucfirst($book['copy']); }else{ echo 'N/A';} ?>
                  </td>
                  <?php if($tid=='0'){ ?>
                  <th class="col-sm-3">Book Cost</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['book_cost']) && !empty($book['book_cost'])){ echo ucfirst($book['book_cost']); }else{ echo 'N/A';} ?>
                  </td>

                  <?php } else { ?>
                  <th class="col-sm-3">Book Cost</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['book_cost']) && !empty($book['book_cost'])){ echo '<b>&#8377;</b> '.money_format('%!i', $book['book_cost']); }
										else{ echo 'N/A';} ?>
                  </td>
                  <?php } ?>
                </tr>
                <tr class="odd">
                  <th class="col-sm-3">Remarks</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['remarks']) && !empty($book['remarks'])){ echo ucfirst($book['remarks']); }else{ echo 'N/A';} ?>
                  </td>

                  <th class="col-sm-3">Book Creation Date</th>
                  <td class="col-sm-3">
                    <?php if(isset($book['created']) && !empty($book['created'])){ echo date('d-m-Y',strtotime($book['created'])); }else{ echo 'N/A';} ?>
                  </td>
                </tr>

              </tbody>
            </table>
          </div>
          <!-- /.box-body -->

        </div>

      </div>
      <!--/.col (right) -->
    </div>
    <!-- /.row -->

    <!-- copies view: start -->

    <div class="row">

      <div class="col-xs-12">

        <div class="box">

          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-files-o"></i> <b>Copies</b></h3>
            <!--<a class="btn btn-success btn-flat pull-right" href="<?php echo SITE_URL; ?>admin/Books/addmorecopy/<?php echo $book['id']; ?>" 
							data-target="#globalModal" data-toggle="modal">
							<i class="fa fa-plus-square"></i> Add More
						</a>-->
          </div>

          <div class="box-body">

            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Acc. No.</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php 

								$page = $this->request->params['paging']['copies']['page'];
								$limit = $this->request->params['paging']['copies']['perPage'];
								$counter = ($page * $limit) - $limit + 1;

								if(isset($copies) && !empty($copies)){ 
									foreach($copies as $work){?>
                <tr>
                  <td><?php echo $counter;?></td>
                  <td><?php if(isset($book['accsnno'])){ echo ucfirst($book['accsnno']);}else{ echo 'N/A';}?></td>
                  <td><?php if(isset($work['status'])){ echo ucfirst($work['status']);}else{ echo 'N/A';}?></td>
                </tr>
                <?php $counter++; } } else { ?>
                <tr>
                  <td>No Data Available</td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- copies view: end -->

  </section>
  <!-- /.content -->
</div>


<div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true"
  style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="loader">
          <div class="es-spinner">
            <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  //prepare the dialog
  //respond to click event on anything with 'overlay' class
  $("#globalModal").click(function(event) {
    //load content from href of link
    $('.modal-content').load($(this).attr("href"));
  });
});
</script>