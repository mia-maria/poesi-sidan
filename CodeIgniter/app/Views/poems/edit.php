<div class="container">
<br>
<h2>
  <span class="far fa-edit"></span> Redigera din dikt
</h2>
<br>
<?= \Config\Services::validation()->listErrors() ?>
<form action="/poems/update/<?= esc($poem['id'])?>" method="post" >
<?= csrf_field() ?>
  <div class="form-group">
    <textarea rows = "1" class="form-control" name="title" required="required" autofocus="autofocus"><?= esc($poem['title'])?></textarea>
    <br>
    <textarea rows = "5" class="form-control" name="body" required="required" autofocus="autofocus"><?= esc($poem['body'])?></textarea>
  </div>
  <button type="submit" class="btn btn-lg btn-primary" style="background-color:#4db380">Redigera</button>
</form>
</div>
