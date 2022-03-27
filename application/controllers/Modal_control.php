<?php
$modal = $this->modal_variables->getModalVariables($params);
$uri = end($this->uri->segments);
$modal_html ='';
foreach($modal as $m) {
    $modal_html.= '<div class="modal fade ' .  $m->action  . '" id="myDynamicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
    $modal_html.= '<div class="modal-dialog ' . $m->size . '" role="document">';
    $modal_html.= '<div class="modal-content">';
    $modal_html.= '<div class="modal-header">';
    $modal_html.= '<h5 class="modal-title" id="exampleModalLabel">' . $m->tittle . '</h5>';
    $modal_html.= '<button class="close" type="button" data-dismiss="modal" aria-label="Close">';
    $modal_html.= '<span aria-hidden="true"><i class="fas fa-times"></i></span>';
    $modal_html.= '</button>';
    $modal_html.= '</div>';
    $modal_html.= '<div class="modal-body">' . $m->message . '</div>';
    $modal_html.= '<div class="modal-footer">';
    if ($m->button == 'yesno') {
        if ($m->action == 'logout') {
            $modal_html.= '<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>'
            . anchor($m->link, ucwords($m->action),
                array('class' => 'btn btn-primary')
            );
        } else {
            $modal_html.= '<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>';
            $modal_html.= '<button id="' . $m->action . '' . str_replace('-', '_', ucwords($uri)) . '" class="btn btn-primary" type="button" data-dismiss="modal">' . ucwords($m->action) . '</button>';
        }
    } else {
        $modal_html.= '<button id="' . $m->action . '' . str_replace('-', '_', ucwords($uri)) . '" class="btn btn-primary" type="button">OK</button>';
    }
    $modal_html.= '</div>';
    $modal_html.= '</div>';
    $modal_html.= '</div>';
    $modal_html.= '</div>';
}
$data['modal'] = $modal_html;
?>