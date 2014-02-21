Page Views Counter Plugin for Morfy CMS
=======================================

Configuration
-------------

Place the `pageview` folder with its contents in `plugins` folder. Then update your `config.php` file:

    <?php
        return array(
    
            ...
            ...
            ...
    
            'plugins' => array(
                'markdown',
                'sitemap',
                'admin', // <= Recommended to be installed
                'pageview' // <= Activation
            ),
            'pageview_config' => array(
                // Change to `false` if you want to remove the leading zero in counter
                'leading_zero' => '000000'
            )
        );

In your `blog_post.html` template, add this code wherever you like. Do it once, or you will get double page views in one page:

    <span class="page-views">
        <strong class="page-views-label">Total Page Views:</strong> 
        <span class="page-views-counter">
            <?php Morfy::factory()->runAction('pageview'); ?>
        </span>
    </span>

Done.
