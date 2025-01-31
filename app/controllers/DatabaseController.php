<?php   

class DatabaseController extends Controller{



   public function populateDatabase() {
    try{
        $userModel = $this->model('UserModel');
        $existingUser = $userModel->getUser(1);
        if(empty($existingUser)){
           
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


        header('Location:'. BASE_URL . 'AuthController/login');
    }catch(Exception $e){
       
    }
    
    
}

}

?>