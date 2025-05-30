<?php
$referer = $_SERVER['HTTP_REFERER'] ?? '/dashboard';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Terms of Service - ShopWise</title>
  <script>
    function handleClose() {
      if (window.history.length > 1) {
        window.history.back();
      } else {
        window.location.href = "<?= htmlspecialchars($referer) ?>";
      }
    }

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') handleClose();
    });
  </script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      lucide.createIcons();
    });
  </script>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="overflow-hidden">
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm animate-fade-in">
    <div class="bg-white/90 rounded-2xl shadow-2xl w-full max-w-2xl mx-2 sm:mx-4 p-0 relative border border-white/40 ring-1 ring-indigo-100 animate-fade-in-up flex flex-col max-h-[90vh]">

      <!-- Header -->
      <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 sticky top-0 bg-white/95 rounded-t-2xl z-10">
        <h1 class="text-lg sm:text-2xl font-bold text-indigo-700 text-center w-full">Terms of Service</h1>
        <button
          onclick="handleClose()"
          class="absolute right-4 top-3 text-gray-500 hover:text-indigo-600 text-2xl font-bold rounded-full p-2 transition bg-white/80"
          aria-label="Close"
          style="line-height: 1;"
        >
          <i data-lucide="x" class="w-7 h-7"></i>
        </button>
      </div>

      <!-- Content -->
      <div class="overflow-y-auto px-4 py-4 sm:px-8 sm:py-8 flex-1" style="-webkit-overflow-scrolling: touch;">
        <div class="space-y-6 text-gray-700 text-base">
          <section>
            <h2 class="font-semibold text-lg mb-2">1. Acceptance of Terms</h2>
            <ul class="list-disc ml-6">
              <li>By using ShopWise, you agree to these Terms of Service and our Privacy Policy.</li>
              <li>If you do not agree, please do not use the app.</li>
            </ul>
          </section>
          <section>
            <h2 class="font-semibold text-lg mb-2">2. User Responsibilities</h2>
            <ul class="list-disc ml-6">
              <li>You are responsible for maintaining the confidentiality of your account information.</li>
              <li>You agree not to misuse the app or attempt to access accounts or data that are not yours.</li>
            </ul>
          </section>
          <section>
            <h2 class="font-semibold text-lg mb-2">3. Data & Content</h2>
            <ul class="list-disc ml-6">
              <li>All data you enter is stored locally in your browser and is not shared with third parties.</li>
              <li>You retain ownership of your data, but ShopWise is not responsible for data loss due to browser issues or device loss.</li>
            </ul>
          </section>
          <section>
            <h2 class="font-semibold text-lg mb-2">4. Modifications & Updates</h2>
            <ul class="list-disc ml-6">
              <li>We may update these Terms at any time. Changes will be posted in the app.</li>
              <li>Continued use of ShopWise after changes means you accept the new Terms.</li>
            </ul>
          </section>
          <section>
            <h2 class="font-semibold text-lg mb-2">5. Disclaimer & Limitation of Liability</h2>
            <ul class="list-disc ml-6">
              <li>ShopWise is provided "as is" without warranties of any kind.</li>
              <li>We are not liable for any damages or losses resulting from your use of the app.</li>
            </ul>
          </section>
          <section>
            <h2 class="font-semibold text-lg mb-2">6. Contact</h2>
            <ul class="list-disc ml-6">
              <li>For questions about these Terms, contact <a href="mailto:support@shopwise.com" class="text-indigo-600 underline">support@shopwise.com</a>.</li>
            </ul>
          </section>
        </div>
      </div>
    </div>
  </div>
</body>
</html>