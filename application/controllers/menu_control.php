<?php

    $this->load->model('m_control', 'mc');

    $dept = $this->session->userdata('dept_id');
    $parent = '';
    $type ='1';

    $menuParent = $this->mc->listMenu($dept, $parent, $type);
    $menu = "";

    foreach($menuParent as $p) {
        $check = $this->mc->checkParent($p->menu_id);

        if(count($check) > 0) {
            $menu.='<li class="nav-item">' . anchor($p->alias . '/' . $p->link, '
                <i class="' . $p->icon . '"></i>
                <span>' . $p->menu_tittle . '</span>
                ', array('class' => 'nav-link collapsed', 
                                        'data-toggle' => 'collapse',
                                        'data-target' => '#' . $p->menu_id,
                                        'aria-expanded' => 'false',
                                        'aria-controls' => $p->menu_id)
                                    );
            
            $menu.='<div id="' . $p->menu_id .'" class="collapse" aria-labelledby="headingTwo" data-parent="#sidebarMenu">';
            $menu.='<div class="card bg-white py-2 rounded">';
            $menu.='<ul class="list-group list-group-flush">';
            
            $parent2 = $p->menu_id;
            $type2 = '2';
            $menuChild = $this->mc->listMenu($dept, $parent2, $type2);
            foreach ($menuChild as $c) {
                $menu.='<li class="list-group-item">' . anchor($p->alias . '/'.strtolower(preg_replace('/\s+/', '-', $c->parent_name)).'/'.$c->link, 
                '<i class="' . $c->icon . '"></i><span>' . $c->menu_tittle . '</span>',
                array('class' => 'collapse-item')
            );
            $menu.='</li>';
            }
            $menu.='</ul>'; // list-group
            $menu.='</div>'; // card
            $menu.='</div>'; // collapse
		    $menu.= '</li>'; // nav-item
        } else {
            $menu.='<li class="nav-item">' . anchor($p->alias . '/' . $p->link, '
                <i class="' . $p->icon . '"></i>
                <span>' . $p->menu_tittle . '</span>', array('class' => 'nav-link')
                                    );
        }
    }
$data['menu'] = $menu;
?>