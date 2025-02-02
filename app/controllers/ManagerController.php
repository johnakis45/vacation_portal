<?php 

namespace App\controllers;
use App\core\Controller;

/**
 * Manager Controller
 * 
 * This controller handles all the functionalities related to the manager's operations. It allows managers
 * to view all users and requests, approve or reject vacation requests, create and update users, and delete users.
 * @package app\controllers
 */
class ManagerController extends Controller
{

    /**
     * Retrieves and displays all users.
     * 
     * This method fetches all users from the database and displays them in the user dashboard. 
     * It ensures that only managers can access this method.
     *
     * @return void
     */
    public function getAllUsers(): void
    {
        $this->checkRole('manager');
        $this->checkEdit($_SESSION['id']);
        $user = $this->model('UserModel');
        $users = $user->fetchAllUsers();
        $this->view('manager/user_dashboardView', ['users' => $users]);
    }

    /**
     * Retrieves and displays all vacation requests.
     * 
     * This method fetches all vacation requests from the database, associates each request with the employee's 
     * name, and displays them in the request dashboard. Only managers are allowed to access this method.
     *
     * @return void
     */
    public function getAllRequests(): void
    {
        $this->checkRole('manager');
        $this->checkEdit($_SESSION['id']);
        $request = $this->model('RequestModel');
        $requests = $request->fetchAllRequests();
        $user = $this->model('UserModel');
        $users = $user->fetchAllUsers();

        foreach ($requests as $key => $value) {
            foreach ($users as $key2 => $value2) {
                if ($value['user_id'] == $value2['id']) {
                    $requests[$key]['employee_name'] = $value2['username'];
                }else{
                    $requests[$key]['employee_name'] = 'User not found';
                }
            }
        }

        $this->view('manager/request_dashboardView', ['requests' => $requests]);
    }

    /**
     * Displays the user creation form.
     * 
     * This method displays the form for creating a new user. It is accessible only to managers.
     *
     * @return void
     */
    public function showUserCreationForm(): void
    {
        $this->checkRole('manager');
        $this->checkEdit($_SESSION['id']);
        $this->view('manager/user_creationView', []);
    }

    /**
     * Saves a new user to the database.
     * 
     * This method processes the form submission for creating a new user. If the user creation is successful, 
     * a success message is displayed; otherwise, an error message is shown.
     *
     * @return void
     */
    public function saveUser(): void
    {
        $this->checkRole('manager');
        $this->checkEdit($_SESSION['id']);
        
        if (!$this->checkPost($_POST)) {
            header("Location: " . BASE_URL . "ManagerController/showUserCreationForm");
        }
        
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $unique_code = $_POST['unique_code'];

        $user = $this->model('UserModel');
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setUniqueCode($unique_code);
        $user->setRole('user');
        
        if ($user->insertUser() == true) {
            $this->view('manager/user_creationView', ['success' => 'User created successfully']);
        } else {
            $this->view('manager/user_creationView', ['error' => 'User creation failed']);
        }
    }

    /**
     * Approves a vacation request.
     * 
     * This method approves a specific vacation request based on its ID. Only managers can approve requests.
     *
     * @param int|null $id The ID of the vacation request to approve
     * @return void
     */
    public function approveRequest(int $id = null): void
    {
        $this->checkRole('manager');
        $this->checkEdit($_SESSION['id']);
        
        if ($id != null) {
            $request = $this->model('RequestModel');
            $request->approveRequest($id);
        }
        
        header("Location: " . BASE_URL . "ManagerController/getAllRequests");
    }

    /**
     * Rejects a vacation request.
     * 
     * This method rejects a specific vacation request based on its ID. Only managers can reject requests.
     *
     * @param int|null $id The ID of the vacation request to reject
     * @return void
     */
    public function rejectRequest(int $id = null): void
    {
        $this->checkRole('manager');
        $this->checkEdit($_SESSION['id']);
        
        if ($id != null) {
            $request = $this->model('RequestModel');
            $request->rejectRequest($id);
        }
        
        header("Location: " . BASE_URL . "ManagerController/getAllRequests");
    }

    /**
     * Updates a user's details.
     * 
     * This method processes the form for updating an existing user's details, including their username, email, and password.
     * If the update is successful, the manager is redirected to the user list; otherwise, an error message is displayed.
     *
     * @param int|null $id The ID of the user to update
     * @return void
     */
    public function updateUser(int $id = null): void
    {
        $this->checkRole('manager');
        $this->checkEdit($_SESSION['id']);
        
        if ($id != null) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $user = $this->model('UserModel');
                $user->fetchUserById($id);

                $username = !empty($_POST['username']) ? $_POST['username'] : $user->getUsername();
                $email = !empty($_POST['email']) ? $_POST['email'] : $user->getEmail();
                $password = !empty($_POST['password']) ? $_POST['password'] : null;

                $user->setUsername($username);
                $user->setEmail($email);
                $user->setPassword($password);

                if ($user->updateUser($id)) {
                    header("Location: " . BASE_URL . "ManagerController/getAllUsers");
                } else {
                    header("Location: " . BASE_URL . "ManagerController/showUserEditForm/{$id}/error");
                }
            }
        }
    }

    /**
     * Deletes a user from the database.
     * 
     * This method deletes a specific user based on their ID. After deletion, the manager is redirected to the user list.
     *
     * @param int|null $id The ID of the user to delete
     * @return void
     */
    public function deleteUser(int $id = null): void
    {
        $this->checkRole('manager');
        $this->checkEdit($_SESSION['id']);
        
        if ($id != null) {
            $user = $this->model('UserModel');
            $user->removeUser($id);
            header("Location: " . BASE_URL . "ManagerController/getAllUsers");
        }
    }

    /**
     * Displays the user edit form.
     * 
     * This method displays the form for editing a user's details. It is accessible only to managers. 
     * If the user cannot be found or an error occurs, an error message is displayed.
     *
     * @param int|null $id The ID of the user to edit
     * @param string|null $error Error message (optional)
     * @return void
     */
    public function showUserEditForm(int $id = null, string $error = null): void
    {
        $this->checkRole('manager');
        $this->checkEdit($_SESSION['id']);
        
        if ($id != null) {
            $user = $this->model('UserModel');
            $user->fetchUserById($id);
            
            if ($user->getId() == null) {
                header("Location: " . BASE_URL . "ManagerController/getAllUsers");
            }

            if ($error) {
                $error = "User update failed";
            }
            $this->view('manager/user_editView', ['id' => $user->getId(), 'name' => $user->getUsername(), 'email' => $user->getEmail(), 'error' => $error]);
        } else {
            header("Location: " . BASE_URL . "ManagerController/getAllUsers");
        }
    }
}

?>
