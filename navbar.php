<nav>
  <div class="logo navbar-item">
    <h1>TaskQuest</h1>
  </div>
  <ul id="navbarlinks" class="navbar-item hideOnMobile">
    <li class="hideOnMobile"><a href="index.php" class="active">Startseite</a></li>
    <li class="dropdown hideOnMobile">
      <a id="dropdown-toggle" href="#">Self-Management Tools ▼</a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="stickynotes.php">Sticky Notes</a></li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="#">Whiteboard</a></li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="todo.php">To-Do Liste</a></li>
      </ul>
    </li>
    <li class="hideOnMobile"><a href="profile.php">Profil</a></li>
    <li><a href="flashcards.php">Flashcards</a></li>
    <li class="hideOnMobile"><a href="leaderboard.php">Bestenliste</a></li>
    <li class="hideOnMobile"><a href="about.php">Über uns</a></li>
    <li class="hideOnMobile"><a href="contact.php">Kontakt</a></li>
    <li class="hideOnMobile"><a href="impressum.php">Impressum</a></li>
  </ul>
  <?php if (empty($_SESSION["userId"])) { ?>
    <div id="navbar-btn" class="user-menu navbar-item">
      <button id="loginBtn" class="hideOnMobile"><a class="nodecor" style="color: #5E5DF0 !important;" href="login.php">Anmelden</a></button>
      <!-- Button trigger modal -->
      <button id="registerBtn" class="highlight-btn hideOnMobile"><a class="nodecor" style="color: white !important;" href="register.php">Registrieren</a></button>
    </div>
  <?php  } else { ?>
    <div id="navbar-btn" class="user-menu navbar-item">

      <button id="logoutBtn" class="highlight-btn hideOnMobile"><a class="nodecor" style="color: white !important;" href="logout.php">Logout</a></button>
    </div>
  <?php } ?>
  <br>
  <div id="userDisplay" style="display: none;">
    <span id="userGreeting"></span>
    <button id="logoutBtn" class="btn btn-danger">Logout</button>
  </div>

  <!--SIDEBAR IMPLEMENTIERUNG-->
  <button class="showOnMobile" id="toggleSidebar">Menu</button>   <!--SIDEBAR MENU-->

  <div class="sidebar" id="sidebar">
    <ul id="navbarlinks" class="navbar-item">
      <li><a href="index.php" class="active">Startseite</a></li>
      <li class="dropdown-sidebar">
        <a id="dropdown-toggle-sidebar" href="#">Self-Management Tools ▼</a>
          <ul class="dropdown-menu-sidebar">
            <li><a class="dropdown-item-sidebar" href="stickynotes.php">Sticky Notes</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item-sidebar" href="#">Whiteboard</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item-sidebar" href="todo.php">To-Do Liste</a></li>
          </ul>
      </li>
      <li><a href="profile.php">Profil</a></li>
      <li><a href="flashcards.php">Flashcards</a></li>
      <li><a href="leaderboard.php">Bestenliste</a></li>
      <li><a href="about.php">Über uns</a></li>
      <li><a href="contact.php">Kontakt</a></li>
      <li><a href="impressum.php">Impressum</a></li>
      <?php if (empty($_SESSION["userId"])) { ?>
        <div id="navbar-btn" class="user-menu navbar-item">
          <button id="loginBtn"><a class="nodecor" style="color: #5E5DF0 !important;" href="login.php">Anmelden</a></button>
          <!-- Button trigger modal -->
          <button id="registerBtn" class="highlight-btn"><a class="nodecor" style="color: white !important;" href="register.php">Registrieren</a></button>
        </div>
      <?php  } else { ?>
        <div id="navbar-btn" class="user-menu navbar-item">

          <button id="logoutBtn" class="highlight-btn"><a class="nodecor" style="color: white !important;" href="logout.php">Logout</a></button>
        </div>
      <?php } ?>
      <br>

      <div id="userDisplay" style="display: none;">
        <span id="userGreeting"></span>
        <button id="logoutBtn" class="btn btn-danger">Logout</button>
      </div>
    </ul>
  </div>
</nav>


<script>
  document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("dropdown-toggle");
    const dropdown = toggle.parentElement;

    const toggleSidebar = document.getElementById("toggleSidebar");
    const sidebar = document.getElementById("sidebar");

    const toggleDropdownSidebar = document.getElementById("dropdown-toggle-sidebar");
    const dropdownSidebar = toggleDropdownSidebar.parentElement;

    toggle.addEventListener("click", () => {
      dropdown.classList.toggle("open");
    });

    toggleSidebar.addEventListener('click', () => {
      sidebar.classList.add("sidebaropen");
    });

    toggleDropdownSidebar.addEventListener('click', () => {
      dropdownSidebar.classList.toggle("open");
    });

    document.addEventListener("click", (event) => {
      if (!dropdown.contains(event.target)) {
        dropdown.classList.remove("open");
      }

      if (!sidebar.contains(event.target) && !toggleSidebar.contains(event.target)) {
        sidebar.classList.remove("sidebaropen");
      }

      if (!dropdownSidebar.contains(event.target)) {
        dropdownSidebar.classList.remove("open");
      }
    });

  });
</script>