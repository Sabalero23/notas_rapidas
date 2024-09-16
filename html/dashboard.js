document.addEventListener('DOMContentLoaded', function() {
    const noteContainer = document.getElementById('noteContainer');
    const noteModal = document.getElementById('noteModal');
    const searchModal = document.getElementById('searchModal');
    const settingsModal = document.getElementById('settingsModal');
    const closeModal = document.getElementById('closeModal');
    const closeSearchModal = document.getElementById('closeSearchModal');
    const closeSettingsModal = document.getElementById('closeSettingsModal');
    const saveNote = document.getElementById('saveNote');
    const noteText = document.getElementById('noteText');
    const noteImage = document.getElementById('noteImage');
    const mobileKeypad = document.getElementById('mobileKeypad');
    const modalTitle = document.getElementById('modalTitle');
    const searchInput = document.getElementById('searchInput');
    const performSearch = document.getElementById('performSearch');
    const themeSelect = document.getElementById('themeSelect');
    const saveSettings = document.getElementById('saveSettings');
    let currentNoteId = null;

    // Inicialización de ClipboardJS
    new ClipboardJS('.copy-note', {
        text: function(trigger) {
            return trigger.closest('.note').querySelector('p').innerText;
        }
    });

    // Event listeners
    mobileKeypad.addEventListener('click', handleMobileKeypadClick);
    closeModal.addEventListener('click', () => closeModalFunction(noteModal));
    closeSearchModal.addEventListener('click', () => closeModalFunction(searchModal));
    closeSettingsModal.addEventListener('click', () => closeModalFunction(settingsModal));
    saveNote.addEventListener('click', handleSaveNote);
    noteContainer.addEventListener('click', handleNoteContainerClick);
    performSearch.addEventListener('click', handlePerformSearch);
    saveSettings.addEventListener('click', handleSaveSettings);

    // Funciones de manejo de eventos
    function handleMobileKeypadClick(e) {
        const button = e.target.closest('.keypad-btn');
        if (!button) return;
        
        const action = button.dataset.action;
        switch(action) {
            case 'newNote':
                openNoteModal();
                break;
            case 'searchNotes':
                openSearchModal();
                break;
            case 'sortNotes':
                sortNotes();
                break;
            case 'manageUsers':
                window.location.href = 'usuarios.php';
                break;
            case 'editProfile':
                window.location.href = 'profile.php';
                break;
            case 'settings':
                openSettingsModal();
                break;
            case 'logout':
                window.location.href = 'logout.php';
                break;
        }
    }

    function handleSaveNote() {
        const formData = new FormData();
        formData.append('text', noteText.value);
        if (noteImage.files[0]) {
            formData.append('image', noteImage.files[0]);
        }
        if (currentNoteId !== null) {
            formData.append('id', currentNoteId);
        }

        fetch('save_note.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeModalFunction(noteModal);
                loadNotes();
            } else {
                alert('Error al guardar la nota: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function handleNoteContainerClick(e) {
        const noteDiv = e.target.closest('.note');
        if (!noteDiv) return;

        if (e.target.classList.contains('edit-note') || e.target.parentNode.classList.contains('edit-note')) {
            currentNoteId = noteDiv.dataset.id;
            noteText.value = noteDiv.querySelector('p').innerText;
            modalTitle.textContent = 'Editar Nota';
            openNoteModal();
        } else if (e.target.classList.contains('delete-note') || e.target.parentNode.classList.contains('delete-note')) {
            if (confirm('¿Estás seguro de que quieres eliminar esta nota?')) {
                deleteNote(noteDiv.dataset.id);
            }
        }
    }

    function handlePerformSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const notes = document.querySelectorAll('.note');
        notes.forEach(note => {
            const text = note.querySelector('p').textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                note.style.display = '';
            } else {
                note.style.display = 'none';
            }
        });
        closeModalFunction(searchModal);
    }

    function handleSaveSettings() {
        const theme = themeSelect.value;
        document.body.className = theme;
        localStorage.setItem('theme', theme);
        closeModalFunction(settingsModal);
    }

    // Funciones auxiliares
    function openNoteModal() {
        if (currentNoteId === null) {
            noteText.value = '';
            noteImage.value = '';
            modalTitle.textContent = 'Crear Nota';
        }
        noteModal.style.display = 'block';
    }

    function openSearchModal() {
        searchInput.value = '';
        searchModal.style.display = 'block';
        searchInput.focus();
    }

    function openSettingsModal() {
        themeSelect.value = localStorage.getItem('theme') || 'light';
        settingsModal.style.display = 'block';
    }

    function closeModalFunction(modal) {
        modal.style.display = 'none';
    }

    function deleteNote(id) {
        fetch('delete_note.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotes();
            } else {
                alert('Error al eliminar la nota: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function loadNotes() {
        fetch('get_notes.php')
        .then(response => response.json())
        .then(data => {
            noteContainer.innerHTML = '';
            if (Array.isArray(data)) {
                data.forEach((note, index) => {
                    const noteDiv = document.createElement('div');
                    noteDiv.className = 'note';
                    noteDiv.dataset.id = index;
                    noteDiv.innerHTML = `
                        ${note.image ? `<img src="${note.image}" alt="Imagen de la nota">` : ''}
                        <p>${note.text}</p>
                        <div class="note-actions">
                            <button class="edit-note" title="Editar"><i class="fas fa-edit"></i></button>
                            <button class="copy-note" title="Copiar"><i class="fas fa-copy"></i></button>
                            <button class="delete-note" title="Eliminar"><i class="fas fa-trash"></i></button>
                        </div>
                    `;
                    noteContainer.appendChild(noteDiv);
                });
            } else {
                console.error('Los datos recibidos no son un array:', data);
                noteContainer.innerHTML = '<p>Error al cargar las notas. Por favor, intenta de nuevo más tarde.</p>';
            }
        })
        .catch(error => {
            console.error('Error loading notes:', error);
            noteContainer.innerHTML = '<p>Error al cargar las notas. Por favor, intenta de nuevo más tarde.</p>';
        });
    }

    function sortNotes() {
        const notes = Array.from(noteContainer.children);
        notes.sort((a, b) => {
            return a.querySelector('p').textContent.localeCompare(b.querySelector('p').textContent);
        });
        notes.forEach(note => noteContainer.appendChild(note));
    }

    // Inicialización
    loadNotes();

    // Aplicar tema guardado
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        document.body.className = savedTheme;
    }
});