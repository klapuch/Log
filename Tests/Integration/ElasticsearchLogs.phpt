<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Log\Integration;

use Klapuch\Log;
use Klapuch\Log\TestCase;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class ElasticsearchLogs extends Tester\TestCase {
	use TestCase\Elasticsearch;

	public function testStoringOnPile() {
		(new Log\ElasticsearchLogs(
			$this->elasticsearch,
			(new \DateTimeImmutable('2005-01-01 10:00'))
		))->put(new Log\JsonLog(new \RuntimeException('Ooops')));
		sleep(1);
		$response = $this->elasticsearch->search(['index' => 'logs', 'type' => 'pile']);
		Assert::same(1, $response['hits']['total']);
	}
}

(new ElasticsearchLogs())->run();