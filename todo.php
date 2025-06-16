<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO Board - TaskQuest</title>
    <?php include("header.php") ?>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <?php include("navbar.php") ?>
    </header>

    <h1 id="todo-heading">Meine ToDo-Liste</h1>

    <div class="board">
        <!-- To Do Column -->
        <div class="column" id="todo">
            <div class="column-header">
                <h2>To Do</h2>
                <span class="counter">0</span>
            </div>
            <div class="add-todo">
                <input type="text" id="new-task-input" placeholder="Neue Aufgabe..." />
                <button onclick="addTask()">+</button>
            </div>
            <div class="dropzone" id="todo-dropzone"></div>
        </div>

        <!-- In Progress Column -->
        <div class="column" id="in-progress">
            <div class="column-header">
                <h2>In Progress</h2>
                <span class="counter">0</span>
            </div>
            <div class="dropzone" id="in-progress-dropzone"></div>
        </div>

        <!-- Done Column -->
        <div class="column" id="done">
            <div class="column-header">
                <h2>Done</h2>
                <span class="counter">0</span>
            </div>
            <div class="dropzone" id="done-dropzone"></div>
        </div>
    </div>

    <script>
    function updateCounters() {
        document.querySelectorAll('.dropzone').forEach(dropzone => {
            const count = dropzone.querySelectorAll('.card').length;
            dropzone.parentElement.querySelector('.counter').textContent = count;
        });
    }

    function createCard(text) {
        const card = document.createElement('div');
        card.className = 'card';
        card.setAttribute('draggable', 'true');

        const content = document.createElement('span');
        content.className = 'card-content';
        content.textContent = text;

        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'delete-btn';
        deleteBtn.innerHTML = '❌';
        deleteBtn.title = 'Aufgabe löschen';

        deleteBtn.addEventListener('click', () => {
            card.remove();
            updateCounters();
        });

        card.appendChild(content);
        card.appendChild(deleteBtn);

        card.addEventListener('dragstart', () => {
            card.classList.add('dragging');
        });

        card.addEventListener('dragend', () => {
            card.classList.remove('dragging');
            updateCounters();
        });

        return card;
    }


    function addTask() {
        const input = document.getElementById('new-task-input');
        const value = input.value.trim();
        if (!value) return;

        const card = createCard(value);
        document.getElementById('todo-dropzone').appendChild(card);
        input.value = '';
        updateCounters();
    }

    const dropzones = document.querySelectorAll('.dropzone');

    dropzones.forEach(zone => {
        zone.addEventListener('dragover', e => {
            e.preventDefault();
            const dragging = document.querySelector('.dragging');
            if (dragging) {
                zone.appendChild(dragging);
            }
        });

        zone.addEventListener('drop', updateCounters);
    });

    // Anfangsdaten
    const initialTasks = ['Aufgabe 1', 'Aufgabe 2'];
    initialTasks.forEach(task => {
        const card = createCard(task);
        document.getElementById('todo-dropzone').appendChild(card);
    });

    updateCounters();
    </script>
</body>

</html>