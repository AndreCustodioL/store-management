<?php

namespace App\Controller\Admin;

use \App\Utils\View;

class Page{
    
    /**
     * Módulos disponíveis no painel
     *
     * @var array
     */
    private static $modules = [
        'home' => [
            'label' => 'Home',
            'icon' => 'bi-house',
            'link' => URL.'/admin'
        ],
        'testimonies' => [
            'label' => 'Depoimentos',
            'icon' => 'bi-chat-right-quote',
            'link' => URL.'/admin/testimonies'
        ],
        'users' => [
            'label' => 'Usuários',
            'icon' => 'bi-person',
            'link' => URL.'/admin/users',
        ],
        'products' => [
            'label' => 'Produtos',
            'icon' => 'bi-box-seam',
            'link' => URL.'/admin/products',
            'submenu' => [
                'products' => [
                    'label' => 'Produtos',
                    'link' => URL.'/admin/products'
                ],
                'groups' => [
                    'label' => 'Grupos',
                    'link' => URL.'/admin/products/groups'
                ],
                'units' => [
                    'label' => 'Unidades de medida',
                    'link' => URL.'/admin/products/units'
                ]
            ]
        ]
    ];
    
    /**
     * Método responsável por retornar o conteúdo (view) da estrutura genérica de página do painel
     *
     * @param  string $title
     * @param  string $content
     * @return string
     */
    public static function getPage($title,$content){
        return View::render('admin/page',[
            'title' => $title,
            'content' => $content
        ]);
    }

    private static function getSubMenu($modules){
        $links = '';
        foreach($modules as $hash=>$module){
            $links .= View::render('admin/menu/submenu/link-sub',[
            'label' => $module['label'],
            'link' => $module['link']
        ]);
        }
        return $links;
    }
    
    /**
     * Método responsável por renderizar a view do menu do painel
     *
     * @param  string $currentModule
     * @return string
     */
    private static function getMenu($currentModule){

        //LINKS DO MENU
        $links = '';

        //ITERA OS MÓDULOS
        foreach (self::$modules as $hash => $module) {
            $links .= self::renderModuleLink($module, $hash == $currentModule,$hash);
        }

        //RETORNA A RENDERIZAÇÃO DO MENU
        return View::render('admin/menu/box',[
            'links' => $links
        ]);
    }
    
    /**
     * Método responsável por renderizar os links dinâmicos do menu (seja ele menu ou submenu)
     *
     * @param  string $module
     * @param  string $isCurrent
     * @return string
     */
    private static function renderModuleLink($module, $isCurrent,$hash) {
        $viewData = [
            'label' => $module['label'],
            'hash' => $hash,
            'icon' => $module['icon'],
            'current' => $isCurrent ? 'current' : ''
        ];
        
        if (isset($module['submenu'])) {
            $viewData['submenu'] = self::getSubMenu($module['submenu']);
            return View::render('admin/menu/submenu/link', $viewData);
        }
        
        $viewData['link'] = $module['link'];
        return View::render('admin/menu/link', $viewData);
    }
    
    /**
     * Método responsável por renderizar a view do painel com conteúdos dinâmicos
     *
     * @param  string $title
     * @param  string $content
     * @param  string $currentModule
     * @return string
     */
    public static function getPanel($title,$content,$currentModule) {

        //RENDERIZA A VIEW DO PAINEL
        $contentPanel = View::render('admin/panel',[
            'menu' => self::getMenu($currentModule),
            'content' => $content
        ]);

        //RETORNA A PAGINA RENDERIZADA
        return self::getPage($title,$contentPanel);
    }

    /**
     * Método responsável por renderizar o layout de paginação
     *
     * @param  Request $request
     * @param  Pagination $obPagination
     * @return string
     */
    public static function getPagination($request,$obPagination) {
        //PÁGINAS
        $pages = $obPagination->getPages();

        //VERIFICA A QUANTIDADE DE PÁGINAS
        if(count($pages) <= 1) return '';

        //LINKS
        $links = '';

        //URL ATUAL (SEM GETS)
        $url = $request->getRouter()->getCurrentUrl();

        //GET
        $queryParams = $request->getQueryParams();

        //RENDERIZA OS LINKS
        foreach($pages as $page) {
            //ALTERA A PAGINA
            $queryParams['page'] = $page['page'];

            //LINK
            $link = $url.'?'.http_build_query($queryParams);

            //VIEW
            $links .=  View::render('admin/pagination/link', [
                'page' => $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
        }

        //RENDERIZA BOX DE PAGINAÇÃO
        return View::render('admin/pagination/box', [
            'links' => $links
        ]);
    }
}