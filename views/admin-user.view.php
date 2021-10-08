<?php
    include 'includes/env.inc.php';

    $userId = $_SESSION['admin_session'];
    $user = new UserController();
    $investment = new InvestmentController();
    $plan = new PlanController();
    $payout = new PayoutController();
    $mailer = new Mailer;

    $userData = $user->getUser($userId);
    $inv_user_id = trim($_SERVER['REQUEST_URI'], "/dashboard/admin/user/");
    $inv_user = $user->getUser($inv_user_id);

    function sumInvestments($investments, $plan){
        $sum = 0;
        if(is_array($investments)){
            foreach ($investments AS $inv){
                $amount = $plan->getPlan($inv['plan_id'])['amount'];
                $sum = $sum + $amount;
            }
        }
        return $sum;
    }

    function sumPayouts($payouts, $payout){
        $sum = 0;
        if(is_array($payouts)){
            foreach ($payouts AS $pay){
                $sum = $sum + $pay['amount'];
            }
        }
        return $sum;
    }
?>

<div class="header-home">
    <div style="padding-top:20px">
        <div class="row m0">
            <?php 
                include 'includes/sidemenu.inc.php';
            ?>
            <div class="col-sm-9">
                <div class="p10 header-gray-banner" style="margin-top:10px; margin-bottom:20px">
                    <h3 class="m0"> <?php echo $inv_user['first_name']." ".$inv_user['last_name']." Summary" ?> </h3>
                </div>
                <div class="row" style="margin:0; margin-bottom:20px">
                    <div class="col-sm-4">
                        <div class="wallet-card-investment">
                            <span class="white-color"> TOTAL INVESTMENTS </span> <br>
                            <span class="balance-text" id="inv-balance"> N<?php echo number_format(sumInvestments($investment->getInvestments($inv_user_id, "result"), $plan),2); ?> </span> <br>
                            <span class="white-color"> <?php echo number_format($investment->getInvestments($inv_user_id, "count")); ?> Investment </span> <br>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="wallet-card-referral">
                            <span class="white-color"> TOTAL PAYOUTS </span> <br>
                            <span class="balance-text" id="inv-balance"> N<?php echo number_format(sumPayouts($payout->userPayouts($inv_user_id), $payout),2); ?> </span> <br>
                            <span class="white-color"> <?php echo number_format($payout->payoutsByStatus($inv_user_id, "pending", "count")); ?> Pending, <?php echo number_format($payout->payoutsByStatus($inv_user_id, "complete", "count")); ?> Complete  </span> <br>
                        </div>
                    </div>
                </div>

                <div class="row m0">
                    <div class="col-sm-4">
                        <div class="wallet-card-investment">
                            <span class="white-color"> ACTIVE INVESTMENTS </span> <br>
                            <span class="balance-text"> N<?php echo number_format(sumInvestments($investment->adminInvByStatus($inv_user_id,"active", "result"),$plan),2); ?> </span> <br>
                            <span class="white-color"> <?php echo number_format($investment->adminInvByStatus($inv_user_id,"active","count"))  ?> Investments </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="wallet-card-balance">
                            <span class="white-color"> PENDING INVESTMENTS </span> <br>
                            <span class="balance-text"> N<?php echo number_format(sumInvestments($investment->adminInvByStatus($inv_user_id,"pending", "result"),$plan),2); ?> </span> <br>
                            <span class="white-color"> <?php echo number_format($investment->adminInvByStatus($inv_user_id,"pending","count"))  ?> Investments </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="wallet-card-complete">
                            <span class="white-color"> COMPLETED INVESTMENTS </span> <br>
                            <span class="balance-text"> N<?php echo number_format(sumInvestments($investment->adminInvByStatus($inv_user_id,"complete", "result"),$plan),2); ?> </span> <br>
                            <span class="white-color"> <?php echo number_format($investment->adminInvByStatus($inv_user_id,"complete","count"))  ?> Investments </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>