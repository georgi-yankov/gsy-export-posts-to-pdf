<?php

require_once '../../../wp-load.php'; // make available WP functions

if (!isset($_POST['option_page']) || ($_POST['option_page'] !== 'gsy_export_posts_to_pdf_group')) {
    header('Location: ' . home_url('/'));
}

$export_counter = false;
$export_authors = false;
$export_categories = false;
$export_comments = false;
$export_date = false;

if (isset($_POST['gsy_export_posts_to_pdf_options'])) {
    if (isset($_POST['gsy_export_posts_to_pdf_options']['counter_checkbox']) &&
            $_POST['gsy_export_posts_to_pdf_options']['counter_checkbox'] === 'on') {
        $export_counter = true;
    }

    if (isset($_POST['gsy_export_posts_to_pdf_options']['author_checkbox']) &&
            $_POST['gsy_export_posts_to_pdf_options']['author_checkbox'] === 'on') {
        $export_authors = true;
    }

    if (isset($_POST['gsy_export_posts_to_pdf_options']['category_checkbox']) &&
            $_POST['gsy_export_posts_to_pdf_options']['category_checkbox'] === 'on') {
        $export_categories = true;
    }

    if (isset($_POST['gsy_export_posts_to_pdf_options']['comments_checkbox']) &&
            $_POST['gsy_export_posts_to_pdf_options']['comments_checkbox'] === 'on') {
        $export_comments = true;
    }

    if (isset($_POST['gsy_export_posts_to_pdf_options']['date_checkbox']) &&
            $_POST['gsy_export_posts_to_pdf_options']['date_checkbox'] === 'on') {
        $export_date = true;
    }
}

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

    if ($export_counter) {
        $html .= '<th></th>';
    }

    $html .= '<th>' . __('Title', 'gsy-export-posts-to-pdf') . '</th>';

    if ($export_authors) {
        $html .= '<th>' . __('Author', 'gsy-export-posts-to-pdf') . '</th>';
    }

    if ($export_categories) {
        $html .= '<th>' . __('Categories', 'gsy-export-posts-to-pdf') . '</th>';
    }

    if ($export_comments) {
        $html .= '<th>' . __('Comments', 'gsy-export-posts-to-pdf') . '</th>';
    }

    if ($export_date) {
        $html .= '<th>' . __('Date', 'gsy-export-posts-to-pdf') . '</th>';
    }

    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    $count_posts = 1;

    while ($the_query->have_posts()) :
        $the_query->the_post();

        $html .= '<tr>';

        if ($export_counter) {
            $html .= '<td>' . $count_posts . '.</td>';
        }

        $html .= '<td>' . get_the_title() . '</td>';

        if ($export_authors) {
            $html .= '<td>' . collect_author_data($post->ID) . '</td>';
        }

        if ($export_categories) {
            $html .= '<td>' . collect_categories($post->ID) . '</td>';
        }

        if ($export_comments) {
            $html .= '<td>' . get_comments_number($post->ID) . '</td>';
        }

        if ($export_date) {
            $html .= '<td>' . get_the_date('', $post->ID) . '</td>';
        }

        $html .= '</tr>';

        $count_posts++;

    endwhile;

    $html .= '</tbody>';
    $html .= '</table>';
else:
    $html = __('Sorry, no posts to be exported!', 'gsy-export-posts-to-pdf');
endif;
wp_reset_postdata();

function collect_author_data($post_id) {
    $post = get_post($post_id);
    $author_id = $post->post_author;
    $author_name = get_the_author_meta('user_nicename', $author_id);

    return $author_name;
}

function collect_categories($post_id) {
    $categories = get_the_category($post_id);
    $seperator = ', ';
    $result = '';

    foreach ($categories as $category) {
        $result .= $category->name;
        $result .= $seperator;
    }

    $result = trim($result, $seperator);
    return $result;
}

//==============================================================
//==============================================================
//==============================================================

require 'libraries/mpdf/mpdf.php';

$mpdf = new mPDF('utf-8', 'A4-L');

$arr = array(
    'L' => array(
        'content' => get_bloginfo(),
        'font-size' => '10',
        'color' => '#969696'
    ),
    'R' => array(
        'content' => __('Page', 'gsy-export-posts-to-pdf') . ' {PAGENO}',
        'font-size' => '10',
        'color' => '#969696'
    ),
);

$mpdf->SetHeader($arr, 'O');

// LOAD a stylesheet
$stylesheet = file_get_contents('css/mpdfstyleA4.css');

$mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($html, 2);
$mpdf->Output();
exit;
