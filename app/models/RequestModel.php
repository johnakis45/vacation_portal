<?php

namespace App\models;
use App\models\DbhModel;

/**
 * RequestModel Class
 * 
 * This class represents a vacation request made by an employee. It extends the `DbhModel` class to interact with 
 * the database. It includes methods for handling CRUD operations on vacation requests, including inserting, 
 * deleting, fetching, approving, and rejecting requests.
 * @package app\models
 */
class RequestModel extends DbhModel
{
    // Properties
    private int $id;                
    private int $employeeId;       
    private string $submittedDate;  
    private string $startDate;      
    private string $endDate;        
    private string $reason;         
    private string $status;         // ( approved, rejected, pending)

    /**
     * Constructor to initialize the request model.
     * 
     * This constructor initializes the submitted date to the current date.
     */
    public function __construct() {
        parent::__construct();
        $this->submittedDate = date('Y-m-d');
    }

    // Getters
    /**
     * Get the ID of the vacation request.
     *
     * @return int|null Returns the request ID or null if not set.
     */
    public function getId(): ?int {
        return isset($this->id) ? $this->id : null;
    }
    
    /**
     * Get the employee ID who made the request.
     *
     * @return int|null Returns the employee ID or null if not set.
     */
    public function getEmployeeId(): ?int {
        return isset($this->employeeId) ? $this->employeeId : null;
    }

    /**
     * Get the start date of the vacation request.
     *
     * @return string|null Returns the start date of the vacation or null if not set.
     */
    public function getStartDate(): ?string {
        return isset($this->startDate) ? $this->startDate : null;
    }

    /**
     * Get the end date of the vacation request.
     *
     * @return string|null Returns the end date of the vacation or null if not set.
     */
    public function getEndDate(): ?string {
        return isset($this->endDate) ? $this->endDate : null;
    }

    /**
     * Get the current status of the vacation request.
     *
     * @return string|null Returns the status of the request or null if not set.
     */
    public function getStatus(): ?string {
        return isset($this->status) ? $this->status : null;
    }

    /**
     * Get the date the vacation request was submitted.
     *
     * @return string|null Returns the submitted date or null if not set.
     */
    public function getSubmittedDate(): ?string {
        return isset($this->submittedDate) ? $this->submittedDate : null;
    }

    /**
     * Get the reason for the vacation request.
     *
     * @return string|null Returns the reason for the request or null if not set.
     */
    public function getReason(): ?string {
        return isset($this->reason) ? $this->reason : null;
    }

    // Setters
    /**
     * Set the ID of the vacation request.
     *
     * @param int|null $id The request ID.
     */
    public function setId(?int $id): void {
        if ($id !== null) {
            $this->id = $id;
        }
    }

    /**
     * Set the employee ID who made the request.
     *
     * @param int|null $employeeId The employee ID.
     */
    public function setEmployeeId(?int $employeeId): void {
        if ($employeeId !== null) {
            $this->employeeId = $employeeId;
        }
    }

    /**
     * Set the start date of the vacation request.
     *
     * @param string|null $startDate The start date.
     */
    public function setStartDate(?string $startDate): void {
        if ($startDate !== null) {
            $this->startDate = $startDate;
        }
    }

    /**
     * Set the end date of the vacation request.
     *
     * @param string|null $endDate The end date.
     */
    public function setEndDate(?string $endDate): void {
        if ($endDate !== null) {
            $this->endDate = $endDate;
        }
    }

    /**
     * Set the status of the vacation request.
     *
     * @param string|null $status The status of the request (e.g., 'approved', 'rejected').
     */
    public function setStatus(?string $status): void {
        if ($status !== null) {
            $this->status = $status;
        }
    }

    /**
     * Set the submitted date of the vacation request.
     *
     * @param string|null $submittedDate The submitted date.
     */
    public function setSubmittedDate(?string $submittedDate): void {
        if ($submittedDate !== null) {
            $this->submittedDate = $submittedDate;
        }
    }

    /**
     * Set the reason for the vacation request.
     *
     * @param string|null $reason The reason for the vacation request.
     */
    public function setReason(?string $reason): void {
        if ($reason !== null) {
            $this->reason = $reason;
        }
    }

