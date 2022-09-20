function fbAddToCart(val) {
    fbq('track', 'AddToCart', {
        value: val,
        currency: 'USD'
    });
}
function fbCheckout() {
    fbq('track', 'InitiateCheckout');
}
function fbPurchase(val, content_ids) {
    fbq('track', 'Purchase', {
        value: val,
        currency: 'USD',
        content_type: 'product',
        content_ids: content_ids
    });
}