<?php
session_start();

$referer = $_SERVER['HTTP_REFERER'] ?? '/dashboard';

$name = $email = $message = '';
$status = 'idle'; // idle, success, error
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$email || !$message) {
        $status = 'error';
        $error = 'Please provide your email and message.';
    } else {
        // Here you would normally send email or save the message
        // For demo, just mark success:
        $status = 'success';
        $name = $email = $message = '';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Contact Us - ShopWise</title>
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
        <h1 class="text-lg sm:text-2xl font-bold text-indigo-700 text-center w-full">Contact Us</h1>
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
        
        <div class="mb-6 space-y-2">
          <div class="flex items-center gap-2 text-gray-700">
            <i data-lucide="mail" class="w-4.5 h-4.5"></i>
            <span>support@shopwise.com</span>
          </div>
          <div class="text-gray-500 text-sm">We typically respond within 1-2 business days.</div>
        </div>

        <form method="POST" class="space-y-4" novalidate>
          <div>
            <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
            <div class="flex items-center bg-white rounded-lg border border-gray-200 px-3">
              <i data-lucide="user" class="w-4 h-4 text-gray-400 mr-2"></i>
              <input
                type="text"
                id="name"
                name="name"
                class="w-full py-2 outline-none bg-transparent"
                placeholder="Your name (optional)"
                value="<?= htmlspecialchars($name) ?>"
                autocomplete="name"
              />
            </div>
          </div>

          <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">
              Email<span class="text-red-500">*</span>
            </label>
            <div class="flex items-center bg-white rounded-lg border border-gray-200 px-3">
              <i data-lucide="mail" class="w-4 h-4 text-gray-400 mr-2"></i>
              <input
                type="email"
                id="email"
                name="email"
                class="w-full py-2 outline-none bg-transparent"
                placeholder="you@example.com"
                value="<?= htmlspecialchars($email) ?>"
                autocomplete="email"
                required
              />
            </div>
          </div>

          <div>
            <label for="message" class="block text-gray-700 font-medium mb-1">
              Message<span class="text-red-500">*</span>
            </label>
            <div class="flex items-start bg-white rounded-lg border border-gray-200 px-3">
              <i data-lucide="message-circle" class="w-4 h-4 text-gray-400 mr-2 mt-2"></i>
              <textarea
                id="message"
                name="message"
                class="w-full py-2 outline-none bg-transparent resize-none min-h-[80px]"
                placeholder="How can we help you?"
                required
              ><?= htmlspecialchars($message) ?></textarea>
            </div>
          </div>

          <?php if ($error): ?>
            <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
          <?php elseif ($status === 'success'): ?>
            <div class="text-green-600 text-sm">Thank you! Your message has been sent.</div>
          <?php endif; ?>

          <button
            type="submit"
            class="w-full bg-gradient-to-r from-indigo-500 via-violet-500 to-blue-500 text-white py-2 rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200 font-semibold border-2 border-transparent hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
            <?= $status === 'success' ? 'disabled' : '' ?>
          >
            Send Message
          </button>
        </form>

        <div class="mt-8 text-xs text-gray-400 text-center">
          Your information is used only to respond to your inquiry and is not shared.
        </div>
      </div>
    </div>
  </div>
</body>
</html>