<?php
  include('connection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
    integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
    integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>PHP and MySQL CRUD</title>
</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="https://egavilanmedia.com" target="_blank" >Madhunivas Dashboard</a>
    </div>
  </nav>
  <br><br><br>

  <div class="container">
    <div class="row">
      <div class="col-md-12 card">
        <div>
          <div class="head-title">
            <h4 class="text-center">Sell Property Dashboard</h4>
            <hr>
          </div>
          <div class="col-md-3 float-left add-new-button">
            <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#addModal">
              <i class="fas fa-plus"></i> Add New Property
            </a>
          </div>
          <div class="col-md-3 float-left add-new-button">
            <a href="pdf.php" target="_blank" class="btn btn-success btn-block">
              <i class="fas fa-print"></i> Print
            </a>
          </div>
          <br><br><br>
          <table class="table table-striped">
            <thead class="bg-secondary text-white">
              <tr>
                <th>No</th>
                <!-- <th>image</th> -->
                <th>Name</th>
                <th>location</th>
                <th>bedrooms</th>
                <th>bathrooms</th>
                <th>Image</th>
                <th>parking</th>                
                <th>area</th>
                <th>price</th>
                <th>View</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>

            <?php

              $sql = "SELECT * FROM register";
              $result = mysqli_query($con, $sql);

            if($result)
            {
              while($row = mysqli_fetch_assoc($result)){
            ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['location']; ?></td>
                <td><?php echo $row['beds']; ?></td>
                <td><?php echo $row['bathrooms']; ?></td>
                <td><img src="<?php echo $row['image']; ?>" alt="image" width="150" height="100"></td>
                <td><?php echo $row['parking']; ?></td>
                <td><?php echo $row['area']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td>
                  <button type="button" class="btn btn-info viewBtn"> <i class="fas fa-eye"></i> View </button>
                </td>
                <td>
                  <button type="button" class="btn btn-warning updateBtn"> <i class="fas fa-edit"></i> Update </button>
                </td>
                <td>
                  <button type="button" class="btn btn-danger deleteBtn"> <i class="fas fa-trash-alt"></i> Delete </button>
                </td>
              </tr>
            <?php
              }
            }else{
              echo "<script> alert('No Record Found');</script>";
            }
          ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- MODALS -->

  <!-- ADD RECORD MODAL -->
  <div class="modal fade" id="addModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Add New Property</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="insert.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="title">Property Name :</label>
              <input type="text" name="text" class="form-control" placeholder="Enter Property Name" maxlength="50"
                required>
            </div>
            <div class="form-group">
              <label for="title">location :</label>
              <input type="text" name="location" class="form-control" placeholder="Enter location" maxlength="50"
                required>
            </div>
            <!-- <div class="form-group">
              <label for="title">Address</label>
              <input type="text" name="beds" id="beds" value="1" class="form-control" placeholder="Enter address" maxlength="50"
                required>
            </div> -->
            <div class="form-group">
              <label for="title">Bed-rooms : </label>
                 <select class="form-control" id="beds" name="beds">
                  <option>Select list (select one)</option>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                 </select>
            </div>

            <div class="form-group">
              <label for="title">Bath-rooms : </label>
                 <select class="form-control" id="bathrooms" name="bathrooms">
                  <option>Select list (select one)</option>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                 </select>
            </div>

            <div class="form-group">
              <label for="title">Parking : </label>
                 <select class="form-control" id="park" name="park">
                  <option>Select list (select one)</option>
                  <option>Yes</option>
                  <option>No</option>
                  
                 </select>
            </div>
            <div class="form-group">
              <label for="title">Plot Area :</label>
              <input type="text" name="area" class="form-control" placeholder="Enter Plot Area" maxlength="50"
                required>
            </div>

            <div class="form-group">
              <label for="title">Price :</label>
              <input type="text" name="price" class="form-control" placeholder="Enter Price" maxlength="50"
                required>
            </div>

            <div class="form-group">
              <label for="title">Property Image:</label>
              <input type="file" name="f1" class="form-control"  maxlength="50"
                required>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" name="sub" value="Save">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- VIEW MODAL -->
  <div class="modal fade" id="viewModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title">View Property Information</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-5 col-xs-6 tital " >
              <strong>Property Name:</strong>
            </div>
            <div class="col-sm-7 col-xs-6 ">
              <div id="viewtext"></div>
            </div>
            <div class="col-sm-5 col-xs-6 tital " >
              <strong>Location:</strong>
            </div>
            <div class="col-sm-7 col-xs-6 ">
              <div id="viewlocation"></div>
            </div>
            <div class="col-sm-5 col-xs-6 tital " >
              <strong>beds:</strong>
            </div>
            <div class="col-sm-7 col-xs-6 ">
              <div id="viewbeds"></div>
            </div>
            <div class="col-sm-5 col-xs-6 tital " >
              <strong>bathrooms:</strong>
            </div>
            <div class="col-sm-7 col-xs-6 ">
              <div id="viewbathrooms"></div>
            </div>
            <div class="col-sm-5 col-xs-6 tital " >
              <strong>parking:</strong>
            </div>
            <div class="col-sm-7 col-xs-6 ">
              <div id="viewpark"></div>
            </div>
            <div class="col-sm-5 col-xs-6 tital " >
              <strong>area:</strong>
            </div>
            <div class="col-sm-7 col-xs-6 ">
              <div id="viewarea"></div>
            </div> 
            <div class="col-sm-5 col-xs-6 tital " >
              <strong>price:</strong>
            </div>
            <div class="col-sm-7 col-xs-6 ">
              <div id="viewprice"></div>
            </div>
            <div class="col-sm-5 col-xs-6 tital " >
              <strong>image:</strong>
            </div>
            <div class="col-sm-7 col-xs-6 ">
              <div><img src="" id="viewf1" alt="image" width="250" height="200"/></div>

            </div>            
          </div>
          <br>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- UPDATE MODAL -->
  <div class="modal fade" id="updateModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title">Edit Property</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="updateId" id="updateId">
            <div class="form-group">
              <label for="title">Property Name</label>
              <input type="text" name="updatetext" id="updatetext" class="form-control" placeholder="Enter first name" maxlength="50"
                required>
            </div>
            <div class="form-group">
              <label for="title">Location</label>
              <input type="text" name="updatelocation" id="updatelocation" class="form-control" placeholder="Enter last name" maxlength="50"
                required>
            </div>
            <div class="form-group">
              <label for="title">beds</label>
              <input type="text" name="updatebeds" id="updatebeds" class="form-control" placeholder="Enter address" maxlength="50"
                required>
            </div>
            <div class="form-group">
              <label for="title">bathrooms</label>
              <input type="text" name="updatebathrooms" id="updatebathrooms" class="form-control" placeholder="Enter skills" maxlength="50" required>
            </div>
            <div class="form-group">
              <label for="title">parking</label>
              <input type="text" name="updatepark" id="updatepark" class="form-control" placeholder="Enter designation" maxlength="50"
                required>
            </div>

            <div class="form-group">
              <label for="title">area</label>
              <input type="text" name="updatearea" id="updatearea" class="form-control" placeholder="Enter designation" maxlength="50"
                required>
            </div>

            <div class="form-group">
              <label for="title">price</label>
              <input type="text" name="updateprice" id="updateprice" class="form-control" placeholder="Enter designation" maxlength="50"
                required>
            </div>
 
            <div class="form-group">
              <label for="title">Property Image:</label>
              <input type="file" name="updatef1" id="updatef1" class="form-control"  maxlength="50"
                required>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" name="updateData">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- DELETE MODAL -->
  <div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="exampleModalLabel">Delete Record</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="delete.php" method="POST">

          <div class="modal-body">

            <input type="hidden" name="deleteId" id="deleteId">

            <h4>Are you sure want to delete?</h4>

          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button type="submit" class="btn btn-primary" name="deleteData">Yes</button>
        </div>

        </form>
      </div>
    </div>
  </div>

  <script src="http://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
    integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
    crossorigin="anonymous"></script>
  <script src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>

  <script>
    $(document).ready(function () {
      $('.updateBtn').on('click', function(){

        $('#updateModal').modal('show');

        // Get the table row data.
        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
		

        console.log(data);

        $('#updateId').val(data[0]);
        $('#updatetext').val(data[1]);
        $('#updatelocation').val(data[2]);
        $('#updatebeds').val(data[3]);
        $('#updatebathrooms').val(data[4]);
        $('#updatef1').val(data[5]);
        $('#updatepark').val(data[6]);
        $('#updatearea').val(data[7]);
        $('#updateprice').val(data[8]);
              

        });
        
    });
  </script>

  <script>
    $(document).ready(function () {
      $('.viewBtn').on('click', function(){

        $('#viewModal').modal('show');
        // Get the table row data.
        $tr = $(this).closest('tr');
     
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
		
	    var imgv = $("img", $tr).attr("src");
	    //data[5] = imgv;
		
        console.log(data);

        $('#viewtext').text(data[1]);
        $('#viewlocation').text(data[2]);
        $('#viewbeds').text(data[3]);
        $('#viewbathrooms').text(data[4]);
		//$('#viewf1').text(data[5]);
        $('#viewpark').text(data[6]);
        $('#viewarea').text(data[7]);
        $('#viewprice').text(data[8]);
        
		document.getElementById("viewf1").src=imgv;
        /*$('#viewpark').text(data[9]);*/      

        });
    
    });
  </script>

  <script>
    $(document).ready(function () {
      $('.deleteBtn').on('click', function(){

        $('#deleteModal').modal('show');
        
        // Get the table row data.
        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);

        $('#deleteId').val(data[0]);

        });
    
    });
  </script>
</body>

</html>