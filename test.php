<?php

\Doctrine\ORM\NativeQuery::HYDRATE_ARRAY;

function dirToArray($dir) {

    $result = array();

    $cdir = scandir($dir);
    foreach ($cdir as $key => $value)
    {
        if (!in_array($value,array(".","..")))
        {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
            {
                $result = array_merge($result, dirToArray($dir . DIRECTORY_SEPARATOR . $value));
            }
            else
            {
                $result[] = $dir . DIRECTORY_SEPARATOR . $value;
            }
        }
    }

    return $result;
}

$files = dirToArray('datalist');
//print_r($files);

foreach ($files as $file) {
    $name = basename($file);
    $pkg = dirname($file);

    //rename($file, str_replace('.inc', '.php', $file));

    $contents = file_get_contents($file);
    $contents = str_replace('<?php', '<?php' . "\nnamespace spark\\" . str_replace(DIRECTORY_SEPARATOR, '\\', $pkg . ";\n"), $contents);

    //echo $contents; die;

    //file_put_contents($file, $contents);

}