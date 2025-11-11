// assets/js/cart-manager.js
class CartManager {
    constructor() {
        this.init();
    }
    
    init() {
        this.loadFromStorage();
        this.updateUI();
    }
    
    add(productId, productData, quantity = 1) {
        let cart = this.getAll();
        
        // Buscar si ya existe el producto
        const existingItem = cart.find(item => item.id === productId);
        
        if(existingItem) {
            existingItem.quantity += quantity;
        } else {
            cart.push({
                id: productId,
                ...productData,
                quantity: quantity,
                addedAt: Date.now()
            });
        }
        
        this.save(cart);
        BallStore.notifications.show('Producto agregado al carrito', 'success');
        this.updateUI();
    }
    
    remove(productId) {
        let cart = this.getAll();
        cart = cart.filter(item => item.id !== productId);
        this.save(cart);
        BallStore.notifications.show('Producto eliminado del carrito', 'info');
        this.updateUI();
    }
    
    updateQuantity(productId, quantity) {
        if(quantity < 1) {
            this.remove(productId);
            return;
        }
        
        let cart = this.getAll();
        const item = cart.find(item => item.id === productId);
        
        if(item) {
            item.quantity = quantity;
            this.save(cart);
            this.updateUI();
        }
    }
    
    getAll() {
        return BallStore.storage.local.get('cart') || [];
    }
    
    getTotalItems() {
        return this.getAll().reduce((total, item) => total + item.quantity, 0);
    }
    
    getTotalPrice() {
        return this.getAll().reduce((total, item) => total + (item.price * item.quantity), 0);
    }
    
    save(cart) {
        BallStore.storage.local.set('cart', {
            items: cart,
            timestamp: Date.now(),
            total: this.getTotalPrice(),
            count: this.getTotalItems()
        });
    }
    
    loadFromStorage() {
        const cartData = BallStore.storage.local.get('cart');
        if(cartData && cartData.items) {
            console.log('Carrito recuperado:', cartData);
            return cartData.items;
        }
        return [];
    }
    
    clear() {
        BallStore.storage.local.remove('cart');
        BallStore.notifications.show('Carrito vaciado', 'info');
        this.updateUI();
    }
    
    updateUI() {
        const totalItems = this.getTotalItems();
        const cartBadge = document.querySelector('.cart-count');
        
        if(cartBadge) {
            cartBadge.textContent = totalItems;
            cartBadge.style.display = totalItems > 0 ? 'inline' : 'none';
        }
        
        // Actualizar total en el carrito dropdown
        const cartTotal = document.querySelector('.cart-total');
        if(cartTotal) {
            cartTotal.textContent = `$${this.getTotalPrice().toFixed(2)}`;
        }
    }
    
    validateStock(productId, requestedQuantity, availableStock) {
        const cart = this.getAll();
        const cartItem = cart.find(item => item.id === productId);
        const currentInCart = cartItem ? cartItem.quantity : 0;
        
        return (currentInCart + requestedQuantity) <= availableStock;
    }
}