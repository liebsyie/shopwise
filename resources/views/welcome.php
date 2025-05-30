<?php
session_start();

// Redirect if authenticated
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ShopWise - Welcome</title>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .gradient-text {
      background: linear-gradient(to right, #6366f1, #8b5cf6);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .bg-gradient-primary {
      background: linear-gradient(to right, #6366f1, #8b5cf6);
    }
    .glass-card {
      background: rgba(255, 255, 255, 0.6);
      backdrop-filter: blur(10px);
      border-radius: 1rem;
    }
    .progress-bar {
      width: 100%;
      height: 8px;
      background-color: #e5e7eb;
      border-radius: 4px;
      overflow: hidden;
    }
    .progress-green {
      height: 100%;
      background-color: #10b981;
    }
  </style>
</head>
<body class="font-[Outfit,sans-serif] bg-gradient-to-br from-indigo-100 via-blue-50 to-violet-100">

<!-- Background Noise -->
<div class="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-200/60 via-slate-100/40 to-blue-100/50"></div>
<div class="fixed inset-0 -z-10 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.13]"></div>

<!-- Header -->
<header class="py-4 px-4 flex flex-row items-center justify-between">
  <div class="flex items-center gap-2">
    <div class="p-2 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-lg shadow-lg">
      <script>lucide.createIcons();</script>
      <i data-lucide="shopping-cart" class="text-white" style="width: 24px; height: 24px;"></i>
    </div>
    <span class="font-bold text-2xl gradient-text">ShopWise</span>
  </div>
  <div class="flex gap-2">
    <a href="login.php" class="py-2 px-4 rounded-lg text-indigo-600 font-medium hover:bg-white hover:shadow-sm transition duration-300 text-center">Login</a>
    <a href="register.php" class="py-2 px-5 bg-gradient-primary text-white rounded-lg font-medium hover:shadow-md transition duration-300 flex items-center gap-1 justify-center">
      <span>Get Started</span>
      <i data-lucide="chevron-right" style="width: 16px; height: 16px;"></i>
    </a>
  </div>
</header>

<!-- Hero -->
<main class="container mx-auto px-8 py-16 flex flex-col md:flex-row items-center justify-between">
  <div class="md:w-1/2 mb-10 md:mb-0">
    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/80 rounded-full mb-6 shadow-sm backdrop-blur-sm">
      <div class="p-1 bg-gradient-to-r from-indigo-600 to-violet-600 rounded-full">
        <i data-lucide="sparkles" class="text-white" style="width: 14px; height: 14px;"></i>
      </div>
      <span class="text-sm font-medium text-indigo-800">Smart Budget Tracking</span>
    </div>
    <h1 class="text-4xl md:text-6xl font-bold mb-6">Smart Grocery Shopping <span class="gradient-text">Starts Here</span></h1>
    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
      Take control of your grocery budget with ShopWise. Create categorized lists, track spending in real-time, and never go over budget again.
    </p>
    <a href="register.php" class="group py-3 px-8 bg-gradient-primary text-white rounded-lg font-medium hover:shadow-lg transition duration-300 text-lg inline-flex items-center gap-2">
      Get Started
      <i data-lucide="arrow-right" class="group-hover:translate-x-1 transition-transform" style="width: 18px; height: 18px;"></i>
    </a>
  </div>
  <div class="md:w-1/2 glass-card p-8 md:ml-10 shadow-xl">
    <div class="glass-card p-6 mb-6 border border-white/50">
      <h3 class="font-semibold mb-4 text-gray-800">Weekly Groceries</h3>
      <div class="flex justify-between mb-3">
        <span class="text-gray-600">Budget</span>
        <span class="font-medium">₱120.00</span>
      </div>
      <div class="progress-bar"><div class="progress-green w-3/4"></div></div>
      <div class="flex justify-between mt-2">
        <span class="text-sm text-gray-500">Spent: ₱90.45</span>
        <span class="text-sm text-green-600 font-medium">Remaining: ₱29.55</span>
      </div>
    </div>
    <!-- Feature cards omitted for brevity -->
  </div>
</main>

<!-- CTA -->
<section class="py-16 px-8 bg-gradient-primary text-white">
  <div class="container mx-auto max-w-4xl text-center">
    <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to transform your shopping experience?</h2>
    <p class="text-indigo-100 text-lg mb-8 max-w-2xl mx-auto">
      Join thousands of smart shoppers who save money and time with ShopWise's powerful budget tracking tools.
    </p>
    <a href="register.php" class="inline-flex items-center gap-2 py-3 px-8 bg-white text-indigo-600 rounded-lg font-medium hover:shadow-xl transition duration-300 text-lg">
      Get Started For Free
      <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
    </a>
  </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-8 px-8 mt-auto w-full">
  <div class="container mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-center">
      <div class="flex items-center gap-2 mb-4 md:mb-0">
        <div class="p-1.5 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-lg">
          <i data-lucide="shopping-cart" class="text-white" style="width: 20px; height: 20px;"></i>
        </div>
        <span class="font-bold text-xl">ShopWise</span>
      </div>
      <div class="text-gray-400 text-sm">
        © <?= date('Y') ?> ShopWise. All rights reserved.
      </div>
    </div>
  </div>
</footer>

<script>
  lucide.createIcons();
</script>
</body>
</html>