<?php 
    
    $invs = $investment->investmentsByStatus($userId, 'active');
    if($invs !== false){
        $invArray = [];
        foreach($invs AS $key => $invs){
            $invArray[$key]['investment'] = $invs;
            $invArray[$key]['plan'] = $plan->getPlan($invs['plan_id']);
        }
        $allInv = json_encode($invArray);
    } else {
        $allInv = json_encode(false);
    }

    if(!isset($wallet)){ $wallet = new WalletController; }
    if(!isset($referral)){ $referral = new ReferralController; }
    if(!isset($user)){ $user = new UserController; }

    $walletBalance = $wallet->walletBalance($userId);
    $bonusBalance = $wallet->bonusBalance($userId, $referral);
    
?>

<div style="margin-bottom: 20px">
    <div class="row m0">
        <div class="col-sm-4">
            <div class="wallet-card-balance">
                <span class="white-color"> WALLET BALANCE </span> <br>
                <span class="balance-text"> N<?php echo number_format($walletBalance,2) ?> </span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="wallet-card-investment">
                <span class="white-color"> INVESTMENT LEVEL </span> <br>
                    <span class="balance-text"> <?php echo $user->getUser($userId)['level']; ?> </span>
            </div>
        </div>
        <div class="col-sm-4">
            <!-- <div class="wallet-card-referral">
                <span class="white-color"> LEVEL BONUS </span> <br>
                <span class="balance-text"> N<?php echo number_format($bonusBalance,2) ?> </span>
            </div> -->
        </div>
    </div>
</div>

<script>
   
</script>