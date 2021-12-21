<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Country;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class IssuesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'constraints' => new NotBlank(['message' => 'Please enter your name.'])
            ])
            ->add('country', EntityType::class, [
                'constraints' => new NotBlank(['message' => 'Please choose a country.']),
                'placeholder' => 'Choisissez un pays',
                'class' => Country::class,
                'choice_label' => function(Country $country){
                    return $country->getName();
                },
                'query_builder' => function(CountryRepository $countryRepository) {
                    return $countryRepository->createQueryBuilder('country')->orderBy('country.name','ASC');
                }
            ])
            /*->add('city', EntityType::class, [
                'constraints' => new NotBlank(['message' => 'Please choose a city.']),
                'placeholder' => 'Choisissez une ville',
                'class' => City::class,
                //'disabled' => true,
                'choice_label' => 'name',
                'query_builder' => function(CityRepository $cityRepository) {
                    return $cityRepository->createQueryBuilder('city')->orderBy('city.name','ASC');
                }
            ]) */
            ->add('city', ChoiceType::class, [
                'placeholder' => 'Ville (Choisir un pays)',
                'required' => false,
                'disabled' => true
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'constraints' => [
                    new NotBlank(['message' => 'Please enter your message.']),
                    new Length(['min' => 5, 'minMessage' => 'The message should be with {{ limit }} characters minimum'])
                ]
            ])
            ->add('availableAt', DateTimeType::class, [
                'label' => 'Date de disponibilité'
            ])
            ->add('envoyer', SubmitType::class)
        ;

        $formModifier = function(FormInterface $form, Country $country = null) {
            $cities = null === $country ? [] : $country->getCities();

            $form->add('city', EntityType::class, [
                'label' => 'Ville',
                'class' => City::class,
                'choices' => $cities,
                'choice_label' => 'name',
                'placeholder' => 'Ville',
                'required' => false
            ]);
        };

        $builder->get('country')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event) use ($formModifier){
                $country = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $country);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
