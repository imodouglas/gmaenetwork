<?php 

class AccountModel extends Config {

    /** Get Account */
    protected function account($userId){
        $query = $this->conn()->prepare("SELECT * FROM accounts WHERE `user_id` = ?");
        $query->execute([$userId]);
        return $this->singleResult($query);
    }

    /** Get account by ID */
    protected function accountId($id){
        $query = $this->conn()->prepare("SELECT * FROM accounts WHERE id = ?");
        $query->execute([$id]);
        return $this->singleResult($query);
    }

    /** Add Account Details */
    protected function addAccount($userId, $bank, $acctName, $acctNo){
        $query = $this->conn()->prepare("INSERT INTO accounts (`user_id`, bank, account_name, account_no) VALUES (?,?,?,?)");
        $query->execute([$userId, $bank, $acctName, $acctNo]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

    /** Update Account Details */
    protected function updateAccount($userId, $bank, $acctName, $acctNo, $id){
        $query = $this->conn()->prepare("UPDATE accounts SET `user_id` = ?, bank = ?, account_name = ?, account_no = ? WHERE id = ?");
        $query->execute([$userId, $bank, $acctName, $acctNo, $id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

    /** Delete Account by ID */
    protected function deleteAccount($id){
        $query = $this->conn()->prepare("DELETE FROM accounts WHERE id = ?");
        $query->execute([$id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

}
