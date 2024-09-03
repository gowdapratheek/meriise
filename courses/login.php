<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- CSS only -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
            integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
            crossorigin="anonymous" />

        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Admin</title>
    </head>

    <body class="p-1 m-2 offset-md-2">
        <div class="container-fluid">

            <div class="flex">

                <div class="flex2">
                    <div class="h3 text-center">Login</div><br />
                </div>
            </div>

            <div class="row">
                <form class="col-8  offset-2" action="login.php" method="post">
                    <div class="form-group">

                        <label>Email address</label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp"
                            placeholder="Enter your email address" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>

                </form>

            </div>


        </div>

        <?php

		require_once 'config/db_connect.php';

		session_start();

		if(isset($_POST['email']) && isset($_POST['password'])){

			$email =mysqli_real_escape_string($conn, $_POST['email']);
			$password = mysqli_real_escape_string($conn,$_POST['password']);
            
            $email = htmlspecialchars(strip_tags($email));
            $password = htmlspecialchars(strip_tags($password));

			$query = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";

			$result = mysqli_query($conn, $query);
			$row = mysqli_fetch_assoc($result);

			$count = mysqli_num_rows($result);

			if($count == 1){
				
				$_SESSION['email'] = $row['email'];
				header("Location: admin/dashboard.php");

			}else{

				echo("<div class='alert alert-danger mt-3 text-center'>Invalid Email/Password</div>");
			
			}

		}

	?>

    </body>

</html>