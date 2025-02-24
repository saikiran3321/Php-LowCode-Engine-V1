<?php

if( file_exists("vendor/autoload.php") ){
	require_once("vendor/autoload.php");
}else if( file_exists("../vendor/autoload.php") ){
	require_once("../vendor/autoload.php");
}else if( file_exists("../../vendor/autoload.php") ){
	require_once("../../vendor/autoload.php");
}else if( file_exists("../../../vendor/autoload.php") ){
	require_once("../../../vendor/autoload.php");
}else{
	echo "Incorrect include path!";exit;
}

class mongodb_connection{

	public $database = false;
	public $connection = false;
	public $debug = false;

	function __construct( $host = "localhost", $port = 27017, $db = "test", $user = "", $pass = "", $authdb='admin', $tls = false ){
		//echo $hostname;exit;
		$options = [
			'retryWrites'=>false,
			'retryReads'=>false,
			'socketTimeoutMS' => 10000,
			'connectTimeoutMS'=> 3000,
			'maxIdleTimeMS'=> 600
		];
		if( $user ){
			$options['authSource'] = $authdb;
			$auth = $user . ':' . urlencode($pass) . '@';
		}
		//echo "mongodb://". $auth . $host.":".$port;exit;
		$this->connection = new MongoDB\Client( "mongodb://". $auth . $host.":".$port. "/".$db,$options, [
			'typeMap'=>[
				'array'=>'array',
				'root'=>'array',
				'document'=>'array'
			]
		] );
		$this->database = $this->connection->{ $db };
	}

	function error($e){
		header("http/1.1 500 error");
		echo $e;
		exit;
	}

	function get_id( $vid ){
		if( preg_match("/^[a-f0-9]{24}$/", $vid) ){
			try{
				return new MongoDB\BSON\ObjectID( $vid );
			}catch(Exception $ex){
				echo $ex->getMessage();exit;
				return false;
			}
		}else{
			return $vid;
		}
	}

	function generate_id(){
		try{
			$k = new MongoDB\BSON\ObjectID();
			$k = (array)$k;
			//print_pre( $k );
			return $k['oid'];
		}catch(Exception $ex){
			$this->error( "Object ID Parse Failed: " . $vid . " : " . $ex->getMessage() );
			return false;
		}
	}

		function insert( $collection, $insert_data, $options = [] ){
			$col = $this->database->{$collection};
			try{
				if( $insert_data["_id"] && is_string( $insert_data["_id"] ) ){
					$insert_data["_id"] = $this->get_id( $insert_data["_id"] );
				}
				$insert_data["m_i"]=date("Y-m-d H:i:s");
				$cur = $col->insertOne($insert_data);
				$id =  (string)$cur->getInsertedId();
				return ["status"=>"success","inserted_id"=>$id];
			}catch(Exception $ex){
				return ["status"=>"fail","error"=>$ex->getMessage()];
			}
			return false;
		}

