<?php 


class EmployeeController extends Controller {



    public function saveVacation() : void {
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

    public function deleteRequest(int $id = null) : void {
        $this->checkRole('user');
        if($id != null){
            $request= $this->model('RequestModel');
            $request->fetchRequest($id);
            if($request->getEmployeeId() != $_SESSION['id']){
                header("Location: {$this->base_url}EmployeeController/getUserRequests/{$_SESSION['id']}"); 
                exit();
            }
            $employee_id = $request->removeRequest($id);
            header("Location: {$this->base_url}EmployeeController/getUserRequests/{$employee_id}"); 
        }else{
            header("Location: {$this->base_url}EmployeeController/getUserRequests/{$_SESSION['id']}"); 
        }
    }


    public function showRequestVacationForm(string $message = null) : void {
        $this->checkRole('user');
        if($message == 'error'){
            $message = "Error while saving the request";
        }
        $this->view('employee/vacationView', ['error' => $message]);
    }


    public function getUserRequests($id = null) : void {  
        $this->checkLoggedIn();
        if($_SESSION['id'] != $id || $id == null){
            header("Location: {$this->base_url}EmployeeController/getUserRequests/{$_SESSION['id']}");
            exit();
        }
        
        $this->checkRole('user');
        $user= $this->model('UserModel');
        $user->fetchUserById($id);
        if($user->getEditDate() != $_SESSION['edit_date']){
            header("Location: {$this->base_url}AuthController/logout");
            exit();
        }
            
        $request= $this->model('RequestModel');
       
        $this->view('employee/vacation_dashboardView', ['requests' => $request->fetchUserRequests($id)]);
        return;
    }


}
?>