# LaraGenRepo
This package use for >= laravel 5 to generate repository for a database model.

# Installation:
1- cd into vendor folder.

2- use the next command in the terminal to install the package: 

      $ git clone https://github.com/Meklad/LaraGenRepo.git
      
3- type in the terminal:

      $ composer dumpauotload
 
Or Type:

      $ composer dumpautoload -o

# Usage:
1- To create new repository for a database model type in the terminal:

      $ php artisan make:repository <Repository Name> <Model Name>

2- To find the path to repository dirctory cd app/Repository
