<?php 
    include 'includes/env.inc.php';

    $userId = $userSession;
    $user = new UserController();
    $investment = new InvestmentController();
    $plan = new PlanController();
    $wallet = new WalletController();
    $mailer = new Mailer;

    $userData = $user->getUser($userId);

    $step1 = 0;
    $step2 = 0;
?>

<div class="header-home">
    <div style="padding-top:20px">
        <div class="row m0">
            <?php 
                include 'includes/sidemenu.inc.php';
            ?>
            <div class="col-sm-9">
                <?php 
                    include 'includes/wallet-cards.inc.php'; 
                ?>
                <div class="row m0">
                    <div class="col-sm-6 offset-sm-3" align="center"  style="margin-top:20px">
                        <b> SELECT A LEVEL TO VIEW </b>
                        <form action="" method="post">
                            <p>
                                <select name="investment_id" id="investment_id" class="form-control" required>
                                    <option value="">-- SELECT LEVEL --</option>
                                    <?php 
                                        foreach($investment->getInvestments($userId, 'result') AS $inv){
                                            echo "<option value='".$inv['id']."'>Level ".$inv['plan_id']."</option>";
                                        }
                                    ?>
                                </select>
                            </p>
                            <p>
                                <input type="submit" value="View Level" class="btn btn-sm btn-primary form-control" />
                            </p>
                        </form>
                    </div>
                </div>
                <?php
                    if(isset($_POST['investment_id'])){
                        $currentInvestment = $investment->getInvestment($_POST['investment_id']);
                        $currentPlan = $plan->getPlan($currentInvestment['plan_id']);
                        $walletBalance = $wallet->walletBalance($userId);
                        $currentTeam = $user->getTeam($currentInvestment['id']);
                        $refLink = rtrim($rootURL, "dashboard/")."/?ref=".$userData['uname'];
                ?>

                    
                    <div class="mb10" align="center" style="padding-top:40px; padding-bottom:40px">
                        <h3> Level <?php echo $currentInvestment['plan_id']; ?> </h3>
                        <br><br>
                        <div>
                            <i class="fa fa-street-view user-icon-active"></i>
                            <br> You (<?php echo $userData['uname'] ?>)
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
                                        $l1Investment = $investment->getLevelInvestment($currentTeam['link1'], $currentInvestment['plan_id']);
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
                                        $l2Investment = $investment->getLevelInvestment($currentTeam['link2'], $currentInvestment['plan_id']);
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
                                        $l3Investment = $investment->getLevelInvestment($currentTeam['link3'], $currentInvestment['plan_id']);
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
                                    <b> Remaining </b>
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
                                    <?php echo 3 - $step1; ?>
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
                                    <?php echo 9 - $step2; ?>
                                </div>
                            </div>
                            <div class="row m0" style="border-bottom: #f0f0f0 thin solid">
                                <div class="col-4 p10" style="background:#333; color:#fff"> Stage Reward </div>
                                <div class="col-8 p10">
                                    <?php echo "N".number_format($currentPlan['cash_price'])." cash and ".$currentPlan['item_price']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                <?php } ?>
            </div>
        </div>
    </div>
</div>

