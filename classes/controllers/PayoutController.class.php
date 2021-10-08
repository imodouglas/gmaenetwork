<?php 

class PayoutController extends PayoutModel{

    /** Get all payouts */
    public function allPayouts(){
        return $this->payouts();
    }

    /** Get User Payouts */
    public function userPayouts($userId){
        return $this->payoutsUser($userId);
    }

    /** Get User Payouts Count */
    public function userPayoutsCount($userId){
        return $this->payoutsCount($userId);
    }

    public function payoutsByStatus($userId, $status, $feedback){
        return $this->userPayoutsStatus($userId, $status, $feedback);
    }

    public function payoutsSumStatus($status){
        return $this->allPayoutsStatusSum($status);
    }


    public function payoutsStatus($status, $feedback){
        return $this->allPayoutsStatus($status, $feedback);
    }

    /** Get All Type Payouts */
    public function allPayoutsByType($type){
        return $this->allPayoutsType($type);
    }

    /** Get User Payouts by Type */
    public function getUserPayoutsType($userId, $type){
        return $this->userPayoutsType($userId, $type);
    }

    /** Get User Type Payouts Sum */
    public function payoutsTypeSum($userId, $type){
        return $this->doPayoutsTypeSum($userId, $type);
    }

    /** Get Payout by Id */
    public function payout($id){
        return $this->payoutId($id);
    }

    /** Add Payouts */
    public function doAddPayout($userId, $type, $amount, $status){
        return $this->addPayout($userId, $type, $amount, $status);
    }

    /** Update Payout */
    public function doUpdatePayout($id, $userId, $type, $amount, $status){
        return $this->updateAccount($id, $userId, $type, $amount, $status);
    }

    /** Update Payout Status */
    public function doUpdateStatus($id, $status){
        return $this->updateStatus($id, $status);
    }

    /** Delete Payout */
    public function doDeletePayout($id){
        return $this->deletePayout($id);
    }

}