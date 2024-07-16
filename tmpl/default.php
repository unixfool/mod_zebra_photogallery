<?php defined('_JEXEC') or die; ?>

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
 
$enableFancybox = $params->get('enable_fancybox', 1);

if ($enableFancybox) : ?>
    <script>
    jQuery(document).ready(function($) {
        $(".fancybox").fancybox();
    });
    </script>
<?php endif; ?>

<div class="nav">
    <?php if ($showPagination && $totalPages > 1) : ?>
        <!-- Botones de navegación -->
        <div class="pagination-buttons">
            <?php if ($currentPage > 1) : ?>
                <?php $prevPageUrl = JRoute::_('index.php?option=com_content&view=article&id=' . JFactory::getApplication()->input->getInt('id') . '&page=' . ($currentPage - 1)); ?>
                <a href="<?php echo $prevPageUrl; ?>" class="btn btn-prev">
                    <i class="fas fa-chevron-circle-left"></i> <?php echo JText::_('MOD_ZEBRA_PHOTOGALLERY_PREV_PAGE'); ?>
                </a>
            <?php endif; ?>

            <?php if ($currentPage < $totalPages) : ?>
                <?php $nextPageUrl = JRoute::_('index.php?option=com_content&view=article&id=' . JFactory::getApplication()->input->getInt('id') . '&page=' . ($currentPage + 1)); ?>
                <a href="<?php echo $nextPageUrl; ?>" class="btn btn-next">
                    <?php echo JText::_('MOD_ZEBRA_PHOTOGALLERY_NEXT_PAGE'); ?> <i class="fas fa-chevron-circle-right"></i></i>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<div class="photo-gallery">
    <div class="row">
        <?php if (!empty($images)) : ?>
            <?php foreach ($images as $image) : ?>
                <div class="photo columns-<?php echo (int)$columns; ?>">
                    <a href="<?php echo htmlspecialchars($image['url']); ?>" class="<?php echo $enableFancybox ? 'fancybox' : ''; ?>" data-fancybox="gallery" data-caption="<?php echo htmlspecialchars($image['alt']); ?>">
                        <img src="<?php echo htmlspecialchars($image['url']); ?>" alt="<?php echo htmlspecialchars($image['alt']); ?>">
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p><?php echo JText::_('MOD_ZEBRA_PHOTOGALLERY_NO_IMAGES'); ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="nav">
    <?php if ($showPagination && $totalPages > 1) : ?>
        <!-- Paginación condensada al final de la galería -->
        <nav aria-label="<?php echo JText::_('MOD_PHOTO_GALLERY_PAGE_NAVIGATION'); ?>">
            <ul class="pagination">
                <?php
                // Define el rango de páginas a mostrar
                $range = 2; // Número de páginas alrededor de la página actual
                $start = max(1, $currentPage - $range);
                $end = min($totalPages, $currentPage + $range);

                // Mostrar el primer enlace de página siempre
                if ($start > 1) {
                    $paginationUrl = JRoute::_('index.php?option=com_content&view=article&id=' . JFactory::getApplication()->input->getInt('id') . '&page=1');
                    echo '<li class="page-item"><a href="' . $paginationUrl . '" class="page-link">1</a></li>';
                    if ($start > 2) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                }

                // Mostrar el rango de páginas
                for ($i = $start; $i <= $end; $i++) {
                    $paginationUrl = JRoute::_('index.php?option=com_content&view=article&id=' . JFactory::getApplication()->input->getInt('id') . '&page=' . $i);
                    echo '<li class="page-item' . ($i == $currentPage ? ' active' : '') . '"><a href="' . $paginationUrl . '" class="page-link">' . $i . '</a></li>';
                }

                // Mostrar el último enlace de página siempre
                if ($end < $totalPages) {
                    if ($end < $totalPages - 1) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                    $paginationUrl = JRoute::_('index.php?option=com_content&view=article&id=' . JFactory::getApplication()->input->getInt('id') . '&page=' . $totalPages);
                    echo '<li class="page-item"><a href="' . $paginationUrl . '" class="page-link">' . $totalPages . '</a></li>';
                }
                ?>
            </ul>
        </nav>
    <?php endif; ?>
	
</div>

<div style="text-align:right;font-size:12px;display:block;padding:5px;position:relative;">
	<p><a href="https://desarrollaria.com/herramientas" target="_blank"><?php echo JText::_('MOD_ZEBRA_PHOTOGALLERY_COPYRIGHT'); ?></a></p>
</div>