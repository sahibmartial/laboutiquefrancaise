<?php
namespace App\EventSubscriber;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Finder\Finder;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Cette classe repond a un event sur image pour le stockage
 */
class EasyAdminSubscriber implements EventSubscriberInterface
{
	
	private $appKernel;
	private $entityManager;

	public function __construct(KerneLInterface $appKernel, EntityManagerInterface $entityManager)
	{
        $this->appKernel=$appKernel;//infos techinique de mon application
        $this->entityManager=$entityManager;
	}
	//ecoute sur fields illustration lors du save entity et 

	 public static function getSubscribedEvents()
    {
        return [
           BeforeEntityPersistedEvent::class =>['setIllustration'],
           BeforeEntityUpdatedEvent::class =>['updateIllustration'],
        ];
    } 


    function uploadIllustration($event)
    {
        $entity=$event->getEntityInstance();
         //$tmp_name=$_FILES['Product']['tmp_name']['illustration']['file'];//obtention chelin temporaire
        $tmpname=$_FILES['Product']['tmp_name']['illustration']['file'];

        $tmp_name=$entity->getIllustration();//nom du fichier
        
        
        $filename =uniqid();//genere id uniq de mon image

    	$extension= pathinfo($entity->getIllustration(), PATHINFO_EXTENSION);//save extension de mon image

       //dd($entity);
      
       //dump($this->appKernel);
    	$project_dir=$this->appKernel->getProjectDir();//chemin complet du projet
      

         // $tmp_name='/home/laravel/symfony/laboutiquefrancaise/public/uploads';

        // move_uploaded_file($_FILES['Product']['tmp_name']['illustration']['file'], $project_dir."/public/uploads/".$filename.".".$extension);

    	$entity->setIllustration($entity->getIllustration());  


    }



    public function updateIllustration(BeforeEntityUpdatedEvent $event)
    {
        if(($event->getEntityInstance() instanceof Product)){
        	return;
        }
        
        if ($_FILES['Product']['tmp_name']['illustration']['file'] != '') {
           $this->uploadIllustration($event);
        }

       
    }


    public function setIllustration(BeforeEntityPersistedEvent $event)
    {
    	 if(($event->getEntityInstance() instanceof Product)){
        	return;
        }

        $this->uploadIllustration($event);
        

      
    	
    }
}