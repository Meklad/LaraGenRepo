<?php

namespace Owllog\RepoGenerator;

use Illuminate\Console\Command;

class RepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {repository} {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command create new repository skeleton';

    /**
     * The console command type.
     *
     * @var string
     */
    protected $type = "Repository";

    /**
     * Static Paths:
     */
    private $newRepositoryDir;
    private $interfaceStubFile;
    private $repositoryIntrfaceDirPath;
    private $stubContent;
    private $repositoryInterfacePath;
    private $stubClassContent;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Initialize Static Attributes
        $this->newRepositoryDir = app_path() . '/Repository/';
        $this->interfaceStubFile = $this->getStubInterface();
        $this->repositoryIntrfaceDirPath = app_path() . '/Repository/BaseRepository/';
        $this->stubContent = file_get_contents($this->interfaceStubFile);
        $this->repositoryInterfacePath = $this->repositoryIntrfaceDirPath . 'RepositoryInterface.php';
        $this->stubClassContent = file_get_contents($this->getRepositoryClass());
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $repositoryClassName = $this->argument('repository');
        $repositoryClassFileName = $repositoryClassName . '.php';
        $repositoryClassPath = $this->newRepositoryDir . $repositoryClassName;
        $modelName = $this->argument('model');

        if (!is_dir($this->newRepositoryDir)) {

            mkdir($this->newRepositoryDir);
            mkdir($this->repositoryIntrfaceDirPath);
            $this->getRepoistoryInterface();
            $this->createNewRepository($repositoryClassName, $modelName);
            $this->info('Repository ' . $repositoryClassName . 'wa Successfully Created.');

        } else {
            if (!is_dir($this->repositoryIntrfaceDirPath)) {

                mkdir($this->repositoryIntrfaceDirPath);
                $this->getRepoistoryInterface();

            } else {
                if (!file_exists($this->repositoryInterfacePath)) {

                    $this->info($this->repositoryInterfacePath);
                    $this->getRepoistoryInterface();

                } else {

                    $this->warn('Warning:');
                    $this->info('BaseRepository Is Exists.');
                }
            }

            if (!file_exists($repositoryClassPath . '.php')) {

                $this->createNewRepository($repositoryClassName, $modelName);
                $this->info('Repository ' . $repositoryClassName . 'wa Successfully Created.');

            } else {

                $this->error('Error:');
                $this->info('Repository ' . $repositoryClassName . ' already exists');

            }
        }
    }

    /**
     * This method return full path of source file of the interface.
     *
     * @return string
     */
    public function getStubInterface()
    {
        $path = __DIR__ . '/stub/repositoryInterface.stub';
        return $path;
    }

    /**
     * This method return full path of source file of repository class.
     *
     * @return string
     */
    public function getRepositoryClass()
    {
        $path = __DIR__ . '/stub/repositoryClass.stub';
        return $path;
    }

    /**
     * This method create new repository class.
     *
     * @param  string $repositoryClassName This variable represent the name the repository class name.
     * @param  string $modelName           This variable represent the name of model name.
     * @return void
     */
    public function createNewRepository($repositoryClassName, $modelName)
    {
        $pattern = ["/DummyRepository/", "/DummyModel/"];
        $replacement = [$repositoryClassName, $modelName];

        $contentAfterChanges = preg_replace($pattern, $replacement, $this->stubClassContent);

        return file_put_contents($this->newRepositoryDir . $this->argument('repository') . '.php', $contentAfterChanges);
    }

    /**
     * This method create the base repository interface.
     *
     * @return void
     */
    public function getRepoistoryInterface()
    {
        return file_put_contents($this->repositoryIntrfaceDirPath . 'BaseRepository.php', $this->stubContent);
    }
}
