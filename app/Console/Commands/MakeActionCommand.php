<?php

namespace App\Console\Commands;

use Faker\Core\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class MakeActionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:action {pathFile} {name}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name=$this->argument('name');
        $pathFile=$this->argument('pathFile');
        $className=ucfirst($name);
        $path=app_path('Actions/'.$pathFile.'/'.$className.'.php');
       if (file_exists($path))
       {
           $this->error('File already exists!');
       }
       $stub=<<<EOT
<?php
namespace App\Actions\\$pathFile;
use App\Actions\BaseAction;
use Illuminate\Http\Resources\Json\JsonResource;
class {$className} extends BaseAction
{
protected function  validate(array \$data) {

}
protected function execute(array \$data){
}
protected function resource(\$result):JsonResource{
 return new  JsonResource(\$result);
 }
}
EOT;
       \Illuminate\Support\Facades\File::put($path, $stub);
       $this->info("action $className has been created successfully");
    }
}
