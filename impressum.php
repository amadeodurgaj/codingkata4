<?php
  require_once("dbconnect.php")
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Impressum - TaskQuest</title>
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
  <section class="hero" style="background: linear-gradient(135deg, #fd79a8, #e84393);">
    <div class="hero-content">
      <h2>Impressum</h2>
      <p>Wichtige rechtliche Hinweise zu TaskQuest</p>
    </div>
    <div class="hero-image">
      <!-- Beispielbild oder Logo -->
      <img src="img/logo.png" alt="Impressum">
    </div>
  </section>

  <section class="features" style="padding-top: 2rem;">
    <div class="container">
      <h2>Angaben gemäß § 5 TMG</h2>
      <p>
        TaskQuest (ITP-Projekt Gruppe 25)<br>
        Beispielstraße 123<br>
        12345 Beispielstadt<br>
        Österreich
      </p>

      <h2>Kontakt</h2>
      <p>
        Telefon: +49 123 456 789<br>
        E-Mail: <a href="mailto:support@taskquest.com">support@taskquest.com</a>
      </p>

      <h2>Vertreten durch</h2>
      <p>
        Amadeo Durgaj, Glen Kasa, Emil Ceric, Jaspher Gröstenberger, Bill David Canupin
      </p>

      <h2>Haftungsausschluss</h2>
      <p>
        Die Inhalte unserer Seiten wurden mit größter Sorgfalt erstellt. Für die Richtigkeit, 
        Vollständigkeit und Aktualität der Inhalte können wir jedoch keine Gewähr übernehmen. 
      </p>

      <h2>Urheberrecht</h2>
      <p>
        Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen 
        dem Urheberrecht. Beiträge Dritter sind als solche gekennzeichnet. Die Vervielfältigung, 
        Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechts 
        bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers.
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

<!-- Optionales JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>
