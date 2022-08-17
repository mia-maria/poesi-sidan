<div class="container">
<h1 class="display-6">
      Vill du logga ut?
    </h1>
    <br>
    <?= \Config\Services::validation()->listErrors() ?>
    <form action="<?= base_url('user/logoutUser'); ?>" method="post">
    <?= csrf_field() ?>
    <button type="submit" class="btn btn-lg btn-primary">Logga ut</button>
  </form>
</div>