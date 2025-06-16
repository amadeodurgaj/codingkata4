<?php
session_start();
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Über uns - TaskQuest</title>
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
  <section class="hero" style="background: linear-gradient(135deg, #fbc531, #e1b12c);">
    <div class="hero-content">
      <h2>Über TaskQuest</h2>
      <p>Erfahre mehr über unser Projekt und unser Team.</p>
    </div>
    <div class="hero-image">
      <!-- Beispielbild oder Logo -->
      <img src="img/logo.png" alt="Über uns">
    </div>
  </section>

  <!-- Inhalt: Über das Projekt / Teaminfo -->
  <section class="features" style="padding-top: 2rem;">
    <div class="container">
      <h2>Unsere Vision</h2>
      <p>
        TaskQuest ist eine gamifizierte Plattform, mit der du deinen Fortschritt in verschiedenen Lebensbereichen 
        verfolgen kannst. Das Besondere dabei: Deine tägliche To-Do-Liste verwandelt sich in ein spannendes Abenteuer. 
        Sammle Erfahrungspunkte, steige im Level auf und bleib dauerhaft motiviert!
      </p>

      <h2>Wer wir sind</h2>
      <p>
        Wir sind eine Gruppe begeisterter Informatik-Studierender, die moderne Technologien einsetzen, um 
        Produktivität und Spaß zu vereinen. Unser Team setzt sich aus folgenden Mitgliedern zusammen:
      </p>
      <ul>
        <li>Amadeo Durgaj</li>
        <li>Glen Kasa</li>
        <li>Emil Ceric</li>
        <li>Jaspher Gröstenberger</li>
        <li>Bill David Canupin</li>
      </ul>

      <h2>Was uns antreibt</h2>
      <p>
        Unser Ziel ist es, allen Menschen zu helfen, ihre Ziele spielerisch zu erreichen. Wir glauben, dass 
        Gamification ein großer Motivationsfaktor sein kann, um Aufgaben besser zu meistern und Ziele nicht 
        aus den Augen zu verlieren.
      </p>
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

<!-- Optionales JavaScript (falls Ihr es für das Modal oder andere Funktionen benötigt) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>
