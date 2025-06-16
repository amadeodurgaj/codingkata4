<?php
session_start();
require_once("dbconnect.php")

?>

<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produktivitäts-Game</title>
  <?php include("header.php") ?>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <!-- Header-Bereich mit Navigation -->
  <header>
    <?php require_once("navbar.php") ?>
  </header>

  <!-- Hauptinhalt - Startseite -->
  <main>
    <!-- Hero-Bereich -->
    <section class="hero">
      <div class="hero-content">
        <h2>Steigere deine Produktivität spielerisch!</h2>
        <p>Organisiere deine Aufgaben, sammle Erfahrungspunkte und steige im Level auf.</p>
        <button class="cta-button"><a href="login.php" class="nodecor" style="color: white !important;">Jetzt starten!</a></button>
      </div>
      <div class="hero-image">
        <img src=img/logo.png alt="Gamifizierte Produktivität">
      </div>
    </section>

    <!-- Willkommensnachricht für eingeloggte Benutzer -->
    <section id="welcomeSection" class="welcome-message" style="display: none;">
      <h2 id="welcomeMessage"></h2>
    </section>

    <!-- Funktionen -->
    <section class="features">
      <h2>Funktionen</h2>
      <div class="feature-container">
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-tasks"></i></div>
          <h3>Aufgabenmanagement</h3>
          <p>Erstelle und organisiere deine täglichen Aufgaben einfach und übersichtlich.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-trophy"></i></div>
          <h3>Belohnungssystem</h3>
          <p>Erhalte XP für erledigte Aufgaben und steige im Level auf.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
          <h3>Fortschrittsverfolgung</h3>
          <p>Behalte den Überblick über deine Produktivität und deinen Fortschritt.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-user-ninja"></i></div>
          <h3>Eigene Charaktere</h3>
          <p>Gestalte deinen virtuellen Charakter und schalte neue Funktionen frei.</p>
        </div>
      </div>
    </section>

    <!-- Wie es funktioniert -->
    <section class="how-it-works">
      <h2>So funktioniert's</h2>
      <div class="steps">
        <div class="step">
          <div class="step-number">1</div>
          <div class="step-content">
            <h3>Registriere dich</h3>
            <p>Erstelle ein Konto und gestalte deinen virtuellen Charakter.</p>
          </div>
        </div>
        <div class="step">
          <div class="step-number">2</div>
          <div class="step-content">
            <h3>Erstelle Aufgaben</h3>
            <p>Füge deine täglichen Aufgaben hinzu und strukturiere sie nach Priorität.</p>
          </div>
        </div>
        <div class="step">
          <div class="step-number">3</div>
          <div class="step-content">
            <h3>Erledige Aufgaben</h3>
            <p>Hake erledigte Aufgaben ab und erhalte XP-Punkte.</p>
          </div>
        </div>
        <div class="step">
          <div class="step-number">4</div>
          <div class="step-content">
            <h3>Steige im Level auf</h3>
            <p>Sammle XP, steige im Level auf und schalte neue Funktionen frei.</p>
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
          <li><a href="imprint.html">Impressum</a></li>
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


</body>

</html>