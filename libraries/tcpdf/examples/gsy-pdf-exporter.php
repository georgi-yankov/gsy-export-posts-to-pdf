<?php

chdir('../../../../../../'); // go to WP root directory
require_once 'wp-load.php'; // make available WP functions

if (!isset($_POST['gsy_export_posts_to_pdf_options'])) {
    die(__("Sorry, the export to pdf couldn't be done!", 'gsy-export-posts-to-pdf'));
}

extract($_POST['gsy_export_posts_to_pdf_options']);

$args = array(
    'post_type' => 'post',
    'orderby' => 'date',
    'order' => 'DESC',
);

// The Query
$the_query = new WP_Query($args);

$html = '';

if ($the_query->have_posts()) :
    $html .= '<table>';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th>' . __('Title', 'gsy-export-posts-to-pdf') . '</th>';
    $html .= '<th>' . __('Category', 'gsy-export-posts-to-pdf') . '</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    while ($the_query->have_posts()) :
        $the_query->the_post();

        $html .= '<tr>';
        $html .= '<td>' . get_the_title() . '</td>';
        $html .= '<td>Some category</td>';
        $html .= '</tr>';

    endwhile;

    $html .= '</tbody>';
    $html .= '</table>';
else:
// no posts to show
endif;
wp_reset_postdata();

echo $html;
