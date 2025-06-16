<?php
session_start();
require_once 'dbconnect.php';

if (!isset($_SESSION['userId'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['userId'];
$error = '';
$success = '';
$profileData = [];

try {
    $stmt = $pdo->prepare('SELECT firstname, lastname, birthdate, profilepicture, xp, level, category FROM "profile" WHERE userid = :userid');
    $stmt->execute(['userid' => $userId]);
    $profileData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$profileData) {
        $error = 'Profil konnte nicht geladen werden.';
    }
} catch (PDOException $e) {
    $error = 'Fehler beim Laden des Profils: ' . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $birthdate = $_POST['birthdate'];
    $password = $_POST['password'];
    $category = isset($_POST['category']) ? (int)$_POST['category'] : 1;
    $profilePicturePath = $profileData['profilepicture'];

    if (isset($_FILES['profilepicture']) && $_FILES['profilepicture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/img/';
        $fileName = basename($_FILES['profilepicture']['name']);
        $filePath = $uploadDir . $fileName;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['profilepicture']['type'], $allowedTypes)) {
            $error = 'Ungültiger Dateityp. Nur JPG, PNG und GIF sind erlaubt.';
        } elseif (!move_uploaded_file($_FILES['profilepicture']['tmp_name'], $filePath)) {
            $error = 'Fehler beim Hochladen des Profilbilds.';
        } else {
            $profilePicturePath = '/img/' . $fileName;
        }
    }

    if (!$error) {
        try {
            $stmt = $pdo->prepare('SELECT passwordhash FROM "user" WHERE userid = :userid');
            $stmt->execute(['userid' => $userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($password, $user['passwordhash'])) {
                $error = 'Passwort ist falsch.';
            } else {
                $stmt = $pdo->prepare(
                    'UPDATE "profile" 
                    SET firstname = :firstname, lastname = :lastname, birthdate = :birthdate, profilepicture = :profilepicture, category = :category 
                    WHERE userid = :userid'
                );
                $stmt->execute([
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'birthdate' => $birthdate,
                    'profilepicture' => $profilePicturePath,
                    'category' => $category,
                    'userid' => $userId
                ]);
                $success = 'Profil erfolgreich aktualisiert.';
                $stmt = $pdo->prepare('SELECT firstname, lastname, birthdate, profilepicture, xp, level, category FROM "profile" WHERE userid = :userid');
                $stmt->execute(['userid' => $userId]);
                $profileData = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            $error = 'Fehler beim Aktualisieren des Profils: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("header.php"); ?>
    <link rel="stylesheet" href="styles.css">
    <title>Profil - TaskQuest</title>
</head>
<body>
    <header>
        <?php require_once("navbar.php"); ?>
    </header>
    <div class="container mt-5">
        <h2>Dein Profil</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="profile-section">
            <div class="text-center mb-4">
                <?php if (!empty($profileData['profilepicture'])): ?>
                    <img src=".<?= htmlspecialchars($profileData['profilepicture']) ?>" alt="Profilbild" class="img-thumbnail" style="max-width: 150px;">
                <?php else: ?>
                    <div class="img-thumbnail" style="max-width: 150px; height: 150px; display: flex; justify-content: center; align-items: center; background-color: #f8f9fa;">
                        <span>Dein Profilbild kommt hier hin</span>
                    </div>
                <?php endif; ?>
            </div>

            <form method="post" action="profile.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="firstname">Vorname</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" value="<?= htmlspecialchars($profileData['firstname'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Nachname</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" value="<?= htmlspecialchars($profileData['lastname'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="birthdate">Geburtsdatum</label>
                    <input type="date" name="birthdate" id="birthdate" class="form-control" value="<?= htmlspecialchars($profileData['birthdate'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="profilepicture">Profilbild</label>
                    <input type="file" name="profilepicture" id="profilepicture" class="form-control">
                </div>
                <!-- Training Frequency Field -->
                <div class="form-group">
                    <label for="category">Training Frequency</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="1" <?= (isset($profileData['category']) && $profileData['category'] == 1) ? 'selected' : '' ?>>One time a week</option>
                        <option value="2" <?= (isset($profileData['category']) && $profileData['category'] == 2) ? 'selected' : '' ?>>3 times a week</option>
                        <option value="3" <?= (isset($profileData['category']) && $profileData['category'] == 3) ? 'selected' : '' ?>>5 times a week</option>
                        <option value="4" <?= (isset($profileData['category']) && $profileData['category'] == 4) ? 'selected' : '' ?>>7 times a week</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Passwort bestätigen</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Profil aktualisieren</button>
            </form>
            <div class="mt-4">
                <a href="stickynotes.php" class="btn btn-secondary">Zu den Sticky Notes</a>
            </div>
        </div>
    </div>
</body>
</html>