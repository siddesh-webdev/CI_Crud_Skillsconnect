<?php
class UserDetails extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('PlayerModel');
        $this->load->helper(array('form', 'url'));

    }

    public function addPlayer()
    {

        if (isset($_POST['send'])) {

            // echo "<pre>";
            // print_r($_FILES['profile']);
            // exit;

            $config['upload_path'] = './upload/';

            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload', $config);

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('profile')) {
                $error = array('error' => $this->upload->display_errors());


            } else {
                $data = $this->upload->data();
                $img_path = base_url('upload/' . $data['file_name']);

                $_POST['profile'] = $img_path;
            }

            $img_p = $_POST['profile'];
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            $contact = $this->input->post('contact');
            $gender = $this->input->post('gender');
            $master_id = $this->input->post('master_id');

            $data = array(
                'master_id' => $master_id,
                'name' => $name,
                'email' => $email,
                'contact' => $contact,
                'profile' => $img_p,
                'gender' => $gender
            );

            $this->PlayerModel->insert_player($data);

            $eid = $this->PlayerModel->fetch_last_inserted_id();

            $addressCount = 1;
            // Iterate through each address field
            for ($i = 1; $i < 5; $i++) {
                $addressField = isset($_POST['address_' . $i]) ? trim($_POST['address_' . $i]) : '';
                // Check if the address field is not empty
                if (!empty($addressField)) {
                    $addressCount++;
                }

            }
            //adding full address in database
            if ($addressCount == 3) {
                $full_address = $_POST['address'] . ", " . $_POST['address_2'] . ", " . $_POST['address_3'];
            } else if ($addressCount == 2) {
                $full_address = $_POST['address'] . ", " . $_POST['address_2'];
            } else {
                $full_address = $_POST['address'];
            }

            //second address storing in player
            if ($city_id = $this->input->post('city_2')) {
                $data = $this->PlayerModel->fetch_all_id($city_id);

                $data2 = array(
                    'player_id' => $eid,
                    'address' => $full_address,
                    'city_id' => $data['city_id'],
                    'state_id' => $data['state_id'],
                    'country_id' => $data['country_id']

                );

                $table_name = 'player_address';
                $this->PlayerModel->insert_player_ad($table_name, $data2);

            }

            if ($city_id = $this->input->post('city_3')) {
                $data = $this->PlayerModel->fetch_all_id($city_id);

                $data2 = array(
                    'player_id' => $eid,
                    'address' => $full_address,
                    'city_id' => $data['city_id'],
                    'state_id' => $data['state_id'],
                    'country_id' => $data['country_id']
                );


                $table_name = 'player_address';
                $this->PlayerModel->insert_player_ad($table_name, $data2);
            }

            $city_id = $this->input->post('city');

            $data = $this->PlayerModel->fetch_all_id($city_id);


            $data2 = array(
                'player_id' => $eid,
                'address' => $full_address,
                'city_id' => $data['city_id'],
                'state_id' => $data['state_id'],
                'country_id' => $data['country_id']
            );


            $table_name = 'player_address';
            $this->PlayerModel->insert_player_ad($table_name, $data2);
            $this->session->set_flashdata('success', 'succesfully user registration');
            echo 'inserted';


        }
    }


    public function getPlayer()
    {

        $name = $this->session->userdata('name');
        $Alldata = $this->PlayerModel->getAll_playerdtl();
        $table_data = "";
        $i = 1;

        foreach ($Alldata as $data) {

            $table_data .= "
                    <tr>
                        <td>$i</td>
                        <td>
                             <b>$name</b>
                        </td>
                        <td>
                        <img src='$data->profile' width='55px'>
                        <br>
                             $data->name 
                        </td>
                        <td>
                            <b>$data->email</b>
                        </td>
                        <td>
                            <b>$data->gender</b> 
                        <br>
                        </td>
                        <td>
                            <b>$data->contact</b> 
                        </td>
                        <td>
                            <b>$data->address</b> 
                        </td>
                        <td>
                            <button type='button' onclick='edit_details($data->bo_id)' class='btn mb-2 text-white btn-sm fw-bold btn-primary shadow-none' data-bs-toggle='modal' data-bs-target='#editModel'>
                                <i class='bi bi-pencil-square'></i> Edit
                            </button>
                            <button type='button' onclick='delete_user($data->bo_id)' class='btn mb-2 btn-outline-danger btn-sm fw-bold shadow-none'>
                                <i class='bi bi-trash'></i> Delete
                            </button>
                        </td>
                    </tr>
                ";
            $i++;
        }

        $output = json_encode(["table_data" => $table_data]);
        echo $output;

    }

    public function givemeAddress()
    {
        $id = $_POST['id'];

        $Alldata = $this->PlayerModel->getAllAddress($id);

        $address_data = "";

        $i = 1;


        $countries = $this->AjaxModel->fetch_country();

        foreach ($Alldata['address_details'] as $data) {

            // Append HTML for each address
            // echo "<pre>";
            // print_r($data->city_id);
            // echo "<br>";
            // print_r($data->country_id);
            // echo "<br>";
            // print_r($data->state_id);
            // exit;
            $address_data .= '
            <div class="row">
                <div class="col-md-12">
                    <label class="form-label">Address line</label>
                    <textarea id="address_' . $i . '" name="address_' . $i . '" class="form-control shadow-none" rows="1" required>' . $data->address . '</textarea>
                </div>
                <div class="col-md-4 mb-3 mt-2">
                    <label class="form-label">Country</label>
                    <select id="countrys_' . $i . '" name="country_' . $i . '" class="form-select country1" aria-label="Default select example" row_count="' . $i . '" pre_state = "' . $data->state_id . '"  >
                        <option value="" >Select country </option>';

            foreach ($countries as $country) {

                $selected = ($country->id == $data->country_id) ? 'selected' : '';

                $address_data .= '<option value="' . $country->id . '" ' . $selected . '>' . $country->name . '</option>';
            }
            $address_data .= '
                    </select>
                </div>
                <div class="col-md-4 mt-2">
                    <label class="form-label">State</label>
                    
                    <select id="states_' . $i . '" name="state_' . $i . '" class="form-select statesscs" aria-label="Default select example" row_count="' . $i . '" pre_city="' . $data->city_id . '" pres_state = "' . $data->state_id . '">
                        <option value="" >Select state</option>
                    </select>
                </div>
                

                <div class="col-md-4 mt-2">
                    <label class="form-label">City</label>
                    <input type="hidden" name="pre_city_' . $i . '" id="pre_city_' . $i . '" value="' . $data->city_id . '" /> 
                    <select id="citys_' . $i . '" name="city_' . $i . '" class="form-select" aria-label="Default select example">
                        <option value="">Select city</option>
                    </select>
                </div>
            </div>';
            $i++;


        }

        // Echo or return the generated HTML
        echo $address_data;
    }


    public function removePlayer()
    {
        if (isset($_POST['remove_user'])) {
            $id = $this->input->post('user_id');

            if ($this->PlayerModel->delPlayer($id)) {

                echo 1;
            } else {

                echo 0;

            }
        }
    }

    public function editPlayer()
    {
        if (isset($_POST['get_player'])) {
            $id = $this->input->post('get_player');

            $count = $this->AjaxModel->fetch_Address_count($id);

            $data = $this->PlayerModel->getPlayer($id);


            echo $data;
        }
    }


    public function submiteditPlayer()
    {
        if (isset($_POST['edit_user'])) {
            
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $player_id = $this->input->post('player_id');
            $contact = $this->input->post('contact');
            $gender = $this->input->post('gender');

            $config['upload_path'] = './upload/';

            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload', $config);

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('profile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = $this->upload->data();
                $img_path = base_url('upload/' . $data['file_name']);
                $_POST['profile'] = $img_path;
                $img_p = $_POST['profile'];

                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'contact' => $contact,
                    'profile' => $img_p,
                    'gender' => $gender
                );

                $this->PlayerModel->updatePlayer($player_id, $data);
            }

            $data = array(
                'name' => $name,
                'email' => $email,
                'contact' => $contact,
                'gender' => $gender
            );




            $addressCount = 1;
            // Iterate through each address field
            for ($i = 1; $i < 5; $i++) {
                $addressField = isset($_POST['address_' . $i]) ? trim($_POST['address_' . $i]) : '';
                // Check if the address field is not empty
                if (!empty($addressField)) {
                    $addressCount++;
                }

            }
            //adding full address in database
            if ($addressCount == 3) {
                $full_address = $_POST['address'] . ", " . $_POST['address_2'] . ", " . $_POST['address_3'];
            } else if ($addressCount == 2) {
                $full_address = $_POST['address'] . ", " . $_POST['address_2'];
            } else {
                $full_address = $_POST['address'];
            }



            if (isset($_POST['city'])) {
                $city_id = $this->input->post('city');
                $state_id = $this->input->post('state');
                $country_id = $this->input->post('country');

                $data2 = array(
                    'address' => $full_address,
                    'country_id' => $country_id,
                    'state_id' => $state_id,
                    'city_id' => $city_id
                );
                if ($this->PlayerModel->updatePlayerAd($player_id, $data2)) {
                    echo 1;
                } else {
                    return false;
                }
            }

            if ($this->PlayerModel->updatePlayer($player_id, $data)) {
                echo 1;
            } else {
                return false;
            }


        }
    }
}
?>