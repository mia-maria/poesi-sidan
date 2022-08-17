<div class="container">
<h2><?= esc($name['name'])?>s dikter</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Titel</th>
            <th>Dikt</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($poems as $row): ?>
        <tr>
            <td class="w-30"><?= esc($row->title) ?></td>
            <td class="w-70" style="white-space: pre-wrap;"><?= esc($row->body) ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>
</div>
</div>