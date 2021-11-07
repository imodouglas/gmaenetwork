<?php

class InvestmentController extends InvestmentModel{

    /** Get User Investments */
    public function getInvestments($userId, $feedback){
        return $this->userInvestments($userId, $feedback);
    }

    /** Get Current Investments */
    public function getCurrentInvestment($userId){
        return $this->currentInvestment($userId);
    }

    /** Get Level Investments */
    public function getLevelInvestment($userId, $planId){
        return $this->levelInvestment($userId, $planId);
    }

    public function doCompleteInvestment($id){
        return $this->completeInvestement($id);
    }

    /** Get User Investments */
    public function getLatestInvestments($userId, $feedback){
        return $this->latestInvestments($userId, $feedback);
    }
    
    /** Get User Investments by Status */
    public function investmentsByStatus($userId, $status){
        return $this->investmentsStatus($userId, $status);
    }

    /** Get User Investments by Status */
    public function adminInvByStatus($userId, $status, $feedback){
        return $this->adminInvStatus($userId, $status, $feedback);
    }

    /** Get an Investment */
    public function getInvestment($id){
        return $this->investment($id);
    }

    /** Update Investment Status */
    public function doUpdateInvestmentStatus($id, $status){
        return $this->updateInvestmentStatus($id, $status);
    }

    /** Add investment */
    public function doAddInvestment($userId, $planId){
        return $this->addInvestment($userId, $planId);
    }

    /** Delete investment */
    public function doDeleteInvestment($id){
        return $this->deleteInvestment($id);
    }

    /** Get all investments */
    public function getTotalInvestments($callback){
        return $this->totalInvestments($callback);
    }

    /** Get all investments by status */
    public function getTotalInvestmentsStatus($status,$callback){
        return $this->totalInvestmentsStatus($status,$callback);
    }

}