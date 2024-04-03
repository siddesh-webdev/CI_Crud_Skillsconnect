<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/style.css">
</head>

<body class="bg-light">
    <div class="container">
        <div class="login-form text-center rounded overflow-hidden shadow">
            <?php echo form_open('AjaxController/registerNow',['id'=>'add-form']); ?>
            <h4 class="bg-dark text-white py-3">Signup Page </h4>
            <div class="row p-4">
                <div class="col-md-6 mb-3">
                    <?php echo form_input(['name' => 'name', 'type' => 'text', 'class' => 'form-control shadow-none', 'placeholder' => 'Name', 'required' => 0]); ?>
                </div>
                <div class="col-md-6 mb-3">
                    <?php echo form_input(['name' => 'email', 'type' => 'email', 'class' => 'form-control shadow-none', 'placeholder' => 'Email', 'required' => 0]); ?>
                </div>
                <div class="col-md-6 mb-3">
                    <?php echo form_input(['name' => 'contact', 'type' => 'number', 'class' => 'form-control shadow-none', 'placeholder' => 'Contact', 'required' => 0]); ?>
                </div>
                <div class="col-md-6 mb-3">
                    <?php echo form_password(['name' => 'pass', 'type' => 'password', 'class' => 'form-control shadow-none', 'placeholder' => 'Password', 'required' => 0]); ?>
                </div>
                <div id="addressFields" class="addressFields" row_count="1">
                    <div class="mb-3">
                        <?php echo form_textarea(['id' => 'address', 'name' => 'address', 'rows' => "1", 'class' => 'form-control shadow-none', 'placeholder' => 'Address', 'required' => 0]); ?>
                    </div>
                    <div class="mb-3">
                        <?php
                        $options = array('' => 'Select Country');
                        foreach ($countries as $row) {
                            $options[$row->id] = $row->name;
                        }
                        echo form_dropdown('country', $options, '', 'id="country_1" class="form-select country" aria-label="Default select example" row_count="1"');
                        ?>
                    
                    </div>
                    <div class="mb-3">
                        <?php
                        $options = array('' => 'Select state');
                        echo form_dropdown('state', $options, '', ' id="state_1" name="state" class="form-select statessc"
                         aria-label="Default select example" row_count="1"');
                        ?>
                    </div>
                    <div class="mb-3">
                        <?php
                        $options = array('' => 'Select city');
                        echo form_dropdown('city', $options, '', ' id="city_1" name="city" class="form-select"
                         aria-label="Default select example" row_count="1"');
                        ?>
                    </div>
                </div>
                <div class="mb-3">
                    <?php echo form_input(['name' => 'pincode', 'type' => 'number', 'class' => 'form-control shadow-none', 'placeholder' => 'Pincode', 'required' => 0]); ?>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <?php echo form_button('button_text', 'Add More', ['type' => 'button', 'onclick' => 'addAddressLine()', 'class' => 'btn btn-sm mb-2 btn-outline-dark shadow-none d-flex justify-content-start', 'row_count' => "1"]); ?>
                           
                            <div class="col-md-4 mt-2">
                            <button name="remove" type="button" class="btn btn-sm btn-danger" onclick="removeAddressLine(this)">Remove</button>
                            </div>
                        </div>
                      
                    </div>
                </div>
                <?php echo form_submit(['name' => "submit", 'type' => "submit", "value" => "Submit", "class" => "btn text-white custom-bg shadow-none"]); ?>
            </div>
        </div>
    </div>

</body>

</html>
<script>

    //fetching state in basis of country  
    $(document).on("change", '.country', function () {

        var country_id = $(this).val();

        var row_count = $(this).attr("row_count");

        if (country_id != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>AjaxController/fetch_state",
                method: "POST",
                data: { country_id: country_id },
                success: function (data) {
                    $('#state_' + row_count).html(data);
                    $('#city_' + row_count).html('<option value="">Select City</option>');
                }
            });
        }
        else {
            $('#state_' + row_count).html('<option value="">Select country first</option>');
            $('#city_' + row_count).html('<option value="">Select state first</option>');
        }
    });
    //fetching city on basis on states
    $(document).on("change", ".statessc", function () {
        var row_count = $(this).attr("row_count");
        var state_id = $(this).val();
        var country_id = $('#country_' + row_count).val();
        if (country_id != '') {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url(); ?>AjaxController/fetch_city",
                data: {
                    state_id: state_id,
                    country_id: country_id
                },
                success: function (data) {
                    $('#city_' + row_count).html(data);
                }
            });
        } else {
            $('#state_' + row_count).html('<option value="">Select country first</option>');
            $('#city_' + row_count).html('<option value="">Select state first</option>');
        }
    });

    function addAddressLine() {
        var container = document.getElementById("addressFields");
        var addressLines = container.getElementsByClassName("row");
        var row_count = $(".addressFields").attr("row_count");

        if (addressLines.length < 5) {
            row_count++;
            $("#addressFields").attr("row_count", row_count);
            // Check if the maximum limit has not been reached       
            var addressLine = document.createElement("div");
            // addressLine.classList.add("row", "mb-3");
            addressLine.innerHTML = '<div class="help mb-3">' +
                '<textarea id="address_' + row_count + '" name="address_' + row_count + '" class="form-control shadow-none" rows="1" placeholder="Address" required></textarea>' +
                '</div>' +
                '<div class="mb-3">' +
                '<select id="country_' + row_count + '" name="country_' + row_count + '" class="form-select country" aria-label="Default select example" row_count="' + row_count + '">' +
                '<option selected>Select Country</option>' +
                '<?php foreach ($countries as $row) { ?>' +
                    "<option value='<?= $row->id ?>'><?= $row->name ?></option>" +
                    '<?php } ?>' +
                '</select>' +
                '</div>' +
                '<div class="mb-3">' +
                '<select id="state_' + row_count + '" name="state_' + row_count + '" class="form-select statessc" aria-label="Default select example" row_count="' + row_count + '">' +
                '<option value="">Select state</option>' +
                '</select>' +
                '</div>' +
                '<div class="mb-3">' +
                '<select id="city_' + row_count + '" name="city_' + row_count + '" class="form-select" aria-label="Default select example">' +
                '<option value="">Select city</option>' +
                '</select>' +
                '</div>';

            container.appendChild(addressLine);
        } else {
            alert("You have reached the maximum limit of address lines.");
        }

    }
    function removeAddressLine(button) {
       var rowToRemove = button.closest('.row');
        rowToRemove.remove();
     
    }

  
    let add_form = document.getElementById('add-form');

    add_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();
        data.append('name', add_form.elements['name'].value);
        data.append('email', add_form.elements['email'].value);
        data.append('contact', add_form.elements['contact'].value);
        data.append('pincode', add_form.elements['pincode'].value);
        data.append('state', add_form.elements['state'].value);
        data.append('country', add_form.elements['country'].value);
        data.append('city', add_form.elements['city'].value);
        data.append('address', add_form.elements['address'].value);
        data.append('password', add_form.elements['pass'].value);

        for (let i = 1; i < 5; i++) {
            if (add_form.elements['address_' + i]) {
                data.append('address_' + i, add_form.elements['address_' + i].value);
            }
        }
        for (let i = 1; i < 5; i++) {
            if (add_form.elements['country_' + i]) {
                data.append('country_' + i, add_form.elements['country_' + i].value);
            }
        }
        for (let i = 1; i < 5; i++) {
            if (add_form.elements['state_' + i]) {
                data.append('state_' + i, add_form.elements['state_' + i].value);
            }
        }
        for (let i = 1; i < 5; i++) {
            if (add_form.elements['city_' + i]) {
                data.append('city_' + i, add_form.elements['city_' + i].value);
            }
        }
        data.append('add', '');

        let xhr = new XMLHttpRequest();

        xhr.open('POST', '<?php echo base_url();?>AjaxController/registerNow', true);

        xhr.onload = function () {

            if (this.responseText == 'ins_failed') {
                alert("Cannot add!");
                add_form.reset();
            }
            else if (this.responseText == 'inserted')
            {
                alert("You have succesfully Register");
                add_form.reset();
                window.location.href='<?php echo base_url();?>AjaxController/index';

            }
          
        }

        xhr.send(data);

    });

</script>