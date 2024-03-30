

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
    data.append('profile', add_form.elements['profile'].value);
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

    xhr.open('POST', '<?php echo base_url();?>UserDetails/addPlayer', true);

    xhr.onload = function () {

        if (this.responseText == 'ins_failed') {
            alert("Cannot add!");
            add_form.reset();
        }
        else if (this.responseText == 'inserted')
        {
            alert("Player Added");
            add_form.reset();
    
        }
      
    }
    xhr.send(data);

});

function get_players()
{

let xhr = new XMLHttpRequest();

xhr.open('POST','<?php echo base_url();?>UserDetails/getPlayer',true);

xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

xhr.onload = function()
{ 
    alert(this.responseText);
   let data=JSON.parse(this.responseText);
   document.getElementById('table-data').innerHTML=data.table_data;       
}
xhr.send('get_players');
}


window.onload=function(){
  get_players();
 }
</script>