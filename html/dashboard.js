document.addEventListener('DOMContentLoaded', function() {
    const noteContainer = document.getElementById('noteContainer');
    const noteModal = document.getElementById('noteModal');
    const searchModal = document.getElementById('searchModal');
    const settingsModal = document.getElementById('settingsModal');
    const shareNoteModal = document.getElementById('shareNoteModal');
    const closeModal = document.getElementById('closeModal');
    const closeSearchModal = document.getElementById('closeSearchModal');
    const closeSettingsModal = document.getElementById('closeSettingsModal');
    const closeShareModal = document.getElementById('closeShareModal');
    const saveNote = document.getElementById('saveNote');
    const shareNoteButton = document.getElementById('shareNote');
    const noteText = document.getElementById('noteText');
    const noteImage = document.getElementById('noteImage');
    const shareWithUserId = document.getElementById('shareWithUserId');
    const mobileKeypad = document.getElementById('mobileKeypad');
    const modalTitle = document.getElementById('modalTitle');
    const searchInput = document.getElementById('searchInput');
    const performSearch = document.getElementById('performSearch');
    const themeSelect = document.getElementById('themeSelect');
    const saveSettings = document.getElementById('saveSettings');
    const toggleSharedNotesButton = document.getElementById('toggleSharedNotes');
    let currentNoteId = null;
    let currentNoteIdToShare = null;
    let showSharedNotes = false;

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
    closeShareModal.addEventListener('click', () => closeModalFunction(shareNoteModal));
    saveNote.addEventListener('click', handleSaveNote);
    shareNoteButton.addEventListener('click', performShareNote);
    noteContainer.addEventListener('click', handleNoteContainerClick);
    performSearch.addEventListener('click', handlePerformSearch);
    saveSettings.addEventListener('click', handleSaveSettings);
    toggleSharedNotesButton.addEventListener('click', toggleSharedNotes);

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

    function handleShareNote() {
        if (!currentNoteIdToShare) {
            alert('Por favor, selecciona una nota para compartir');
            return;
        }

        fetch('get_users.php')
        .then(response => response.json())
        .then(users => {
            const userList = Object.entries(users)
                .filter(([id, user]) => id !== currentUserId)
                .map(([id, user]) => `<option value="${id}">${user.username}</option>`)
                .join('');

            const selectHtml = `
                <select id="shareWithUserId">
                    <option value="">Selecciona un usuario</option>
                    ${userList}
                </select>
            `;

            document.getElementById('shareWithUserId').outerHTML = selectHtml;

            openShareNoteModal();
        })
        .catch(error => {
            console.error('Error al obtener la lista de usuarios:', error);
            alert('Error al cargar la lista de usuarios');
        });
    }

    function performShareNote() {
        const shareWithUserId = document.getElementById('shareWithUserId').value;
        if (!shareWithUserId) {
            alert('Por favor, selecciona un usuario para compartir la nota');
            return;
        }

        fetch('share_note.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `noteId=${encodeURIComponent(currentNoteIdToShare)}&shareWithUserId=${encodeURIComponent(shareWithUserId)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                closeModalFunction(shareNoteModal);
                loadNotes();
            } else {
                alert('Error al compartir la nota: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al compartir la nota: ' + error.message);
        });
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
        } else if (e.target.classList.contains('share-note') || e.target.parentNode.classList.contains('share-note')) {
            currentNoteIdToShare = noteDiv.dataset.id;
            handleShareNote();
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

    function openShareNoteModal() {
        shareNoteModal.style.display = 'block';
    }

    function closeModalFunction(modal) {
        modal.style.display = 'none';
        currentNoteId = null;
        currentNoteIdToShare = null;
    }

    function deleteNote(id) {
        fetch('delete_note.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${encodeURIComponent(id)}`
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
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            noteContainer.innerHTML = '';
            if (Array.isArray(data)) {
                data.forEach(note => {
                    const isOwner = String(note.owner) === String(currentUserId);
                    if (isOwner || showSharedNotes) {
                        const noteDiv = document.createElement('div');
                        noteDiv.className = 'note';
                        noteDiv.dataset.id = note.id;
                        noteDiv.innerHTML = `
                            ${note.image ? `<img src="${note.image}" alt="Imagen de la nota">` : ''}
                            <p>${note.text}</p>
                            <div class="note-info">
                                <span>Propietario: ${note.owner_name}</span>
                                <span>Compartida con: ${note.shared_with_names.length} usuario(s)</span>
                            </div>
                            <div class="note-actions">
                                ${isOwner ? `
                                    <button class="edit-note" title="Editar"><i class="fas fa-edit"></i></button>
                                    <button class="delete-note" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    <button class="share-note" title="Compartir"><i class="fas fa-share"></i></button>
                                ` : ''}
                                <button class="copy-note" title="Copiar"><i class="fas fa-copy"></i></button>
                            </div>
                        `;
                        noteContainer.appendChild(noteDiv);
                    }
                });
            } else {
                throw new Error('Los datos recibidos no son un array');
            }
        })
        .catch(error => {
            console.error('Error loading notes:', error);
            noteContainer.innerHTML = `<p>Error al cargar las notas: ${error.message}. Por favor, intenta de nuevo más tarde.</p>`;
        });
    }

    function sortNotes() {
        const notes = Array.from(noteContainer.children);
        notes.sort((a, b) => {
            return a.querySelector('p').textContent.localeCompare(b.querySelector('p').textContent);
        });
        notes.forEach(note => noteContainer.appendChild(note));
    }

    function toggleSharedNotes() {
        showSharedNotes = !showSharedNotes;
        loadNotes();
        updateToggleButtonText();
    }

    function updateToggleButtonText() {
        toggleSharedNotesButton.textContent = showSharedNotes ? 'Ocultar notas compartidas' : 'Mostrar notas compartidas';
    }

    // Inicialización
    loadNotes();
    updateToggleButtonText();

    // Aplicar tema guardado
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        document.body.className = savedTheme;
    }
});