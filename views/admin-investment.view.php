<?php
    include 'includes/env.inc.php';

    $userId = $_SESSION['admin_session'];
    $user = new UserController();
    $investment = new InvestmentController();
    $plan = new PlanController();
    $mailer = new Mailer;

    $userData = $user->getUser($userId);
    $inv_user_id = trim($_SERVER['REQUEST_URI'], "/dashboard/admin/investments/");
    $inv_user = $user->getUser($inv_user_id);
?>

<div class="header-home">
    <div style="padding-top:20px">
        <div class="row m0">
            <?php 
                include 'includes/sidemenu.inc.php';
            ?>
            <div class="col-sm-9">
                <div class="p10 header-gray-banner" style="margin-top:10px; margin-bottom:20px">
                    <h3 class="m0"> <?php echo $inv_user['first_name']." ".$inv_user['last_name']." Investments" ?> </h3>
                </div>

                
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="true">active</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab" aria-controls="completed" aria-selected="false">completed</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">

                    <!-- ACTIVE INVESTMENTS -->
                    <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                        <div class="p10 mb10 header-title-banner" style="margin-top:10px">
                            <h3 class="m0">Active Investments</h3>
                        </div>

                        <div class="row m0">
                            <?php
                                if($investment->investmentsByStatus($inv_user_id, 'active') !== false){
                                    foreach($investment->investmentsByStatus($inv_user_id, 'active') AS $invest){
                                        $planData = $plan->getPlan($invest['plan_id']);
                            ?>
                                <div class="col-sm-4 p10 mb10">
                                    <div class="investment-card" align="center">
                                        <h3>Stage <?php echo $planData['id']; ?></h3>

                                        <div class="row m0 investment-card-item">
                                            <div class="col-6 p5" align="left">
                                                <b> Amount </b>
                                            </div>
                                            <div class="col-6 p5">
                                                N<?php echo number_format($planData['amount']); ?>
                                            </div>
                                        </div>
                                        <div class="row m0 investment-card-item">
                                            <div class="col-6 p5" align="left">
                                                <b> Cash Reward </b>
                                            </div>
                                            <div class="col-6 p5">
                                                N<?php echo number_format($planData['cash_price']); ?>
                                            </div>
                                        </div>
                                        <div class="row m0 investment-card-item">
                                            <div class="col-12 p5" align="left">
                                                <b> Item Reward </b> <br>
                                                <?php echo $planData['item_price']; ?>
                                            </div>
                                        </div>
                                        <div class="row m0 investment-card-item">
                                            <div class="col-6 p5" align="left">
                                                <b> Creation Date </b>
                                            </div>
                                            <div class="col-6 p5">
                                                <?php 
                                                    echo date("d M, Y", $invest['created_at']);
                                                ?> 
                                            </div>
                                        </div>
                                        <div class="row m0">
                                            <div class="col-12">
                                                <a href="../user/<?php echo $inv_user['id']; ?>" class="btn btn-primary form-control white-color"> View Tree </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } } else { echo "No active investment!"; } ?>
                        </div>
                    </div>

                    <!-- PENDING INVESTMENTS -->
                    <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                        <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                            <div class="p10 mb10 header-title-banner" style="margin-top:10px">
                                <h3 class="m0">Pending Investments </h3>
                            </div>

                            <div class="row m0">
                                <?php
                                    if($investment->investmentsByStatus($inv_user_id, 'pending') !== false){
                                        foreach($investment->investmentsByStatus($inv_user_id, 'pending') AS $invest){
                                            $planData = $plan->getPlan($invest['plan_id']);
                                ?>
                                    <div class="col-sm-4 p10 mb10">
                                        <div class="investment-card" align="center">
                                            <h3>Stage <?php echo $planData['id']; ?></h3>

                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Amount </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    N<?php echo number_format($planData['amount']); ?>
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Cash Reward </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    N<?php echo number_format($planData['cash_price']); ?>
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-12 p5" align="left">
                                                    <b> Item Reward </b> <br>
                                                    <?php echo $planData['item_price']; ?>
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Creation Date </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    <?php 
                                                        echo date("d M, Y", $invest['created_at']);
                                                    ?> 
                                                </div>
                                            </div>
                                            <div class="row m0">
                                                <div class="col-12">
                                                    <?php if($invest['status'] == "pending"){ ?>
                                                        <button class="btn btn-success" style="padding:5px 8px; font-size:10px" title="Activate Investment" onclick="activateInvestment(<?php echo $invest['id']; ?>)"> Activate <i class="fas fa-play"></i> </button>
                                                        <button class="btn btn-danger" style="padding:5px 8px; font-size:10px" title="Delete Investment" onclick="deleteInvestment(<?php echo $invest['id']; ?>)"> Delete <i class="fas fa-times"></i> </button>
                                                    <?php } ?>
                                                </div>
                                                <script>
                                                    const activateInvestment = (id) => {
                                                        let formData = "investment="+id+"&cmd=confirm";
                                                        $.post("../../api.php", formData, function(result){
                                                            location.reload();
                                                        });
                                                    }
                                                    
                                                    const deleteInvestment = (id) => {
                                                        let formData = "investment="+id+"&cmd=delete";
                                                        $.post("../../api.php", formData, (result)=>{
                                                            location.reload();
                                                        });
                                                    }
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                <?php } 
                                    } else {
                                        echo "No pending investment";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- COMPLETED INVESTMENTS -->
                    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                    
                        <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                            <div class="p10 mb10 header-title-banner" style="margin-top:10px">
                                <h3 class="m0">Completed Investments </h3>
                            </div>

                            <div class="row m0">
                                <?php
                                    if($investment->investmentsByStatus($inv_user_id, 'complete') !== false){
                                        foreach($investment->investmentsByStatus($inv_user_id, 'complete') AS $invest){
                                            $planData = $plan->getPlan($invest['plan_id']);
                                ?>
                                    <div class="col-sm-4 p10 mb10">
                                        <div class="investment-card" align="center">
                                            <h3>Stage <?php echo $planData['id']; ?></h3>

                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Amount </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    N<?php echo number_format($planData['amount']); ?>
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Cash Reward </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    N<?php echo number_format($planData['cash_price']); ?>
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-12 p5" align="left">
                                                    <b> Item Reward </b> <br>
                                                    <?php echo $planData['item_price']; ?>
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Creation Date </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    <?php 
                                                        echo date("d M, Y", $invest['created_at']);
                                                    ?> 
                                                </div>
                                            </div>
                                            <div class="row m0 investment-card-item">
                                                <div class="col-6 p5" align="left">
                                                    <b> Completion Date </b>
                                                </div>
                                                <div class="col-6 p5">
                                                    <?php 
                                                        echo date("d M, Y", $invest['completed_at']);
                                                    ?> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } 
                                    } else {
                                        echo "No complete investment";
                                    }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const activateInvestment = (id) => {
        let formData = "investment="+id+"&cmd=confirm";
        $.post("../../api.php", formData, function(result){
            // if(data == true){
            //     location.reload();
            // } else if(data == false){
            //     alert("An error occured! Try again.");
            // }
            location.reload();
        });
    }

    const deactivateInvestment = (id) => {
        let formData = "investment="+id+"&cmd=pending";
        $.post("../../api.php", formData, (result)=>{
            // if(data == true){
            //     location.reload();
            // } else if(data == false){
            //     alert("An error occured! Try again.");
            // }
            location.reload();
        });
    }
    
    const deleteInvestment = (id) => {
        let formData = "investment="+id+"&cmd=delete";
        $.post("../api.php", formData, (result)=>{
            // if(data == true){
            //     location.reload();
            // } else if(data == false){
            //     alert("An error occured! Try again.");
            // }
            location.reload();
        });
    }
</script>