<?php
$base = base_url();

$header_theme = 'theme/tr/anasayfa.html';

$theme_data = $base.$header_theme;

$file_get_contents = file_get_contents($theme_data);
echo  $file_get_contents;

?>