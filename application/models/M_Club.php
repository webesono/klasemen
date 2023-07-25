<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Club extends CI_Model
{
    private $t_club = 'clubs';
    private $t_match_detail = 'match_detail';
    private $t_match_status = 'match_status';

    public function getClub()
    {
        $this->db->select('*')
            ->from($this->t_club);
        return $this->db->get();
    }

    public function getMatchStatus()
    {
        $this->db->select('*')
            ->from($this->t_match_status);
        return $this->db->get();
    }

    public function getMatchDetail()
    {
        $this->db->select('*')
            ->from($this->t_match_detail);
        return $this->db->get();
    }

    public function postClub($param)
    {
        $data = [
            'club_name' => $param['name'],
            'kota' => $param['city'],
        ];
        $this->db->insert('clubs', $data);
        return [
            'success' => true
        ];
    }

    public function postMatch($param)
    {
        $this->db->trans_start();

        foreach ($param as $key => $m) {
            $status = $this->getMatchStatus()->result_array();
            $status_p1 = 0;
            $status_p2 = 0;
            if ($m['player1']['goal'] > $m['player2']['goal']) {
                $status_p1 = (int)search($status, ['inisial' => 'm'])[0]['id'];
                $status_p2 = (int)search($status, ['inisial' => 'k'])[0]['id'];
            } elseif ($m['player2']['goal'] > $m['player1']['goal']) {
                $status_p2 = (int)search($status, ['inisial' => 'm'])[0]['id'];
                $status_p1 = (int)search($status, ['inisial' => 'k'])[0]['id'];
            } elseif ($m['player2']['goal'] == $m['player1']['goal']) {
                $status_p2 = (int)search($status, ['inisial' => 's'])[0]['id'];
                $status_p1 = (int)search($status, ['inisial' => 's'])[0]['id'];
            }
            $input = [
                'desc' => 'match ' . $key,
                'detail' => [
                    [
                        'club_id' => $m['player1']['club'],
                        'match_status_id' => $status_p1,
                        'gm_num' => $m['player1']['goal'],
                        'gk_num' => $m['player2']['goal']
                    ],
                    [
                        'club_id' => $m['player2']['club'],
                        'match_status_id' => $status_p2,
                        'gm_num' => $m['player2']['goal'],
                        'gk_num' => $m['player1']['goal']
                    ],
                ]
            ];
            //PROSES
            //Input Match
            $data_match = ['desc' => $input['desc']];
            $this->db->insert('matches', $data_match);
            $match_id = $this->db->insert_id();
            // Input match_detail
            foreach ($input['detail'] as $d) {
                $data_detail = [
                    'match_id' => $match_id,
                    'club_id' => $d['club_id'],
                    'match_status_id' => $d['match_status_id'],
                    'gm_num' => $d['gm_num'],
                    'gk_num' => $d['gk_num'],
                ];
                $this->db->insert('match_detail', $data_detail);
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return [
                'success' => false,
                'message' => 'Gagal ketika menambahkan data ke databse'
            ];
        } else {
            $this->db->trans_complete();
            return [
                'success' => true,
                'message' => 'Berhasil tambah data'
            ];
        }
    }
}
