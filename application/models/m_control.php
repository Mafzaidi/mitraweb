<?php 
Class M_control extends CI_Model
{
	
    function listMenu($kd_bagian, $parent, $type){		
		$sql = "SELECT
                    b.*, ifnull(c.menu_id,'') as parent_id, ifnull(c.menu_tittle,'') as parent_name 
                FROM
                (
                    SELECT
                        a.*, ifnull(b.alias,'') AS alias
                    FROM
                        mitraweb.ms_menu_m a
                        LEFT JOIN mitraweb.ms_dept_m b ON a.dept_id = b.dept_id
                    WHERE
                        (b.kd_bagian = '".$kd_bagian."' OR IFNULL(a.dept_id,'') ='')
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