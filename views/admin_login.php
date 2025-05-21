<?php
session_start();
if(isset($_SESSION['admin_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

require_once '../controllers/AdminController.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adminController = new AdminController();
    
    if($adminController->login($_POST['username'], $_POST['password'])) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = 'Invalid username or password';
    }
}

$isAdmin = false;
include 'includes/header.php';
?>

<!-- Hero banner with login card inside -->
<div class="admin-hero-section position-relative text-center text-white" style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="admin-hero-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;  z-index: 1;"></div>

    <div class="container" style="position: relative; z-index: 2; max-width: 400px;">
        <div class="card shadow reservation-form-container">
            <div class="card-body p-4">
                <h2 class="text-center mb-4 section-title">Admin Login</h2>

                <?php if($error): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="admin_login.php" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="invalid-feedback">Please enter your password.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
