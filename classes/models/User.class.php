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
        $query = $this->conn()->prepare("SELECT * FROM teams WHERE id = ? OR investment_id = ?");
        $query->execute([$id, $id]);
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

}