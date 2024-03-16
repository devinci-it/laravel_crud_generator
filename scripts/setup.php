<?php

// Get the path to the vendor directory
$vendorPath = __DIR__ . '/../../../';

// Define the paths to the files to be deleted relative to the vendor directory
$filesToDelete = [
    $vendorPath . 'app/Repositories/BaseRepository.php',
    $vendorPath . 'stubs/base_repository.stub',
    $vendorPath . 'stubs/base_repository_controller.stub',
    $vendorPath . 'stubs/repository.stub',
];

// Delete the files
foreach ($filesToDelete as $file) {
    if (file_exists($file)) {
        unlink($file);
        echo "Deleted: $file\n";
    }
}

// Run the artisan command to set up the repository
$artisanCommand = 'php ' . $vendorPath . 'artisan repository:setup';
echo "Running command: $artisanCommand\n";
system($artisanCommand);
