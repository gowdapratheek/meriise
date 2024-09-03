<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />


        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
            integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">

        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" type="text/css" href="../assets/css/formstyles.css" />

        <title>Register</title>
    </head>

    <body>

        <header>

            <div class="header-container">
                <div>
                    <img src="../assets/img/mr_logo.png" class="logo1">
                </div>

                <div class="header-text">
                    <h3>MICRO-ENGINEERING CERTIFICATION PROGRAM</h3>
                    <p>DEPT. OF CSE & ME-RIISE, Malnad College of Engneering,Hassan</p>
                </div>
                <div>
                    <img src="../assets/img/mce_logo.png" class="logo2">
                </div>
            </div>

        </header>



        <div class="container">
            <h1 id="register">Registration</h1>

            <form method="POST" action="checkout.php">
                <div class="col-12 col-md-6 first">
                    <div class="form-group">
                        <label for="Name">Name</label>
                        <input name="name" type="text" class="form-control" id="Name" required aria-describedby="text"
                            placeholder="Name" />
                        <small id="text" class="form-text text-muted"> </small>
                    </div>

                </div>

                <div class="col-12 col-md-6 first">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input required name="email" type="email" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Email" />
                    </div>
                </div>

                <div class="col-12 col-md-6 first">

                    <div class="form-group">
                        <label for="phno">Phone No.</label>
                        <input required name="phone" type="tel" class="form-control" id="phno" pattern="[0-9]{10}"
                            aria-describedby="text" placeholder="Phone no." />
                        <small id="text" class="form-text text-muted"> </small>
                    </div>

                </div>
                
                 <div class="col-12 col-md-6 first">
                    <div class="form-group">
                        <label for="Branch">Branch</label>
                        <input name="branch" required type="text" class="form-control" id="branch"
                            placeholder="Branch name" />
                    </div>
                </div>
                
                <div class="col-12 col-md-6 first">
                    <div class="form-group">
                        <label for="USN">USN</label>
                        <input name="USN" required type="text" class="form-control" id="USN"
                            placeholder="USN" />
                    </div>
                </div>
                

                <div class="col-12 col-md-6 first">
                    <div class="form-group">
                        <label for="College">College</label>
                        <input name="college" required type="text" class="form-control" id="college"
                            placeholder="College name" />
                    </div>
                </div>
                
                

                <div class="col-12 col-md-6 first select-courses">
                    <div class="form-group">
                        <small id="small-txt">Student/Faculty</small>
                        <select class="selectpicker" name="selectedUnderstanding" id="selectedUnderstanding">
                            <option value="Student">Student</option>
                            <option value="Faculty">Faculty</option>
                            <option value="Faculty">Other</option>
                        </select>
                    </div>
                </div>



                <div class="col-12 col-md-6 first select-courses w-100">
                    <small id="small-txt">Select your courses</small>
                    <select required multiple class="selectpicker" id='select-courses' name="selectedCourses[]">
                        <?php 
            require_once '../config/db_connect.php';

            $sql = "SELECT * FROM course_list";

            $result = mysqli_query($conn, $sql);

            if(!$result){
              exit("Server error");
            } 
            $html='';
            while($row = mysqli_fetch_assoc($result)){
              
              $html .= "<option data-price =".$row["price"]." value='".$row["title"]."'>".$row["title"]." (&#8377 ".$row["price"].")</option>";
            }
                echo $html;
             ?>
                    </select>
                </div>

                <div class="col-12 col-md-6 first">
                    <div class="total-amount-container">
                        <label>Total Amount</label>
                        <h3 id='total-amount'>&#8377 0.0</h3>
                    </div>
                </div>
                <div class="col-12 col-md-6 first chk-btn">
                    <input type="submit" name="checkout" value="checkout" class="checkout" />
                </div>
            </form>
        </div>

        <button class="scrollupBtn fa fa-angle-up">

        </button>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
        </script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"
            integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg=="
            crossorigin="anonymous"></script>


        <script>
        $(function() {
            $('.selectpicker').selectpicker();
        });
        </script>
        <script src="../assets/js/formscript.js"></script>
    </body>
    <footer>
        <div class="footer-container">
            <p>MICRO-ENGINEERING CERTIFICATION PROGRAM</p>
            <p>Malnad College of Engineering,Hassan</p>
        </div>
    </footer>

</html>