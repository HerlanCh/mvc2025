// assets/js/utils.js
class Utilities {
    static initAnimations() {
        // Fade in animation for elements
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.animation = `fadeInUp 0.6s ease ${index * 0.1}s`;
            card.style.animationFillMode = 'both';
        });

        // Auto hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.animation = 'slideOut 0.5s ease';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    }
    
    static handleFormSubmit(e) {
        const submitBtn = e.target.querySelector('button[type="submit"]');
        if(submitBtn && !submitBtn.disabled) {
            submitBtn.disabled = true;
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Procesando...';
            
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }, 3000);
        }
    }
    
    static debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    static formatPrice(price) {
        return new Intl.NumberFormat('es-ES', {
            style: 'currency',
            currency: 'USD'
        }).format(price);
    }
    
    static formatDate(date) {
        return new Date(date).toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }
    
    static validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    static exportData() {
        const data = {
            preferences: BallStore.storage.local.get('preferences'),
            favorites: BallStore.storage.local.get('favorites'),
            cart: BallStore.storage.local.get('cart'),
            search_history: BallStore.storage.session.get('search_history'),
            exported_at: new Date().toISOString()
        };
        
        const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `ballstore_backup_${Date.now()}.json`;
        a.click();
        URL.revokeObjectURL(url);
        
        BallStore.notifications.show('Datos exportados correctamente', 'success');
    }
    
    static importData(fileInput) {
        const file = fileInput.files[0];
        if(!file) return;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const data = JSON.parse(e.target.result);
                
                if(data.preferences) BallStore.storage.local.set('preferences', data.preferences);
                if(data.favorites) BallStore.storage.local.set('favorites', data.favorites);
                if(data.cart) BallStore.storage.local.set('cart', data.cart);
                if(data.search_history) BallStore.storage.session.set('search_history', data.search_history);
                
                BallStore.notifications.show('Datos importados correctamente', 'success');
                setTimeout(() => location.reload(), 1500);
            } catch(error) {
                BallStore.notifications.show('Error al importar datos', 'danger');
            }
        };
        reader.readAsText(file);
    }
}

// Search History Management
class SearchManager {
    static addToHistory(query) {
        if(!query || query.trim() === '') return;
        
        let history = BallStore.storage.session.get('search_history') || [];
        history = history.filter(item => item !== query);
        history.unshift(query);
        
        if(history.length > 10) {
            history = history.slice(0, 10);
        }
        
        BallStore.storage.session.set('search_history', history);
    }
    
    static getHistory() {
        return BallStore.storage.session.get('search_history') || [];
    }
    
    static clearHistory() {
        BallStore.storage.session.remove('search_history');
        BallStore.notifications.show('Historial de búsqueda limpiado', 'info');
    }
}

// Filters Management
class FiltersManager {
    static save(filters) {
        BallStore.storage.session.set('active_filters', filters);
    }
    
    static load() {
        return BallStore.storage.session.get('active_filters') || {};
    }
    
    static clear() {
        BallStore.storage.session.remove('active_filters');
    }
}