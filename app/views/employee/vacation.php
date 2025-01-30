<?php include '../public/assets/header.php'; ?>
<div class="container mt-5">
        <div class="card card-form">
            <div class="card-body p-4">
                <h2 class="card-title text-center mb-4">Vacation Request</h2>
                <form action="saveVacation" method="POST">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Date From</label>
                        <input type="date" class="form-control form-control-lg" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Date To</label>
                        <input type="date" class="form-control form-control-lg" name="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea class="form-control form-control-lg" name="reason" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">Save</button>
                </form>
            </div>

            <?php if(isset($data['message'])): ?>
                <div class="alert alert-success mt-3" role="alert">
                    <?php echo $data['message']; ?>
                </div>
            <?php endif; ?>

            <?php if(isset($data['error'])): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?php echo $data['error']; ?>
                </div>
            <?php endif; ?>
        </div>
</div>
<?php include '../public/assets/footer.php'; ?>