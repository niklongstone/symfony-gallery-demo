<?php

namespace AppBundle\Controller;

use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class DefaultController
{
    /**
     * @var EngineInterface
     */
    private $template;

    /**
     * @var string
     */
    private $imagesFolder;

    /**
     * @var string
     */
    private $imagesBaseURL;

    /**
     * @param EngineInterface $template
     * @param                 $imagesFolder
     * @param                 $imagesBaseURL
     */
    public function __construct(EngineInterface $template, $imagesFolder, $imagesBaseURL)
    {
        $this->template = $template;
        $this->imagesFolder = $imagesFolder;
        $this->imagesBaseURL = $imagesBaseURL;
    }

    /**
     * Creates the homepage.
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $images = $this->getImages($this->imagesFolder);

        return new Response(
            $this->template->render('AppBundle:Default:index.html.twig',
                array('images' => $images)
            )
        );
    }

    /**
     * Gets a list of images from the given folder.
     *
     * @param $imagesFolder
     *
     * @return array
     */
    private function getImages($imagesFolder)
    {
        $images = array();
        $finder = new Finder();
        $finder->files()->sortByModifiedTime();
        foreach ($finder->in($imagesFolder) as $file) {
            $images[] = $file->getFilename();
        }

        return $images;
    }
}
