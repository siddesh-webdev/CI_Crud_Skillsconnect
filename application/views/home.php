<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Panel</title>

    <head>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link
            href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/style.css">
    </head>
    <style>

    </style>
</head>

<body class="bg-light">
    <div class="login-form text-center rounded overflow-hidden shadow">

        <?php echo form_open('AjaxController/loginNow', ['id' => 'login-form']); ?>
        <h4 class="bg-dark text-white py-3">Login Page </h4>
        <div class="p-4">
            <div class="mb-3">
                <?php echo form_input(['name' => 'email', 'type' => 'text', 'class' => 'form-control shadow-none text-center', 'placeholder' => 'Email', 'required' => 0]); ?>
            </div>
            <div class="mb-1">
                <?php echo form_password(['name' => 'pass', 'type' => 'password', 'class' => 'form-control shadow-none text-center', 'placeholder' => 'Password', 'required' => 0]); ?>
            </div>
            <div class="mb-1 mt-2">
                <a href="<?php echo base_url(); ?>AjaxController/signUp/" style="text-decoration:none"
                    class="d-flex justify-content-start">New User ,Signup?</a>
            </div>
            <?php echo form_submit(['name' => "login", 'type' => "submit", "value" => "Login", "class" => "btn text-white custom-bg shadow-none mt-2"]); ?>
        </div>
        </form>

    </div>

</body>

</html>

<script>
    let login_form = document.getElementById('login-form');

    login_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();

        data.append('email', login_form.elements['email'].value);
       
        data.append('password', login_form.elements['pass'].value);
        data.append('login','');

        let xhr = new XMLHttpRequest();

        xhr.open('POST', '<?php echo base_url(); ?>AjaxController/loginNow', true);

        xhr.onload = function () {

            if (this.responseText == 'failed') {
                alert("Wrong Password or Username");
           
            }
            else if (this.responseText == '1') {    

                window.location.href = '<?php echo base_url(); ?>AjaxController/User_in';

            }

        }
        xhr.send(data);

    });



</script>