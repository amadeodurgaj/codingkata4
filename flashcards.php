<?php
session_start();
require_once("dbconnect.php");

// Prüfen ob User eingeloggt ist
if (empty($_SESSION["userId"])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION["userId"];

// Karteikarten des Users laden
try {
    $stmt = $pdo->prepare("SELECT * FROM flashcards WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$userId]);
    $flashcards = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $flashcards = [];
    $error = "Fehler beim Laden der Karteikarten.";
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karteikarten - TaskQuest</title>
    <?php include("header.php") ?>
    <link rel="stylesheet" href="styles.css">
    <style>
        .flashcard-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .flashcard {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 200px;
            position: relative;
        }

        .flashcard:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .flashcard.flipped .card-front {
            display: none;
        }

        .flashcard.flipped .card-back {
            display: block;
        }

        .card-back {
            display: none;
        }

        .flashcard h3 {
            color: #5E5DF0;
            margin-bottom: 15px;
            font-size: 1.2em;
        }

        .flashcard p {
            color: #666;
            line-height: 1.6;
        }

        .flashcard-actions {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .btn-small {
            padding: 5px 10px;
            font-size: 12px;
            margin-left: 5px;
        }

        .add-flashcard-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #5E5DF0;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 4em;
            color: #ddd;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <header>
        <?php require_once("navbar.php") ?>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h2>Karteikarten</h2>
                <p>Erstelle und lerne mit deinen eigenen Karteikarten!</p>
                <a href="tutorial_flashcards.php" class="btn" style="margin-top: 15px;">
                    <i class="fas fa-question-circle"></i> Tutorial ansehen
                </a>
            </div>
            <div class="hero-image">
                <img src="img/logo.png" alt="Karteikarten">
            </div>
        </section>

        <section class="features">
            <div class="container">
                <!-- Neue Karteikarte erstellen -->
                <div class="add-flashcard-section">
                    <h3>Neue Karteikarte erstellen</h3>
                    <form id="addFlashcardForm" method="POST" action="add_flashcard.php">
                        <div class="form-group">
                            <label for="front_text">Vorderseite (Frage):</label>
                            <textarea id="front_text" name="front_text" placeholder="Gib hier deine Frage ein..."
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="back_text">Rückseite (Antwort):</label>
                            <textarea id="back_text" name="back_text" placeholder="Gib hier die Antwort ein..."
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category">Kategorie (optional):</label>
                            <input type="text" id="category" name="category"
                                placeholder="z.B. Mathematik, Geschichte...">
                        </div>
                        <button type="submit" class="cta-button">Karteikarte erstellen</button>
                    </form>
                </div>

                <!-- Bestehende Karteikarten anzeigen -->
                <h3>Deine Karteikarten</h3>

                <?php if (empty($flashcards)): ?>
                    <div class="empty-state">
                        <i class="fas fa-layer-group"></i>
                        <h3>Noch keine Karteikarten vorhanden</h3>
                        <p>Erstelle deine erste Karteikarte, um mit dem Lernen zu beginnen!</p>
                    </div>
                <?php else: ?>
                    <div class="flashcard-container">
                        <?php foreach ($flashcards as $card): ?>
                            <div class="flashcard" onclick="flipCard(this)">
                                <div class="flashcard-actions">
                                    <button class="btn btn-small"
                                        onclick="event.stopPropagation(); editCard(<?php echo $card['id']; ?>)"
                                        title="Bearbeiten">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-small"
                                        onclick="event.stopPropagation(); deleteCard(<?php echo $card['id']; ?>)"
                                        title="Löschen" style="background-color: #dc3545;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <div class="card-front">
                                    <?php if (!empty($card['category'])): ?>
                                        <small
                                            style="color: #888; font-size: 12px;"><?php echo htmlspecialchars($card['category']); ?></small>
                                    <?php endif; ?>
                                    <h3>Frage:</h3>
                                    <p><?php echo nl2br(htmlspecialchars($card['front_text'])); ?></p>
                                    <small style="position: absolute; bottom: 10px; left: 20px; color: #999;">
                                        Klicken zum Umdrehen
                                    </small>
                                </div>

                                <div class="card-back">
                                    <?php if (!empty($card['category'])): ?>
                                        <small
                                            style="color: #888; font-size: 12px;"><?php echo htmlspecialchars($card['category']); ?></small>
                                    <?php endif; ?>
                                    <h3>Antwort:</h3>
                                    <p><?php echo nl2br(htmlspecialchars($card['back_text'])); ?></p>
                                    <small style="position: absolute; bottom: 10px; left: 20px; color: #999;">
                                        Klicken zum Umdrehen
                                    </small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>TaskQuest</h3>
                <p>Eine gamifizierte Fortschrittsplattform, die dir hilft, deine Aufgaben zu organisieren und deine
                    Motivation zu steigern.</p>
            </div>
            <div class="footer-section">
                <h3>Links</h3>
                <ul>
                    <li><a href="index.php">Startseite</a></li>
                    <li><a href="todo.php">Aufgaben</a></li>
                    <li><a href="profile.php">Profil</a></li>
                    <li><a href="leaderboard.php">Bestenliste</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Rechtliches</h3>
                <ul>
                    <li><a href="about.php">Über uns</a></li>
                    <li><a href="contact.php">Kontakt</a></li>
                    <li><a href="privacy.php">Datenschutz</a></li>
                    <li><a href="impressum.php">Impressum</a></li>
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

    <script>
        function flipCard(card) {
            card.classList.toggle('flipped');
        }

        function editCard(cardId) {
            // Hier könntest du ein Modal oder eine neue Seite für die Bearbeitung öffnen
            window.location.href = `edit_flashcard.php?id=${cardId}`;
        }

        function deleteCard(cardId) {
            if (confirm('Möchtest du diese Karteikarte wirklich löschen?')) {
                window.location.href = `delete_flashcard.php?id=${cardId}`;
            }
        }

        // Erfolgs-/Fehlermeldung anzeigen falls in URL-Parameter vorhanden
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const success = urlParams.get('success');
            const error = urlParams.get('error');

            if (success) {
                alert('Karteikarte erfolgreich erstellt!');
                // URL Parameter entfernen
                window.history.replaceState({}, document.title, window.location.pathname);
            }

            if (error) {
                alert('Fehler: ' + error);
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
    </script>
</body>

</html>