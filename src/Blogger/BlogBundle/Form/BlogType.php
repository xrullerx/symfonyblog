<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// Описание формы блога.
class BlogType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', null, array('label' => 'Заголовок:'))
                ->add('author', null, array('label' => 'Автор:'))
                ->add('blog', null, array('label' => 'Блог:'))
                ->add('image', null, array('label' => 'Рисунок:'))
                ->add('tags', null, array('label' => 'Теги:'))
                ->add('created', null, array('label' => 'Дата создания:'))
                ->add('updated', null, array('label' => 'Дата обновления:')) ;      
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Blogger\BlogBundle\Entity\Blog'));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'blog';
    }


}
