<div class="container">
<?php
    $session = session();
    $message = $session->getFlashdata('message');
    $class = $session->getFlashdata('alert-class');
?> 
<div class="alert <?= $class ?>">
    <?= $message ?>
</div>
<h2>Mina dikter</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Titel</th>
            <th>Dikt</th>
            <th>Redigera</th>
            <th>Radera</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($poems as $row): ?>
        <tr>
            <td class="w-20"><?= esc($row->title) ?></td>
            <td class="w-60" style="white-space: pre-wrap;"><?= esc($row->body) ?></td>
            <td class="w-10">
                <a href="/poems/edit/<?= esc($row->id)?>"><span class="far fa-edit"></a>
            </td>
            <td class="w-10">
                <a href="/poems/remove/<?= esc($row->id)?>"><span class="far fa-trash-alt"></a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>
</div>

