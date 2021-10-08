<?php 

class ReferralController extends Referral{

    public function getReferrals($userID, $feedback){
        return $this->doGetReferrals($userID, $feedback);
    }

}