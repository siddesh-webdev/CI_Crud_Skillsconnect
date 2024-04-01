<?php
class PlayerModel extends CI_Model
{


    function insert_player($data)
    {
        $this->db->insert('player_dtl', $data);
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

    function insert_player_ad($table_name, $data)
    {
        $this->db->insert($table_name, $data);
    }

    function getAll_playerdtl()
    {
        $master_id = $this->session->userdata('id');

        // $query = $this->db->select('bo.*, bd.*,bo.id as bo_id')
        //     ->from('player_dtl bo')
        //     ->join('player_address bd', 'bo.id = bd.player_id')

        //     ->where('bo.master_id=' . $master_id)

        //     ->where('bo.status', 1)

        //     ->get();

        $subquery = $this->db->select('MAX(id) as id, player_id, MAX(address) as address')
            ->from('player_address')
            ->group_by('player_id')
            ->get_compiled_select();

        $query = $this->db->select('bo.*, bd.*, bo.id as bo_id')
            ->from("($subquery) bd")
            ->join('player_dtl bo', 'bo.id = bd.player_id', 'left')
            ->where('bo.master_id', $master_id)
            ->where('bo.status', 1)
            ->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function delPlayer($id)
    {
        return $this->db->where('id', $id)
            ->set('status', 0)
            ->update('player_dtl');
    }

    function getPlayer($id)
    {
        $player_details = $this->db->select('*')
            ->from('player_dtl')
            ->where('id', $id)
            ->get()
            ->row();

        $address_details = $this->db->select('state_id, country_id, city_id,address')
            ->from('player_address')
            ->where('player_id', $id)
            ->get()
            ->row();

        $result = array(
            'player_details' => $player_details,
            'address_details' => $address_details
        );

        $result = json_encode($result);

        return $result;


    }

    function updatePlayer($id, $data)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('player_dtl', $data);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function updatePlayerAd($id, $data)
    {
        $this->db->where('player_id', $id);
        $result = $this->db->update('player_address', $data);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function getAlladdress($id)
    {
        $this->db->where('player_id', $id);
        $query = $this->db->get("player_address");

    
        $address_details = $query->result();
    
        $address_count = $query->num_rows();
    
        // Return both address details and count as an array
        return array(
            'address_details' => $address_details,
            'address_count' => $address_count
        );
    }
}
?>