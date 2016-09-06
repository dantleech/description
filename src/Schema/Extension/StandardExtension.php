<?php

namespace Psi\Component\Description\Schema;

use Psi\Component\Description\Schema\ExtensionInterface;
use Psi\Component\Description\Schema\Builder;

class StandardExtension implements ExtensionInterface
{
    public function buildSchema(Builder $builder)
    {
        $builder->add('class.fqn', ScalarDesciptor::class, 'Resolved class FQN');
        $builder->add('title', ScalarDesciptor::class, 'Title to use for the object instance');
        $builder->add('description', ScalarDesciptor::class, 'Description of the object');

        $builder->add('user_link.create', LinkDesciptor::class, 'Link to where the object can be created');
        $builder->add('user_link.show', LinkDesciptor::class, 'Link to where the object can be shown');
        $builder->add('user_link.update', LinkDesciptor::class, 'Link to where the object can be updated');
        $builder->add('user_link.delete', LinkDesciptor::class, 'Link to where the object can be deleted');
        $builder->add('user_link.create_child', LinkCollectionDescriptor::class, 'URLs to where children can be created. Keys should indicate the type of child to be created');

        $builder->add('api_link.create', ScalarDesciptor::class, 'API Link to where the object can be created');
        $builder->add('api_link.show', ScalarDesciptor::class, 'API Link to where the object can be shown');
        $builder->add('api_link.update', ScalarDesciptor::class, 'API Link to where the object can be updated');
        $builder->add('api_link.delete', ScalarDesciptor::class, 'API Link to where the object can be deleted');

        $builder->add('hierarchy.children_allow', BooleanDescriptor::class, 
    }

    public function getName()
    {
        return 'std';
    }
}
