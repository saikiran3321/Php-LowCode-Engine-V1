<?php

if( !is_dir( "/tmp/apimaker" ) ){
	mkdir( "/tmp/apimaker", 0755 );
}

$engine_cache_path = "/tmp/apimaker/engine_" . $config_engine_app_id . ".php";
if( file_exists($engine_cache_path) ){
	$cache_refresh = false;
	require_once($engine_cache_path);
	if( !$config_global_engine ){
		$cache_refresh = true;
	}
	if( filemtime($engine_cache_path) < time()-(int)$config_global_apimaker_engine["config_engine_cache_interval"] ){
		$cache_refresh = true;
	}
	$k = $config_global_apimaker_engine["config_engine_cache_refresh_action_query_string"];
	if( $k ){
		if( $_GET[ array_keys($k)[0] ] ){
			if( $_GET[ array_keys($k)[0] ] == $k[ array_keys($k)[0] ] ){
				$cache_refresh = "yes";
			}
		}
	}
}else{
	$cache_refresh = true;
}

if( $cache_refresh ){
	$resp = get_request([
		"url"=>$config_global_apimaker_engine["config_apimaker_endpoint_url"] . "/engine_api/configs/get",
		"headers"=>[
			'APPID: ' . $config_global_apimaker_engine["config_engine_app_id"],
	    	'APPKEY: ' . $config_global_apimaker_engine["config_engine_key"]
		],
	]);
	//echo "<pre>";print_r( $resp );exit;
	if( $resp['status'] == "error" ){
		http_response_code(500); echo "Cache Engine: " . $resp['error'];	exit;
	}else if( $resp['status'] != 200 ){
		http_response_code(500); echo "Cache Engine: http: " .$resp['status'];	exit;
	}else if( $resp['body'] == "" ){
		http_response_code(500); echo "Cache Engine: empty response";	exit;
	}
	$res = json_decode($resp['body'],true);
	if( json_last_error() ){
		http_response_code(500); echo "Cache Engine: json parse error "; exit;
	}
	//print_r( $res );
	if( $res['status'] != "success" ){
		http_response_code(500); echo "Cache Engine: error: " . $res['error']; exit;
	}
	file_put_contents($engine_cache_path, "<"."?php\n\$config_global_engine = " . var_export($res['configs'],true) . "; ?>" );
	if( !file_exists($engine_cache_path) ){
		http_response_code(500); echo "Cache Engine: error: filesystem fail"; exit;
	}
	$config_global_engine = $res['configs'];
	//if( $cache_refresh === "yes" ){ echo "Cache Refreshed successfully!" . $cache_refresh;exit; }
	//echo "engine updated";	exit;
}

/* Mongo DB connection */
require("class_mongodb.php");

if( $config_global_engine['config_mongo_username'] ){
	$mongodb_con = new mongodb_connection( 
		$config_global_engine['config_mongo_host'], 
		$config_global_engine['config_mongo_port'], 
		$config_global_engine['config_mongo_db'], 
		$config_global_engine['config_mongo_username'], 
		$config_global_engine['config_mongo_password'], 
		$config_global_engine['config_mongo_authSource'], 
		$config_global_engine['config_mongo_tls']
	);
}else{
	$mongodb_con = new mongodb_connection( 
		$config_global_engine['config_mongo_host'], 
		$config_global_engine['config_mongo_port'], 
		$config_global_engine['config_mongo_db'] 
	);
}

/* Mongo DB connection */