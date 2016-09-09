Description
===========

The description component allows you to obtain standardized descriptions for
object instances. It is a metadata system for object instances as opposed to
object classes and allows descriptions to be built up from disparate sources.

Workflow
--------

- Description is requested for a given object instance.
- Description factory creates a new description and passes it to description
  *enhancers*.
- Description enhancers add descriptors (e.g. title, edit URL, etc)

Example
-------

For example, if you have a `App\Entity\Post` entity and a
`App\Document\Page` document, and lets say you have an enhancer for your admin
system, which is has a metadata system which can provide the needed
information and is aware of these two objects.

.. code-block:: php

    <?php
 
    $post = // get the post entity
    $page = // get the page document

    $descriptionFactory = new DescriptionFactory([
        new MyAdminEnhancer($myAdminMetadataFactory);
    ]);

    $description = $descriptionFactory->getDescriptionFor($post);
    echo $description->get('title')->getValue(); // e.g. "My Blog Post"
    echo get_class($description->get('title')) // Psi\Component\Description\Descriptor\ScalarDesciptor

    $description = $descriptionFactory->getDescriptionFor($page);
    echo $description->get('title')->getValue(); // e.g. "About Us"

The component includes a number of descriptors by default, other descriptors
include a `description`, `class.fqn`, URLs for viewing, updating or removing
the instance, URLs for thumbnail images, etc.

Schema Validation
-----------------

In order that all systems use the `title` field in the same way, with the same
descriptor object, a schema system is provided.

When given to the factory the ``Schema`` ensures that only valid desciptor
names and value objects are set, and that when trying to retrieve an invalid
descriptor, useful exception messages are provided.

.. code-block:: php

    <?php

    use Psi\Component\Description\DescriptionFactory;
    use Psi\Component\Description\Schema\Schema;
    use Psi\Component\Description\Schema\StandardExtension;

    $schema = new Schema();
    $scehma->register(new StandardExtension());

    $descriptionFactory = new DescriptionFactory([
        new MyAdminEnhancer($myAdminMetadataFactory);
    ], $schema);

    $description = $descriptionFactory->getDescriptionFor($page);
    $description->get('invalid key'); // throws exception

.. note::

    Schema validation is an unnecessary overhead in production and it can be
    disabled by simply not passing the schema to the factory.
