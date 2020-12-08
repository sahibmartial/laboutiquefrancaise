<?php
namespace App\Form;
use App\Entity\Category;
use App\Classe\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/**
 *cette classe gere le formulaire de filtre du user
 */

class SearchType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('string', TextType::class ,
			['label'        => 'rechercher',
				'required'     => false,
				'attr'         =>
				['placeholder' => 'votre recherche ....',
			'class'=>'form-control-sm']
			])
      ->add('categories',EntityType::class,[
				'label'=>false,
				'required'=>false,
				'class'=>Category::class,
				'multiple'=>true,
				'expanded'=>true
			])
			->add('submit',SubmitType::class,[
				'label'=>'Filtrer',
				'attr'=>[
					'class'=>'btn-block btn-primary'
				]
			])
			;

	}

	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults([
				'data_class'      => Search::class ,
				'method'          => 'GET',
				'crsf_protection' => false,
			]);
	}

	/**
	 * gere l'url a copier pas les users
	 */

	public function getBlockPrefix() {
		return '';
	}

}
