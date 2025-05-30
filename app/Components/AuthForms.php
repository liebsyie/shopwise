<?php
session_start();
include 'db.php'; // Your DB connection
$errors = [];
$success = '';
$showLogin = true; // Toggle form

// Handle Login
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (!$errors) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['name'];
            $success = "Login successful.";
        } else {
            $errors[] = "Invalid email or password.";
        }
    }
}

// Handle Registration
if (isset($_POST['register'])) {
    $showLogin = false;

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirmPassword'];

    if (empty($name)) $errors[] = "Name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email.";
    if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters.";
    if ($password !== $confirm) $errors[] = "Passwords do not match.";

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $errors[] = "Email is already registered.";
    }

    if (!$errors) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $hashed])) {
            $success = "Account created successfully. You can now login.";
            $showLogin = true;
        } else {
            $errors[] = "Registration failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Auth Forms</title>
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
    <script>
        function toggleForm() {
            document.getElementById("loginForm").classList.toggle("hidden");
            document.getElementById("registerForm").classList.toggle("hidden");
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            <?= $showLogin ? "Welcome Back" : "Create Your Account" ?>
        </h2>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-4">
                <?= implode('<br>', $errors) ?>
            </div>
        <?php elseif ($success): ?>
            <div class="bg-green-50 text-green-600 p-3 rounded-lg mb-4">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form id="loginForm" method="POST" class="<?= $showLogin ? '' : 'hidden' ?>">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-1">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="loginPassword" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    <button type="button" onclick="togglePassword('loginPassword')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">👁</button>
                </div>
            </div>
            <button name="login" type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg">Sign In</button>
            <p class="mt-4 text-center text-sm text-gray-500">
                Don't have an account? <a href="#" onclick="toggleForm()" class="text-blue-600 underline">Register</a>
            </p>
        </form>

        <!-- Register Form -->
        <form id="registerForm" method="POST" class="<?= $showLogin ? 'hidden' : '' ?>">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Name</label>
                <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="regPassword" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    <button type="button" onclick="togglePassword('regPassword')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">👁</button>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-1">Confirm Password</label>
                <input type="password" name="confirmPassword" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <button name="register" type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg">Create Account</button>
            <p class="mt-4 text-center text-sm text-gray-500">
                Already have an account? <a href="#" onclick="toggleForm()" class="text-blue-600 underline">Login</a>
            </p>
        </form>
    </div>
</body>
</html>