<!DOCTYPE html>
<html lang="sv">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Poesi-sidan</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link rel="stylesheet" type="text/css" href="./css/styles.css" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container">
  <a class="navbar-brand" href="/">Poesi-sidan</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="/poems">Dikter</a>
      </li>
        <?php
        $session = session();
        $logged_in = $session->get('logged_in');
        if ($logged_in) : ?> 
        <li class="nav-item active">
        <a class="nav-link" href="/poems/myPoems">Mina dikter</a>
        </li>
        <li class="nav-item active">
        <a class="nav-link" href="/poems/new">Skapa en dikt</a>
        </li>
        <li class="nav-item active">
        <a class="nav-link" href="/user/info">Användarvillkor</a>
        </li>
        <li class="nav-item active">
        <a class="nav-link" href="/user/logout">Logga ut</a>
      </li>
      <?php else : ?>
        <li class="nav-item active">
          <a class="nav-link" href="/user/registration">Registrera dig</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="/user/login">Logga in</a>
       </li>
        <?php endif ?>
    </ul>
  </div>
</div>
</nav>
