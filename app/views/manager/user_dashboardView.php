<?php include '../public/assets/header.php'; ?>
<div class="container mt-5">
    <h2 class="text-center">List of Users</h2>

    <!-- Create User Button -->
    <div class="mb-3">
        <a href="showUserCreationForm" class="btn btn-dark">Create User</a>
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
                foreach ($data['users'] as $row) {
                    $name = isset($row['username']) ? $row['username'] : 'N/A';
                    $email = isset($row['email']) ? $row['email'] : 'N/A';
                    $id = isset($row['id']) ? $row['id'] : '';
                
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($name) . "</td>";
                    echo "<td>" . htmlspecialchars($email) . "</td>";
                    echo "<td>
                            <a href='showUserEditForm/" . $id . "' class='btn btn-primary btn-sm'>Edit</a>
                            <a href='deleteUser/" . $id . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
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