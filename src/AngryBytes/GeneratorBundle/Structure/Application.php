<?php
/**
 * Application.php
 *
 * @category        AngryBytes
 * @package         GeneratorBundle
 * @subpackage      Structure
 */

namespace AngryBytes\GeneratorBundle\Structure;

use Naneau\FileGen\Structure;
use Naneau\FileGen\File\Contents\Twig as TwigContents;

use \Twig_Environment as Twig;

/**
 * Application
 *
 * Generates the structure for an application
 *
 * @category        AngryBytes
 * @package         GeneratorBundle
 * @subpackage      Structure
 */
class Application
{
    /**
     * The twig template engine
     *
     * @var Application
     **/
    private $twig;

    /**
     * Get the twig template engine
     *
     * @return Twig
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * Set the twig template engine
     *
     * @param  Twig        $twig
     * @return Application
     */
    public function setTwig(Twig $twig)
    {
        $this->twig = $twig;

        return $this;
    }

    /**
     * Create a structure for an application
     *
     * @return Structure
     **/
    public function createForName($name)
    {
        $structure = new Structure;
        $structure
            // Root
            ->directory($name)

            // Resources/config
            ->directory($name . '/application')
            ->directory($name . '/application/Resources')
            ->directory($name . '/application/Resources/config')
            ->file(
                $name . '/application/Resources/config/application.xml',
                $this->createTwigContents('application.xml.twig')
            )
            ->file(
                $name . '/application/Resources/config/menu.yml',
                $this->createTwigContents('menu.yml.twig')
            )
            ->file(
                $name . '/application/Resources/config/routing.yml',
                $this->createTwigContents('routing.yml.twig')
            )

            // Public webroot
            ->directory($name . '/public')
            ->file(
                $name . '/public/index.php',
                $this->createTwigContents('front-controller.php.twig')
            )

            // The console
            ->file(
                $name . '/console',
                $this->createTwigContents('console.twig'),
                0770
            );

        // Parameters
        $structure
            ->parameter('id', 'Application id');

        return $structure;
    }

    /**
     * Create twig file contents
     *
     * @return TwigContents
     **/
    private function createTwigContents($name)
    {
        $fullPath = sprintf(
            __DIR__ . '/../Resources/templates/%s',
            $name
        );

        return new TwigContents(
            $this->getTwig()->loadTemplate($fullPath)
        );
    }

}
