<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
   $builder
    ->add('name', TextType::class, [
        'constraints' => [
            new Assert\NotBlank([
                'message' => 'Nazwa nie może być pusta.'
            ]),
            new Assert\Length([
                'min' => 3,
                'minMessage' => 'Nazwa musi mieć co najmniej 3 znaki.'
            ])
        ]
    ])
    ->add('description', TextareaType::class, [
        'constraints' => [
            new Assert\NotBlank([
                'message' => 'Opis nie może być pusty.'
            ]),
            new Assert\Length([
                'min' => 10,
                'minMessage' => 'Opis musi mieć co najmniej 10 znaków.'
            ])
        ]
    ])
    ->add('ean', TextType::class, [ // EAN is typically a string, not an integer
        'constraints' => [
            new Assert\NotBlank([
                'message' => 'EAN nie może być pusty.'
            ]),
            new Assert\Type([
                'type' => 'string',
                'message' => 'EAN musi być tekstem.'
            ]),
            new Assert\Length([
                'min' => 8,
                'max' => 13,
                'minMessage' => 'EAN musi mieć co najmniej {{ limit }} cyfr.',
                'maxMessage' => 'EAN nie może mieć więcej niż {{ limit }} cyfr.'
            ])
        ]
    ])
    ->add('main_image', TextType::class, [
        'constraints' => [
            new Assert\NotBlank([
                'message' => 'Adres obrazka nie może być pusty.'
            ]),
            new Assert\Url([
                'message' => 'Podaj prawidłowy adres URL obrazka.'
            ])
        ]
    ])
    ->add('price', IntegerType::class, [
        'constraints' => [
            new Assert\NotBlank([
                'message' => 'Cena jest wymagana.'
            ]),
            new Assert\Positive([
                'message' => 'Cena musi być liczbą dodatnią.'
            ])
        ]
    ])
    ->add('stock', IntegerType::class, [
        'constraints' => [
            new Assert\NotBlank([
                'message' => 'Stan magazynowy jest wymagany.'
            ]),
            new Assert\PositiveOrZero([
                'message' => 'Stan magazynowy nie może być ujemny.'
            ])
        ]
    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
