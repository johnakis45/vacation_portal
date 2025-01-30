<?php include '../public/assets/header.php'; ?>
 <div class="container mt-5">
        <div class="card card-form">
            <div class="card-body p-4">
                <h2 class="card-title text-center mb-4">User Properties</h2>
                <form action="/public/ManagerController/update_user/<?= $data['user'][0]['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control form-control-lg" name="username" 
                        placeholder="<?php echo htmlspecialchars($data['user'][0]['username'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-lg" name="email" 
                        placeholder="<?php echo htmlspecialchars($data['user'][0]['email'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control form-control-lg" name="password" 
                        placeholder="<?php echo htmlspecialchars($data['user'][0]['password'] ?? ''); ?>">
                    </div>
                    <button type="Save" class="btn btn-primary btn-lg w-100 mt-3">Update</button>
                </form>
            </div>
        </div>
    </div>
<?php include '../public/assets/footer.php'; ?>