<?php include '../public/assets/header.php'; ?>
<div class="container mt-5">
    <h2 class="text-center">My Vacation Requests Dashboard</h2>

    <!-- Request Vacation Button -->
    <div class="mb-3">
        <a  href="<?= BASE_URL ?>EmployeeController/showRequestVacationForm"  class="btn btn-dark">Request Vacation</a>
    </div>

    <!-- Vacation Requests Table -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Date submitted</th>
                <th>Dates requested</th>
                <th>Total Days</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
                
            </tr>
        </thead>
        <tbody>
        <?php
            if (!empty($data['requests'])) {
                foreach ($data['requests'] as $row) {
                    $submitDates = isset($row['submit_date']) ? (new DateTime($row['submit_date']))->format('Y-m-d') : 'N/A';
                    $startDate = isset($row['start_date']) ? $row['start_date'] : 'N/A';
                    $endDate = isset($row['end_date']) ? $row['end_date'] : 'N/A';
                    $reason = isset($row['description']) ? $row['description'] : 'N/A';
                    $status = isset($row['status']) ? $row['status'] : 'N/A';

                    
                    $id = isset($row['id']) ? $row['id'] : '';

                    // Construct the requested date range
                    $requestedDates = ($startDate !== 'N/A' && $endDate !== 'N/A') ? "$startDate to $endDate" : 'N/A';

                    // Calculate total days if start_date and end_date exist
                    $totalDays = 'N/A';
                    if ($startDate !== 'N/A' && $endDate !== 'N/A') {
                        $startDateObj = new DateTime($startDate);
                        $endDateObj = new DateTime($endDate);
                        $totalDays = $startDateObj->diff($endDateObj)->days + 1;
                    }

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($submitDates) . "</td>";
                    echo "<td>" . htmlspecialchars($requestedDates) . "</td>";
                    echo "<td>" . htmlspecialchars($totalDays) . "</td>";
                    echo "<td>" . htmlspecialchars($reason) . "</td>";
                    echo "<td>";
                    if ($status == 'approved') {
                        echo '<span class="badge bg-success">Approved</span>';
                    } elseif ($status == 'pending') {
                        echo '<span class="badge bg-warning text-dark">Pending</span>';
                    } else {
                        echo '<span class="badge bg-danger">Rejected</span>';
                    }
                    echo "</td>";
                    echo "<td>";

                    if (strtolower($status) === 'pending') {
                        echo "<a href=\"" . BASE_URL . "EmployeeController/deleteRequest/" . htmlspecialchars($id) . "\" class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this request?\")'>Delete</a>";
                    }

                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr>
                        <td colspan='6' class='text-center'>No vacation requests found.</td>
                    </tr>";
            }
            ?>


        </tbody>
    </table>
</div>
<?php include '../public/assets/footer.php'; ?>