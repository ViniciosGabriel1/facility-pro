<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

use Illuminate\Console\Command;

class MakeCrudApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud-api {name}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria Controller, Service, Requests e rotas para API';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $model          = $name;                         // Clinica
        $modelPlural    = Str::pluralStudly($model);     // Clinicas
        $controller     = "{$modelPlural}Controller";    // ClinicasController
        $service        = "{$modelPlural}Service";       // ClinicasService
        $route          = Str::kebab($modelPlural);      // clinicas

        $this->info("Criando CRUD API para {$model}...");

        $this->createController($model, $modelPlural, $controller);
        $this->createService($model);
        $this->createRequests($model);
        $this->registerRoute($route, $controller);

        $this->info('CRUD API criado com sucesso.');
    }

    private function createController(string $model, string $modelPlural, string $controller): void
{
    $stub = file_get_contents(base_path('stubs/controller.api.stub'));

    $content = str_replace(
        ['{{ model }}', '{{ modelPlural }}'],
        [$model, $modelPlural],
        $stub
    );

    $path = app_path("Http/Controllers/{$controller}.php");

    file_put_contents($path, $content);

    $this->info("Controller criado: {$controller}");
}

private function createService(string $model): void
{
    $stub = file_get_contents(base_path('stubs/service.stub'));

    $content = str_replace(
        '{{ model }}',
        $model,
        $stub
    );

    $path = app_path("Services/{$model}Service.php");

    file_put_contents($path, $content);

    $this->info("Service criado: {$model}Service");
}

private function createRequests(string $model): void
{
    $criarStub = file_get_contents(base_path('stubs/request.criar.stub'));
    $atualizarStub = file_get_contents(base_path('stubs/request.atualizar.stub'));

    $criarContent = str_replace('{{ model }}', $model, $criarStub);
    $atualizarContent = str_replace('{{ model }}', $model, $atualizarStub);

    file_put_contents(
        app_path("Http/Requests/Criar{$model}Request.php"),
        $criarContent
    );

    file_put_contents(
        app_path("Http/Requests/Atualizar{$model}Request.php"),
        $atualizarContent
    );

    $this->info("Requests criados para {$model}");
}


private function registerRoute(string $route, string $controller): void
{
    $routeDefinition = PHP_EOL .
        "Route::apiResource('{$route}', \\App\\Http\\Controllers\\{$controller}::class);" .
        PHP_EOL;

    file_put_contents(
        base_path('routes/api.php'),
        $routeDefinition,
        FILE_APPEND
    );

    $this->info("Rota registrada: /{$route}");
}

}
