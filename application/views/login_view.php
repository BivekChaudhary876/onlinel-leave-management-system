<div class="row">
  <!-- Image column -->
  <div class="col-md-6">
    <img src="public/img/login.png" alt="Image" class="img-fluid">
  </div>
  <!-- Login form column -->
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-8 mx-auto my-5">
        <div class="row">
          <div class="col-12 text-center">
            <h2>Login</h2>
          </div>
        </div>
        <div class="row">
          <form action="?c=user&m=login" method="POST" >
            <div class="mt-4 mb-3 row">
              <label class="col-sm-3 col-form-label">User Name</label>
              <div class="col-sm-9">
                <input type="text" name="username" class="form-control bg-body-secondary" required placeholder="Username"/>
              </div>
            </div>
            <div class="mb-3 row">
              <label class="col-sm-3 col-form-label">Password</label>
              <div class="col-sm-9">
                <input type="password" name="password" class="form-control bg-body-secondary" required placeholder="Password"/>
              </div>
            </div>
            <div class="mb-3 row">
              <div class="col-6 mx-auto mb-3 text-center">
                <input type="submit" class="form-control btn btn-outline-success" value="Login">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>