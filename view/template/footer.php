</div> <!-- End main-container -->
    </div> <!-- End container -->

    <!-- Footer -->
    <footer class="text-center mt-5" style="color: white;">
        <div class="container">
            <p class="mb-0">
                <i class="bi bi-heart-fill" style="color: #ef4444;"></i> 
                <?php echo constant("SITE_NAME"); ?> &copy; <?php echo date('Y'); ?> - 
                <?php echo constant("SITE_SLOGAN"); ?>
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // ========================================
        // SISTEMA DE ALMACENAMIENTO WEB
        // ========================================
        
        // Clase para gestionar LocalStorage
        class StorageManager {
            constructor(storageType = 'local') {
                this.storage = storageType === 'local' ? localStorage : sessionStorage;
                this.prefix = 'ballstore_';
            }
            
            set(key, value) {
                try {
                    const serialized = JSON.stringify(value);
                    this.storage.setItem(this.prefix + key, serialized);
                    return true;
                } catch(e) {
                    console.error('Error al guardar en storage:', e);
                    return false;
                }
            }
            
            get(key) {
                try {
                    const item = this.storage.getItem(this.prefix + key);
                    return item ? JSON.parse(item) : null;
                } catch(e) {
                    console.error('Error al leer storage:', e);
                    return null;
                }
            }
            
            remove(key) {
                this.storage.removeItem(this.prefix + key);
            }
            
            clear() {
                Object.keys(this.storage).forEach(key => {
                    if(key.startsWith(this.prefix)) {
                        this.storage.removeItem(key);
                    }
                });
            }
            
            getAll() {
                const items = {};
                Object.keys(this.storage).forEach(key => {
                    if(key.startsWith(this.prefix)) {
                        items[key.replace(this.prefix, '')] = this.get(key.replace(this.prefix, ''));
                    }
                });
                return items;
            }
        }
        
        // Instancias globales
        const localStore = new StorageManager('local');
        const sessionStore = new StorageManager('session');
        
        // ========================================
        // GESTIÓN DE PREFERENCIAS (LocalStorage)
        // ========================================
        
        // Cargar preferencias al iniciar
        window.addEventListener('load', function() {
            loadUserPreferences();
            loadSearchHistory();
            loadCartFromStorage();
        });
        
        function loadUserPreferences() {
            const prefs = localStore.get('preferences') || {
                theme: 'light',
                view: 'grid',
                notifications: true,
                language: 'es'
            };
            
            // Aplicar tema
            if(prefs.theme === 'dark') {
                document.body.classList.add('dark-theme');
            }
            
            // Aplicar vista (grid/list)
            if(prefs.view === 'list') {
                const catalog = document.querySelector('.row.g-4');
                if(catalog) catalog.classList.add('list-view');
            }
            
            return prefs;
        }
        
        function savePreference(key, value) {
            const prefs = localStore.get('preferences') || {};
            prefs[key] = value;
            localStore.set('preferences', prefs);
            
            // Mostrar notificación
            showNotification('Preferencia guardada', 'success');
        }
        
        function openPreferences() {
            // Aquí se podría abrir un modal con preferencias
            const prefs = localStore.get('preferences');
            alert('Preferencias:\n' + JSON.stringify(prefs, null, 2));
        }
        
        // ========================================
        // HISTORIAL DE BÚSQUEDA (SessionStorage)
        // ========================================
        
        function addToSearchHistory(query) {
            if(!query || query.trim() === '') return;
            
            let history = sessionStore.get('search_history') || [];
            
            // Evitar duplicados
            history = history.filter(item => item !== query);
            
            // Agregar al inicio
            history.unshift(query);
            
            // Límite de 10 búsquedas
            if(history.length > 10) {
                history = history.slice(0, 10);
            }
            
            sessionStore.set('search_history', history);
        }
        
        function loadSearchHistory() {
            const history = sessionStore.get('search_history') || [];
            // Aquí se podría mostrar en un dropdown de búsqueda
            console.log('Historial de búsqueda:', history);
            return history;
        }
        
        function clearSearchHistory() {
            sessionStore.remove('search_history');
            showNotification('Historial de búsqueda limpiado', 'info');
        }
        
        // ========================================
        // CARRITO PERSISTENTE (LocalStorage)
        // ========================================
        
        function saveCartToStorage() {
            // Guardar carrito en localStorage para persistencia
            const cartItems = Array.from(document.querySelectorAll('.cart-item')).map(item => {
                return {
                    id: item.dataset.id,
                    name: item.dataset.name,
                    price: item.dataset.price,
                    quantity: item.dataset.quantity
                };
            });
            
            localStore.set('cart_backup', {
                items: cartItems,
                timestamp: Date.now()
            });
        }
        
        function loadCartFromStorage() {
            const cartBackup = localStore.get('cart_backup');
            if(cartBackup) {
                // Verificar que no sea muy antiguo (más de 7 días)
                const weekInMs = 7 * 24 * 60 * 60 * 1000;
                if(Date.now() - cartBackup.timestamp < weekInMs) {
                    console.log('Carrito recuperado de localStorage:', cartBackup);
                } else {
                    localStore.remove('cart_backup');
                }
            }
        }
        
        // ========================================
        // FAVORITOS (LocalStorage)
        // ========================================
        
        function addToFavorites(productId, productData) {
            let favorites = localStore.get('favorites') || [];
            
            // Verificar si ya existe
            if(favorites.find(f => f.id === productId)) {
                showNotification('Ya está en favoritos', 'info');
                return false;
            }
            
            favorites.push({
                id: productId,
                ...productData,
                addedAt: Date.now()
            });
            
            localStore.set('favorites', favorites);
            showNotification('Agregado a favoritos', 'success');
            updateFavoritesUI();
            return true;
        }
        
        function removeFromFavorites(productId) {
            let favorites = localStore.get('favorites') || [];
            favorites = favorites.filter(f => f.id !== productId);
            localStore.set('favorites', favorites);
            showNotification('Eliminado de favoritos', 'info');
            updateFavoritesUI();
        }
        
        function getFavorites() {
            return localStore.get('favorites') || [];
        }
        
        function updateFavoritesUI() {
            const count = getFavorites().length;
            const badge = document.querySelector('.favorites-count');
            if(badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'inline' : 'none';
            }
        }
        
        // ========================================
        // FILTROS (SessionStorage)
        // ========================================
        
        function saveFilters(filters) {
            sessionStore.set('active_filters', filters);
        }
        
        function loadFilters() {
            return sessionStore.get('active_filters') || {};
        }
        
        function clearFilters() {
            sessionStore.remove('active_filters');
        }
        
        // ========================================
        // SISTEMA DE NOTIFICACIONES
        // ========================================
        
        function showNotification(message, type = 'info') {
            const prefs = localStore.get('preferences') || {};
            if(prefs.notifications === false) return;
            
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-dismissible fade show notification-toast`;
            notification.innerHTML = `
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'info-circle'}"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                animation: slideInRight 0.3s ease;
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
        
        // ========================================
        // GESTIÓN DE COOKIES
        // ========================================
        
        class CookieManager {
            static set(name, value, days = 30, options = {}) {
                const expires = new Date();
                expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
                
                const defaultOptions = {
                    path: '/',
                    expires: expires.toUTCString(),
                    sameSite: 'Strict',
                    // secure: true, // Activar en producción con HTTPS
                };
                
                const cookieOptions = { ...defaultOptions, ...options };
                
                let cookieString = `${name}=${encodeURIComponent(value)}`;
                for(let [key, val] of Object.entries(cookieOptions)) {
                    if(key === 'secure' && val) {
                        cookieString += `; ${key}`;
                    } else {
                        cookieString += `; ${key}=${val}`;
                    }
                }
                
                document.cookie = cookieString;
            }
            
            static get(name) {
                const nameEQ = name + "=";
                const ca = document.cookie.split(';');
                for(let i = 0; i < ca.length; i++) {
                    let c = ca[i].trim();
                    if(c.indexOf(nameEQ) === 0) {
                        return decodeURIComponent(c.substring(nameEQ.length));
                    }
                }
                return null;
            }
            
            static delete(name) {
                document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
            }
        }
        
        // ========================================
        // ANIMACIONES Y UI
        // ========================================
        
        // Fade in animation for elements
        document.addEventListener('DOMContentLoaded', function() {
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
            
            // Inicializar UI
            updateFavoritesUI();
        });

        // Validar stock antes de agregar al carrito
        function validarStock(form, stockDisponible, nombreProducto) {
            const cantidad = parseInt(form.querySelector('input[name="cantidad"]').value);
            
            if(cantidad > stockDisponible) {
                showNotification(`Stock insuficiente: solo hay ${stockDisponible} unidades de "${nombreProducto}"`, 'danger');
                form.querySelector('input[name="cantidad"]').value = stockDisponible;
                return false;
            }
            
            if(cantidad < 1) {
                showNotification('La cantidad debe ser al menos 1', 'warning');
                form.querySelector('input[name="cantidad"]').value = 1;
                return false;
            }
            
            return true;
        }

        // Form validation animation
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"]');
                if(submitBtn && !submitBtn.disabled) {
                    submitBtn.disabled = true;
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<span class="loading"></span> Procesando...';
                    
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 3000);
                }
            });
        });

        // Animaciones CSS adicionales
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideOut {
                from { opacity: 1; transform: translateX(0); }
                to { opacity: 0; transform: translateX(20px); }
            }
            @keyframes slideInRight {
                from { opacity: 0; transform: translateX(100px); }
                to { opacity: 1; transform: translateX(0); }
            }
            @keyframes slideOutRight {
                from { opacity: 1; transform: translateX(0); }
                to { opacity: 0; transform: translateX(100px); }
            }
        `;
        document.head.appendChild(style);
        
        // ========================================
        // EXPORT/IMPORT DE DATOS
        // ========================================
        
        function exportAllData() {
            const data = {
                preferences: localStore.get('preferences'),
                favorites: localStore.get('favorites'),
                cart_backup: localStore.get('cart_backup'),
                search_history: sessionStore.get('search_history'),
                exported_at: new Date().toISOString()
            };
            
            const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `ballstore_backup_${Date.now()}.json`;
            a.click();
            URL.revokeObjectURL(url);
            
            showNotification('Datos exportados correctamente', 'success');
        }
        
        function importData(fileInput) {
            const file = fileInput.files[0];
            if(!file) return;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const data = JSON.parse(e.target.result);
                    
                    if(data.preferences) localStore.set('preferences', data.preferences);
                    if(data.favorites) localStore.set('favorites', data.favorites);
                    if(data.cart_backup) localStore.set('cart_backup', data.cart_backup);
                    if(data.search_history) sessionStore.set('search_history', data.search_history);
                    
                    showNotification('Datos importados correctamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } catch(error) {
                    showNotification('Error al importar datos', 'danger');
                }
            };
            reader.readAsText(file);
        }
        
        // Exponer funciones globales
        window.BallStore = {
            storage: { local: localStore, session: sessionStore },
            cookies: CookieManager,
            notifications: showNotification,
            favorites: { add: addToFavorites, remove: removeFromFavorites, get: getFavorites },
            search: { add: addToSearchHistory, get: loadSearchHistory, clear: clearSearchHistory },
            preferences: { save: savePreference, load: loadUserPreferences },
            backup: { export: exportAllData, import: importData }
        };
    </script>
</body>
</html>