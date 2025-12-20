<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th width="4%">S.No.</th>
            <th width="16%">School Name</th>
            <th width="16%">Purchase Date</th>
            <th width="16%">Amount</th>
            <th width="16%">Message Count</th>
            <th width="16%">Payment Mode</th>
            <th width="8%">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $page = $this->request->params['paging']['']['page'];
                           $limit = $this->request->params['paging']['']['perPage'];
                           $counter = ($page * $limit) - $limit + 1;
                           if(isset($users) && !empty($users)){ 
                               foreach($users as $intusr){ //pr($intusr); die;
                           ?>
        <tr>
            <td><?php echo $counter;?></td>
            <td><?php echo $intusr['school']['school_name'];?></td>
            <td><?php echo date('Y-m-d',strtotime($intusr['purchase_date']));?></td>
            <td><?php echo $intusr['amount'];?></td>
            <td><?php echo $intusr['message_count'];?></td>
            <td><?php echo $intusr['payment_mode'];?></td>
            <td>
          
                <?php
                                    echo $this->Html->link('', [
                                    'action' => 'delete',
                                    $intusr->id
                                    ],['class'=> 'fa fa-trash fa-2px','style'=>''	
                                    ,"onClick"=>"javascript: return confirm('Are you sure do you want to delete this  Record')"]); ?>
                </strong>
            </td>

        </tr>
        <?php $counter++; } }else{ ?>
        <?php } ?>
    </tbody>
</table>