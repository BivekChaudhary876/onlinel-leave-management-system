<div class="row bg-login" style="background-image: url('public/img/login-water-bg.jpg');
background-size: cover;
background-repeat: no-repeat;
background-attachment: fixed;">
  <div class="form-row">
    <div class="form">
      <div class="form-inner">
        <form action="user/login" method="POST">
          <label class="login-label">User Name</label>
          <input type="text" name="username" class="login-input" required placeholder="Enter your username" />
          <label class="login-label">Password</label>
          <input type="password" name="password" class="login-input" required placeholder="Enter your password" />
          <p class="login-password">Forget Password?</p>
          <button type="submit" class="login-button"><?php echo icon("login"); ?>Login</button>
        </form>
      </div>
    </div>
  </div>
</div>

