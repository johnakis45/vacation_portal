<?php 

//namespace app\controllers;


class ManagerController extends Controller
{

    public function __construct(){}

    public function getAllUsers()
    {
        $this->checkRole('manager');
        $user = $this->model('UserModel');
        $users = $user->getAllUsers();
        $this->view('manager/user_dashboardView', ['users' => $users]);
    }

    public function getAllRequests()
    {
        $this->checkRole('manager');
        $request = $this->model('RequestModel');
        $requests = $request->getAllRequests();
        $user = $this->model('UserModel');
        $users = $user->getAllUsers();
        foreach ($requests as $key => $value) {
            foreach ($users as $key2 => $value2) {
                if($value['user_id'] == $value2['id']){
                    $requests[$key]['employee_name'] = $value2['username'];
                }
            }
        }
        $this->view('manager/request_dashboardView', ['requests' => $requests]);
    }



    public function getUser($username)
    {
        $this->checkRole('manager');
        $user = $this->model('User');
        $user = $user->getUser($username);
        $this->view('manager/user_edit', ['user' => $user]);
    }

    public function showUserCreationForm()
    {
        $this->checkRole('manager');
        $this->view('manager/user_creationView', []);
    }

    public function saveUser()
    {
        $this->checkRole('manager');
        if (!$this->checkPost($_POST)) {
            header("Location: {$this->base_url}ManagerController/showUserCreationForm");
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
        
        if($user->insertUser()==true){
            $this->view('manager/user_creationView', ['success' => 'User created successfully']);
        }else{
            $this->view('manager/user_creationView', ['error' => 'User creation failed']);
        }
    }

    



    public function approveRequest($id)
    {
        $this->checkRole('manager');
        $request = $this->model('RequestModel');
        $request->approveRequest($id);
        header("Location: {$this->base_url}ManagerController/getAllRequests");
    }

    public function rejectRequest($id)
    {
        $this->checkRole('manager');
        $request = $this->model('RequestModel');
        $request->rejectRequest($id);
        header("Location: {$this->base_url}ManagerController/getAllRequests");
    }

    public function updateUser($id)
    {
        $this->checkRole('manager');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = $this->model('UserModel');

            $data = $user->getUser($id);

            $username = !empty($_POST['username']) ? $_POST['username'] : $data[0]['username'];
            $email = !empty($_POST['email']) ? $_POST['email'] : $data[0]['email'];

            $password = !empty($_POST['password']) ? $_POST['password'] : $data[0]['password'];

            $user->setUsername($username);
            $user->setEmail($email);

            if ($password !== null) {
                $user->setPassword($password);
            }else{
                $user->setPasswordNoHash($data[0]['password']);
            }

            if($user->updateUser($id)){
                header("Location: {$this->base_url}ManagerController/getAllUsers");
            }else{
                header("Location: {$this->base_url}ManagerController/showUserEditForm/{$id}/error");
            }
            
        }
    }


    public function deleteUser($id)
    {
        $this->checkRole('manager');
        $user = $this->model('UserModel');
        $user->removeUser($id);
        header("Location: {$this->base_url}ManagerController/getAllUsers"); 
    }

    public function showUserEditForm($id, $error = null)
    {
        $this->checkRole('manager');
        $user = $this->model('UserModel');
        $user = $user->getUser($id);
        if($error){
            $error = "User update failed";
        }
        $this->view('manager/user_editView', ['user' => $user , 'error' => $error]);
    }
}

?>