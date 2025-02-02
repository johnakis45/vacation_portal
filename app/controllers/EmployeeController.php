<?php 

namespace App\controllers;
use App\core\Controller;
/**
 * Employee Controller
 * 
 * This controller handles the functionality related to vacation requests for users (employees). 
 * It includes methods for saving vacation requests, deleting requests, showing the vacation request form, 
 * and fetching the vacation requests of a user.
 * @package app\controllers
 */
class EmployeeController extends Controller {

    /**
     * Saves a vacation request submitted by the employee.
     * 
     * This method handles the vacation request submission process. It checks whether the request is valid,
     * and if so, inserts it into the database. If the request is invalid, it redirects to the form with an error message.
     *
     * @return void
     */
    public function saveVacation(): void {
        $this->checkRole('user');
        
        $id = $_SESSION['id'];
        
        if (!isset($_POST['start_date']) || !isset($_POST['end_date']) || !isset($_POST['reason'])) {
            header("Location: " . BASE_URL . "EmployeeController/showRequestVacationForm/error");
        }
        
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $reason = $_POST['reason'];
        

        $request = $this->model('RequestModel');
        $request->setEmployeeId($id);
        $request->setStartDate($start_date);
        $request->setEndDate($end_date);
        $request->setReason($reason);

        if ($request->validateRequest()) {
            header("Location: " . BASE_URL . "EmployeeController/showRequestVacationForm/error");
            exit();
        }

        if ($request->insertRequest() == true) {
            header("Location: " . BASE_URL . "EmployeeController/getUserRequests/{$id}");
            exit();
        }
        header("Location: " . BASE_URL . "EmployeeController/showRequestVacationForm/error");
    }

    /**
     * Deletes a vacation request made by the employee.
     * 
     * This method deletes a specific vacation request based on its ID. If the employee is not authorized 
     * to delete the request, or if the request ID is invalid, the method redirects the employee to their requests page.
     *
     * @param int|null $id The ID of the vacation request to be deleted
     * @return void
     */
    public function deleteRequest(int $id = null): void {
        $this->checkRole('user');
        
        if ($id != null) {
            $request = $this->model('RequestModel');
            $request->fetchRequest($id);
            
            if ($request->getEmployeeId() != $_SESSION['id']) {
                header("Location: " . BASE_URL . "EmployeeController/getUserRequests/{$_SESSION['id']}");
                exit();
            }
            
            $employee_id = $request->removeRequest($id);
            header("Location: " . BASE_URL . "EmployeeController/getUserRequests/{$employee_id}");
        } else {
            header("Location: " . BASE_URL . "EmployeeController/getUserRequests/{$_SESSION['id']}");
        }
    }

    /**
     * Displays the vacation request form.
     * 
     * This method displays the vacation request form to the employee. If an error message is provided, it is 
     * displayed on the form to inform the employee about any issues with their previous request.
     *
     * @param string|null $message The error message to display (if any)
     * @return void
     */
    public function showRequestVacationForm(string $message = null): void {
        $this->checkRole('user');
        if ($message == 'error') {
            $message = "Error while saving the request";
        }
        
        $this->view('employee/vacationView', ['error' => $message]);
    }

    /**
     * Fetches and displays the vacation requests of a specific employee.
     * 
     * This method retrieves and displays the list of vacation requests made by a specific employee. 
     * If the employee is not logged in or doesn't have permission to view the requests, they are redirected 
     * to the appropriate page.
     *
     * @param int|null $id The ID of the employee whose requests are being fetched
     * @return void
     */
    public function getUserRequests($id = null): void {  
        $this->checkLoggedIn();
        
        if ($_SESSION['id'] != $id || $id == null) {
            header("Location: " . BASE_URL . "EmployeeController/getUserRequests/{$_SESSION['id']}");
            exit();
        }
        
        $this->checkRole('user');
        
        $this->checkEdit($id);
        $request = $this->model('RequestModel');
        $this->view('employee/vacation_dashboardView', ['requests' => $request->fetchUserRequests($id)]);
        return;
    }

}
?>
