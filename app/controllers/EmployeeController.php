<?php 


class EmployeeController extends Controller {

    public function index($name = '') {
        $user = $this->model('User');
        $user->setUsername($name);
        $this->view('login', ['name' => $user->getUsername()]);
    }

    public function create($name = '', $email = '', $password = '', $unique_code = '', $role = '') {
        $user = $this->model('User');
        $user->setUsername($name);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setUniqueCode($unique_code);
        $user->setRole($role);
        $user->create();
        //$this->view('employee/vacation_dashboard', ['name' => $user->name]);
        
    }

    public function saveVacation(){
        $id = $_SESSION['id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $reason = $_POST['reason'];

        $vacation = $this->model('Vacation');
        $vacation->setEmployeeId($id);
        $vacation->setStartDate($start_date);
        $vacation->setEndDate($end_date);
        $vacation->setReason($reason);
        if($vacation->insertVacation()==true){
            $this->view('employee/vacation', ['message' => 'Vacation request submitted successfully']);
        }else{
            $this->view('employee/vacation', ['message' => 'Vacation request failed']);
        }
        //$this->view('employee/vacation_dashboard', []);
    }

    public function deleteRequest($id){
        $base_url = BASE_URL;
        $vacation = $this->model('Vacation');
        $vacation->deleteVacation($id);
        header("Location: {$base_url}EmployeeController/requests/2"); 
    }


    public function requestVacation(){
        $this->view('employee/vacation', []);
    }


    public function requests($id) {
        $vacation = $this->model('Vacation');
        return $this->view('employee/vacation_dashboard', ['requests' => $vacation->getUserRequests($id)]);
    }


}
?>