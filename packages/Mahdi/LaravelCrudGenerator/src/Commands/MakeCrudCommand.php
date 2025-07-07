<?php

namespace Mahdi\LaravelCrudGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeCrudCommand extends Command
{
    protected $signature = 'make:crud {name}';
    protected $description = 'Generate CRUD Controller, Requests, DataTable, and CommonService';

    protected $files;
    protected $model;
    protected $controller;
    protected $requestPath = 'App\\Http\\Requests';

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $this->model = $name;
        $this->controller = "{$name}Controller";

        $this->makeRequest('Store');
        $this->makeRequest('Update');
        $this->makeController();
        $this->makeCommonService();
        $this->makeDataTable();

        $this->info("✅ CRUD for {$name} generated.");
    }

    protected function makeRequest($type)
    {
        $className = "{$type}{$this->model}Request";
        $path = app_path("Http/Requests/{$className}.php");
        if (!$this->files->exists($path)) {
            $this->files->ensureDirectoryExists(app_path('Http/Requests'));
            $this->files->put($path, "<?php\n\nnamespace {$this->requestPath};\n\nuse Illuminate\\Foundation\\Http\\FormRequest;\n\nclass {$className} extends FormRequest\n{\n    public function authorize() { return true; }\n    public function rules(): array { return ['name' => 'required|string|max:255']; }\n}");
        }
    }

    protected function makeController()
    {
        $stub = file_get_contents(__DIR__ . '/../stubs/Controller.stub');
        $stub = str_replace(['{{ model }}', '{{ route }}'], [$this->model, Str::kebab(Str::plural($this->model))], $stub);

        $path = app_path("Http/Controllers/{$this->controller}.php");
        if (!$this->files->exists($path)) {
            $this->files->put($path, $stub);
        }
    }

    protected function makeCommonService()
    {
        $path = app_path('Services/CommonService.php');
        if (!$this->files->exists($path)) {
            $this->files->ensureDirectoryExists(app_path('Services'));
            $this->files->copy(__DIR__ . '/../stubs/CommonService.stub', $path);
        }
    }

    protected function makeDataTable()
    {
        $plural = Str::pluralStudly($this->model);
        $model = "App\\Models\\{$this->model}";

        $stub = file_get_contents(__DIR__ . '/../stubs/DataTable.stub');
        $stub = str_replace(
            ['{{ model }}', '{{ modelPlural }}', '{{ modelSnake }}', '{{ route }}'],
            [$this->model, $plural, Str::snake($this->model), Str::kebab($plural)],
            $stub
        );

        $path = app_path("DataTables/{$plural}DataTable.php");
        if (!$this->files->exists($path)) {
            $this->files->ensureDirectoryExists(app_path('DataTables'));
            $this->files->put($path, $stub);
        }
    }


}
