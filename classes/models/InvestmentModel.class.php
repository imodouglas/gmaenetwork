<?php

class InvestmentModel extends Config {

    /** Get User Investments */
    protected function userInvestments($userId, $feedback){
        $query = $this->conn()->prepare("SELECT * FROM investments WHERE `user_id` = ? ORDER BY id desc");
        $query->execute([$userId]);
        $result = $this->allResults($query);
        if($feedback == 'count'){
            return $query->rowCount();
        } else if($feedback == 'result'){
            return $result;
        }
    }

    /** Get User Current Investments */
    protected function currentInvestment($userId){
        $query = $this->conn()->prepare("SELECT * FROM investments WHERE `user_id` = ? AND is_current = ? ORDER BY id desc");
        $query->execute([$userId, "yes"]);
        $result = $this->singleResult($query);
        return $result;
    }

    /** Get User Current Investments */
    protected function levelInvestment($userId, $planId){
        $query = $this->conn()->prepare("SELECT * FROM investments WHERE `user_id` = ? AND plan_id = ? ORDER BY id desc");
        $query->execute([$userId, $planId]);
        $result = $this->singleResult($query);
        return $result;
    }

    /** Get Latest Investments */
    protected function latestInvestments($userId, $feedback){
        $query = $this->conn()->prepare("SELECT * FROM investments WHERE `user_id` = ? ORDER BY id desc LIMIT 3");
        $query->execute([$userId]);
        $result = $this->allResults($query);
        if($feedback == 'count'){
            return $query->rowCount();
        } else if($feedback == 'result'){
            return $result;
        }
    }

    /** Get All User Investments By Status */
    protected function investmentsStatus($userId, $status){
        $query = $this->conn()->prepare("SELECT * FROM investments WHERE `user_id` = ? AND status = ? ORDER BY id desc");
        $query->execute([$userId, $status]);
        return $this->allResults($query);
    }


    protected function adminInvStatus($userId, $status, $feedback){
        $query = $this->conn()->prepare("SELECT * FROM investments WHERE `user_id` = ? AND status = ? ORDER BY id desc");
        $query->execute([$userId, $status]);
        $result = $this->allResults($query);
        if($feedback == 'count'){
            return $query->rowCount();
        } else if($feedback == 'result'){
            return $result;
        }
    }

    /** Get an Investment */
    protected function investment($id){
        $query = $this->conn()->prepare("SELECT * FROM investments WHERE id = ? ORDER BY id desc");
        $query->execute([$id]);
        $result = $this->singleResult($query);
        return $result;
    }

    /** Update Investment Status */
    protected function updateInvestmentStatus($id, $status){
        $query = $this->conn()->prepare("UPDATE investments SET status = ? WHERE id = ?");
        $query->execute([$status, $id]);
        if($query){
            return true;
        } else { 
            return false;
        }
    }


    /** Complete Status */
    protected function completeInvestement($id){
        $query = $this->conn()->prepare("UPDATE investments SET is_current = ?, status = ?, completed_at = ? WHERE id = ?");
        $query->execute(["no", "complete", time(), $id]);
        if($query){
            return true;
        } else { 
            return false;
        }
    }

    /** Add Investment */
    protected function addInvestment($userId, $planId){
        $query = $this->conn()->prepare("INSERT INTO investments (user_id, plan_id, created_at, status) VALUES (?,?,?,?)");
        $query->execute([$userId, $planId, time(), 'pending']);
        if($query){
            return true;
        } else { 
            return false;
        }
    }

    /** Delete Investment */
    protected function deleteInvestment($id){
        $query = $this->conn()->prepare("DELETE FROM investments WHERE id = ?");
        $query->execute([$id]);
        if($query){
            return true;
        } else { 
            return false;
        }
    }

    /** Get all Investments */
    protected function totalInvestments($callback){
        $query = $this->conn()->prepare("SELECT * FROM investments");
        $query->execute();
        if($callback == "data"){
            $result = $this->allResults($query);
        } else if($callback == "count") {
            $result = $query->rowCount();
        } else if($callback == "total"){
            $query = $this->conn()->prepare("SELECT SUM(amount) AS total FROM `investments` a JOIN `plans` b ON a.plan_id = b.id");
            $query->execute();
            $result = $this->singleResult($query);
        }
        return $result;
    }


    /** Get all Investments by status */
    protected function totalInvestmentsStatus($status,$callback){
        $query = $this->conn()->prepare("SELECT * FROM investments WHERE status = ?");
        $query->execute([$status]);
        if($callback == "data"){
            $result = $this->allResults($query);
        } else if($callback == "count") {
            $result = $query->rowCount();
        } else if($callback == "total"){
            $query = $this->conn()->prepare("SELECT SUM(amount) AS total FROM `investments` a JOIN `plans` b ON a.plan_id = b.id WHERE a.status = ?");
            $query->execute([$status]);
            $result = $this->singleResult($query);
        }
        return $result;
    }

}