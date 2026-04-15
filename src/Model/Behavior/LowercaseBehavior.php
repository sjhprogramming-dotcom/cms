<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;

use Cake\Event\EventInterface;
use Cake\Datasource\EntityInterface;
use ArrayObject;

/**
 * Lowercase behavior
 */
class LowercaseBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected array $_defaultConfig =   [ 
        
        'fields' => []
    
    ,];


    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options): void 
    {
        foreach ($this->getConfig('fields') as $field) {
            if ($entity->isDirty($field)) {
                $value = $entity->get($field);
                if (is_string($value) && $value !== '') {
                    $entity->set($field, mb_strtolower($value));
                }
            }
        }
    }
}
