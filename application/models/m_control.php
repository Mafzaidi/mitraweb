<?php 
Class M_control extends CI_Model
{
	
    function listMenu($dept, $parent, $type){		
		$sql = "SELECT
                    b.*, ifnull(c.menu_id,'') as parent_id, ifnull(c.menu_tittle,'') as parent_name 
                FROM
                (
                    SELECT
                        a.*, ifnull(d.alias,'') AS url, ifnull(c.alias,'') AS alias, b.dept_id AS employee_dept_id
                    FROM
                        mitraweb.ms_menu_m a
                        LEFT JOIN mitraweb.ms_menu_d_dept b ON a.menu_id = b.menu_id
                        LEFT JOIN mitraweb.ms_dept_m c ON b.dept_id = c.dept_id
                        LEFT JOIN mitraweb.ms_dept_m d ON a.dept_id = d.dept_id
                    WHERE
                        ((c.kd_bagian = '".$dept."' OR b.dept_id = '".$dept."') OR a.menu_id = 'MN0002')
                        AND a.is_active = 'Y'
                      
                    ) b 
                    LEFT JOIN ms_menu_m c ON b.parent = c.menu_id
                WHERE
                    b.menu_type = '".$type."'
                    AND IFNULL(b.parent,'') = '".$parent."'
                ORDER BY b.menu_order ASC";                
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
	}
    function checkParent($parent){		
		$sql = "SELECT
                    a.*
                FROM
                    ms_menu_m a
                WHERE
                    ifnull(a.parent,'') = '".$parent."'
                ORDER BY a.menu_order ASC
                    ";                
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
	}
	
}