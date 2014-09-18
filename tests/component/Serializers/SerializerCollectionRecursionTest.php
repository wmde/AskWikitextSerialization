<?php

namespace Ask\Tests\Ask\Wikitext\Serializers;

use Ask\Language\Description\AnyValue;
use Ask\Language\Description\Conjunction;
use Ask\Language\Description\Description;
use Ask\Language\Description\Disjunction;
use Ask\Language\Description\SomeProperty;
use Ask\Wikitext\Serializers\SerializerFactory;
use DataValues\StringValue;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SerializerCollectionRecursionTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider nestedDescriptionCollectionsProvider
	 */
	public function testDisjunctionAndConjunctionRecursionSerialization( $expected, Description $description ) {
		$factory = new SerializerFactory();
		$serializer = $factory->newDescriptionSerializer();

		$this->assertSame( $expected, $serializer->serialize( $description ) );
	}

	public function nestedDescriptionCollectionsProvider() {
		return array(
			array(
				'[[P1::+]] OR [[P2::+]] [[P3::+]] OR [[P4::+]]',
				new Conjunction( array(
					new Disjunction( array(
						new SomeProperty( new StringValue( 'P1' ), new AnyValue() ),
						new SomeProperty( new StringValue( 'P2' ), new AnyValue() ),
					) ),
					new Disjunction( array(
						new SomeProperty( new StringValue( 'P3' ), new AnyValue() ),
						new SomeProperty( new StringValue( 'P4' ), new AnyValue() ),
					) ),
				) )
			)
		);
	}

}
