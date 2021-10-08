<?php 

class LevelModel extends Config {

    protected function allData(){
        $query = $this->conn()->prepare("SELECT * FROM levels");
        $query->execute();
        return $this->allResults($query);
    }

    protected function singleData($id){
        $query = $this->conn()->prepare("SELECT * FROM levels WHERE id = ?");
        $query->execute([$id]);
        return $this->singleResult($query);
    }

    protected function addData(){
        
    }

}