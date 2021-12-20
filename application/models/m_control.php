<?php 
Class M_control extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}	

    function listMenu($role, $dept, $parent, $type){		
		$sql = "SELECT
                    c.*, ifnull(d.menu_id,'') as parent_id, ifnull(d.menu_tittle,'') as parent_name 
                FROM
                (
                SELECT
                    a.*
                    FROM
                    ms_menu_m a
                    JOIN ms_menu_d_role b ON a.menu_id = b.menu_id
                    WHERE 
                    b.role_id = '".$role."'
                    AND a.is_active = 'Y'
                    AND b.is_active ='Y'                   
                UNION 
                    SELECT
                    a.*
                    FROM
                    ms_menu_m a
                    JOIN ms_menu_d_dept b ON a.menu_id = b.menu_id
                    WHERE
                    b.dept_id = '".$dept."'
                    AND a.is_active = 'Y'
                    AND b.is_active = 'Y'
                    ) c 
                LEFT JOIN ms_menu_m d ON c.parent = d.menu_id
                WHERE
                    c.menu_type = '".$type."'
                    AND ifnull(c.parent,'') = '".$parent."'";                
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