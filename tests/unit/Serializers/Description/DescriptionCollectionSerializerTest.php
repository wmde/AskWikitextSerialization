<?php

namespace Ask\Tests\Ask\Wikitext\Serializers\Description;

use Ask\Language\Description\Conjunction;
use Ask\Language\Description\Disjunction;
use Ask\Wikitext\Serializers\Description\DescriptionCollectionSerializer;
use Serializers\Serializer;
use Ask\Language\Description\AnyValue;

/**
 * @covers Ask\Wikitext\Serializers\Description\DescriptionCollectionSerializer
 *
 * @licence GNU GPL v2+
 * @author Jan Zerebecki < jan.wikimedia@zerebecki.de >
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DescriptionCollectionSerializerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Serializer
	 */
	private $serializer;

	public function setUp() {
		$this->serializer = new DescriptionCollectionSerializer(
			$this->getStubDescriptionSerializer()
		);
	}

	private function getStubDescriptionSerializer() {
		$serializer = $this->getMock( 'Serializers\Serializer' );

		$serializer->expects( $this->any() )
			->method( 'serialize' )
			->will( $this->returnValue( '[[kittens]]' ) );

		return $serializer;
	}

	public function testGivenNonCollection_serializeThrowsException() {
		$this->setExpectedException( 'InvalidArgumentException' );
		$this->serializer->serialize( new AnyValue() );
	}

	public function testGivenEmptyCollection_emptyStringIsReturned() {
		$this->assertSame( '', $this->serializer->serialize( new Conjunction( array() ) ) );
	}

	public function testGivenCollectionWithOneDescription_onlyDescriptionIsReturned() {
		$collection = new Conjunction(
			array(
				$this->getMock( 'Ask\Language\Description\Description' ),
			)
		);

		$this->assertSame( '[[kittens]]', $this->serializer->serialize( $collection ) );
	}

	public function testGivenConjunction_spaceIsUsedAsSeparator() {
		$collection = new Conjunction(
			array(
				$this->getMock( 'Ask\Language\Description\Description' ),
				$this->getMock( 'Ask\Language\Description\Description' ),
				$this->getMock( 'Ask\Language\Description\Description' ),
			)
		);

		$this->assertSame(
			'[[kittens]] [[kittens]] [[kittens]]',
			$this->serializer->serialize( $collection )
		);
	}

	public function testGivenDisjunction_orIsUsedAsSeparator() {
		$collection = new Disjunction(
			array(
				$this->getMock( 'Ask\Language\Description\Description' ),
				$this->getMock( 'Ask\Language\Description\Description' ),
				$this->getMock( 'Ask\Language\Description\Description' ),
			)
		);

		$this->assertSame(
			'[[kittens]] OR [[kittens]] OR [[kittens]]',
			$this->serializer->serialize( $collection )
		);
	}

}
