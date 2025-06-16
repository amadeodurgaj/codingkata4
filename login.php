<?php
session_start();
require_once 'dbconnect.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email && $password) {
        $stmt = $pdo->prepare('SELECT userid, username, passwordhash FROM "user" WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['passwordhash'])) {
            $_SESSION['userId']   = $user['userid'];
            $_SESSION['username']  = $user['username'];
            header('Location: index.php');
            exit;
        }
        $error = 'Ungültige E-Mail oder Passwort.';
    } else {
        $error = 'Bitte alle Felder ausfüllen.';
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include("header.php"); ?>
  <title>Anmelden - TaskQuest</title>
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
    .login-card {
      background: rgba(255, 255, 255, 0.9);
      padding: 2.5rem;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      width: 600px;
      max-width: 90%;
      position: relative;
      overflow: hidden;
    }
    .login-card h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: var(--primary-color);
    }
    .form-group {
      position: relative;
      margin-bottom: 1.5rem;
    }
    .form-group input {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid var(--input-border);
      border-radius: 6px;
      background: var(--input-bg);
      transition: border var(--transition-fast);
      font-size: 1rem;
    }
    .form-group input:focus {
      border-color: var(--input-focus-border);
      outline: none;
    }
    .form-group label {
      position: absolute;
      top: 50%;
      left: 1rem;
      transform: translateY(-50%);
      background: transparent;
      padding: 0 0.25rem;
      color: #aaa;
      pointer-events: none;
      transition: all var(--transition-fast);
    }
    .form-group input:focus + label,
    .form-group input:not(:placeholder-shown) + label {
      top: -0.4rem;
      font-size: 0.8rem;
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
      font-size: 1rem;
      color: #666;
    }
    .error-msg {
      background: #ffe6e6;
      border: 1px solid #f5c2c2;
      color: #d9534f;
      padding: 0.75rem;
      border-radius: 6px;
      margin-bottom: 1rem;
      font-size: 0.9rem;
    }
    button.submit-btn {
      width: 100%;
      padding: 0.75rem;
      background: var(--primary-color);
      border: none;
      color: #fff;
      font-size: 1rem;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
      transition: background var(--transition-fast);
    }
    button.submit-btn:hover {
      background: #4a44c0;
    }
    .register-link {
      text-align: center;
      margin-top: 1rem;
      font-size: 0.9rem;
    }
    .register-link a {
      color: var(--primary-color);
      text-decoration: none;
      font-weight: bold;
    }
    .register-link a:hover {
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
  <div class="login-card">
    <h2>Anmelden</h2>
    <?php if (!empty($error)): ?>
      <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="login.php" novalidate>
      <div class="form-group">
        <input type="email" name="email" id="email" placeholder=" " required />
        <label for="email">E-Mail</label>
      </div>
      <div class="form-group">
        <input type="password" name="password" id="password" placeholder=" " required minlength="6" />
        <label for="password">Passwort</label>
        <button type="button" class="toggle-password" aria-label="Passwort anzeigen">
          👁️
        </button>
      </div>
      <button type="submit" class="submit-btn">Anmelden</button>
    </form>
    <p class="register-link">Noch kein Konto? <a href="register.php">Registrieren</a></p>
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
    // Client-side form validation styling
    const form = document.querySelector('form');
    form.addEventListener('submit', (e) => {
      if (!form.checkValidity()) {
        e.preventDefault();
        form.querySelectorAll('input:invalid').forEach(input => {
          input.style.borderColor = '#d9534f';
        });
      }
    });
  </script>
</body>
</html>
