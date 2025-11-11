// assets/js/storage-manager.js
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

class CookieManager {
    static set(name, value, days = 30, options = {}) {
        const expires = new Date();
        expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
        
        const defaultOptions = {
            path: '/',
            expires: expires.toUTCString(),
            sameSite: 'Strict',
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