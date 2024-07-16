<?php
/**
 * This file is part of the Zebra Photogallery module.
 *
 * @license GPL-3.0-or-later
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */
 
 
defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

$template = $params->get('template', 'style'); // Valor por defecto
$document = \Joomla\CMS\Factory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_zebra_photogallery/media/css/' . $template . '.css');

$repoUrl = $params->get('repo_url');
$columns = $params->get('columns', 4); // Valor predeterminado de 4 columnas
$imagesPerPage = $params->get('images_per_page', 10); // Valor predeterminado de 10 imágenes por página
$currentPage = \Joomla\CMS\Factory::getApplication()->input->getInt('page', 1);
$imageALT = $params->get('images_alt');
$cacheLifetime = $params->get('cache_lifetime', 3600); // Valor predeterminado de 3600 segundos (1 hora)
$showPagination = $params->get('show_pagination', 1); // Valor predeterminado de mostrar paginación
$enableFancybox = $params->get('enable_fancybox', 1); // Valor predeterminado de habilitar Fancybox

// Configurar el tiempo de vida del caché
$cache = \Joomla\CMS\Factory::getCache('mod_zebra_photogallery', 'output');

$cache->setLifeTime($cacheLifetime);

$data = ModPhotoGalleryHelper::getImages($repoUrl, $imagesPerPage, $currentPage, $imageALT);

// No se encontraron imágenes
if (empty($data['images'])) {
    \Joomla\CMS\Log\Log::add(\Joomla\CMS\Language\Text::_('MOD_ZEBRA_PHOTOGALLERY_NO_IMAGES'), \Joomla\CMS\Log\Log::ERROR, 'mod_zebra_photogallery');
}

// Imágenes por páginas
$images = $data['images'];
$totalPages = $data['total_pages'];
$currentPage = $data['current_page'];

// Incluir Fancybox si está habilitado
if ($enableFancybox) {
    $document->addStyleSheet('https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css');
    $document->addScript('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js');
    $document->addScript('https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js');
}

require \Joomla\CMS\Helper\ModuleHelper::getLayoutPath('mod_zebra_photogallery');

?>
