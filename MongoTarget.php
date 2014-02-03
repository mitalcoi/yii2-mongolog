<?php
namespace mitalcoi;
use yii\log\Target;
use Yii;

/**
 * Class MongoTarget
 *
 */
class MongoTarget extends Target
{

	/**
	 * @var string connection ID
	 */
	public $connectionID = "mongodb";

	/**
	 * @var string collection name
	 */
	public $collectionName = "log";

	/**
	 * @var \yii\mongodb\Connection mongo Db collection
	 */
	private $_connection;

	/** @inheritdoc */
	public function init()
	{
		parent::init();
		$this->_connection = Yii::$app->{$this->connectionID};
	}

	/** @inheritdoc */
	public function export()
	{
		foreach ($this->messages as $message) {
			$this->_connection->getCollection($this->collectionName)->insert([
				'level' => $message[1],
				'category' => $message[2],
				'log_time' => time(),
				'message' => $message[0],
			]);
		}
	}

}
