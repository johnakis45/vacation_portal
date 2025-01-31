<?php include '../public/assets/header.php'; ?>
<div class="container mt-5">
        <div class="card card-form">
            <div class="card-body p-4">
                <h2 class="card-title text-center mb-4">Create User</h2>
                <form action="saveUser" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control form-control-lg" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-lg" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Employee Code (7 digits)</label>
                        <input 
                            type="text" 
                            class="form-control form-control-lg" 
                            name="unique_code" 
                            pattern="\d{7}" 
                            title="Employee code must be exactly 7 digits" 
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control form-control-lg" name="password" required>
                    </div>
                    <button type="Create" class="btn btn-primary btn-lg w-100 mt-3">Create User</button>
                </form>
                <?php if (isset($data['error'])): ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <?= $data['error'] ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($data['success'])): ?>
                    <div class="alert alert-success mt-3" role="alert">
                        <?= $data['success'] ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php include '../public/assets/footer.php'; ?>