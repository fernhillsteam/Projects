<?php

$con = mysql_connect('localhost','u949021360_Pendios','Pendios@123');

if (!$con)

{

die('Could not connect: ' . mysql_error());

}

mysql_select_db('u949021360_Pendios', $con);

$con = mysql_connect('localhost','u949021360_Pendios','Pendios@123');

if (!$con)

{

die('Could not connect: ' . mysql_error());

}

mysql_select_db('u949021360_Pendios', $con);

//$sql="select * from accountdtl";

$result = mysql_query("SELECT ac_v, ac_c, ac_p ,dc_v,dc_c,dc_p, time_stamp FROM voltmeter");

while($rowval = mysql_fetch_array($result))

 {

$accountnumber= $rowval['ac_v'];

$title= $rowval['ac_c'];

$fname= $rowval['ac_p'];

$lname= $rowval['dc_v'];

$add1= $rowval['dc_c'];

$add2= $rowval['dc_p'];

$town= $rowval['time_stamp'];

/*$country= $rowval['country'];

$pin= $rowval['pcode'];

$mob= $rowval['con_no'];

$mailid= $rowval['mail_id'];

$uname= $rowval['uname'];

$balance= $rowval['balance'];*/

}

mysql_close($con);

 

?>
<html>

<body>

<from >

 

  <table  style="color:purple;border-style:groove; height:150px;width:350px" background="3.jpg">

        <tr>

           

            <td style="font-family:Copperplate Gothic Bold">&nbsp;</td>

        </tr>

        <tr>

            <td style="color:red;background-color:aqua;" class="auto-style3">Account no:</td>

            <td class="auto-style4">

                <input id="Text1" type="text" value='<?php echo  $accountnumber; ?>'/></td>

        </tr>

        <tr>

            <td style="color:red;background-color:aqua;" class="auto-style3">Title</td>

            <td class="auto-style4">

                <input id="Text2" type="text" value='<?php echo  $title; ?>'/></td>

        </tr>

        <tr>

             <td style="color:red;background-color:aqua;" class="auto-style3">FirstName:</td>

            <td class="auto-style4">

                <input id="Text3" type="text" value='<?php echo  $fname; ?>' /></td>

        </tr>

        <tr>

             <td style="color:red;background-color:aqua;" class="auto-style3">Surname:</td>

            <td class="auto-style4">

                <input id="Text4" type="text" value='<?php echo  $lname; ?>' /></td>

        </tr>

        <tr>

            <td style="color:red;background-color:aqua;" class="auto-style3">Address Line 1:</td>

            <td class="auto-style4">

                <input id="Text5" type="text" value='<?php echo  $add1; ?>' /></td>

        </tr>

        <tr>

           <td style="color:red;background-color:aqua;" class="auto-style3">Address Line 2:</td>

            <td class="auto-style4">

                <input id="Text6" type="text" value='<?php echo  $add2; ?>' ></td>

        </tr>

        <tr>

             <td style="color:red;background-color:aqua;" class="auto-style3">Town:</td>

            <td class="auto-style4">

                <input id="Text7" type="text" value='<?php echo  $town; ?>'/></td>

        </tr>

        <!-- <tr>

             <td style="color:red;background-color:aqua;" class="auto-style3">Country:</td>

            <td class="auto-style4">

                <input id="Text8" type="text" value='<?php echo  $country; ?>' /></td>

        </tr>

        <tr>

             <td style="color:red;background-color:aqua;" class="auto-style3">Post Code:</td>

            <td class="auto-style4">

                <input id="Text9" type="text"  value='<?php echo  $pin; ?>'/></td>

        </tr>

        <tr>

             <td style="color:red;background-color:aqua;" class="auto-style3">Contact Number:</td>

            <td class="auto-style4">

                <input id="Text10" type="text" value='<?php echo  $mob; ?>'/></td>

        </tr>

        <tr>

            <td style="color:red;background-color:aqua;" class="auto-style3">Email Address:</td>

            <td class="auto-style4">

                <input id="Text11" type="text" value='<?php echo  $mailid; ?>'/></td>

        </tr>

        <tr>

             <td style="color:red;background-color:aqua;" class="auto-style3">User Name:</td>

            <td class="auto-style4">

                <input id="Text12" type="text" value='<?php echo  $uname; ?>'/></td>

        </tr>

        <tr>

            <td style="color:red;background-color:aqua;" class="auto-style3">Balance:</td>

            <td>

                <input id="Text13" type="text" value='<?php echo  $balance; ?>' /></td>

        </tr> -->

        <tr>

            <td></td>

        </tr>

    </table>

</form>

</body>

</html>

