<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage Category
* @author RickG, jseros
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: edit.php 3466 2011-06-08 22:37:28Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

$editor = JFactory::getEditor();

$mainframe = JFactory::getApplication();

?>

<div class="col50">
	<table class="adminform">
		<tr>
			<td class="key" style="width: 150px;">
				<label for="published">
					<?php echo JText::_('COM_VIRTUEMART_PUBLISHED'); ?>
				</label>
			</td>
			<td>
				<fieldset class="radio">
				<?php echo JHTML::_('select.booleanlist', 'published', $this->category->published, $this->category->published);?>
				</fieldset>
			</td>
		</tr>
		<!-- Commented out for future use
		<tr>
			<td class="key">
				<label for="shared">
					<?php echo JText::_('COM_VIRTUEMART_CATEGORY_FORM_SHARED'); ?>:
				</label>
			</td>
			<td>
				<?php
					$categoryShared = isset($this->relationInfo->category_shared) ? $this->relationInfo->category_shared : 1;
					echo JHTML::_('select.booleanlist', 'shared', $categoryShared, $categoryShared);
				?>
			</td>
		</tr>
		-->
		<tr>
			<td class="key">
				<label for="category_name">
					<?php echo JText::_('COM_VIRTUEMART_CATEGORY_NAME'); ?>
				</label>
			</td>
			<td>
				<input type="text" name="category_name" id="category_name" size="60" value="<?php echo $this->category->category_name; ?>" class="inputbox" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="slug">
					<?php echo JText::_('COM_VIRTUEMART_SLUG'); ?>
				</label>
			</td>
			<td>
				<input type="text" name="slug" id="slug" size="60" value="<?php echo $this->category->slug; ?>" class="inputbox" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="category_description">
					<?php echo JText::_('COM_VIRTUEMART_DESCRIPTION'); ?>
				</label>
			</td>
			<td>
				<?php echo $editor->display('category_description', $this->category->category_description, '100%', '300', '50', '8', array('pagebreak', 'readmore'));?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table style="width: 100%">
					<tr>
						<td valign="top" style="width: 50%;">
							<fieldset>
								<legend><?php echo JText::_('COM_VIRTUEMART_DETAILS'); ?></legend>
								<table>
									<tr>
										<td class="key">
											<label for="ordering">
												<?php echo JText::_('COM_VIRTUEMART_ORDERING') ?>
											</label>
										</td>
										<td>
											<?php echo ShopFunctions::getEnumeratedCategories(true, true, $this->parent->virtuemart_category_id, 'ordering', '', 'ordering', 'category_name', $this->category->ordering); ?>
										</td>
									</tr>
									<tr>
										<td class="key">
											<label for="category_parent_id">
												<?php echo JText::_('COM_VIRTUEMART_CATEGORY_FORM_PARENT'); ?>
											</label>
										</td>
										<td>
											<select name="category_parent_id" id="category_parent_id" class="inputbox">
												<option value=""><?php echo JText::_('COM_VIRTUEMART_CATEGORY_FORM_TOP_LEVEL'); ?></option>
												<?php echo $this->categorylist;?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="key">
											<label for="products_per_row">
												<?php echo JText::_('COM_VIRTUEMART_CATEGORY_FORM_PRODUCTS_PER_ROW'); ?>
											</label>
										</td>
										<td>
											<input type="text" name="products_per_row" id="products_per_row" size="5" value="<?php echo $this->category->products_per_row; ?>" class="inputbox" />
										</td>
									</tr>

									<tr>
										<td class="key">
											<label for="limit_list_start">
												<?php echo JText::_('COM_VIRTUEMART_CATEGORY_FORM_LIMIT_LIST_START'); ?>
											</label>
										</td>
										<td>
											<input type="text" name="limit_list_start" id="limit_list_start" size="5" value="<?php echo $this->category->limit_list_start; ?>" class="inputbox" />
										</td>
									</tr>
									<tr>
										<td class="key">
											<label for="limit_list_step">
												<?php echo JText::_('COM_VIRTUEMART_CATEGORY_FORM_LIMIT_LIST_STEP'); ?>
											</label>
										</td>
										<td>
											<input type="text" name="limit_list_step" id="limit_list_step" size="5" value="<?php echo $this->category->limit_list_step; ?>" class="inputbox" />
										</td>
									</tr>
									<tr>
										<td class="key">
											<label for="limit_list_max">
												<?php echo JText::_('COM_VIRTUEMART_CATEGORY_FORM_LIMIT_LIST_MAX'); ?>
											</label>
										</td>
										<td>
											<input type="text" name="limit_list_max" id="limit_list_max" size="5" value="<?php echo $this->category->limit_list_max; ?>" class="inputbox" />
										</td>
									</tr>
									<tr>
										<td class="key">
											<label for="limit_list_initial">
												<?php echo JText::_('COM_VIRTUEMART_CATEGORY_FORM_INITIAL_DISPLAY_RECORDS'); ?>
											</label>
										</td>
										<td>
											<input type="text" name="limit_list_initial" id="limit_list_initial" size="5" value="<?php echo $this->category->limit_list_initial; ?>" class="inputbox" />
										</td>
									</tr>
									<tr>
										<td class="key">
											<label for="category_browsepage">
												<?php echo JText::_('COM_VIRTUEMART_CATEGORY_FORM_TEMPLATE'); ?>
											</label>
										</td>
										<td>
											<?php echo JHTML::_('Select.genericlist', $this->jTemplateList, 'category_template', 'size=1', 'directory', 'name', $this->category->category_template); ?>
										</td>
									</tr>
									<tr>
										<td class="key">
											<label for="category_browsepage">
												<?php echo JText::_('COM_VIRTUEMART_CATEGORY_FORM_BROWSE_LAYOUT'); ?>
											</label>
										</td>
										<td>
											<?php echo JHTML::_('Select.genericlist', $this->categoryLayouts, 'category_layout', 'size=1', 'text', 'text', $this->category->category_layout); ?>
										</td>
									</tr>
									<tr>
										<td class="key">
											<label for="category_flypage">
												<?php echo JText::_('COM_VIRTUEMART_CATEGORY_FORM_FLYPAGE'); ?>
											</label>
										</td>
										<td>
											<?php echo JHTML::_('Select.genericlist', $this->productLayouts, 'category_product_layout', 'size=1', 'text', 'text', $this->category->category_product_layout); ?>
										</td>
									</tr>
								</table>
							</fieldset>
						</td>
						<td valign="top">
							<fieldset>
								<legend><?php echo JText::_('COM_VIRTUEMART_META_INFORMATION'); ?></legend>
								<table>
									<tr>
										<td class="key">
											<label for="metadesc">
												<?php echo JText::_('COM_VIRTUEMART_META_DESC'); ?>
											</label>
										</td>
										<td>
											<textarea class="inputbox" name="metadesc" id="metadesc" cols="35" rows="5"><?php echo $this->category->metadesc; ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="key">
											<label for="metakey">
												<?php echo JText::_('COM_VIRTUEMART_META_KEYWORDS'); ?>
											</label>
										</td>
										<td>
											<textarea class="inputbox" name="metakey" id="metakey" cols="35" rows="5"><?php echo $this->category->metakey; ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="key">
											<label for="metarobot">
												<?php echo JText::_('COM_VIRTUEMART_META_ROBOTS'); ?>
											</label>
										</td>
										<td>
											<input type="text" name="metarobot" id="metarobot" size="25" value="<?php echo $this->category->metarobot; ?>" class="inputbox" />
										</td>
									</tr>
									<tr>
										<td class="key">
											<label for="metaauthor">
												<?php echo JText::_('COM_VIRTUEMART_METAAUTHOR'); ?>
											</label>
										</td>
										<td>
											<input type="text" name="metaauthor" id="metaauthor" size="25" value="<?php echo $this->category->metaauthor; ?>" class="inputbox" />
										</td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>