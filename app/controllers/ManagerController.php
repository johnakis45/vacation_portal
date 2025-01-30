<?php 

//namespace app\controllers;


class ManagerController extends Controller
{

    public function __construct()
    {

    }


    public function getAllUsers()
    {
        $user = $this->model('User');
        $users = $user->getAllUsers();
        $this->view('manager/user_dashboard', ['users' => $users]);
    }

    public function getUser($username)
    {
        $user = $this->model('User');
        $user = $user->getUser($username);
        $this->view('manager/user_edit', ['user' => $user]);
    }

    public function updateUser($username, $email, $password)
    {
        $user = $this->model('User');
        $user->updateUser($username, $email, $password);
        $this->view('manager/user_dashboard', []);
    }

    public function deleteUser($username)
    {
        $user = $this->model('User');
        $user->deleteUser($username);
        $this->view('manager/user_dashboard', []);
    }

    public function createUser($username, $email, $password, $unique_code, $role)
    {
        $user = $this->model('User');
        $user->createUser($username, $email, $password, $unique_code, $role);
        $this->view('manager/user_dashboard', []);
    }

    public function requests($id)
    {
        $request = $this->model('Vacation');
        $requests = $request->getUserRequests($id);
        $this->view('manager/requests', ['requests' => $requests]);
    }



    public function approveRequest($id)
    {
        $request = $this->model('Request');
        $request->approveRequest($id);
        $this->view('manager/user_dashboard', []);
    }

    public function rejectRequest($id)
    {
        $request = $this->model('Request');
        $request->rejectRequest($id);
        $this->view('manager/user_dashboard', []);
    }

    public function update_user($id)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $base_url = BASE_URL;
            $user = $this->model('User');

            $data = $user->getUser($id);

            $username = !empty($_POST['username']) ? $_POST['username'] : $data[0]['username'];
            $email = !empty($_POST['email']) ? $_POST['email'] : $data[0]['email'];
            $password = !empty($_POST['password']) ? $_POST['password'] : $data[0]['password'];
        
            
            // $username =$_POST['username'];
            // $email = $_POST['email'];
            // $password = $_POST['password'];
            
            $user->updateUser($id,$username, $email, $password);
            header("Location: {$base_url}ManagerController/getAllUsers");
        }
    }


    public function delete_user($id)
    {
        $base_url = BASE_URL;
        $user = $this->model('User');
        $user->deleteUser($id);
        header("Location: {$base_url}ManagerController/getAllUsers"); 
    }

    public function edit_user($id)
    {
        //$base_url = BASE_URL;
        $user = $this->model('User');
        $user = $user->getUser($id);
        $this->view('manager/user_edit', ['user' => $user]);
    }
}

?>