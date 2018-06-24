<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Log\Unit;

use Klapuch\Log;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class ExceptionLog extends Tester\TestCase {
	public function testProvidedFields() {
		$content = (new Log\ExceptionLog(new \RuntimeException('foo')))->content();
		Assert::same(array_keys($content), ['type', 'code', 'file', 'line', 'message', 'trace']);
		Assert::same('RuntimeException', $content['type']);
		Assert::same(0, $content['code']);
		Assert::same('/var/www/Log/Tests/Unit/ExceptionLog.phpt', $content['file']);
		Assert::same(17, $content['line']);
		Assert::same('foo', $content['message']);
		Assert::true(isset($content['trace']));
	}
}
(new ExceptionLog())->run();
