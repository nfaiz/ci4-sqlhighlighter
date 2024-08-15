<?php

/**
 * This file is not part of the CodeIgniter 4 framework.
 */

namespace Nfaiz\SqlHighlighter\Collectors;

use CodeIgniter\Debug\Toolbar\Collectors\BaseCollector;
use CodeIgniter\Database\Query;
use Config\Toolbar as ToolbarConfig;

/**
 * Collector for the Database tab of the Debug Toolbar.
 */
class SqlHighlighter extends BaseCollector
{
    /**
     * Whether this collector has timeline data.
     *
     * @var boolean
     */
    protected $hasTimeline = false;

    /**
     * Whether this collector should display its own tab.
     *
     * @var boolean
     */
    protected $hasTabContent = true;

    /**
     * Whether this collector has data for the Vars tab.
     *
     * @var boolean
     */
    protected $hasVarData = false;

    /**
     * The name used to reference this collector in the toolbar.
     *
     * @var string
     */
    protected $title = 'SQL Highlighter';

    /**
     * Returns timeline data formatted for the toolbar.
     *
     * @return array The formatted data or an empty array.
     */
    protected function formatTimelineData(): array
    {
         return [];
    }

    /**
     * Returns the data of this collector to be formatted in the toolbar
     *
     * @return mixed
     */
    public function display(): string
    {
        $config = config(ToolbarConfig::class);

        if (! isset($config->sqlHighlighterAssets)) {
            return '';
        }

        $cssDark = file_get_contents($config->sqlHighlighterAssets['css_dark']);
        $cssLight = file_get_contents($config->sqlHighlighterAssets['css_light']);
        $style = $cssLight . str_replace('.hljs', '#toolbarContainer.dark .hljs', $cssDark);

        return <<<STYLE
        <STYLE> 
        {$style}
        </STYLE>
        STYLE
            . 'Var $sqlHighlighterAssets<table>'
            . '<tr><td>css_light</td>'
            . '<td><a href="' . $config->sqlHighlighterAssets['css_light'] . '">' 
            . $config->sqlHighlighterAssets['css_light'] . '</a></td>'
            . '</tr>'
            . '<tr><td>css_light</td>'
            . '<td><a href="' . $config->sqlHighlighterAssets['css_dark'] . '">' 
            . $config->sqlHighlighterAssets['css_dark'] . '</a></td>'
            . '</tr>'
            . '<td>js</td>'
            . '<td><a href="' . $config->sqlHighlighterAssets['js'] . '">' 
            . $config->sqlHighlighterAssets['js'] . '</a></td>'
            . '</tr>'
            . '</table>';   
    }

    /**
     * Gets the "badge" value for the button.
     */
    public function getBadgeValue(): int
    {
        $config = config(ToolbarConfig::class);
        return isset($config->sqlHighlighterAssets) ? count($config->sqlHighlighterAssets) : 0;
    }

    /**
     * Information to be displayed next to the title.
     *
     * @return string The number of queries (in parentheses) or an empty string.
     */
    public function getTitleDetails(): string
    {
        return '' ;
    }

    /**
     * Display the icon.
     *
     * Icon from https://icons8.com - 1em package
     */
    public function icon(): string
    {
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACgklEQVR4nO2ay2oUQRSGP0FBN3FmXCdmFaPxATS6EMnGB9DoC0SD8waarREJqDt1IS69QkhcCMkYTOIzCK7EhRcyDAluEsWMFPwNRTNkqmequytSP9Rius91uqr/U6ca+sdJ4BowAzwD1oHPwFegBfzRaOmaubcm2RnpjlICjgHTwCvgB9D2NIytl8AN+cgNl4A3wE4qgJ/APHAPmAIu6h8+DlSBQxpVXRuVzJR05mXDtrkjX8anN5zVdEmc/AWW9M+d8uTjgGxNA8vykfhbVww94wjwBNiVwSZwGxgkfwxq/TTl28TwEDiY1dCA9RS2gTvAUYpHBZi1pvM7xeb8mN9a8/8c5eO8tY4WFWNXXJXCL2CEcDCimExsV1wUViRsFl5ouKnYGi7CWxI28zM0VBXbpotwO+BEalZ8XZEImscYGuq9JBLyYm+7KNilwgZwgfIx3qGu64pEcNmqe2ZLWjMV4K5FiEu9JGLKgQfW76bKhqH842coVaKYcV8xZU4kgWH2j6misaGXwZgry3aBsXFaNt93KBrH94jPOZEEpqR+rdorvY4WgDlVxBOqZIc7lPHDSn5CsnPS3UjZ3JavTmV834nY7/LrwAvgu8eN1TfgufYptT7iyy4onFB9dgt4CqwCn4Av2t7+1mjpmrn3QbJGZzLja76dNZHI7DmiHpmdyOxeUInMTmR2IrMTmX1vRGYvAPXI7ERm94JKZHYisxOZnZyYfSvjVrfIPXstSzd+ZR80sRsuwpP7oIl92bXrt2idIZrzu5DOEBeydDcH9JlFaE3s1SynuvY5++PUOXtZTexd4BFw2PeXD0U2sdeAM3hEKE1sbyi7iZ0bim5i81/jHwn5KgDx2BeAAAAAAElFTkSuQmCC';
    }
}