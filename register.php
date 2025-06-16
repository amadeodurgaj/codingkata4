<?php
session_start();
require_once 'dbconnect.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];
    $category = isset($_POST['category']) ? (int)$_POST['category'] : 1;

    if (!$username || !$email || !$password || !$confirm) {
        $error = 'Bitte alle Felder ausfüllen.';
    } elseif ($password !== $confirm) {
        $error = 'Die Passwörter stimmen nicht überein.';
    } elseif (emailExists($pdo, $email)) {
        $error = 'E-Mail bereits registriert.';
    } else {
        try {
            $pdo->beginTransaction();
            $hash  = password_hash($password, PASSWORD_DEFAULT);

            $id = getNextId($pdo);
            createUser($pdo, $id, $username, $email, $hash, 1, 1);
            initUserProfile($pdo, $id, $category, $username);
            $pdo->commit();
            header("location: login.php");
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = 'Registrierung fehlgeschlagen. Bitte erneut versuchen.';
        }
    }
}

function getNextId(PDO $pdo, String $col = "userid", String $tableName = "user") {
    $stmt = $pdo->query('SELECT MAX(' . $col . ') AS max_id FROM "' . $tableName . '"');
    $row  = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($row['max_id'] ?? 0) + 1;
}

function emailExists(PDO $pdo, $email) {
    $stmt = $pdo->prepare('SELECT 1 FROM "user" WHERE email = :email');
    $stmt->execute(['email' => $email]);
    return (bool) $stmt->fetchColumn();
}

function createUser(PDO $pdo, $id, $username, $email, $passwordHash, $isActive, $roleId) {
    $stmt = $pdo->prepare(
        'INSERT INTO "user" (userid, username, email, passwordhash, isactive, roleid, lastlogin) VALUES (:userid, :username, :email, :password, :isactive, :roleid, NOW())'
    );
    $stmt->execute([
        'userid'       => $id,
        'username'     => $username,
        'email'        => $email,
        'password'     => $passwordHash,
        'isactive'     => $isActive,
        'roleid'       => $roleId
    ]);
}

function initUserProfile(PDO $pdo, $userId, $category, $username) {
    try {
        $profileId = getNextId($pdo, "profileid", "profile");
        $firstname = $username;
        $lastname = " ";
        $birthdate = "1970-01-01";
        $profilepicture = " ";
        $xp = 0;
        $level = 1;
        $stmt = $pdo->prepare(
            'INSERT INTO "profile" (profileid, userid, firstname, lastname, birthdate, profilepicture, xp, level, category) 
             VALUES (:profileid, :userid, :firstname, :lastname, :birthdate, :profilepicture, :xp, :level, :category)'
        );
        $stmt->execute([
            'profileid'     => $profileId,
            'userid'        => $userId,
            'firstname'     => $firstname,
            'lastname'      => $lastname,
            'birthdate'     => $birthdate,
            'profilepicture'=> $profilepicture,
            'xp'            => $xp,
            'level'         => $level,
            'category'      => $category
        ]);
    } catch (PDOException $e) {
        error_log("Error in initUserProfile: " . $e->getMessage());
        throw $e; 
    }
}

function assignUserRole(PDO $pdo, $userId, $roleId = 1) {
    $stmt = $pdo->prepare(
        'INSERT INTO userrole (user_id, role_id) VALUES (:id, :role)'
    );
    $stmt->execute([
        'id'   => $userId,
        'role' => $roleId
    ]);
}

