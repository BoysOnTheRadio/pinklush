<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link rel="stylesheet" href="pinklush_admin.css">
</head>
<body>
  <section class="admin_bg">
      <form class="pl-admin-section admin-login" method="post">
          <h1 id="pl-admin-header-b">LOGIN</h1>
          <div class="form-group">
              <label for="username">Email</label>
              <input type="text" id="email" name="username" placeholder="Enter your email" required>
          </div>
          <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password" placeholder="Enter your password" required>
          </div>
          <button class="btn primary" type="submit" id="submit-btn">Log In</button>
      </form>
  </section>

  <script src="/scripts/admin/loginAuth.js"></script>
</body>
</html>
