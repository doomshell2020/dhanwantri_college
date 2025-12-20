<table id="example1" class="table table-bordered table-striped">
  <thead>

    <tr>
      <th>S.No</th>
      <th>Periodical Name</th>
      <th>Periodicity</th>
      <th>Language</th>
      <th>Subs. Start</th>
      <th>Subs. End</th>
      <th>Price</th>
      <th>Author</th>
      <th>Bill Date</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>

    <?php

    $page = $this->request->params['paging']['perio']['page'];
    $limit = $this->request->params['paging']['perio']['perPage'];
    $counter = ($page * $limit) - $limit + 1;
    if (isset($periodic) && !empty($periodic)) {
      $d1 = date("d-m-Y");
      $d1 = date_create($d1);
      foreach ($periodic as $perio) {
        $id = $perio['periodic_category_id'];
        $perdet = $this->Comman->findperidetail($id);;
    ?>
        <tr <?php
            $d2 = date_create($perdet['subs_end_date']);
            $stat = $perio['periodical_master']['sub_status'];
            if ($d2 < $d1) { ?> style="color:red;" <?php } ?>>
          <td><?php echo $counter; ?></td>
          <td><?php if (isset($perio['name'])) {
                echo ucfirst($perio['name']);
                if ($stat == '1') { ?>
                <span style="color:red;"><?php echo "(SUBSCRIPTION CLOSED)"; ?></span>
            <?php }
              } else {
                echo 'N/A';
              } ?>
          </td>

          <?php $prty = $this->Comman->findperiodicityname($perio['periodical_master']['periodicity']); ?>
          <td><?php if (isset($prty['name'])) {
                echo ucfirst($prty['name']);
              } else {
                echo 'N/A';
              } ?></td>
          <?php $lasd = $this->Comman->findlang($perio['lang']); ?>
          <td><?php if (isset($lasd['language'])) {
                echo ucfirst($lasd['language']);
              } else {
                echo 'N/A';
              } ?></td>


          <td><?php if (isset($perdet['subs_start_date'])) {
                echo date('d-m-Y', strtotime($perdet['subs_start_date']));
              } else {
                echo 'N/A';
              } ?></td>

           <td>
             <?php if (isset($perdet['subs_end_date'])) {
                echo date('d-m-Y', strtotime($perdet['subs_end_date'])); ?> 
                <?php } else {echo 'N/A';} ?>
           </td>

          <td>
            <?php if (isset($perdet['per_volume_cost'])) {
                echo ucfirst($perdet['per_volume_cost']);}
                 else {echo 'N/A';} ?>
          </td>

          <td><?php if (isset($perio['author']))
           {echo ucfirst($perio['author']);}
           else {echo 'N/A';} ?>
        </td>
          <td><?php if (isset($perio['bildt'])) {
                echo str_replace("/", "-", $perio['bildt']);
              } ?></td>
          <input type="hidden" value="<?php echo $perdet['periodic_id']; ?>" class="masid">

          <?php if ($stat == '0') {
            $status = 1;
          } else {
            $status = 0;
          } ?>
          <input type="hidden" value="<?php echo $status; ?>" class="masstatus">
          <td>
            <a target="_blank" href="<?php echo SITE_URL; ?>admin/books/periodicEdit/<?php echo $perdet['id']; ?>/<?php echo $perdet['periodic_id']; ?> "><img src="<?php echo SITE_URL; ?>/images/edit.png"></a>
            <?php if ($stat == '0') { ?><a target="_blank" href="<?php echo SITE_URL; ?>admin/books/periodicRenew/<?php echo $perdet['id']; ?>/<?php echo $perdet['periodic_id']; ?> "><img src="<?php echo SITE_URL; ?>/images/renew.png"></a> <?php } ?>
            <?php if ($stat == '0') { ?><a href="<?php echo ADMIN_URL; ?>Books/updatesubstatus/<?php echo $perdet['periodic_id']; ?>/<?php echo $status; ?>"><img src="<?php echo SITE_URL; ?>/images/subscription.png"></a> <?php } else { ?>
              <a href="<?php echo ADMIN_URL; ?>Books/updatesubstatus/<?php echo $perdet['periodic_id']; ?>/<?php echo $status; ?>"><img src="<?php echo SITE_URL; ?>/images/subscriptionred.png"></a> <?php } ?>
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