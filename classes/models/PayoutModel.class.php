<?php 

class PayoutModel extends Config {

    /** Get All Payouts */
    protected function payouts(){
        $query = $this->conn()->prepare("SELECT * FROM payouts");
        $query->execute();
        return $this->allResults($query);
    }

    /** Get User Payouts */
    protected function payoutsUser($userId){
        $query = $this->conn()->prepare("SELECT * FROM payouts WHERE `user_id` = ?");
        $query->execute([$userId]);
        return $this->allResults($query);
    }

    /** Get User Payouts Count */
    protected function payoutsCount($userId){
        $query = $this->conn()->prepare("SELECT * FROM payouts WHERE `user_id` = ?");
        $query->execute([$userId]);
        return $query->rowCount();
    }

    /** Get All Type Payouts */
    protected function allPayoutsType($type){
        $query = $this->conn()->prepare("SELECT * FROM payouts WHERE `type` = ?");
        $query->execute([$type]);
        return $this->allResults($query);
    }

    /** Get User Type Payouts */
    protected function userPayoutsType($userId, $type){
        $query = $this->conn()->prepare("SELECT * FROM payouts WHERE `user_id` = ? AND `type` = ?");
        $query->execute([$userId, $type]);
        return $this->allResults($query);
    }

    /** Get User Payouts By Status */
    protected function userPayoutsStatus($userId, $status, $feedback){
        $query = $this->conn()->prepare("SELECT * FROM payouts WHERE `user_id` = ? AND `status` = ?");
        $query->execute([$userId, $status]);
        if($feedback == "count"){
            return $query->rowCount();
        } else if($feedback == "result") {
            return $this->allResults($query);
        }
    }

    /** Get User Type Payouts Sum */
    protected function doPayoutsTypeSum($userId, $type){
        $query = $this->conn()->prepare("SELECT SUM(amount) AS total FROM payouts WHERE `user_id` = ? AND `type` = ?");
        $query->execute([$userId, $type]);
        return $this->singleResult($query);
    }

    /** Get All Payouts by Status Sum */
    protected function allPayoutsStatusSum($status){
        $query = $this->conn()->prepare("SELECT SUM(amount) AS total FROM payouts WHERE `status` = ? AND `type` = ?");
        $query->execute([$status, "bank"]);
        return $this->singleResult($query);
    }


    /** Get All Payouts by Status */
    protected function allPayoutsStatus($status, $feedback){
        $query = $this->conn()->prepare("SELECT * FROM payouts WHERE `status` = ? AND `type` = ?");
        $query->execute([$status, "bank"]);
        if($feedback == "count"){
            return $query->rowCount();
        } else if($feedback == "result") {
            return $this->allResults($query);
        }
    }

    /** Get payout by ID */
    protected function payoutId($id){
        $query = $this->conn()->prepare("SELECT * FROM payouts WHERE id = ?");
        $query->execute([$id]);
        return $this->singleResult($query);
    }

    /** Add payout Details */
    protected function addPayout($userId, $type, $amount, $status){
        $query = $this->conn()->prepare("INSERT INTO payouts (`user_id`, `type`, amount, created_at, `status`) VALUES (?,?,?,?,?)");
        $query->execute([$userId, $type, $amount, time(), $status]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

    /** Update Payouts */
    protected function updateAccount($id, $userId, $type, $amount, $status){
        $query = $this->conn()->prepare("UPDATE payouts SET `user_id` = ?, `type` = ?, amount = ?, created_at = ?, `status` = ? WHERE id = ?");
        $query->execute([$userId, $type, $amount, time(), $status, $id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

    /** Update Payouts */
    protected function updateStatus($id, $status){
        $query = $this->conn()->prepare("UPDATE payouts SET `status` = ? WHERE id = ?");
        $query->execute([$status, $id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

    /** Delete Account by ID */
    protected function deletePayout($id){
        $query = $this->conn()->prepare("DELETE FROM payouts WHERE id = ?");
        $query->execute([$id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

}
