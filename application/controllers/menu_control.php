<?php

    $this->load->model('m_control', 'mc');

    $kd_bagian = $this->session->userdata('kd_bagian');
    if ($kd_bagian <> '') {
        $dept = $this->session->userdata('kd_bagian');
    } else {
        $dept = $this->session->userdata('dept_id');
    }
    $parent = '';
    $type ='1';
    $uri2 = $this->uri->segment(2);
    $uri3 = $this->uri->segment(3);
    $cls_child = '';
    $collapse = '';
    $attrib_parent = array();
    if ($kd_bagian <> '') {
        $menuParent = $this->mc->listMenu($dept, $parent, $type);
    } else {
        $menuParent = $this->mc->listMenu($dept, $parent, $type);
    }
    $menu = "";
    foreach($menuParent as $p) {
        $check = $this->mc->checkParent($p->menu_id);
        if(count($check) > 0) {
            if ($uri2 <> '' && $uri2 == strtolower(preg_replace('/\s+/', '-', $p->menu_tittle))){
                $attrib_parent = array(
                    'class' => 'nav-link', 
                    'data-toggle' => 'collapse',
                    'data-target' => '#' . $p->menu_id,
                    'aria-expanded' => 'true',
                    'aria-controls' => $p->menu_id
                );
                $collapse = 'collapse show';
            } else {
                $attrib_parent = array(
                    'class' => 'nav-link collapsed', 
                    'data-toggle' => 'collapse',
                    'data-target' => '#' . $p->menu_id,
                    'aria-expanded' => 'false',
                    'aria-controls' => $p->menu_id
                );
                $collapse = 'collapse';
            }
            $menu.='<li class="nav-item">' . anchor($p->alias . '/' . $p->link, '
                <i class="' . $p->icon . '"></i>
                <span>' . $p->menu_tittle2 . '</span>
                ', 
                $attrib_parent
                // array('class' => 'nav-link collapsed', 
                //     'data-toggle' => 'collapse',
                //     'data-target' => '#' . $p->menu_id,
                //     'aria-expanded' => 'false',
                //     'aria-controls' => $p->menu_id)
                );
            
            $menu.='<div id="' . $p->menu_id .'" class="' . $collapse . '" aria-labelledby="headingTwo" data-parent="#sidebarMenu">';
            $menu.='<div class="card bg-white py-2 rounded">';
            $menu.='<ul class="list-group list-group-flush">';
            
            $parent2 = $p->menu_id;
            $type2 = '2';
            if ($kd_bagian <> '') {
                $menuChild = $this->mc->listMenu($dept, $parent2, $type2);
            } else {
                $menuChild = $this->mc->listMenu($dept, $parent2, $type2);
            }
            foreach ($menuChild as $c) {
                // $menu.='<span>' . $uri_child . ' ' . $c->link . '</span>';
                if ($uri3 <> '' && $uri3 == $c->link){
                    $cls_child = 'active';
                } else {
                    $cls_child = '';
                }
                $menu.='<li class="list-group-item ' . $cls_child . '">' . anchor($c->url . '/'.strtolower(preg_replace('/\s+/', '-', $c->parent_name)).'/'.$c->link, 
                '<i class="' . $c->icon . '"></i><span>' . $c->menu_tittle2 . '</span>',
                array('class' => 'collapse-item text-decoration-none')
            );
            $menu.='</li>';
            }
            $menu.='</ul>'; // list-group
            $menu.='</div>'; // card
            $menu.='</div>'; // collapse
		    $menu.= '</li>'; // nav-item
        } else {
            // $menu.='<span>' . $uri_child . '</span>';
            $menu.='<li class="nav-item">' . anchor($p->alias . '/' . $p->link, '
                <i class="' . $p->icon . '"></i>
                <span>' . $p->menu_tittle2 . '</span>', array('class' => 'nav-link')
                                    );
        }
    }
$data['menu'] = $menu;
?>