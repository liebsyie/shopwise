<?php
// Usage: include 'Modal.php'; showModal(true, 'Modal Title', '<p>Modal content here.</p>');
function showModal($isOpen, $title = '', $content = '', $closeUrl = '#') {
  if (!$isOpen) return;
?>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm animate-fade-in">
    <div class="bg-white/90 rounded-2xl shadow-2xl max-w-2xl w-full p-8 relative border border-white/40 ring-1 ring-indigo-100 animate-fade-in-up">
      <a href="<?= htmlspecialchars($closeUrl) ?>" class="absolute top-4 right-4 text-gray-500 hover:text-indigo-600 text-xl font-bold rounded-full p-2 transition" aria-label="Close">
        ×
      </a>
      <?php if (!empty($title)): ?>
        <h2 class="text-2xl font-bold text-indigo-700 mb-4 text-center"><?= htmlspecialchars($title) ?></h2>
      <?php endif; ?>
      <div><?= $content ?></div>
    </div>
  </div>
<?php
}
?>