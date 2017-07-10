<?
require "KrakenAPIClient.php";

$config = json_decode(file_get_contents("config.json"), TRUE);

$key = $config["key"];
$secret = $config["secret"];

$delay = 3;

$url = "https://api.kraken.com";

$sslverify = true;

$kraken = new KrakenAPI($key, $secret);

$assets = $kraken->QueryPublic('Assets');

function map_asset_name($asset_name) {
	$map = array(
		"XBT" => "BTC"
	);

	if (isset($map[$asset_name])) {
		return $map[$asset_name];
	} else {
		return $asset_name;
	}
}

$pairs_result = $kraken->QueryPublic('AssetPairs');
$pairs = array_keys($pairs_result["result"]);

$last = array();

while(true) {
	sleep(3);

	$ticker = $kraken->QueryPublic('Ticker', array('pair' => implode(",", $pairs)));

	$current = array();

	foreach($ticker["result"] as $pair => $entry) {
		$pair_info = $pairs_result["result"][$pair];

		$current[$pair] = array(
			"kraken",
			time(),
			map_asset_name($assets["result"][$pair_info["base"]]["altname"]),
			map_asset_name($assets["result"][$pair_info["quote"]]["altname"]),
			$entry["c"][0],
			$entry["v"][1]
		);

		if (!isset($last[$pair]) || $current[$pair][4] != $last[$pair][4]) {
			echo implode("\t", $current[$pair]) . "\n";
		}
	}

	$last = $current;
}
