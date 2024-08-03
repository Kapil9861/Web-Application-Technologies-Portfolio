<?php
    include('connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form method="post" action="">
        <fieldset>
            <legend>Register</legend>
            <label for="firstname">Firstname:</label>
            <input type="text" name="firstname" id="firstname" value="<?php
            if(isset($_POST['firstname'])){
                echo $_POST['firstname'];
            }
            ?>" placeholder="Firstname"><br><br>
            <label for="lastname">Lastname:</label>
            <input type="text" name="lastname" id="lastname" value="<?php
            if(isset($_POST['lastname'])){
                echo $_POST['lastname'];
            }
            ?>" placeholder="Surname"><br><br>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?php
            if(isset($_POST['username'])){
                echo $_POST['username'];
            }
            ?>" placeholder="Username"><br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" value="<?php
            if(isset($_POST['password'])){
                echo $_POST['password'];
            }
            ?>" placeholder="Password"><br><br>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php
                if(isset($_POST['email'])){
                    echo $_POST['email'];
                }
            ?>" placeholder="Email">
            <br><br>
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" value="<?php
            if(isset($_POST['address'])){
                echo $_POST['address'];
            }
            ?>" placeholder="Address"><br><br>
            <label for="country">Country:</label>
            <input type="text" name="country" id="country" value="<?php
            if(isset($_POST['country'])){
                echo $_POST['country'];
            }
            ?>" placeholder="Country"><br><br>
            <label for="DOB">Date of Birth: </label>
            <select name='dd' size='1' id="DOB">
                <?php
                for($i=1;$i<=31; $i++){
                echo "<option value=\"$i\">$i</option>";
            
            }?>
            </select>
            <select name='mm' size='1' id="DOB">
                
                <?php
                $months=array("January","February","March","April","May","June","July","August","September","October","November","December");
                    foreach($months as $M){
                        echo "<option value=\"$M\">$M</option>";
                    }
                ?>
            </select>
            <select name='yyyy' size='1' id="DOB">
            <?php
                for($i=1940;$i<=2022; $i++){
                echo "<option value=\"$i\">$i</option>";
            
            }?>
            </select><br><br>
            <label for="gender">Gender: </label>
            <input type="radio" name="gender" id="gender" value="Male"checked/>Male
            <input type="radio" name="gender" id="gender" value="Female">Female
            <input type="radio" name="gender" id="gender" value="Others">Others
            <br><br>
            <input type="checkbox" name="confirm" value="confirm" 
            <?php echo isset($_POST['confirm']) ? 'checked' : ''; ?>> Terms And Conditions
        </fieldset>
        <input type="submit" name="submit" value="Register">
        <input type="reset" value="clear">
    </form>

<?php
if(isset($_POST['submit'])){
    $firstname=trim($_POST['firstname']);
    $lastname=trim($_POST['lastname']);
    $Ffirstname=filter_var($firstname,FILTER_SANITIZE_STRING);
    $Flastname=trim($lastname,FILTER_SANITIZE_STRING);
    $username=trim($_POST['username']);
    $Fusername=filter_var($username,FILTER_SANITIZE_STRING);
    $password=trim($_POST['password']);
    $email=trim($_POST['email']);
    $Femail=filter_var($email,FILTER_SANITIZE_EMAIL);
    $Vemail=filter_var($Femail,FILTER_VALIDATE_EMAIL); 
    $address=trim($_POST['address']);
    $faddress=filter_var($address,FILTER_SANITIZE_STRING);
    $country=trim($_POST['country']);
    $fcountry=filter_var($country,FILTER_SANITIZE_STRING);
    $yy =$_POST['yyyy'];
    $mm =$_POST['mm'];
    $dd =$_POST['dd'];
    $gender =$_POST['gender'];
    if(isset($Fusername)&&isset($password)&&!empty($Vemail)&&isset($Ffirstname)&&isset($Flastname)&&isset($faddress)&&
    isset($country)&&isset($yy)&&isset($mm)&&isset($dd)&&isset($gender)){
        if(isset($_POST['confirm'])){
            $pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
            if(!preg_match($pattern,$password)){
                echo "Weak or invalid password!<br>".
                "The password must have length of 8 or more and must contain a number, capital letter and a special character";
            }else{
                $sequel="SELECT * FROM users WHERE username='$Fusername'";
                $que=mysqli_query($connection,$sequel) or die(mysqli_error($connection));
                if (mysqli_num_rows($que) > 0) {
                    echo "An user with $Fusername already exists. Please use different username.";
                }else{
                    $pass=md5($_POST['password']);
                    $sql="INSERT INTO users(firstname,lastname,username,password,email,address,country,yyyy,mm,dd,gender)
                    VALUES('$Ffirstname','$Flastname','$Fusername','$pass','$Vemail','$faddress','$fcountry','$yy','$mm','$dd','$gender')";

                    $query=mysqli_query($connection,$sql) or die(mysqli_error($connection));
                    if($query){
                        echo "Successfully Registered. </br>";
                        echo '<strong>Please <a href="./Login.php">Login.</a></strong>';
                    }
                    
                }
            }
        }else{
            echo "Terms and conditions must be agreed before proceeding.";
        }
    }else{
        echo "All fields are required for registration. Please check the fields above.";
    }
}
?>   
</body>
</html>