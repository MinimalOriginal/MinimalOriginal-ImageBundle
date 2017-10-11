<?php

namespace MinimalOriginal\ImageBundle;

use MinimalOriginal\CoreBundle\Modules\AbstractManageableModule;

use MinimalOriginal\ImageBundle\Service\Uploader;

use MinimalOriginal\ImageBundle\Form\ImageType;
use MinimalOriginal\ImageBundle\Entity\Image;

class MinimalModule extends AbstractManageableModule{

  private $uploader;

  /**
   *
   * @param Uploader $uploader
   *
  **/
  public function setUploader(Uploader $uploader){
    $this->uploader = $uploader;
  }

  /**
   * {@inheritdoc}
   */
  public function init(){
    $this->informations->set('name', 'image');
    $this->informations->set('title', 'Images');
    $this->informations->set('description', "Créez ou modifiez les images de votre site.");
    $this->informations->set('icon', "ion-ios-camera-outline");
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityClass(){
    return Image::class;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormTypeClass(){
    return ImageType::class;
  }

  public function createModel(){
    return new Image();
  }

  public function updateModel($model, $andFlush = true){
    if ($model->getAttachment()) {
        $image_data = $this->uploader->upload($model->getAttachment());
        $model->setDirectory($image_data['dir']);
        $model->setFilename($image_data['filename']);
    }
    $this->em->persist($model);
    if ($andFlush) {
        $this->em->flush();
    }
  }

  public function removeModel($model, $andFlush = true){
    $this->em->remove($model);
    if ($andFlush) {
        $this->em->flush();
    }
  }

}
