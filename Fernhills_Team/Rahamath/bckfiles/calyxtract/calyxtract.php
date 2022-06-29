<html>
<head>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<title>Demo</title>
<script type="text/javascript">
	
    var count = 0;

    function  myfunction(x){
    	var x;
    	if (x == 1){
    		count=count+1;
    	} 
        if (count == 1) {
        	document.getElementById("change").style.background="red";
        }
        else if (count == 2) {
        	document.getElementById("change").style.background="green";
        	count=0;
        }

    }


</script>
</head>

<body>
	<center>
<button id="change" onclick="myfunction(1)" type="button" class="btn btn-success">Click me</button>
<!-- <hr>
<button id="change" onclick="myfunction(2)" type="button" class="btn btn-success">Click me</button>
<hr>
<button id="change" onclick="myfunction(1)" type="button" class="btn btn-success">Click me</button>
<hr>
<button id="change" onclick="myfunction(1)" type="button" class="btn btn-success">Click me</button>
<hr>
<button id="change" onclick="myfunction(1)" type="button" class="btn btn-success">Click me</button>
<hr>
<button id="change" onclick="myfunction(1)" type="button" class="btn btn-success">Click me</button>
<hr>
<button id="change" onclick="myfunction(1)" type="button" class="btn btn-success">Click me</button>
<hr>
<button id="change" onclick="myfunction(1)" type="button" class="btn btn-success">Click me</button>
<hr>
<button id="change" onclick="myfunction(1)" type="button" class="btn btn-success">Click me</button> -->
  
</center>

</body>
</html> 
