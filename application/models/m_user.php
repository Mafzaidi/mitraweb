<?php

class M_user extends CI_Model
{
    function countUser($table, $where)
    {
        return $this->db->get_where($table, $where);
    }

    function getUser($table, $where)
    {
        return $this->db->get_where($table, $where);
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

    function getUserInfo($username)
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

    function checkUser($table, $where)
    {
        return $this->db->get_where($table, $where);
    }
}
