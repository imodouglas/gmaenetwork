<div class="col-sm-3">
  <div class="p5">
    <button class="btn btn-dark menu-button form-control" onclick='toggleMenu()' style="display:none"> <i class="fas fa-bars"></i> Menu </button>
  </div>
  <div class="menu-container" id="side-menu">
    <div style="padding: 10px; margin-bottom:10px"> 
        <a href="<?php echo $rootURL; ?>profile" style="text-decoration:none;"> 
            <i class="fas fa-user" style="padding:10px; border-radius:50%; border:#fff thin solid"></i> &nbsp;<?php echo $userData['first_name']." ".$userData['last_name']; ?> 
        </a> 
    </div>
    <?php if(isset($_SESSION['user_session']) || isset($_SESSION['editor_session'])){ ?>
      <a href="<?php echo $rootURL; ?>home" class="menu-item"> <i class="fas fa-tachometer-alt"></i> Dashboard </a>
      <!-- <a href="<?php echo $rootURL; ?>investments" class="menu-item"> <i class="fas fa-chart-line"></i> Levels </a> -->
      <a href="<?php echo $rootURL; ?>history" class="menu-item"> <i class="fas fa-book-open"></i> History </a>
      <a href="<?php echo $rootURL; ?>wallet" class="menu-item"> <i class="fas fa-wallet"></i> Wallet </a>
      <!-- <a href="<?php echo $rootURL; ?>referrals" class="menu-item"> <i class="fas fa-cog"></i> Referrals </a> -->
      <?php if(isset($_SESSION['editor_session'])){ ?>
        <a href="#" class="menu-item"> <i class="fas fa-caret-down"></i> ADMIN MENU <i class="fas fa-caret-down"></i> </a>
        <a href="<?php echo $rootURL; ?>admin" class="menu-item"> <i class="fas fa-tachometer-alt"></i> Admin Dashboard </a>
        <a href="<?php echo $rootURL; ?>admin/users" class="menu-item"> <i class="fas fa-users"></i> Users </a>
        <a href="<?php echo $rootURL; ?>admin/investments" class="menu-item"> <i class="fas fa-chart-line"></i> Investments </a>
      <?php } ?>
      <a href="<?php echo $rootURL; ?>logout" class="menu-item"> <i class="fas fa-sign-out-alt"></i> Logout </a>
    <?php } else if(isset($_SESSION['admin_session'])){ ?>
      <a href="<?php echo $rootURL; ?>admin" class="menu-item"> <i class="fas fa-tachometer-alt"></i> Dashboard </a>
      <a href="<?php echo $rootURL; ?>admin/users" class="menu-item"> <i class="fas fa-users"></i> Users </a>
      <a href="<?php echo $rootURL; ?>admin/investments" class="menu-item"> <i class="fas fa-chart-line"></i> Investments </a>
      <a href="<?php echo $rootURL; ?>admin/payouts" class="menu-item"> <i class="fas fa-wallet"></i> Payouts </a>
      <a href="<?php echo $rootURL; ?>logout" class="menu-item"> <i class="fas fa-sign-out-alt"></i> Logout </a>
    <?php } ?>
  </div>
</div>

<script>
  const toggleMenu = () => {
    $("#side-menu").slideToggle('fast');
  }
</script>