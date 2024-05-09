<div class="row bg-login" style="background-image: url('public/img/loginPage.jpg');
background-size: cover;
background-repeat: no-repeat;
background-attachment: fixed;
color: #fff;">
<!-- Image column -->
<div class="col-md-6">
  <div class="col-md-8 mx-auto my-5">
    <div class="col-12 text-center">
      <img src="public/img/login.png" alt="Image" class="img-fluid">
    </div>
  </div>
</div>
<!-- Login form column -->
<div class="col-md-6">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-8 mx-auto my-5">
        <div class="row">
          <div class="col-12 text-center text-dark">
            <h2>Login</h2>
          </div>
        </div>
        <div class="row">
          <form action="user/login" method="POST">
            <div class="mt-4 mb-3 row">
              <label class="col-sm-3 col-form-label text-dark">User Name</label>
              <div class="col-sm-9">
                <input type="text" name="username" class="input bg-body-secondary" required placeholder="Username" />
              </div>
            </div>
            <div class="mb-3 row">
              <label class="col-sm-3 col-form-label text-dark">Password</label>
              <div class="col-sm-9">
                <input type="password" name="password" class="input bg-body-secondary" required placeholder="Password" />
              </div>
            </div>
            <div class="mb-3 row">
              <div class="col-6 mx-auto mb-3 text-center">
                <button type="submit" class=" input button"><?php echo icon("login"); ?>Login</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
