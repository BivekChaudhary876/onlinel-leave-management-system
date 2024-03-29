<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee</title>
</head>
<body>
    <form action="?c=employee" method="post">
    <h2>Employee</h2>
    <label for="firstName">First Name:</label>
    <input type="text" id="firstName" name="firstName" required><br>
    <label for="text">Last Name:</label>
    <input type="text" id="lastName" name="lastName" required><br>
    <label for="email">Email Address:</label>
    <input type="email" id="email" name="email" required><br>
    <label for="phoneNumber">Phone Number:</label>
    <input type="number" id="phoneNumber" name="phoneNumber" required><br>
    <label for="designation">Designation:</label>
    <input type="designation" id="designation" name="designation" required><br>
    <input type="submit" name="emp" value="Submit">
</form>
</body>
</html>