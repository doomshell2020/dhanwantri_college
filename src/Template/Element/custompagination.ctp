<?php pr($this->request->params); die;?>
<div class="paginator">
    <ul class="pagination"> 
        <?php if ($paging['prev']): ?>
            <li><?= $this->Html->link('<< First', ['action' => 'hostelcollection', '?' => ['page' => 1]]) ?></li>
            <li><?= $this->Html->link('< Previous', ['action' => 'hostelcollection', '?' => ['page' => $paging['prev']]]) ?></li>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $paging['pages']; $i++): ?>
            <li><?= $this->Html->link($i, ['action' => 'hostelcollection/fdsffsd', '?' => ['page' => $i]]) ?></li>
        <?php endfor; ?>

        <?php if ($paging['next']): ?>
            <li><?= $this->Html->link('Next >', ['action' => 'hostelcollection', '?' => ['page' => $paging['next']]]) ?></li>
            <li><?= $this->Html->link('Last >>', ['action' => 'hostelcollection', '?' => ['page' => $paging['pages']]]) ?></li>
        <?php endif; ?>
    </ul>
    <p><?= "Page {$paging['page']} of {$paging['pages']}, showing {$limit} records out of {$paging['total']} total" ?></p>
</div>