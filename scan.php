<?php
// PHP BACKDOOR SCAN
// @author Alexandre Magnier - Exaland Concept
function scanDirectory($dir) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                scanDirectory($path);
            } else {
                analyzeFile($path);
            }
        }
    }
}

function analyzeFile($file) {
    // Analyse le contenu du fichier à la recherche de motifs suspects
    $content = file_get_contents($file);
    // Modifiez ici vos critères de détection des backdoors
    if (preg_match('/\beval\s*\(\s*[$\(]/i', $content) || preg_match('/\bsystem\s*\(\s*\$_[AGET]/i', $content)) {
        echo "Suspect File Found : $file\n \n";
        // Vous pouvez ajouter d'autres actions ici, comme la suppression du fichier ou la notification
    }
}

// Chemin du répertoire à scanner (modifiez-le selon votre besoin)
$directory = __DIR__;
echo "Starting PHP Backdoor Scanning...\n";
scanDirectory($directory);
echo "Scanning Finished.\n";
?>
