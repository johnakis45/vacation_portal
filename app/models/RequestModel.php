<?php

require_once 'DbhModel.php';
class RequestModel extends DbhModel
{
    private $id;
    private $employeeId;
    private $submittedDate;
    private $startDate;
    private $endDate;
    private $reason;
    private $status;

    public function __construct() {
        parent::__construct();
        $this->submittedDate = date('Y-m-d');
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEmployeeId() {
        return $this->employeeId;
    }

    public function setEmployeeId($employeeId) {
        $this->employeeId = $employeeId;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setSubmittedDate($submittedDate) {
        $this->submittedDate = $submittedDate;
    }

    public function setReason($reason) {
        $this->reason = $reason;
    }

    public function getSubmittedDate() {
        return $this->submittedDate;
    }

    public function insertRequest() {
        $sql = "INSERT INTO vacations (user_id, description, submit_date, start_date, end_date) 
        VALUES ($this->employeeId, '$this->reason', '$this->submittedDate', '$this->startDate', '$this->endDate')";
        return $this-> executeNonQuery($sql);
    }

    public function removeRequest($id) {
        $sql  = "SELECT user_id FROM vacations WHERE id = $id";
        $user_id = $this->executeQuery($sql)[0]['user_id'];
        $sql = "DELETE FROM vacations WHERE id = $id";
        $this->executeNonQuery($sql);
        return $user_id;
    }

    public function validateRequest() {

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
        if (count($result) > 0) {
            return true;
        }
        return false;
    }


    public function getUserRequests($id){
        $sql = "SELECT * FROM vacations WHERE user_id = $id";
        $result = $this->executeQuery($sql);
        return $this->executeQuery($sql);
    }

    public function getAllRequests(){
        $sql = "SELECT * FROM vacations";
        return $this->executeQuery($sql);
    }

    public function approveRequest($id){
        $sql = "UPDATE vacations SET status = 'approved' WHERE id = $id";
        return $this->executeNonQuery($sql);
    }

    public function rejectRequest($id){
        $sql = "UPDATE vacations SET status = 'rejected' WHERE id = $id";
        return $this->executeNonQuery($sql);
    }
}