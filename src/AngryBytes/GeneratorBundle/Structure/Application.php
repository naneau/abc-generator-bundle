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

/**
 * Application
 *
 * Structure for an application
 *
 * @category        AngryBytes
 * @package         GeneratorBundle
 * @subpackage      Structure
 */
class Application extends Structure
{
    /**
     * Constructor
     *
     * @param string $root
     * @return void
     **/
    public function __construct($root)
    {
        parent::__construct($root);

        $this
            // Root
            ->directory($name)

            // Resources/config
            ->directory($name . '/application')
            ->directory($name . '/application/Resources')
            ->directory($name . '/application/Resources/config')
            ->file($name . '/application/Resources/config/application.xml', new TwigContents(
                __DIR__ . '/../Resources/templates/application/application.xml.twig'
            ))

            // Public webroot
            ->directory($name . '/public')
            ->file($name . '/public/index.php', new TwigContents(
                __DIR__ . '/../Resources/templates/application/front-controller.php.twig'
            ));

        // Parameters
        $this
            ->param('name', 'Name of the application');
    }
}
