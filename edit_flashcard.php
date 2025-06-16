<?php
session_start();
require_once("dbconnect.php");

// Prüfen ob User eingeloggt ist
if (empty($_SESSION["userId"])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION["userId"];
$cardId = $_GET['id'] ?? 0;

// Validierung
if (!$cardId) {
    header("Location: flashcards.php?error=" . urlencode("Ungültige Karteikarten-ID."));
    exit();
}

// POST-Request verarbeiten (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $frontText = trim($_POST['front_text'] ?? '');
    $backText = trim($_POST['back_text'] ?? '');
    $category = trim($_POST['category'] ?? '');
    
    // Validierung
    if (empty($frontText) || empty($backText)) {
        $error = "Vorderseite und Rückseite müssen ausgefüllt werden.";
    } else {
        try {
            // Karteikarte aktualisieren
            $stmt = $pdo->prepare("UPDATE flashcards SET front_text = ?, back_text = ?, category = ? WHERE id = ? AND user_id = ?");
            $stmt->execute([$frontText, $backText, $category, $cardId, $userId]);
            
            header("Location: flashcards.php?success=" . urlencode("Karteikarte erfolgreich aktualisiert."));
            exit();
            
        } catch (PDOException $e) {
            $error = "Fehler beim Aktualisieren der Karteikarte.";
        }
    }
}

// Karteikarte laden
try {
    $stmt = $pdo->prepare("SELECT * FROM flashcards WHERE id = ? AND user_id = ?");
    $stmt->execute([$cardId, $userId]);
    $card = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$card) {
        header("Location: flashcards.php?error=" . urlencode("Karteikarte nicht gefunden oder keine Berechtigung."));
        exit();
    }
    
} catch (PDOException $e) {
    header("Location: flashcards.php?error=" . urlencode("Fehler beim Laden der Karteikarte."));
    exit();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karteikarte bearbeiten - TaskQuest</title>
    <?php include("header.php") ?>
    <link rel="stylesheet" href="styles.css">
    <style>
        .edit-form-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin: 30px auto;
            max-width: 800px;
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
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .btn-secondary:hover {
            background-color: #545b62;
            color: white;
            text-decoration: none;
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
                <h2>Karteikarte bearbeiten</h2>
                <p>Aktualisiere deine Karteikarte</p>
            </div>
            <div class="hero-image">
                <img src="img/logo.png" alt="Karteikarte bearbeiten">
            </div>
        </section>

        <section class="features">
            <div class="container">
                <div class="edit-form-section">
                    <h3>Karteikarte bearbeiten</h3>
                    
                    <?php if (isset($error)): ?>
                        <div class="error-message">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="form-group">
                            <label for="front_text">Vorderseite (Frage):</label>
                            <textarea id="front_text" name="front_text" required><?php echo htmlspecialchars($card['front_text']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="back_text">Rückseite (Antwort):</label>
                            <textarea id="back_text" name="back_text" required><?php echo htmlspecialchars($card['back_text']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category">Kategorie (optional):</label>
                            <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($card['category'] ?? ''); ?>" placeholder="z.B. Mathematik, Geschichte...">
                        </div>
                        
                        <div class="button-group">
                            <button type="submit" class="cta-button">Änderungen speichern</button>
                            <a href="flashcards.php" class="btn-secondary">Abbrechen</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>TaskQuest</h3>
                <p>Eine gamifizierte Fortschrittsplattform, die dir hilft, deine Aufgaben zu organisieren und deine Motivation zu steigern.</p>
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
                    Emil Kasa<br>
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