		function find($collection, $condition = array(), $option = array() ){
			if( ! is_string($collection) ){
				return ["status"=>"fail","error"=>"collection name required"];
			}
			if( !is_array($condition) ){
				return ["status"=>"fail","error"=>"condition is not array"];
			}
			$option["collation"] = [ "locale"=>"en_US", "strength"=> 2];
			if( !$option['limit'] ){
				$option['limit'] = 500;
			}
			//print_pre( $option );exit;
			$col = $this->database->{$collection};
			try{
				if( $condition["_id"] && is_string( $condition["_id"] ) ){
					$condition["_id"] = $this->get_id( $condition["_id"] );
				}
				$cur = $col->find($condition, $option)->toArray();
				foreach( $cur as $i=>$j ){
					if( $cur[$i]['_id'] ){
						$cur[$i]['_id'] = (string)$cur[$i]['_id'];
					}
				}
				return ["status"=>"success","data"=>$cur];
			}catch(Exception $ex){
				return ["status"=>"fail","error"=>$ex->getMessage()];
			}
		}
		function find_with_key($collection, $key = "_id", $condition = array(), $option = array() ){
			if( !is_string($collection) ){
				return ["status"=>"fail","error"=>"collection name required"];
			}
			if( !is_string($key) ){
				return ["status"=>"fail","error"=>"key is required"];
			}
			if( !is_array($condition) ){
				return ["status"=>"fail","error"=>"condition is not array"];
			}
			$col = $this->database->{$collection};
			$option["collation"] = [ "locale"=>"en_US", "strength"=> 2];
			if( !$options['limit'] ){
				$options['limit'] = 500;
			}
			$newcur = [];
			try{
				if( $condition["_id"] && is_string( $condition["_id"] ) ){
					$condition["_id"] = $this->get_id( $condition["_id"] );
				}
				//$cur = bson_to_json($col->find($condition, $option));
				$cur = $col->find($condition, $option)->toArray();
				for($i = 0; $i< count($cur);$i++){
					if( $cur[$i]['_id'] ){
						$cur[$i]['_id']=(string)$cur[$i]['_id'];
					}
					$newcur[ $cur[$i][$key] ] = $cur[$i];
				}
				return ["status"=>"success","data"=>$newcur];
			}catch(Exception $ex){
				return ["status"=>"fail","error"=>$ex->getMessage()];
			}
			return $newcur;
		}
		function find_assoc($collection, $key = "_id", $value = "_id", $condition = array(), $option = array() ){
			if( !is_string($collection) ){
				return ["status"=>"fail","error"=>"collection name required"];
			}
			if( !is_string($key) ){
				return ["status"=>"fail","error"=>"key is required"];
			}
			if( !is_string($value) ){
				return ["status"=>"fail","error"=>"value is required"];
			}
			if( !is_array($condition) ){
				return ["status"=>"fail","error"=>"condition is not array"];
			}
			$col = $this->database->{$collection};
			$option["collation"] = [ "locale"=>"en_US", "strength"=> 2];
			if( !$options['limit'] ){
				$options['limit'] = 500;
			}
			$options['projection'] = [ $key=>1, $value=>1];
			$newcur = [];
			try{
				if( $condition["_id"] && is_string( $condition["_id"] ) ){
					$condition["_id"] = $this->get_id( $condition["_id"] );
				}
				//$cur = bson_to_json($col->find($condition, $option));
				$cur = $col->find($condition, $option)->toArray();
				for($i = 0; $i< count($cur);$i++){
					if( $cur[$i]['_id'] ){
						$cur[$i]['_id']=(string)$cur[$i]['_id'];
					}
					$newcur[ $cur[$i][$key] ] = $cur[$i][$value];
				}
				return ["status"=>"success","data"=>$newcur];
			}catch(Exception $ex){
				return ["status"=>"fail","error"=>$ex->getMessage()];
			}
			return $newcur;
		}

		function find_one($collection, $condition = array(), $option = array() ){
			if( ! is_string($collection) ){
				return ["status"=>"fail","error"=>"collection name required"];
			}
			if( !is_array($condition) ){
				return ["status"=>"fail","error"=>"condition is not array"];
			}
			$col = $this->database->{$collection};
			try{
				if( $condition["_id"] && is_string( $condition["_id"] ) ){
					$condition["_id"] = $this->get_id( $condition["_id"] );
				}
				$cur = (array)$col->findOne($condition,$option);
				//echo "<pre>";print_r( $cur );
				if($cur['_id']){
					$cur['_id'] = (string)$cur['_id'];
				}
				return ["status"=>"success","data"=>$cur];
			}catch(Exception $ex){
				return ["status"=>"fail","error"=>$ex->getMessage()];
			}
			return $cur;
		}
		function count($collection, $filter = array(), $option = array() ){
			$col = $this->database->{$collection};
			try{
				$cnt = $col->count( $filter, $option );
				return ["status"=>"success","data"=>$cnt];
			}catch(Exception $ex){
				return ["status"=>"fail","error"=>$ex->getMessage()];
			}
			return false;
		}

