<?php include '../public/assets/header.php'; ?>
    <div class="container mt-5">
        <div class="card card-form">
            <div class="card-body p-4">
                <h2 class="card-title text-center mb-4">Sign In</h2>
                <form action='login' method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control form-control-lg" name="username"  required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control form-control-lg" name="password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary btn-lg w-100 mt-3">Sign In</button>
                </form>
            </div>
        </div>
        <?php if(isset($data['error'])): ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?php echo $data['error']; ?>
            </div>
        <?php endif; ?>
    </div>
<?php include '../public/assets/footer.php'; 
?>