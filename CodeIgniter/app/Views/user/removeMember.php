<div class="container">
<br>
<h2>
  Avsluta medlemskap
</h2>
<br>
<p>Hej! Vill du avsluta ditt medlemskap?</p>
<p>Det innebär att dina användaruppgifter och dina dikter kommer att raderas.</p>
<br>
<form action="<?= base_url('user/delete'); ?>" method="post">
    <?= csrf_field() ?>
  <button type="submit" class="btn btn-lg btn-primary" style="background-color:#4db380">Ja, avsluta mitt medlemskap</button>
</form>
</div>