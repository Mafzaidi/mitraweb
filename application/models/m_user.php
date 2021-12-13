<?php

class M_user extends CI_Model
{
    function cek_login($table, $where)
    {
        return $this->db->get_where($table, $where);
    }

    function getUser($userID)
    {
        $query = $this->db->query("SELECT
									A.USER_ID, 
									A.FIRST_NAME, 
									A.LAST_NAME, 
									A.IS_ADMIN
								 FROM
                                    ENDEMIK.MS_USER_M A
								 WHERE
									A.USER_ID = '" . $userID . "'");

        $row = $query->row();
        return $row;
    }

    function loginUser($username, $password)
    {
        $query = $this->db->query("SELECT
									a.user_id, 
                                    a.username,
									a.first_name, 
									a.last_name,
                                    a.email
								 FROM
                                    endemik.ms_user_m a
								 WHERE
									(a.email = '" . $username . "'
                                    OR UPPER(a.username) = UPPER('" . $username . "'))
									AND a.password = '" . $password . "'");

        $row = $query->row();
        return $row;
    }

    function checkUser($table, $where)
    {
        return $this->db->get_where($table, $where);
    }
}
