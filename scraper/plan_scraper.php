<?php
error_reporting();

//$year = $argv[1];

if (isset($argv[1])) {
    $n = $argv[1];
} else {
    $n = -1;
}

$year_array = array("2017","2018","2019","2020","2021","2022","2023","2024","2025","2026");
$programs = array();

foreach ($year_array as $year) {
    $url = "https://programsandcourses.anu.edu.au/data/ProgramSearch/GetPrograms?q=&ShowAll=true&SelectedYear=" . $year;
    print "GETTING PROGRAMS FOR YEAR:" . $year . "\n";
    $context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
    $xmlString = file_get_contents($url, false, $context);
    $xml = simplexml_load_string($xmlString);
    $xml2 = $xml->children()->children();
    $i = 0;
    foreach ($xml2 as $element) {
        $programs[$year][$i] = array(
            "c" => (string)$element->AcademicPlanCode,
            "n" => (string)$element->ProgramName,
            "l" => (string)$element->AcademicCareer,
        );
        $i++;
    }
    print "Programs loaded for " . $year . ": " . $i . "\n";
}

$fp = fopen("output/programs.min.json", 'w');
fwrite($fp,json_encode($programs));
fclose($fp);

