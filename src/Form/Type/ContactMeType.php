<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactMeType extends AbstractType
{
    // 2. Declare a locally accesible variable
    public $translator;

    // 3. Autowire the translator interface and update the local value with the injected one
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label'=> 'form_labels.contact_me.1',
                'required'   => false])
            
            ->add('lastName', TextType::class, [
                'label'=> 'form_labels.contact_me.2',
                'required'   => true,
                'constraints' => [
                    new Assert\NotBlank(['message'=> $this->translator->trans('form_errors.contact_me.1', 
                    ['field_label'=>  $this->translator->trans('form_labels.contact_me.2')]) ])
                ],

                ])
            
            ->add('information', EmailType::class, [
                    'label'=> 'form_labels.contact_me.3',
                    'required'   => true,
                    'constraints' => [
                        new Assert\NotBlank(['message'=> $this->translator->trans('form_errors.contact_me.1', 
                        ['field_label'=>  $this->translator->trans('form_labels.contact_me.3')]) ]),
                        new Assert\Email(['message'=> $this->translator->trans('form_errors.contact_me.2') ])
                    ]])

            ->add('email', TextType::class, [
                'label'=> 'form_labels.contact_me.3',
                'required'   => true,
                'constraints' => [
                    new Assert\Blank(['message'=> $this->translator->trans('form_errors.contact_me.3') ])
                ]])
            
            ->add('subject', TextType::class, [
                'label'=> 'form_labels.contact_me.4',
                'required'   => true,
                'constraints' => [
                    new Assert\NotBlank(['message'=> $this->translator->trans('form_errors.contact_me.1', 
                    ['field_label'=>  $this->translator->trans('form_labels.contact_me.4')]) ])
                ]])
    
            ->add('content', TextareaType::class, [
                'label'=> 'form_labels.contact_me.5',
                'required'   => true,
                'attr' => ['placeholder' => $this->translator->trans('form_placeholders.contact_me.1')],
                'constraints' => [
                    new Assert\NotBlank(['message'=> $this->translator->trans('form_errors.contact_me.1', 
                    ['field_label'=>  $this->translator->trans('form_labels.contact_me.5')]) ])
                ]])

            ->add('send', SubmitType::class,[
                'label'=> 'form_labels.contact_me.6',
            ]
            )
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'error_bubbling' => true,
        ]);
    }
} 



