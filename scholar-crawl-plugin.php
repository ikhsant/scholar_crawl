<?php
/*
Plugin Name: Scholar Crawl Plugin
Plugin URI:  https://github.com/ikhsant/scholar_crawl
Description: A simple plugin to scrape Google Scholar profile, publication data and display it.
Version: 1.2
Author: Ikhsan Thohir
Author URI: https://ikhsanthohir.com
*/

// Include simple_html_dom.php (make sure to upload this file inside the plugin folder)
include('simple_html_dom.php');

// Function to fetch and display Google Scholar data
function scholar_crawl_fetch_data($user_id, $show_profile) {
    // Google Scholar profile URL (now using the customizable user ID)
    $url = 'https://scholar.google.com/citations?user=' . $user_id . '&hl=en&oi=ao';

    // Initialize cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $html = curl_exec($ch);
    curl_close($ch);

    // Create a DOM object
    $dom = new simple_html_dom();
    $dom->load($html);

    // Extract profile picture, name, and institution
    $profile_pic_element = $dom->find('#gsc_prf_pup-img', 0);
    $profile_pic = ($profile_pic_element) ? 'https://scholar.google.com' . $profile_pic_element->src : 'No profile picture found';

    $name_element = $dom->find('#gsc_prf_in', 0);
    $name = ($name_element) ? $name_element->plaintext : 'No name found';

    $institution_element = $dom->find('.gsc_prf_il', 0);
    $institution = ($institution_element) ? $institution_element->plaintext : 'No institution found';

    // Start building the output string
    $output = "";

    // Show or hide profile information based on the parameter
    if ($show_profile === 'true') {
        $output .= "<h2>Profile Information</h2>";
        
        if ($profile_pic !== 'No profile picture found') {
            $output .= "<img src='" . $profile_pic . "' alt='Profile Picture' style='width:100px;height:100px;'><br>";
        }
        $output .= "<strong>Name:</strong> " . $name . "<br>";
        $output .= "<strong>Institution:</strong> " . $institution . "<br><br>";
    }

    // Fetch publications
    $output .= "<h2>Publications</h2>";
    foreach ($dom->find('tr.gsc_a_tr') as $publication) {
        $titleElement = $publication->find('.gsc_a_at', 0);
        if ($titleElement) {
            $title = $titleElement->plaintext;
            $link = 'https://scholar.google.com' . $titleElement->href; // Full URL for title
        } else {
            $title = 'No title found';
            $link = '#';
        }

        $yearElement = $publication->find('.gsc_a_y span', 0);
        $year = ($yearElement) ? $yearElement->plaintext : 'No year found';

        // Append to the output
        $output .= "Title: <a href='" . $link . "' target='_blank'>" . $title . "</a><br>";
        $output .= "Year: " . $year . "<br><br>";
    }

    return $output;
}

// Shortcode function with customizable Google Scholar user ID and profile visibility
function scholar_crawl_shortcode($atts) {
    // Extract the user ID and show_profile from shortcode attributes
    $atts = shortcode_atts(
        array(
            'user' => 'QcPyFTkAAAAJ', // Default user ID
            'show_profile' => 'true', // Default to show profile information
        ),
        $atts
    );
    
    // Call the function to fetch data with the provided user ID and profile visibility
    return scholar_crawl_fetch_data($atts['user'], $atts['show_profile']);
}

// Register shortcode [scholar_crawl user="" show_profile=""]
add_shortcode('scholar_crawl', 'scholar_crawl_shortcode');
?>
