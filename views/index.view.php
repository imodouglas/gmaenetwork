<?php 
    include 'includes/env.inc.php';

    $user = new UserController();
    $investment = new InvestmentController();
    // $userView = new UserView();
    $mailer = new Mailer;

    if(isset($_POST['login'], $_POST['email'], $_POST['password'])){
        $result = $user->doLogin($_POST['email'], $_POST['password']);
        if($result !== false){
            if($result['role'] == 'admin'){
                $_SESSION['admin_session'] = $result['id'];
                echo "<script> window.location = '".$rootURL."admin'; </script>";
            } else if($result['role'] == 'member'){
                $_SESSION['user_session'] = $result['id'];
                echo "<script> window.location = '".$rootURL."home'; </script>";
            }
        } else {
            echo "<script> alert('Incorrect login credentials!'); </script>";
        }
    }

    if(isset($_POST['addAccount'], $_POST['ref'])){ 
        if($_POST['ref'] !== ""){
            if($_POST['password'] == $_POST['confirm_password']){
                if($user->userByEmail($_POST['email']) == false){
                    if($user->getUser($_POST['uname']) == false){
                        $refData = $user->getUser($_POST['ref']);
                        if($refData !== false){ 
                            $level = $refData['level'];
                            $data = $user->doCreateUser($_POST['password'], $_POST['fname'], $_POST['lname'], $_POST['uname'], $_POST['email'], $_POST['phone'], $level, $_POST['ref']);
                            if($data !== false){
                                $userID = $user->userByEmail($_POST['email'])['id'];
                                $_SESSION['user_session'] = $userID;
                                $inv = $investment->doAddInvestment($userID, $level);
                                $msg = "Hello ".$_POST['fname'].", \r\n\r\nIt is our pleasure to inform you that your account with ".$companyName." has been created successfully. \r\n\r\nYou can login to your account to start making investments. \r\n\r\nFeel free to contact us via any of our contact channels if your need clarification on any of the above information. \r\n\r\nBest regards,\r\n\r\n".$companyName;
                                $mail = $mailer->sendMail($companyEmail, $_POST['email'], 'Welcome to '.$companyName, $msg, $companyName);
                                echo "<script> window.location = '".$rootURL."home'; </script>";
                            } else {
                                echo "<script> alert('There was an error creating your account. Please try again!'); </script>";
                            }
                        } else { 
                            echo "<script> alert('We could not find a user with username: ".$_POST['ref']."!'); </script>";     
                        }
                    } else {
                        echo "<script> alert('An account with the username ".$_POST['uname']." already exist!'); </script>";
                    }
                } else {
                    echo "<script> alert('An account with the email ".$_POST['email']." already exist!'); </script>";
                }
            } else {
                echo "<script> alert('An error occured. Please try again'); </script>";
            }
        } else {
            echo "<script> alert('You cannot signup without a referrer!'); </script>";
        }
    }

    
?>

<div class="header">
    <!-- <div class="overlay"></div> -->
    <div class="flexBox center-center">
        <div class="container">
            <div class="row" style="padding-top:80px; padding-bottom:80px">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="card-box">
                        <div class="card-box-body" align="center">
                            <div id="login">
                                <div class="card-title"> Login to your account </div>
                                <form method="post" action="">
                                    <p>
                                        <label> Email: </label>
                                        <input type="email" name="email" class="form-control" required />
                                    </p>
                                    <p>
                                        <label> Password: </label>
                                        <input type="password" name="password" class="form-control" required />
                                    </p>
                                    <p>
                                        <input type="submit" name="login" value="Login" class="btn btn-success form-control" required />
                                    </p>
                                    <p>
                                        Forgot password? <a href="#" onclick="modal.reset()"> Reset Password </a>
                                    </p>
                                    <p>
                                        Don't have an account? <a href="#" onclick="modal.signup()"> Create One </a>
                                    </p>
                                </form>
                            </div>

                            <div id="signup" style="display:none">
                                <div class="card-title"> Create an Account </div>
                                <form method="post" action="" name="add-account">
                                    <p>
                                        <input type="text" name="fname" class="form-control" required="" placeholder="First name" />
                                    </p>
                                    <p>
                                        <input type="text" name="lname" class="form-control" required="" placeholder="Last name" />
                                    </p>
                                    <p>
                                        <input type="text" name="uname" class="form-control" required="" placeholder="Username" />
                                    </p>
                                    <p>
                                        <input type="number" name="phone" class="form-control" required="" placeholder="Phone no." />
                                    </p>
                                    <p>
                                        <input type="email" name="email" class="form-control" required="" placeholder="Email" />
                                    </p>
                                    <p>
                                        <input type="password" name="password" class="form-control" required="" placeholder="Password" />
                                    </p>
                                    <p>
                                        <input type="password" name="confirm_password" class="form-control" required="" placeholder="Confirm Password" />
                                    </p>
                                    <p>
                                        <input type="text" name="ref" value="<?php if(isset($_SESSION['ref'])){ echo $_SESSION['ref']; } ?>" class="form-control" required="" placeholder="Referrer's Username" readonly />
                                    </p>
                                    <p>
                                        <input type="submit" name="addAccount" value="Create Account" class="btn btn-success form-control" />
                                    </p>
                                    <p>
                                        Already have an account? <a href="#" onclick="modal.login()"> Signin Now </a>
                                    </p>
                                </form> 
                            </div>

                            <div id="reset" style="display:none">
                                <div class="card-title"> Reset your password </div>
                                <form method="post" action="reset-password">
                                    <p>
                                        <label> Email: </label>
                                        <input type="email" name="email" class="form-control" required />
                                    </p>
                                    <p>
                                        <input type="submit" name="reset" value="Reset Password" class="btn btn-success form-control" required />
                                    </p>
                                    <p>
                                        Remembered password? <a href="#" onclick="modal.login()"> Login </a>
                                    </p>
                                    <p>
                                        Don't have an account? <a href="#" onclick="modal.signup()"> Create One </a>
                                    </p>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
</div>


<script>
    // function showSignup(){
    //     console.log('done!');
    // }
    const modal = {
        signup() {
            $("#login").hide();
            $("#reset").hide();
            $("#signup").fadeToggle("slow");
        },

        login() {
            $("#signup").hide();
            $("#reset").hide();
            $("#login").fadeToggle("slow");
        },

        reset() {
            $("#signup").hide();
            $("#login").hide();
            $("#reset").fadeToggle("slow");
        }

    };
</script>