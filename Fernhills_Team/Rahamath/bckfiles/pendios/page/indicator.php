<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/pendios.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
   Pendios IoT Dashboard
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>
<body>
  <div class="row">
  <div class="col">
    <div class="card">
              <div class="card-header">
               <!-- <h4 class="card-title">Device Status</h4>-->
              </div>
              <div class="card-body">
                <div class="row">
                 <?php
   
                require('db.php');
       
         //********* to update Device status depending up on Sl_no increase*********
                         $query ="SELECT * FROM `indicator` order by `Sl_no` DESC limit 1 ";
                         $result = mysqli_query($con, $query) or die(mysql_error());
               
           while($row = mysqli_fetch_row($result)){

                    $short  =$row[2];
          $shutdown=$row[3];
          $overload=$row[4];
          $tamper=$row[5];
          $health=$row[6];

?>
         <div class="col-lg col-md-6 col-6 ml-auto text-center">
        <?php echo  "<div style='color: ".($short == 1 ? "green" : "red")."' ><i class='fas fa-circle '></i></div>"; ?>
         <p class="card-category text-center">Short Circuit</p>
                </div>
        <div class="col-lg col-md-6 col-6 ml-auto text-center">
            <?php echo  "<div style='color: ".($shutdown == 1 ? "green" : "red")."' ><i class='fas fa-circle '></i></div>"; ?>
        <p class="card-category text-center">Shutdown</p>
        </div>
        <div class="col-lg col-md-6 col-6 ml-auto text-center">
            <?php echo  "<div style='color: ".($overload == 1 ? "green" : "red")."' ><i class='fas fa-circle '></i></div>"; ?>
        <p class="card-category text-center">Overload</p>
        </div>
        <div class="col-lg col-md-6 col-6 ml-auto text-center">
            <?php echo  "<div style='color: ".($tamper == 1 ? "green" : "red")."' ><i class='fas fa-circle '></i></div>"; ?>
        <p class="card-category text-center">Tampering</p>
            </div>
        <div class="col-lg col-md-6 col-6 ml-auto text-center">
            <?php echo  "<div style='color: ".($health == 1 ? "green" : "red")."' ><i class='fas fa-circle '></i></div>"; ?>
        <p class="card-category text-center">Health</p>

        </div>



                  </div>

                  </div>
              </div>
            </div>
    </div>
    <?php
                }

?>
</body>
</html>