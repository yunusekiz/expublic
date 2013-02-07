<?php

$base = base_url();

$about_theme = 'theme/tr/4columns_portfolio.html';

$theme_data = $base.$about_theme;

$file_get_contents = file_get_contents($theme_data);
echo $file_get_contents;

?>