<?php
session_start();
require_once 'dbconnect.php';

// Prüfen ob User eingeloggt ist
if (empty($_SESSION['userId'])) {
    header('Location: login.php');
    exit();
}

// Prüfen ob POST-Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: flashcards.php");
    exit();
}

$userId = $_SESSION["userId"];
$frontText = trim($_POST['front_text'] ?? '');
$backText = trim($_POST['back_text'] ?? '');
$category = trim($_POST['category'] ?? '');

// Validierung
if (empty($frontText) || empty($backText)) {
    header("Location: flashcards.php?error=" . urlencode("Vorderseite und Rückseite müssen ausgefüllt werden."));
    exit();
}

try {
    // Karteikarte in Datenbank einfügen
    $stmt = $pdo->prepare("INSERT INTO flashcards (user_id, front_text, back_text, category, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$userId, $frontText, $backText, $category]);
    
    header("Location: flashcards.php?success=1");
    exit();
    
} catch (PDOException $e) {
    echo "DB-Fehler: " . $e->getMessage();
    exit();
}
?>