<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kirim Pesan WhatsApp - Fonnte</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">
                    📱 Kirim Pesan WhatsApp
                </h1>

                <!-- Alert Success -->
                <div id="alert-success" class="hidden mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    <p id="success-message"></p>
                </div>

                <!-- Alert Error -->
                <div id="alert-error" class="hidden mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <p id="error-message"></p>
                </div>

                <!-- Form -->
                <form id="whatsapp-form">
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 font-medium mb-2">
                            Nomor WhatsApp
                        </label>
                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="Contoh: 081234567890 atau 6281234567890"
                            required
                        >
                        <p class="text-sm text-gray-500 mt-1">
                            Format: 08xxx atau 628xxx
                        </p>
                    </div>

                    <div class="mb-6">
                        <label for="message" class="block text-gray-700 font-medium mb-2">
                            Pesan
                        </label>
                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="Ketik pesan Anda di sini..."
                            required
                        ></textarea>
                    </div>

                    <button
                        type="submit"
                        id="submit-btn"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center"
                    >
                        <span id="btn-text">Kirim Pesan</span>
                        <span id="btn-loading" class="hidden">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </form>

                <!-- Info -->
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h3 class="font-medium text-blue-900 mb-2">ℹ️ Informasi</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Pastikan device WhatsApp Anda sudah terhubung di Fonnte</li>
                        <li>• Nomor tujuan harus terdaftar di WhatsApp</li>
                        <li>• Format nomor akan otomatis disesuaikan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Setup CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Form Submit Handler
        document.getElementById('whatsapp-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            // UI Elements
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const btnLoading = document.getElementById('btn-loading');
            const alertSuccess = document.getElementById('alert-success');
            const alertError = document.getElementById('alert-error');
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');

            // Hide alerts
            alertSuccess.classList.add('hidden');
            alertError.classList.add('hidden');

            // Show loading
            submitBtn.disabled = true;
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');

            // Get form data
            const phone = document.getElementById('phone').value;
            const message = document.getElementById('message').value;

            try {
                const response = await fetch('{{ route("whatsapp.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        phone: phone,
                        message: message
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Show success
                    successMessage.textContent = data.message;
                    alertSuccess.classList.remove('hidden');

                    // Reset form
                    document.getElementById('whatsapp-form').reset();

                    // Scroll to top
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } else {
                    // Show error
                    errorMessage.textContent = data.message || 'Terjadi kesalahan saat mengirim pesan';
                    alertError.classList.remove('hidden');
                }
            } catch (error) {
                errorMessage.textContent = 'Terjadi kesalahan: ' + error.message;
                alertError.classList.remove('hidden');
            } finally {
                // Hide loading
                submitBtn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
