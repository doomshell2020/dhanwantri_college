<?php
if ($Head == 'dateSum') { ?>
    <table class="table table-bordered table-striped" style="width:100%;">
        <thead>
            <tr>
                <th style="width:08%;text-align:left;">S.No</th>
                <th style="width:20%;text-align:left;">Date</th>
                <th style="width:30%;text-align:left;">Expense Name</th>
                <th style="width:30%;text-align:left;">Description</th>
                <th style="width:12%;text-align:right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            foreach ($query as $value) {
                $i++;
                $expancedetails = $this->Comman->findexpansediscription($value['description']);
                $expansename = $this->Comman->findexpansename($value['exp_cat_id']); ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($value['add_date'])); ?></td>
                    <td><?php echo $expansename['category_name']; ?></td>
                    <td><?php echo $expancedetails['title']; ?></td>
                    <td style="width:12%;text-align:right;"><?php echo $value['amount']; ?></td>
                </tr>
                <?php
                $total += $value['amount'];
            } ?>
            <tr>
                <th colspan="4">Total</th>
                <th style="width:12%;text-align:right;"><?php echo $total; ?></th>
            </tr>

        </tbody>
    </table>
    <?php
} else { ?>
    <table class="table table-bordered table-striped" style="width:100%;">
        <thead>
            <tr>
                <th style="width:15%;text-align:left;">Expenses</th>
                <th style="width:5%;text-align:right !important;">April</th>
                <th style="width:5%;text-align:right !important;">May</th>
                <th style="width:5%;text-align:right !important;">June</th>
                <th style="width:5%;text-align:right !important;">July</th>
                <th style="width:5%;text-align:right !important;">Aug</th>
                <th style="width:5%;text-align:right !important;">Sep</th>
                <th style="width:5%;text-align:right !important;">Oct</th>
                <th style="width:5%;text-align:right !important;">Nov</th>
                <th style="width:5%;text-align:right !important;">Dec</th>
                <th style="width: 5%;text-align:right !important;">Jan</th>
                <th style="width: 5%;text-align:right !important;">Feb</th>
                <th style="width:5%;text-align:right !important;">March</th>
                <th style="width:5%;text-align:right !important;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $mnths = array('1' => '4', '2' => '5', '3' => '6', '4' => '7', '5' => '8', '6' => '9', '7' => '10', '8' => '11', '9' => '12', '10' => '1', '11' => '2', '12' => '3');
            foreach ($ex_cat as $ex_catt) {
                ?>
                <tr>
                    <td><b><?php echo $ex_catt['category_name']; ?></b></td>
                    <?php
                    $total = 0;
                    for ($i = 1; $i <= 12; $i++) {
                        $unique_id = uniqid('modal_');
                        $m = $this->Comman->getMonthTotal($ex_catt['id'], $mnths[$i], $yea);
                        $amount = $m['sum'] ? $m['sum'] : 0;
                        $total += $amount;
                        ?>
                        <td style="text-align:right !important;">
                            <a href="<?php echo ADMIN_URL; ?>expense/viewexpense/<?php echo $ex_catt['id']; ?>/<?php echo $mnths[$i]; ?>/<?php echo $yea; ?>"
                                class="globalModalghs" data-toggle="modal" data-target="#<?php echo $unique_id; ?>">
                                <?php echo $amount; ?>
                            </a>
                            <!-- Modal -->
                            <div class="modal fade" id="<?php echo $unique_id; ?>" tabindex="-1" role="dialog"
                                aria-labelledby="esModalLabel" aria-hidden="true">
                                <div class="modal-dialog" style="max-width: 1500px;">
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
                        </td>
                    <?php } ?>
                    <td style="text-align:right !important;"><?php echo $total; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td style="text-align:right !important;"><b>Total</b></td>
                <?php
                $total_sum = 0;
                for ($i = 1; $i <= 12; $i++) { ?>
                    <td style="text-align:right !important;">
                        <?php
                        $m = $this->Comman->getMonthTotalSum($mnths[$i], $yea);
                        echo $m['sum'] ? $m['sum'] : 0;
                        ?>
                    </td>
                    <?php
                    $total_sum += $m['sum'];
                } ?>
                <td style="text-align:right !important;"><?php echo $total_sum; ?></td>
            </tr>
        </tbody>
    </table>



    <script>
        $(document).on('click', '.globalModalghs', function (e) {
            e.preventDefault();
            var targetUrl = $(this).attr('href');
            var modalId = $(this).data('target');
            $(modalId).modal('show');
            $(modalId + ' .modal-body').html('<div class="loader"><div class="es-spinner"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div></div>');

            $.ajax({
                url: targetUrl,
                success: function (data) {
                    $(modalId + ' .modal-body').html(data);
                },
                error: function () {
                    $(modalId + ' .modal-body').html('<p>Error loading content. Please try again.</p>');
                }
            });
        });
    </script>
<?php } ?>