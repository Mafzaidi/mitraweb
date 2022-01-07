<?php
$modal = $this->modal_variables->getModalVariables($params);
$modal_html ='';

foreach($modal as $m) {
    $modal_html.= '<div class="modal fade" id="' . $m->modal . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
    $modal_html.= '<div class="modal-dialog" role="document">';
    $modal_html.= '<div class="modal-content">';
    $modal_html.= '<div class="modal-header">';
    $modal_html.= '<h5 class="modal-title" id="exampleModalLabel">' . $m->tittle . '</h5>';
    $modal_html.= '<button class="close" type="button" data-dismiss="modal" aria-label="Close">';
    $modal_html.= '<span aria-hidden="true"><i class="fas fa-times"></i></span>';
    $modal_html.= '</button>';
    $modal_html.= '</div>';
    $modal_html.= '<div class="modal-body">' . $m->message . '.</div>';
    $modal_html.= '<div class="modal-footer">';
    if ($m->button == 'yesno') {
        $modal_html.= '<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>'
        . anchor($m->link, $m->action,
            array('class' => 'btn btn-primary')
        );
        //$modal_html.= '<a class="btn btn-primary" href="' . base_url($m->action) . '">' . $m->modal . '</a>';
    } else {
        $modal_html.= '<button class="btn btn-primary" type="button" data-dismiss="modal">OK</button>';
    }
    $modal_html.= '</div>';
    $modal_html.= '</div>';
    $modal_html.= '</div>';
    $modal_html.= '</div>';
}
$data['modal'] = $modal_html;
?>