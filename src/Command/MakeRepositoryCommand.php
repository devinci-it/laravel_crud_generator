<?php

namespace Devinci\LaravelUtils\Command;

use Illuminate\Console\GeneratorCommand;

class MakeRepositoryCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {model} {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return base_path('stubs/repository.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Repositories';
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $stub = $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);

        $modelName = str_replace('Repository', '', $this->argument('name'));
        $stub = str_replace('DummyModel', $modelName, $stub);

        // Generate the testRepository method
        $testRepositoryMethod = $this->generateTestRepositoryMethod($modelName);

        // Replace the DummyTestRepositoryMethod placeholder with the testRepository method
        $stub = str_replace('DummyTestRepositoryMethod', $testRepositoryMethod, $stub);

        return $stub;
    }

    protected function generateTestRepositoryMethod($modelName)
    {
        // Load the testRepository method template
        $template = $this->files->get(base_path('stubs/test_repository_method.stub'));

        // Get the fillable properties of the model
        $modelClass = "App\\Models\\$modelName";
        $model = new $modelClass;
        $fillableProperties = $model->getFillable();

        // Generate the boilerplate code for the new and updated model instances
        $newModelData = $this->generateModelDataBoilerplate($fillableProperties);
        $updatedModelData = $this->generateModelDataBoilerplate($fillableProperties);

        // Replace placeholders with actual values
        $template = str_replace('{{modelName}}', $modelName, $template);
        $template = str_replace('{{newModelData}}', $newModelData, $template);
        $template = str_replace('{{updatedModelData}}', $updatedModelData, $template);

        return $template;
    }

    protected function generateModelDataBoilerplate($fillableProperties)
    {
        $boilerplate = [];

        foreach ($fillableProperties as $property) {
            $boilerplate[] = "'$property' => 'value', // Replace 'value' with the actual value for $property";
        }

        return implode("\n", $boilerplate);
    }

    protected function generateTestRepositoryMethodAndInsert($modelName, $repositoryName)
    {
        // Load the template for the testRepository method
        $template = $this->generateTestRepositoryMethod($modelName);

        // Determine the namespace of the repository
        $namespace = rtrim($this->rootNamespace(), '\\') . '\Repositories';

        // Generate the fully qualified class name of the repository
        $fullyQualifiedRepositoryName = $namespace . '\\' . $repositoryName;

        // Get the path to the generated repository file
        $repositoryPath = $this->getPath($this->qualifyClass($repositoryName));

        // Read the contents of the repository file
        $contents = $this->files->get($repositoryPath);

        // Find the position where we want to insert the testRepository method (right before the closing } of the class)
        $methodPosition = strrpos($contents, '}');

        // Insert the testRepository method into the repository file
        $contents = substr_replace($contents, $template, $methodPosition, 0);

        // Write the updated contents back to the repository file
        $this->files->put($repositoryPath, $contents);
    }

    public function handle()
    {
        $modelName = $this->argument('model');

        // Check if the model exists
        $modelClass = "App\\Models\\$modelName";
        if (!class_exists($modelClass)) {
            $this->error("Model $modelName does not exist!");
            return false;
        }

        // Generate the repository name
        $repositoryName = $modelName . 'Repository';
        $this->input->setArgument('name', $repositoryName);

        // Check if the repository already exists
        $repositoryPath = $this->getPath($this->qualifyClass($repositoryName));
        if ($this->alreadyExists($this->getNameInput()) && !$this->confirm("The [{$repositoryName}] repository already exists. Do you want to replace it?")) {
            $this->info('Command Cancelled!');
            return false;
        }
        $this->files->delete($repositoryPath);

        // Call the parent handle method
        parent::handle();

        // Generate and insert the testRepository method into the repository file
        $this->generateTestRepositoryMethodAndInsert($modelName, $repositoryName);

        return true;
    }
}
