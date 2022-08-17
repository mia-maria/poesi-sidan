<div class="container">
<?php
    $session = session();
    $message = $session->getFlashdata('message');
    $class = $session->getFlashdata('alert-class');
?> 
<div class="alert <?= $class ?>">
    <?= $message ?>
</div>
      
<h2>Dikter</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Titel</th>
            <th>Dikt</th>
            <th>Författare</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($poems as $row): ?>
        <tr>
            <td class="w-25"><?= esc($row->title) ?></td>
            <td class="w-50" style="white-space: pre-wrap;"><?= esc($row->body) ?></td>
            <td class="w-25"><a href="/poems/author/<?= esc($row->author_id)?>"><?= esc($row->name) ?></a></td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>
</div>
