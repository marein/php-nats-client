<?php
declare(strict_types=1);

namespace Marein\Nats\Tests\Unit\Protocol\Model;

use Marein\Nats\Protocol\Model\Subject;
use PHPUnit\Framework\TestCase;

class SubjectTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeCreatedWithItsValues(): void
    {
        $expectedName = 'name';

        $subject = new Subject('name');

        $this->assertSame($expectedName, (string)$subject);
    }

    /**
     * @test
     */
    public function itShouldBeCreatedRandomly(): void
    {
        $subjectOne = Subject::random();
        $subjectTwo = Subject::random();

        $this->assertNotSame((string)$subjectOne, (string)$subjectTwo);
    }
}
