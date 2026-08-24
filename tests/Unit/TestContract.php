<?php

declare(strict_types=1);

namespace Quillstack\StorageInterface\Tests\Unit;

use Quillstack\StorageInterface\StorageInterface;
use Quillstack\UnitTests\AssertEqual;
use Quillstack\UnitTests\Types\AssertBoolean;
use ReflectionClass;

/**
 * What this package promises.
 *
 * A signature that moves here moves in every package that implements this one and every package
 * that depends on one — which is exactly the change worth having a test notice, and the only
 * thing there is to test in a package containing no code.
 */
class TestContract
{
    /**
     * The methods, and how many arguments each one requires. `delete()` takes more than one —
     * it is variadic — but requires exactly one, and what a caller must pass is the promise.
     *
     * @var array<string, int>
     */
    private const PROMISED = [
        'get' => 1,
        'exists' => 1,
        'missing' => 1,
        'save' => 2,
        'add' => 2,
        'delete' => 1,
    ];

    public function __construct(
        private AssertEqual $assertEqual,
        private AssertBoolean $assertBoolean
    ) {
        //
    }

    public function itPromisesTheseMethodsAndNoOthers()
    {
        $names = array_map(
            static fn (\ReflectionMethod $method): string => $method->getName(),
            (new ReflectionClass(StorageInterface::class))->getMethods()
        );

        sort($names);
        $promised = array_keys(self::PROMISED);
        sort($promised);

        $this->assertEqual->equal($promised, $names);
    }

    public function eachRequiresWhatItSaysItRequires()
    {
        $reflection = new ReflectionClass(StorageInterface::class);

        foreach (self::PROMISED as $name => $arguments) {
            $this->assertEqual->equal(
                $arguments,
                $reflection->getMethod($name)->getNumberOfRequiredParameters()
            );
        }
    }

    /**
     * An interface with an implementation in it is not an interface any more.
     */
    public function itIsAnInterfaceAndNothingElse()
    {
        $this->assertBoolean->isTrue((new ReflectionClass(StorageInterface::class))->isInterface());
        $this->assertEqual->equal(1, count(glob(dirname(__FILE__) . '/../../src/*.php') ?: []));
    }
}
