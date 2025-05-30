<?php
session_start();
$isLoggedIn = isset($_SESSION['user']);
$currentUser = $isLoggedIn ? $_SESSION['user'] : null;

$currentPage = basename($_SERVER['PHP_SELF']);
function isActive($path) {
    global $currentPage;
    return $currentPage === $path ? 'text-indigo-700 bg-indigo-50' : 'text-gray-700 hover:text-indigo-600 hover:bg-indigo-50/80';
}
?>

<nav class="sticky top-0 z-50 transition-all duration-300 bg-white/70 backdrop-blur-sm border-b border-gray-200/70">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
      <div class="flex items-center">
        <a href="index.php" class="flex items-center gap-2">
          <div class="p-2 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-lg shadow-md">
            <svg class="text-white w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path d="M3 3h18v18H3V3z" stroke-width="2"/>
            </svg>
          </div>
          <span class="font-bold text-xl" style="font-family: 'Outfit', sans-serif">ShopWise</span>
        </a>
      </div>

      <!-- Desktop navigation -->
      <div class="hidden md:flex items-center space-x-4">
        <?php if ($isLoggedIn): ?>
          <a href="dashboard.php" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium <?= isActive('dashboard.php') ?>">
            🏠 Dashboard
          </a>
          <a href="new-list.php" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium <?= isActive('new-list.php') ?>">
            ➕ New List
          </a>
          <a href="logout.php" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200">
            🔓 Logout
          </a>
          <a href="profile.php" class="flex items-center bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full hover:bg-indigo-100 transition ml-4">
            👤 <span class="text-sm font-medium ml-1"><?= htmlspecialchars($currentUser['name'] ?? 'User') ?></span>
          </a>
        <?php else: ?>
          <a href="login.php" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200">Login</a>
          <a href="register.php" class="px-3 py-2 rounded-md text-sm font-medium bg-gradient-to-r from-indigo-600 to-violet-600 text-white hover:shadow-md transition duration-200">Sign Up</a>
        <?php endif; ?>
      </div>

      <!-- Mobile menu toggle -->
      <div class="flex items-center md:hidden">
        <button id="toggleMenu" class="p-2 rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none">
          ☰
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile menu -->
  <div id="mobileMenu" class="hidden md:hidden px-4 pt-2 pb-4 space-y-1">
    <?php if ($isLoggedIn): ?>
      <div class="px-3 py-3 border-b border-gray-200 mb-2">
        <p class="text-sm font-medium text-gray-700">Signed in as</p>
        <p class="text-sm text-gray-600"><?= htmlspecialchars($currentUser['email']) ?></p>
      </div>
      <a href="dashboard.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">🏠 Dashboard</a>
      <a href="new-list.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">➕ New List</a>
      <a href="profile.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">👤 My Profile</a>
      <a href="logout.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">🔓 Logout</a>
    <?php else: ?>
      <a href="login.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">Login</a>
      <a href="register.php" class="block px-3 py-2 rounded-md text-base font-medium bg-blue-600 text-white hover:bg-blue-700">Sign Up</a>
    <?php endif; ?>
  </div>
</nav>

<script>
  document.getElementById('toggleMenu').addEventListener('click', function () {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
  });
</script>