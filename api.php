<?php
    header('Content-Type: application/json');
    session_start();
    require 'includes/env.inc.php';

    // if(!isset($_SESSION['user_session']) || !isset($_SESSION['admin_session'])){
    //     header("Location: ./");
    // }

    spl_autoload_register('autoloader');

    function autoloader($class){
        $dir = array('classes/controllers/', 'classes/models/', 'classes/database/');
        $ext = '.class.php';

        foreach($dir as $dir){
            $path = $dir.$class.$ext;
            if(file_exists($path)){
                include $path;
            }
        }
    }
    

    $user = new UserController();
    $investment = new InvestmentController();
    $plan = new PlanController();
    $payout = new PayoutController();
    $account = new AccountController();
    $mailer = new Mailer;

    if(isset($_POST['cmd'], $_POST['user'], $_POST['level']) && $_POST['cmd'] == "upgrade-level"){
        if($user->doUpdateLevel($_POST['user'], $plan->getPlan($_POST['level'])['level_no']) == true){
            $result = $investment->doAddInvestment($_POST['user'], $_POST['level']);
        } else {
            $result = false;
        }
        echo json_encode($result);
    }
    

    if(isset($_POST['userid'], $_POST['plan'], $_POST['cmd']) && $_POST['cmd'] == "make-investment"){
        $planData = $plan->getPlan($_POST['plan']);
        if($planData !== false) {
            $expires = strtotime('+'.$planData['days'].' days');
            $result = $investment->doAddInvestment($_POST['userid'], $_POST['plan'], $expires);
            if($result == true){
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(false);
        } 
    }

    if(isset($_POST['investment'], $_POST['cmd']) && $_POST['cmd'] == "data"){
        $data = [];
        $inv = $investment->getInvestment($_POST['investment']);
        if($inv !== false){
            $plan = $plan->getPlan($inv['plan_id']);
            $userData = $user->getUser($inv['user_id']);
            $data['investment'] = $inv;
            $data['plan'] = $plan;
            $data['user'] = $userData;
            // echo json_encode($plan->getPlan($inv['plan_id']));
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }
    }

    if(isset($_POST['current-investment'], $_POST['cmd']) && ($_POST['cmd'] == "confirm" || $_POST['cmd'] == "pending")){
        $inv = $investment->getCurrentInvestment($_POST['current-investment']);
        if($inv !== false){
            $plan = $plan->getPlan($inv['plan_id']);
            if($_POST['cmd'] == "confirm"){ 
                $userData = $user->getUser($userSession);
                $referrer = $user->getUser($userData['referrer']);
                $refInvestment = $investment->getCurrentInvestment($referrer['id']);
                if($refInvestment !== false){
                    $refTeam = $user->getTeam($refInvestment['id']);
                    if($refTeam['link1'] == NULL){
                        $rData = $user->doUpdateTeam($refTeam['id'], 'link1', $userData['id']);
                    } else if($refTeam['link2'] == NULL){
                        $rData = $user->doUpdateTeam($refTeam['id'], 'link2', $userData['id']);
                    } else if($refTeam['link3'] == NULL){
                        $rData = $user->doUpdateTeam($refTeam['id'], 'link3', $userData['id']);
                    }
                    $team = $user->doCreateTeam($userSession, $inv['id']);
                    if($team == true){
                        $status = "active"; 
                        $invUp = $investment->doUpdateInvestmentStatus($inv['id'], $status);
                        if($invUp !== false){
                            echo json_encode(true);
                        } else {
                            echo json_encode(false);
                        }
                    }
                } else {
                    $status = "active"; 
                    $team = $user->doCreateTeam($userSession, $inv['id']);
                    if($team == true){
                        $status = "active"; 
                        $invUp = $investment->doUpdateInvestmentStatus($inv['id'], $status);
                        if($invUp !== false){
                            echo json_encode(true);
                        } else {
                            echo json_encode(false);
                        }
                    }
                }
            } else if($_POST['cmd'] == "pending") { 
                $status = "pending"; 
            }
        } else {
            echo json_encode(false);
        }
    }

    if(isset($_POST['investment'], $_POST['cmd']) && ($_POST['cmd'] == "confirm" || $_POST['cmd'] == "pending")){
        $inv = $investment->getInvestment($_POST['investment']);
        if($inv !== false){
            $plan = $plan->getPlan($inv['plan_id']);
            if($_POST['cmd'] == "confirm"){ 
                $userData = $user->getUser($userSession);
                $referrer = $user->getUser($userData['referrer']);
                $refInvestment = $investment->getCurrentInvestment($referrer['id']);
                if($refInvestment !== false){
                    $refTeam = $user->getTeam($refInvestment['id']);
                    if($refTeam['link1'] == NULL){
                        $rData = $user->doUpdateTeam($refTeam['id'], 'link1', $userData['id']);
                    } else if($refTeam['link2'] == NULL){
                        $rData = $user->doUpdateTeam($refTeam['id'], 'link2', $userData['id']);
                    } else if($refTeam['link3'] == NULL){
                        $rData = $user->doUpdateTeam($refTeam['id'], 'link3', $userData['id']);
                    }
                    $team = $user->doCreateTeam($userSession, $inv['id']);
                    if($team == true){
                        $status = "active"; 
                        $invUp = $investment->doUpdateInvestmentStatus($inv['id'], $status);
                        if($invUp !== false){
                            echo json_encode(true);
                        } else {
                            echo json_encode(false);
                        }
                    }
                } else {
                    $status = "active"; 
                    $team = $user->doCreateTeam($userSession, $inv['id']);
                    if($team == true){
                        $status = "active"; 
                        $invUp = $investment->doUpdateInvestmentStatus($inv['id'], $status);
                        if($invUp !== false){
                            echo json_encode(true);
                        } else {
                            echo json_encode(false);
                        }
                    }
                }
            } else if($_POST['cmd'] == "pending") { 
                $status = "pending"; 
            }
        } else {
            echo json_encode(false);
        }
    }

    if(isset($_POST['investment'], $_POST['cmd']) && $_POST['cmd'] == "complete"){
        $inv = $investment->getInvestment($_POST['investment']);
        if($inv !== false){
            $plan = $plan->getPlan($inv['plan_id']);
            $amount = $plan['amount'] + (($plan['amount'] * $plan['percentage']) / 100);
            $payout = $payout->doAddPayout($_SESSION['user_session'], "wallet", $amount, "complete");
            if($payout == true){
                $invUp = $investment->doUpdateInvestmentStatus($inv['id'], 'complete', $inv['activated_at'], $inv['expires_at']);
                echo json_encode($invUp);
            } else {
                echo json_encode(false);    
            }
        } else {
            echo json_encode(false);
        }
    }


    if(isset($_POST['investment'], $_POST['cmd']) && $_POST['cmd'] == "delete"){
        $result = $investment->doDeleteInvestment($_POST['investment']);
        if($result == true){
            echo json_encode(true);
        } else {
            echo json_encode(false);
        } 
    }

    if(isset($_POST['cmd']) && $_POST['cmd'] == "add-account"){
        $result = $account->doAddAccount($_POST['userid'], $_POST['bank'], $_POST['acctName'], $_POST['acctNo']);
        if($result == true){
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    if(isset($_POST['id'], $_POST['status'], $_POST['cmd']) && $_POST['cmd'] == "payout-complete"){
        $result = $payout->doUpdateStatus($_POST['id'], $_POST['status']);
        if($result == true && $_POST['status'] == "complete"){
            $data = $payout->payout($_POST['id']);

            $body = "Hi ".$user->getUser($data['user_id'])['first_name']."!, \r\n\r\nThis is to notify you that your payout for the sum of N".number_format($data['amount'],2)." was successfully remitted to you bank account. \r\n\r\nFor more information or enquiry, please reply to this email and a representative will respond to you as soon as possible.\r\n\r\nBest regards,\r\n".$companyName;
            $mailer->sendMail($companyEmail, $user->getUser($data['user_id'])['email'], "Your payout of N".number_format($data['amount'],2)." was successful", $body, $companyName);
            echo json_encode($result);
        } else {
            echo json_encode($result);
        }
    }