		function update_many($collection,$data,$condition){
			if( !is_string($collection) ){
				return ["status"=>"fail","error"=>"collection name required"];
			}
			if( !is_array($condition) ){
				return ["status"=>"fail","error"=>"condition is not array"];
			}
			$col = $this->database->{$collection};
			try{
				if( $data['$set'] || $data['$inc'] || $data['$rename'] || $data['$unset'] ){
				}else{
					$data = ['$set'=>$data];
				}
				if( $condition["_id"] && is_string( $condition["_id"] ) ){
					$condition["_id"] = $this->get_id( $condition["_id"] );
				}
				$res=$col->updateMany($condition, $data);
				return [
					"status"=>"success", 
					"data"=>[
						"matched_count"=>$res->getMatchedCount(),
						"modified_count"=>$res->getModifiedCount(),
						"upserted_count"=>$res->getUpsertedCount()
					]
				];
			}catch(Exception $ex){
				return ["status"=>"fail","error"=>$ex->getMessage()];
				return false;
			}
			return true;
		}

		function update_one($collection,$condition,$data){
			if( !is_string($collection) ){
				return ["status"=>"fail","error"=>"collection name required"];
			}
			if( !is_array($condition) ){
				return ["status"=>"fail","error"=>"condition is not array"];
			}
			if( !is_array($data) ){
				return ["status"=>"fail","error"=>"data is not array"];
			}
			$col = $this->database->{$collection};
			try{
				if( $condition["_id"] && is_string( $condition["_id"] ) ){
					$condition["_id"] = $this->get_id( $condition["_id"] );
				}
				if( $data['$set'] || $data['$inc'] || $data['$rename'] || $data['$unset'] ){
				}else{
					$data = ['$set'=>$data];
				}
				$res=$col->updateOne($condition, $data);
				return [
					"status"=>"success", 
					"data"=>[
						"matched_count"=>$res->getMatchedCount(),
						"modified_count"=>$res->getModifiedCount(),
						"upserted_count"=>$res->getUpsertedCount()
					]
				];
			}catch(Exception $ex ){
				return ["status"=>"fail","error"=>$ex->getMessage()];
			}
			return true;
		}

		function getnextseq($collection, $condition = array(),$data = array()){
			if( !is_string($collection) ){
				return ["status"=>"fail","error"=>"collection name required"];
			}
			if( !is_array($condition) ){
				return ["status"=>"fail","error"=>"condition is not array"];
			}
			if( !is_array($data) ){
				return ["status"=>"fail","error"=>"data is not array"];
			}
			$col = $this->database->{$collection};
			try{
				$option =[
				'upsert'=> true,
				'new' => true,
				'returnDocument' => MongoDB\Operation\FindOneAndUpdate::RETURN_DOCUMENT_AFTER,
				];
				$cur =$col->findOneAndUpdate($condition,$data,$option);
			}catch(Exception $ex){
				return ["status"=>"fail","error"=>$ex->getMessage()];
			}
			return $cur;
		}
		function increment($collection, $key = "something", $val = "val", $incr = 1){
			if( !is_string($collection) ){
				return ["status"=>"fail","error"=>"collection name required"];
			}
			if( !is_string($key) ){
				return ["status"=>"fail","error"=>"key is not string"];
			}
			$incr = (int)$incr;
			$col = $this->database->{$collection};
			try{
				$option = [
					'upsert'=> true,
					'new' => true,
					'returnDocument' => MongoDB\Operation\FindOneAndUpdate::RETURN_DOCUMENT_AFTER,
				];
				$cur =$col->findOneAndUpdate([
					'_id'=>$this->get_id($key)
				],[
					'$set'=>[
						'_id'=>$this->get_id($key),
					],
					'$inc'=>[
						$val=>$incr
					]
				],$option);
				return ["status"=>"success","data"=>$cur];;
			}catch(Exception $ex){
				return ["status"=>"fail","error"=>$ex->getMessage()];
			}
		}
		function decrement($collection, $key = "something", $val = "val", $incr = 1){
			if( !is_string($collection) ){
				return ["status"=>"fail","error"=>"collection name required"];
			}
			if( !is_string($key) ){
				return ["status"=>"fail","error"=>"key is not string"];
			}
			$incr = (int)$incr;
			$col = $this->database->{$collection};
			try{
				$option =[
					'upsert'=> true,
					'new' => true,
					'returnDocument' => MongoDB\Operation\FindOneAndUpdate::RETURN_DOCUMENT_AFTER,
				];
				$cur =$col->findOneAndUpdate([
					'_id'=>$this->get_id($key)
				],[
					'$inc'=>[
						$val=>$incr
					]
				],$option);
				return ["status"=>"success","data"=>$cur];;
			}catch(Exception $ex){
				return ["status"=>"fail","error"=>$ex->getMessage()];
			}
		}

