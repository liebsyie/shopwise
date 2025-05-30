<footer class="bg-gray-900 text-white py-4 mt-auto w-full border-t border-gray-800">
  <div class="container mx-auto px-4">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
      
      <!-- Logo + Copyright -->
      <div class="flex items-center gap-2 order-1 sm:order-none">
        <div class="p-1 bg-gradient-to-br from-indigo-600 to-violet-600 rounded">
          <!-- Shopping cart icon SVG -->
          <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M6 6h15l-1.5 9h-13L6 6z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="9" cy="20" r="1" />
            <circle cx="18" cy="20" r="1" />
          </svg>
        </div>
        <span class="text-sm text-gray-400">© <?= date('Y') ?> ShopWise</span>
      </div>

      <!-- Navigation Links -->
      <nav class="flex flex-wrap justify-center gap-x-4 gap-y-1 text-xs order-2 sm:order-none">
        <a href="about.php" class="text-gray-400 hover:text-white transition">About</a>
        <a href="faq.php" class="text-gray-400 hover:text-white transition">Help</a>
        <a href="feedback.php" class="text-gray-400 hover:text-white transition">Feedback</a>
        <a href="privacy.php" class="text-gray-400 hover:text-white transition">Privacy</a>
        <a href="terms.php" class="text-gray-400 hover:text-white transition">Terms</a>
        <a href="contact.php" class="text-gray-400 hover:text-white transition">Contact</a>
      </nav>

    </div>
  </div>
</footer>