function initLeaderboard(PDO $pdo, $userId) {
    $stmt = $pdo->prepare(
        'INSERT INTO leaderboard (user_id, points) VALUES (:id, 0)'
    );
    $stmt->execute(['id' => $userId]);
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include_once("header.php"); ?>
  <title>Registrieren - TaskQuest</title>
  <link rel="stylesheet" href="styles.css" />
  <style>
    :root {
      --primary-color: #5E5DF0;
      --bg-gradient-start: #f5f7fa;
      --bg-gradient-end: #c3cfe2;
      --input-bg: #fff;
      --input-border: #ddd;
      --input-focus-border: var(--primary-color);
      --text-color: #333;
      --transition-fast: 0.2s ease;
    }
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(135deg, var(--bg-gradient-start), var(--bg-gradient-end));
      font-family: 'Helvetica Neue', Arial, sans-serif;
      color: var(--text-color);
      padding-top: 80px;
    }
    .register-card {
      background: rgba(255, 255, 255, 0.95);
      padding: 3rem;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      width: 600px;
      max-width: 95%;
      position: relative;
      overflow: hidden;
    }
    .register-card h2 {
      text-align: center;
      margin-bottom: 2rem;
      color: var(--primary-color);
      font-size: 1.8rem;
    }
    .form-group {
      position: relative;
      margin-bottom: 1.75rem;
    }
    .form-group input,
    .form-group select {
      width: 100%;
      padding: 1rem 1.25rem;
      border: 1px solid var(--input-border);
      border-radius: 6px;
      background: var(--input-bg);
      transition: border var(--transition-fast);
      font-size: 1.05rem;
      appearance: none;
    }
    .form-group input:focus,
    .form-group select:focus {
      border-color: var(--input-focus-border);
      outline: none;
    }
    .form-group label {
      position: absolute;
      top: 50%;
      left: 1.25rem;
      transform: translateY(-50%);
      background: transparent;
      padding: 0 0.25rem;
      color: #aaa;
      pointer-events: none;
      transition: all var(--transition-fast);
    }
    .form-group input:focus + label,
    .form-group input:not(:placeholder-shown) + label {
      top: -0.5rem;
      font-size: 0.85rem;
      color: var(--primary-color);
    }
    .form-group select:focus + label,
    .form-group select:not([value=""]) + label {
      top: -0.5rem;
      font-size: 0.85rem;
      color: var(--primary-color);
    }
    .toggle-password {
      position: absolute;
      top: 50%;
      right: 1rem;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      font-size: 1.2rem;
      color: #666;
    }
    .error-msg {
      background: #ffe6e6;
      border: 1px solid #f5c2c2;
      color: #d9534f;
      padding: 0.75rem;
      border-radius: 6px;
      margin-bottom: 1.25rem;
      font-size: 0.95rem;
    }
    button.submit-btn {
      width: 100%;
      padding: 1rem;
      background: var(--primary-color);
      border: none;
      color: #fff;
      font-size: 1.1rem;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
      transition: background var(--transition-fast);
    }
    button.submit-btn:hover {
      background: #4a44c0;
    }
    .login-link {
      text-align: center;
      margin-top: 1.5rem;
      font-size: 0.95rem;
    }
    .login-link a {
      color: var(--primary-color);
      text-decoration: none;
      font-weight: bold;
    }
    .login-link a:hover {
      text-decoration: underline;
    }
    header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 60px;
      background: #fff;
      z-index: 1000;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <header>
    <?php require_once("navbar.php"); ?>
  </header>
  <div class="register-card">
    <h2>Registrieren</h2>
    <?php if (!empty($error)): ?>
      <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="register.php" novalidate>
      <div class="form-group">
        <input type="text" name="username" id="username" placeholder=" " required />
        <label for="username">Benutzername</label>
      </div>
      <div class="form-group">
        <input type="email" name="email" id="email" placeholder=" " required />
        <label for="email">E-Mail</label>
      </div>
      <div class="form-group">
        <input type="password" name="password" id="password" placeholder=" " required minlength="6" />
        <label for="password">Passwort</label>
        <button type="button" class="toggle-password" aria-label="Passwort anzeigen">👁️</button>
      </div>
      <div class="form-group">
        <input type="password" name="confirm" id="confirm" placeholder=" " required minlength="6" />
        <label for="confirm">Passwort bestätigen</label>
        <button type="button" class="toggle-password" aria-label="Passwort anzeigen">👁️</button>
      </div>
      <div class="form-group">
        <select name="category" id="category" required value="">
          <option value="" disabled selected>Training Frequency</option>
          <option value="1">One time a week</option>
          <option value="2">3 times a week</option>
          <option value="3">5 times a week</option>
          <option value="4">7 times a week</option>
        </select>
        <label for="category"></label>
      </div>
      <button type="submit" class="submit-btn">Registrieren</button>
    </form>
    <p class="login-link">Schon registriert? <a href="login.php">Anmelden</a></p>
  </div>
  <script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(btn => {
      btn.addEventListener('click', () => {
        const input = btn.parentElement.querySelector('input');
        if (input.type === 'password') {
          input.type = 'text';
          btn.setAttribute('aria-label', 'Passwort verbergen');
          btn.textContent = '🙈';
        } else {
          input.type = 'password';
          btn.setAttribute('aria-label', 'Passwort anzeigen');
          btn.textContent = '👁️';
        }
      });
    });

    // Client-side validation styling
    const form = document.querySelector('form');
    form.addEventListener('submit', e => {
      if (!form.checkValidity()) {
        e.preventDefault();
        form.querySelectorAll('input:invalid, select:invalid').forEach(el => {
          el.style.borderColor = '#d9534f';
        });
      }
    });
  </script>
</body>
</html>
