<?php
declare(strict_types=1);

namespace MixerApi\Core\View;

use Cake\Datasource\EntityInterface;

/**
 * This class checks a Cake\ORM\Entity for properties that can be serialize and returns a key-value pair. The following
 * properties are ignored:
 *
 * - That begin with an underscore "_"
 * - Values that are not one of: array or EntityInterface
 */
class SerializableAssociation
{
    /**
     * Key-value pair of serializable associations
     *
     * @var array
     */
    private $associations = [];

    /**
     * @param \Cake\Datasource\EntityInterface $entity Cake\ORM\Entity or an EntityInterface
     */
    public function __construct(EntityInterface $entity)
    {
        $properties = array_filter($entity->getVisible(), function ($property) use ($entity) {

            if (!isset($entity->{$property}) || strpos($property, '_') === 0) {
                return false;
            }

            if (!is_array($entity->{$property}) && !$entity->{$property} instanceof EntityInterface) {
                return false;
            }

            return true;
        });

        foreach ($properties as $property) {
            $this->associations[$property] = $entity->{$property};
        }
    }

    /**
     * Returns a key-value pair of serializable associations
     *
     * @return array
     */
    public function getAssociations(): array
    {
        return $this->associations;
    }
}
