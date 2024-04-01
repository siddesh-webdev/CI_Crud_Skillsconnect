<?php

class AjaxModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function fetch_country()
    {
        $this->db->order_by("name", "ASC");
        $query = $this->db->get("countries");
        return $query->result();

    }

   function fetch_Address_count($id)
   {
    $this->db->where('player_id', $id);
    $query = $this->db->get("player_address");
    return $query->num_rows();
   }

    function fetch_state($country_id)
    {
        $this->db->where("country_id", $country_id);
        $this->db->order_by("name", "ASC");
        $query = $this->db->get("states");
        $output = '<option value="">Select State</option>';
        foreach ($query->result() as $row) {
            $output .= '<option value ="' . $row->id . '">' . $row->name . '</option>';
        }
        return $output;
    }

    function fetch_city($state_id)
    {
        $this->db->where("state_id", $state_id);
        $this->db->order_by("name", "ASC");
        $query = $this->db->get("cities");
        $output = '<option value="">Select City</option>';
        foreach ($query->result() as $row) {
            $output .= '<option value ="' . $row->id . '">' . $row->name . '</option>';
        }
        return $output;
    }

    function insert_user($data)
    {
        $this->db->insert('user_dtl', $data);
    }
    public function fetch_last_inserted_id()
    {
        $this->db->select('LAST_INSERT_ID() AS eid');
        $query = $this->db->get();
        return $query->row()->eid;
    }

    function fetch_all_id($city_id)
    {
        $this->db->select('id, state_id, country_id');
        $this->db->from('cities');
        $this->db->where('id', $city_id);
        $query = $this->db->get();

        // Check if the query returned any rows
        if ($query->num_rows() > 0) {
            // Fetch the result row
            $row = $query->row_array();

            // Return an array with city ID, state ID, and country ID
            $data = array(
                'city_id' => $row['id'],
                'state_id' => $row['state_id'],
                'country_id' => $row['country_id']
            );

            return $data;
        } else {
            // Return false if no data found
            return false;
        }
    }


    function insert_user_ad($table_name, $data)
    {
        $this->db->insert($table_name, $data);
    }

    function checkDetails($email, $password)
    {
        $q = $this->db->where(['email' => $email, 'password' => $password])->get('user_dtl');
        if ($q->num_rows()) {

            $user = $q->row();
            return ['id' => $user->id, 'name' => $user->name];
        }
    }

    
}

?>