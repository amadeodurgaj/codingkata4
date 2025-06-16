<?php
session_start();
require_once("dbconnect.php");

// Prüfen ob User eingeloggt ist
if (empty($_SESSION["userId"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karteikarten Tutorial - TaskQuest</title>
    <?php include("header.php") ?>
    <link rel="stylesheet" href="styles.css">
    <style>
        .tutorial-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
        }
        
        .tutorial-card {
            display: flex;
            gap: 40px;
            margin-bottom: 50px;
            align-items: center;
        }
        
        .tutorial-card.reverse {
            flex-direction: row-reverse;
        }
        
        .demo-flashcard {
            flex: 1;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            min-height: 300px;
            max-width: 500px;
            position: relative;
            cursor: pointer;
        }
        
        .demo-flashcard.flipped .card-front {
            display: none;
        }
        
        .demo-flashcard.flipped .card-back {
            display: block;
        }
        
        .card-back {
            display: none;
        }
        
        .tutorial-text {
            flex: 1;
        }
        
        .tutorial-text h3 {
            color: #5E5DF0;
            margin-bottom: 20px;
            font-size: 1.5em;
        }
        
        .tutorial-text p {
            color: #555;
            line-height: 1.8;
            margin-bottom: 20px;
        }
        
        .tutorial-text ul {
            padding-left: 20px;
            color: #555;
            line-height: 1.8;
        }
        
        .tutorial-text li {
            margin-bottom: 10px;
        }
        
        .action-icon {
            display: inline-block;
            width: 30px;
            height: 30px;
            background: #5E5DF0;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            margin-right: 10px;
        }
        
        .step-number {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: #5E5DF0;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            font-size: 1.2em;
            font-weight: bold;
            margin-right: 15px;
        }
        
        .step-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .back-button {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 25px;
            background: #5E5DF0;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .back-button:hover {
            background: #4a4ae0;
            transform: translateY(-2px);
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
                <h2>Karteikarten Tutorial</h2>
                <p>Lerne, wie du Karteikarten optimal nutzen kannst</p>
            </div>
        </section>

        <section class="tutorial-container">
            <div class="tutorial-card">
                <div class="demo-flashcard" id="demoCard1" onclick="flipCard(this)">
                    <div class="card-front">
                        <small style="color: #888; font-size: 12px;">Beispiel-Kategorie</small>
                        <h3>Frage:</h3>
                        <p>Was ist die Hauptstadt von Frankreich?</p>
                        <small style="position: absolute; bottom: 10px; left: 20px; color: #999;">
                            Klicken zum Umdrehen
                        </small>
                    </div>
                    <div class="card-back">
                        <small style="color: #888; font-size: 12px;">Beispiel-Kategorie</small>
                        <h3>Antwort:</h3>
                        <p>Die Hauptstadt von Frankreich ist Paris.</p>
                        <small style="position: absolute; bottom: 10px; left: 20px; color: #999;">
                            Klicken zum Umdrehen
                        </small>
                    </div>
                </div>
                
                <div class="tutorial-text">
                    <div class="step-header">
                        <div class="step-number">1</div>
                        <h3>Karteikarten verwenden</h3>
                    </div>
                    <p>Karteikarten sind ein effektives Lernwerkzeug. Sie bestehen aus einer Vorderseite mit einer Frage und einer Rückseite mit der Antwort.</p>
                    
                    <ul>
                        <li><span class="action-icon"><i class="fas fa-mouse-pointer"></i></span> Klicke auf die Karte, um sie umzudrehen</li>
                        <li><span class="action-icon"><i class="fas fa-brain"></i></span> Versuche zuerst, die Antwort selbst zu wissen</li>
                        <li><span class="action-icon"><i class="fas fa-check"></i></span> Markiere Karten, die du schon kannst</li>
                    </ul>
                </div>
            </div>
            
            <div class="tutorial-card reverse">
                <div class="demo-flashcard" id="demoCard2">
                    <div class="card-front">
                        <div class="flashcard-actions">
                            <button class="btn btn-small" title="Bearbeiten">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-small" title="Löschen" style="background-color: #dc3545;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <small style="color: #888; font-size: 12px;">Beispiel-Kategorie</small>
                        <h3>Frage:</h3>
                        <p>Wie lautet der Satz des Pythagoras?</p>
                    </div>
                </div>
                
                <div class="tutorial-text">
                    <div class="step-header">
                        <div class="step-number">2</div>
                        <h3>Karteikarten verwalten</h3>
                    </div>
                    <p>Du kannst deine Karteikarten einfach bearbeiten oder löschen, wenn sich etwas ändert oder du sie nicht mehr benötigst.</p>
                    
                    <ul>
                        <li><span class="action-icon"><i class="fas fa-edit"></i></span> Bearbeiten: Ändere Frage, Antwort oder Kategorie</li>
                        <li><span class="action-icon"><i class="fas fa-trash"></i></span> Löschen: Entferne Karten, die du nicht mehr brauchst</li>
                        <li><span class="action-icon"><i class="fas fa-plus"></i></span> Neue Karten: Füge jederzeit neue Lerninhalte hinzu</li>
                    </ul>
                </div>
            </div>
            
            <div class="tutorial-card">
                <div class="demo-flashcard" id="demoCard3">
                    <div class="card-front">
                        <small style="color: #888; font-size: 12px;">Mathematik</small>
                        <h3>Frage:</h3>
                        <p>Was ist 7 × 8?</p>
                    </div>
                </div>
                
                <div class="tutorial-text">
                    <div class="step-header">
                        <div class="step-number">3</div>
                        <h3>Tipps für effektives Lernen</h3>
                    </div>
                    <p>Mit diesen Strategien kannst du das Beste aus deinen Karteikarten herausholen:</p>
                    
                    <ul>
                        <li><span class="action-icon"><i class="fas fa-tags"></i></span> Verwende Kategorien, um ähnliche Themen zu gruppieren</li>
                        <li><span class="action-icon"><i class="fas fa-clock"></i></span> Lerne regelmäßig in kurzen Einheiten (20-30 Minuten)</li>
                        <li><span class="action-icon"><i class="fas fa-random"></i></span> Mische deine Karten, um den Reihenfolgeeffekt zu vermeiden</li>
                        <li><span class="action-icon"><i class="fas fa-star"></i></span> Markiere schwierige Karten für gezieltes Wiederholen</li>
                    </ul>
                </div>
            </div>
            
            <a href="flashcards.php" class="back-button">
                <i class="fas fa-arrow-left"></i> Zurück zu deinen Karteikarten
            </a>
        </section>
    </main>

    <footer>
        <?php require_once("footer.php") ?>
    </footer>

    <script>
        function flipCard(card) {
            card.classList.toggle('flipped');
        }
    </script>
</body>
</html>