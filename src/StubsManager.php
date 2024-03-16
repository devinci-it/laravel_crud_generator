<?php
namespace Devinci\LaravelUtils;

use Illuminate\Support\Facades\File;

class StubsManager
{
    public static function moveStubsToProjectRoot()
    {
        $stubsDirectory = __DIR__ . '/../stubs';
        $destinationDirectory = base_path('stubs');

        // Check if the stubs directory doesn't exist
        if (!File::exists($destinationDirectory)) {
            // Create the stubs directory
            File::makeDirectory($destinationDirectory);
        }

        // Get all files in the stubs directory
        $files = glob($stubsDirectory . '/*.stub');

        foreach ($files as $filePath) {
            $filename = basename($filePath);
            $destinationPath = $destinationDirectory . '/' . $filename;

            // Check if the file doesn't exist in the destination directory
            if (!File::exists($destinationPath)) {
                // Move the file to the destination directory
                File::copy($filePath, $destinationPath);
                echo "Moved $filename to $destinationPath\n";
            } else {
                echo "$filename already exists in $destinationDirectory\n";
            }
        }
    }

    public static function createRepositoryDir()
    {
        $templatePath = base_path('stubs/base_repository.stub');
        $destinationDirectory = app_path('Repositories');
        $destinationPath = $destinationDirectory . '/BaseRepository.php';
        if (!File::isDirectory($destinationDirectory)) {
            // Create the directory recursively
            File::makeDirectory($destinationDirectory, 0755, true, true);
        }
        // Check if the BaseRepositoryController already exists
        if (!File::exists($destinationPath)) {
            // If it doesn't exist, read the template
            $templateContent = File::get($templatePath);

            // Write the template content to the destination file
            File::put($destinationPath, $templateContent);

            echo "BaseRepository has been created\n";
        } else {
            echo "BaseRepository already exists\n";
        }
    }

}