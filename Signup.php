<?php
include('header.php');
include('signup.class.php');
$user = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        "first_name" => $_POST["Fname"],
        "last_name" => $_POST["Lname"],
        "email" => $_POST["email"],
        "phone_number" => $_POST["contact"],
        "password" => $_POST["password"], // Password will be hashed
        "role" => $_POST["role"],
        "address" => $_POST["address"],
        "gender" => $_POST["gender"]
    ];
    if ($user->addUser($data)) {
        echo "<script>alert('User added successfully!');</script>";
    } else {
        echo "<script>alert('Failed to add user.');</script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register user</title>

    <style type="text/css">
        .bottom {
            /* height :500px; */
            position: inherit;
            background-color: rgb(31, 104, 117);
            color: white;
            padding: 20px;
            padding-left: 60px;
            margin: 10px 0px 0px 0px;
        }

        h1 {
            color: white;
            font-weight: lighter;
        }

        .box {
            border: 2px solid transparent;
            background-color: white;
            border-radius: 19px;
            padding: 20px;
            margin-left: 180px;
            margin-bottom: 50px;
            width: 700px;
            height: auto;
            letter-spacing: 1px;
            text-align: center;
        }

        .foot {
            letter-spacing: 1px;
            color: white;
            padding: 20px;
            text-align: center;
            background-color: rgb(26, 83, 93);
        }

        input[type=text],
        input[type=password] {
            width: 70%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: none;
            border-bottom: 2px solid rgb(26, 83, 93);
        }

        #submit,
        #reset,
        #cancel {
            background-color: rgb(31, 104, 117);
            color: white;
            border-radius: 30px;
            width: 100px;
            height: 30px;
            font-size: 1.2em;
            border: 1px solid transparent;
            /* margin: 30px; */
            margin-bottom: 30px;
        }

        #submit:hover,
        #reset:hover,
        #cancel:hover {
            background-color: rgb(26, 83, 93);
            color: white;
            border: none;
        }

        #submit:focus,
        #reset:focus,
        #cancel:focus {
            outline: 0;
        }

        form>a:link,
        form>a:visited {
            text-decoration: none !important;
        }

        form>a:hover {
            color: rgb(26, 83, 93);
            font-size: 1.1em;
            background-color: ghostwhite;
        }

        #input2 {
            font-size: 15px;
            font-weight: lighter;
            width: 470px;
            height: 50px;
            border-bottom: 2px solid rgb(26, 83, 93);
            ;
            background-color: transparent;
            color: black;
            padding-left: 20px;
            margin-top: 10px;
        }

        input,
        textarea:focus {
            outline: 0;
        }

        .radio {
            color: black;
            margin-top: 30px;
            margin-right: 330px;
        }

        .buttons {
            margin-top: 30px;
        }

        #reset {
            margin-left: 50px;
        }
    </style>

    <script>
        function validateForm() {
            let fname = document.forms["login"]["Fname"].value.trim();
            let lname = document.forms["login"]["Lname"].value.trim();
            let contact = document.forms["login"]["contact"].value.trim();
            let email = document.forms["login"]["email"].value.trim();
            let password = document.forms["login"]["password"].value.trim();
            let address = document.forms["login"]["address"].value.trim();
            let role = document.querySelector('input[name="role"]:checked');

            if (fname === "") {
                alert("First Name is required");
                return false;
            }
            if (lname === "") {
                alert("Last Name is required");
                return false;
            }
            if (contact === "" || !/^[0-9]{10}$/.test(contact)) {
                alert("Enter a valid 10-digit contact number");
                return false;
            }
            if (email === "" || !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
                alert("Enter a valid email");
                return false;
            }
            if (password === "" || password.length < 6) {
                alert("Password must be at least 6 characters long");
                return false;
            }
            if (address === "") {
                alert("Address is required");
                return false;
            }
            if (!role) {
                alert("Please select a role");
                return false;
            }
            return true;
        }

        window.onload = function() {
            document.querySelector('input[value="faculty"]').checked = true;
            document.querySelector('input[value="male"]').checked = true;
        };
    </script>
</head>

<body>
    <div class="bottom">
        <h1>Register New User</h1>
        <div class="box">
            <form name="signup" method="post" class="form" onsubmit="return validateForm()">
                <input type="text" name="Fname" placeholder="First Name"><br>
                <input type="text" name="Lname" placeholder="Last Name"><br>
                <input type="text" name="contact" placeholder="Contact Number"><br>
                <input type="text" name="email" placeholder="Email"><br>
                <input type="password" name="password" placeholder="Password"><br>
                <input type="text" name="address" placeholder="Address"><br>
                <div class="radio">
                    <label for="">Gender</label>
                    <input value="male" type="radio" name="gender" />Male&nbsp;
                    <input value="female" type="radio" name="gender" />Female
                </div><br>

                <div class="radio">
                    <label for="">Role</label>
                    <input value="student" type="radio" name="role" />Student&nbsp;
                    <input value="faculty" type="radio" name="role" />Teacher
                </div><br>

                <div class="buttons">
                    <input id="submit" type="submit" value="Submit" />
                    <input id="reset" type="reset" value="Reset" />
                </div>
            </form>
        </div>
    </div>
    <div class="foot">
        Made With <img src="Vector.svg"> By CSE Techies Of KIET-W
    </div>
</body>

</html>