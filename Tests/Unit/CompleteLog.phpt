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

final class CompleteLog extends Tester\TestCase {
	public function testProvidedFields() {
		$content = (new Log\CompleteLog(
			new class implements Log\Log {
				public function content(): array {
					return ['a' => 1];
				}
			},
			new class implements Log\Log {
				public function content(): array {
					return ['b' => 2];
				}
			}
		))->content();
		Assert::same(['a' => 1, 'b' => 2], $content);
	}
}
(new CompleteLog())->run();