		function aggregate( $collection, $pipeline, $options = [] ){
			if( !is_string($collection) ){
				return ["status"=>"fail","error"=>"collection name required"];
			}
			if( !is_array($pipeline) ){
				return ["status"=>"fail","error"=>"pipeline is not array"];
			}
			$col = $this->database->{$collection};
			try{
				$res=$col->aggregate($pipeline, $options)->toArray();
				return $res;
			}catch(Exception $ex){
				return ["status"=>"fail","error"=>$ex->getMessage()];
			}
			return false;
		}

		function delete_one( $collection, $condition ){
			if( !is_string($collection) ){
				return ["status"=>"fail","error"=>"collection name required"];
			}
			if( !is_array($condition) ){
				return ["status"=>"fail","error"=>"condition is not array"];
			}
			$col = $this->database->{$collection};
			try{
				if( $condition["_id"] && is_string( $condition["_id"] ) ){
					$condition["_id"] = $this->get_id( $condition["_id"] );
				}
				$res = $col->deleteOne( $condition );
				return [ "status"=>"success", "deleted_count"=>$res->getDeletedCount() ];
			}catch(Exception $ex){
				return ["status"=>"fail","error"=>$ex->getMessage()];
			}
			return true;
		}

		function delete_many( $collection, $condition ){
			$col = $this->database->{$collection};
			try{
				if( $condition["_id"] && is_string( $condition["_id"] ) ){
					$condition["_id"] = $this->get_id( $condition["_id"] );
				}
				$res = $col->deletemany($condition);
				return [ "status"=>"success", "deleted_count"=>$res->getDeletedCount() ];
			}catch(Exception $ex){
				return ["status"=>"fail","error"=>$ex->getMessage()];
			}
			return true;
		}

		function find_and_delete($collection,$condition){
			$col = $this->database->{$collection};
			try{
				if( $condition["_id"] && is_string( $condition["_id"] ) ){
					$condition["_id"] = $this->get_id( $condition["_id"] );
				}
				$col->findOneAndDelete($condition);
				return [ "status"=>"success", "deleted_count"=>$res->getDeletedCount() ];
			}catch(Exception $ex){
				return ["status"=>"fail","error"=>$ex->getMessage()];
			}
			return true;
		}

		function drop_collection( $collection ){
			$col = $this->database->{$collection};
			try{
				$col->drop();
				return true;
			}catch(Exception $ex){
				return ["status"=>"fail","error"=>$ex->getMessage()];
			}
			return false;
		}

		function list_collections(){
			try{
				$res = $this->database->listCollectionNames();
				$cols =[];
				foreach( $res as $i=>$j ){
					$cols[] = $j;
				}
				return ['status'=>"success", "data"=>$cols];
			}catch(Exception $ex){
				return ["status"=>"fail","error"=>$ex->getMessage()];
			}
		}

		function drop_table($table){
			$col = $this->database->{$collection};
			$col->drop();
		}
}