<?php include '../public/assets/header.php'; ?>
<div class="container mt-5">
    <h2 class="text-center">Vacation Requests Dashboard</h2>

    <!-- Vacation Requests Table -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Date Submitted</th>
                <th>Dates Requested</th>
                <th>Reason</th>
                <th>Total Days</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($data['requests'])): ?>
    <?php foreach ($data['requests'] as $request): ?>
        <tr>
            <td><?= htmlspecialchars($request['employee_name']) ?></td> <!-- Replace with actual user name if available -->
            <td><?= htmlspecialchars(date('Y-m-d', strtotime($request['submit_date']))) ?></td>
            <td><?= htmlspecialchars(date('Y/m/d', strtotime($request['start_date']))) ?> - <?= htmlspecialchars(date('Y/m/d', strtotime($request['end_date']))) ?></td>
            <td><?= htmlspecialchars($request['description']) ?></td>
            <td><?= (new DateTime($request['start_date']))->diff(new DateTime($request['end_date']))->days + 1 ?></td>
            <td>
                <?php if ($request['status'] == 'approved'): ?>
                    <span class="badge bg-success">Approved</span>
                <?php elseif ($request['status'] == 'pending'): ?>
                    <span class="badge bg-warning text-dark">Pending</span>
                <?php else: ?>
                    <span class="badge bg-danger">Rejected</span>
                <?php endif; ?>
            </td>
            <td>
            <a href="<?= BASE_URL ?>ManagerController/approveRequest/<?= $request['id'] ?>" class="text-success">Approve</a> | 
            <a href="<?= BASE_URL ?>ManagerController/rejectRequest/<?= $request['id'] ?>" class="text-danger">Reject</a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="7" class="text-center">No requests found.</td>
    </tr>
<?php endif; ?>
</tbody>
    </table>
</div>
<?php include '../public/assets/footer.php'; ?>