<?php 
    include 'includes/env.inc.php';

    $userId = $_SESSION['admin_session'];
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
                    <div class="col-sm-12">
                        <div class="header-title-banner p10">
                            <h4> Users </h4>
                        </div>
                        <div style="padding-top:10px">
                            <table style="width:100%; font-size:12px">
                                <tr>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Name
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Username
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Email
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Phone
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Referrer
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Registration Date
                                    </th>
                                    <th style="padding:10px; background:#f0f0f0; border-bottom:#ccc thin solid">
                                        Action
                                    </th>
                                </tr>
                                <?php foreach($user->getAllUsers() AS $user){ ?>
                                    <tr>
                                        <td style="padding:10px;border-bottom:#ccc thin solid">
                                            <?php echo $user['first_name']." ".$user['last_name']; ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php echo $user['uname']; ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php echo $user['email']; ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php echo $user['phone']; ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php echo $user['referrer']; ?>
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <?php echo date("d M, Y - h:ia", $user['created_at']); ?>   
                                        </td>
                                        <td style="padding:10px; border-bottom:#ccc thin solid">
                                            <a href="user/<?php echo $user['id']; ?>" class="btn btn-primary white-color" style="font-size:12px; padding: 3px; background:blue" onclick="showUser('<?php echo $user['id']; ?>')" title="Full Details"> <i class="fas fa-eye"></i> </a>
                                            <a href="payouts/<?php echo $user['id']; ?>" class="btn btn-primary white-color" style="font-size:12px; padding: 3px; background:green" title="User's Cashouts"> <i class="fas fa-money-bill"></i> </a>
                                            <a href="investments/<?php echo $user['id']; ?>" class="btn btn-primary white-color" style="font-size:12px; padding: 3px; background:#333"  title="User's Investments"> <i class="fas fa-chart-line"></i> </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

