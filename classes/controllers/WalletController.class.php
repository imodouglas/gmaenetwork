<?php

class WalletController extends PayoutController{

    public function walletBalance($userId){
        $result = ($this->payoutsTypeSum($userId, 'wallet')['total'] + $this->payoutsTypeSum($userId, 'bonus')['total']) - $this->payoutsTypeSum($userId, 'bank')['total'];
        return $result;
    }

    public function bonusBalance($userId, $referral){
        $result = ($referral->getReferrals($userId,'ref-bonus') - $referral->getReferrals($userId,'bonus'));
        return $result;
    }

}