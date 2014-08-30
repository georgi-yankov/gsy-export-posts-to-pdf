<?php

require_once '../../../wp-load.php'; // make available WP functions

if (!isset($_POST['option_page']) || ($_POST['option_page'] !== 'gsy_export_posts_to_pdf_group')) {
    header('Location: ' . home_url('/'));
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
    $html .= '<th></th>';
    $html .= '<th>' . __('Title', 'gsy-export-posts-to-pdf') . '</th>';
    $html .= '<th>' . __('Category', 'gsy-export-posts-to-pdf') . '</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    $count_posts = 1;

    while ($the_query->have_posts()) :
        $the_query->the_post();

        $categories = get_the_category();
        $seperator = ', ';
        $output = '';

        foreach ($categories as $category) {
            $output .= $category->name;
            $output .= $seperator;
        }

        $output = trim($output, $seperator);

        $html .= '<tr>';
        $html .= '<td>' . $count_posts . '.</td>';
        $html .= '<td>' . get_the_title() . '</td>';
        $html .= '<td>' . $output . '</td>';
        $html .= '</tr>';

        $count_posts++;

    endwhile;

    $html .= '</tbody>';
    $html .= '</table>';
else:
// TODO: no posts to show
endif;
wp_reset_postdata();

//==============================================================
//==============================================================
//==============================================================

require 'libraries/mpdf/mpdf.php';

$mpdf = new mPDF('utf-8', 'A4-L');

// LOAD a stylesheet
$stylesheet = file_get_contents('css/mpdfstyleA4.css');

$mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($html, 2);
$mpdf->Output();
exit;
