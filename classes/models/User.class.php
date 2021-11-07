<?php 

class User extends Config {

    /** Login Model */
    protected function login($email, $pword){
        $query = $this->conn()->prepare("SELECT * FROM users WHERE (email = ? OR uname = ?) AND password = ?");
        $query->execute(array($email, $email, md5($pword)));
        $data = $this->singleResult($query);
        return $data;
    }

    /** Create User Model */
    protected function createUser($password, $firstName, $lastName, $uname, $email, $phone, $level, $ref){
        $query = $this->conn()->prepare("INSERT INTO users (first_name, last_name, uname, email, phone, password, level, referrer, created_at) VALUES (?,?,?,?,?,?,?,?,?)");
        $query->execute([$firstName, $lastName, $uname, $email, $phone, md5($password), $level, $ref, time()]);
        if($query){
            return $this->conn()->lastInsertId();
        } else {
            return false;
        }
    }

    /** Update User Model */
    protected function updateUser($id, $firstName, $lastName, $email, $phone){
        $query = $this->conn()->prepare("UPDATE users SET fname=?, lname=?, email=?, phone=? WHERE id = ?");
        $query->execute([$firstName, $lastName, $email, $phone, $id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }


    /** Update User Level Model */
    protected function updateLevel($id, $level){
        $query = $this->conn()->prepare("UPDATE users SET level=? WHERE id = ?");
        $query->execute([$level, $id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }


    /** Get A User Data by Email Model */
    protected function userData($data){
        $query = $this->conn()->prepare("SELECT * FROM users WHERE email = ?");
        $query->execute([$data]);
        $data = $this->singleResult($query);
        return $data;
    }

    /** Get A User Data by Id Model */
    protected function userById($id){
        $query = $this->conn()->prepare("SELECT * FROM users WHERE id = ? OR uname = ?");
        $query->execute([$id, $id]);
        $data = $this->singleResult($query);
        return $data;
    }

    /** Get Total Number of Users Model */
    protected function totalUsers(){
        $query = $this->conn()->prepare("SELECT * FROM users");
        $query->execute();
        $data = $query->rowCount();
        return $data;
    }

    /** Get All Users Model */
    protected function allUsers(){
        $query = $this->conn()->prepare("SELECT * FROM users");
        $query->execute();
        $data = $this->allResults($query);
        return $data;
    }

    /** Check User Password */
    protected function checkPassword($id, $password){
        $query = $this->conn()->prepare("SELECT * FROM users WHERE id = ? AND password = ?");
        $query->execute([$id, $password]);
        if($query->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    /** Change User Password */
    protected function changePassword($id, $password){
        $query = $this->conn()->prepare("UPDATE users SET password = ? WHERE id = ?");
        $query->execute([$password, $id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }


    /** Update User Status Model */
    protected function updateStatus($data, $status){
        $query = $this->conn()->prepare("UPDATE users SET status = ? WHERE id = ?");
        $query->execute([$status, $data]);
        if($query){
            return true;
        } else {
            return false;
        }
    }


    /** Delete User */
    protected function deleteUser($acctNo){
        $query = $this->conn()->prepare("DELETE FROM users WHERE id = ?");
        $query->execute([$acctNo]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

    /** Create Team */
    protected function createTeam($userId, $investmentId){
        $query = $this->conn()->prepare("INSERT INTO teams (leader,investment_id) VALUES (?,?)");
        $query->execute([$userId, $investmentId]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

    /** GET Team */
    protected function readTeam($id){
        $query = $this->conn()->prepare("SELECT * FROM teams WHERE investment_id = ?");
        $query->execute([$id]);
        $result = $this->singleResult($query);
        return $result;
    }


    /** GET Team By Id */
    protected function teamById($id){
        $query = $this->conn()->prepare("SELECT * FROM teams WHERE id = ?");
        $query->execute([$id]);
        $result = $this->singleResult($query);
        return $result;
    }


    /** Update Team */
    protected function updateTeam($id, $column, $userId){
        $query = $this->conn()->prepare("UPDATE teams set $column = ? WHERE id = ?");
        $query->execute([$userId, $id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }


    /** Delete Team */
    protected function deleteTeam($id){
        $query = $this->conn()->prepare("DELETE FROM teams WHERE id = ?");
        $query->execute([$id]);
        if($query){
            return true;
        } else {
            return false;
        }
    }

    /** Current and next plan info */
    protected function currentNextPlan($userId){
        $query = $this->conn()->prepare("SELECT i.id, i.user_id, i.plan_id, i.is_current, i.status, p.id as current_plan_id, p.cash_price, @npId:=(SELECT id FROM plans WHERE id = i.plan_id + 1) AS next_plan_id, @npAmount:=(SELECT amount FROM plans WHERE id = i.plan_id + 1) AS next_plan_amount FROM investments i JOIN plans p ON i.plan_id = p.id WHERE i.user_id = ? AND i.is_current = 'yes' AND i.status = 'active'");
        $query->execute([$userId]);
        $result = $this->singleResult($query);
        return $result;
    }

    /** Check if upline is in next stage and has free space */
    protected function checkUpline($referrer, $level){
        // $query = $this->conn()->prepare("SELECT i.id FROM investments i INNER JOIN teams t ON i.id = t.investment_id WHERE i.user_id IN (SELECT id FROM users WHERE uname = ?) AND i.plan_id = ? AND i.is_current = ? AND t.leader = i.user_id AND (link1 IS NULL OR link2 IS NULL OR link3 IS NULL)");
        $query = $this->conn()->prepare("SELECT * FROM investments WHERE user_id = ? AND plan_id = ? AND status = ?");
        $query->execute([$referrer, $level, "active"]);
        $result = $this->singleResult($query);
        return $result;
    }

    /** Check if downline is in next stage*/
    protected function checkDownline($id, $level){
        $query = $this->conn()->prepare("SELECT * FROM investments WHERE user_id = ? AND plan_id = ? AND status = ?");
        $query->execute([$id, $level, "active"]);
        $result = $this->singleResult($query);
        return $result;
    }

    protected function userDownlines($uname){
        $query = $this->conn()->prepare("SELECT * FROM users WHERE referrer = ?");
        $query->execute([$uname]);
        $data = $this->allResults($query);
        return $data;
    }
}