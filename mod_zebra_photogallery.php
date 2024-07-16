<?php
defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

$template = $params->get('template', 'style'); // Valor por defecto
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_zebra_photogallery/media/css/' . $template . '.css');

$repoUrl = $params->get('repo_url');
$columns = $params->get('columns', 4); // Valor predeterminado de 4 columnas
$imagesPerPage = $params->get('images_per_page', 10); // Valor predeterminado de 10 imágenes por página
$currentPage = JFactory::getApplication()->input->getInt('page', 1);
$imageALT = $params->get('images_alt');
$cacheLifetime = $params->get('cache_lifetime', 3600); // Valor predeterminado de 3600 segundos (1 hora)
$showPagination = $params->get('show_pagination', 1); // Valor predeterminado de mostrar paginación
$enableFancybox = $params->get('enable_fancybox', 1); // Valor predeterminado de habilitar Fancybox

// Configurar el tiempo de vida del caché
$cache = JFactory::getCache('mod_zebra_photogallery', 'output');
$cache->setLifeTime($cacheLifetime);

$data = ModPhotoGalleryHelper::getImages($repoUrl, $imagesPerPage, $currentPage, $imageALT);

// No se encontraron imágenes
if (empty($data['images'])) {
    JLog::add(JText::_('MOD_ZEBRA_PHOTOGALLERY_NO_IMAGES'), JLog::ERROR, 'mod_zebra_photogallery');
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

require JModuleHelper::getLayoutPath('mod_zebra_photogallery');
?>
