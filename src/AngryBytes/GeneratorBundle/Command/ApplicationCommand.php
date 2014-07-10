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

use Abc\AbcBundle\Application\Collection as Applications;
use Abc\AbcBundle\Project\Directories as DirectoryLayout;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\Console\Question\Question;

use AngryBytes\GeneratorBundle\Structure\Application as Structure;

use Naneau\FileGen\Console\Helper\ParameterHelper;
use Naneau\FileGen\Generator;

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
     * The directory layout
     *
     * @var DirectoryLayout
     **/
    private $directoryLayout;

    /**
     * Applications
     *
     * @var Applications
     **/
    private $applications;

    /**
     * Configure the command
     *
     * @return void
     **/
    protected function configure()
    {
        $this
            ->setName('generator:application')
            ->setDescription('Generate a new application')
            ->addOption(
                'name',
                null,
                InputOption::VALUE_REQUIRED,
                'Name of the application (also used as the directory under which it is generated)'
            );
    }

    /**
     * Execute the command
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     **/
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Figure out name
        $name = $input->getOption('name');
        if (empty($name)) {
            // Name question
            $question = new Question('Please enter the location for the application: ');

            // Ask for the name
            $name = $this->getHelper('question')->ask($input, $output, $question);
        }

        // Create the structure
        $structure = $this->getStructure()->createForName($name);

        $parameters = array_merge(
            array('name' => $name),
            $this->getParameterHelper()->askParameters($structure, $input, $output)
        );

        $generator = new Generator(
            $this->getDirectoryLayout()->getRoot() . '/applications',
            $parameters
        );

        $generator->generate($structure);
    }

    /**
     * Get the directory layout
     *
     * @return DirectoryLayout
     */
    public function getDirectoryLayout()
    {
        return $this->directoryLayout;
    }

    /**
     * Set the directory layout
     *
     * @param  DirectoryLayout    $directoryLayout
     * @return ApplicationCommand
     */
    public function setDirectoryLayout(DirectoryLayout $directoryLayout)
    {
        $this->directoryLayout = $directoryLayout;

        return $this;
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
     * @param  Structure          $structure
     * @return ApplicationCommand
     */
    public function setStructure(Structure $structure)
    {
        $this->structure = $structure;

        return $this;
    }

    /**
     * Get the application set
     *
     * @return Applications
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Set the application set
     *
     * @param  Applications       $applications
     * @return ApplicationCommand
     */
    public function setApplications(Applications $applications)
    {
        $this->applications = $applications;

        return $this;
    }

    /**
     * Get the filegen parameter helper
     *
     * @return ParameterHelper
     **/
    private function getParameterHelper()
    {
        return $this->getHelper('filegenParameters');
    }

}
