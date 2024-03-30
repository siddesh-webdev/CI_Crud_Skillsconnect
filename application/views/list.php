<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://ajax.cdnjs.com/ajax/libs/json2/20110223/json2.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body class="bg-light">
    <nav id="nav-bar" class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="">
            </a>
            <button class="navbar-toggler shadow-none " type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link me-2 text-dark fw-bold" href="#">Welcome
                            <?php echo $_SESSION['name']; ?>
                        </a>
                    </li>
                </ul>
                <div class="d-flex">
                    <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal"
                        data-bs-target="#AddModel">
                        Add Team
                    </button>
                    <a href="<?php echo base_url(); ?>AjaxController/logoutNow/" style="text-decoration:none"
                        class="btn btn-outline-dark shadow-none me-lg-3 me-2">Log Out</a>

                </div>
            </div>
        </div>
    </nav>


    <!-- table of employee -->
    <div class="container" id="main-content">
        <div class="row">
            <div class="col ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Player Records</h3>
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-hover border" style="min-width: 1200px;">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Player</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Contact</th>
                                        <th scope="col">Address </th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">

                                </tbody>
                            </table>
                        </div>

                        <nav>
                            <ul class="pagination mt-3" id="table-pagination">

                            </ul>
                        </nav>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- add model -->
    <div class="modal fade" id="AddModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="add-form" enctype="multipart/form-data" method="post"
                    action="<?= base_url() ?>UserDetails/addPlayer">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center"><i
                                class="bi bi-person-lines-fill fs-3 me-2"></i> Team Details</h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Player Name</label>
                                    <input name="name" type="text" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Email</label>
                                    <input name="email" type="email" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-4  mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input name="contact" type="number" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Picture</label>
                                    <input name="profile" type="file" accept=".jpg, .jpeg, .png, .webp"
                                        class="form-control shadow-none" required>

                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-select" aria-label="Default select example">
                                        <option selected>Select Gender </option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>

                                <h5 class="modal-title d-flex mb-3"><i class="bi bi-geo-alt-fill me-2 "></i> Address
                                    Details
                                </h5>

                                <!-- Address details -->

                                <div id="addressFields" class="addressFields" row_count="1">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Address line</label>
                                            <textarea id="address" name="address" class="form-control shadow-none"
                                                rows="1" required></textarea>
                                        </div>
                                        <div class="col-md-4 mb-3 mt-2">
                                            <label class="form-label">Country</label>
                                            <?php
                                            $options = array('' => 'Select Country');
                                            foreach ($countries as $row) {
                                                $options[$row->id] = $row->name;
                                            }
                                            echo form_dropdown('country', $options, '', 'id="country_1" class="form-select country" aria-label="Default select example" row_count="1"');
                                            ?>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label class="form-label">State</label>
                                            <select id="state_1" name="state" class="form-select statessc"
                                                aria-label="Default select example" row_count="1">
                                                <option value="">Select state</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label class="form-label">City</label>
                                            <select id="city_1" name="city" class="form-select"
                                                aria-label="Default select example" row_count="1">
                                                <option value="">Select city</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button to add more address fields -->
                                <div class="col-md-6 mb-3">
                                    <button type="button" onclick="addAddressLine()"
                                        class="btn btn-outline-dark shadow-none" row_count="1">Add
                                        more</button>
                                </div>


                            </div>
                        </div>
                        <div class="text-center my-1">
                            <button type="submit" class="btn btn-dark shodow-none">Submit </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Edit model -->
    <div class="modal fade" id="editModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="edit_form" enctype="multipart/form-data" method="post" action="">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center"><i
                                class="bi bi-person-lines-fill fs-3 me-2"></i> Team Details</h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Player Name</label>
                                    <input name="name" type="text" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Email</label>
                                    <input name="email" type="email" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-4  mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input name="contact" type="number" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Picture</label>
                                    <input name="profile" type="file" accept=".jpg, .jpeg, .png, .webp"
                                        class="form-control shadow-none" required>

                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-select" aria-label="Default select example">
                                        <option selected>Select Gender </option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>

                                <h5 class="modal-title d-flex mb-3"><i class="bi bi-geo-alt-fill me-2 "></i> Address
                                    Details
                                </h5>

                                <!-- Address details -->

                                <div id="addressFields" class="addressFields" row_count="1">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Address line</label>
                                            <textarea id="address" name="address" class="form-control shadow-none"
                                                rows="1" required></textarea>
                                        </div>
                                        <div class="col-md-4 mb-3 mt-2">
                                            <label class="form-label">Country</label>
                                            <?php
                                            $options = array('' => 'Select Country');
                                            foreach ($countries as $row) {
                                                $options[$row->id] = $row->name;
                                            }
                                            echo form_dropdown('country', $options, '', 'id="country_1" class="form-select country" aria-label="Default select example" row_count="1"');
                                            ?>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label class="form-label">State</label>
                                            <select id="state_1" name="state" class="form-select statessc"
                                                aria-label="Default select example" row_count="1">
                                                <option value="">Select state</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label class="form-label">City</label>
                                            <select id="city_1" name="city" class="form-select"
                                                aria-label="Default select example" row_count="1">
                                                <option value="">Select city</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button to add more address fields -->
                                <div class="col-md-6 mb-3">
                                    <button type="button" onclick="addAddressLine()"
                                        class="btn btn-outline-dark shadow-none" row_count="1">Add
                                        more</button>
                                </div>


                            </div>
                        </div>
                        <div class="text-center my-1">
                            <button type="submit" class="btn btn-dark shodow-none">Submit </button>
                        </div>
                    </div>
                </form>
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
            addressLine.innerHTML = '<div class="row">' +
                '<div class="col-md-12">' +
                '<label class="form-label">Address line</label>' +
                '<textarea id="address_' + row_count + '" name="address_' + row_count + '" class="form-control shadow-none" rows="1" required></textarea>' +
                '</div>' +
                '<div class="col-md-4 mb-3 mt-2">' +
                '<label class="form-label">Country</label>' +
                '<select id="country_' + row_count + '" name="country_' + row_count + '" class="form-select country" aria-label="Default select example" row_count="' + row_count + '">' +
                '<option selected>Select Country</option>' +
                '<?php foreach ($countries as $row) { ?>' +
                    "<option value='<?= $row->id ?>'><?= $row->name ?></option>" +
                    '<?php } ?>' +
                '</select></div><div class="col-md-4 mt-2">' +
                '<label class="form-label">State</label>' +
                '<select id="state_' + row_count + '" name="state_' + row_count + '" class="form-select statessc" aria-label="Default select example" row_count="' + row_count + '">' +
                '<option value="">Select state</option>' +
                '</select>' + '</div>' +
                '<div class="col-md-4 mt-2">' +
                '<label class="form-label">City</label>' +
                '<select id="city_' + row_count + '" name="city_' + row_count + '" class="form-select" aria-label="Default select example">' +
                '<option value="">Select city</option>' +
                '</select>' +
                '</div>';


            container.appendChild(addressLine);
        } else {
            alert('error', "You have reached the maximum limit of address lines.", 'image-alert');
        }
    }

    let add_form = document.getElementById('add-form');

    add_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();
        data.append('name', add_form.elements['name'].value);
        data.append('email', add_form.elements['email'].value);
        data.append('contact', add_form.elements['contact'].value);
        data.append('profile', add_form.elements['profile'].files[0]);
        data.append('gender', add_form.elements['gender'].value);

        data.append('state', add_form.elements['state'].value);
        data.append('country', add_form.elements['country'].value);
        data.append('city', add_form.elements['city'].value);
        data.append('address', add_form.elements['address'].value);

        data.append('master_name', '<?php echo $_SESSION['name']; ?>');
        data.append('master_id', '<?php echo $_SESSION['id']; ?>');

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
        data.append('send', '');

        var myModal = document.getElementById('AddModel');
        var modal = bootstrap.Modal.getInstance(myModal); // Returns a Bootstrap modal instance
        modal.hide();

        let xhr = new XMLHttpRequest();

        xhr.open('POST', '<?php echo base_url(); ?>UserDetails/addPlayer', true);

        xhr.onload = function () {
            if (this.responseText == 'ins_failed') {
                alert("Cannot add!");
                add_form.reset();
            }
            else {
                add_form.reset();
                alert("Player Added");
                get_players();
            }

        }
        xhr.send(data);

    });


    let edit_form = document.getElementById('edit_form');

    function edit_details(id) {

        let xhr = new XMLHttpRequest();

        xhr.open('POST', '<?php echo base_url(); ?>UserDetails/editPlayer', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {

            let data = JSON.parse(this.responseText);

            edit_form.elements['name'].value = data.player_details.name;
            edit_form.elements['email'].value = data.player_details.email;
            edit_form.elements['contact'].value = data.player_details.contact;
            // edit_form.elements['profile'].file[0] = data.player_details.profile;
            edit_form.elements['gender'].value = data.player_details.gender;
            edit_form.elements['address'].value = data.address_details.address;
            // edit_form.elements['state'].value = data.address_details.state_id;
            // edit_form.elements['city'].value = data.address_details.city_id;
            // edit_form.elements['country'].value = data.address_details.country_id;

            // let stateSelect = document.getElementById('state_1');
            // let citySelect = document.getElementById('city_1');

            let countrySelect = edit_form.elements['country'];
           
            let countryOptions = countrySelect.options;
            for (let i = 0; i < countryOptions.length; i++) {
                if (countryOptions[i].value === data.address_details.country_id) {
                    countrySelect.selectedIndex = i;
                    break;
                }
            }

           
            let stateSelect = edit_form.elements['state'];
            // let state_id =data.address_details.state_id;
            let stateOptions = stateSelect.options;

            for (let i = 0; i < stateOptions.length; i++) {

                if (stateOptions[i].value === data.address_details.state_id) {
                    stateSelect.selectedIndex = i;
                    break;
                }
            }

       
            let citySelect = edit_form.elements['city'];
       
            let cityOptions = citySelect.options;
            for (let i = 0; i < cityOptions.length; i++) {
                if (cityOptions[i].value === data.address_details.city_id) {
                    citySelect.selectedIndex = i;
                    break;
                }
            }


        }
        xhr.send('get_player=' + id);

    }

    edit_form.addEventListener('submit', function (e) {
        e.preventDefault();
        submit_edit();
    });


    function get_players() {

        let xhr = new XMLHttpRequest();

        xhr.open('POST', '<?php echo base_url(); ?>UserDetails/getPlayer', true);

        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {

            let data = JSON.parse(this.responseText);
            document.getElementById('table-data').innerHTML = data.table_data;

        }

        xhr.send('get_players');
    }

    function delete_user(user_id) {

        if (confirm("are you sure ,you want to remove this user?")) {

            let data = new FormData();
            data.append('user_id', user_id);
            data.append('remove_user', '');

            let xhr = new XMLHttpRequest();

            xhr.open('POST', '<?php echo base_url(); ?>UserDetails/removePlayer', true);

            xhr.onload = function () {

                if (this.responseText == 1) {
                    alert('User Removed..!');
                    get_players();
                }
                else {
                    alert('User Removal Failed!');
                }
            }
            xhr.send(data);
        }

    }



    window.onload = function () {
        get_players();
    }
</script>