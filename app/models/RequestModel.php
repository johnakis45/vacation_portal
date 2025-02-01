<?php

require_once 'DbhModel.php';
class RequestModel extends DbhModel
{
    // Properties
    private int $id;
    private int $employeeId;
    private string $submittedDate;
    private string $startDate;
    private string $endDate;
    private string $reason;
    private string $status;

    // Constructor
    public function __construct() {
        parent::__construct();
        $this->submittedDate = date('Y-m-d');
    }

    // Getters
    public function getId(): ?int {
        return isset($this->id) ? $this->id : null;
    }
    
    public function getEmployeeId(): ?int {
        return isset($this->employeeId) ? $this->employeeId : null;
    }
    
    public function getStartDate(): ?string {
        return isset($this->startDate) ? $this->startDate : null;
    }
    
    public function getEndDate(): ?string {
        return isset($this->endDate) ? $this->endDate : null;
    }
    
    public function getStatus(): ?string {
        return isset($this->status) ? $this->status : null;
    }
    
    public function getSubmittedDate(): ?string {
        return isset($this->submittedDate) ? $this->submittedDate : null;
    }
    

    // Setters
    public function setId(?int $id): void {
        if ($id !== null) {
            $this->id = $id;
        }
    }
    
    public function setEmployeeId(?int $employeeId): void {
        if ($employeeId !== null) {
            $this->employeeId = $employeeId;
        }
    }
    
    public function setStartDate(?string $startDate): void {
        if ($startDate !== null) {
            $this->startDate = $startDate;
        }
    }
    
    public function setEndDate(?string $endDate): void {
        if ($endDate !== null) {
            $this->endDate = $endDate;
        }
    }
    
    public function setStatus(?string $status): void {
        if ($status !== null) {
            $this->status = $status;
        }
    }
    
    public function setSubmittedDate(?string $submittedDate): void {
        if ($submittedDate !== null) {
            $this->submittedDate = $submittedDate;
        }
    }
    
    public function setReason(?string $reason): void {
        if ($reason !== null) {
            $this->reason = $reason;
        }
    }
    

    // CRUD Operations
    public function insertRequest(): bool {
        $sql = "INSERT INTO vacations (user_id, description, submit_date, start_date, end_date) 
                VALUES ($this->employeeId, '$this->reason', '$this->submittedDate', '$this->startDate', '$this->endDate')";
        return $this->executeNonQuery($sql);
    }

    public function removeRequest(int $id): int {
        $sql = "SELECT user_id FROM vacations WHERE id = $id";
        $user_id = $this->executeQuery($sql)[0]['user_id'];
        $sql = "DELETE FROM vacations WHERE id = $id";
        $this->executeNonQuery($sql);
        return $user_id;
    }

    public function fetchUserRequests(int $id): array {
        $sql = "SELECT * FROM vacations WHERE user_id = $id";
        return $this->executeQuery($sql);
    }

    public function fetchAllRequests(): array {
        $sql = "SELECT * FROM vacations";
        return $this->executeQuery($sql);
    }

    public function fetchRequest(int $id): void {
        $sql = "SELECT * FROM vacations WHERE id = $id";
        $data = $this->executeQuery($sql);
        $this->reason = $data[0]['description'];
        $this->startDate = $data[0]['start_date'];
        $this->endDate = $data[0]['end_date'];
        $this->status = $data[0]['status'];
        $this->submittedDate = $data[0]['submit_date'];
        $this->employeeId = $data[0]['user_id'];
    }

    public function approveRequest(int $id): bool {
        $sql = "UPDATE vacations SET status = 'approved' WHERE id = $id";
        return $this->executeNonQuery($sql);
    }

    public function rejectRequest(int $id): bool {
        $sql = "UPDATE vacations SET status = 'rejected' WHERE id = $id";
        return $this->executeNonQuery($sql);
    }

    // Validation
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