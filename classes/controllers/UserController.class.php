<?php

class UserController extends User {

    /** Login function */
    public function doLogin($uname, $pword){
        $data = $this->login($uname, $pword);
        return $data;
    }

    /** Create User Account */
    public function doCreateUser($password, $firstName, $lastName, $uname, $email, $phone, $level, $ref){
        return $result = $this->createUser($password, $firstName, $lastName, $uname, $email, $phone, $level, $ref);
    }

    /** Get Users Data by ID */
    public function getUser($id){
        $data = $this->userById($id);
        return $data;
    }

    /** Get Users Data by Email */
    public function userByEmail($email){
        $data = $this->userData($email);
        return $data;
    }

    /** Get All Users Count */
    public function getTotalUsers(){
        $data = $this->totalUsers();
        return $data;
    }

    /** Get All Users Data */
    public function getAllUsers(){
        $data = $this->allUsers();
        return $data;
    }

    /** Update User Account */
    public function doUpdateUser($id, $firstName, $lastName, $email, $phone){
        return $this->updateUser($id, $firstName, $lastName, $email, $phone);
    }

    /** Update User Level */
    public function doUpdateLevel($id, $level){
        return $this->updateLevel($id, $level);
    }

    /** get Current and Next Level */
    public function getCurrentNextPlan($userId){
        return $this->currentNextPlan($userId);
    }

    /** get check upline */
    public function getCheckUpline($referrer, $level){
        if($this->getUser($referrer) == false){
            $refId = 3;
        } else {
            $refId = $this->getUser($referrer)['id'];
        }
        return $this->checkUpline($refId, $level);
    }

    /** get check downline */
    public function getCheckDownline($id, $level){
        return $this->checkDownline($id, $level);
    }

    /** get user downlines */
    public function getDownlines($uname){
        return $this->userDownlines($uname);
    }

    /** Change Password */
    public function getChangePassword($id, $password){
        return $this->changePassword($id, md5($password));
    }

    /** Check Password */
    public function getCheckPassword($id, $password){
        return $this->checkPassword($id, md5($password));
    }

    /** Update User Status */
    public function getUpdateStatus($id, $status){
        $data = $this->updateStatus($id, $status);
        return $data;
    }

    /** Delete User Account */
    public function doDeleteUser($id){
        $result = $this->deleteUser($id);
        return $result;
    }


    /** Create Team */
    public function doCreateTeam($userId, $investmentId){
        return $this->createTeam($userId, $investmentId);
    }

    /** Get Team */
    public function getTeam($id){
        return $this->readTeam($id);
    }

    /** Update Team */
    public function doUpdateTeam($id, $column, $userId){
        return $this->updateTeam($id, $column, $userId);
    }

    /** Delete Team */
    public function doDeleteTeam($id){
        return $this->deleteTeam($id);
    }

}