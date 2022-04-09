<?php

namespace App\Form;

use App\Entity\Event;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;


class EventType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
      $builder
          ->add('name', TextType::class, [
              'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px', 'placeholder' => 'Event Name']
          ])
          ->add('date', DateTimeType::class, [
            'attr' => ['style' => 'margin-bottom:15px','placeholder' => 'Event Date']
          ])
          ->add('description', TextType::class, [
              'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px','placeholder' => 'Description']
          ])
          ->add('type', ChoiceType::class, [
              'choices' => ['Music' => 'Music', 'Sport' => 'Sport', 'Movie' => 'Movie', 'Theater' => 'Theater'],
              'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px','placeholder' => 'Type of Event']
          ])
                //create an Object as $product = new Product;
                //build the form using the file type input
                ->add('picture', FileType::class, [
                  'label' => 'Upload Picture',
                //unmapped means that is not associated to any entity property
                  'mapped' => false,
                //not mandatory to have a file
                  'required' => false,

                //in the associated entity, so you can use the PHP constraint classes as validators
                  'constraints' => [
                new File([
                    'maxSize' => '5242880',
                    'mimeTypes' => [
                        'image/png',
                        'image/jpeg',
                        'image/jpg',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid image file',
      ])
  ],
])
          ->add('capacity', IntegerType::class, [
            'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px','placeholder' => 'Capacity']
          ])
          ->add('contactemail', EmailType::class, [
            'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px', 'placeholder' => 'Contact Email']
          ])
          ->add('contactphone', IntegerType::class, [
            'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px','placeholder' => 'Contact Phone']
          ])
          ->add('address', TextType::class, [
            'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px','placeholder' => 'Address of the Event']
          ])
          ->add('url', TextType::class, [
            'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px','placeholder' => 'Url address']
          ])

          ->add('save', SubmitType::class, [
              'label' => 'Create Event',
              'attr' => ['class' => 'btn-info', 'style' => 'margin-bottom:25px','style' => 'padding:15px']
          ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
      $resolver->setDefaults([
          'data_class' => Event::class,
      ]);
  }
}