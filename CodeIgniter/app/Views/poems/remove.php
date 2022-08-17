<div class="container">
<br>
<h2>
  <span class="far fa-trash-alt"></span> Vill du radera din dikt?
</h2>
<br>
<?= \Config\Services::validation()->listErrors() ?>
<form action="/poems/delete/<?= esc($poem['id'])?>" method="post" >
<?= csrf_field() ?>
<div class="form-group">
    <h3><?= esc($poem['title'])?></h3>
    <p><?= esc($poem['body'])?></p>
  </div>
  <button type="submit" class="btn btn-lg btn-primary" style="background-color:#4db380">Radera dikten</button>
</form>
</div>