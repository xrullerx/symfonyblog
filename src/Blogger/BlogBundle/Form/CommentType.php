<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// Описание формы комментариев.
class CommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder->add('user', null, array('label' => 'Имя:'));
            $builder->add('comment', null, array('label' => 'Сообщение:'));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Blogger\BlogBundle\Entity\Comment'));
    }

    public function getBlockPrefix()
    {
        return 'blogger_blogbundle_commenttype';
    }
}
