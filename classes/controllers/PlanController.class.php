<?php 

class PlanController extends PlanModel {

    /** Get all plans */
    public function getPlans($status){
        return $this->userPlans($status);
    }

    /** Get plan by ID */
    public function getPlan($id){
        return $this->plan($id);
    }
}