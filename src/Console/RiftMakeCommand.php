<?php

namespace Singlephon\Rift\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Features\SupportConsoleCommands\Commands\ComponentParser;
use Livewire\Features\SupportConsoleCommands\Commands\MakeCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use function Livewire\str;

#[AsCommand(name: 'rift:make')]
class RiftMakeCommand extends MakeCommand
{
    protected $signature = 'rift:make {name} {--force}';

    protected string $baseJsPath;
    protected $directories;
    protected $component;
    protected $componentClass;


    public function handle()
    {
        $this->parser = new ComponentParser(
            "App\\Livewire\\Rift",
            resource_path('views/rift'),
            $this->argument('name'),
        );

        $this->baseJsPath = resource_path('js/rift/');
        $directories = preg_split('/[.\/(\\\\)]+/', $this->argument('name'));
        $camelCase = str(array_pop($directories))->camel();
        $kebabCase = str($camelCase)->kebab();
        $this->component = $kebabCase;
        $this->componentClass = str($this->component)->studly();

        $this->directories = array_map([Str::class, 'studly'], $directories);

        if (!$this->isClassNameValid($name = $this->parser->className())) {
            $this->line("<options=bold,reverse;fg=red> WHOOPS! </> 😳 \n");
            $this->line("<fg=red;options=bold>Class is invalid:</> {$name}");

            return;
        }

        if ($this->isReservedClassName($name)) {
            $this->line("<options=bold,reverse;fg=red> WHOOPS! </> 😳 \n");
            $this->line("<fg=red;options=bold>Class is reserved:</> {$name}");

            return;
        }

        $force = $this->option('force');

        $showWelcomeMessage = $this->isFirstTimeMakingAComponent();

        $class = $this->createClass($force);
        $view = $this->createView($force);
        $js = $this->createJs($force);


        if($class || $view) {
            $this->line("<options=bold,reverse;fg=green> COMPONENT CREATED </> 🤙\n");
            $class && $this->line("<options=bold;fg=green>CLASS:</> {$this->parser->relativeClassPath()}");
            $view && $this->line("<options=bold;fg=green>VIEW:</>  {$this->parser->relativeViewPath()}");
            $js && $this->line("<options=bold;fg=green>JS:</>  {$this->relativeJsPath()}");

            if ($showWelcomeMessage && ! app()->runningUnitTests()) {
                $this->writeWelcomeMessage();
            }
        }
    }

    protected function createClass($force = false, $inline = false)
    {
        $classPath = $this->parser->classPath();

        if (File::exists($classPath) && ! $force) {
            $this->line("<options=bold,reverse;fg=red> WHOOPS-IE-TOOTLES </> 😳 \n");
            $this->line("<fg=red;options=bold>Class already exists:</> {$this->parser->relativeClassPath()}");

            return false;
        }

        $this->ensureDirectoryExists($classPath);

        File::put($classPath, $this->classContents());

        return $classPath;
    }

    public function classContents()
    {
        $stubName = 'rift.stub';

        if (File::exists($stubPath = __DIR__ . '/../../stubs/' .$stubName)) {
            $template = file_get_contents($stubPath);
        } else {
            $template = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.$stubName);
        }

        return preg_replace(
            ['/\[namespace\]/', '/\[class\]/', '/\[view\]/'],
            [$this->parser->classNamespace(), $this->parser->className(), $this->parser->viewName()],
            $template
        );
    }

    protected function createJs($force = false, $inline = false): string
    {
        if ($inline) {
            return false;
        }
        $jsPath = $this->jsPath();

        if (File::exists($jsPath) && ! $force) {
            $this->line("<fg=red;options=bold>View already exists:</> {$this->relativeJsPath()}");

            return false;
        }

        $this->ensureDirectoryExists($jsPath);

        File::put($jsPath, $this->jsContents());

        return $jsPath;
    }

    protected function jsPath()
    {
        return $this->baseJsPath . collect()
                ->concat($this->directories)
                ->map([Str::class, 'kebab'])
                ->push($this->jsFile())
                ->implode(DIRECTORY_SEPARATOR);
    }

    public function jsFile()
    {
        return $this->component.'.js';
    }

    public function relativeJsPath() : string
    {
        return str($this->jsPath())->replaceFirst(base_path().'/', '');
    }

    public function jsContents()
    {
        $stubPath = __DIR__ . '/../../stubs/rift.js.stub';

        return preg_replace(
            '/\[class\]/',
            $this->componentClass,
            file_get_contents($stubPath)
        );
    }

    protected function createView($force = false, $inline = false)
    {
        if ($inline) {
            return false;
        }
        $viewPath = $this->parser->viewPath();

        if (File::exists($viewPath) && ! $force) {
            $this->line("<fg=red;options=bold>View already exists:</> {$this->parser->relativeViewPath()}");

            return false;
        }

        $this->ensureDirectoryExists($viewPath);

        File::put($viewPath, $this->viewContents());

        return $viewPath;
    }

    public function viewContents()
    {

        if( ! File::exists($stubPath = __DIR__ . '/../../stubs/rift.view.stub')) {
            $stubPath = __DIR__.DIRECTORY_SEPARATOR.'rift.view.stub';
        }

        return preg_replace(
            ['/\[quote\]/', '/\[path\]/'],
            [$this->parser->wisdomOfTheTao(), $this->clearPath()],
            file_get_contents($stubPath)
        );
    }

    public function clearPath(): string
    {
        return collect($this->directories)
                ->map([Str::class, 'kebab'])
                ->push($this->component)
                ->implode('.');
    }
}
