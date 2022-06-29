<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <div></div>
  
  <form>
    <div class = "panel panel-primary">
   <div class = "panel-heading">
      <h1 class = "panel-title">User Creation</h1>
   </div>
    
      <div class = "panel-body">
    <div class="form-group row">
      <div class="col-xs-3">
        <label for="ex1">Username</label>
        <input class="form-control" id="ex1" type="text" placeholder="username">
      </div>
      <div class="col-xs-3">
        <label for="ex2">device_id</label>
        <input class="form-control" id="ex2" type="text" placeholder="device_id">
      </div>
      <div class="col-xs-3">
        <label for="ex3">mobilenumber</label>
        <input class="form-control" id="ex3" type="text" placeholder="mobilenumber">
      </div>
    </div>
    
    <div class="form-group row">
      <div class="col-xs-3">
        <label for="ex1">email</label>
        <input class="form-control" id="ex1" type="email" placeholder="email">
      </div>
      <div class="col-xs-3">
        <label for="ex2">password</label>
        <input class="form-control" id="ex2" type="password" placeholder="password">
      </div>
      <div class="col-xs-3">
        <label for="ex3">date</label>
        <input class="form-control" id="ex3" type="date" placeholder="date">
      </div>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </div>
</div>

  </form>


</body>
</html>
