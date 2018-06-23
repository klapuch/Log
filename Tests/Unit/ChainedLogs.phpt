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

final class ChainedLogs extends Tester\TestCase {
	public function testLoggingEach() {
		ob_start();
		(new Log\ChainedLogs(
			new class implements Log\Logs {
				public function put(\Throwable $exception, Log\Environment $environment): void {
					echo 'a';
				}
			},
			new class implements Log\Logs {
				public function put(\Throwable $exception, Log\Environment $environment): void {
					echo 'b';
				}
			}
		))->put(new \RuntimeException(), new Log\FakeEnvironment());
		Assert::same('ab', ob_get_clean());
	}
}

(new ChainedLogs())->run();
