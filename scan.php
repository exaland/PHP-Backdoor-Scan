<?php
function scanDirectory($dir) {
    $files = scandir($dir);
    $suspectFiles = [];
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                $suspectFiles = array_merge($suspectFiles, scanDirectory($path));
            } else {
                $suspectFiles = array_merge($suspectFiles, analyzeFile($path));
            }
        }
    }
    return $suspectFiles;
}

function analyzeFile($file) {
    $suspectFiles = [];
    $content = file_get_contents($file);
    if (preg_match('/\beval\s*\(\s*[$\(]/i', $content) || preg_match('/\bsystem\s*\(\s*\$_[AGET]/i', $content)) {
        $suspectFiles[] = $file;
    }
    return $suspectFiles;
}

// Chemin du répertoire à scanner (modifiez-le selon votre besoin)
$directory = __DIR__;
echo "Start of analysis...\n";
$suspectFiles = scanDirectory($directory);
echo "Analysis completed.\n";

// Affichage des résultats dans un tableau
if (!empty($suspectFiles)) {
    echo "<table border='1'><tr><th>Suspect Files</th></tr>";
    foreach ($suspectFiles as $file) {
        echo "<tr><td>$file</td></tr>";
    }
    echo "</table>";
} else {
    echo "Not Suspect File Found.";
}
?>
