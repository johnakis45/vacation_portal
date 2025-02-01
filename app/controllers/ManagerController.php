<?php 

//namespace app\controllers;


class ManagerController extends Controller
{

    public function __construct(){}

    public function getAllUsers() : void
    {
        $this->checkRole('manager');
        $user = $this->model('UserModel');
        $users = $user->fetchAllUsers();
        $this->view('manager/user_dashboardView', ['users' => $users]);
    }

    public function getAllRequests() : void
    {
        $this->checkRole('manager');
        $request = $this->model('RequestModel');
        $requests = $request->fetchAllRequests();
        $user = $this->model('UserModel');
        $users = $user->fetchAllUsers();
        foreach ($requests as $key => $value) {
            foreach ($users as $key2 => $value2) {
                if($value['user_id'] == $value2['id']){
                    $requests[$key]['employee_name'] = $value2['username'];
                }
            }
        }
        $this->view('manager/request_dashboardView', ['requests' => $requests]);
    }


    public function showUserCreationForm() : void
    {
        $this->checkRole('manager');
        $this->view('manager/user_creationView', []);
    }

    public function saveUser() : void
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

    



    public function approveRequest(int $id = null) : void
    {
        $this->checkRole('manager');
        if($id != null){
            $request = $this->model('RequestModel');
            $request->approveRequest($id);
        }
        header("Location: {$this->base_url}ManagerController/getAllRequests");
    }

    public function rejectRequest(int $id = null) : void
    {
        $this->checkRole('manager');
        if($id != null){
            $request = $this->model('RequestModel');
            $request->rejectRequest($id);
        }
        header("Location: {$this->base_url}ManagerController/getAllRequests");
    }

    public function updateUser(int $id = null) : void
    {
        $this->checkRole('manager');
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
                

                if($user->updateUser($id)){
                    header("Location: {$this->base_url}ManagerController/getAllUsers");
                }else{
                    header("Location: {$this->base_url}ManagerController/showUserEditForm/{$id}/error");
                }
            }
        }
    }


    public function deleteUser(int $id = null) : void
    {
        $this->checkRole('manager');
        if($id != null){
            $user = $this->model('UserModel');
            $user->removeUser($id);
            header("Location: {$this->base_url}ManagerController/getAllUsers"); 
        }
    }

    public function showUserEditForm(int $id = null, string $error = null) : void
    {
        $this->checkRole('manager');
        if($id != null){
            $user = $this->model('UserModel');
            $user->fetchUserById($id);
            if($user->getId() == null){
                header("Location: {$this->base_url}ManagerController/getAllUsers");
            }
            if($error){
                $error = "User update failed";
            }
            $this->view('manager/user_editView', ['id'=>$user->getId(),'name' => $user->getUsername(), 'email' => $user->getEmail() , 'error' => $error]);
        }else{
            header("Location: {$this->base_url}ManagerController/getAllUsers");
        }
    }
}

?>