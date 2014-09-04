<?php

namespace Ask\Tests\Ask\Wikitext\Formatter\Description;

use Ask\Language\Description\AnyValue;
use Ask\Wikitext\Formatter\Description\AnyValueFormatter;

/**
 * @covers Ask\Wikitext\Formatter\Description\AnyValueFormatter
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class AnyValueFormatterTest extends \PHPUnit_Framework_TestCase {

	public function testFormatAnyValue() {
		$anyValue = new AnyValue();

		$formatter = new AnyValueFormatter();

		$this->assertEquals( '+', $formatter->format( $anyValue ) );
	}

}
