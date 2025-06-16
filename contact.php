<?php

  require_once("dbconnect.php")

?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kontakt - TaskQuest</title>
  <!-- CSS & Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<!-- Header-Bereich mit Navigation -->
<header>
  <?php require_once("navbar.php") ?>
</header>

<!-- Hauptinhalt -->
<main>
  <!-- Heldensektion (optional) -->
  <section class="hero" style="background: linear-gradient(135deg, #00cec9, #0984e3);">
    <div class="hero-content">
      <h2>Kontaktiere uns</h2>
      <p>Wir freuen uns auf deine Nachricht</p>
    </div>
    <div class="hero-image">
      <!-- Beispielbild oder Logo -->
      <img src="img/logo.png" alt="Kontakt">
    </div>
  </section>

  <!-- Kontaktbereich -->
  <section class="features" style="padding-top: 2rem;">
    <div class="container">
      <h2>Unser Kontaktformular</h2>
      <p>Bei Fragen, Anregungen oder Problemen fülle das Formular aus oder schreib uns eine E-Mail.</p>
      <div class="row">
        <div class="col-md-6">
<!-- contact.html -->
<form id="contactForm" method="post" action="sendEmail.php">
    <div class="form-group" style="margin-bottom: 1.5rem;">
      <label for="contactName">Name</label>
      <!-- Add name="contactName" here -->
      <input type="text" id="contactName" name="contactName" required placeholder="Dein Name" class="form-control">
    </div>
    <div class="form-group" style="margin-bottom: 1.5rem;">
      <label for="contactEmail">E-Mail</label>
      <!-- Add name="contactEmail" here -->
      <input type="email" id="contactEmail" name="contactEmail" required placeholder="Deine E-Mail" class="form-control">
    </div>
    <div class="form-group" style="margin-bottom: 1.5rem;">
      <label for="contactMessage">Nachricht</label>
      <!-- Add name="contactMessage" here -->
      <textarea id="contactMessage" name="contactMessage" rows="5" required placeholder="Was möchtest du uns mitteilen?" class="form-control"></textarea>
    </div>
    <button type="submit" class="highlight-btn">Abschicken</button>
  </form>
  
        </div>
        <div class="col-md-6">
          <h3 style="margin-top: 1rem;">Kontaktinformationen</h3>
          <p>Du erreichst uns per E-Mail unter:</p>
          <p><strong>taskquest1@gmail.com</strong></p>
          <p>oder telefonisch unter: <strong>+49 123 456 789</strong></p>
          <p>Wir bemühen uns, so schnell wie möglich zu antworten.</p>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Footer-Bereich -->
<footer>
  <div class="footer-container">
    <div class="footer-section">
      <h3>TaskQuest</h3>
      <p>Eine gamifizierte Fortschrittsplattform, die dir hilft, deine Aufgaben zu organisieren und deine Motivation zu steigern.</p>
    </div>
    <div class="footer-section">
      <h3>Links</h3>
      <ul>
        <li><a href="index.html">Startseite</a></li>
        <li><a href="tasks.html">Aufgaben</a></li>
        <li><a href="profile.html">Profil</a></li>
        <li><a href="leaderboard.html">Bestenliste</a></li>
      </ul>
    </div>
    <div class="footer-section">
      <h3>Rechtliches</h3>
      <ul>
        <li><a href="about.html">Über uns</a></li>
        <li><a href="contact.html">Kontakt</a></li>
        <li><a href="privacy.html">Datenschutz</a></li>
        <li><a href="impressum.html">Impressum</a></li>
      </ul>
    </div>
    <div class="footer-section">
      <h3>Team</h3>
      <p>
        Amadeo Durgaj<br>
        Glen Kasa<br>
        Emil Ceric<br>
        Jaspher Gröstenberger<br>
        Bill David Canupin<br>
      </p>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; 2025 TaskQuest - ITP-Projekt Gruppe 25</p>
  </div>
</footer>

<!-- Optionales JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>
