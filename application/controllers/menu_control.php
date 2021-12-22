<?php

    $this->load->model('m_control', 'mc');

    $role = $this->session->userdata('role_id');
    $dept = $this->session->userdata('dept_id');
    $parent = '-';
    $type = $this->session->userdata('dept_id');

    $menuParent = $this->mc->listMenu($role, $dept, $parent, $type);
    $menu = "";

    foreach($menuParent as $p) {
        $check = $this->mc->checkParent($p->menu_id);

        if(count($check) > 0) {
            $menu.="<li class='nav-item'>" . anchor("medrec/" . $p->link, "
                <i class='fas fa-align-justify'></i>
                <span>Form</span>", array("class" => "nav-link collapsed", 
                                        "data-toggle" => "collapse",
                                        "data-target" => "#" . $p->menu_id,
                                        "aria-expanded" => "false",
                                        "aria-controls" => $p->menu_id)
                                    );
            
		$menu.= '</li>';
        }
    }

    return $menu;

?>