<div class="container">
<?php
    $session = session();
    $message = $session->getFlashdata('message');
    $class = $session->getFlashdata('alert-class');
    $validation =  \Config\Services::validation();
?> 
<div class="alert <?= $class ?>">
    <?= $message ?>
</div>
<h1 class="display-6">
      Registrera dig
    </h1>
    <br>
    <p>Vill du också publicera dina dikter på poesi-sidan? Välkommen att bli medlem!</>
    <br>
    <?= \Config\Services::validation()->listErrors() ?>
    <form action="<?= base_url('user/register'); ?>" method="post">
    <?= csrf_field() ?>
    <div class="form-group">
    <div class="col-9">
    <input type="text" class="form-control" name="name" placeholder="Namn (minst 3 tecken)" required="required" autofocus="autofocus" />
    <br>
    <input type="text" class="form-control" name="email" placeholder="E-postadress" required="required" autofocus="autofocus" />
    <br>
    <input type="password" class="form-control" name="password" placeholder="Lösenord (minst 8 tecken)" required="required" autofocus="autofocus" />
    <br>
    <input type="password" class="form-control" name="confirmPassword" placeholder="Upprepa lösenord" required="required" autofocus="autofocus" />
    </div>
    </div>
    <button type="submit" class="btn btn-lg btn-primary" style="background-color:#4db380">Bli medlem</button>
    <br>
    <br>
    <a class="nav-link" href="../user/login">Redan medlem? Logga in här!</a>
  </form>
  </div>
</div>