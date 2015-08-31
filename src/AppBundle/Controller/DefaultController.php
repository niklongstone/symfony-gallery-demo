<?php

namespace AppBundle\Controller;

use Puli\Discovery\KeyValueStoreDiscovery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class DefaultController
{
    /**
     * @var EngineInterface
     */
    private $template;

    /**
     * @var KeyValueStoreDiscovery
     */
    private $puliDiscovery;


    /**
     * @param EngineInterface        $template
     * @param KeyValueStoreDiscovery $puliDiscovery
     */
    public function __construct(EngineInterface $template, KeyValueStoreDiscovery $puliDiscovery)
    {
        $this->template = $template;
        $this->puliDiscovery = $puliDiscovery;
    }

    /**
     * Creates the homepage.
     *
     * @return Response
     */
    public function indexAction()
    {
        $images = $this->getImages();

        return new Response(
            $this->template->render('/myapp/views/Default/index.html.twig',
                array('images' => $images)
            )
        );
    }

    /**
     * Gets a list of images from the given folder.
     *
     * @return array.
     */
    private function getImages()
    {
        $images = array();
        $bindings = $this->puliDiscovery->findByType('mygallery/image');
        foreach ($bindings as $binding) {
            foreach ($binding->getResources() as $resource) {
                $images[] = $resource->getName();
            }
        }

        return $images;
    }
}
