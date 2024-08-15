<?php

namespace Nfaiz\SqlHighlighter\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SqlHighlighter extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Third Party';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'hl:setup';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Setup sql highlighter. This will modify CI4 system files.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'hl:setup';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $this->modifyToolbarConfig();
        $this->modifyDebugToolbar();
        $this->modifyToolbarJs();
        $this->modifyDatabaseTpl();
    }

    protected function modifyToolbarConfig()
    {
        $filename = 'Toolbar.php';
        $content = file_get_contents($this->getAppConfiGPath($filename));

        $content = str_replace(
            'public int $maxQueries = 100;', 
            'public int $maxQueries = 100;'
             . PHP_EOL . PHP_EOL
             . '    /**' . PHP_EOL
             . '     * --------------------------------------------------------------------------' . PHP_EOL
             . '     * SQL Highlighter Assets'. PHP_EOL
             . '     * --------------------------------------------------------------------------' . PHP_EOL
             . '     *' . PHP_EOL
             . '     * This is where the highlightjs assets are located.' . PHP_EOL
             . '     *' . PHP_EOL
             . '     * @var array<string, string>' . PHP_EOL
             . '     */' . PHP_EOL . PHP_EOL
             . '    public array $sqlHighlighterAssets = [' . PHP_EOL
             . "        'js' => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/highlight.min.js'," . PHP_EOL
             . "        'css_light' => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/styles/atom-one-light.min.css'," . PHP_EOL
             . "        'css_dark' => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/styles/atom-one-dark.min.css'," . PHP_EOL
             . "    ];",
            $content
        );

        $this->writeConfigFile($this->getAppConfiGPath($filename), $content);
    }

    protected function modifyDebugToolbar()
    {
        $filename = 'Toolbar.php';
        $content = file_get_contents($this->getDebugToolbarPath($filename));

        $text = '            $script .= ' . "'" . '<script src="' . "' . config(ToolbarConfig::class)->sqlHighlighterAssets['js'] . '" . '"' . "></script>'. PHP_EOL;";

        $content = str_replace(
            '. PHP_EOL;', 
            '. PHP_EOL;'
             . PHP_EOL . PHP_EOL
             . $text,
            $content
        );

        $this->writeConfigFile($this->getDebugToolbarPath($filename), $content);
    }

    protected function modifyToolbarJs()
    {
        $filename = 'Toolbar' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'toolbar.js';
        $content = file_get_contents($this->getDebugToolbarPath($filename));

        $text = '
        hljs.configure({
            ignoreUnescapedHTML: true,
            languages: ["sql", "pgsql"]
        });

        document.querySelectorAll(".sqlhighlighter").forEach((el) => {
            hljs.highlightElement(el);
        });';

        $content = str_replace(
            'this.icon = document.getElementById("debug-icon");', 
            'this.icon = document.getElementById("debug-icon");'
             . PHP_EOL
             . $text,
            $content
        );

        $this->writeConfigFile($this->getDebugToolbarPath($filename), $content);
    }

    protected function modifyDatabaseTpl()
    {
        $filename = 'Toolbar' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . '_database.tpl';
        $content = file_get_contents($this->getDebugToolbarPath($filename));

        $content = str_replace(
            '{! sql !}', 
            '<pre><code class="sqlhighlighter">{! sql !}</code></pre>',
            $content
        );

        $this->writeConfigFile($this->getDebugToolbarPath($filename), $content);
    }

    protected function getDebugToolbarPath($filename)
    {
        return SYSTEMPATH . DIRECTORY_SEPARATOR . 'Debug' . DIRECTORY_SEPARATOR . $filename;
    }

    protected function getAppConfiGPath($filename)
    {
        return APPPATH . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . $filename;
    }

    protected function writeConfigFile(string $filename, string $content)
    {
        $file = $filename; 
        
        $directory = dirname($file);

        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        if (file_exists($file)) {
            $overwrite = (bool) CLI::getOption('f');
            if (! $overwrite && CLI::prompt("Overwrite File '{$filename}' ?", ['n', 'y']) === 'n') {
                CLI::error("Skipped {$filename}.");
                return;
            }
        }

        if (write_file($file, $content)) {
            CLI::write(CLI::color('Overwrite: ', 'green') . $filename);
        } else {
            CLI::error("Error creating {$filename}.");
        }
    }
}