    // CRUD Operations
    /**
     * Insert a new vacation request into the database.
     * 
     * This method inserts a new request into the `vacations` table in the database.
     *
     * @return bool Returns true if the insertion is successful, false otherwise.
     */
    public function insertRequest(): bool {
        $sql = "INSERT INTO vacations (user_id, description, submit_date, start_date, end_date) 
                VALUES ($this->employeeId, '$this->reason', '$this->submittedDate', '$this->startDate', '$this->endDate')";
        return $this->executeNonQuery($sql);
    }

    /**
     * Remove a vacation request from the database.
     * 
     * This method deletes a vacation request by its ID from the `vacations` table and returns the employee's ID.
     *
     * @param int $id The ID of the vacation request.
     * @return int The employee ID of the request.
     */
    public function removeRequest(int $id): ?int {
        try {
            // First get the user_id
            $sql = "SELECT user_id FROM vacations WHERE id = $id";
            $result = $this->executeQuery($sql);
            
            if (empty($result)) {
                return null; // Request not found
            }
            
            $user_id = $result[0]['user_id'];
            
            // Then delete the request
            $sql = "DELETE FROM vacations WHERE id = $id";
            if (!$this->executeNonQuery($sql)) {
                throw new \Exception("Failed to delete vacation request");
            }
            
            return $user_id;
            
        } catch (\Exception $e) {
            // Log error here if needed
            return null;
        }
    }

    /**
     * Fetch all vacation requests for a specific employee.
     * 
     * This method retrieves all vacation requests for an employee using their employee ID.
     *
     * @param int $id The employee ID.
     * @return array An array of vacation requests.
     */
    public function fetchUserRequests(int $id): array {
        $sql = "SELECT * FROM vacations WHERE user_id = $id";
        return $this->executeQuery($sql);
    }

    /**
     * Fetch all vacation requests.
     * 
     * This method retrieves all vacation requests from the `vacations` table.
     *
     * @return array An array of all vacation requests.
     */
    public function fetchAllRequests(): array {
        $sql = "SELECT * FROM vacations";
        return $this->executeQuery($sql);
    }

    /**
     * Fetch a specific vacation request by its ID.
     * 
     * This method retrieves the details of a vacation request by its ID and populates the object's properties.
     *
     * @param int $id The vacation request ID.
     * @return void
     */
    public function fetchRequest(int $id): void {
        $sql = "SELECT * FROM vacations WHERE id = $id";
        $data = $this->executeQuery($sql);
        if(!empty($data)) {
            $this->reason = $data[0]['description'];
            $this->startDate = $data[0]['start_date'];
            $this->endDate = $data[0]['end_date'];
            $this->status = $data[0]['status'];
            $this->submittedDate = $data[0]['submit_date'];
            $this->employeeId = $data[0]['user_id'];
        }
    }

    /**
     * Approve a vacation request.
     * 
     * This method updates the status of a vacation request to 'approved' in the database.
     *
     * @param int $id The vacation request ID.
     * @return bool Returns true if the request was approved successfully, false otherwise.
     */
    public function approveRequest(int $id): bool {
        $sql = "UPDATE vacations SET status = 'approved' WHERE id = $id";
        return $this->executeNonQuery($sql);
    }

    /**
     * Reject a vacation request.
     * 
     * This method updates the status of a vacation request to 'rejected' in the database.
     *
     * @param int $id The vacation request ID.
     * @return bool Returns true if the request was rejected successfully, false otherwise.
     */
    public function rejectRequest(int $id): bool {
        $sql = "UPDATE vacations SET status = 'rejected' WHERE id = $id";
        return $this->executeNonQuery($sql);
    }

    // Validation
    /**
     * Validate a vacation request.
     * 
     * This method checks whether the start and end dates are valid. It ensures that the start date is not 
     * later than the end date, that neither date is in the past, and that there are no overlapping requests 
     * from the same employee.
     *
     * @return bool Returns true if the request is invalid, false otherwise.
     */
    public function validateRequest(): bool {
        if (strtotime($this->startDate) > strtotime($this->endDate)) {
            return true;
        }
        if (strtotime($this->startDate) < strtotime('today') || strtotime($this->endDate) < strtotime('today')) {
            return true;
        }
        $sql = "SELECT * FROM vacations WHERE user_id = $this->employeeId AND 
                ((start_date BETWEEN '$this->startDate' AND '$this->endDate') OR 
                (end_date BETWEEN '$this->startDate' AND '$this->endDate'))";
        $result = $this->executeQuery($sql);
        return count($result) > 0;
    }
}

?>
