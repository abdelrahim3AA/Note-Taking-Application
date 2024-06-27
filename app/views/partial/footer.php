<script>
document.addEventListener("DOMContentLoaded", () => {
    const noteForm = document.getElementById('note-form');
    const unfinishedNotes = document.getElementById('unfinished-notes');
    const finishedNotes = document.getElementById('finished-notes');
    const sessionStatus = document.getElementById('session-status').value;

    if (sessionStatus === 'inactive') {
        noteForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(noteForm);
            const newTask = {
                id: Date.now(), // Unique temporary ID
                title: formData.get('title'),
                description: formData.get('description'),
                created_at: new Date().toLocaleString(),
                updated_at: new Date().toLocaleString(),
                completed: false
            };
            addNoteToDOM(newTask);
            noteForm.reset();
        });
    }

    function addNoteToDOM(task) {
        const noteItem = document.createElement('div');
        noteItem.classList.add('note-item');
        noteItem.setAttribute('id', 'task-' + task.id);
        noteItem.innerHTML = `
            <h3>${task.title}</h3>
            <p>${task.description}</p>
            <div class="actions">
                <div class="dates">
                    <span>Created at: ${task.created_at}</span><br>
                    <span>Updated at: ${task.updated_at}</span>
                </div>
                <div></div>
            </div>
        `;

        if (task.completed) {
            finishedNotes.appendChild(noteItem);
        } else {
            unfinishedNotes.appendChild(noteItem);
        }
    }

    const toggleSidebarButton = document.querySelector('.toggle-sidebar');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');

    toggleSidebarButton.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        mainContent.classList.toggle('expanded');
        toggleSidebarButton.classList.toggle('active');
    });
});
</script>
</body>
</html>
