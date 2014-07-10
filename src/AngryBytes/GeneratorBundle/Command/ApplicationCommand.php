<?php
/**
 * ApplicationCommand.php
 *
 * @category        AngryBytes
 * @package         GeneratorBundle
 * @subpackage      Command
 * @copyright       Copyright (c) 2014 Angry Bytes BV (http://www.angrybytes.com)
 */

namespace AngryBytes\GeneratorBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Naneau\FileGen\Structure;

/**
 * ApplicationCommand
 *
 * Generates a new application
 *
 * @category        AngryBytes
 * @package         GeneratorBundle
 * @subpackage      Command
 */
class ApplicationCommand extends Command
{
    /**
     * The structure
     *
     * @var Structure
     **/
    private $structure;

    /**
     * Configure the command
     *
     * @return void
     **/
    protected function configure()
    {
        $this
            ->setName('generator:application')
            ->setDescription('Generate a new application');
    }

    /**
     * Execute the command
     *
     * @return void
     **/
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Parameter helper
        $helper = $this->getHelper('filegenParameters');
    }

    /**
     * Get the structure to generate
     *
     * @return Structure
     */
    public function getStructure()
    {
        return $this->structure;
    }

    /**
     * Set the structure to generate
     *
     * @param Structure $structure
     * @return ApplicationCommand
     */
    public function setStructure(Structure $structure)
    {
        $this->structure = $structure;

        return $this;
    }

}
