<?php include '../public/assets/header.php'; ?>
<div class="container mt-5">
    <h2 class="text-center">List of Users</h2>

    <!-- Create User Button -->
    <div class="mb-3">
        <a href="create_user.php" class="btn btn-dark">Create User</a>
    </div>

    <!-- Users Table -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if (!empty($data['users'])) {
                // Loop through each user in the $data array and create a table row
                foreach ($data['users'] as $row) {
                    // Check if 'username', 'email', and 'id' exist before using them
                    $name = isset($row['username']) ? $row['username'] : 'N/A'; // Default to 'N/A' if missing
                    $email = isset($row['email']) ? $row['email'] : 'N/A'; // Default to 'N/A' if missing
                    $id = isset($row['id']) ? $row['id'] : ''; // Default to empty string if missing
                
                    // Render the table row
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($name) . "</td>";
                    echo "<td>" . htmlspecialchars($email) . "</td>";
                    echo "<td>
                            <a href='edit_user/" . $id . "' class='btn btn-primary btn-sm'>Edit</a>
                            <a href='delete_user/" . $id . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                        </td>";
                    echo "</tr>";
                }
                
            } else {
                // Message for no users found
                echo "<tr>
                        <td colspan='3' class='text-center'>No users found.</td>
                    </tr>";
            }
            ?>

        </tbody>
    </table>
</div>
<?php include '../public/assets/footer.php'; ?>