<?php

namespace spec\Pim\Bundle\CatalogBundle\EventSubscriber;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use PhpSpec\ObjectBehavior;
use Pim\Bundle\CatalogBundle\EventSubscriber\LoadProductValuesSubscriber;
use Pim\Component\Catalog\Factory\ProductValueCollectionFactoryInterface;
use Pim\Component\Catalog\Model\ProductInterface;
use Pim\Component\Catalog\Model\ProductValueCollectionInterface;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadProductValuesSubscriberSpec extends ObjectBehavior
{
    function let(
        ContainerInterface $container,
        ProductValueCollectionFactoryInterface $valueCollectionFactory
    ) {
        $this->beConstructedWith($container);

        $container->get('pim_catalog.factory.product_value_collection')->willReturn($valueCollectionFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LoadProductValuesSubscriber::class);
    }

    function it_subscribes_to_the_postLoad_event()
    {
        $this->getSubscribedEvents()->shouldReturn(['postLoad']);
    }

    function it_loads_values_of_a_product(
        $valueCollectionFactory,
        LifecycleEventArgs $event,
        ProductInterface $product,
        ProductValueCollectionInterface $values
    ) {
        $event->getObject()->willReturn($product);
        $product->getIdentifier()->willReturn('foo');

        $product->getRawValues()->willReturn(['an attribute' => 'a value', 'another attribute' => 'another value']);

        $valueCollectionFactory
            ->createFromStorageFormat(['an attribute' => 'a value', 'another attribute' => 'another value'])
            ->willReturn($values);

        $product->setValues($values)->shouldBeCalled();

        $this->postLoad($event);
    }

    function it_works_only_with_products($container, LifecycleEventArgs $event, \stdClass $object)
    {
        $event->getObject()->willReturn($object);
        $container->get(Argument::any())->shouldNotBeCalled();

        $this->postLoad($event);
    }
}
