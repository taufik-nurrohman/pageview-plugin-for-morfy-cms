<?php

/**
 * Pageview Plugin for Morfy CMS
 *
 * @package Morfy
 * @subpackage Plugins
 * @author Taufik Nurrohman <http://latitudu.com>
 * @copyright 2014 Romanenko Sergey / Awilum
 * @version 1.0.0
 *
 */

// Usage => Morfy::factory()->runAction('pageview');
Morfy::factory()->addAction('pageview', function() {

    // Configuration data
    $config = Morfy::$config['pageview_config'];
    // Get current page URL
    $current_url = trim(Morfy::factory()->getUrl(), '/');
    // Create file name based on current page path
    // Replace all `/` character to `__` so we can use it to make a valid file name
    $file = PLUGINS_PATH . '/pageview/content/' . str_replace('/', '__', $current_url) . '.txt';
    // Check if we have admin plugin installed
    $is_admin = in_array('admin', Morfy::$config['plugins']) && isset(Morfy::$config['logged_in']) && Morfy::$config['logged_in'] === true;

    // Function to create and/or update the content of a TXT file (our pageview counter)
    function update_pageview_counter($file_path, $data) {
        $handle = fopen($file_path, 'w') or die('Cannot open file: ' . $file_path);
        fwrite($handle, $data);
    }

    // Check whether the counter file already exist.
    if(file_exists($file)) {
        $pageview = (int) file_get_contents($file);
        if( ! $is_admin) {
            $pageview++; // Increase the current pageview value by one
            update_pageview_counter($file, $pageview);
        }
    } else {
        if( ! $is_admin) {
            update_pageview_counter($file, "1");
            $pageview = 1;
        } else {
            $pageview = 0;
        }
    }

    $pageview = $config['leading_zero'] !== false ? sprintf("%0" . strlen($config['leading_zero']) . "d", $pageview) : $pageview;

    $numbers = str_split($pageview, 1);
    $html = array();

    foreach($numbers as $number) {
        $html[] = '<span class="i i-' . $number . '">' . $number . '</span>';
    }

    echo implode('', $html);

});
