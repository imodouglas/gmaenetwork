<?php 
    include 'includes/env.inc.php';

    $userId = $userSession;
    $user = new UserController();
    $investment = new InvestmentController();
    $plan = new PlanController();
    $wallet = new WalletController();
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
                <?php
                    include 'includes/wallet-cards.inc.php';
                    require 'includes/pages/dashboard.inc.php';
                    include 'includes/modals/make-investment.inc.php';
                ?>
            </div>
        </div>
    </div>
</div>

