<?php declare(strict_types=1);

namespace Shopware\Core\Framework\Test\DataAbstractionLayer\Search\Parser;

use PHPUnit\Framework\TestCase;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Exception\InvalidFilterQueryException;
use Shopware\Core\Framework\DataAbstractionLayer\Exception\SearchRequestException;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\ContainsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Parser\QueryStringParser;

class QueryStringParserTest extends TestCase
{
    public function testWithUnsupportedFormat(): void
    {
        $this->expectException(InvalidFilterQueryException::class);
        QueryStringParser::fromArray(ProductDefinition::class, ['type' => 'foo'], new SearchRequestException());
    }

    public function testInvalidParameters(): void
    {
        $this->expectException(InvalidFilterQueryException::class);
        QueryStringParser::fromArray(ProductDefinition::class, ['foo' => 'bar'], new SearchRequestException());
    }

    /**
     * @dataProvider equalsFilterDataProvider
     *
     * @param array $filter
     * @param bool  $expectException
     */
    public function testEqualsFilter(array $filter, bool $expectException): void
    {
        if ($expectException) {
            $this->expectException(InvalidFilterQueryException::class);
        }

        /** @var EqualsFilter $result */
        $result = QueryStringParser::fromArray(ProductDefinition::class, $filter, new SearchRequestException());

        static::assertInstanceOf(EqualsFilter::class, $result);

        static::assertEquals($result->getField(), 'product.' . $filter['field']);
        static::assertEquals($result->getValue(), $filter['value']);
    }

    public function equalsFilterDataProvider(): array
    {
        return [
            [['type' => 'equals', 'field' => 'foo', 'value' => 'bar'], false],
            [['type' => 'equals', 'field' => 'foo', 'value' => ''], true],
            [['type' => 'equals', 'field' => '', 'value' => 'bar'], true],
            [['type' => 'equals', 'field' => 'foo'], true],
            [['type' => 'equals', 'value' => 'bar'], true],
            [['type' => 'equals', 'field' => 'foo', 'value' => true], false],
            [['type' => 'equals', 'field' => 'foo', 'value' => false], false],
            [['type' => 'equals', 'field' => 'foo', 'value' => 1], false],
            [['type' => 'equals', 'field' => 'foo', 'value' => 0], false],
        ];
    }

    /**
     * @dataProvider containsFilterDataProvider
     *
     * @param array $filter
     * @param bool  $expectException
     */
    public function testContainsFilter(array $filter, bool $expectException): void
    {
        if ($expectException) {
            $this->expectException(InvalidFilterQueryException::class);
        }

        /** @var EqualsFilter $result */
        $result = QueryStringParser::fromArray(ProductDefinition::class, $filter, new SearchRequestException());

        static::assertInstanceOf(ContainsFilter::class, $result);

        static::assertEquals($result->getField(), 'product.' . $filter['field']);
        static::assertEquals($result->getValue(), $filter['value']);
    }

    public function containsFilterDataProvider(): array
    {
        return [
            [['type' => 'contains', 'field' => 'foo', 'value' => 'bar'], false],
            [['type' => 'contains', 'field' => 'foo', 'value' => ''], true],
            [['type' => 'contains', 'field' => '', 'value' => 'bar'], true],
            [['type' => 'contains', 'field' => 'foo'], true],
            [['type' => 'contains', 'value' => 'bar'], true],
            [['type' => 'contains', 'field' => 'foo', 'value' => true], false],
            [['type' => 'contains', 'field' => 'foo', 'value' => false], false],
            [['type' => 'contains', 'field' => 'foo', 'value' => 1], false],
            [['type' => 'contains', 'field' => 'foo', 'value' => 0], false],
        ];
    }

    /**
     * @dataProvider equalsAnyFilterDataProvider
     *
     * @param array $filter
     * @param bool  $expectException
     */
    public function testEqualsAnyFilter(array $filter, bool $expectException): void
    {
        if ($expectException) {
            $this->expectException(InvalidFilterQueryException::class);
        }

        /** @var EqualsAnyFilter $result */
        $result = QueryStringParser::fromArray(ProductDefinition::class, $filter, new SearchRequestException());

        static::assertInstanceOf(EqualsAnyFilter::class, $result);

        $expectedValue = $filter['value'];
        if (\is_string($expectedValue)) {
            $expectedValue = array_filter(explode('|', $expectedValue));
        }

        if (!\is_array($expectedValue)) {
            $expectedValue = [$expectedValue];
        }

        static::assertEquals($result->getField(), 'product.' . $filter['field']);
        static::assertEquals($result->getValue(), $expectedValue);
    }

    public function equalsAnyFilterDataProvider(): array
    {
        return [
            [['type' => 'equalsAny', 'field' => 'foo', 'value' => 'bar'], false],
            [['type' => 'equalsAny', 'field' => 'foo', 'value' => ''], true],
            [['type' => 'equalsAny', 'field' => '', 'value' => 'bar'], true],
            [['type' => 'equalsAny', 'field' => 'foo', 'value' => 'abc|def|ghi'], false],
            [['type' => 'equalsAny', 'field' => 'foo', 'value' => 'false|true|0'], false],
            [['type' => 'equalsAny', 'field' => 'foo'], true],
            [['type' => 'equalsAny', 'value' => 'foo'], true],
            [['type' => 'equalsAny', 'field' => 'foo', 'value' => '||||'], true],
            [['type' => 'equalsAny', 'field' => 'foo', 'value' => true], false],
            [['type' => 'equalsAny', 'field' => 'foo', 'value' => false], true],
            [['type' => 'equalsAny', 'field' => 'foo', 'value' => 0], true],
            [['type' => 'equalsAny', 'field' => 'foo', 'value' => 1], false],
        ];
    }
}
