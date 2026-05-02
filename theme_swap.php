<?php

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('resources/views'));
$bladeFiles = [];
foreach ($files as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
        $bladeFiles[] = $file->getPathname();
    }
}

$mappings = [
    '#0F172A' => '__BG_MAIN__',
    '#1E293B' => '__BG_CARD__',
    '#334155' => '__BORDER__',
    '#F8FAFC' => '__TEXT_MAIN__',
    '#F1F5F9' => '__TEXT_MAIN2__',
    '#CBD5E1' => '__TEXT_SEC__',
    '#94A3B8' => '__TEXT_MUTED__',
    'rgba(15,23,42,.8)' => '__BG_INPUT__',
    'rgba(15,23,42,.85)' => '__BG_INPUT2__',
    'rgba(15,23,42,.95)' => '__BG_NAV__',
    'rgba(15,23,42,.98)' => '__BG_NAV2__',
    'rgba(30,41,59,.8)' => '__BG_CARD_OP__',
    'rgba(30,41,59,.9)' => '__BG_CARD_OP2__',
    'rgba(30,41,59,.5)' => '__BG_CARD_OP3__',
    'rgba(15,23,42,.5)' => '__BG_OP__',
    'rgba(15,23,42,.4)' => '__BG_OP2__',
    'rgba(15,23,42,.6)' => '__BG_OP3__',
    'rgba(255,255,255,.05)' => '__W_OP1__',
    'rgba(255,255,255,.1)' => '__W_OP2__',
    '#64748B' => '__TEXT_MUTED_DK__',
];

$lightMappings = [
    '__BG_MAIN__' => '#F8FAFC',
    '__BG_CARD__' => '#FFFFFF',
    '__BORDER__' => '#E2E8F0',
    '__TEXT_MAIN__' => '#0F172A',
    '__TEXT_MAIN2__' => '#1E293B',
    '__TEXT_SEC__' => '#475569',
    '__TEXT_MUTED__' => '#64748B',
    '__BG_INPUT__' => '#F1F5F9',
    '__BG_INPUT2__' => '#F8FAFC',
    '__BG_NAV__' => 'rgba(255,255,255,.95)',
    '__BG_NAV2__' => 'rgba(255,255,255,.98)',
    '__BG_CARD_OP__' => 'rgba(255,255,255,.9)',
    '__BG_CARD_OP2__' => 'rgba(255,255,255,.95)',
    '__BG_CARD_OP3__' => 'rgba(255,255,255,.7)',
    '__BG_OP__' => '#F1F5F9',
    '__BG_OP2__' => '#F8FAFC',
    '__BG_OP3__' => '#E2E8F0',
    '__W_OP1__' => 'rgba(0,0,0,.05)',
    '__W_OP2__' => 'rgba(0,0,0,.1)',
    '__TEXT_MUTED_DK__' => '#64748B',
];

foreach ($bladeFiles as $file) {
    $content = file_get_contents($file);
    foreach ($mappings as $old => $new) {
        $content = str_replace($old, $new, $content);
    }
    foreach ($lightMappings as $placeholder => $lightColor) {
        $content = str_replace($placeholder, $lightColor, $content);
    }
    file_put_contents($file, $content);
}
echo "Theme updated to light mode in " . count($bladeFiles) . " files.\n";
