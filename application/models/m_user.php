<?php

class M_user extends CI_Model
{
    function countUser($table, $where)
    {
        return $this->db->get_where($table, $where);
    }

    function loginUser($username, $password)
    {
        $query = $this->db->query("SELECT
									a.user_id, 
                                    a.username,
									a.first_name, 
									a.last_name,
                                    a.email,
                                    a.is_admin
								 FROM
                                    mitraweb.ms_user_m a
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
