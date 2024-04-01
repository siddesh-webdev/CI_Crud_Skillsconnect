<?php
class AjaxController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('AjaxModel');

    }
    public function index()
    {

        $this->load->view('home');
    }

    public function User_in()
    {
        if (!$this->session->userdata('id'))
            redirect('AjaxController/index');

        $data['countries'] = $this->AjaxModel->fetch_country();

        $this->load->view("list", $data);

    }
    public function fetchingCount(){

        $player_id=1;

        $address_count = $this->AjaxModel->fetch_Address_count($player_id);

    } 

    public function signUp()
    {

        $data['countries'] = $this->AjaxModel->fetch_country();

        $this->load->view('signup', $data);
    }

    function fetch_state()
    {
        if ($this->input->post("country_id")) {
            echo $this->AjaxModel->fetch_state($this->input->post("country_id"));

        }
    }

    function fetch_city()
    {
        if ($this->input->post("state_id")) {
            echo $this->AjaxModel->fetch_city($this->input->post("state_id"));

        }
    }

    function registerNow()
    {
        if (isset($_POST['add'])) {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $contact = $this->input->post('contact');

            $data = array(
                'name' => $name,
                'email' => $email,
                'contact' => $contact,
                'password' => $password
            );
            $this->AjaxModel->insert_user($data);

            $eid = $this->AjaxModel->fetch_last_inserted_id();

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

            //second adress storing
            if ($city_id = $this->input->post('city_2')) {
                $data = $this->AjaxModel->fetch_all_id($city_id);

                $data2 = array(
                    'user_id' => $eid,
                    'address' => $full_address,
                    'city_id' => $data['city_id'],
                    'state_id' => $data['state_id'],
                    'country_id' => $data['country_id'],
                    'pincode' => $this->input->post('pincode')
                );


                $table_name = 'address_table';
                $this->AjaxModel->insert_user_ad($table_name, $data2);

            }

            if ($city_id = $this->input->post('city_3')) {
                $data = $this->AjaxModel->fetch_all_id($city_id);

                $data2 = array(
                    'user_id' => $eid,
                    'address' => $full_address,
                    'city_id' => $data['city_id'],
                    'state_id' => $data['state_id'],
                    'country_id' => $data['country_id'],
                    'pincode' => $this->input->post('pincode')
                );


                $table_name = 'address_table';
                $this->AjaxModel->insert_user_ad($table_name, $data2);
            }

            $city_id = $this->input->post('city');

            $data = $this->AjaxModel->fetch_all_id($city_id);


            $data2 = array(
                'user_id' => $eid,
                'address' => $full_address,
                'city_id' => $data['city_id'],
                'state_id' => $data['state_id'],
                'country_id' => $data['country_id'],
                'pincode' => $this->input->post('pincode')
            );


            $table_name = 'address_table';
            $this->AjaxModel->insert_user_ad($table_name, $data2);
            $this->session->set_flashdata('success', 'succesfully user registration');
            echo 'inserted';


        }
    }
    function loginNow()
    {

        if ((isset($_POST['login']))) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $user_info = $this->AjaxModel->checkDetails($email, $password);
            if ($user_info) {
                $_SESSION['login'] = true;
                $this->session->set_userdata('id', $user_info['id']);
                $this->session->set_userdata('name', $user_info['name']);
                echo 1;
            } else {
                echo "failed";
            }
        }
    }

    

    function logoutNow()
    {
        $this->session->sess_destroy();
        $this->load->view('home');
    }

}
