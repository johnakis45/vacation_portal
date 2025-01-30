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
            <!-- Example Rows (This should be populated dynamically with PHP/Database) -->
            <tr>
                <td>John Doe</td>
                <td>2023-01-21</td>
                <td>2023/02/04 - 2023/02/07</td>
                <td>Holidays</td>
                <td>3</td>
                <td><span class="badge bg-success">Approved</span></td>
                <td>
                    <a href="#" class="text-success">Approve</a> | 
                    <a href="#" class="text-danger">Reject</a>
                </td>
            </tr>
            <tr>
                <td>Jane Doe</td>
                <td>2023-05-28</td>
                <td>2023/07/01 - 2023/07/10</td>
                <td>Summer Vacation</td>
                <td>10</td>
                <td><span class="badge bg-warning text-dark">Pending</span></td>
                <td>
                    <a href="#" class="text-success">Approve</a> | 
                    <a href="#" class="text-danger">Reject</a>
                </td>
            </tr>

        </tbody>
    </table>
</div>
<?php include '../public/assets/footer.php'; ?>