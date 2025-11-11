// assets/js/app.js
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar módulos
    BallStore.storage = {
        local: new StorageManager('local'),
        session: new StorageManager('session')
    };
    
    BallStore.cookies = CookieManager;
    BallStore.notifications = new NotificationManager();
    BallStore.theme = new ThemeManager();
    BallStore.favorites = new FavoritesManager();
    BallStore.cart = new CartManager();
    BallStore.utils = Utilities;
    BallStore.search = SearchManager;
    BallStore.filters = FiltersManager;
    
    // Inicializar componentes
    BallStore.utils.initAnimations();
    initEventListeners();
    loadUserPreferences();
    
    console.log('BallStore inicializado correctamente');
});

function initEventListeners() {
    // Event listeners globales
    const themeToggle = document.getElementById('themeToggle');
    if(themeToggle) {
        themeToggle.addEventListener('click', () => BallStore.theme.toggleTheme());
    }
    
    // Validación de formularios
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', BallStore.utils.handleFormSubmit);
    });
    
    // Búsqueda con debounce
    const searchInput = document.getElementById('searchInput');
    if(searchInput) {
        searchInput.addEventListener('input', BallStore.utils.debounce(function(e) {
            BallStore.search.addToHistory(e.target.value);
        }, 500));
    }
}

function loadUserPreferences() {
    const prefs = BallStore.storage.local.get('preferences') || {
        theme: 'light',
        view: 'grid',
        notifications: true,
        language: 'es'
    };
    
    if(prefs.view === 'list') {
        const catalog = document.querySelector('.row.g-4');
        if(catalog) catalog.classList.add('list-view');
    }
    
    return prefs;
}

// Exponer funciones globales para uso en HTML
window.toggleTheme = () => BallStore.theme.toggleTheme();
window.exportAllData = () => BallStore.utils.exportData();
window.importData = (fileInput) => BallStore.utils.importData(fileInput);