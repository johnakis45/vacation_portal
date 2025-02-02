<?php

namespace App\controllers;
use App\core\Controller;

/**
 * Database Controller
 * 
 * This class handles the functionality of populating the database with initial data.
 * It checks if certain records exist and, if not, creates new records (e.g., admin, user, vacation requests).
 * @package app\controllers
 */
class DatabaseController extends Controller
{
    /**
     * Populates the database with initial data.
     * 
     * This method checks if the user with ID 1 (admin) exists in the database. If not, it creates
     * default users (admin and user) and some vacation requests for the user. Once the data is populated,
     * the user is redirected to the login page.
     *
     * @return void
     */
    public function populateDatabase(): void
    {
        try {
            $userModel = $this->model('UserModel');
            $userModel->fetchUserById(1);

            if (empty($userModel->getId())) {
                $user = $this->model('UserModel');
                $user->setUsername('admin');
                $user->setEmail('admin@epignosishq.com');
                $user->setUniqueCode('0000000');
                $user->setPassword('admin');
                $user->setRole('manager');
                $user->insertUser();

                $user = $this->model('UserModel');
                $user->setUsername('user');
                $user->setEmail('user@mail.com');
                $user->setUniqueCode('1234567');
                $user->setPassword('user');
                $user->setRole('user');
                $user->insertUser();

                $vacation = $this->model('RequestModel');
                $vacation->setEmployeeId(2);  
                $vacation->setStartDate('2020-01-01');
                $vacation->setEndDate('2020-01-10');
                $vacation->setReason('Vacation');
                $vacation->setStatus('pending');
                $vacation->insertRequest();

                $vacation = $this->model('RequestModel');
                $vacation->setEmployeeId(2);  
                $vacation->setStartDate('2020-02-01');
                $vacation->setEndDate('2020-02-10');
                $vacation->setReason('Vacation 3');
                $vacation->setStatus('approved');
                $vacation->insertRequest();
            }
            header('Location:' . BASE_URL . 'AuthController/login');
        } catch (Exception $e) {
            header('HTTP/1.1 500 Error');
        }
    }
}

?>
