<?php
$referer = $_SERVER['HTTP_REFERER'] ?? '/dashboard';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Feedback - ShopWise</title>
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

    function handleSubmit(event) {
      event.preventDefault();
      const textarea = document.getElementById('feedback');
      const errorDiv = document.getElementById('error-msg');
      const successDiv = document.getElementById('success-msg');
      const submitBtn = document.getElementById('submit-btn');

      errorDiv.textContent = '';
      successDiv.textContent = '';

      if (!textarea.value.trim()) {
        errorDiv.textContent = 'Please enter your feedback.';
        return;
      }

      successDiv.textContent = 'Thank you for your feedback!';
      submitBtn.disabled = true;
      textarea.value = '';

      setTimeout(() => {
        successDiv.textContent = '';
        submitBtn.disabled = false;
      }, 2500);
    }
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
    <div class="bg-white/90 rounded-2xl shadow-2xl w-full max-w-xl mx-2 sm:mx-4 p-0 relative border border-white/40 ring-1 ring-indigo-100 animate-fade-in-up flex flex-col max-h-[90vh]">

      <!-- Header -->
      <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 sticky top-0 bg-white/95 rounded-t-2xl z-10">
        <h1 class="text-lg sm:text-2xl font-bold text-indigo-700 text-center w-full flex items-center justify-center gap-2">
          <i data-lucide="message-square" class="w-5 h-5"></i>
          Feedback
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

      <!-- Form -->
      <div class="overflow-y-auto px-4 py-4 sm:px-8 sm:py-8 flex-1" style="-webkit-overflow-scrolling: touch;">
        <form class="space-y-4" onsubmit="handleSubmit(event)">
          <label for="feedback" class="block text-gray-700 font-medium mb-1">Your Feedback</label>
          <textarea
            id="feedback"
            name="feedback"
            class="w-full py-2 px-3 rounded-lg border border-gray-200 outline-none bg-white resize-none min-h-[80px]"
            placeholder="Let us know what you love, what could be better, or any ideas you have!"
            required
          ></textarea>

          <div id="error-msg" class="text-red-600 text-sm"></div>
          <div id="success-msg" class="text-green-600 text-sm"></div>

          <button
            id="submit-btn"
            type="submit"
            class="w-full bg-gradient-to-r from-indigo-500 via-violet-500 to-blue-500 text-white py-2 rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200 font-semibold border-2 border-transparent hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
          >
            Submit
          </button>
        </form>

        <div class="mt-8 text-xs text-gray-400 text-center">
          Your feedback is anonymous and helps us improve ShopWise.
        </div>
      </div>

    </div>
  </div>
</body>
</html>