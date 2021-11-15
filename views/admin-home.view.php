<?php 
    include 'includes/env.inc.php';

    $userId = $userSession;
    $user = new UserController();
    $investment = new InvestmentController();
    $plan = new PlanController();
    $mailer = new Mailer;

    $userData = $user->getUser($userId);

?>

<div class="header-home">
    <div style="padding-top:20px">
        <div class="row m0">
            <?php 
                include 'includes/sidemenu.inc.php';
            ?>
            <div class="col-sm-9">
                <div class="row m0">
                    <div class="col-sm-4">
                        <div class="wallet-card-balance">
                            <span class="white-color"> TOTAL USERS </span> <br>
                            <span class="balance-text"> <?php echo number_format($user->getTotalUsers()); ?> </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="wallet-card-referral">
                            <span class="white-color"> NUMBER OF INVESTMENTS </span> <br>
                            <span class="balance-text" id="inv-balance"> <?php echo number_format($investment->getTotalInvestments("count")); ?> </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="wallet-card-investment">
                            <span class="white-color"> TOTAL INVESTMENTS </span> <br>
                            <span class="balance-text" id="inv-balance"> N<?php echo number_format($investment->getTotalInvestments("total")['total'],2); ?> </span>
                        </div>
                    </div>
                </div>

                <div class="row m0">
                    <div class="col-sm-4">
                        <div class="wallet-card-investment">
                            <span class="white-color"> ACTIVE INVESTMENTS </span> <br>
                            <span class="balance-text"> N<?php echo number_format($investment->getTotalInvestmentsStatus("active","total")['total'],2); ?> </span> <br>
                            <span class="white-color"> <?php echo number_format($investment->getTotalInvestmentsStatus("active","count"));  ?> Investments </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="wallet-card-balance">
                            <span class="white-color"> PENDING INVESTMENTS </span> <br>
                            <span class="balance-text"> N<?php echo number_format($investment->getTotalInvestmentsStatus("pending","total")['total'],2); ?> </span> <br>
                            <span class="white-color"> <?php echo number_format($investment->getTotalInvestmentsStatus("pending","count"));  ?> Investments </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="wallet-card-complete">
                            <span class="white-color"> COMPLETED INVESTMENTS </span> <br>
                            <span class="balance-text"> N<?php echo number_format($investment->getTotalInvestmentsStatus("complete","total")['total'],2); ?> </span> <br>
                            <span class="white-color"> <?php echo number_format($investment->getTotalInvestmentsStatus("complete","count"));  ?> Investments </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

