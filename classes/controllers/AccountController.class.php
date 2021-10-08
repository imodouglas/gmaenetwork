<?php 

class AccountController extends AccountModel{

    /** Get account */
    public function getAccount($userId){
        return $this->account($userId);
    }

    /** Get account by Id */
    public function accountById($id){
        return $this->accountId($id);
    }

    /** Add Bank Account */
    public function doAddAccount($userId, $bank, $acctName, $acctNo){
        return $this->addAccount($userId, $bank, $acctName, $acctNo);
    }

    /** Update Bank Account */
    public function doUpdateAccount($userId, $bank, $acctName, $acctNo, $id){
        return updateAccount($userId, $bank, $acctName, $acctNo, $id);
    }

    /** Delete Bank Account */
    public function doDeleteAccount($id){
        return deleteAccount($id);
    }

}