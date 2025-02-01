<?php 


class EmployeeController extends Controller {



    public function saveVacation(){
        $this->checkRole('user');
        $id = $_SESSION['id'];
        if (!isset($_POST['start_date']) || !isset($_POST['end_date']) || !isset($_POST['reason'])) {
            header("Location: {$this->base_url}EmployeeController/showRequestVacationForm/error"); 
        }
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $reason = $_POST['reason'];
        $request= $this->model('RequestModel');
        $request->setEmployeeId($id);
        $request->setStartDate($start_date);
        $request->setEndDate($end_date);
        $request->setReason($reason);

        if($request->validateRequest()){
            header("Location: {$this->base_url}EmployeeController/showRequestVacationForm/error"); 
            exit();
        }
        if($request->insertRequest()==true){
            header("Location: {$this->base_url}EmployeeController/getUserRequests/{$id}"); 
            exit();
        }
        header("Location: {$this->base_url}EmployeeController/showRequestVacationForm/error"); 

    }

    public function deleteRequest($id){
        $this->checkRole('user');
        $request= $this->model('RequestModel');
        if($request->getRequestemployeeId($id)[0]['user_id'] != $_SESSION['id']){
            header("Location: {$this->base_url}EmployeeController/getUserRequests/{$_SESSION['id']}"); 
            exit();
        }
        $employee_id = $request->removeRequest($id);
        header("Location: {$this->base_url}EmployeeController/getUserRequests/{$employee_id}"); 
    }


    public function showRequestVacationForm($message = null){
        $this->checkRole('user');
        if($message == 'error'){
            $message = "Error while saving the request";
        }
        $this->view('employee/vacationView', ['error' => $message]);
    }


    public function getUserRequests($id = null){  
        if($_SESSION['id'] != $id || $id == null){
            header("Location: {$this->base_url}EmployeeController/getUserRequests/{$_SESSION['id']}");
            exit();
        }
        
        $this->checkRole('user');
        $user= $this->model('UserModel');
        $userData = $user->getUser($id);
        if($userData == null || $userData[0]['edit_date'] != $_SESSION['edit_date']){
            header("Location: {$this->base_url}AuthController/logout");
            exit();
        }
            
        $request= $this->model('RequestModel');
       
        return $this->view('employee/vacation_dashboardView', ['requests' => $request->getUserRequests($id)]);
    }



}
?>