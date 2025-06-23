<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" contents="width=device-width, initial-scale=1.0">
    <title> E-Commerce Website For Sweet Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    
    <div class="container" id="signup" style="display:none;">
        <h1 class="form-title">Register</h1>
        <form method="post" action="register.php"> <!--Register.php-->
          <div class="input-group">
             <i class="fas fa-user"></i>
             <input type="text" name="fName" id="fName" placeholder="First Name" required>
             <label for="fname">First Name</label>
          </div>
          <div class="input-group">
              <i class="fas fa-user"></i>
              <input type="text" name="lName" id="lName" placeholder="Last Name" required>
              <label for="lName">Last Name</label>
          </div>
          <div class="input-group">
            <i class="fas fa-phone"></i>
            <input type="text" name="phone" id="phone" placeholder="Phone Number" required>
            <label for="phone">Phone Number</label>
        </div>
        <div class="input-group">
            <i class="fas fa-calendar-alt"></i>
            <input type="date" name="dob" id="dob" required>
        </div>
        <div class="input-group">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" id="email" placeholder="Email" required>
          <label for="email">Email</label>
      </div>
          <div class="input-group">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" id="password" placeholder="Password" required>
              <label for="password">Password</label>
          </div>
          <div class="admin-checkbox">
              <input type="checkbox" name="is_admin" id="is_admin">
              <label for="is_admin">Register as Admin</label>
          </div>
         <input type="submit" class="btn" value="Sign Up" name="signUp">
        </form>
        <div class="links">
          <p>Already Have Account ?</p>
          <button id="signInButton">Sign In</button>
        </div>
      </div>
  
      <div class="container" id="signIn">
          <h1 class="form-title">Login</h1>
          <form method="post" action="register.php"> <!--Register.php-->
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
           
           <input type="submit" class="btn" value="Sign In" name="signIn">
          </form>
          <div class="links">
            <p>Don't have account yet?</p>
            <button id="signUpButton">Sign Up</button>
          </div>
        </div>
    <script src="script.js"></script>

</body>
</html>