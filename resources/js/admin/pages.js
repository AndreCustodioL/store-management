document.getElementById('sidebarToggle').addEventListener('click', function() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('collapsed');
    const submenu = document.getElementById('submenu');
    if (sidebar.classList.contains('collapsed')) {
        // Esconde o submenu se o menu principal for colapsado
        submenu.classList.remove('show');
    }
});

document.getElementById('submenuToggle').addEventListener('click', function(e) {
    e.preventDefault();
    const sidebar = document.getElementById('sidebar');
    const submenu = document.getElementById('submenu');
    
    if (!sidebar.classList.contains('collapsed')) {
        // Apenas mostra/oculta o submenu se o menu principal não estiver colapsado
        submenu.classList.toggle('show');
    }
});