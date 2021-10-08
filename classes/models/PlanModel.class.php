<?php 

class PlanModel extends Config {

    /** Get all plans */
    protected function userPlans($status){
        $query = $this->conn()->prepare("SELECT * FROM plans WHERE status = ?");
        $query->execute([$status]);
        return $this->allResults($query);
    }

    /** Get plan by ID */
    protected function plan($id){
        $query = $this->conn()->prepare("SELECT * FROM plans WHERE id = ?");
        $query->execute([$id]);
        return $this->singleResult($query);
    }

}
