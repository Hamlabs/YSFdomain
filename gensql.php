#!/usr/bin/php
<?php
    
if(!isset($_SERVER['argv'][1])) {
    echo "Specify domain ID plx ;-)\n";
    exit(1);
} else {
    $DOMAINID = $_SERVER['argv'][1];
}

$DEBUG = true;

function dout($text) {
    global $DEBUG;

    if($DEBUG) echo $text;
}

$INPUTFILE = 'http://www.ea3hkb.com/wp-content/uploads/YSFHosts.txt';

echo "Loading YSF servers...";
$LINES = file($INPUTFILE);
echo "done.\n";

$SERVERS = array();

//var_dump($LINES);
foreach($LINES as $i=>$line) {
    //var_dump($line);
    if(preg_match('/^(\xefbbbf)?#/', $line)) {
        dout("INPUT: Comment line index[$i]\n");
        continue;
    }
    $line = trim($line);
    if(empty($line)) {
        dout("INPUT: Empty line index[$i]\n");
        continue;
    }

    $hits = preg_split('/\s+/', $line);
    if(is_numeric($hits[1])) {
        $SERVERS[] = $hits;
    }

}

printf("DELETE FROM rr where zone = %d and name = '_ysf._udp' and type = 'SRV';\n", $DOMAINID);
foreach($SERVERS as $server) {
    printf(
        "INSERT INTO rr (`zone`, `name`, `type`, `data`, `ttl`) VALUES (%d, '_ysf._udp', 'SRV', '10 0 %d %s.', 300);\n",
        $DOMAINID,
        $server[1],
        $server[0]
    );
}