<?php

class Referral extends Config {

    protected function getUser($userID){
        $query = $this->conn()->prepare("SELECT * FROM users WHERE id= ?");
        $query->execute([$userID]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    protected function getPlan($id){
        $query = $this->conn()->prepare("SELECT * FROM plans WHERE id= ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    protected function getInvestment($userID){
        $query = $this->conn()->prepare("SELECT * FROM investments WHERE `user_id`= ?");
        $query->execute([$userID]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    protected function refMines($userID){
        $query = $this->conn()->prepare("SELECT * FROM investments WHERE `user_id` = ? AND (`status` = ? OR `status` = ?)");
        $query->execute(array($userID, 'active', 'complete'));
        $result = $query->fetchAll();
        return $result;
    }

    protected function refPayouts($userID, $type){
        $query =$this->conn()->prepare("SELECT * FROM payouts WHERE `user_id` = ? and `type` = ?");
        $query->execute(array($userID, $type));
        $result = $query->fetchAll();
        return $result;
    }

    protected function doGetReferrals($userID, $feedback){
        $query = $this->conn()->prepare("SELECT * FROM users WHERE referrer = ?");
        $query->execute(array($userID));
        $refs = $query->fetchAll();

        if($query->rowCount() > 0){
            if($feedback == 'users'){
                $result = $refs;
            } else if($feedback == 'count'){
                $result = $query->rowCount();
            } else if($feedback == 'total'){
                $bal = 0;
                foreach($refs AS $ref){
                    $investments = $this->refMines($ref['id']);
                    if($investments !== false){
                        foreach($investments AS $invest){
                            $bal = $bal + $this->getPlan($invest['plan_id'])['amount'];
                        }
                    }
                }
                $result = $bal;
            } else if($feedback == 'ref-bonus'){
                $bal = 0;
                foreach($refs AS $ref){
                    $investments = $this->refMines($ref['id']);
                    if($investments !== false){
                        foreach($investments AS $invest){
                            $bal = $bal + $this->getPlan($invest['plan_id'])['amount'];
                        }
                    }
                }
                if($bal > 0){
                    $result = ($bal * 10)/100 ;
                } else {
                    $result = 0;
                }
            } else if($feedback == 'bonus'){
                $cashouts = $this->refPayouts($userID, 'bonus');
                $coTotal = 0;
                foreach($cashouts AS $cashout){
                    $coTotal = $coTotal + $cashout['amount'];
                }
                $result = $coTotal;
            } else if($feedback == 'bank'){
                $cashouts = $this->refPayouts($userID, 'bank');
                $coTotal = 0;
                foreach($cashouts AS $cashout){
                    $coTotal = $coTotal + $cashout['amount'];
                }
                $result = $coTotal;
            }
        } else {
            $result = 0;
        }

        return $result;
    }

}