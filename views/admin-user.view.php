<?php
    include 'includes/env.inc.php';

    $userId = $_SESSION['admin_session'];
    $user = new UserController();
    $investment = new InvestmentController();
    $plan = new PlanController();
    $payout = new PayoutController();
    $wallet = new WalletController();
    $mailer = new Mailer;

    $userData = $user->getUser($userId);
    $inv_user_id = trim($_SERVER['REQUEST_URI'], "/dashboard/admin/user/");
    $inv_user = $user->getUser($inv_user_id);
    $step1 = 0;
    $step2 = 0;

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

                <!-- SHOW USER DASHBOARD -->
                <div class="col-sm-12" style="padding-top:20px">
                    <?php 
                        if($inv_user['level'] == 0){
                    ?>
                        <div class="p10 mb10 header-title-banner" align="center">
                            <h4 class="m0"> User does not have an active investment! </h4>
                        </div>
                    <?php } else { 
                        $currentInvestment = $investment->getCurrentInvestment($inv_user_id, "result");
                        $currentPlan = $plan->getPlan($currentInvestment['plan_id']);
                        $walletBalance = $wallet->walletBalance($inv_user_id);
                        
                        if($currentInvestment['status'] == "pending"){
                    ?>
                        <div class="p10 mb10 header-title-banner" align="center">
                            <h4 class="m0"> User has an investment that is pending activation! </h4>
                        </div>
                        <?php } else { 
                            $currentTeam = $user->getTeam($currentInvestment['id']);
                            $refLink = rtrim($rootURL, "dashboard/")."/?ref=".$inv_user['uname'];
                        ?>
                            <div class="p10 mb10 header-title-banner">
                                <b> Referral Link: </b> <a href="<?php echo $refLink; ?>" style="color:#369"> <?php echo $refLink; ?> </a>
                            </div>
                            <div class="mb10" align="center" style="padding-top:40px; padding-bottom:40px">
                                <div>
                                    <i class="fa fa-street-view user-icon-active"></i>
                                    <br> You (<?php echo $inv_user['uname'] ?>)
                                    <br> |
                                </div>
                                <div class="row p10">
                                    <div class="col-4">
                                        <div class="row" style="margin-bottom:5px">
                                            <div class="col-6"></div>
                                            <div class="col-6" style="border-top:#333 thin solid"></div>
                                        </div>
                                        <?php 
                                            if($currentTeam['link1'] !== NULL){
                                                $step1 = $step1 + 1;
                                                $link1 = $user->getUser($currentTeam['link1']);
                                                echo "<i class='fa fa-street-view user-icon-active' id='".$link1['uname']."' onclick='getRefLink(this.id)'></i> <br> ".$link1['uname'];
                                            } else {
                                                echo "<i class='fa fa-street-view user-icon-inactive'></i> <br> Not set";
                                            }
                                        ?>
                                        <br> |
                                        <?php 
                                            if($currentTeam['link1'] !== NULL){
                                                $l1Investment = $investment->getCurrentInvestment($currentTeam['link1']);
                                                if($l1Investment !== false){
                                                    $l1Team = $user->getTeam($l1Investment['id']);
                                        ?>
                                            <div>
                                                <div class="row p10">
                                                    <div class="col-4">
                                                        <div class="row" style="margin-bottom:5px">
                                                            <div class="col-6"></div>
                                                            <div class="col-6" style="border-top:#333 thin solid"></div>
                                                        </div>
                                                        <?php 
                                                            if($l1Team['link1'] !== NULL){
                                                                $step2 = $step2 + 1;
                                                                $link1 = $user->getUser($l1Team['link1']);
                                                                echo "<i class='fa fa-street-view user-icon-active' id='".$link1['uname']."' onclick='getRefLink(this.id)'></i> <br> ".$link1['uname'];
                                                            } else {
                                                                echo "<i class='fa fa-street-view user-icon-inactive'></i> <br> Not set";
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="row" style="margin-bottom:5px">
                                                            <div class="col-6" style="border-top:#333 thin solid"></div>
                                                            <div class="col-6" style="border-top:#333 thin solid"></div>
                                                        </div>
                                                        <?php 
                                                            if($l1Team['link2'] !== NULL){
                                                                $step2 = $step2 + 1;
                                                                $link2 = $user->getUser($l1Team['link2']);
                                                                echo "<i class='fa fa-street-view user-icon-active' id='".$link2['uname']."' onclick='getRefLink(this.id)'></i> <br> ".$link2['uname'];
                                                            } else {
                                                                echo "<i class='fa fa-street-view user-icon-inactive'></i> <br> Not set";
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="row" style="margin-bottom:5px">
                                                            <div class="col-6" style="border-top:#333 thin solid"></div>
                                                            <div class="col-6"></div>
                                                        </div>
                                                        <?php 
                                                            if($l1Team['link3'] !== NULL){
                                                                $step2 = $step2 + 1;
                                                                $link3 = $user->getUser($l1Team['link3']);
                                                                echo "<i class='fa fa-street-view user-icon-active' id='".$link3['uname']."' onclick='getRefLink(this.id)'></i> <br> ".$link3['uname'];
                                                            } else {
                                                                echo "<i class='fa fa-street-view user-icon-inactive'></i> <br> Not set";
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } } else { echo "<br> No active team yet!"; } ?>
                                    </div>
                                    <div class="col-4">
                                        <div class="row" style="margin-bottom:5px">
                                            <div class="col-6" style="border-top:#333 thin solid"></div>
                                            <div class="col-6" style="border-top:#333 thin solid"></div>
                                        </div>
                                        <?php 
                                            if($currentTeam['link2'] !== NULL){
                                                $step1 = $step1 + 1;
                                                $link2 = $user->getUser($currentTeam['link2']);
                                                echo "<i class='fa fa-street-view user-icon-active' id='".$link2['uname']."' onclick='getRefLink(this.id)'></i> <br> ".$link2['uname'];
                                            } else {
                                                echo "<i class='fa fa-street-view user-icon-inactive'></i> <br> Not set";
                                            }
                                        ?>
                                        <br> |
                                        <?php 
                                            if($currentTeam['link2'] !== NULL){
                                                $l2Investment = $investment->getCurrentInvestment($currentTeam['link2']);
                                                if($l2Investment !== false){
                                                    $l2Team = $user->getTeam($l2Investment['id']);
                                        ?>
                                            <div>
                                                <div class="row p10">
                                                    <div class="col-4">
                                                        <div class="row" style="margin-bottom:5px">
                                                            <div class="col-6"></div>
                                                            <div class="col-6" style="border-top:#333 thin solid"></div>
                                                        </div>
                                                        <?php 
                                                            if($l2Team['link1'] !== NULL){
                                                                $step2 = $step2 + 1;
                                                                $link1 = $user->getUser($l2Team['link1']);
                                                                echo "<i class='fa fa-street-view user-icon-active' id='".$link1['uname']."' onclick='getRefLink(this.id)'></i> <br> ".$link1['uname'];
                                                            } else {
                                                                echo "<i class='fa fa-street-view user-icon-inactive'></i> <br> Not set";
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="row" style="margin-bottom:5px">
                                                            <div class="col-6" style="border-top:#333 thin solid"></div>
                                                            <div class="col-6" style="border-top:#333 thin solid"></div>
                                                        </div>
                                                        <?php 
                                                            if($l2Team['link2'] !== NULL){
                                                                $step2 = $step2 + 1;
                                                                $link2 = $user->getUser($l2Team['link2']);
                                                                echo "<i class='fa fa-street-view user-icon-active' id='".$link2['uname']."' onclick='getRefLink(this.id)'></i> <br> ".$link2['uname'];
                                                            } else {
                                                                echo "<i class='fa fa-street-view user-icon-inactive'></i> <br> Not set";
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="row" style="margin-bottom:5px">
                                                            <div class="col-6" style="border-top:#333 thin solid"></div>
                                                            <div class="col-6"></div>
                                                        </div>
                                                        <?php 
                                                            if($l2Team['link3'] !== NULL){
                                                                $step2 = $step2 + 1;
                                                                $link3 = $user->getUser($l2Team['link3']);
                                                                echo "<i class='fa fa-street-view user-icon-active' id='".$link3['uname']."' onclick='getRefLink(this.id)'></i> <br> ".$link3['uname'];
                                                            } else {
                                                                echo "<i class='fa fa-street-view user-icon-inactive'></i> <br> Not set";
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } } else { echo "<br> No active team yet!"; } ?>
                                    </div>
                                    <div class="col-4">
                                        <div class="row" style="margin-bottom:5px">
                                            <div class="col-6" style="border-top:#333 thin solid"></div>
                                            <div class="col-6"></div>
                                        </div>
                                        <?php 
                                            if($currentTeam['link3'] !== NULL){
                                                $step1 = $step1 + 1;
                                                $link3 = $user->getUser($currentTeam['link3']);
                                                echo "<i class='fa fa-street-view user-icon-active' id='".$link3['uname']."' onclick='getRefLink(this.id)'></i> <br> ".$link3['uname'];
                                            } else {
                                                echo "<i class='fa fa-street-view user-icon-inactive'></i> <br> Not set";
                                            }
                                        ?>
                                        <br> |
                                        <?php 
                                            if($currentTeam['link3'] !== NULL){
                                                $l3Investment = $investment->getCurrentInvestment($currentTeam['link3']);
                                                if($l3Investment !== false){
                                                    $l3Team = $user->getTeam($l3Investment['id']);
                                        ?>
                                            <div>
                                                <div class="row p10">
                                                    <div class="col-4">
                                                        <div class="row" style="margin-bottom:5px">
                                                            <div class="col-6"></div>
                                                            <div class="col-6" style="border-top:#333 thin solid"></div>
                                                        </div>
                                                        <?php 
                                                            if($l3Team['link1'] !== NULL){
                                                                $step2 = $step2 + 1;
                                                                $link1 = $user->getUser($l3Team['link1']);
                                                                echo "<i class='fa fa-street-view user-icon-active' id='".$link1['uname']."' onclick='getRefLink(this.id)'></i> <br> ".$link1['uname'];
                                                            } else {
                                                                echo "<i class='fa fa-street-view user-icon-inactive'></i> <br> Not set";
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="row" style="margin-bottom:5px">
                                                            <div class="col-6" style="border-top:#333 thin solid"></div>
                                                            <div class="col-6" style="border-top:#333 thin solid"></div>
                                                        </div>
                                                        <?php 
                                                            if($l3Team['link2'] !== NULL){
                                                                $step2 = $step2 + 1;
                                                                $link2 = $user->getUser($l3Team['link2']);
                                                                echo "<i class='fa fa-street-view user-icon-active' id='".$link2['uname']."' onclick='getRefLink(this.id)'></i> <br> ".$link2['uname'];
                                                            } else {
                                                                echo "<i class='fa fa-street-view user-icon-inactive'></i> <br> Not set";
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="row" style="margin-bottom:5px">
                                                            <div class="col-6" style="border-top:#333 thin solid"></div>
                                                            <div class="col-6"></div>
                                                        </div>
                                                        <?php 
                                                            if($l3Team['link3'] !== NULL){
                                                                $step2 = $step2 + 1;
                                                                $link3 = $user->getUser($l3Team['link3']);
                                                                echo "<i class='fa fa-street-view user-icon-active' id='".$link3['uname']."' onclick='getRefLink(this.id)'></i> <br> ".$link3['uname'];
                                                            } else {
                                                                echo "<i class='fa fa-street-view user-icon-inactive'></i> <br> Not set";
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } } else { echo "<br> No active team yet!"; } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="p10" align="center">
                                <h3> Level Summary </h3>
                                <div>
                                    <div class="row m0">
                                        <div class="col-3 p10" style="background: #f0f0f0; border-bottom: #fff thin solid"> 
                                            <b> Step </b>
                                        </div>
                                        <div class="col-4 p10" style="background: #f0f0f0; border-bottom: #fff thin solid"> 
                                            <b> Downlines </b>
                                        </div>
                                        <div class="col-5 p10" style="background: #f0f0f0; border-bottom: #fff thin solid"> 
                                            <b> Bonus </b>
                                        </div>
                                    </div>
                                    <div class="row m0">
                                        <div class="col-3 p10" style="border-bottom: #f0f0f0 thin solid"> 
                                            1
                                        </div>
                                        <div class="col-4 p10" style="border-bottom: #f0f0f0 thin solid"> 
                                            <?php echo $step1; ?>
                                        </div>
                                        <div class="col-5 p10" style="border-bottom: #f0f0f0 thin solid"> 
                                            <?php if($step1 < 3){ echo "N0.00"; } else { echo "N".number_format((($currentPlan['amount'] * $currentPlan['stage1_roi'])/100), 2); } ?>
                                        </div>
                                    </div>
                                    <div class="row m0">
                                        <div class="col-3 p10" style="border-bottom: #f0f0f0 thin solid"> 
                                            2
                                        </div>
                                        <div class="col-4 p10" style="border-bottom: #f0f0f0 thin solid"> 
                                            <?php echo $step2; ?>
                                        </div>
                                        <div class="col-5 p10" style="border-bottom: #f0f0f0 thin solid"> 
                                            <?php if($step2 < 9){ echo "N0.00"; } else { echo "N".number_format((($currentPlan['amount'] * $currentPlan['stage2_roi'])/100), 2); } ?>
                                        </div>
                                    </div>
                                    <?php if($step1 == 3 && $step2 == 9){ ?>
                                        <div class="p10" align="center" style="margin-top:30px">
                                            <button class="btn btn-primary"> <i class="fas fa-arrow-up"></i>&nbsp; Upgrade to Level <?php echo $inv_user['level'] + 1; ?> </button>
                                            <button class="btn btn-danger"> End & Take Profit &nbsp;<i class="fas fa-sign-out-alt"></i> </button>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>