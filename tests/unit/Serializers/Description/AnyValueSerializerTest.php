<?php

namespace Ask\Tests\Ask\Wikitext\Formatter\Description;

use Ask\Language\Description\AnyValue;
use Ask\Wikitext\Serializers\Description\AnyValueSerializer;

/**
 * @covers Ask\Wikitext\Serializers\Description\AnyValueSerializer
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 */
class AnyValueSerializerTest extends \PHPUnit_Framework_TestCase {

	public function testFormatAnyValue() {
		$anyValue = new AnyValue();

		$formatter = new AnyValueSerializer();

		$this->assertEquals( '+', $formatter->serialize( $anyValue ) );
	}

}
