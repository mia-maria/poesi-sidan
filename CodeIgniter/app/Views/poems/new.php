<div class="container">
<br>
<?php
    $session = session();
    $message = $session->getFlashdata('message');
    $class = $session->getFlashdata('alert-class');
?> 
<div class="alert <?= $class ?>">
    <?= $message ?>
</div>
<h2>
  Skapa en dikt!
</h2>
<?= \Config\Services::validation()->listErrors() ?>
<form action="<?= base_url('poems/create'); ?>" method="post">
    <?= csrf_field() ?>
  <div class="form-group">
    <textarea rows = "1" class="form-control" name="title" placeholder="Titel" required="required" autofocus="autofocus" ></textarea>
    <br>
    <textarea rows = "10" class="form-control" name="body" placeholder="Skriv din dikt här" required="required" autofocus="autofocus" ></textarea>
  </div>
  <button type="submit" class="btn btn-lg btn-primary" style="background-color:#4db380">Publicera</button>
</form>
</div>