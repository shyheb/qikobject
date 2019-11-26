<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class ObjettrouverType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description')->add('date',DateType::class, array(
            // renders it as a single text box
            'widget' => 'single_text',))->add('gouvernorat', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'select some colors',
            'choices' => array(''=>'','Ariana' => 'Ariana', 'Beja' => 'Beja', 'Ben arous' => 'Ben arous','Bizert' => 'Bizert' , 'Gabes' => 'Gabes' , 'Jendouba' => 'Jendouba' , 'Kairaouan' => 'Kairaouan' , 'Kasserine' => 'Kasserine' , 'Kelibia' => 'Kelibia' , 'Kef' => 'Kef' , 'Mahdia' => 'Mahdia' , 'Manouba' => 'Manouba' , 'Medenine' => 'Medenine' , 'Monastir' => 'Monastir' , 'Nabeul' => 'Nabeul' , 'Sfax' => 'Sfax' , 'Sidi bouzid' => 'Sidi bouzid' , 'Siliana' => 'Siliana' , 'Sousse' => 'Sousse' , 'Tataouine' => 'Tataouine' , 'Tozeur' => 'Tozeur' , 'Tunis' => 'Tunis' , 'Zaghouan' => 'Zaghouan'),
        ))->add('cond')->add('images',\AppBundle\Form\MediaType::class,array('required' => true))->add('image2',\AppBundle\Form\MediaType::class,array('required' => false))->add('image3',\AppBundle\Form\MediaType::class,array('required' => false));
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Objet'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_objet';
    }


}
