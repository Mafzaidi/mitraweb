<?php

class M_user extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->oracle_db = $this->load->database('oracle', true);
        $this->mysql_db = $this->load->database('default', true);
    }

    function countUser($table, $where)
    {
        return $this->db->get_where($table, $where);
    }

    function getUser($table, $where)
    {
        return $this->db->get_where($table, $where);
    }

    function getDataOra($table, $where)
    {
        return $this->oracle_db->get_where($table, $where);
    }

    function loginUser($username)
    {
        $query = $this->db->query("SELECT
									a.user_id, 
                                    a.username,
									a.first_name, 
									a.last_name,
                                    a.email,
                                    a.role_id,
                                    b.role_name,
                                    c.dept_name,
                                    a.dept_id
								 FROM
                                    mitraweb.ms_user_m a
                                    JOIN mitraweb.ms_role_m b ON a.role_id = b.role_id
                                    JOIN mitraweb.ms_dept_m c ON a.dept_id = c.dept_id
								 WHERE
                                    a.is_active = 'Y'
									AND (a.email = '" . $username . "'
                                    OR UPPER(a.username) = UPPER('" . $username . "'))");

        $row = $query->row();
        return $row;
    }

    function getDataUser($username)
    {
        $sql = "SELECT
                    A.NO_KAR, 
                    A.NAMA_KAR,
                    A.BAGIAN, 
                    A.KD_BAGIAN,
                    A.STRUK_ORG_ID,
                    A.DEPT_ID
                    FROM
                    HIS_MANAGER.MS_KARYAWAN A
                    WHERE
                    A.SHOW_ITEM = '1'
                    AND A.NO_KAR = '" . $username . "'";
                    
        $query = $this->oracle_db->query($sql);
        $row = $query->row();
        return $row;
    }

    function getUserInfo($userid)
    {
        $query = $this->db->query("SELECT
                                    a.username,
                                    a.first_name,
                                    a.last_name,
                                    IFNULL(a.email,'') AS email,
                                    b.dept_name,
                                    c.role_name,
                                    d.img_url,
                                    a.created_date
                                FROM
                                    mitraweb.ms_user_m a
                                    JOIN mitraweb.ms_dept_m b ON a.dept_id = b.dept_id
                                    JOIN mitraweb.ms_role_m c ON a.role_id = c.role_id
                                    JOIN mitraweb.ms_user_d_imgprfl d ON a.user_id = d.user_id
                                WHERE
                                    a.user_id = '" . $userid . "'
                                    AND a.is_active = 'Y'
                                    AND d.is_active = 'Y'
                                ORDER BY d.img_order ASC");

        $row_array = $query->row_array();
        return $row_array;
    }
}
