<?php
$referer = $_SERVER['HTTP_REFERER'] ?? '/dashboard';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>FAQ / Help - ShopWise</title>
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
        <h1 class="text-lg sm:text-2xl font-bold text-indigo-700 text-center w-full flex items-center justify-center gap-2">
          <i data-lucide="help-circle" class="w-5 h-5"></i>
          FAQ / Help
        </h1>
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
          <div>
            <h2 class="font-semibold text-lg mb-2">How do I create a new shopping list?</h2>
            <p>Go to your Dashboard and click the "New List" button. Fill in the details and save.</p>
          </div>
          <div>
            <h2 class="font-semibold text-lg mb-2">Is my data private?</h2>
            <p>Yes! All your data is stored locally in your browser and is never shared with third parties.</p>
          </div>
          <div>
            <h2 class="font-semibold text-lg mb-2">Can I use ShopWise on multiple devices?</h2>
            <p>Your data is saved in your browser. If you use a different device or browser, your lists will not sync automatically.</p>
          </div>
          <div>
            <h2 class="font-semibold text-lg mb-2">How do I reset my password?</h2>
            <p>Click "Forgot Password" on the login page and follow the instructions to reset your password.</p>
          </div>
          <div>
            <h2 class="font-semibold text-lg mb-2">How can I contact support?</h2>
            <p>Email us at <a href="mailto:support@shopwise.com" class="text-indigo-600 underline">support@shopwise.com</a> or use the Contact form in the footer.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</body>
</html>