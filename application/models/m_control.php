<?php 
Class M_control extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}	

    function listMenu($dept, $parent, $type){		
		$sql = "SELECT
                    b.*, ifnull(c.menu_id,'') as parent_id, ifnull(c.menu_tittle,'') as parent_name 
                FROM
                (
                    SELECT
                        a.*
                    FROM
                        ms_menu_m a
                    WHERE
                        (a.dept_id = '".$dept."' OR IFNULL(a.dept_id,'') ='')
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