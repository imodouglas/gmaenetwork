<?php 
    $step1 = 0;
    $step2 = 0;
?>
<div class="row m0" style="padding-bottom:70px">
    <div class="col-sm-12">
        <?php 
            if($userData['level'] == 0){
        ?>
            <div class="p10 mb10 header-title-banner" align="center">
                <h3 class="m0"> You are one step away! </h3>
                <p style="margin-top:15px">
                    Your journey to financial freedom is one step away. Simply select a plan level to continue. <br>
                    Want to know more on how it work? <a href="#"> Know More... </a>
                </p>
                <p>
                    <button class="btn btn-primary" onclick="showPlans()"> Start Level &nbsp;<i class="fas fa-arrow-right"></i> </button>
                </p>
            </div>
        <?php } else { 
            $currentInvestment = $investment->getCurrentInvestment($userId, "result");
            $currentPlan = $plan->getPlan($currentInvestment['plan_id']);
            $walletBalance = $wallet->walletBalance($userId);
            
            if($currentInvestment['status'] == "pending"){
        ?>
            <div class="p10 mb10 header-title-banner" align="center">
                <h3 class="m0"> Well Done! <br> It's time to active your Level. </h3>
                <p style="margin-top:15px">
                    <p> You are to pay the sum of N<?php echo number_format($currentPlan['amount']); ?> to activate your level and start growing your Network. </p>
                </p>
                <p>
                    <?php if($walletBalance > $currentPlan['amount']){ ?>
                        <button class="btn btn-primary" onclick="payment.wallet(<?php echo $currentPlan['amount']; ?>)"> Pay From Wallet &nbsp;<i class="fas fa-arrow-right"></i> </button>
                    <?php } ?>
                    <button class="btn btn-primary" onclick="payment.card('<?php echo $userId; ?>', '<?php echo $currentPlan['amount']; ?>', '<?php echo $userData['email']; ?>', '<?php echo $userData['first_name']; ?>')"> Pay With Cash/Card &nbsp;<i class="fas fa-arrow-right"></i> </button>
                    <button class="btn btn-primary" onclick="investment.confirm('<?php echo $userId; ?>')"> Activate Free &nbsp;<i class="fas fa-arrow-right"></i> </button>
                </p>
            </div>
            <?php } else { 
                $currentTeam = $user->getTeam($currentInvestment['id']);
                $refLink = rtrim($rootURL, "dashboard/")."/?ref=".$userData['uname'];
            ?>
                <div class="p10 mb10 header-title-banner">
                    <b> Referral Link: </b> <a href="<?php echo $refLink; ?>" style="color:#369"> <?php echo $refLink; ?> </a>
                </div>
                <div class="mb10" align="center" style="padding-top:40px; padding-bottom:40px">
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
                                    echo "<i class='fa fa-street-view user-icon-active'></i> <br> ".$link1['uname'];
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
                                                    echo "<i class='fa fa-street-view user-icon-active'></i> <br> ".$link1['uname'];
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
                                                    echo "<i class='fa fa-street-view user-icon-active'></i> <br> ".$link2['uname'];
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
                                                    echo "<i class='fa fa-street-view user-icon-active'></i> <br> ".$link3['uname'];
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
                                    echo "<i class='fa fa-street-view user-icon-active'></i> <br> ".$link2['uname'];
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
                                                    echo "<i class='fa fa-street-view user-icon-active'></i> <br> ".$link1['uname'];
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
                                                    echo "<i class='fa fa-street-view user-icon-active'></i> <br> ".$link2['uname'];
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
                                                    echo "<i class='fa fa-street-view user-icon-active'></i> <br> ".$link3['uname'];
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
                                    echo "<i class='fa fa-street-view user-icon-active'></i> <br> ".$link3['uname'];
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
                                                    echo "<i class='fa fa-street-view user-icon-active'></i> <br> ".$link1['uname'];
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
                                                    echo "<i class='fa fa-street-view user-icon-active'></i> <br> ".$link2['uname'];
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
                                                    echo "<i class='fa fa-street-view user-icon-active'></i> <br> ".$link3['uname'];
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
                                <!-- <?php if($step1 < 3){ echo "N0.00"; } else { "N".number_format((($currentPlan['amount'] * $currentPlan['stage1_roi'])/100), 2); } ?> -->
                                <?php if($step1 < 3){ echo "N0.00"; } else { "N".number_format($currentPlan['amount'], 2); } ?>
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
                                <?php if($step2 < 9){ echo "N0.00"; } else { "N".number_format((($currentPlan['amount'] * $currentPlan['stage2_roi'])/100), 2); } ?>
                            </div>
                        </div>
                        <?php if($step1 == 3 && $step2 == 9){ ?>
                            <div class="p10" align="center" style="margin-top:30px">
                                <button class="btn btn-primary"> <i class="fas fa-arrow-up"></i>&nbsp; Upgrade to Level <?php echo $userData['level'] + 1; ?> </button>
                                <button class="btn btn-danger"> End & Take Profit &nbsp;<i class="fas fa-sign-out-alt"></i> </button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

        <?php } ?>
    </div>
</div>

<div id="select-plan" style="display:none">
    <div style="position:fixed; top:0; left:0; width:100%; height:100vh; z-index:10000; background:#000; opacity:0.8"></div>
    <div style="position:fixed; top:20vh; left:0; width:100%; z-index:10010;" align="center">
        <div style="width:90%; max-width:500px; height:500px; overflow-y:scroll; padding:20px; background:#fcfcfc; border:#ccc thin solid; border-radius:3px; box-shadow:#000 0px 0px 8px" align="left">
            <button style="padding:3px 10px; background:#ccc; float:right; margin-top:-10px; margin-right:-10px" onclick="showPlans()" > <i class="fa fa-times"></i></button>
            <div style="margin-bottom:10px;" class="cm-primary-color" align="center"> <b> SELECT A LEVEL </b> </div>
            <?php 
                foreach($plan->getPlans("active") AS $plan){
            ?>
                <div class="row header-title-banner" style="padding:10px;" align="left">
                    <div class="col-9">
                        <div class="row">
                            <div class="col-sm-4">
                                <span style="font-size:12px; color:#369">Plan</span> <br>
                                <?php echo $plan['name']; ?>
                            </div>
                            <div class="col-sm-4">
                                <span style="font-size:12px; color:#369">Amount</span> <br>
                                <?php echo "N".number_format($plan['amount']); ?>
                            </div>
                            <div class="col-sm-4">
                                <span style="font-size:12px; color:#369">ROI</span> <br>
                                <?php echo "N".number_format($plan['amount'] * ($plan['stage2_roi'] / 100)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 pt10" align="right">
                        <button class="btn btn-sm btn-primary white-color" onclick="upgradePlan(<?php echo $userId; ?>, <?php echo $plan['id']; ?>)"> Select </button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script src="https://checkout.flutterwave.com/v3.js"></script>
<script src="includes/scripts/payments.js"></script>
<script>
    const showPlans = () => {
        $("#select-plan").slideToggle("slow")
    }

    const upgradePlan = (userId, planId) => {
        let formData = "cmd=upgrade-level&user="+userId+"&level="+planId
        $.post("api.php", formData, (data)=>{
            if(data == true){
                location.reload()
            } else {
                alert("There was an error! Please try again.")
            }
        });
        // console.log("data");
    }
</script>