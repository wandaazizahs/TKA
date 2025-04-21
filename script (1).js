// Hitung subtotal otomatis
document.addEventListener('DOMContentLoaded', function() {
    const hargaInput = document.getElementById('harga');
    const jumlahInput = document.getElementById('jumlah');
    const subtotalInput = document.getElementById('subtotal');
    
    if (hargaInput && jumlahInput && subtotalInput) {
        [hargaInput, jumlahInput].forEach(input => {
            input.addEventListener('input', calculateSubtotal);
        });
    }
    
    function calculateSubtotal() {
        const harga = parseFloat(hargaInput.value) || 0;
        const jumlah = parseFloat(jumlahInput.value) || 0;
        subtotalInput.value = 'Rp ' + (harga * jumlah).toLocaleString('id-ID');
    }
});