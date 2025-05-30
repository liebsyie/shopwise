<?php
session_start();

// Check for a previous page (simulate React Router background state)
$referer = $_SERVER['HTTP_REFERER'] ?? '/dashboard';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About ShopWise</title>
  <script>
    // Close modal and navigate back
    function handleClose() {
      window.history.length > 1 ? window.history.back() : window.location.href = "<?= $referer ?>";
    }

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') handleClose();
    });
  </script>
  <script src="https://unpkg.com/lucide@latest"></script> <!-- Lucide icons -->
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
          <i data-lucide="info" class="w-5 h-5"></i> About ShopWise
        </h1>
        <button
          onclick="handleClose()"
          class="absolute right-4 top-3 text-gray-500 hover:text-indigo-600 text-2xl font-bold rounded-full p-2 transition bg-white/80"
          aria-label="Close"
        >
          <i data-lucide="x" class="w-7 h-7"></i>
        </button>
      </div>

      <!-- Content -->
      <div class="overflow-y-auto px-4 py-4 sm:px-8 sm:py-8 flex-1" style="-webkit-overflow-scrolling: touch;">
        <div class="space-y-6 text-gray-700 text-base">
          <p><strong>ShopWise</strong> is your smart companion for grocery shopping and budget management. Our mission is to help you save money, stay organized, and make shopping stress-free.</p>
          <ul class="list-disc ml-6">
            <li>Create and manage categorized shopping lists</li>
            <li>Track your spending and set budgets</li>
            <li>Access your lists from any device (data stays in your browser)</li>
            <li>Enjoy a beautiful, modern, and privacy-friendly experience</li>
          </ul>
          <p>ShopWise is built with privacy in mind—your data stays on your device. We welcome your feedback and suggestions to make ShopWise even better!</p>
        </div>
      </div>

    </div>
  </div>
</body>
</html>