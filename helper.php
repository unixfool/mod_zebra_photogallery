<?php



/**
 * This file is part of the Zebra Photo gallery module.
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

class ModPhotoGalleryHelper {
    public static function getImages($repoUrl, $imagesPerPage, $currentPage, $imageALT) {
        $cache = JFactory::getCache('mod_zebra_photogallery', 'output');
        $cacheKey = md5($repoUrl);

        // Intentar obtener las imágenes del caché
        $cachedImages = $cache->get($cacheKey);

        if ($cachedImages !== false) {
            $images = $cachedImages;
        } else {
            $repoUrl = rtrim($repoUrl, '/');
            $images = [];
            
            // Obtener la lista de archivos en la URL del servidor local
            $dir = JPATH_SITE . str_replace(JURI::base(), '', $repoUrl);
            
            if (is_dir($dir)) {
                $files = scandir($dir);

                foreach ($files as $file) {
                    if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file)) {
                        $images[] = [
                            'url' => JURI::root() . str_replace(JPATH_SITE, '', $dir) . '/' . $file,
                            'alt' => $imageALT . ' ' . basename($file)
                        ];
                    }
                }
                
                // Almacenar las imágenes en el caché
                $cache->store($images, $cacheKey);
            } else {
                JLog::add('No se encontró el directorio: ' . $dir, JLog::ERROR, 'mod_zebra_photogallery');
            }
        }

        // Implementar la lógica de paginación
        $totalImages = count($images);
        $totalPages = ceil($totalImages / $imagesPerPage);
        $offset = ($currentPage - 1) * $imagesPerPage;
        $images = array_slice($images, $offset, $imagesPerPage);

        return [
            'images' => $images,
            'total_pages' => $totalPages,
            'current_page' => $currentPage
        ];
    }
}
