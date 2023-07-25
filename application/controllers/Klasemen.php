<?php

class Klasemen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('c_helper');
        $this->load->model('M_Sidebar', 'm_sidebar');
        // $this->load->model('M_Auth', 'm_auth');
        $this->load->model('M_Club', 'm_club');
    }

    // ========== HALAMAN ==========
    public function index()
    {

        //data sidebar & navbar || start
        $menu = $this->m_sidebar->getSidebarMenu();
        $data['title'] = 'Klasemen';
        $data['url'] = 'klasemen';
        $data['sub_title'] = 'Daftar Klasemen';
        $data['menu'] = $menu;
        $data['clubs'] = $this->m_club->getClub()->result_array();

        // data sidebar & navbar || end
        viewAdmin($this, 'admin/match', $data);
    }

    // ========== END ==========


    // ========== DATATABLES ==========
    public function getClub()
    {
        $allData = $this->m_club->getMatchDetail()->result_array();
        $status = $this->m_club->getMatchStatus()->result_array();
        // print_r(search($status, ['inisial' => 'm'])[0]['id']);
        // die;
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $query = $this->m_club->getClub();
        // var_dump($tes);
        // die;
        $data = [];

        foreach ($query->result_array() as $key => $r) {
            $clubDetail = search($allData, ['club_id' => $r['id']]);
            $gwn = 0;
            $gln = 0;
            foreach ($clubDetail as $var) {
                $gwn = $gwn + $var['gm_num'];
                $gln = $gln + $var['gk_num'];
            }
            $win = count(search($clubDetail, ['match_status_id' => search($status, ['inisial' => 'm'])[0]['id']]));
            $draw = count(search($clubDetail, ['match_status_id' => search($status, ['inisial' => 's'])[0]['id']]));
            $lose = count(search($clubDetail, ['match_status_id' => search($status, ['inisial' => 'k'])[0]['id']]));
            $data[] = array(
                'no' => $key + 1,
                'club' => $r['club_name'],
                'play' => count($clubDetail),
                'win' => $win,
                'draw' => $draw,
                'lose' => $lose,
                'goal_win_num' => $gwn,
                'goal_lose_num' => $gln,
                'point_num' => ($win * search($status, ['inisial' => 'm'])[0]['point']) + ($draw * search($status, ['inisial' => 's'])[0]['point']) + ($lose * search($status, ['inisial' => 'k'])[0]['point'])
            );
        }
        $result = array(
            "draw" => $draw,
            "recordsTotal" => $query->num_rows(),
            "recordFiltered" => $query->num_rows(),
            "data" => $data
        );
        echo json_encode($result);
    }
    // // ========== END ==========


    // // ========== CRUD ===========

    public function aksiClub()
    {
        $clubs = $this->m_club->getClub()->result_array();
        $rules = [
            [
                'field' => 'name',
                'label' => 'nama club',
                'rules' => 'required|max_length[100]|min_length[2]'
            ],
            [
                'field' => 'city',
                'label' => 'kota',
                'rules' => 'required|max_length[100]|min_length[2]'
            ],

        ];

        $this->form_validation->set_message('required', '{field} harus diisi!');
        $this->form_validation->set_message('max_length', '{field} terlalu panjang');
        $this->form_validation->set_message('min_length', '{field} terlalu pendek');
        $this->form_validation->set_rules($rules);

        $param = $this->input->post();

        if ($param == []) {
            $result = [
                'success' => false,
                'message' => 'Data inputan tidak ada'
            ];
        } elseif ($this->form_validation->run() == false) {
            $result = [
                'success' => false,
                'message' => [
                    'alert_type' => 'classic',
                    'name_error' => strip_tags(form_error('name')),
                    'city_error' => strip_tags(form_error('city')),
                ]
            ];
        } elseif (count(search($clubs, ['club_name' => $param['name']])) > 0) {
            $result = [
                'success' => false,
                'message' => [
                    'alert_type' => 'classic',
                    'name_error' => 'Nama club sudah ada',
                    'city_error' => '',
                ]
            ];
        } else {
            if ($param['iC'] == '') {
                $proses = $this->m_club->postClub($param);
                if ($proses['success']) {
                    $result = [
                        'success' => true,
                        'message' => 'Club bola berhasil ditambahkan'
                    ];
                } else {
                    $result = [
                        'success' => false,
                        'message' => 'Kesalahan database'
                    ];
                }
            } else {
                $proses = $this->m_club->putClub($param);
                if ($proses['success']) {
                    $result = [
                        'success' => true,
                        'message' => 'Club "' . $param['name'] . '" berhasil diubah'
                    ];
                } else {
                    $result = [
                        'success' => false,
                        'message' => [
                            'alert_type' => 'swal',
                            'message' => 'Kesalahan database'
                        ]
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    public function postMatch()
    {
        $param = $this->input->post();
        $match = $param['match'];
        foreach ($match as $key => $m) {
            if ($m['player1']['club'] == null || $m['player2']['club'] == null || $m['player1']['goal'] == null || $m['player2']['goal'] == null) {
                $result = [
                    'success' => false,
                    'message' => [
                        'message' => 'Lengkapi semua data',
                        'target' => '.match' . $key
                    ]
                ];
                echo json_encode($result);
                die;
            } elseif (is_numeric($m['player1']['club']) == false || is_numeric($m['player2']['club']) == false || is_numeric($m['player1']['goal']) == false || is_numeric($m['player2']['goal']) == false) {
                $result = [
                    'success' => false,
                    'message' => [
                        'message' => 'Inputan tidak sesuai',
                        'target' => '.match' . $key
                    ]
                ];
                echo json_encode($result);
                die;
            } elseif ($m['player1']['club'] == $m['player2']['club']) {
                $result = [
                    'success' => false,
                    'message' => [
                        'message' => 'Tidak dapat tanding dengan tim sendiri',
                        'target' => '.match' . $key
                    ]
                ];
                echo json_encode($result);
                die;
            }
        }
        $proses = $this->m_club->postMatch($match);
        if ($proses['success']) {
            $result = [
                'success' => true,
                'message' => 'Berhasil menambahkan data pertandingan!'
            ];
        } else {
            $result = [
                'success' => false,
                'message' => [
                    'target' => null,
                    'message' => $proses['messsage']
                ]
            ];
        }
        echo json_encode($result);
        die;
    }

    // public function detailPaket()
    // {
    //     $param = $this->input->post();
    //     $id_paket = $param['id'];
    //     if ($id_paket == null) {
    //         $result = [
    //             'success' => false,
    //             'message' => 'id paket tidak ada'
    //         ];
    //     } else {
    //         $proses = $this->m_paket->getPaket($id_paket)->row_array();
    //         $result = [
    //             'success' => true,
    //             'message' => $proses
    //         ];
    //     }
    //     echo json_encode($result);
    // }

    // public function detailHargaPaket()
    // {
    //     $param = $this->input->post();
    //     $id_harga_paket = $param['id'];
    //     if ($id_harga_paket == null) {
    //         $result = [
    //             'success' => false,
    //             'message' => 'id paket tidak ada'
    //         ];
    //     } else {
    //         $proses = $this->m_paket->getHargaPaket(null, $id_harga_paket)->row_array();
    //         $result = [
    //             'success' => true,
    //             'message' => [
    //                 'id' => $proses['id_paket_harga'],
    //                 'copy' => $proses['copy_num'],
    //                 'harga' => $proses['harga']
    //             ]
    //         ];
    //     }
    //     echo json_encode($result);
    // }

    // public function aksiPaket()
    // {
    //     $rules = [
    //         [
    //             'field' => 'name',
    //             'label' => 'nama paket',
    //             'rules' => 'required|max_length[100]'
    //         ],

    //     ];
    //     $this->form_validation->set_rules($rules);

    //     $param = $this->input->post();

    //     if ($param == []) {
    //         $result = [
    //             'success' => false,
    //             'message' => 'Data inputan tidak ada'
    //         ];
    //     } elseif ($this->form_validation->run() == false) {
    //         $result = [
    //             'success' => false,
    //             'message' => [
    //                 'alert_type' => 'classic',
    //                 'name_error' => strip_tags(form_error('name')),
    //                 // 'copy_error' => strip_tags(form_error('copy')),
    //             ]
    //         ];
    //     }
    //     // elseif ($param['copy'] <= 0) {
    //     //     $result = [
    //     //         'success' => false,
    //     //         'message' => [
    //     //             'alert_type' => 'classic',
    //     //             'copy_error' => 'Jumlah eksemplar tidak boleh kurang dari 1 eksemplar',
    //     //         ]
    //     //     ];
    //     // } 
    //     else {
    //         if ($param['iP'] == '') {
    //             $proses = $this->m_paket->postPaket($param);
    //             if ($proses['success']) {
    //                 $result = [
    //                     'success' => true,
    //                     'message' => 'Jenis paket baru berhasil ditambahkan'
    //                 ];
    //             } else {
    //                 $result = [
    //                     'success' => false,
    //                     'message' => 'Kesalahan database'
    //                 ];
    //             }
    //         } else {
    //             $proses = $this->m_paket->putPaket($param);
    //             if ($proses['success']) {
    //                 $result = [
    //                     'success' => true,
    //                     'message' => 'Paket "' . $param['name'] . '" berhasil diubah'
    //                 ];
    //             } else {
    //                 $result = [
    //                     'success' => false,
    //                     'message' => 'Kesalahan database'
    //                 ];
    //             }
    //         }
    //     }
    //     echo json_encode($result);
    // }

    // public function aksiHargaPaket()
    // {

    //     $param = $this->input->post();

    //     if ($param == []) {
    //         $result = [
    //             'success' => false,
    //             'message' => 'Data inputan tidak ada'
    //         ];
    //     } elseif (trim($param['copy']) == '') {
    //         $result = [
    //             'success' => false,
    //             'message' => [
    //                 'alert_type' => 'classic',
    //                 'copy_error' => 'Jumlah eksemplar belum diisi',
    //             ]
    //         ];
    //     } elseif (trim($param['price']) == '') {
    //         $result = [
    //             'success' => false,
    //             'message' => [
    //                 'alert_type' => 'classic',
    //                 'price_error' => 'Harga belum terisi',
    //             ]
    //         ];
    //     } elseif (trim($param['price']) < 0) {
    //         $result = [
    //             'success' => false,
    //             'message' => [
    //                 'alert_type' => 'classic',
    //                 'price_error' => 'Harga tidak boleh kurang dari 0 rupiah',
    //             ]
    //         ];
    //     } else {
    //         if ($param['iK'] == '') {
    //             $proses = $this->m_paket->postHargaPaket($param);
    //             if ($proses['success']) {
    //                 $result = [
    //                     'success' => true,
    //                     'message' => 'Jenis harga berhasil ditambahkan'
    //                 ];
    //             } else {
    //                 $result = [
    //                     'success' => false,
    //                     'message' => 'Kesalahan database'
    //                 ];
    //             }
    //         } else {
    //             $proses = $this->m_paket->putHargaPaket($param);
    //             if ($proses['success']) {
    //                 $result = [
    //                     'success' => true,
    //                     'message' => 'Berhasil diubah'
    //                 ];
    //             } else {
    //                 $result = [
    //                     'success' => false,
    //                     'message' => 'Kesalahan database'
    //                 ];
    //             }
    //         }
    //     }
    //     echo json_encode($result);
    // }

    // public function deletePaket()
    // {
    //     if ($this->input->post() == null) {
    //         $array = [
    //             'success' => false,
    //             'message' => 'data tidak ditemukan'
    //         ];
    //     } else if ($this->m_paket->getHargaPaket($this->input->post()['id'])->num_rows() != 0) {
    //         $array = [
    //             'success' => false,
    //             'message' => 'Pastikan harga-harga paket sudah kosong'
    //         ];
    //     } else {
    //         $id_paket = $this->input->post()['id'];
    //         $proses = $this->m_paket->deletePaket($id_paket);
    //         if ($proses['success']) {
    //             $array = [
    //                 'success' => true,
    //                 'message' => 'Berhasil hapus data'
    //             ];
    //         } else {
    //             $array = [
    //                 'success' => false,
    //                 'message' => 'Gagal hapus data'
    //             ];
    //         }
    //     }
    //     echo json_encode($array);
    // }

    // public function deleteHargaPaket()
    // {
    //     if ($this->input->post() == null) {
    //         $array = [
    //             'success' => false,
    //             'message' => 'data tidak ditemukan'
    //         ];
    //     } else {
    //         $id_harga_paket = $this->input->post()['id'];
    //         $proses = $this->m_paket->deleteHargaPaket($id_harga_paket);
    //         if ($proses['success']) {
    //             $array = [
    //                 'success' => true,
    //                 'message' => 'Berhasil hapus data'
    //             ];
    //         } else {
    //             $array = [
    //                 'success' => false,
    //                 'message' => 'Gagal hapus data'
    //             ];
    //         }
    //     }
    //     echo json_encode($array);
    // }

    // public function putService()
    // {
    //     $param = $this->input->post();
    //     // print_r(json_decode($param['data']));
    //     // die;
    //     if ($param == null) {
    //         redirect(base_url('custom404'));
    //     } else {
    //         $arrMateri = array_column($param['data'], 'value');
    //         // $arrMateriName = array_column($param['data'], 'name');
    //         $myarray = array();
    //         $fslt = [];
    //         foreach ($arrMateri as $am) {
    //             if (strlen(trim($am, " ")) == 0) {
    //                 $array = [
    //                     'success' => false,
    //                     'message' => 'Tidak dapat diisi hanya dengan spasi',
    //                     'icon' => 'warning'
    //                 ];
    //                 echo json_encode($array);
    //                 die;
    //             } elseif (strlen($am) < 2 || strlen($am) > 255) {
    //                 $array = [
    //                     'success' => false,
    //                     'message' => 'List materi setidaknya terdapat 2 karakter dan paling banyak 255 karakter',
    //                     'icon' => 'warning'
    //                 ];
    //                 echo json_encode($array);
    //                 die;
    //             }
    //             $myarray['fasilitas'] = $am;
    //             $fslt[] = $myarray;
    //         };

    //         $data = [
    //             'id' => $param['id'],
    //             'fasilitas' => json_encode($fslt),
    //         ];


    //         $result = $this->m_paket->putService($data);
    //         if ($result['success']) {
    //             $array = [
    //                 'success' => true,
    //                 'icon' => 'success',
    //                 'message' => 'Berhasil mengubah fasilitas'
    //             ];
    //         } else {
    //             $array = [
    //                 'success' => false,
    //                 'icon' => 'error',
    //                 'message' => 'Gagal mengubah fasilitas'
    //             ];
    //         }

    //         echo json_encode($array);
    //     }
    // }
    // // ========== END ===========

    // private function textStatus($status_code)
    // {
    //     switch ($status_code) {
    //         case 1:
    //             return '<p>Aktif</p>';
    //             break;
    //         case 0:
    //             return '<p>Tidak Aktif</p>';
    //             break;
    //     }
    // }
}
