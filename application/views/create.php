<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajax Crud Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/style.css">
</head>

<body class="bg-light">
    <div class="header">
        <div class="container">
            <div class="row">
                <h1 class="heading">User Details C3</h1>
                <div class="col-md-12 d-flex justify-content-end mb-5">
                <button type="button" class="btn btn-outline-dark shadow-none ">
                Log Out</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 pt-2">
                <h4>User</h4>
            
            </div>
            <div class="col-md-6 pt-2  d-flex justify-content-end">
                <a href="javascript:void(0);" onclick=showModal() class="btn btn-primary">Create</a>
            </div>
            <div class="col-md-12 pt-2">
                <table class="table table-strip bg-dark text-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="AddModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="add-form" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center"><i
                                class="bi bi-person-lines-fill fs-3 me-2"></i> Employee Details</h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="image-alert"></div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Name</label>
                                    <input name="name" type="text" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Email</label>
                                    <input name="email" type="email" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-4  mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input name="phonenum" type="number" class="form-control shadow-none" required>
                                </div>


                                <h5 class="modal-title d-flex mb-3"><i class="bi bi-geo-alt-fill me-2 "></i>
                                    Address Details</h5>


                                <!-- Address details -->

                                <div id="addressFields" class="addressFields" row_count="1">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Address line</label>
                                            <textarea id="address" name="address" class="form-control shadow-none"
                                                rows="1" required></textarea>
                                        </div>


                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Country</label>
                                            <select id="country_1" name="country" class="form-select country"
                                                aria-label="Default select example" row_count="1">
                                                <option selected>Select Country </option>
                                                <?php
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo '<option value="' . $row['iso2'] . '">' . $row['name'] . '</option>';
                                                    }
                                                } else {
                                                    echo '<option value="">Country not available</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">State</label>
                                            <select id="state_1" name="state" class="form-select statessc"
                                                aria-label="Default select example" row_count="1">
                                                <option value="">Select state</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">City</label>
                                            <select id="city_1" name="city" class="form-select"
                                                aria-label="Default select example" row_count="1">
                                                <option value="">Select city</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Pin Code</label>
                                            <input name="pincode" type="number" class="form-control shadow-none"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button to add more address fields -->
                                <div class="col-md-6 mb-3">
                                    <button type="button" onclick="addAddressLine()"
                                        class="btn btn-outline-dark shadow-none" row_count="1">Add
                                        more</button>
                                    <!-- <button type="button" onclick="removeAddressLine()"
                                    class="btn btn-outline-dark shadow-none">Remove</button> -->
                                </div>


                            </div>
                        </div>
                        <div class="text-center my-1">
                            <button type="submit" name="submit" class="btn btn-dark shodow-none">Submit
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
<script>
    function showModal() {
        $('#AddModel').modal('show');

        $.ajax({
            url: "<?php echo base_url(); ?>.'index.php/AjaxController/showForm/'",
            type: 'POST',
            data: {},
            dataType: 'json',
            sucess: function (response) {
                console.log(response);
            }
        });
    }


</script>