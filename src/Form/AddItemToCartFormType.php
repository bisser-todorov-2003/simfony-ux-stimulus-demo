<?php

namespace App\Form;

use App\Entity\Color;
use http\Exception\InvalidArgumentException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddItemToCartFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $product = $options['product'];
        if (!$product) {
            throw new InvalidArgumentException('The product option must be set.');
        }

        $builder->add('quantity', IntegerType::class, [
            'label' => 'Quantity',
        ]);
        if (!empty($product->getColors()))
        {
            $builder->add('colors', ChoiceType::class, [

                'choices' => $product->getColors(),
                'placeholder' => 'Select a color',
                'choice_label' => 'name',
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setRequired(['product']);
    }
}