<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>S.No</th>
      <th>Periodical Name</th>
      <th>Subscription No.</th>
      <th>Periodicity</th>
      <th>Language</th>
      <th>Subs. Start</th>
      <th>Subs. End</th>
      <th>Subs. Amount</th>
      <th>Price</th>
      <th>Author</th>
      <th>Volume</th>
      <th>Issue</th>

      <th>Status</th>
    </tr>
  </thead>
  <tbody>

    <?php
    $counter = 1;
    if (isset($pdetails) && !empty($pdetails)) { ?>
      <tr>
        <td><?php echo $counter; ?></td>
        <td><?php if (isset($pdetails['periodical_master']['name'])) {
              echo ucfirst($pdetails['periodical_master']['name']);
            } else {
              echo 'N/A';
            } ?></td>
        <td><?php if (isset($pdetails['subs_no'])) {
              echo ucfirst($pdetails['subs_no']);
            } else {
              echo 'N/A';
            } ?></td>
        <?php $prty = $this->Comman->findperiodicityname($pdetails['periodical_master']['periodicity']); ?>
        <td><?php if (isset($prty['name'])) {
              echo ucfirst($prty['name']);
            } else {
              echo 'N/A';
            } ?></td>
        <?php $lasd = $this->Comman->findlang($pdetails['periodical_master']['lang']); ?>
        <td><?php if (isset($lasd['language'])) {
              echo ucfirst($lasd['language']);
            } else {
              echo 'N/A';
            } ?></td>
        <td><?php if (isset($pdetails['subs_start_date'])) {
              echo date('d-m-Y', strtotime($pdetails['subs_start_date']));
            } else {
              echo 'N/A';
            } ?></td>

        <td><?php if (isset($pdetails['subs_end_date'])) {
              echo date('d-m-Y', strtotime($pdetails['subs_end_date']));
            } else {
              echo 'N/A';
            } ?></td>

        <td><?php if (isset($pdetails['subs_amount'])) {
              echo ucfirst($pdetails['subs_amount']);
            } else {
              echo 'N/A';
            } ?></td>

        <td><?php if (isset($pdetails['per_volume_cost'])) {
              echo ucfirst($pdetails['per_volume_cost']);
            } else {
              echo 'N/A';
            } ?></td>
        <td><?php if (isset($pdetails['periodical_master']['author'])) {
              echo ucfirst($pdetails['periodical_master']['author']);
            } else {
              echo 'N/A';
            } ?></td>
        <?php
        $det = $this->Comman->findbookperidetail($pdetails['periodic_id']);
        $detcount = count($det);
        ?>
        <td><?php if (isset($det)) {
              echo $det['0']['vol'];
            } else {
              echo 'N/A';
            } ?></td>
        <td><?php if (isset($det)) {
              echo $det['0']['pageno'];
            } else {
              echo 'N/A';
            } ?></td>
        <?php $d1 = strtotime(date('Y-m-d'));

        $sdate = strtotime(date('Y-m-d', strtotime($pdetails['subs_end_date'])));



        if ($sdate >= $d1) { ?>
          <td style="color:green;"><?php if (isset($pdetails['id'])) {
                                      echo "Activated";
                                    } else {
                                      echo 'N/A';
                                    } ?></td>

        <?php } else { ?>
          <td style="color:red;"><?php if (isset($pdetails['id'])) {
                                    echo "Expired";
                                  } else {
                                    echo 'N/A';
                                  } ?></td>
        <?php } ?>

      </tr>
      <tr>
        <th></th>
        <th>CupBoard</th>
        <th>Shelf</th>
        <th>Bill Date</th>
        <th>Entry Date</th>
      </tr>
      <tr>
        <td></td>
        <td><?php echo $locat['cup_board']['name']; ?></td>
        <td><?php echo $locat['name']; ?></td>
        <td><?php echo date('Y-m-d', strtotime($det['0']['bildt'])); ?> </td>

        <td><?php echo date('d-m-Y', strtotime($det['0']['created'])); ?></td>


        <td></td>
      </tr>
    <?php  } else { ?>
      <tr>
        <td>NO Data Available</td>
      </tr>
    <?php } ?>
  </tbody>
</table>

