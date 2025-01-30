<?php

require_once 'Dbh.php';
class Vacation extends Dbh
{
    private $id;
    private $employeeId;
    private $submittedDate;
    private $startDate;
    private $endDate;
    private $reason;
    private $status;

    public function __construct() {
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

    public function insertVacation() {
        $sql = "INSERT INTO vacations (user_id, description, submit_date, start_date, end_date) 
        VALUES ($this->employeeId, '$this->reason', '$this->submittedDate', '$this->startDate', '$this->endDate')";
        return $this-> executeQueryInsert($sql);
    }

    public function deleteVacation($id) {
        $sql = "DELETE FROM vacations WHERE id = $id";
        return $this->executeQueryInsert($sql);
    }


    public function getUserRequests($id){
        $sql = "SELECT * FROM vacations WHERE user_id = $id";
        $result = $this->executeQuery($sql);
        return $this->executeQuery($sql);
    }
}