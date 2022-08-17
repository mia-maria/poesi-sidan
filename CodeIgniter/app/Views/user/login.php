<div class="container">
<?php
    $session = session();
    $message = $session->getFlashdata('message');
    $class = $session->getFlashdata('alert-class');
?> 
<div class="alert <?= $class ?>">
    <?= $message ?>
</div>
<h1 class="display-6">
      Logga in
    </h1>
    <br>
    <form action="<?= base_url('user/login'); ?>" method="post">
    <?= csrf_field() ?>
    <div class="form-group">
    <div class="col-6">
    <input type="text" class="form-control" name="email" placeholder="E-postadress" required="required" autofocus="autofocus" />
    <br>
    <input type="password" class="form-control" name="password" placeholder="Lösenord" required="required" autofocus="autofocus" />
    <br>
    </div>
    </div>
    <button type="submit" class="btn btn-lg btn-primary" style="background-color:#4db380">Logga in</button>
    <br>
    <br>
    <a class="nav-link" href="../user/registration">Är du inte medlem? Registrera dig här!</a>
  </form>
  </div>
</div>