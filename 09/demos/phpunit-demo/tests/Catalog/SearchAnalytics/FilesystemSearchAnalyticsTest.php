<?php
declare(strict_types=1);

namespace App\Tests\Catalog\SearchAnalytics;

use App\Catalog\SearchAnalytics\FilesystemSearchAnalytics;
use App\Clock\Clock;
use App\Tests\IntegrationTestCase;
use DI;

/** @covers \App\Catalog\SearchAnalytics\FilesystemSearchAnalytics */
final class FilesystemSearchAnalyticsTest extends IntegrationTestCase
{
    const FILE_PATH = __DIR__ . '/../../../var/search_analytics.csv';

    /** @test */
    public function track(): void
    {
        unlink(self::FILE_PATH);

        $this->initializeContainer();
        $this->diContainer->set(Clock::class, DI\factory(function () {
            $clock = $this->createStub(Clock::class);
            $clock
                ->method('now')
                ->willReturn(new \DateTimeImmutable('2020-01-01 12:01:02', new \DateTimeZone('UTC')));
            return $clock;
        }));

        $analytics = $this->diContainer->get(FilesystemSearchAnalytics::class);
        $analytics->track(['price' => null, 'name' => null]);
        self::assertEquals(
            '"2020-01-01T12:01:02+00:00","{\"price\":null,\"name\":null}"',
            file_get_contents(self::FILE_PATH)
        );
    }
}
