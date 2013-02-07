<?php
$base = base_url();

$header_theme = 'theme/tr/footer_2.html';

$theme_data = $base.$header_theme;

$file_get_contents = file_get_contents($theme_data);
echo $file_get_contents;

?>