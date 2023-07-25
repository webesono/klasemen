<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Sidebar extends CI_Model
{

    private $tableA = 'menu';


    public function getSidebarMenu()
    {
        $this->db->select('*')
            ->from($this->tableA)
            ->where([
                // 'id_role' => $id_role,
                'is_active' => '1'
            ]);
        return $this->db->get()->result_array();
    }
}
