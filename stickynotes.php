<?php
session_start();
require_once 'dbconnect.php';

if (!isset($_SESSION['userId'])) {
    header('Location: login.php');
    exit;
}

// Handle AJAX requests for sticky notes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response = ['success' => false];
    $userId = $_SESSION['userId'];
    
    switch ($_POST['action']) {
        case 'get':
            // Get all notes for the current user
            $stmt = $pdo->prepare('SELECT id, content FROM sticky_notes WHERE user_id = :userId ORDER BY updated_at DESC');
            $stmt->execute(['userId' => $userId]);
            $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response = ['success' => true, 'notes' => $notes];
            break;
            
        case 'create':
            // Create a new note
            $stmt = $pdo->prepare('INSERT INTO sticky_notes (user_id, content, created_at, updated_at) VALUES (:userId, :content, NOW(), NOW()) RETURNING id');
            $stmt->execute([
                'userId' => $userId,
                'content' => ''
            ]);
            $noteId = $stmt->fetch(PDO::FETCH_ASSOC)['id'];
            $response = ['success' => true, 'id' => $noteId];
            break;
            
        case 'update':
            // Update note content
            $noteId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $content = $_POST['content'];
            
            // Verify this note belongs to the current user
            $stmt = $pdo->prepare('SELECT id FROM sticky_notes WHERE id = :id AND user_id = :userId');
            $stmt->execute(['id' => $noteId, 'userId' => $userId]);
            
            if ($stmt->rowCount() > 0) {
                $stmt = $pdo->prepare('UPDATE sticky_notes SET content = :content, updated_at = NOW() WHERE id = :id');
                $stmt->execute(['content' => $content, 'id' => $noteId]);
                $response = ['success' => true];
            } else {
                $response = ['success' => false, 'error' => 'Not authorized'];
            }
            break;
            
        case 'delete':
            // Delete a note
            $noteId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            
            // Verify this note belongs to the current user
            $stmt = $pdo->prepare('SELECT id FROM sticky_notes WHERE id = :id AND user_id = :userId');
            $stmt->execute(['id' => $noteId, 'userId' => $userId]);
            
            if ($stmt->rowCount() > 0) {
                $stmt = $pdo->prepare('DELETE FROM sticky_notes WHERE id = :id');
                $stmt->execute(['id' => $noteId]);
                $response = ['success' => true];
            } else {
                $response = ['success' => false, 'error' => 'Not authorized'];
            }
            break;
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sticky Notes - TaskQuest</title>
    <!-- CSS & Bootstrap -->
    <?php include("header.php") ?>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding-top: 60px; 
            box-sizing: border-box;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px; /* Match the navbar height */
            background: #fff; /* Match your navbar background */
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .sticky-notes-section {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1200px;
            min-height: 80vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 auto; /* Ensure it's centered horizontally */
        }

        .sticky-notes-section h1 {
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: #333;
        }

        #add-note {
            background-color: #5E5DF0;
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        #add-note:hover {
            background-color: #4a4acb;
        }

        #notes-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            width: 100%;
            justify-content: center;
        }

        .note {
            background: #fffae6;
            border: 1px solid #f0e68c;
            border-radius: 8px;
            padding: 1rem;
            width: 250px;
            min-height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .note .toolbar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .note .editable {
            flex-grow: 1;
            outline: none;
            border: none;
            background: transparent;
            resize: none;
            font-size: 1rem;
        }

        .note .delete-btn {
            background: #ff4d4d;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 0.25rem 0.5rem;
            cursor: pointer;
            font-size: 0.9rem;
            align-self: flex-end;
        }

        .note .delete-btn:hover {
            background: #e63939;
        }

        .loading {
            text-align: center;
            padding: 2rem;
            font-size: 1.2rem;
            color: #777;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            text-align: center;
            width: 100%;
        }
    </style>
</head>

<body>
    <!-- Header-Bereich mit Navigation -->
    <header>
        <?php require_once("navbar.php") ?>
    </header>

    <section class="sticky-notes-section">
        <h1>Sticky Notes</h1>
        <button id="add-note">+ Add</button>

        <div id="notes-container">
            <div class="loading">Loading your notes...</div>
        </div>
    </section>

    <script type="module">
        import { EmojiButton } from 'https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4/dist/index.min.js';

        // ------------------------
        // Server API
        // ------------------------
        const api = {
            async loadNotes() {
                const formData = new FormData();
                formData.append('action', 'get');
                
                const response = await fetch('stickynotes.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                if (data.success) {
                    return data.notes;
                } else {
                    throw new Error(data.error || 'Failed to load notes');
                }
            },
            
            async createNote() {
                const formData = new FormData();
                formData.append('action', 'create');
                
                const response = await fetch('stickynotes.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                if (data.success) {
                    return { id: data.id, content: '' };
                } else {
                    throw new Error(data.error || 'Failed to create note');
                }
            },
            
            async updateNote(id, content) {
                const formData = new FormData();
                formData.append('action', 'update');
                formData.append('id', id);
                formData.append('content', content);
                
                const response = await fetch('stickynotes.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                if (!data.success) {
                    throw new Error(data.error || 'Failed to update note');
                }
            },
            
            async deleteNote(id) {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id', id);
                
                const response = await fetch('stickynotes.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                if (!data.success) {
                    throw new Error(data.error || 'Failed to delete note');
                }
            }
        };

        // ------------------------
        // Main App
        // ------------------------
        document.addEventListener('DOMContentLoaded', () => {
            const addBtn = document.getElementById('add-note');
            const container = document.getElementById('notes-container');
            
            // Initial load
            loadNotes();
            
            // Load all notes
            async function loadNotes() {
                try {
                    const notes = await api.loadNotes();
                    container.innerHTML = ''; // Clear loading message
                    
                    if (notes.length === 0) {
                        container.innerHTML = '<p>You don\'t have any notes yet. Click "Add" to create one!</p>';
                    } else {
                        notes.forEach(note => renderNote(note));
                    }
                } catch (error) {
                    container.innerHTML = `<div class="error-message">Error: ${error.message}</div>`;
                    console.error('Failed to load notes:', error);
                }
            }

            // Add new note
            addBtn.addEventListener('click', async () => {
                try {
                    const note = await api.createNote();
                    renderNote(note, true);
                } catch (error) {
                    alert(`Error creating note: ${error.message}`);
                    console.error('Failed to create note:', error);
                }
            });

            // Render & wire up one note
            function renderNote(note, scrollIntoView = false) {
                const article = document.createElement('article');
                article.className = 'note';
                article.dataset.id = note.id;

                // 1) Toolbar
                const toolbar = document.createElement('div');
                toolbar.className = 'toolbar';
                toolbar.innerHTML = `
                    <button data-cmd="bold"><b>B</b></button>
                    <button data-cmd="italic"><i>I</i></button>
                    <button data-cmd="insertUnorderedList">• List</button>
                    <select class="font-size">
                        <option value="" selected>Font</option>
                        <option value="1">8px</option>
                        <option value="2">10px</option>
                        <option value="3">12px</option>
                        <option value="4">14px</option>
                        <option value="5">18px</option>
                        <option value="6">24px</option>
                        <option value="7">36px</option>
                    </select>
                    <button class="emoji-btn" title="Emoji">😊</button>
                `;
                article.appendChild(toolbar);

                // 2) Editable area
                const editable = document.createElement('div');
                editable.className = 'editable';
                editable.contentEditable = 'true';
                editable.innerHTML = note.content;
                
                // Save content after a short delay when user stops typing
                let saveTimeout;
                editable.addEventListener('input', () => {
                    clearTimeout(saveTimeout);
                    saveTimeout = setTimeout(() => saveContent(note.id, editable.innerHTML), 500);
                });
                
                article.appendChild(editable);

                // 3) Delete button
                const delBtn = document.createElement('button');
                delBtn.className = 'delete-btn';
                delBtn.innerHTML = '&times;';
                delBtn.title = 'Delete note';
                delBtn.addEventListener('click', () => deleteNote(note.id, article));
                article.appendChild(delBtn);

                // 4) Emoji picker integration
                const emojiBtn = toolbar.querySelector('.emoji-btn');
                const picker = new EmojiButton({ position: 'top-start' });
                picker.on('emoji', selection => {
                    editable.focus();
                    document.execCommand('insertText', false, selection.emoji);
                    // Trigger save when emoji is inserted
                    clearTimeout(saveTimeout);
                    saveTimeout = setTimeout(() => saveContent(note.id, editable.innerHTML), 500);
                });
                emojiBtn.addEventListener('click', () => picker.togglePicker(emojiBtn));

                // 5) Wire toolbar commands
                toolbar.querySelectorAll('button[data-cmd]').forEach(btn => {
                    btn.addEventListener('click', () => {
                        editable.focus();
                        document.execCommand(btn.dataset.cmd, false, null);
                        // Trigger save when formatting is changed
                        clearTimeout(saveTimeout);
                        saveTimeout = setTimeout(() => saveContent(note.id, editable.innerHTML), 500);
                    });
                });
                
                toolbar.querySelector('.font-size').addEventListener('change', function() {
                    if (!this.value) return;
                    editable.focus();
                    document.execCommand('fontSize', false, this.value);
                    this.value = '';
                    // Trigger save when font size is changed
                    clearTimeout(saveTimeout);
                    saveTimeout = setTimeout(() => saveContent(note.id, editable.innerHTML), 500);
                });

                // Append to DOM
                container.appendChild(article);
                if (scrollIntoView) {
                    article.scrollIntoView({ behavior: 'smooth' });
                    editable.focus();
                }
            }

            // Save updated HTML content
            async function saveContent(id, html) {
                try {
                    await api.updateNote(id, html);
                    console.log('Note saved successfully');
                } catch (error) {
                    console.error('Failed to save note:', error);
                    alert(`Error saving note: ${error.message}`);
                }
            }

            // Delete note
            async function deleteNote(id, el) {
                if (!confirm('Are you sure you want to delete this note?')) {
                    return;
                }
                
                try {
                    await api.deleteNote(id);
                    el.remove();
                    

                } catch (error) {
                    console.error('Failed to delete note:', error);
                    alert(`Error deleting note: ${error.message}`);
                }
            }
        });
    </script>
</body>

</html>