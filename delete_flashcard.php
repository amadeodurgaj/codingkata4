<?php
session_start();
require_once("dbconnect.php");

// Prüfen ob User eingeloggt ist
if (empty($_SESSION["userId"])) {
    header("Location: login.php");
    exit();
}

$errorLink = "Location: flashcards.php?error=";

$userId = $_SESSION["userId"];
$cardId = $_GET['id'] ?? 0;

// Validierung
if (!$cardId) {
    header($errorLink . urlencode("Ungültige Karteikarten-ID."));
    exit();
}

try {
    // Prüfen ob die Karteikarte dem User gehört
    $stmt = $pdo->prepare("SELECT id FROM flashcards WHERE id = ? AND user_id = ?");
    $stmt->execute([$cardId, $userId]);
    $card = $stmt->fetch();
    
    if (!$card) {
        header($errorLink . urlencode("Karteikarte nicht gefunden oder keine Berechtigung."));
        exit();
    }
    
    // Karteikarte löschen
    $stmt = $pdo->prepare("DELETE FROM flashcards WHERE id = ? AND user_id = ?");
    $stmt->execute([$cardId, $userId]);
    
    header("Location: flashcards.php?success=" . urlencode("Karteikarte erfolgreich gelöscht."));
    exit();
    
} catch (PDOException $e) {
    header($errorLink . urlencode("Fehler beim Löschen der Karteikarte."));
    exit();
}
?>