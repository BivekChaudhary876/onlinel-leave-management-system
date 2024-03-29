<!-- <?php  echo 'Welcome ' . $data[ 'name' ];?><br /> -->


<form action="?c=login&m=login" method="post">
    <h2>Login</h2>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <input type="submit" value="Login" name="userLogin">
</form>

