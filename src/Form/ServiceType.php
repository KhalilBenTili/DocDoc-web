<?php

namespace App\Form;

use App\Entity\CategorieService;
use App\Entity\FourniseurService;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('categorie',EntityType::class,[
                'class'=>CategorieService::class,
                'choice_label'=>'libelle',
                'choice_value'=>'id',
                'placeholder'=>'selectionnez le catégorie du service'

               ]);
        $formModifier = function (FormInterface $form, CategorieService $cat = null) {
            $fr = null === $cat ? [] : $cat->getFourniseurServices();

            $form->add('fournisseurs', EntityType::class, [
                'class' => FourniseurService::class,
                'placeholder' => '',
                'choices' => $fr,
                'multiple'=>true
            ]);
        };
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();

                $formModifier($event->getForm(), $data->getCategorie());
            }
        );
        $builder->get('categorie')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {

                $categorie = $event->getForm()->getData();

                $formModifier($event->getForm()->getParent(), $categorie);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
