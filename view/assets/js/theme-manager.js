// assets/js/theme-manager.js
class ThemeManager {
    constructor() {
        this.currentTheme = this.getSavedTheme();
        this.init();
    }
    
    init() {
        this.applyTheme(this.currentTheme);
        this.updateThemeUI();
    }
    
    toggleTheme() {
        const newTheme = this.currentTheme === 'light' ? 'dark' : 'light';
        this.applyTheme(newTheme);
        this.saveTheme(newTheme);
        this.updateThemeUI();
        
        BallStore.notifications.show(`Tema ${newTheme === 'dark' ? 'oscuro' : 'claro'} activado`, 'success');
        this.saveThemeToDatabase(newTheme);
    }
    
    applyTheme(theme) {
        if(theme === 'dark') {
            document.body.classList.add('dark-theme');
        } else {
            document.body.classList.remove('dark-theme');
        }
        this.currentTheme = theme;
    }
    
    updateThemeUI() {
        const icon = document.getElementById('themeIcon');
        const text = document.getElementById('themeText');
        
        if(!icon || !text) return;
        
        if(this.currentTheme === 'dark') {
            icon.className = 'bi bi-sun';
            text.textContent = 'Tema Claro';
        } else {
            icon.className = 'bi bi-moon-stars';
            text.textContent = 'Tema Oscuro';
        }
    }
    
    getSavedTheme() {
        return BallStore.storage.local.get('theme') || 'light';
    }
    
    saveTheme(theme) {
        BallStore.storage.local.set('theme', theme);
    }
    
    saveThemeToDatabase(theme) {
        // Guardar en BD via AJAX
        fetch('?controller=preferences&action=saveTheme', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'tema=' + theme
        }).catch(err => console.log('Error guardando tema:', err));
    }
}