<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD + AJAX (CI4)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'slide-up': 'slideUp 0.3s ease-out',
                        'fade-in': 'fadeIn 0.3s ease-out',
                        'scale-in': 'scaleIn 0.2s ease-out'
                    },
                    keyframes: {
                        slideUp: {
                            '0%': {
                                transform: 'translateY(100%)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'translateY(0)',
                                opacity: '1'
                            }
                        },
                        fadeIn: {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            }
                        },
                        scaleIn: {
                            '0%': {
                                transform: 'scale(0.9)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'scale(1)',
                                opacity: '1'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen">
    <!-- Toast Notification -->
    <div id="toast-container" class="fixed top-6 right-6 z-50 space-y-2"></div>

    <div class="container mx-auto px-6 py-8 max-w-7xl">
        <!-- Header Section -->
        <div class="mb-8 animate-fade-in">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            <i class="fas fa-cube mr-3 text-indigo-500"></i>Products Management
                        </h1>
                        <p class="text-slate-600 mt-2 text-lg">Kelola produk Anda dengan mudah dan efisien</p>
                    </div>
                    <button id="btnAdd" class="group bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                        Tambah Produk
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden animate-scale-in">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-8 py-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-table mr-3"></i>
                    Daftar Produk
                </h2>
            </div>

            <div class="p-8">
                <div class="overflow-x-auto">
                    <table class="w-full" id="tblProducts">
                        <thead>
                            <tr class="border-b-2 border-slate-200">
                                <th class="text-left py-6 px-4 font-bold text-slate-700 text-sm uppercase tracking-wider w-16">#</th>
                                <th class="text-left py-6 px-4 font-bold text-slate-700 text-sm uppercase tracking-wider">Nama Produk</th>
                                <th class="text-left py-6 px-4 font-bold text-slate-700 text-sm uppercase tracking-wider w-32">Harga</th>
                                <th class="text-left py-6 px-4 font-bold text-slate-700 text-sm uppercase tracking-wider w-24">Stok</th>
                                <th class="text-center py-6 px-4 font-bold text-slate-700 text-sm uppercase tracking-wider w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div id="formModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-slate-900 bg-opacity-75 backdrop-blur-sm" id="modalBackdrop"></div>

            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold text-white" id="modalTitle">
                            <i class="fas fa-plus-circle mr-3"></i>
                            Tambah Produk
                        </h3>
                        <button type="button" id="closeModal" class="text-white hover:text-slate-200 transition-colors duration-200">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <div class="px-8 py-8">
                    <form id="productForm" class="space-y-6">
                        <input type="hidden" id="productId">

                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-tag mr-2 text-indigo-500"></i>
                                Nama Produk
                            </label>
                            <input type="text"
                                class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 outline-none"
                                name="name"
                                id="name"
                                placeholder="Masukkan nama produk"
                                required>
                            <div class="invalid-feedback text-red-500 text-sm mt-1 hidden" id="err_name"></div>
                        </div>

                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-money-bill-wave mr-2 text-green-500"></i>
                                Harga
                            </label>
                            <input type="number"
                                step="0.01"
                                class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 outline-none"
                                name="price"
                                id="price"
                                placeholder="0.00"
                                required>
                            <div class="invalid-feedback text-red-500 text-sm mt-1 hidden" id="err_price"></div>
                        </div>

                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-boxes mr-2 text-orange-500"></i>
                                Stok
                            </label>
                            <input type="number"
                                class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 outline-none"
                                name="stock"
                                id="stock"
                                placeholder="0"
                                required>
                            <div class="invalid-feedback text-red-500 text-sm mt-1 hidden" id="err_stock"></div>
                        </div>
                    </form>
                </div>

                <div class="bg-slate-50 px-8 py-6 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                    <button type="button"
                        id="btnCancel"
                        class="px-6 py-3 border-2 border-slate-300 text-slate-700 rounded-xl hover:bg-slate-100 transition-all duration-200 font-semibold">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </button>
                    <button type="button"
                        id="btnSave"
                        class="px-8 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-save mr-2"></i>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal functionality
        const formModal = document.getElementById('formModal');
        const modalBackdrop = document.getElementById('modalBackdrop');
        const closeModal = document.getElementById('closeModal');
        const btnCancel = document.getElementById('btnCancel');
        const btnAdd = document.getElementById('btnAdd');
        const btnSave = document.getElementById('btnSave');
        const productForm = document.getElementById('productForm');
        const modalTitle = document.getElementById('modalTitle');
        const tblBody = document.querySelector('#tblProducts tbody');

        function showModal() {
            formModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function hideModal() {
            formModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            clearValidation();
        }

        function clearValidation() {
            const errorElements = document.querySelectorAll('.invalid-feedback');
            const inputElements = document.querySelectorAll('input[type="text"], input[type="number"]');

            errorElements.forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });

            inputElements.forEach(el => {
                el.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-100');
                el.classList.add('border-slate-200', 'focus:border-indigo-500', 'focus:ring-indigo-100');
            });
        }

        closeModal.addEventListener('click', hideModal);
        btnCancel.addEventListener('click', hideModal);
        modalBackdrop.addEventListener('click', hideModal);

        function createToast(message, type = 'success') {
            const toastContainer = document.getElementById('toast-container');
            const toast = document.createElement('div');

            const icons = {
                success: 'fas fa-check-circle',
                error: 'fas fa-exclamation-triangle',
                warning: 'fas fa-exclamation-circle'
            };

            const colors = {
                success: 'from-green-500 to-emerald-600 border-green-200',
                error: 'from-red-500 to-rose-600 border-red-200',
                warning: 'from-yellow-500 to-orange-600 border-yellow-200'
            };

            toast.className = `bg-gradient-to-r ${colors[type]} text-white px-6 py-4 rounded-xl shadow-lg border backdrop-blur-sm flex items-center space-x-3 transform translate-x-full transition-all duration-300 animate-slide-up max-w-md`;

            toast.innerHTML = `
                <i class="${icons[type]} text-xl"></i>
                <span class="font-medium flex-1">${message}</span>
                <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white transition-colors duration-200">
                    <i class="fas fa-times"></i>
                </button>
            `;

            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);

            setTimeout(() => {
                if (toast.parentElement) {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => toast.remove(), 300);
                }
            }, 5000);
        }

        // Load products data
        function loadProducts() {
            fetch('/products/list')
                .then(res => res.json())
                .then(data => {
                    tblBody.innerHTML = '';
                    if (data.length === 0) {
                        tblBody.innerHTML = `
                            <tr>
                                <td colspan="5" class="text-center py-12 text-slate-500">
                                    <i class="fas fa-box-open text-6xl mb-4 text-slate-300"></i>
                                    <p class="text-lg font-medium">Belum ada produk</p>
                                    <p>Tambah produk pertama Anda sekarang</p>
                                </td>
                            </tr>
                        `;
                    } else {
                        data.forEach((item, i) => {
                            const row = document.createElement('tr');
                            row.className = 'hover:bg-slate-50 transition-colors duration-200';
                            row.innerHTML = `
                                <td class="py-4 px-4 text-slate-600 font-medium">${i + 1}</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-cube text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800">${item.name}</p>
                                            <p class="text-sm text-slate-500">ID: #${item.id}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-rupiah-sign mr-1"></i>
                                        ${parseFloat(item.price).toLocaleString('id-ID')}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${item.stock > 10 ? 'bg-blue-100 text-blue-800' : item.stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}">
                                        <i class="fas fa-boxes mr-1"></i>
                                        ${item.stock}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button onclick="editProduct(${item.id})" class="bg-gradient-to-r from-amber-400 to-orange-500 hover:from-amber-500 hover:to-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-105">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </button>
                                        <button onclick="deleteProduct(${item.id})" class="bg-gradient-to-r from-red-400 to-rose-500 hover:from-red-500 hover:to-rose-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-105">
                                            <i class="fas fa-trash mr-1"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            `;
                            tblBody.appendChild(row);
                        });
                    }
                })
                .catch(err => {
                    console.error('Error loading products:', err);
                    createToast('Gagal memuat data produk', 'error');
                });
        }

        // Add product
        btnAdd.addEventListener('click', () => {
            productForm.reset();
            document.getElementById('productId').value = '';
            modalTitle.innerHTML = '<i class="fas fa-plus-circle mr-3"></i>Tambah Produk';
            showModal();
        });

        // Save product
        btnSave.addEventListener('click', () => {
            clearValidation();

            const formData = new FormData(productForm);
            const id = document.getElementById('productId').value;
            const url = id ? '/products/update/' + id : '/products/store';

            // Add loading state
            btnSave.disabled = true;
            btnSave.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';

            fetch(url, {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        hideModal();
                        loadProducts();
                        createToast(res.message || 'Data berhasil disimpan', 'success');
                    } else {
                        createToast('Gagal menyimpan data', 'error');

                        // Show validation errors
                        if (res.errors) {
                            for (const key in res.errors) {
                                const errorElement = document.getElementById('err_' + key);
                                const inputElement = document.getElementById(key);

                                if (errorElement && inputElement) {
                                    errorElement.textContent = res.errors[key];
                                    errorElement.classList.remove('hidden');

                                    inputElement.classList.remove('border-slate-200', 'focus:border-indigo-500', 'focus:ring-indigo-100');
                                    inputElement.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-100');
                                }
                            }
                        }
                    }
                })
                .catch(err => {
                    console.error('Error saving product:', err);
                    createToast('Terjadi kesalahan server', 'error');
                })
                .finally(() => {
                    btnSave.disabled = false;
                    btnSave.innerHTML = '<i class="fas fa-save mr-2"></i>Simpan';
                });
        });

        // Edit product
        function editProduct(id) {
            fetch('/products/show/' + id)
                .then(res => res.json())
                .then(res => {
                    if (res.data) {
                        document.getElementById('productId').value = res.data.id;
                        document.getElementById('name').value = res.data.name;
                        document.getElementById('price').value = res.data.price;
                        document.getElementById('stock').value = res.data.stock;
                        modalTitle.innerHTML = '<i class="fas fa-edit mr-3"></i>Edit Produk';
                        showModal();
                    } else {
                        createToast(res.message || 'Data tidak ditemukan', 'error');
                    }
                })
                .catch(err => {
                    console.error('Error loading product:', err);
                    createToast('Gagal memuat data', 'error');
                });
        }

        // Delete product
        function deleteProduct(id) {
            // Custom confirmation modal would be better, but using native confirm for simplicity
            if (confirm('Yakin ingin menghapus produk ini?')) {
                const formData = new FormData();
                formData.append('id', id);

                fetch('/products/delete/' + id, {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            loadProducts();
                            createToast(res.message || 'Produk berhasil dihapus', 'success');
                        } else {
                            createToast(res.message || 'Gagal menghapus produk', 'error');
                        }
                    })
                    .catch(err => {
                        console.error('Error deleting product:', err);
                        createToast('Terjadi kesalahan server', 'error');
                    });
            }
        }

        // Initialize
        loadProducts();
    </script>
</body>

</html>