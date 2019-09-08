<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php"><h3>Home</h3> <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://www.codecademy.com/learn/learn-php">Learn php</a>
      </li>
      <li>
      <a class="nav-link" href="http://www.mysqltutorial.org/">Learn Mysql</a>
      </li>
    </ul>
    <form class="form-inline" action = "register.php">
      <button class="btn btn-outline-success btn-lg m-2">Sign Up</button>
    </form>

    <form  action = "login.php">
      <button class="btn btn-outline-success btn-lg m-2">login</button>
    </form>

    <form action = "logout.php">
      <button class="btn btn-outline-danger btn-lg m-2">logout</button>
    </form>
  </div>
</nav>
</body>
</html>