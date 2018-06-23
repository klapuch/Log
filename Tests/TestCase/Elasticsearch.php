<?php
declare(strict_types = 1);
namespace Klapuch\Log\TestCase;

use Elasticsearch\ClientBuilder;
use Tester;

trait Elasticsearch {
	/** @var \Elasticsearch\Client */
	protected $elasticsearch;

	protected function setUp(): void {
		parent::setUp();
		Tester\Environment::lock('elasticsearch', __DIR__ . '/../Temporary');
		$credentials = parse_ini_file(__DIR__ . '/../Configuration/config.ini', true);
		$this->elasticsearch = ClientBuilder::create()
			->setHosts($credentials['ELASTICSEARCH']['hosts'])
			->build();
		$this->elasticsearch->indices()->delete(['index' => '*']);
	}
}
