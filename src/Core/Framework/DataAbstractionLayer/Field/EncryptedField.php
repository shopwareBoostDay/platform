<?php declare(strict_types=1);

namespace Shopware\Core\Framework\DataAbstractionLayer\Field;

use Shopware\Core\Framework\DataAbstractionLayer\FieldSerializer\EncryptedFieldSerializer;

class EncryptedField extends Field implements StorageAware
{
    /**
     * @var string
     */
    private $storageName;

    /**
     * @var string|int|null
     */
    private $algorithm;

    /**
     * @param string|int $algorithm
     */
    public function __construct(string $storageName, string $propertyName, $algorithm = 'DEFAULT ALOG')
    {
        parent::__construct($propertyName);
        $this->storageName = $storageName;
        $this->algorithm = $algorithm;
    }

    public function getStorageName(): string
    {
        return $this->storageName;
    }

    /**
     * since php 7.4 the algorithms are identified as string -> https://wiki.php.net/rfc/password_registry#backward_incompatible_changes
     *
     * @return int|string|null
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    protected function getSerializerClass(): string
    {
        return EncryptedFieldSerializer::class;
    }
}
